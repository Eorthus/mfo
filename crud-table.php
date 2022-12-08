<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

if (Yii::$app->user->isGuest) {  // не переносить в контроллер !!!
    echo "<script>window.location.href = 'index.php?r=site/login';</script>";
    exit;
}
?>
<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png"/>
        <style>
            .hidden {
                display: none !important;
            }

            .nonhidden {
                display: unset !important;
            }

            .crud-container {
                margin: 75px 15px 55px 265px;
            }

            .breadcrumb {
                background-color: #e7e7e7;
                border-radius: 10px;
                padding: 5px 25px !important;
            }

            .breadcrumb li {
                margin-right: 15px;
                border-right: 1px solid white;
            }

            .breadcrumb li:last-child {
                border-right: 0;
            }

            .breadcrumb li a {
                margin-right: 15px;
            }

            a {
                color: blue
            }

            #infinite-list {
                position: relative;
                width: auto;
                height: 75vh;
                overflow-y: scroll;
                font-size: 15px;
            }

            table {
                border-spacing: 0;
                border-collapse: collapse;
            }

            td {
                border: 1px solid #dbdbdb !important;
                padding: 5px !important;
                background-color: white;
                cursor: pointer;
            }

            th {
                border: 1px solid #dbdbdb !important;
                padding: 5px !important;
                background-color: white;
            }

            .color-0 {
                background-color: #ffffff;
            }

            .color-1 {
                background-color: #FFFF00FF;
            }

            .color-2 {
                background-color: #00B050B0;
            }

            .color-3 {
                background-color: #FF00007C;
            }

            .color-4 {
                background-color: #007AF08A;
            }

            .color-5 {
                background-color: #002060FF;
            }

            .color-6 {
                background-color: #7030A0FF;
            }

            .color-7 {
                background-color: #00B050FF;
            }

            .color-8 {
                background-color: #f5acde;
            }

            .color-ff9de0 {
                background-color: #ffc5ed;
            }

            .b-title {
                background-color: #c0efef;
                font-weight: 400;
                color: black;
                z-index: 10;
            }

            .back-white {
                background-color: white;
            }

            .text-center {
                text-align: center;
            }

            th {
                position: sticky;
                top: 0;
                background-color: white;
                text-align: center;
            }

            .border {
                border: 1px solid #e8e8e8;
            }

            .sticky {
                position: sticky;
                left: 0;

            }

            .sticky {
                max-width: 155px !important;
                min-width: 155px !important;
            }

            .sticky-two {
                left: 153px;
                position: sticky;
                text-align: center;
                min-width: unset !important;
                max-width: unset !important;
            }

            .sticky-two {
                max-width: 155px !important;
                min-width: 155px !important;
            }

            .sticky-three {
                position: sticky;
                left: 153px;
                max-width: 155px !important;
                min-width: 155px !important;
            }

            .sticky-four {
                position: sticky;
                left: 307px;
                min-width: unset !important;
                max-width: unset !important;
            }

            .sticky-five {
                position: sticky;
                left: 407px;
                min-width: unset !important;
                max-width: unset !important;


            }

            .sticky-six {
                position: sticky;
                left: 511px;
                min-width: unset !important;
                max-width: unset !important;
            }


            .deadline-block p, .deadline-block hr {
                margin: 0;

            }

            .deadline-block .deadline {
                margin-bottom: 9px;
                text-align: left;
                font-size: 13.5px;
            }

            .deadline-block .title {
                margin-bottom: 50px;
            }

            .infinite-list4 .deadline-block .deadline {
                margin-bottom: 35px;
            }

            .infinite-list4 .deadline-block .title {
                margin-bottom: 30px;
            }

            .toggle-th, .toggle-th-last {
                cursor: pointer;
            }

            th p {
                margin-bottom: 0;
            }

            .show {
                display: flex !important;
            }

            .modal-dialog {
                margin: auto !important;
            }

            .spoilers-close, .spoilers-open {
                display: none;
            }

            td, th {
                white-space: nowrap;
                text-align: center;
                max-width: 90px;
                min-width: 90px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }

            th hr {
                margin: 5px 0;
            }

            th {
                white-space: nowrap !important;
                text-align: center;
            }

            .header-one {
                vertical-align: top !important;
            }

            .chosen-container {
                width: 100% !important;
            }

            .chosen-container-multi {
                width: 100% !important;
            }

            .chosen-choices {
                min-height: 37px !important;
                padding: 4px !important;
            }

            .block-scroll {
                overflow: scroll;
                height: calc(100vh - 380px) !important;
            }

            .type-as {
                color: red
            }

            .tmp-clear-bg {
                background-color: white !important;
            }

            .get-as-modal, .get-manuf-modal {
                cursor: pointer;
            }

            td.sticky {
                text-align: left;
            }

            .header-one {
                font-weight: 500;
            }

            .get-as-modal {
                font-weight: 700;
                font-size: 12px;
            }

            .get-manuf-modal {
                font-weight: 700;
                font-size: 12px;
            }

            td {
                font-weight: 300;
            }

            .td-active {
                font-weight: 800;
                color: black;
                border: 2px solid black !important;
            }

            .task-comment {
                background-color: #b0b0b0;
            }

            .locked-screen {
                background: white;
                width: 85%;
                height: 100vh;
                position: absolute;
                z-index: 99999999;
                text-align: center;
                padding-top: 20vh;
            }
        </style>

        <link href="assets/css/select/chosen.css" rel="stylesheet"/>
        <link href="assets/css/select/prism.css" rel="stylesheet"/>
        <!--        <link href="assets/css/select/style.css" rel="stylesheet"/>-->

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <?php echo $this->render('//layouts/_parts/_leftNav'); ?>
        <?php echo $this->render('//layouts/_parts/_header'); ?>
        <div class="crud-container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?php echo $content; ?>
        </div>
        <?php echo $this->render('//layouts/_parts/_footer'); ?>
    </div>
    <?php //echo $this->render('//layouts/_parts/_theme_switcher'); ?>

    <div class="modal fade bd-example-modal-lg" id="order-data-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content task-modal" style="width: 1200px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Информация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close-modal-btn" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 16px">
                    Загрузка...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal-btn" data-dismiss="modal">
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    <script>
        function setTableSpoilers(list) {
            //cобираем спойлеры
            let link = list.querySelectorAll('.toggle');
            //console.log('g', link);
            link.forEach(el => {
                //console.log(el);
                el.addEventListener('click', function () {
                    //отделяем manager_id от спойлера
                    let target_attr = el.getAttribute('data-sum').split('_')[0];
                    //собираем tr
                    // let log = document.querySelectorAll('.manuf-line');
                    let log;
                    if (list.classList.contains('infinite-list1')) {
                        log = document.querySelectorAll('.manuf-liness');
                        //console.log(list)
                    } else {
                        log = document.querySelectorAll('.manuf-line');
                    }
                    //console.log(list)


                    log.forEach(item => {
                        //отделяем manager_id от tr
                        let item_attr = item.querySelector('.manager').getAttribute('data-manager');
                        if ((item_attr == target_attr)) {
                            item.classList.toggle('hidden');
                        }
                    });
                });
                //console.log('table spoilers');
            });

        }
    </script>
    <script>
        function setTableSpoilers2(list) {
            //cобираем спойлеры

            let link = list.querySelectorAll('.toggle-th');
            // if (list!=document.querySelector('.infinite-list4')
            //     && list!=document.querySelector('.infinite-list7')
            // && list!=document.querySelector('.infinite-list6')
            //         && list!=document.querySelector('.infinite-list3')
            //         && list!=document.querySelector('.infinite-list5')
            // ){
            link.forEach(el => {
                //  el.textContent+=`${summary}`;

                el.addEventListener('click', function () {

                    //отделяем manager_id от спойлера
                    let target_attr = el.getAttribute('data-sum').split('_')[0];
                    //собираем th
                    let log = document.querySelector('.show').querySelectorAll('.header-one');

                    log.forEach((item) => {
                        //отделяем manager_id от th
                        let item_attr = item.querySelector('hr').getAttribute('data-manager');
                        if (item_attr == target_attr) {

                            //собираем id столбца
                            let id_arr = item.getAttribute('data-id');
                            let id_arr2 = Number(id_arr) + 3;
                            //cобираем столбец в кучку
                            let child_arr = document.querySelector('.show').querySelectorAll(`td:nth-child(${id_arr2})`);
                            //console.log(item_attr, target_attr, id_arr, id_arr2)
                            //вкл hide
                            if (item.classList.contains('hidden')) {
                                item.classList.remove('hidden');
                                child_arr.forEach(el => {
                                    el.classList.remove('hidden');
                                })
                            } else {
                                item.classList.add('hidden');
                                child_arr.forEach(el => {
                                    el.classList.add('hidden');
                                })
                            }
                        }
                    });
                });
            });
            let last = list.querySelector('.toggle-th-last')
            if (last) {
                last.addEventListener('click', function () {

                    //отделяем manager_id от спойлера
                    let target_attr = last.getAttribute('data-sum').split('_')[0];
                    //собираем th
                    let log = document.querySelector('.show').querySelectorAll('.header-one');

                    log.forEach((item) => {
                        //отделяем manager_id от th
                        let item_attr = item.querySelector('hr').getAttribute('data-manager');

                        if (item_attr == target_attr) {
                            //собираем id столбца
                            let id_arr = item.getAttribute('data-id');
                            let id_arr2 = Number(id_arr) + 3;
                            //cобираем столбец в кучку
                            let child_arr = document.querySelector('.show').querySelectorAll(`td:nth-child(${id_arr2})`);

                            //вкл hide
                            if (item.classList.contains('hidden')) {
                                item.classList.remove('hidden');
                                child_arr.forEach(last => {
                                    last.classList.remove('hidden');
                                })
                            } else {
                                item.classList.add('hidden');
                                child_arr.forEach(last => {
                                    last.classList.add('hidden');
                                })

                            }
                        }
                        ;
                    });
                });
            }
        }

    </script>
    <script>
        function createTableLine() {
            // ищем все строки таблицы
            let allLine = $(document).find('.manuf-line');

            // перебираем строки таблицы
            $.each(allLine, function (key, tablerow) {
                var managertd = $(tablerow).find('.manager');
                var managerId = $(managertd).data('manager');

                // раставляем в tableRow соответствующих менагеров
                $(tablerow).attr('data-manager', managerId);
            });
        }
    </script>

    <script>
        let loadState = 0;
        var tableNums = [1];
        let loading_counter = 0;
        let loadedTable = {};
        loadedTable[1] = 1;

        $.each(tableNums, function (index, value) {
            //console.log('--- loadTable start ---');
            document.querySelector('.filter-btn').classList.add('disabled')
            document.querySelector('.import-excel').classList.add('disabled')
            localStorage.removeItem('arr_param_first')
            localStorage.removeItem('arr_param')
            var selector = ".infinite-list" + value;
            var listElm = document.querySelector(selector);
            var url = 'index.php?r=table/ajax-load' + value;
            // $(selector).html(''); // todo: ресет таблиц
            var limit = 5;
            var offset = 0;
            var maxrow = 60;
            var counter = 0;

            var loadMore = function () {
                document.querySelector('.spoilers-close').style.display = "none"
                document.querySelector('.spoilers-open').style.display = "none"
                if (offset < maxrow) {
                    //console.log('--- loadTable f.loadMore() ---');

                    fetch(`index.php?r=table/ajax-load` + value + `&offset=${offset}&limit=${limit}`).then(i => i.json()).then(i => {
                        //console.log('--- loadTable send request ---');

                        if (counter === 1) {
                            let data = i.header;
                            let headerdown = i.headerdown;
                            let target = document.createElement('tr');

                            let space = document.createElement("th");
                            space.className = "b-title";
                            space.classList.add('sticky');
                            space.style.minWidth = '189px'
                            space.innerHTML = 'Производитель';
                            space.setAttribute("rowspan", "4");
                            listElm.append(space);

                            let space2 = document.createElement('th');
                            space2.className = "b-title";
                            space2.classList.add('sticky-two');
                            space2.innerHTML = 'Маркетолог';
                            space2.setAttribute("rowspan", "4");
                            listElm.append(space2);
                            let count_i = 0;
                            data.forEach((e, index, arr) => {
                                let summary = 0;
                                let box = document.createElement('th');
                                box.classList.add('text-center');
                                box.classList.add('header-one');
                                box.innerHTML = e;

                                //создание cпойлера th
                                if (index != 0) {
                                    let now = box.querySelector('hr').getAttribute('data-manager');
                                    let prev_box = document.createElement('th');
                                    prev_box.innerHTML = arr[index - 1];
                                    let prev = prev_box.querySelector('hr').getAttribute('data-manager');
                                    if (now != prev) {
                                        let box2 = document.createElement('th');
                                        let manager_name = prev_box.childNodes[3].textContent;
                                        box2.classList.add(`toggle-th`);
                                        box2.setAttribute('data-sum', `${prev}_hidden`);
                                        box2.setAttribute('data_id', index + count_i);
                                        box2.innerHTML = manager_name;//
                                        box2.style.backgroundColor = "#c0efef";
                                        box2.style.textAlign = "center";
                                        box2.style.verticalAlign = "middle";
                                        box2.style.fontWeight = "500";
                                        count_i++;
                                        //суммирование чисел под th
                                        // let log = document.querySelector('.active')
                                        let log = listElm.querySelectorAll('.header-one');

                                        log.forEach((item) => {
                                            if ((box2.getAttribute('data-sum').split('_')[0]) == (item.querySelector('hr').getAttribute('data-manager'))) {
                                                let num;
                                                if (item.childNodes[5] == undefined) {
                                                    num = 0
                                                } else {
                                                    num = item.childNodes[5].textContent;
                                                }
                                                summary += Number(num);
                                                box2.innerHTML = `${manager_name}<br>${summary}`;
                                            }
                                        });
                                        listElm.append(box2);
                                    }
                                }
                                listElm.append(box);
                                box.setAttribute('data-id', index + count_i);
                                if (index == arr.length - 1) {
                                    let next_box = document.createElement('th');
                                    next_box.innerHTML = e;
                                    let next = next_box.querySelector('hr').getAttribute('data-manager')
                                    let manager_name = next_box.childNodes[3].textContent;
                                    next_box.classList.add(`toggle-th-last`);
                                    next_box.setAttribute('data-sum', `${next}_hidden`);
                                    next_box.setAttribute('data_id', index + count_i);
                                    next_box.innerHTML = manager_name;
                                    next_box.style.backgroundColor = "#c0efef";
                                    next_box.style.textAlign = 'center';
                                    next_box.style.fontWeight = '500';
                                    next_box.style.verticalAlign = 'middle';
                                    //суммирование чисел под th
                                    let log = listElm.querySelectorAll('.header-one');
                                    let summary = 0;
                                    log.forEach((item) => {
                                        if ((next_box.getAttribute('data-sum').split('_')[0]) == (item.querySelector('hr').getAttribute('data-manager'))) {
                                            let num;
                                            //console.log('sa', item)
                                            if (item.childNodes[5] == undefined) {
                                                num = 0
                                            } else {
                                                num = item.childNodes[5].textContent;
                                            }
                                            summary += Number(num);
                                            next_box.innerHTML = `${manager_name}<br>${summary}`;
                                        }
                                    });
                                    listElm.append(next_box);
                                    listElm.append(document.createElement('tr'))
                                    listElm.append(document.createElement('tr'))
                                }
                            });

                            listElm.append(target);
                        }

                        let data = i.results
                        let target = document.createElement('tr');
                        listElm.append(target);

                        data.forEach((e, index, arr) => {
                            let box = document.createElement('tr');
                            box.classList.add('manuf-liness');

                            box.innerHTML = e;

                            if (index != 0) {
                                let now = box.querySelector('.manager').getAttribute('data-manager');
                                let prev_box = document.createElement('tr');
                                prev_box.innerHTML = arr[index - 1];
                                let prev = prev_box.querySelector('.manager').getAttribute('data-manager')

                                if (now != prev) {
                                    let box2 = document.createElement('tr');
                                    let manager_name = $(prev_box).find('.manager').text();
                                    box2.classList.add(`toggle`);
                                    box2.setAttribute('data-sum', `${prev}_hidden`);
                                    box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'>" + manager_name + "</td></tr>";
                                    box2.childNodes[0].classList.add(`sticky`);
                                    box2.childNodes[1].classList.add(`sticky-two`);
                                    box2.querySelector("td").style.backgroundColor = "#c0efef";
                                    box2.querySelector("td").style.fontWeight = "500";
                                    listElm.append(box2);
                                }
                            }
                            if (index == 0 && localStorage.getItem('arr_param_first')) {
                                let now = box.querySelector('.manager').getAttribute('data-manager');
                                let arr_param = localStorage.getItem('arr_param_first');
                                let prev_box = document.createElement('tr');
                                prev_box.innerHTML = arr_param;
                                let prev = prev_box.querySelector('.manager').getAttribute('data-manager')
                                if (now != prev) {
                                    let box2 = document.createElement('tr');
                                    let manager_name = $(prev_box).find('.manager').text();

                                    box2.classList.add(`toggle`);
                                    box2.setAttribute('data-sum', `${prev}_hidden`);
                                    box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                    box2.childNodes[0].classList.add(`sticky`);
                                    box2.childNodes[1].classList.add(`sticky-two`);
                                    box2.querySelector("td").style.backgroundColor = "#c0efef";
                                    listElm.append(box2);

                                }
                            }
                            if (index == arr.length - 1 && selector == '.infinite-list1') {
                                localStorage.setItem('arr_param_first', e);
                                // console.log(index)
                                //console.log('local:', localStorage.getItem('arr_param'));
                            }

                            listElm.append(box);

                            // cоздание пустых ячеек под спойлером th
                            let link = listElm.querySelectorAll('.toggle-th');
                            link.forEach((el, index) => {
                                let el_id = el.getAttribute('data_id')
                                let el_id2 = Number(el_id) + 2;
                                let theFirstChild = box.childNodes[el_id2];
                                let newElement = document.createElement("td");
                                newElement.style.background = "#c0efef";
                                box.insertBefore(newElement, theFirstChild);
                            });

                        });

                        listElm.append(target);

                        loadMore();
                        createTableLine();

                        //console.log('--- loadTable finish (part), 1 ---');

                        // setTableSpoilers(listElm);
                        // setTableSpoilers2(listElm);
                    });
                }

                //console.log('--- loadTable finish (part), 2 ---');

                offset += limit;
                counter++;
            }
            loadMore();
            createTableLine();

            //console.log('--- loadTable finish ---');

            setTimeout(() => {
                //console.log('--- loadTable timeout (start) ---');

                if (localStorage.getItem('arr_param_first') && selector == '.infinite-list1') {
                    let arr_param = localStorage.getItem('arr_param_first');
                    let next_box = document.createElement('tr');
                    next_box.innerHTML = arr_param;
                    let arr = document.querySelectorAll('.manuf-liness')
                    let now = arr[arr.length - 1].querySelector('.manager').getAttribute('data-manager');

                    //    let manager_name = $(arr[arr.length - 1]).find('.manager').text();
                    let manager_name = next_box.querySelector('.manager').textContent;
                    next_box.classList.add(`toggle`);
                    next_box.setAttribute('data-sum', `${now}_hidden`);
                    next_box.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                    next_box.querySelector("td").style.fontWeight = "500";
                    next_box.childNodes[0].classList.add(`sticky`);
                    next_box.childNodes[1].classList.add(`sticky-two`);
                    next_box.querySelector("td").style.backgroundColor = "#c0efef";
                    listElm.append(next_box);
                    //console.log(value)
                    document.querySelector('.spoilers-close').style.display = "block"
                    document.querySelector('.spoilers-open').style.display = "block"
                }


                setTableSpoilers2(listElm);
                //console.log('--- loadTable f.setTableSpoilers2 - ok ---');

                setTableSpoilers(listElm);
                //console.log('--- loadTable f.setTableSpoilers - ok ---');

                hideSpoilers(listElm);
                //console.log('--- loadTable f.hideSpoilers - ok ---');

                document.querySelector('.filter-btn').classList.remove('disabled')
                document.querySelector('.import-excel').classList.remove('disabled')
                //console.log('--- loadTable timeout (finish) ---');
            }, 1000)
        });

    </script>

    <script>
        // доп таблицы
        function loadTable(value) {
            document.querySelector('.spoilers-close').style.display = "none"
            document.querySelector('.spoilers-open').style.display = "none"
            document.querySelector('.import-excel').classList.add('disabled')
            document.querySelector('.filter-btn').classList.add('disabled')
            localStorage.removeItem('arr_param');
            localStorage.removeItem('arr_param_first');
            var selector = ".infinite-list" + value;
            var listElm = document.querySelector(selector);
            var url = 'index.php?r=table/ajax-load' + value;

            var limit = 5;
            var offset = 0;

            if (value == 2) {
                var maxrow = 500; // todo: test - 60
            } else {
                var maxrow = 1;
            }

            var counter = 0;

            var loadMore = function () {

                if (offset < maxrow) {
                    fetch(`index.php?r=table/ajax-load` + value + `&offset=${offset}&limit=${limit}`).then(i => i.json()).then(i => {

                        if (counter === 1) {
                            let data = i.header;
                            let headerdown = i.headerdown;
                            let target = document.createElement('tr');

                            if (value === 1 || value === 2) {
                                let space = document.createElement("th");
                                space.className = "b-title text-center";
                                space.classList.add('sticky');
                                space.style.minWidth = '189px';
                                space.innerHTML = 'Производитель';
                                space.setAttribute("rowspan", "2");
                                listElm.append(space);

                                let space2 = document.createElement('th');
                                space2.className = "b-title text-center";
                                space2.classList.add('sticky-two');
                                space2.innerHTML = 'Маркетолог';
                                space2.setAttribute("rowspan", "2");
                                listElm.append(space2);
                            } else {
                                let space = document.createElement("th");
                                space.className = "b-title text-center";
                                space.classList.add('sticky');
                                space.style.minWidth = '278px';
                                space.innerHTML = 'Аптечная сеть';
                                space.setAttribute("rowspan", "2");
                                space.style.width = '20px';
                                listElm.append(space);

                                let space2 = document.createElement('th');
                                space2.className = "b-title text-center";
                                space2.classList.add('sticky-three');
                                space2.innerHTML = 'Менеджер';
                                space2.setAttribute("rowspan", "2");
                                listElm.append(space2);

                                let space3 = document.createElement('th');
                                space3.className = "b-title text-center";
                                space3.classList.add('sticky-four');
                                space3.innerHTML = 'Кол-во точек';
                                space3.setAttribute("rowspan", "2");
                                listElm.append(space3);

                                let space4 = document.createElement('th');
                                space4.className = "b-title text-center";
                                space4.classList.add('sticky-five');
                                space4.innerHTML = `Оборот АС`;
                                space4.setAttribute("rowspan", "2");
                                listElm.append(space4);

                                let space5 = document.createElement('th');                  // TODO: КОЛ-ВО ДОГОВОРОВ
                                space5.className = "b-title text-center";
                                space5.classList.add('sticky-six');
                                space5.classList.add('deadline-block')
                                space5.innerHTML = '<div class="deadline"><p>Дата постановки</p><hr><p>Дедлайн</p><hr><p>Производитель</p></div><p class="title">Кол-во<br>контрактов</p>';
                                space5.setAttribute("rowspan", "2");
                                listElm.append(space5);

                            }
                            let count_i = 0;

                            // e - во вкладках данные по шапке
                            data.forEach((e, index, arr) => {
                                let summary = 0;
                                let box = document.createElement('th');
                                box.classList.add('text-center');
                                box.classList.add('header-one');
                                box.classList.add('overme');
                                box.style.width = '140px'
                                box.innerHTML = e;


                                //     if (selector=='.infinite-list4' ||
                                //         selector=='.infinite-list6' ||
                                //         selector=='.infinite-list5' ||
                                //         selector=='.infinite-list3'
                                // ) {
                                //         if (index != 0) {
                                //             let now = box.childNodes[5].textContent;
                                //             let prev_box = document.createElement('th');
                                //             prev_box.innerHTML = arr[index - 1];
                                //             let prev = prev_box.childNodes[5].textContent;
                                //             if (now != prev) {
                                //                 let box2 = document.createElement('th');
                                //                 box2.classList.add(`toggle-th`);
                                //                 box2.setAttribute('data_id', index + count_i);
                                //                 box2.innerHTML = prev;
                                //                 box2.style.backgroundColor = "#c0efef";
                                //                 box2.style.textAlign = 'center';
                                //                 box2.style.fontWeight = '500';
                                //                 box2.style.verticalAlign = 'top';
                                //                 count_i++;
                                //                 listElm.append(box2);
                                //             }
                                //         }
                                //
                                //
                                //     } else {
                                //cоздание спойлеров th
                                if (index != 0) {
                                    let now = box.querySelector('hr').getAttribute('data-manager');
                                    let prev_box = document.createElement('th');
                                    prev_box.innerHTML = arr[index - 1];
                                    let prev = prev_box.querySelector('hr').getAttribute('data-manager')
                                    if (now != prev) {
                                        let box2 = document.createElement('th');
                                        let manager_name = prev_box.childNodes[3].textContent;

                                        box2.classList.add(`toggle-th`);
                                        box2.setAttribute('data-sum', `${prev}_hidden`);
                                        box2.setAttribute('data_id', index + count_i);
                                        box2.innerHTML = manager_name;
                                        box2.style.backgroundColor = "#c0efef";
                                        box2.style.textAlign = 'center';
                                        box2.style.fontWeight = '500';
                                        box2.style.verticalAlign = 'middle';
                                        count_i++;

                                        //суммирование чисел под th
                                        let log = document.querySelector('.show').querySelectorAll('.header-one');
                                        log.forEach((item) => {
                                            if ((box2.getAttribute('data-sum').split('_')[0]) == (item.querySelector('hr').getAttribute('data-manager'))) {
                                                let num = item.childNodes[5].textContent;

                                                summary += Number(num);
                                                box2.innerHTML = `${manager_name}<br>${summary}`;
                                            }
                                        });
                                        listElm.append(box2);
                                    }
                                }
                                // }
                                // 4 таблица


                                listElm.append(box);
                                box.setAttribute('data-id', index + count_i);
                                if (selector != '.infinite-list4' &&
                                    selector != '.infinite-list6' &&
                                    selector != '.infinite-list5' &&
                                    selector != '.infinite-list3'
                                ) {
                                    if (index == arr.length - 1) {
                                        //console.log('ss',selector)
                                        let next_box = document.createElement('th');
                                        next_box.innerHTML = e;
                                        let next = next_box.querySelector('hr').getAttribute('data-manager')
                                        let manager_name = next_box.childNodes[3].textContent;

                                        next_box.classList.add(`toggle-th-last`);
                                        next_box.setAttribute('data-sum', `${next}_hidden`);
                                        next_box.setAttribute('data_id', index + count_i);
                                        next_box.innerHTML = manager_name;
                                        next_box.style.backgroundColor = "#c0efef";
                                        next_box.style.textAlign = 'center';
                                        next_box.style.fontWeight = '500';
                                        next_box.style.verticalAlign = 'middle';
                                        //суммирование чисел под th
                                        let log = document.querySelector('.show').querySelectorAll('.header-one');
                                        let summary = 0;
                                        log.forEach((item) => {
                                            if ((next_box.getAttribute('data-sum').split('_')[0]) == (item.querySelector('hr').getAttribute('data-manager'))) {
                                                let num;
                                                //console.log('sa', item)
                                                if (item.childNodes[5] == undefined) {
                                                    num = 0
                                                } else {
                                                    num = item.childNodes[5].textContent;

                                                }
                                                summary += Number(num);
                                                next_box.innerHTML = `${manager_name}<br>${summary}`;
                                            }
                                        });
                                        listElm.append(next_box);
                                    }
                                } else {
                                    // if (index == arr.length - 1) {
                                    //     let next_box = document.createElement('th');
                                    //     next_box.innerHTML = e;
                                    //     let next = next_box.childNodes[5].textContent;
                                    //     console.log(next_box)
                                    //     next_box.classList.add(`toggle-th-last`);
                                    //     next_box.setAttribute('data_id', index + count_i);
                                    //     next_box.innerHTML = next;
                                    //     next_box.style.backgroundColor = "#c0efef";
                                    //     next_box.style.textAlign = 'center';
                                    //     next_box.style.fontWeight = '500';
                                    //     next_box.style.verticalAlign = 'top';
                                    //     //суммирование чисел под th
                                    //     listElm.append(next_box);
                                    // }
                                }
                            });

                            listElm.append(target);
                        }

                        // data.forEach(e => {
                        //     let box = document.createElement('tr');
                        //     box.innerHTML = e;
                        //     listElm.append(box);
                        // });

                        let data = i.results
                        let target = document.createElement('tr');


                        // e - во вкладках, строки
                        if (selector != '.infinite-list2') {
                            let dots = 0, as = 0, orders = 0;
                            data.forEach((e, index, arr) => {

                                let box = document.createElement('tr');
                                box.classList.add('manuf-line');

                                box.innerHTML = e;

                                if (index != 0) {
                                    let now = box.querySelector('.manager').getAttribute('data-manager');
                                    let prev_box = document.createElement('tr');
                                    prev_box.innerHTML = arr[index - 1];
                                    let prev = prev_box.querySelector('.manager').getAttribute('data-manager')

                                    if (now != prev) {
                                        let box2 = document.createElement('tr');
                                        let manager_name = $(prev_box).find('.manager').text();
                                        box2.classList.add(`toggle`);
                                        box2.setAttribute('data-sum', `${prev}_hidden`);
                                        if (value === 3 || value === 4 || value === 5 || value === 6 || value === 7) {
                                            as = as.toLocaleString()
                                            orders = orders.toLocaleString()
                                            box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td>" +
                                                "<td style='background-color: #c0efef'>" + dots + "</td>" +
                                                "<td style='background-color: #c0efef'>" + as + "</td>" +
                                                "<td style='background-color: #c0efef'>" + orders + "</td>" +
                                                "</tr>";
                                        } else {
                                            box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                        }

                                        dots = 0;
                                        as = 0;
                                        orders = 0;

                                        if (selector == '.infinite-list4' ||
                                            selector == '.infinite-list6' ||
                                            selector == '.infinite-list5' ||
                                            selector == '.infinite-list3'
                                        ) {
                                            box2.childNodes[0].classList.add(`sticky`);
                                            box2.childNodes[1].classList.add(`sticky-three`);
                                            box2.childNodes[2].classList.add(`sticky-four`);
                                            box2.childNodes[3].classList.add(`sticky-five`);
                                            box2.childNodes[4].classList.add(`sticky-six`);
                                        } else {
                                            box2.childNodes[0].classList.add(`sticky`);
                                            box2.childNodes[1].classList.add(`sticky-two`);
                                        }
                                        box2.querySelector("td").style.backgroundColor = "#c0efef";
                                        listElm.append(box2);
                                    }
                                }
                                let child2 = +box.childNodes[2].innerHTML;
                                let child3 = +box.childNodes[3].innerHTML;
                                let child4 = +box.childNodes[4].innerHTML;
                                dots = dots + child2;
                                as = as + child3;
                                orders = orders + child4;
                                box.childNodes[3].innerHTML = child3.toLocaleString()
                                box.childNodes[4].innerHTML = child4.toLocaleString()

                                listElm.append(box);
                                if (index == arr.length - 1) {
                                    let now = box.querySelector('.manager').getAttribute('data-manager');
                                    let next_box = document.createElement('tr');
                                    next_box.innerHTML = box.innerHTML;
                                    let manager_name = $(box).find('.manager').text();
                                    next_box.classList.add(`toggle`);
                                    next_box.setAttribute('data-sum', `${now}_hidden`);
                                    if (value === 3 || value === 4 || value === 5 || value === 6 || value === 7) {
                                        as = as.toLocaleString()
                                        orders = orders.toLocaleString()
                                        next_box.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td>" +
                                            "<td style='background-color: #c0efef'>" + dots + "</td>" +
                                            "<td style='background-color: #c0efef'>" + as + "</td>" +
                                            "<td style='background-color: #c0efef'>" + orders + "</td>" +
                                            "</tr>";
                                    } else {
                                        next_box.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                    }
                                    next_box.querySelector("td").style.backgroundColor = "#c0efef";

                                    dots = 0;
                                    as = 0;
                                    orders = 0;

                                    // if (selector == '.infinite-list4'||
                                    //     selector=='.infinite-list6' ||
                                    //     selector=='.infinite-list5' ||
                                    //     selector=='.infinite-list3'
                                    // ) {
                                    //     next_box.childNodes[0].classList.add(`sticky`);
                                    //     next_box.childNodes[1].classList.add(`sticky-three`);
                                    //     listElm.append(next_box);
                                    //     next_box.childNodes[2].classList.add(`sticky-four`);
                                    //  } else{
                                    next_box.childNodes[0].classList.add(`sticky`);
                                    next_box.childNodes[1].classList.add(`sticky-two`);
                                    listElm.append(next_box);
                                    // }


                                }

                                //
                                //     if (selector == '.infinite-list4'||
                                //         selector=='.infinite-list6' ||
                                //         selector=='.infinite-list5' ||
                                //         selector=='.infinite-list3'
                                //     ) {
                                //         let link = listElm.querySelectorAll('.toggle-th');
                                //         link.forEach((el, index) => {
                                //             let el_id = el.getAttribute('data_id')
                                //             let el_id2 = Number(el_id) + 4;
                                //             let theFirstChild = box.childNodes[el_id2];
                                //             let newElement = document.createElement("td");
                                //             newElement.style.background = "#c0efef"; // ЦВЕТ - строка с глюком создания лишних колонок
                                //             box.insertBefore(newElement, theFirstChild);
                                //         });
                                //         let last=listElm.querySelector('.toggle-th-last')
                                //         let el_id = last.getAttribute('data_id')
                                //         let el_id2 = Number(el_id) + 5;
                                //         let theFirstChild = box.childNodes[el_id2];
                                //         let newElement = document.createElement("td");
                                //         newElement.style.background = "#c0efef"; // ЦВЕТ - строка с глюком создания лишних колонок
                                //         box.insertBefore(newElement, theFirstChild);
                                // } else {
                                //cоздание пустых ячеек под спойлером th
                                let link = listElm.querySelectorAll('.toggle-th');
                                link.forEach((el, index) => {
                                    let el_id = el.getAttribute('data_id')
                                    let el_id2 = Number(el_id) + 2;
                                    let theFirstChild = box.childNodes[el_id2];
                                    let newElement = document.createElement("td");
                                    newElement.style.background = "#c0efef"; // ЦВЕТ - строка с глюком создания лишних колонок
                                    box.insertBefore(newElement, theFirstChild);

                                });

                                // }
                            });
                        } else {

                            data.forEach((e, index, arr) => {
                                let box = document.createElement('tr');
                                box.classList.add('manuf-line');
                                box.innerHTML = e;
                                if (index != 0) {
                                    let now = box.querySelector('.manager').getAttribute('data-manager');
                                    let prev_box = document.createElement('tr');
                                    prev_box.innerHTML = arr[index - 1];
                                    let prev = prev_box.querySelector('.manager').getAttribute('data-manager')

                                    if (now != prev) {
                                        let box2 = document.createElement('tr');
                                        let manager_name = $(prev_box).find('.manager').text();
                                        box2.classList.add(`toggle`);
                                        box2.setAttribute('data-sum', `${prev}_hidden`);
                                        box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                        box2.childNodes[0].classList.add(`sticky`);
                                        box2.childNodes[1].classList.add(`sticky-two`);
                                        box2.querySelector("td").style.backgroundColor = "#c0efef";
                                        listElm.append(box2);
                                    }
                                }

                                if (index == 0 && localStorage.getItem('arr_param')) {
                                    let now = box.querySelector('.manager').getAttribute('data-manager');
                                    let arr_param = localStorage.getItem('arr_param');
                                    let prev_box = document.createElement('tr');
                                    prev_box.innerHTML = arr_param;
                                    let prev = prev_box.querySelector('.manager').getAttribute('data-manager')
                                    if (now != prev) {
                                        let box2 = document.createElement('tr');
                                        let manager_name = $(prev_box).find('.manager').text();
                                        box2.classList.add(`toggle`);
                                        box2.setAttribute('data-sum', `${prev}_hidden`);
                                        box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                        box2.childNodes[0].classList.add(`sticky`);
                                        box2.childNodes[1].classList.add(`sticky-two`);
                                        box2.querySelector("td").style.backgroundColor = "#c0efef";
                                        listElm.append(box2);
                                    }
                                }
                                if (index == arr.length - 1) {
                                    localStorage.setItem('arr_param', e)
                                }
                                listElm.append(box);

                                //cоздание пустых ячеек под спойлером th
                                let link = listElm.querySelectorAll('.toggle-th');
                                link.forEach((el, index) => {
                                    let el_id = el.getAttribute('data_id')
                                    let el_id2 = Number(el_id) + 2;
                                    let theFirstChild = box.childNodes[el_id2];
                                    let newElement = document.createElement("td");
                                    newElement.style.background = "#c0efef"; // ЦВЕТ - строка с глюком создания лишних колонок
                                    box.insertBefore(newElement, theFirstChild);
                                });
                            });
                        }

                        //    listElm.append(target);

                        loadMore();
                        createTableLine();

                        // setTableSpoilers(listElm);
                        // setTableSpoilers2(listElm);

                        hideRepeated();
                        if (value != 2) {
                            getTasksAjax(value, 0, 0);


                        }


                    });

                }

                offset += limit;
                counter++;
            }

            loadMore();
            createTableLine();

            // setTableSpoilers();
            // setTableSpoilers(listElm);

            setTimeout(() => {
                if (localStorage.getItem('arr_param') && selector == '.infinite-list2') {
                    let arr_param = localStorage.getItem('arr_param');
                    let next_box = document.createElement('tr');
                    next_box.innerHTML = arr_param;
                    let arr = document.querySelectorAll('.manuf-line')
                    let now = arr[arr.length - 1].querySelector('.manager').getAttribute('data-manager');
                    //    let manager_name = $(arr[arr.length - 1]).find('.manager').text();
                    let manager_name = next_box.querySelector('.manager').textContent;
                    next_box.classList.add(`toggle`);
                    next_box.setAttribute('data-sum', `${now}_hidden`);
                    next_box.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                    next_box.querySelector("td").style.fontWeight = "500";
                    next_box.childNodes[0].classList.add(`sticky`);
                    if (selector == '.infinite-list2') {
                        next_box.childNodes[1].classList.add(`sticky-two`);
                    } else {
                        next_box.childNodes[1].classList.add(`sticky-three`);
                    }
                    next_box.querySelector("td").style.backgroundColor = "#c0efef";
                    listElm.append(next_box);
                    document.querySelector('.spoilers-close').style.display = "block"
                    document.querySelector('.spoilers-open').style.display = "block"

                }
                localStorage.removeItem('arr_param')
                setTableSpoilers2(listElm);
                setTableSpoilers(listElm);
                hideSpoilers(listElm)
                document.querySelector('.filter-btn').classList.remove('disabled')
                document.querySelector('.import-excel').classList.remove('disabled')
                //   getTasksAjax(value);
            }, 1000);

        }


        $(document).on("click", ".nav-link", function () {
            var value = $(this).data('value');
//             loadTable(value);

            // ресет таблиц

            if (!loadedTable[value]) {
                loadTable(value);
                loadedTable[value] = value;
            }


            lockScreen();

        });
    </script>

    <script>
        $(document).on("click", ".get-task-modal", function () {
            var manid = $(this).data('manid');
            var pnid = $(this).data('pnid');
            var tab = $(this).data('tab');
            var taskid = $(this).data('taskid');

            $.get("index.php?r=table/get-order-data-in-modal", {
                manid, pnid, tab, taskid,
            }, function (res) {
                $('.task-modal').html(res);
                $('#order-data-modal').modal('show');
            });
        });

        $(document).on("click", ".get-task-modal-by-id", function () {
            var id = $(this).data('id');

            $.get("index.php?r=table/get-order-data-in-modal-by-id", {
                id,
            }, function (res) {
                $('.task-modal').html(res);
                $('#order-data-modal').modal('show');
            });
        });
    </script>
    <script>
        $(document).on("click", ".get-manuf-modal", function () {
            var manid = $(this).data('manid');

            $.get("index.php?r=table/get-manuf-modal", {manid}, function (res) {
                $('.task-modal').html(res);
                $('#order-data-modal').modal('show');
            });
        });

        $(document).on("click", ".get-as-modal", function () {
            var manid = $(this).data('manid');

            $.get("index.php?r=table/get-as-modal", {manid}, function (res) {
                $('.task-modal').html(res);
                $('#order-data-modal').modal('show');
            });
        });

        $(document).on("click", ".edit-group", function () {
            var manid = $(this).data('manid');
            var type = $(this).data('type');
            var taskid = $(this).data('taskid');

            $.get("index.php?r=table/get-edit-group-modal", {manid, type, taskid}, function (res) {
                $('.task-modal').html(res);
                $('#order-data-modal').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                //    $(' .header-one:first').before('<tr>');
                //   $(' .header-one:last').after('</tr><tr>');
            }, 1000);
        });
    </script>
    <script>
        $(document).on("click", ".close-modal-btn", function () {
            $('#order-data-modal').modal('hide');
        });
    </script>

    <script src="assets/js/select/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/js/select/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/select/prism.js" type="text/javascript" charset="utf-8"></script>
    <script src="assets/js/select/init.js" type="text/javascript" charset="utf-8"></script>

    <script>
        function getContent() {
            var allFilters = $('.chosen-select');
            var arr = [];
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);

            $(currentTab).html("Подготовка данных...");
            $(currentTab).addClass("block-scroll");

            $.each(allFilters, function (index, value) {
                var t = $(value).data('type');
                var v = $(value).val();
                arr.push([t, v]);
            });

            $.get("index.php?r=ajax-table", {arr}, function (res) {
                $(currentTab).html(res);
            });


            // находим выбранные параметры фильтрации
            var allFilters = $('.chosen-select');
            var arr = [];
            let datacount = 0;

            // пересобираем массив в удобном виде
            $.each(allFilters, function (index, value) {
                var t = $(value).data('type');
                var v = $(value).val();
                arr.push([t, v]);

                if (v.length == 0) {
                    datacount++;
                }
            });

            // сброс результатов фильтрации
            if (datacount == 4) {
                window.location.reload();
            }

            // скрываем производителей
            // $.each($('.get-manuf-modal'), function (index, value) {
            //     $(value).parent().parent().hide();
            // });

            // скрываем АС TODO
            // $.each($('.header-one'), function (index, value) {
            //     var t = parseInt($(value).index());
            //     $('th:nth-child(' + t + '),td:nth-child(' + t + ')').hide();
            // });

            // // открываем запрошенных производителей
            // $.each(arr[2][1], function (index, value) {
            //     var manuf = $('.get-manuf-modal[data-manid="' + value + '"]');
            //     $(manuf).parent().parent().show();
            // });
            //
            // // открываем запрошенные АС
            // $.each(arr[3][1], function (index, value) {
            //     var as = $('.get-as-modal[data-manid="' + value + '"]');
            //     var crcol = $(as).parent();
            //     var t = parseInt($(crcol).index());
            //     $('th:nth-child(' + t + '),td:nth-child(' + t + ')').show();
            // });
        }


        function filterMarketers() {
            //console.log('mar')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.marketers').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })

            let marketers_all = [];
            if (tabnum == 1) {
                marketers_all = currentTab[0].querySelectorAll('.manuf-liness');
            } else {
                marketers_all = currentTab[0].querySelectorAll('.manuf-line');
            }
            let marketers = [];

            marketers_all.forEach(mark => {

                if (mark.style.display != 'none') {
                    marketers.push(mark)
                }

            })

            //console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    //console.log('в фильтре', el2)
                    marketers_all.forEach(el3 => {
                        if (el3.childNodes[1].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
                marketers.forEach(el => {
                    el.style.removeProperty('display')

                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers.forEach(el3 => {
                        if (el3.childNodes[1].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')
            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            if (el.style.display != 'none') {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el6 => {
                            if (el5.firstChild.innerText == el6.childNodes[1].innerText) {
                                el6.style.display = 'none'
                            }
                        })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {

                    let manuf = document.querySelector('.marketers').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                        filterManufacturers();
                    } else {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                    }
                }
            }, 500)
            // else {
            //     chosen_result.forEach(el5 => {
            //         let del_marketers=[]
            //         el5.lastChild.addEventListener('click', () => {
            //             currentTab[0].querySelectorAll('.toggle').forEach(el=>{
            //                 console.log(el)
            //             })
            //             marketers_all.forEach(el=>{
            //                 el.style.display='none'
            //             })
            //         })
            //     })
            // }

        }

        function filterMarketers2() {
            console.log('mar2')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.marketers').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })
            console.log(chosen_text)
            let marketers_th = currentTab[0].querySelectorAll('.header-one');
            let marketers_td = currentTab[0].querySelectorAll('.manuf-line');
            let marketers_all = [];

            marketers_th.forEach((mark) => {
                let el_id = mark.getAttribute('data-id')
                let el_id2 = Number(el_id) + 5;

                let marketers_row = [];
                marketers_td.forEach((el2, index) => {
                    let num_child = el2.childNodes[el_id2];

                    marketers_row.push(num_child);
                    if (index == marketers_td.length - 1) {
                        marketers_row.push(mark);
                    }
                })

                marketers_all.push(marketers_row)
            });
            let marketers = [];

            marketers_all.forEach(mark => {
                let nonhide;
                mark.forEach(el => {
                    if (el.style.display != 'none')
                        nonhide = 1;
                })
                if (nonhide) {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.display = 'none'
                    })

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers_all.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[5].innerText


                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
                marketers.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.removeProperty('display')
                    })
                    console.log(el)
                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.forEach(el2 => {

                        el2.style.display = 'none'
                    })
                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[5].innerText

                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            let nonhidden;
                            el.forEach(el2 => {
                                if (el2.style.display != 'none')
                                    nonhidden = 1;
                            })
                            if (nonhidden) {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el3 => {
                            let th = el3[el3.length - 1].childNodes[5].innerText
                            if (th == el5.firstChild.innerText) {

                                el3.forEach(el4 => {

                                    el4.style.display = 'none'
                                })
                            }
                        })
                        // del_marketers.forEach(el6 => {
                        //
                        //     if (el5.firstChild.innerText == el6.childNodes[0].innerText) {
                        //         el6.style.display = 'none'
                        //     }
                        // })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    marketers_all.forEach(el => {
                        el.forEach(el2 => {
                            el2.style.removeProperty('display')
                        })

                    })
                    let manuf = document.querySelector('.manufacturers').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        filterManufacturers2();
                    }
                }
            }, 500)
        }

        function filterManufacturers() {

            console.log('maf')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.manufacturers').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })
            let marketers_all = [];
            if (tabnum == 1) {
                marketers_all = currentTab[0].querySelectorAll('.manuf-liness');
            } else {
                marketers_all = currentTab[0].querySelectorAll('.manuf-line');
            }

            let marketers = [];

            marketers_all.forEach(mark => {

                if (mark.style.display != 'none') {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers_all.forEach(el3 => {
                        if (el3.childNodes[0].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
                marketers.forEach(el => {
                    el.style.removeProperty('display')

                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers.forEach(el3 => {
                        if (el3.childNodes[0].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            if (el.style.display != 'none') {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el6 => {
                            if (el5.firstChild.innerText == el6.childNodes[0].innerText) {
                                el6.style.display = 'none'
                            }
                        })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    console.log('xbcnbv');
                    let manuf = document.querySelector('.manufacturers').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                        filterMarketers();
                    } else {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                    }
                }
            }, 500)
        }

        function filterManufacturers2() {
            console.log('muf2')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.manufacturers').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })
            console.log(chosen_text)
            let marketers_th = currentTab[0].querySelectorAll('.header-one');
            let marketers_td = currentTab[0].querySelectorAll('.manuf-line');
            let marketers_all = [];

            marketers_th.forEach((mark) => {
                let el_id = mark.getAttribute('data-id')
                let el_id2 = Number(el_id) + 5;

                let marketers_row = [];
                marketers_td.forEach((el2, index) => {
                    let num_child = el2.childNodes[el_id2];

                    marketers_row.push(num_child);
                    if (index == marketers_td.length - 1) {
                        marketers_row.push(mark);
                    }
                })

                marketers_all.push(marketers_row)
            });
            let marketers = [];

            marketers_all.forEach(mark => {
                let nonhide;
                mark.forEach(el => {
                    if (el.style.display != 'none')
                        nonhide = 1;
                })
                if (nonhide) {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.display = 'none'
                    })

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers_all.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[2].innerText


                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
                marketers.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.removeProperty('display')
                    })
                    console.log(el)
                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.forEach(el2 => {

                        el2.style.display = 'none'
                    })
                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[2].innerText

                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            let nonhidden;
                            el.forEach(el2 => {
                                if (el2.style.display != 'none')
                                    nonhidden = 1;
                            })
                            if (nonhidden) {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el3 => {
                            let th = el3[el3.length - 1].childNodes[2].innerText
                            if (th == el5.firstChild.innerText) {

                                el3.forEach(el4 => {

                                    el4.style.display = 'none'
                                })
                            }
                        })
                        // del_marketers.forEach(el6 => {
                        //
                        //     if (el5.firstChild.innerText == el6.childNodes[0].innerText) {
                        //         el6.style.display = 'none'
                        //     }
                        // })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    marketers_all.forEach(el => {
                        el.forEach(el2 => {
                            el2.style.removeProperty('display')
                        })

                    })
                    let manuf = document.querySelector('.marketers').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        filterMarketers2();
                    }
                }
            }, 500)
        }

        function filterManagers() {

            console.log('mam')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.managers').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })

            let marketers_th = currentTab[0].querySelectorAll('.header-one');
            let marketers_td = [];
            if (tabnum == 1) {
                marketers_td = currentTab[0].querySelectorAll('.manuf-liness');
            } else {
                marketers_td = currentTab[0].querySelectorAll('.manuf-line');
            }

            let marketers_all = [];

            marketers_th.forEach((mark) => {
                let el_id = mark.getAttribute('data-id')
                let el_id2 = Number(el_id) + 2;

                let marketers_row = [];
                marketers_td.forEach((el2, index) => {
                    let num_child = el2.childNodes[el_id2];

                    marketers_row.push(num_child);
                    if (index == marketers_td.length - 1) {
                        marketers_row.push(mark);
                    }
                })

                marketers_all.push(marketers_row)
            });
            let marketers = [];

            marketers_all.forEach(mark => {
                let nonhide;
                mark.forEach(el => {
                    if (el.style.display != 'none')
                        nonhide = 1;
                })
                if (nonhide) {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.display = 'none'
                    })

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers_all.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[3].innerText

                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
                marketers.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.removeProperty('display')
                    })
                    console.log(el)
                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.forEach(el2 => {

                        el2.style.display = 'none'
                    })
                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[3].innerText

                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            let nonhidden;
                            el.forEach(el2 => {
                                if (el2.style.display != 'none')
                                    nonhidden = 1;
                            })
                            if (nonhidden) {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el3 => {
                            let th = el3[el3.length - 1].childNodes[3].innerText
                            if (th == el5.firstChild.innerText) {

                                el3.forEach(el4 => {

                                    el4.style.display = 'none'
                                })
                            }
                        })
                        // del_marketers.forEach(el6 => {
                        //
                        //     if (el5.firstChild.innerText == el6.childNodes[0].innerText) {
                        //         el6.style.display = 'none'
                        //     }
                        // })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    marketers_all.forEach(el => {
                        el.forEach(el2 => {
                            el2.style.removeProperty('display')
                        })

                    })
                    let manuf = document.querySelector('.pharm-networks').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        filterPharm();
                    }
                }
            }, 500)

        }

        function filterManagers2() {

            console.log('man2')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.managers').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })
            let marketers_all = currentTab[0].querySelectorAll('.manuf-line');


            let marketers = [];

            marketers_all.forEach(mark => {

                if (mark.style.display != 'none') {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers_all.forEach(el3 => {
                        if (el3.childNodes[1].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
                marketers.forEach(el => {
                    el.style.removeProperty('display')

                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers.forEach(el3 => {
                        if (el3.childNodes[1].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            if (el.style.display != 'none') {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el6 => {
                            if (el5.firstChild.innerText == el6.childNodes[1].innerText) {
                                el6.style.display = 'none'
                            }
                        })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    let manuf = document.querySelector('.managers').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                        filterPharm2();
                    } else {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                    }
                }
            }, 500)

        }

        function filterPharm() {

            console.log('mam')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.pharm_networks').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })

            let marketers_th = currentTab[0].querySelectorAll('.header-one');
            let marketers_td = [];
            if (tabnum == 1) {
                marketers_td = currentTab[0].querySelectorAll('.manuf-liness');
            } else {
                marketers_td = currentTab[0].querySelectorAll('.manuf-line');
            }
            let marketers_all = [];

            marketers_th.forEach((mark) => {
                let el_id = mark.getAttribute('data-id')
                let el_id2 = Number(el_id) + 2;

                let marketers_row = [];
                marketers_td.forEach((el2, index) => {
                    let num_child = el2.childNodes[el_id2];

                    marketers_row.push(num_child);
                    if (index == marketers_td.length - 1) {
                        marketers_row.push(mark);
                    }
                })

                marketers_all.push(marketers_row)
            });
            let marketers = [];

            marketers_all.forEach(mark => {
                let nonhide;
                mark.forEach(el => {
                    if (el.style.display != 'none')
                        nonhide = 1;
                })
                if (nonhide) {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.display = 'none'
                    })

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers_all.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[0].querySelector('span').title

                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
                marketers.forEach(el => {
                    el.forEach(el2 => {
                        el2.style.removeProperty('display')
                    })
                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.forEach(el2 => {

                        el2.style.display = 'none'
                    })
                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)

                    marketers.forEach(el3 => {
                        let th = el3[el3.length - 1].childNodes[0].querySelector('span').title
                        console.log(el3[el3.length - 1].childNodes[0].querySelector('span').title)
                        if (th == el2) {

                            el3.forEach(el4 => {

                                el4.style.removeProperty('display')
                            })
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            let nonhidden;
                            el.forEach(el2 => {
                                if (el2.style.display != 'none')
                                    nonhidden = 1;
                            })
                            if (nonhidden) {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el3 => {
                            let th = el3[el3.length - 1].childNodes[0].querySelector('span').title
                            if (th == el5.firstChild.innerText) {

                                el3.forEach(el4 => {

                                    el4.style.display = 'none'
                                })
                            }
                        })
                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    marketers_all.forEach(el => {
                        el.forEach(el2 => {
                            el2.style.removeProperty('display')
                        })

                    })
                    let manuf = document.querySelector('.managers').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        filterManagers();
                    }
                }
            }, 500)
        }

        function filterPharm2() {

            console.log('mfa2')
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let actual_arr = [];
            // currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
            //     el.style.display = 'none'
            // })
            let list_chosen_all = document.querySelector('.pharm_networks').parentNode
            let list_chosen = list_chosen_all.querySelector('.chosen-choices');
            let chosen_options = list_chosen.querySelectorAll('.search-choice')
            let chosen_text = [];
            chosen_options.forEach((el4) => {
                chosen_text.push(el4.firstChild.textContent)
            })
            let marketers_all = currentTab[0].querySelectorAll('.manuf-line');


            let marketers = [];

            marketers_all.forEach(mark => {

                if (mark.style.display != 'none') {
                    marketers.push(mark)
                }

            })
            console.log(marketers_all, marketers)
            if (chosen_text.length > 1) {
                marketers_all.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers_all.forEach(el3 => {
                        if (el3.childNodes[0].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
                marketers.forEach(el => {
                    el.style.removeProperty('display')

                })
            }
            if (chosen_text.length == 1) {
                marketers.forEach(el => {
                    el.style.display = 'none'

                })
                chosen_text.forEach(el2 => {
                    console.log('в фильтре', el2)
                    marketers.forEach(el3 => {
                        if (el3.childNodes[0].innerText == el2) {
                            el3.style.removeProperty('display')
                        }
                    })
                })
            }
            let chosen_result = list_chosen.querySelectorAll('.search-choice')

            if (chosen_result.length != 0) {
                chosen_result.forEach(el5 => {
                    el5.lastChild.addEventListener('click', () => {
                        let del_marketers = [];
                        marketers_all.forEach((el) => {
                            if (el.style.display != 'none') {
                                del_marketers.push(el)
                            }
                        })
                        del_marketers.forEach(el6 => {
                            if (el5.firstChild.innerText == el6.childNodes[0].innerText) {
                                el6.style.display = 'none'
                            }
                        })

                    })
                })
            }
            setTimeout(() => {
                let chosen_result = list_chosen.querySelectorAll('.search-choice')
                if (chosen_result.length == 0) {
                    console.log('xbcnbv');
                    let manuf = document.querySelector('.pharm_networks').parentNode.querySelector('.chosen-choices').querySelector('.search-field')
                    console.log(manuf)
                    if (manuf) {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                        filterManagers2();
                    } else {
                        marketers_all.forEach(el => {
                            el.style.removeProperty('display')
                        })
                    }
                }
            }, 500)

        }

        function filterStart() {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let tasks_date;
            if (tabnum == 1 || tabnum == 2) {
                tasks_date = currentTab[0].querySelectorAll('.get-task-modal');
            } else {
                tasks_date = currentTab[0].querySelectorAll('.task-area');
            }
            let from_date = document.querySelector('.start-date_from').value;
            let to_date = document.querySelector('.start-date_to').value;
            let n_to_date;
            if (!to_date) {
                n_to_date = '2098-12-16'
                to_date = n_to_date;
            }

            if (!from_date) {
                from_date = '1972-03-12'
            }
            if (from_date < to_date) {
                // console.log(tasks_date);
                tasks_date.forEach(el => {
                    if (el.getAttribute('data-d_create')) {
                        let task_date = el.getAttribute('data-d_create');
                        let date_format = task_date.split(' ');
                        if (date_format[0] < from_date || date_format[0] > to_date) {
                            el.style.pointerEvents = "none"
                            if (tabnum == 1 || tabnum == 2) {
                                el.classList.add('color-8')
                                el.style.color = '#f5acde'

                            } else {
                                el.classList.add('back-white')
                                el.style.color = '#fff';

                            }

                        } else {
                            el.style.removeProperty('pointer-events')
                            if (tabnum == 1 || tabnum == 2) {
                                el.classList.remove('color-8');
                                el.style.removeProperty('color')

                            } else {
                                el.classList.remove('back-white')
                                el.style.removeProperty('color')

                            }
                        }
                    }
                })
            } else {
                alert('Дата дедлайна раньше даты старта')
                document.querySelector('.start-date_from').value = ''
                document.querySelector('.start-date_to').value = ''
                tasks_date.forEach(el => {
                    el.style.removeProperty('pointer-events')
                    if (tabnum == 1 || tabnum == 2) {
                        el.classList.remove('color-8')
                    } else {
                        el.classList.remove('back-white')
                    }

                })
            }

        }

        function filterEnd() {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            let tasks_date;
            if (tabnum == 1 || tabnum == 2) {
                tasks_date = currentTab[0].querySelectorAll('.get-task-modal');
            } else {
                tasks_date = currentTab[0].querySelectorAll('.task-area');
            }
            let from_date = document.querySelector('.end-date_from').value;
            let to_date = document.querySelector('.end-date_to').value;
            let n_to_date;
            if (!to_date) {
                n_to_date = '2098-12-16'
                to_date = n_to_date;
            }

            if (!from_date) {
                from_date = '1972-03-12'
            }
            console.log(from_date, to_date)
            if (from_date < to_date) {
                console.log('from_date < to_date', from_date < to_date)
                tasks_date.forEach(el => {
                    console.log('task_date', el)
                    if (el.getAttribute('data-d_deadline')) {
                        console.log('deadline', el.getAttribute('data-d_deadline'))
                        let task_date = el.getAttribute('data-d_deadline');
                        let date_format = task_date.split(' ');
                        console.log('date_format', date_format)
                        if (date_format[0] < from_date || date_format[0] > to_date) {
                            el.style.pointerEvents = "none"
                            if (tabnum == 1 || tabnum == 2) {
                                el.classList.add('color-8')
                                el.style.color = '#f5acde'

                            } else {
                                el.classList.add('back-white')
                                el.style.color = 'fff'

                            }

                        } else {
                            el.style.removeProperty('pointer-events')
                            if (tabnum == 1 || tabnum == 2) {
                                el.classList.remove('color-8')
                                el.style.removeProperty('color')
                            } else {
                                el.classList.remove('back-white')
                                el.style.removeProperty('color')
                            }
                        }
                    }
                })
            } else {
                alert('Дата дедлайна раньше даты старта')
                document.querySelector('.start-date_from').value = ''
                document.querySelector('.start-date_to').value = ''
                tasks_date.forEach(el => {
                    el.style.removeProperty('pointer-events')
                    if (tabnum == 1 || tabnum == 2) {
                        el.classList.remove('color-8')
                    } else {
                        el.classList.remove('back-white')
                    }

                })
            }

        }

        // $('#datefilterfrom').on("change", filterRows);
        // $('#datefilterto').on("change", filterRows);
        $('.marketers').on("change", () => {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);


            if (tabnum == 1 || tabnum == 2) {
                filterMarketers()
            } else {

                filterMarketers2()
            }

        });
        $('.manufacturers').on("change", () => {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            if (tabnum == 1 || tabnum == 2) {
                filterManufacturers()
            } else {

                filterManufacturers2()
            }
        });
        $('.managers').on("change", () => {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            if (tabnum == 1 || tabnum == 2) {
                filterManagers()
            } else {
                filterManagers2()
            }
        });
        $('.pharm_networks').on("change", () => {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            if (tabnum == 1 || tabnum == 2) {
                filterPharm()
            } else {
                filterPharm2()
            }
        });
        $('.start-date_from').on("change", () => {
            filterStart()
        });
        $('.start-date_to').on("change", () => {
            filterStart()
        });
        $('.end-date_from').on("change", () => {
            filterEnd()
        });
        $('.end-date_to').on("change", () => {
            filterEnd()
        });


    </script>

    <script>
        // сброс фильтров
        $(document).on("click", ".reset-filters", function () {
            $('.chosen-select').val([]).trigger('chosen:updated');

            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);

            $(currentTab).html('');

            setTimeout(function () {
                //getContent();
                loadTable(tabnum);
            }, 1000);

            $.each($('.get-manuf-modal'), function (index, value) {
                $('.chosen-select').val([]).trigger('chosen:updated');
                $(value).parent().parent().show();
            });
        });
    </script>

    <script>
        // загрузка файлов через ajax
        $(document).on("click", ".load-file", function () {
            var file_data = $('.file-input').prop('files')[0];
            var type = $(this).data('type');
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('task-id', $(this).data('id'));
            form_data.append('type', type);

            $.ajax({
                url: 'index.php?r=ajax-load-file',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (res) {
                    var resdata = jQuery.parseJSON(res);

                    if (resdata.fileName != null) {
                        $('.filediv').append("<a href='" + resdata.filePath + "'>" + resdata.fileName + "</a><br>");
                    }
                }
            });
        });
    </script>

    <script>
        $(document).on("click", ".del-file", function () {
            var id = $(this).data('id');
            var filegroup = $(this).parent('.filegroup');

            $.get("index.php?r=ajax/file-delete", {id}, function (res) {
                $(filegroup).hide();
            });
        });
    </script>

    <script>
        // комментирование по нажатию кнопки "отправить" (устарел)
        // $(document).on("click", ".mt-send-comment-btn", function () {
        //     var taskid = $('#mt-task-id').val();
        //     var comment = $('.comment-area').val();
        //
        //     $.get("index.php?r=ajax/add-task-comment", {taskid, comment}, function (res) {
        //         $('#comments-list').html(res);
        //         $('.comment-area').val('');
        //     });
        // });

        // комментирование по нажатию enter
        $(window).on('keydown', function (e) {
            if (e.which === 13) {
                var taskid = $('#mt-task-id').val();
                var comment = $('.comment-area').val();

                if (comment) {
                    $.get("index.php?r=ajax/add-task-comment", {taskid, comment}, function (res) {
                        $('#comments-list').html(res);
                        $('.comment-area').val('');
                    });
                }
            }
        });
    </script>

    <script>
        // кнопки актив/неактив/потенц
        $(document).on("click", ".status-btn", function () {
            var status = $(this).data('status');

            $('.status-btn').removeClass('btn-success');
            $('.status-btn').addClass('btn-outline-success');
            $(this).addClass('btn-success');
            $(this).removeClass('btn-outline-success');
            $('.tmp-clear-bg').removeClass('tmp-clear-bg');
            $('.infinite-list7').html('');

            var value = 7;
            var selector = ".infinite-list" + value;
            var listElm = document.querySelector(selector);
            var url = 'index.php?r=table-ajax/get-data&status=' + status;

            var limit = 5;
            var offset = 0;

            if (value == 2) {
                var maxrow = 60;
            } else {
                var maxrow = 1;
            }

            var counter = 0;

            var loadMore = function () {
                if (offset < maxrow) {
                    fetch(`index.php?r=table-ajax/get-data&offset=${offset}&status=${status}&limit=${limit}`).then(i => i.json()).then(i => {
                        if (counter === 1) {
                            let data = i.header;
                            let headerdown = i.headerdown;
                            let target = document.createElement('tr');

                            if (value === 1 || value === 2) {
                                let space = document.createElement("th");
                                space.className = "b-title text-center sticky";
                                space.innerHTML = 'Производитель';
                                space.setAttribute("rowspan", "2");
                                listElm.append(space);

                                let space2 = document.createElement('th');
                                space2.className = "b-title text-center sticky-two";
                                space2.innerHTML = 'Маркетолог';
                                space2.setAttribute("rowspan", "2");
                                listElm.append(space2);
                            } else {
                                let space = document.createElement("th");
                                space.className = "b-title text-center sticky";
                                space.style.minWidth = '278px';
                                space.innerHTML = 'Аптечная сеть';
                                space.setAttribute("rowspan", "2");
                                listElm.append(space);

                                let space2 = document.createElement('th');
                                space2.className = "b-title text-center sticky-three";
                                space2.innerHTML = 'Менеджер';
                                space2.setAttribute("rowspan", "2");
                                listElm.append(space2);

                                let space3 = document.createElement('th');
                                space3.className = "b-title text-center sticky-four";
                                space3.innerHTML = 'Кол-во точек';
                                space3.setAttribute("rowspan", "2");
                                listElm.append(space3);

                                let space4 = document.createElement('th');
                                space4.className = "b-title text-center sticky-five";
                                space4.innerHTML = `Оборот АС`;
                                // space4.classList.add('deadline-block')
                                space4.setAttribute("rowspan", "2");
                                listElm.append(space4);

                                let space5 = document.createElement('th');                  // TODO: КОЛ-ВО ДОГОВОРОВ
                                space5.className = "b-title text-center";
                                space5.classList.add('sticky-six');
                                space5.classList.add('deadline-block')
                                space5.innerHTML = '<div class="deadline"><p>Дата постановки</p><hr><p>Дедлайн</p><hr><p>Производитель</p></div><p class="title">Кол-во<br>контрактов</p>';
                                space5.setAttribute("rowspan", "2");
                                listElm.append(space5);
                            }
                            let count_i = 0;

                            // e - во вкладках данные по шапке
                            data.forEach((e, index, arr) => {
                                let summary = 0;
                                let box = document.createElement('th');
                                box.classList.add('text-center');
                                box.classList.add('header-one');
                                box.innerHTML = e;

                                box.setAttribute('data-id', index + count_i);
                                listElm.append(box);
                            });

                            listElm.append(target);
                        }

                        let data = i.results
                        let target = document.createElement('tr');

                        let dots = 0, as = 0, orders = 0;
                        // e - во вкладках, строки
                        data.forEach((e, index, arr) => {
                            let box = document.createElement('tr');
                            box.classList.add('manuf-line');
                            box.innerHTML = e;

                            if (index != 0) {
                                let now = box.querySelector('.manager').getAttribute('data-manager');
                                let prev_box = document.createElement('tr');
                                prev_box.innerHTML = arr[index - 1];
                                let prev = prev_box.querySelector('.manager').getAttribute('data-manager')

                                if (now != prev) {
                                    let box2 = document.createElement('tr');
                                    let manager_name = $(prev_box).find('.manager').text();

                                    box2.classList.add(`toggle`);
                                    box2.setAttribute('data-sum', `${prev}_hidden`);

                                    //console.log(prev);

                                    if (value === 3 || value === 4 || value === 5 || value === 6 || value === 7) {
                                        //
                                        // /** todo: создает нагрузку при загрузке вкладок !!!!! */
                                        // var tmp_data;
                                        //
                                        // $.ajax({
                                        //     url: 'index.php?r=get-data/results',
                                        //     type: 'GET',
                                        //     async: false,
                                        //     dataType: 'html',
                                        //     data: {
                                        //         manager_name: manager_name
                                        //     },
                                        //     success: function (res) {
                                        //         tmp_data = JSON.parse(res);
                                        //     }
                                        // });
                                        // /** todo: создает нагрузку при загрузке вкладок !!!!! */
                                        as = as.toLocaleString()
                                        orders = orders.toLocaleString()
                                        box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td>" +
                                            "<td style='background-color: #c0efef'>" + dots + "</td>" +
                                            "<td style='background-color: #c0efef'>" + as + "</td>" +
                                            "<td style='background-color: #c0efef'>" + orders + "</td>" +
                                            "</tr>";
                                    } else {
                                        box2.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                    }
                                    dots = 0;
                                    as = 0;
                                    orders = 0;
                                    box2.childNodes[0].classList.add(`sticky`);
                                    box2.childNodes[1].classList.add(`sticky-three`);
                                    box2.childNodes[2].classList.add(`sticky-four`);
                                    box2.childNodes[3].classList.add(`sticky-five`);
                                    box2.childNodes[4].classList.add(`sticky-six`);

                                    box2.querySelector("td").style.backgroundColor = "#c0efef";
                                    listElm.append(box2);
                                }
                            }
                            let child2 = +box.childNodes[2].innerHTML;
                            let child3 = +box.childNodes[3].innerHTML;
                            let child4 = +box.childNodes[4].innerHTML;
                            dots = dots + child2;
                            as = as + child3;
                            orders = orders + child4;
                            box.childNodes[3].innerHTML = child3.toLocaleString()
                            box.childNodes[4].innerHTML = child4.toLocaleString()

                            listElm.append(box);

                            if (index == arr.length - 1) {
                                //console.log(index, arr.length)
                                let now = box.querySelector('.manager').getAttribute('data-manager');
                                let next_box = document.createElement('tr');
                                next_box.innerHTML = e;
                                let manager_name = $(box).find('.manager').text();
                                next_box.classList.add(`toggle`);
                                next_box.setAttribute('data-sum', `${now}_hidden`);
                                if (value === 3 || value === 4 || value === 5 || value === 6 || value === 7) {

                                    // /** todo: создает нагрузку при загрузке вкладок !!!!! */
                                    // var tmp_data;
                                    //
                                    // $.ajax({
                                    //     url: 'index.php?r=get-data/results',
                                    //     type: 'GET',
                                    //     async: false,
                                    //     dataType: 'html',
                                    //     data: {
                                    //         manager_name: manager_name
                                    //     },
                                    //     success: function (res) {
                                    //         tmp_data = JSON.parse(res);
                                    //     }
                                    // });
                                    // /** todo: создает нагрузку при загрузке вкладок !!!!! */
                                    as = as.toLocaleString()
                                    orders = orders.toLocaleString()
                                    next_box.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td>" +
                                        "<td style='background-color: #c0efef'>" + dots + "</td>" +
                                        "<td style='background-color: #c0efef'>" + as + "</td>" +
                                        "<td style='background-color: #c0efef'>" + orders + "</td>" +
                                        "</tr>";
                                } else {
                                    next_box.innerHTML = "<tr class=`${now}_hidden`><td></td><td style='background-color: #c0efef'><b>" + manager_name + "</b></td></tr>";
                                }
                                next_box.querySelector("td").style.backgroundColor = "#c0efef";

                                dots = 0;
                                as = 0;
                                orders = 0;
                                next_box.childNodes[0].classList.add(`sticky`);
                                next_box.childNodes[1].classList.add(`sticky-three`);
                                next_box.childNodes[2].classList.add(`sticky-four`);
                                next_box.childNodes[3].classList.add(`sticky-five`);
                                next_box.childNodes[3].classList.add(`sticky-six`);
                                //
                                // next_box.childNodes[0].classList.add(`sticky`);
                                // next_box.childNodes[1].classList.add(`sticky-three`);
                                listElm.append(next_box);
                                // next_box.childNodes[2].classList.add(`sticky-four`);
                            }
                        });

                        listElm.append(target);

                        loadMore();
                        createTableLine();
                        //  setTableSpoilers();
                        // setTableSpoilers2();
                        // hideRepeated();
                        getTasksAjax(value, 1, status);
                    });
                }

                offset += limit;
                counter++;
            }

            // getTasksAjax(4);

            loadMore();
            createTableLine();
            setTimeout(() => {
                setTableSpoilers(listElm);
                setTableSpoilers2(listElm);
                // getTasksAjax(4);
            }, 3000);

            // hideRepeated();
        });
    </script>

    <script>
        // изменение статуса задачи из модалки
        $(document).on("change", ".modal-task-status", function () {
            var newstatus = $(this).val();
            var taskid = $('#mt-task-id').val();

            $('.task-history').html('<div class="spinner-border text-primary" role="status">' +
                '<span class="visually-hidden"></span></div>');

            $.get("index.php?r=ajax/modal-change-status-task", {taskid, newstatus}, function (res) {
                $('.task-history').html(res);
            });

            // перекрашиваем ячейку
            $.get("index.php?r=tasks/get-new-task-color", {newstatus}, function (res) {
                var selector = "data-id=" + taskid;
                $("td[" + selector + "]").css('background-color', res);
                hideRepeated();
            });
        });
    </script>
    <script>
        $('.btn-status-group').hide();
        let crtab;

        // отображение кнопки Добавить задачу в зависимости от вкладок
        var add_order_btn = $('.add-order-btn');

        // Стартовое состояние - на странице "Активные в работе (на первом табе - скрыть)
        $(add_order_btn).hide();
        $('.group-add-tasks').hide();

        $(document).on("click", ".nav-link", function () {
            var tab_id = $(this).data('value');
            crtab = tab_id;
            //console.log(tab_id);

            // сохраняем инфу о последней открытой вкладке
            sessionStorage.setItem('last_tab', tab_id);

            if (tab_id === 1) {
                $(add_order_btn).hide();
                $('.group-add-tasks').hide();
                $('.btn-status-group').hide();
            }
            if (tab_id === 2) {
                $(add_order_btn).hide();
                $('.group-add-tasks').hide();
                $('.btn-status-group').hide();
            }
            if (tab_id === 3) {
                $(add_order_btn).show();
                $(add_order_btn).attr("href", "index.php?r=tasks/add&t_status=2");
                $('.group-add-tasks').hide();
                $('.btn-status-group').hide();
            }
            if (tab_id === 4) {
                $(add_order_btn).show();
                $(add_order_btn).attr("href", "index.php?r=tasks&t_status=3");
                $('.group-add-tasks').hide();
                $('.btn-status-group').hide();
            }
            if (tab_id === 5) {
                $(add_order_btn).show();
                $(add_order_btn).attr("href", "index.php?r=tasks/add&t_status=4");
                $('.group-add-tasks').hide();
                $('.btn-status-group').hide();
            }
            if (tab_id === 6) {
                $(add_order_btn).show();
                $(add_order_btn).attr("href", "index.php?r=tasks/add&t_status=5");
                $('.group-add-tasks').show();
                $('.btn-status-group').hide();
            }
            if (tab_id === 7) {
                $(add_order_btn).hide();
                $('.group-add-tasks').hide();
                $('.btn-status-group').show();
            }

            // наполнение контрагентов в фильтрах
            if (tab_id === 2) {
                // АС
                // pharmacy_network_status_id
                // 1 - активный
                // 2 неактивный
                // 3 потенциальный
                $(".pharm_networks option[data-status='2']").hide();
                $(".pharm_networks option[data-status='3']").hide();

                // производитель
                // manufacturer_statuses
                // 1 - активный
                // 2 неактивный
                // 3 потенциальный
                $(".manufacturers option[data-status='2']").hide();
                $(".manufacturers option[data-status='3']").hide();

                // обновляем chosen-select
                $('.chosen-select').val([]).trigger('chosen:updated');
            } else {
                $(".pharm_networks option[data-status='2']").show();
                $(".pharm_networks option[data-status='3']").show();

                $(".manufacturers option[data-status='2']").show();
                $(".manufacturers option[data-status='3']").show();

                $('.chosen-select').val([]).trigger('chosen:updated');
            }
        });
    </script>

    <script>
        // Создание задачи по нажатию на +
        $(document).on("click", ".create-task", function () {
            $(this).parent().css('background-color', '#FFFF00FF');
            //$(this).parent().text('');
            $(this).removeClass('create-task');
            let obj = $(this).parent();

            var tasktype = $(this).data('tasktype');
            var as = $(this).data('as');
            var manuf = $(this).data('manuf');
            var tab = $(this).data('tab');

            var t = parseInt($(obj).index());
            t++;
            var upperth = $('th:nth-child(' + t + ')')[1];
            var groupid = $(upperth).find('a').data('grouptaskid');

            $.get("index.php?r=create-task", {tasktype, as, manuf, tab, groupid}, function (res) {
                $(obj).addClass('get-task-modal-by-id');
                $(obj).attr('data-manid', as);
                $(obj).attr('data-pnid', manuf);
                $(obj).attr('data-id', res);
                $(obj).attr('data-taskid', res);
                $(obj).text('');

                //console.log(res);
            });
        });
    </script>

    <script>
        $(document).on("click", ".close-order-btn", function () {
            var id = $(this).data('id');

            $.get("index.php?r=tasks/group-close", {crtab, id}, function (res) {
                //$('.order-data-modal').modal('hide');
                window.location.reload();
            });
        });

        $(document).on("click", ".open-order-btn", function () {
            var id = $(this).data('id');

            $.get("index.php?r=tasks/group-open", {crtab, id}, function (res) {
                //$('.order-data-modal').modal('hide');
                window.location.reload();
            });
        });
    </script>

    <script>
        /** скрываем повторные задачи */
        function hideRepeated() {
            setTimeout(function () {
                var tasks = $('.get-task-modal-by-id');

                $.each(tasks, function (key, data) {
                    var crTaskId = $(data).data('groupid');

                    if (crTaskId) {
                        var $td = $(this);
                        var $th = $td.closest('table').find('th').eq($td.index());
                        var $taskid = $th.find('.get-manuf-modal').data('groupid');

                        if ($taskid != crTaskId) {
                            //$td.css('background-color', 'white');
                            //$td.html('');

                            // $td.remove();
                            //$td.text('+');

                            //console.log($taskid);
                        }
                    }
                });
            }, 0);
        }
    </script>

    <script>
        /** подгружаем такси ajax-ом */
        function getTasksAjax(tab_id, close, closetab) {
            //  let final_th=document.querySelector('.toggle-th-last').getAttribute('data_id');
            let areas = $('.task-area:visible');
            let task_list = [];

            /**
             * @todo:
             * Переделать логику подгрузки задач - упаковать в массив данные по задачам и вытаскивать их
             * при сканировании областей (areas)
             */
            console.log('--- getTasksAjax init ---');
            $.get("index.php?r=tasks/get-group-tasks", {tab_id, close, closetab}, function (res) {
                task_list = jQuery.parseJSON(res);

                console.log(tab_id);
                console.log(close);
                console.log(task_list);

                console.log('--- getTasksAjax send request ---');
                let areas_list = [];
                // перебираем зоны
                //формируем массив актуальных ячеек
                $.each(areas, function (key, data) {
                    // console.log('--- getTasksAjax areas: ' + key + ' ---');
                    var $td = $(this).parent();
                    var $th = $td.closest('table').find('th').eq($td.index());
                    var $taskGroupId = $th.find('.get-manuf-modal').data('groupid');
                    if ($taskGroupId) {
                        areas_list.push(data)
                    }
                    // if (tab_id==5) {
                    //     var $dataId = $th.find('.toggle-th-last')
                    //     // удаляем пустые и лишние
                    //     if (!$taskGroupId && $dataId > final_th) {
                    //         $td.remove();
                    //     }
                    // }
                    // } else{
                    // if (!$taskGroupId) {
                    //     console.log('удаляю')
                    //     $td.remove();
                    // }
                })
                //расставляем задачи по актуальным ячейкам
                $.each(areas_list, function () {
                    var $td = $(this).parent();
                    var $th = $td.closest('table').find('th').eq($td.index());
                    var $asId = $td.parent().find('td:first').find('.get-as-modal').data('manid');
                    var $taskGroupId = $th.find('.get-manuf-modal').data('groupid');
                    $.each(task_list, function (tkey, tdata) {
                        if (tdata.group_task_id == $taskGroupId && tdata.pharmacy_network_id == $asId) {
                            //$td.text(tdata.name);
                            $td.text(tdata.result);
                            $td.addClass('task-area get-task-modal-by-id color-' + tdata.status_task_id);
                            $td.attr('data-id', tdata.id);
                            $td.attr('data-taskid', tdata.id);
                            //$td.attr('data-groupid=', $taskGroupId);
                            $td.attr('data-tab', 0);
                            $td.attr('data-manid', 0);
                            $td.attr('data-marketer-id', 0);
                            $td.attr('data-menager-id', 0);
                            $td.attr('data-pnid', 0);
                            $td.attr('title', tdata.result);
                            $td.attr('data-d_create', tdata.created_at);
                            $td.attr('data-d_deadline', tdata.deadline);
                            let color = tdata.status_task_id;
                                   switch (color) {
                                case '0':
                                    color='#ffffff'
                                    break;
                                case '1':
                                    color='#FFE100'
                                    break;
                                case '2':
                                    color='#00B050'
                                    break;
                                case '3':
                                    color='#DE5C5C'
                                    break;
                                case '4':
                                    color='#4B91D5'
                                    break;
                                case '5':
                                    color='#002060FF'
                                    break;
                                case '6':
                                    color='#7030A0FF'
                                    break;
                                case '7':
                                    color='#00B050FF'
                                    break;
                                case '8':
                                    color='#f5acde'
                                    break;
                            }
                            $td.attr('data-fill-color', color);
                        }
                    });
                })

                // todo: проверить на ТМА. слишком долго доходит до этого шага
                console.log('--- getTasksAjax complete ---');


            });
            if (tab_id != 1 && tab_id != 2) {
                document.querySelector('.spoilers-close').style.display = "block"
                document.querySelector('.spoilers-open').style.display = "block"
            }
            setTimeout(() => {
                let max_th = $('table:visible th').length - 1;
                let trki = $('tr:visible');
                $.each(trki, (key, data) => {
                    let tr = data.childNodes;
                    tr.forEach((item, index) => {
                        if (index > max_th) {
                            item.style.display = "none"
                        }
                    })
                })

            }, 500)

        }
    </script>


    <script>
        $(document).on("change", ".group-edit-inputs", function () {
            var deadline = $('.ge-deadline').val();
            var comment = $('.ge-comment').val();
            var taskid = $('.task-id').val();
            var crobj = $('.get-manuf-modal[data-taskid="' + taskid + '"]').parent().find('.ud-d-deadline');

            $.get("index.php?r=tasks/group-edit-task", {deadline, comment, taskid}, function (res) {
                $('.task-comment[data-id="' + taskid + '"]').attr('title', comment);
                $('.task-comment[data-id="' + taskid + '"]').text(comment);

                var deadline_formated = new Date(deadline);
                var d = deadline_formated.getDate();
                var m = deadline_formated.getMonth();
                m += 1;  // JavaScript months are 0-11
                var y = deadline_formated.getFullYear();

                $(crobj).text(d + "." + m + "." + y);
            });
        });
    </script>

    <script>
        // ф-ция быстрого создания стартовой задачи todo: старое
        function fastCreateStartTask(tab, manid, pnid) {

        }

        $(document).on("click", ".color-8", function () {
            var crtask = $(this);
            var tab = $(this).data('tab');
            var manid = $(this).data('manid');
            var pnid = $(this).data('pnid');

            if (!$(this).data('menager-id')) {
                $.get("index.php?r=tasks/fast-create-start-task", {
                    manid, pnid,
                }, function (id) {
                    $.get("index.php?r=table/get-order-data-in-modal-by-id", {
                        id,
                    }, function (res) {
                        $('.task-modal').html(res);
                        $('#order-data-modal').modal('show');

                        $(crtask).attr('data-taskid', id);
                        $(crtask).attr('data-id', id);
                        $(crtask).addClass('get-task-modal');
                    });

                    $(crtask).attr('data-menager-id', '99999999'); // todo
                });
            }
        });
    </script>

    <script>
        // Доп вкладки - резальтат выполнения задачи (строка)
        $(document).on("keyup", ".work-result", function () {
            var text = $(this).val();
            var taskid = $(this).data('taskid');

            var selector = "data-taskid=" + taskid;
            $("td[" + selector + "]").text(text);

            $.get("index.php?r=tasks/change-task-work-status", {
                taskid, text,
            }, function (res) {
                //console.log(res);
            });
        });

        // Контракты в АС - Сотрудничество в др ассоц. (выбиралка)
        $(document).on("change", ".sotr-s-dr-assoc", function () {
            var text = $(this).val();
            var taskid = $(this).data('taskid');
            var selector = "data-taskid=" + taskid;
            var newstatus = 0;

            $.get("index.php?r=tasks/change-task-work-status-int", {
                taskid, text,
            }, function (res) {
                //console.log(res);
                $("td[" + selector + "]").text(res);

                $('.task-history').html('<div class="spinner-border text-primary" role="status">' +
                    '<span class="visually-hidden"></span></div>');

                $.get("index.php?r=ajax/modal-change-status-task", {taskid, newstatus}, function (res) {
                    $('.task-history').html(res);
                });
            });
        });
    </script>

    <script>
        $('.ajax-content').hide();

        // возврат к открытой вкладке
        setTimeout(function () {
            let saved_tab_state = sessionStorage.getItem('last_tab');
            $(".nav-link[data-value='" + saved_tab_state + "']").trigger('click');
            $('.ajax-content').show();
        }, 250);
    </script>

    <script>
        $(document).on("click", ".test-filters", function () {
            // строка
            var manuf = $('.get-manuf-modal[data-manid="35"]');
            $(manuf).parent().parent().hide();

            // колонка
            var as = $('.get-as-modal[data-manid="2"]');
            var crcol = $(as).parent();
            var t = parseInt($(crcol).index());
            $('th:nth-child(' + t + '),td:nth-child(' + t + ')').hide();
        });
    </script>

    <script>
        // спойлеры
        function hideSpoilers(list) {
            // свернуть все спойлеры
            document.querySelector('.spoilers-close').addEventListener('click', () => {
                if (list.closest('.show')) {
                    let lines = list.querySelectorAll('.manuf-line');
                    lines.forEach(el => {
                        el.classList.add('hidden')
                    })
                    if (list.querySelector('.toggle-th')) {
                        let heads = list.querySelectorAll('.header-one');
                        heads.forEach(el => {
                            el.classList.add('hidden')
                        })

                    }
                }
            });

            // развернуть все спойлеры
            document.querySelector('.spoilers-open').addEventListener('click', () => {
                if (list.closest('.show')) {
                    let log = list.querySelectorAll('.manuf-line');
                    log.forEach(el => {
                        el.classList.remove('hidden')
                    })
                    if (list.querySelector('.toggle-th')) {
                        let heads = list.querySelectorAll('.header-one');
                        heads.forEach(el => {
                            el.classList.remove('hidden')
                        })
                    }
                }
            });
        }
    </script>

    <script>
        // выделение активной клетки
        $(document).on("click", ".get-task-modal", function () {
            $('td').removeClass('td-active');
            $(this).addClass('td-active');
        });

        $(document).on("click", ".get-task-modal-by-id", function () {
            $('td').removeClass('td-active');
            $(this).addClass('td-active');
        });
    </script>

    <script>
        // отправка задачи в следующий / смежный отдел
        $(document).on("click", ".send-task-n-depart", function () {
            $(this).removeClass('btn-outline-info');
            $(this).addClass('btn-outline-success');
            $(this).text('Отправлена');
        });
    </script>

    <script src="assets/js/tableToExcel.js"></script>
    <script>
        // импорт в эксель
        $(document).on("click", ".import-excel", function () {
            var activeTab = $('.tab-pane.fade.show.active');
            var id = $(activeTab).attr('id');
            var navlink = $('#' + id + '-tab');
            var tabnum = $(navlink).data('value');
            var currentTab = $('.infinite-list' + tabnum);
            var selector = ".infinite-list" + tabnum;
            // удаляем спойлеры td
            // $('.toggle').remove();

            //удаляем спойлеры th
            // let marketers_th = currentTab[0].querySelectorAll('.toggle-th');
            // let marketers_td = [];
            // if (tabnum == 1) {
            //     marketers_td = currentTab[0].querySelectorAll('.manuf-liness');
            // } else {
            //     marketers_td = currentTab[0].querySelectorAll('.manuf-line');
            // }
            // let marketers_all = [];
            // marketers_th.forEach((mark) => {
            //     let el_id = mark.getAttribute('data_id')
            //     let el_id2;
            //     if (tabnum == 1 || tabnum == 2) {
            //         el_id2 = Number(el_id) + 2;
            //     } else {
            //         el_id2 = Number(el_id) + 5;
            //     }
            //     let marketers_row = [];
            //     marketers_td.forEach((el2) => {
            //         let num_child = el2.childNodes[el_id2];
            //         marketers_row.push(num_child);
            //     })
            //     marketers_all.push(marketers_row)
            // });
            // marketers_all.forEach(el => {
            //     el.forEach(el2 => {
            //         el2.remove();
            //     })
            // })
            // marketers_th.forEach(el => {
            //     el.remove();
            // })
            // if (currentTab[0].querySelector('.toggle-th-last')) {
            //     currentTab[0].querySelector('.toggle-th-last').remove();
            // }
            if (tabnum != 2 || tabnum != 1) {
                let th_all = currentTab[0].querySelectorAll('th');
                let last_th = th_all.length - 1
                currentTab[0].querySelectorAll('.manuf-line').forEach(el => {
                        el.querySelectorAll('td').forEach((el2, index, arr) => {
                            if (index > last_th) {
                                el2.remove();
                            }
                        })
                    }
                )
            }

            // меняем все th на td
            let th = currentTab[0].querySelectorAll('th')
            let tr = document.createElement('tr');
            let tr2 = document.createElement('tr');
            let tr3 = document.createElement('tr');
            let tr4 = document.createElement('tr');
            let tr5 = document.createElement('tr');
            let tr6 = document.createElement('tr');
            currentTab[0].insertAdjacentElement('afterbegin', tr)
            currentTab[0].insertAdjacentElement('afterbegin', tr2)
            currentTab[0].insertAdjacentElement('afterbegin', tr3)
            if (tabnum != 1 && tabnum != 2) {
                currentTab[0].insertAdjacentElement('afterbegin', tr4)
                currentTab[0].insertAdjacentElement('afterbegin', tr5)
                currentTab[0].insertAdjacentElement('afterbegin', tr6)
            }
            tr = currentTab[0].childNodes[0]
            tr2 = currentTab[0].childNodes[1]
            tr3 = currentTab[0].childNodes[2]
            if (tabnum != 1 && tabnum != 2) {
                tr4 = currentTab[0].childNodes[3]
                tr5 = currentTab[0].childNodes[4]
                tr6 = currentTab[0].childNodes[5]
            }

            // th.forEach(el => {
            //     tr.insertAdjacentElement('beforeend', el)
            // })
            th.forEach(el => {
                // let inner = el.innerHTML
                let first_td = '';
                let sec_td = '';
                let third_td = '';
                let fo_td = '';
                let fi_td = '';
                let si_td = '';
                if (tabnum == 1 || tabnum == 2) {
                    if ((!el.classList.contains('toggle-th'))
                        && (!el.classList.contains('toggle-th-last'))
                        && (!el.classList.contains('b-title'))) {
                        if (tabnum == 1) {
                            first_td = el.childNodes[0].title;
                        } else {
                            first_td = el.childNodes[0].querySelector('span').title;
                        }

                        sec_td = el.childNodes[3].innerText;
                        if (el.childNodes[5]) {
                            third_td = el.childNodes[5].textContent;
                        } else {
                            third_td = '0'
                        }
                    } else if (el.classList.contains('b-title')) {
                        first_td = el.innerText;
                    } else {
                        sec_td = el.childNodes[0].textContent;
                        third_td = el.childNodes[2].textContent
                    }
                } else {
                    if ((!el.classList.contains('toggle-th'))
                        && (!el.classList.contains('toggle-th-last'))
                        && (!el.classList.contains('b-title'))) {
                        first_td = el.childNodes[0].childNodes[0].textContent;
                        sec_td = el.childNodes[0].childNodes[2].textContent;
                        third_td = el.childNodes[2].innerText;
                        fo_td = el.childNodes[5].innerText;
                        fi_td = el.childNodes[9].textContent;
                        fi_td = fi_td + el.childNodes[10].innerText
                        si_td = el.childNodes[12].title;
                    } else if (el.classList.contains('b-title')) {
                        if (el.classList.contains('deadline-block')) {
                            first_td = el.querySelector('.deadline').childNodes[0].innerText;
                            sec_td = el.querySelector('.deadline').childNodes[2].innerText;
                            third_td = el.querySelector('.deadline').childNodes[4].innerText;
                            fo_td = el.querySelector('.title').innerText;
                        } else {
                            first_td = el.innerText;
                        }


                    } else {
                        sec_td = el.childNodes[0].textContent;
                        third_td = el.childNodes[2].textContent
                    }
                }
                // let td = `<td>${inner}</td>`
                let td = `<td>${first_td}</td>`
                let td2 = `<td>${sec_td}</td>`
                let td3 = `<td>${third_td}</td>`
                let td4;
                let td5;
                let td6;
                if (tabnum != 1 && tabnum != 2) {
                    td4 = `<td>${fo_td}</td>`
                    td5 = `<td>${fi_td}</td>`
                    td6 = `<td>${si_td}</td>`
                }
                // const new_el = document.createElement('td')
                const new_el = document.createElement('td')
                const new_el2 = document.createElement('td')
                const new_el3 = document.createElement('td')
                const new_el4 = document.createElement('td')
                const new_el5 = document.createElement('td')
                const new_el6 = document.createElement('td')
                // new_el.innerHTML = td
                new_el.innerHTML = td
                new_el2.innerHTML = td2
                new_el3.innerHTML = td3
                if (tabnum != 1 && tabnum != 2) {
                    new_el4.innerHTML = td4
                    new_el5.innerHTML = td5
                    new_el6.innerHTML = td6
                }
                // el.replaceWith(new_el)


                tr.insertAdjacentElement('beforeend', new_el)
                tr2.insertAdjacentElement('beforeend', new_el2)
                tr3.insertAdjacentElement('beforeend', new_el3)
                if (tabnum != 1 && tabnum != 2) {
                    tr4.insertAdjacentElement('beforeend', new_el4)
                    tr5.insertAdjacentElement('beforeend', new_el5)
                    tr6.insertAdjacentElement('beforeend', new_el6)
                }
            })
            if (tabnum != 1 && tabnum != 2) {


                let mark = currentTab[0].childNodes[0].childNodes[0];
                let manuf = currentTab[0].childNodes[0].childNodes[1];
                let col = currentTab[0].childNodes[0].childNodes[2];
                let ob = currentTab[0].childNodes[0].childNodes[3];
                if (mark.innerText == th[0].innerText ||
                    manuf.innerText == th[1].innerText) {
                    mark.setAttribute("rowspan", "6");
                    manuf.setAttribute("rowspan", "6");
                    col.setAttribute("rowspan", "6");
                    ob.setAttribute("rowspan", "6");
                    for (let i = 1; i <= 4; i++) {
                        currentTab[0].childNodes[1].childNodes[0].remove();
                    }
                    for (let i = 1; i <= 4; i++) {
                        currentTab[0].childNodes[2].childNodes[0].remove();
                    }
                    let to = currentTab[0].childNodes[3].childNodes[4];
                    to.setAttribute("rowspan", "3");
                    for (let i = 1; i <= 4; i++) {
                        currentTab[0].childNodes[3].childNodes[0].remove();
                    }
                    for (let i = 1; i <= 5; i++) {
                        currentTab[0].childNodes[4].childNodes[0].remove();
                    }
                    for (let i = 1; i <= 5; i++) {
                        currentTab[0].childNodes[5].childNodes[0].remove();
                    }
                }

            } else {
                let mark = currentTab[0].childNodes[0].childNodes[0];
                let manuf = currentTab[0].childNodes[0].childNodes[1];
                if (mark.innerText == th[0].innerText ||
                    manuf.innerText == th[1].innerText) {
                    mark.setAttribute("rowspan", "3");
                    manuf.setAttribute("rowspan", "3");
                    currentTab[0].childNodes[1].childNodes[0].remove();
                    currentTab[0].childNodes[1].childNodes[0].remove();
                    currentTab[0].childNodes[2].childNodes[0].remove();
                    currentTab[0].childNodes[2].childNodes[0].remove();
                }
            }

            th.forEach(el => {
                el.remove();
            })
            if (tabnum == 1 || tabnum == 2) {
                currentTab[0].childNodes[3].remove();
                if (tabnum == 1) {
                    currentTab[0].childNodes[3].remove();
                    currentTab[0].childNodes[3].remove();
                }
            } else {
                currentTab[0].childNodes[6].remove();
            }

            let tab_name = document.querySelector('.nav-tabs').querySelector('.active').innerText;
            let route_name = `${tab_name}.xlsx`
            if (tabnum==7){
                let tabs=document.querySelector('.btn-status-group')
                let tabs_arr=tabs.querySelectorAll('.status-btn')
                tabs_arr.forEach(el=>{
                    if (el.classList.contains('btn-success')) {
                        tab_name = tab_name +' '+ el.innerText;
                        route_name=`${tab_name}.xlsx`
                    }
                })
            }
            console.log(tab_name)
            setTimeout(function () {
                TableToExcel.convert(document.querySelector(selector), {
                    name: route_name,
                    sheet: {
                        name: tab_name
                    }
                });


                //возвращаем вид
                $(currentTab).html('');

                setTimeout(function () {
                    //getContent();
                    loadTable(tabnum);
                }, 1000);

                $.each($('.get-manuf-modal'), function (index, value) {
                    $('.chosen-select').val([]).trigger('chosen:updated');
                    $(value).parent().parent().show();
                });

            }, 10);


        });
    </script>

    <script>
        lockScreen();

        // блокировка экрана до полной загрузки
        function lockScreen() {
            $('.locked-screen').show();

            setTimeout(function () {
                $('.locked-screen').hide();
            }, 1);
        }

    </script>
    </body>
    </html>
<?php $this->endPage() ?>