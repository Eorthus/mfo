<?php
namespace app\controllers;

use app\models\db\Comments;
use app\models\db\Manufacturers;
use app\models\db\ManufacturerStatuses;
use app\models\db\PharmacyNetworks;
use app\models\db\PharmacyNetworkStatuses;
use app\models\db\StatusTasks;
use app\models\db\Tasks;
use app\models\db\WorkingPharmacies;
use app\models\Department;
use app\models\ExcelHelpLib;
use app\models\GetLevel;
use app\models\Universalization;
use app\models\User;
use Yii;
use yii\base\Controller;
use yii\helpers\ArrayHelper;

/**
 * Задачи (мониторинг)
 *
 * *** не вность методы load(x) в один метод/модель!
 *
 * @package app\controllers
 */
class TableController extends Controller
{
    public $layout = 'crud-table';

    /**
     * Отрисовка первичной страницы
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Активные в работе
     *
     * @return false|string
     */
    public function actionAjaxLoad1()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        /** Выборка из задач по соотв статусу */
        // находим все задачи с нужным статусом
        $manufacturers_ids     = [];
        $pharmacy_networks_ids = [];
        $tasks                 =
            Tasks::find()->where([
                'status_task_id' => [
                    1,
                    2,
                ],
            ])->asArray()->all();

        foreach ($tasks as $task_data) {
            $manufacturers_ids[$task_data['manufacturer_id']]         = $task_data['manufacturer_id'];
            $pharmacy_networks_ids[$task_data['pharmacy_network_id']] = $task_data['pharmacy_network_id'];
        }
        /** Выборка из задач по соотв статусу */

        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        // если роль = 4 или 5 - полная таблица
        if ($user_roles == 4 or $user_roles == 5) {
            $manufacturers = Manufacturers::find()->asArray()
                ->where(['id' => $manufacturers_ids])
                ->groupBy([
                    'marketer_id',
                    'id',
                ])
                ->offset($offset)
                ->limit($limit)
                ->all();

            $pharmacy_networks = PharmacyNetworks::find()
                ->where(['id' => $pharmacy_networks_ids])
                ->groupBy([
                    'manager_id',
                    'id',
                ])
                ->asArray()
                ->orderBy(['manager_id' => SORT_ASC])
                ->all();
        } elseif ($user_roles == 2) {
            /** DEPARTMENT */
            $my_department   = Yii::$app->user->identity->department_1;
            $my_department_2 = Yii::$app->user->identity->department_2;

            $users_im_my_department = Department::getAllInMyDepartment($my_department, $my_department_2);
            /** DEPARTMENT */

            $manufacturers = Manufacturers::find()->asArray()
                ->where(['id' => $manufacturers_ids])
                ->groupBy([
                    'marketer_id',
                    'id',
                ])
                ->offset($offset)
                ->limit($limit)
                ->all();

            $pharmacy_networks = PharmacyNetworks::find()
                ->where(['id' => $pharmacy_networks_ids])
                ->groupBy([
                    'manager_id',
                    'id',
                ])
                ->asArray()
                ->orderBy(['manager_id' => SORT_ASC])
                ->all();
        } elseif ($user_roles == 3) {
            /** DEPARTMENT */
            $my_department   = Yii::$app->user->identity->department_1;
            $my_department_2 = Yii::$app->user->identity->department_2;

            $users_im_my_department = Department::getAllInMyDepartment($my_department, $my_department_2);
            /** DEPARTMENT */

            $manufacturers = Manufacturers::find()->asArray()
                ->where(['id' => $manufacturers_ids])
                //->where(['marketer_id' => $users_im_my_department])
                ->groupBy([
                    'marketer_id',
                    'id',
                ])
                ->offset($offset)
                ->limit($limit)
                ->all();

            $pharmacy_networks = PharmacyNetworks::find()
                ->where(['id' => $pharmacy_networks_ids])
                ->andWhere(['manager_id' => $users_im_my_department])
                ->groupBy([
                    'manager_id',
                    'id',
                ])
                ->asArray()
                ->orderBy(['manager_id' => SORT_ASC])
                ->all();
        } else {
            /** DEPARTMENT */
            $my_department   = Yii::$app->user->identity->department_1;
            $my_department_2 = Yii::$app->user->identity->department_2;

            $users_im_my_department = Department::getAllInMyDepartment($my_department, $my_department_2);
            /** DEPARTMENT */

            $manufacturers = Manufacturers::find()->asArray()
                ->where(['id' => $manufacturers_ids])
                //->where(['marketer_id' => $users_im_my_department])
                ->groupBy([
                    'marketer_id',
                    'id',
                ])
                ->offset($offset)
                ->limit($limit)
                ->all();

            $pharmacy_networks = PharmacyNetworks::find()
                ->where(['id' => $pharmacy_networks_ids])
                ->andWhere(['manager_id' => $users_im_my_department])
                ->groupBy([
                    'manager_id',
                    'id',
                ])
                ->asArray()
                ->orderBy(['manager_id' => SORT_ASC])
                ->all();
        }

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $m_name = User::getNameById($pharmacy_network['manager_id']);

            if (isset($pharmacy_network['type']) && mb_strlen($pharmacy_network['type']) > 1) {
                //$type = '<span class="type-as">' . $pharmacy_network['type'] . '</span><br>'; // todo: слетают суммы
                $type = '';
            } else {
                $type = '';
            }

            $link_color =
                PharmacyNetworkStatuses::find()->where(['id' => $pharmacy_network['pharmacy_network_status_id']])->one()->color;

