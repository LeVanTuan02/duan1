        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Thống kê</h5>
                        <span class="content__header-description">Thống kê loại hàng</span>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__dashboard">
                    <div class="content__table-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Thống kê hàng hóa</h3>
                            <span class="content__table-text">Analytic management made easy</span>
                        </div>
    
                        <section class="content__analytics">
                            <div id="chart"></div>
                        </section>
                    </div>

                    <div class="content__table-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Thống kê tài khoản</h3>
                            <span class="content__table-text">User management made easy</span>
                        </div>
    
                        <section class="content__analytics">
                            <div id="chart_user"></div>
                        </section>
                    </div>

                </div>

                <div class="content__table-wrap">
                    <section class="content__analytics">
                        <div id="chart_user-register"></div>
                    </section>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                // chart product
                var optionsChartProduct = {
                    series: [<?php foreach ($quantityAnalytics as $item) { echo $item['totalProduct'] . ', ' ;}?>],
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: [<?php foreach ($quantityAnalytics as $item) { echo "'$item[cate_name]', " ;}?>],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chartProduct = new ApexCharts(document.querySelector("#chart"), optionsChartProduct);
                chartProduct.render();

                // chart user
                var optionsChartUser = {
                    series: [<?php foreach ($userAnalytics as $item) { echo $item['total'] . ', ' ;}?>],
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    colors:['rgb(0, 143, 251)', 'rgb(255, 69, 96)'],
                    labels: [<?php foreach ($userAnalytics as $item) { echo ($item['active'] ? '"Đang hoạt động"' : '"Bị khóa"') . ', ' ;}?>],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chartUser = new ApexCharts(document.querySelector("#chart_user"), optionsChartUser);
                chartUser.render();

                // chart user register
                var optionsChartUserReg = {
                    series: [{
                        name: "User",
                        data: [<?php foreach ($userRegAnalytics as $item) { echo $item['total'] . ', '; }?>]
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'Thông kê khách hàng đăng ký theo tháng',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [<?php foreach ($userRegAnalytics as $item) { echo "'Tháng $item[month]', ";}?>],
                    }
                };

                var chartUserReg = new ApexCharts(document.querySelector("#chart_user-register"), optionsChartUserReg);
                chartUserReg.render();
            </script>
        </main>