            $table_header[$key] =
                "<td rowspan='2' data-manager='{$pharmacy_network['manager_id']}'>{$type}<span class='get-as-modal' title='{$pharmacy_network['name']}' data-manid='{$pharmacy_network['id']}' style='color: {$link_color}'>{$pharmacy_network['name']}</span><br><hr data-manager='{$pharmacy_network['manager_id']}'><span title='{$m_name}'>{$m_name}</span><br>{$pharmacy_network['count_points']}</td>";
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        /** Перебор массива производителей */
        foreach ($manufacturers as $key => $manufacturer) {
            $link_color =
                ManufacturerStatuses::find()->where(['id' => $manufacturer['manufacturer_status_id']])->one()->color;

            $results[$key] = "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky' ><a href='#!' class='get-manuf-modal' data-manid='{$manufacturer['id']}' title='{$manufacturer['name']}' style='color: {$link_color}'>{$manufacturer['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-two' data-manager='{$manufacturer['marketer_id']}'>" .
                User::getUserNameById($manufacturer['marketer_id']) .
                "</td>";

            foreach ($pharmacy_networks as $pharmacy_network) {
                $task  =
                    self::getTaskData($manufacturer['id'], $pharmacy_network['id'], [
                        1,
                        2,
                    ]);
                $color = $task['status_task_id'];

                if (!isset($color) && !$color) {
                    $color = '0';
                }

                if (isset($statuses[$task['working_pharmacy_id']])) {
                    $td_title = $statuses[$task['working_pharmacy_id']];
                } else {
                    $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                $bg_color = ExcelHelpLib::color($color);
                if ($color == 1) {
                    $results[$key] .= "<td class='get-task-modal color-{$color}' data-fill-color='{$bg_color}' data-f-color='5d575e' data-tab='1' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$pharmacy_network['manager_id']}' data-pnid='{$pharmacy_network['id']}' title='{$td_title}' data-d_create='{$task['created_at']}' data-d_deadline='{$task['deadline']}'>{$td_title}</td>";
                } else {
                    $results[$key] .= "<td class='color-8' data-fill-color='f5acde' data-f-color='5d575e' data-pnid='{$pharmacy_network['id']}' data-manid='{$manufacturer['id']}' data-tab='1'></td>";
                }
            }

            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * Контракты в АС
     * АС                   – АКТИВНЫЕ
     * Производители        – АКТИВНЫЕ
     *
     * @return false|string
     */
    public function actionAjaxLoad2()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 15;
        }

        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        /** DEPARTMENT */
        $my_department          = Yii::$app->user->identity->department_1;
        $my_department_2        = Yii::$app->user->identity->department_2;
        $users_im_my_department = Department::getAllInMyDepartment($my_department, $my_department_2);

        /** DEPARTMENT */

        $manufacturers = Manufacturers::find()->asArray()
            //->where(['marketer_id' => $users_im_my_department])
            ->where(['manufacturer_status_id' => 1])
            ->groupBy([
                'marketer_id',
                'id',
            ])
            ->offset($offset)
            ->limit($limit)
            ->all();

        $pharmacy_networks = PharmacyNetworks::find()
            //->where(['manager_id' => $users_im_my_department])
            ->where(['pharmacy_network_status_id' => 1])
            ->groupBy([
                'manager_id',
                'id',
            ])
            ->asArray()
            ->orderBy(['manager_id' => SORT_ASC])
            ->all();

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            // определяем цвет заливки АС
            $pn_bg_color = PharmacyNetworkStatuses::find()->where(['id' => $pharmacy_network['pharmacy_network_status_id']])->one()->color;

            $m_name = User::getNameById($pharmacy_network['manager_id']);

            $uni_pharm_network_name = Universalization::tableUpContragentName($pharmacy_network['name']);

            $table_header[$key] =
                "<td rowspan='2' data-manager='{$pharmacy_network['manager_id']}'><span class='get-as-modal' data-manid='{$pharmacy_network['id']}'><span title='{$pharmacy_network['name']}' style='color: {$pn_bg_color}; padding: 5px'>{$uni_pharm_network_name}</span></span><br><hr data-manager='{$pharmacy_network['manager_id']}'><span title='{$m_name}'>{$m_name}</span><br><b>{$pharmacy_network['count_points']}</b></td>";
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        /** Перебор массива производителей */
        foreach ($manufacturers as $key => $manufacturer) {
            $link_color =
                ManufacturerStatuses::find()->where(['id' => $manufacturer['manufacturer_status_id']])->one()->color;

            $results[$key] = "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky' ><a href='#!' class='get-manuf-modal' data-manid='{$manufacturer['id']}' title='{$manufacturer['name']}' style='color: {$link_color}'>{$manufacturer['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-two' data-manager='{$manufacturer['marketer_id']}'>" .
                User::getUserNameById($manufacturer['marketer_id']) .
                "</td>";

            foreach ($pharmacy_networks as $pharmacy_network) {
                $task  = self::getTaskData($manufacturer['id'], $pharmacy_network['id'], 1);
                $color = $task['status_task_id'];

                if (!isset($color) && !$color) {
                    $color = '0';
                }

                if (isset($statuses[$task['working_pharmacy_id']])) {
                    $td_title = $statuses[$task['working_pharmacy_id']];
                } else {
                    $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }

                //$results[$key] .= "<td class='get-task-modal color-{$color}' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$pharmacy_network['manager_id']}' data-pnid='{$pharmacy_network['id']}'>{$td_title}</td>";

                $result_name = WorkingPharmacies::find()->where(['id' => $task['result_int']])->one()->name;

                // сопоставления цветов для импорта в эксель
                $bg_color = ExcelHelpLib::color($color);

                if ($color) {
                    $results[$key] .= "<td class='get-task-modal color-{$color}' data-fill-color='{$bg_color}' data-f-color='5d575e' data-tab='2' data-id='{$task['id']}' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$pharmacy_network['manager_id']}' data-pnid='{$pharmacy_network['id']}' title='{$result_name}' data-d_create='{$task['created_at']}' data-d_deadline='{$task['deadline']}'>{$result_name}</td>";
                } else {
                    $results[$key] .= "<td class='color-8' data-fill-color='f5acde' data-f-color='5d575e' data-pnid='{$pharmacy_network['id']}' data-manid='{$manufacturer['id']}' data-tab='2' data-id='{$task['id']}'></td>";
                }

            }

            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * АС в контракты - Подгрузка данных
     *
     * @return false|string
     */
    public function actionAjaxLoad3()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        /** Выборка из задач по соотв статусу */
        // находим все задачи с нужным статусом
        $manufacturers_ids     = [];
        $pharmacy_networks_ids = [];
        $tasks_clear           =
            Tasks::find()
                ->where(['task_type_id' => 2]) // 3 = Текущие
                ->andWhere(['close' => '0'])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        $tasks = [];

        foreach ($tasks_clear as $key => $task_tmp) {
            $tasks[$task_tmp['group_task_id']][] = $task_tmp;
        }

        foreach ($tasks as $task_data_tmp) {
            foreach ($task_data_tmp as $task_data) {
                $manufacturers_ids[$task_data['manufacturer_id']]         = $task_data['manufacturer_id'];
                $pharmacy_networks_ids[$task_data['pharmacy_network_id']] = $task_data['pharmacy_network_id'];
            }
        }

        /** Выборка из задач по соотв статусу */
        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        $manufacturers = Manufacturers::find()->asArray()
            ->where(['id' => $manufacturers_ids])
            ->andWhere([
                'manufacturer_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'marketer_id',
                'id',
            ])
            ->offset($offset)
            ->limit($limit)
            ->all();

        $pharmacy_networks = PharmacyNetworks::find()
            //->where(['id' => $pharmacy_networks_ids])
            ->where([
                'pharmacy_network_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'manager_id',
                'id',
            ])
            ->asArray()
            ->orderBy(['manager_id' => SORT_ASC])
            ->all();

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];

        $viewed_header_data = [];

        foreach ($tasks as $key_tmp => $task_tmp) {
            foreach ($task_tmp as $key => $task) {
                if (!isset($viewed_header_data[$task['group_task_id']])) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $m_name       = User::getNameById($manufacturer['marketer_id']);
                    $created      = explode(' ', $task['created_at'])[0];
                    $deadline     = explode(' ', $task['deadline'])[0];

                    $uni_task_description = Universalization::tableUpTaskDescription($task['comment']);

                    $date_created  = Universalization::dateFormat($created);
                    $date_deadline = Universalization::dateFormat($deadline);

                    $link_color =
                        ManufacturerStatuses::find()->where(['id' => $manufacturer['manufacturer_status_id']])->one()->color;

                    $table_header[] =
                        "<td rowspan='2'><span style='font-size: 14px'><span class='ud-d-create'>{$date_created}</span><br><span class='ud-d-deadline'>{$date_deadline}</span></span><br><span title='{$manufacturer['name']}' class='get-manuf-modal' data-groupid='{$task['group_task_id']}' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' style='color: {$link_color}'>{$manufacturer['name']}</span><br><hr><span title='{$m_name}'>{$m_name}</span><hr><a href='#!' class='edit-group' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' data-type='3' data-grouptaskid='{$task['group_task_id']}'>Групп. ред.</a><br>{$task['id']}-<span title='{$task['group_task_id']}' class='group-task-id'>{$task['group_task_id']}</span><br><p title='{$task['comment']}' class='task-comment' data-id='{$task['id']}' title='{$uni_task_description}' style='font-weight: 700'>{$uni_task_description}</p></td>";

                    $viewed_header_data[$task['group_task_id']] = $task['group_task_id'];
                }
            }
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        $viewed_task_data = [];

        foreach ($pharmacy_networks as $key => $network) {
            $link_color =
                PharmacyNetworkStatuses::find()->where(['id' => $network['pharmacy_network_status_id']])->one()->color;

            $contracts_count = \app\models\db\Tasks::find()
                ->where(['pharmacy_network_id' => $network['id']])
                ->andWhere(['status_task_id' => 2])
                ->andWhere(['task_type_id' => 1])
                ->count();

            $results[$key] .= "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky'><a href='#!' class='get-as-modal' data-manid='{$network['id']}' style='color: {$link_color}'>{$network['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-three' data-manager='{$network['manager_id']}'>" .
                User::getUserNameById($network['manager_id']) .
                "</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-four'>{$network['count_points']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-five'>{$network['turnover_network']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-six'>{$contracts_count}</td>";

            foreach ($tasks as $task_tmp2) {
                foreach ($task_tmp2 as $task) {
                    // todo: ниже все участки закоменчены для повышения скорости. проверка корректности работы не была произведена
                    //$manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    //$task         = self::getTaskData($manufacturer['id'], $network['id'], 3);

                    //$color = $task['status_task_id'];

                    //if (!isset($color) && !$color) {
                    //    $color = '0';
                    //}

                    //if (isset($statuses[$task['working_pharmacy_id']])) {
                    //    $td_title = $statuses[$task['working_pharmacy_id']];
                    //} else {
                    //    $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    //}

                    if ($task['task_type_id'] == 999) { // == 3
                        $results[$key] .= "<td class='task-area get-task-modal-by-id color-{$color}' data-id='{$task['id']}' data-taskid='{$task['id']}' data-groupid='{$task['group_task_id']}' data-tab='4' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$network['manager_id']}' data-pnid='{$network['id']}' title='{$task['id']} | {$task['group_task_id']}{$td_title}'>{$task['id']} | {$task['group_task_id']}{$td_title}</td>";
                    } else {
                        $results[$key] .= "<td><div class='task-area create-task' data-tasktype='2' data-as='{$network['id']}' data-manuf='{$manufacturer['id']}' data-tab='3'>+</div></td>";
                    }
                }

            }
            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * Текущие - Подгрузка данных
     *
     * @return false|string
     *
     */
    public function actionAjaxLoad4()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        /** Выборка из задач по соотв статусу */
        // находим все задачи с нужным статусом
        $manufacturers_ids     = [];
        $pharmacy_networks_ids = [];
        $tasks_clear           =
            Tasks::find()
                ->where(['task_type_id' => 3]) // 3 = Текущие
                ->andWhere(['close' => '0'])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        $tasks = [];

        foreach ($tasks_clear as $key => $task_tmp) {
            $tasks[$task_tmp['group_task_id']][] = $task_tmp;
        }

        foreach ($tasks as $task_data_tmp) {
            foreach ($task_data_tmp as $task_data) {
                $manufacturers_ids[$task_data['manufacturer_id']]         = $task_data['manufacturer_id'];
                $pharmacy_networks_ids[$task_data['pharmacy_network_id']] = $task_data['pharmacy_network_id'];
            }
        }

        /** Выборка из задач по соотв статусу */
        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        $manufacturers = Manufacturers::find()->asArray()
            ->where(['id' => $manufacturers_ids])
            ->andWhere([
                'manufacturer_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'marketer_id',
                'id',
            ])
            ->offset($offset)
            ->limit($limit)
            ->all();

        $pharmacy_networks = PharmacyNetworks::find()
            //->where(['id' => $pharmacy_networks_ids])
            ->where([
                'pharmacy_network_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'manager_id',
                'id',
            ])
            ->asArray()
            ->orderBy(['manager_id' => SORT_ASC])
            ->all();

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];

        $viewed_header_data = [];

        foreach ($tasks as $key_tmp => $task_tmp) {
            foreach ($task_tmp as $key => $task) {
                if (!isset($viewed_header_data[$task['group_task_id']])) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $m_name       = User::getNameById($manufacturer['marketer_id']);
                    $created      = explode(' ', $task['created_at'])[0];
                    $deadline     = explode(' ', $task['deadline'])[0];

                    $uni_task_description = Universalization::tableUpTaskDescription($task['comment']);

                    $date_created  = Universalization::dateFormat($created);
                    $date_deadline = Universalization::dateFormat($deadline);

                    $link_color =
                        ManufacturerStatuses::find()->where(['id' => $manufacturer['manufacturer_status_id']])->one()->color;

                    $table_header[] =
                        "<td rowspan='2'><span style='font-size: 14px'><span class='ud-d-create'>{$date_created}</span><br><span class='ud-d-deadline'>{$date_deadline}</span></span><br><span title='{$manufacturer['name']}' class='get-manuf-modal' data-groupid='{$task['group_task_id']}' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' style='color: {$link_color}'>{$manufacturer['name']}</span><br><hr><span title='{$m_name}'>{$m_name}</span><hr><a href='#!' class='edit-group' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' data-type='3' data-grouptaskid='{$task['group_task_id']}'>Групп. ред.</a><br>{$task['id']}-<span title='{$task['group_task_id']}' class='group-task-id'>{$task['group_task_id']}</span><br><p title='{$task['comment']}' class='task-comment' data-id='{$task['id']}' title='{$uni_task_description}' style='font-weight: 700'>{$uni_task_description}</p></td>";

                    $viewed_header_data[$task['group_task_id']] = $task['group_task_id'];
                }
            }
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        $viewed_task_data = [];

        foreach ($pharmacy_networks as $key => $network) {
            $link_color =
                PharmacyNetworkStatuses::find()->where(['id' => $network['pharmacy_network_status_id']])->one()->color;

            $contracts_count = \app\models\db\Tasks::find()
                ->where(['pharmacy_network_id' => $network['id']])
                ->andWhere(['status_task_id' => 2])
                ->andWhere(['task_type_id' => 1])
                ->count();

            $results[$key] .= "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky'><a href='#!' class='get-as-modal' data-manid='{$network['id']}' style='color: {$link_color}'>{$network['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-three' data-manager='{$network['manager_id']}'>" .
                User::getUserNameById($network['manager_id']) .
                "</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-four'>{$network['count_points']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-five'>{$network['turnover_network']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-six'>{$contracts_count}</td>";

            foreach ($tasks as $task_tmp2) {
                foreach ($task_tmp2 as $task) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $task         = self::getTaskData($manufacturer['id'], $network['id'], 3);
                    //$task  = self::getTaskDataById($task['id']);
                    $color = $task['status_task_id'];

                    if (!isset($color) && !$color) {
                        $color = '0';
                    }

                    if (isset($statuses[$task['working_pharmacy_id']])) {
                        $td_title = $statuses[$task['working_pharmacy_id']];
                    } else {
                        $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    // сопоставления цветов для импорта в эксель
                    $bg_color = ExcelHelpLib::color($color);
                    if ($task['task_type_id'] == 999) { // == 3
                        $results[$key] .= "<td class='task-area get-task-modal-by-id color-{$color}' data-fill-color='{$bg_color}' data-id='{$task['id']}' data-taskid='{$task['id']}' data-groupid='{$task['group_task_id']}' data-tab='4' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$network['manager_id']}' data-pnid='{$network['id']}' title='{$task['id']} | {$task['group_task_id']}{$td_title}'>{$task['id']} | {$task['group_task_id']}{$td_title}</td>";
                    } else {
                        $results[$key] .= "<td><div class='task-area create-task' data-tasktype='3' data-as='{$network['id']}' data-manuf='{$manufacturer['id']}' data-tab='4'>+</div></td>";
                    }
                }
            }

            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * ТМА - Подгрузка данных
     *
     * @return false|string
     */
    public function actionAjaxLoad5()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        /** Выборка из задач по соотв статусу */
        // находим все задачи с нужным статусом
        $manufacturers_ids     = [];
        $pharmacy_networks_ids = [];
        $tasks_clear           =
            Tasks::find()
                ->where(['task_type_id' => 4]) // 4 = ТМА
                ->andWhere(['close' => '0'])
//                ->limit(100)
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        $tasks = [];

        foreach ($tasks_clear as $key => $task_tmp) {
            $tasks[$task_tmp['group_task_id']][] = $task_tmp;
        }

        foreach ($tasks as $task_data_tmp) {
            foreach ($task_data_tmp as $task_data) {
                $manufacturers_ids[$task_data['manufacturer_id']]         = $task_data['manufacturer_id'];
                $pharmacy_networks_ids[$task_data['pharmacy_network_id']] = $task_data['pharmacy_network_id'];
            }
        }

        /** Выборка из задач по соотв статусу */
        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        $manufacturers = Manufacturers::find()->asArray()
            ->where(['id' => $manufacturers_ids])
            ->andWhere([
                'manufacturer_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'marketer_id',
                'id',
            ])
            ->offset($offset)
            ->limit($limit)
            ->all();

        $pharmacy_networks = PharmacyNetworks::find()
            //->where(['id' => $pharmacy_networks_ids])
            ->where([
                'pharmacy_network_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'manager_id',
                'id',
            ])
            ->asArray()
            ->orderBy(['manager_id' => SORT_ASC])
            ->all();

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];

        $viewed_header_data = [];

        foreach ($tasks as $key_tmp => $task_tmp) {
            foreach ($task_tmp as $key => $task) {
                if (!isset($viewed_header_data[$task['group_task_id']])) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $m_name       = User::getNameById($manufacturer['marketer_id']);
                    $created      = explode(' ', $task['created_at'])[0];
                    $deadline     = explode(' ', $task['deadline'])[0];

                    $uni_task_description = Universalization::tableUpTaskDescription($task['comment']);

                    $date_created  = Universalization::dateFormat($created);
                    $date_deadline = Universalization::dateFormat($deadline);

                    $link_color =
                        ManufacturerStatuses::find()->where(['id' => $manufacturer['manufacturer_status_id']])->one()->color;

                    $table_header[] =
                        "<td rowspan='2'><span style='font-size: 14px'><span class='ud-d-create'>{$date_created}</span><br><span class='ud-d-deadline'>{$date_deadline}</span></span><br><span title='{$manufacturer['name']}' class='get-manuf-modal' data-groupid='{$task['group_task_id']}' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' style='color: {$link_color}'>{$manufacturer['name']}</span><br><hr><span title='{$m_name}'>{$m_name}</span><hr><a href='#!' class='edit-group' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' data-type='3' data-grouptaskid='{$task['group_task_id']}'>Групп. ред.</a><br>{$task['id']}-<span title='{$task['group_task_id']}' class='group-task-id'>{$task['group_task_id']}</span><br><p title='{$task['comment']}' class='task-comment' data-id='{$task['id']}' title='{$uni_task_description}' style='font-weight: 700'>{$uni_task_description}</p></td>";

                    $viewed_header_data[$task['group_task_id']] = $task['group_task_id'];
                }
            }
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        $viewed_task_data = [];

        foreach ($pharmacy_networks as $key => $network) {
            $link_color =
                PharmacyNetworkStatuses::find()->where(['id' => $network['pharmacy_network_status_id']])->one()->color;

            $contracts_count = \app\models\db\Tasks::find()
                ->where(['pharmacy_network_id' => $network['id']])
                ->andWhere(['status_task_id' => 2])
                ->andWhere(['task_type_id' => 1])
                ->count();

            $results[$key] .= "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky'><a href='#!' class='get-as-modal' data-manid='{$network['id']}' style='color: {$link_color}'>{$network['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-three' data-manager='{$network['manager_id']}'>" .
                User::getUserNameById($network['manager_id']) .
                "</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-four'>{$network['count_points']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-five'>{$network['turnover_network']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-six'>{$contracts_count}</td>";

            foreach ($tasks as $task_tmp2) {
                foreach ($task_tmp2 as $task) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $task         = self::getTaskData($manufacturer['id'], $network['id'], 3);
                    //$task  = self::getTaskDataById($task['id']);
                    $color = $task['status_task_id'];

                    if (!isset($color) && !$color) {
                        $color = '0';
                    }

                    if (isset($statuses[$task['working_pharmacy_id']])) {
                        $td_title = $statuses[$task['working_pharmacy_id']];
                    } else {
                        $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }

                    if ($task['task_type_id'] == 999) { // == 3
                        $results[$key] .= "<td class='task-area get-task-modal-by-id color-{$color}' data-id='{$task['id']}' data-taskid='{$task['id']}' data-groupid='{$task['group_task_id']}' data-tab='4' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$network['manager_id']}' data-pnid='{$network['id']}' title='{$task['id']} | {$task['group_task_id']}{$td_title}'>{$task['id']} | {$task['group_task_id']}{$td_title}</td>";
                    } else {
                        $results[$key] .= "<td><div class='task-area create-task' data-tasktype='4' data-as='{$network['id']}' data-manuf='{$manufacturer['id']}' data-tab='5'>+</div></td>";
                    }
                }
            }

            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * Уведомления - Подгрузка данных
     *
     * @return false|string
     */
    public function actionAjaxLoad6()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        /** Выборка из задач по соотв статусу */
        // находим все задачи с нужным статусом
        $manufacturers_ids     = [];
        $pharmacy_networks_ids = [];
        $tasks_clear           =
            Tasks::find()
                ->where(['task_type_id' => 5]) // 5 = Уведомления
                ->andWhere(['close' => '0'])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        $tasks = [];

        foreach ($tasks_clear as $key => $task_tmp) {
            $tasks[$task_tmp['group_task_id']][] = $task_tmp;
        }

        foreach ($tasks as $task_data_tmp) {
            foreach ($task_data_tmp as $task_data) {
                $manufacturers_ids[$task_data['manufacturer_id']]         = $task_data['manufacturer_id'];
                $pharmacy_networks_ids[$task_data['pharmacy_network_id']] = $task_data['pharmacy_network_id'];
            }
        }

        /** Выборка из задач по соотв статусу */
        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        $manufacturers = Manufacturers::find()->asArray()
            ->where(['id' => $manufacturers_ids])
            ->andWhere([
                'manufacturer_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'marketer_id',
                'id',
            ])
            ->offset($offset)
            ->limit($limit)
            ->all();

        $pharmacy_networks = PharmacyNetworks::find()
            //->where(['id' => $pharmacy_networks_ids])
            ->where([
                'pharmacy_network_status_id' => [
                    1,
                    3,
                ],
            ])
            ->groupBy([
                'manager_id',
                'id',
            ])
            ->asArray()
            ->orderBy(['manager_id' => SORT_ASC])
            ->all();

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];

        $viewed_header_data = [];

        foreach ($tasks as $key_tmp => $task_tmp) {
            foreach ($task_tmp as $key => $task) {
                if (!isset($viewed_header_data[$task['group_task_id']])) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $m_name       = User::getNameById($manufacturer['marketer_id']);
                    $created      = explode(' ', $task['created_at'])[0];
                    $deadline     = explode(' ', $task['deadline'])[0];

                    $uni_task_description = Universalization::tableUpTaskDescription($task['comment']);

                    $date_created  = Universalization::dateFormat($created);
                    $date_deadline = Universalization::dateFormat($deadline);

                    $link_color =
                        ManufacturerStatuses::find()->where(['id' => $manufacturer['manufacturer_status_id']])->one()->color;

                    $table_header[] =
                        "<td rowspan='2'><span style='font-size: 14px'><span class='ud-d-create'>{$date_created}</span><br><span class='ud-d-deadline'>{$date_deadline}</span></span><br><span title='{$manufacturer['name']}' class='get-manuf-modal' data-groupid='{$task['group_task_id']}' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' style='color: {$link_color}'>{$manufacturer['name']}</span><br><hr><span title='{$m_name}'>{$m_name}</span><hr><a href='#!' class='edit-group' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' data-type='3' data-grouptaskid='{$task['group_task_id']}'>Групп. ред.</a><br>{$task['id']}-<span title='{$task['group_task_id']}' class='group-task-id'>{$task['group_task_id']}</span><br><p title='{$task['comment']}' class='task-comment' data-id='{$task['id']}' title='{$uni_task_description}' style='font-weight: 700'>{$uni_task_description}</p></td>";

                    $viewed_header_data[$task['group_task_id']] = $task['group_task_id'];
                }
            }
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        $viewed_task_data = [];

        foreach ($pharmacy_networks as $key => $network) {
            $link_color =
                PharmacyNetworkStatuses::find()->where(['id' => $network['pharmacy_network_status_id']])->one()->color;

            $contracts_count = \app\models\db\Tasks::find()
                ->where(['pharmacy_network_id' => $network['id']])
                ->andWhere(['status_task_id' => 2])
                ->andWhere(['task_type_id' => 1])
                ->count();

            $results[$key] .= "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky'><a href='#!' class='get-as-modal' data-manid='{$network['id']}' style='color: {$link_color}'>{$network['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-three' data-manager='{$network['manager_id']}'>" .
                User::getUserNameById($network['manager_id']) .
                "</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-four'>{$network['count_points']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-five'>{$network['turnover_network']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-six'>{$contracts_count}</td>";

            foreach ($tasks as $task_tmp2) {
                foreach ($task_tmp2 as $task) {
                    $manufacturer = Manufacturers::find()->where(['id' => $task['manufacturer_id']])->asArray()->one();
                    $task         = self::getTaskData($manufacturer['id'], $network['id'], 3);
                    //$task  = self::getTaskDataById($task['id']);
                    $color = $task['status_task_id'];

                    if (!isset($color) && !$color) {
                        $color = '0';
                    }

                    if (isset($statuses[$task['working_pharmacy_id']])) {
                        $td_title = $statuses[$task['working_pharmacy_id']];
                    } else {
                        $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }

                    if ($task['task_type_id'] == 999) { // == 3
                        $results[$key] .= "<td class='task-area get-task-modal-by-id color-{$color}' data-id='{$task['id']}' data-taskid='{$task['id']}' data-groupid='{$task['group_task_id']}' data-tab='4' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$network['manager_id']}' data-pnid='{$network['id']}' title='{$task['id']} | {$task['group_task_id']}{$td_title}'>{$task['id']} | {$task['group_task_id']}{$td_title}</td>";
                    } else {
                        $results[$key] .= "<td><div class='task-area create-task' data-tasktype='5' data-as='{$network['id']}' data-manuf='{$manufacturer['id']}' data-tab='6'>+</div></td>";
                    }
                }
            }

            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * Закрытые задачи
     *
     * @return false|string
     */
    public function actionAjaxLoad7()
    {
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        /** Выборка из задач по соотв статусу */
        // находим все задачи с нужным статусом
        $manufacturers_ids     = [];
        $pharmacy_networks_ids = [];
        $tasks                 =
            Tasks::find()
                ->where(['close' => 1])
                ->andWhere(['id' => 0]) // закрываем загрузку стандартным методом
                ->asArray()
                ->limit(10)
                ->all();

        foreach ($tasks as $task_data) {
            $manufacturers_ids[$task_data['manufacturer_id']]         = $task_data['manufacturer_id'];
            $pharmacy_networks_ids[$task_data['pharmacy_network_id']] = $task_data['pharmacy_network_id'];
        }

        /** Выборка из задач по соотв статусу */

        $results = [];

        /** Настройка отображения, в соответствии с основной ролью (админ/офис/менеджер/маркетолог) */
        $user_roles = GetLevel::getIdUpLevelGroup(Yii::$app->user->id);

        $manufacturers = Manufacturers::find()->asArray()
            ->where(['id' => $manufacturers_ids])
            ->andWhere(['manufacturer_status_id' => 1])
            ->groupBy([
                'marketer_id',
                'id',
            ])
            ->offset($offset)
            ->limit($limit)
            ->all();

        $pharmacy_networks = PharmacyNetworks::find()
            //->where(['id' => $pharmacy_networks_ids])
            ->where(['pharmacy_network_status_id' => 1])
            ->groupBy([
                'manager_id',
                'id',
            ])
            ->asArray()
            ->orderBy(['manager_id' => SORT_ASC])
            ->all();

        $statuses = self::getStatusTitle();

        /** Генерация шапки таблицы */
        $table_header = [];

        foreach ($tasks as $key => $task_header) {
            //$m_name             = User::getNameById($manufacturer['marketer_id']);

            $manufacturer = Manufacturers::find()->where(['id' => $task_header['manufacturer_id']])->asArray()->one();

            $table_header[$key] =
                "<td rowspan='2'><span class='get-manuf-modal' title='{$manufacturer['name']}' data-manid='{$manufacturer['id']}'>{$manufacturer['name']}</span><br><hr><span title='{$m_name}'>{$m_name}</span><hr><a href='#!' class='edit-group' data-taskid='{$task['id']}' data-manid='{$manufacturer['id']}' data-type='0'>Групп. ред.</a></td>";
        }

        $table_header2 = [];
        foreach ($pharmacy_networks as $key => $pharmacy_network) {
            $table_header2[$key] = "AA<br>00";
        }

        foreach ($pharmacy_networks as $key => $network) {
            $results[$key] .= "<tr class='tvd1'>";
            $results[$key] .= "<td style='width: 70px' class='sticky'><a href='#!' class='get-as-modal' data-manid='{$network['id']}'>{$network['name']}</a></td>";
            $results[$key] .= "<td style='width: 70px' class='manager sticky-three' data-manager='{$network['manager_id']}'>" .
                User::getUserNameById($network['manager_id']) .
                "</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-four'>{$network['count_points']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-five'>{$network['turnover_network']}</td>";
            $results[$key] .= "<td style='width: 70px' class='sticky-six'>{$network['turnover_network']}</td>";

            foreach ($manufacturers as $manufacturer) {
                $task  = self::getTaskData($manufacturer['id'], $network['id'], null, 1);
                $color = $task['status_task_id'];

                if (!isset($color) && !$color) {
                    $color = '0';
                }

                if (isset($statuses[$task['working_pharmacy_id']])) {
                    $td_title = $statuses[$task['working_pharmacy_id']];
                } else {
                    $td_title = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }

                $results[$key] .= "<td class='get-task-modal color-{$color}' data-tab='7' data-manid='{$manufacturer['id']}' data-marketer-id='{$manufacturer['marketer_id']}' data-menager-id='{$network['manager_id']}' data-pnid='{$network['id']}' title='{$td_title}'>{$td_title}</td>";
            }

            $results[$key] .= "</tr>";
        }

        $data = [
            'count'      => Manufacturers::find()->count(),
            'next'       => 'index.php?r=table/ajax-load',
            'previous'   => null,
            'results'    => $results,
            'header'     => $table_header,
            'headerdown' => $table_header2,
        ];

        return json_encode($data);
    }

    /**
     * Получение данных для модалки
     *
     * @return string
     */
    public function actionGetOrderDataInModal()
    {
        $this->layout = false;
        $manid        = htmlspecialchars($_GET['manid']);
        $pnid         = htmlspecialchars($_GET['pnid']);
        $tab          = htmlspecialchars($_GET['tab']);

        $current_task =
            Tasks::find()->where(['manufacturer_id' => $manid])->andWhere(['pharmacy_network_id' => $pnid])->asArray()->one();

        $manuf_name = Manufacturers::getNameById($current_task['manufacturer_id']);
        $pn_name    = PharmacyNetworks::getNameById($current_task['pharmacy_network_id']);

        $comments = Comments::find()
            ->where(['model_id' => $current_task['id']])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->render('_modal', [
            'manid'        => $manid,
            'pnid'         => $pnid,
            'current_task' => $current_task,
            'manuf_name'   => $manuf_name,
            'pn_name'      => $pn_name,
            'comments'     => $comments,
            'tab'          => $tab,
        ]);
    }

    /**
     * Получение данных для модалки
     *
     * @return string
     */
    public function actionGetOrderDataInModalById()
    {
        $this->layout = false;
        $id           = htmlspecialchars($_GET['id']);

        $current_task =
            Tasks::find()->where(['id' => $id])->asArray()->one();

        $manuf_name = Manufacturers::getNameById($current_task['manufacturer_id']);
        $pn_name    = PharmacyNetworks::getNameById($current_task['pharmacy_network_id']);

        $comments = Comments::find()
            ->where(['model_id' => $current_task['id']])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->render('_modal', [
            'manid'        => $manid,
            'pnid'         => $pnid,
            'current_task' => $current_task,
            'manuf_name'   => $manuf_name,
            'pn_name'      => $pn_name,
            'comments'     => $comments,
            'tab'          => $tab,
        ]);
    }

    /**
     * @return string
     */
    public function actionGetStartOrderDataInModal()
    {
        $this->layout = false;
        $manid        = htmlspecialchars($_GET['manid']);
        $pnid         = htmlspecialchars($_GET['pnid']);
        $tab          = 2;

        $current_task =
            Tasks::find()->where(['manufacturer_id' => $manid])->andWhere(['pharmacy_network_id' => $pnid])->asArray()->one();

        $manuf_name = Manufacturers::getNameById($manid);
        $pn_name    = PharmacyNetworks::getNameById($pnid);

        $comments = Comments::find()
            ->where(['model_id' => $current_task['id']])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->render('_modalStartOrder', [
            'manid'        => $manid,
            'pnid'         => $pnid,
            'current_task' => $current_task,
            'manuf_name'   => $manuf_name,
            'pn_name'      => $pn_name,
            'comments'     => $comments,
            'tab'          => $tab,
        ]);
    }

    /**
     * Получение цвета заливки ячейки таблицы
     *
     * @param $manid
     * @param $pnid
     *
     * @return mixed|string|null
     */
    private static function getColor($manid, $pnid)
    {
        $task =
            Tasks::find()->where(['manufacturer_id' => $manid])->andWhere(['pharmacy_network_id' => $pnid])->asArray()->one();

        if (isset($task)) {
            $status = $task['status_task_id'];

            return StatusTasks::find()->where(['id' => $status])->one()->color;
        }

        return "#ffffff";
    }

    /**
     * Получение ID цвета заливки ячейки таблицы
     *
     * @param $status_task_id
     *
     * @return mixed|string
     */
    private static function getIdColor($status_task_id)
    {
        $color = StatusTasks::find()->where(['id' => $status_task_id])->asArray()->one()['color'];

        if (isset($color)) {
            return $color;
        }

        return "#ffffff";
    }

    /**
     * Получение данных по задаче по пересечению произв./АС
     *
     * @param      $manid
     * @param      $pnid
     * @param null $task_type_id
     * @param int  $close
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    private static function getTaskData($manid, $pnid, $task_type_id = null, $close = 0)
    {
        return Tasks::find()
            ->where(['manufacturer_id' => $manid])
            ->andWhere(['pharmacy_network_id' => $pnid])
            ->andFilterWhere(['task_type_id' => $task_type_id])
            ->asArray()
            ->one();
    }

    /**
     * Получение данных по задаче по id
     *
     * @param $id
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    private static function getTaskDataById($id)
    {
        return Tasks::find()
            ->where(['id' => $id])
            ->asArray()
            ->one();
    }

    /**
     * Получение массива из таблицы working_pharmacies (надписи на квадратиках)
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    private static function getStatusTitle()
    {
        $data_arr = WorkingPharmacies::find()
            ->asArray()
            ->all();
        $data_arr = ArrayHelper::map($data_arr, 'id', 'name');

        return $data_arr;
    }

    /**
     * Получение данных для модалки
     *
     * @return string
     */
    public function actionGetManufModal()
    {
        $this->layout = false;
        $manid        = htmlspecialchars($_GET['manid']);

        $manuf_data = Manufacturers::find()->where(['id' => $manid])->one();

        return $this->render('_manufModal', [
            'manuf_data' => $manuf_data,
        ]);
    }

    /**
     * Получение данных для модалки
     *
     * @return string
     */
    public function actionGetAsModal()
    {
        $this->layout = false;
        $manid        = htmlspecialchars($_GET['manid']);

        $manuf_data = PharmacyNetworks::find()->where(['id' => $manid])->one();

        return $this->render('_asModal', [
            'manuf_data' => $manuf_data,
        ]);
    }

    /**
     * Получение данных для модалки
     *
     * @return string
     */
    public function actionGetEditGroupModal()
    {
        $this->layout = false;
        $manid        = htmlspecialchars($_GET['manid']);
        $type         = htmlspecialchars($_GET['type']);

        if (isset($_GET['taskid'])) {
            $taskid = $_GET['taskid'];
        } else {
            $taskid = 0;
        }

        $manuf_data = Manufacturers::find()->where(['id' => $manid])->one();

        return $this->render('_editGroupModal', [
            'manuf_data' => $manuf_data,
            'type'       => $type,
            'taskid'     => $taskid,
        ]);
    }
}