<?php
require_once 'head.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="main">
    <?php require_once 'menu.php'; ?>
    <div class="right">
        <div id="doanhso" data-ds='<?php echo json_encode($data['doanh_so']) ?>'></div>
        <div id="top_sp" data-product='<?php echo json_encode($data['top_product']) ?>'></div>
        <div class="chart">
        <div id="line_chart">
            <h3> Thống kê doanh số theo tháng trong năm </h3>
            <canvas class="line_chart"></canvas>
        </div>

        <div id="bar_chart">
            <h3> Top 10 sản phẩm bán chạy nhất </h3>
            <canvas class="bar_chart"></canvas>
        </div>
        </div>
    </div>
</div>

<script>
    var doanh_so = document.getElementById('doanhso');
    doanh_so = doanh_so.getAttribute('data-ds');
    doanh_so = JSON.parse(doanh_so);
    var product = document.getElementById('top_sp');
    product = product.getAttribute('data-product');
    product = JSON.parse(product);
    console.log(Object.keys(product));

    const line = document.getElementsByClassName('line_chart');
    const labels = [
            'tháng 1', 'tháng 2', 'tháng 3', 'tháng 4', 'tháng 5', 'tháng 6', 'tháng 7', 'tháng 8', 'tháng 9', 'tháng 10','tháng 11','tháng 12',
        ];

    var datas =[];
    for(let i=0; i<12; i++){
        datas[i] =0;
        for(let j=0; j<Object.keys(doanh_so).length;j++){
            if(parseInt(doanh_so[j].thang) == i+1){
                datas[i] = parseInt(doanh_so[j].tong_tien);
            }
        }
    }
    const data = {
            labels,
            datasets: [{
                data:datas,
                label:"Biểu đồ cột",
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
            }],
            
        };
        const config = {
            type: "line",
            data: data,
            options: {
                reponsive:true,
            },
        };

        const chart = new Chart(line, config);

        getChartBar(product);

        function getChartBar(product){
            let bar = document.getElementsByClassName('bar_chart');
            let labels = [];
            let datas = [];
            for(let i=0; i< 10; i++){
                if((product.hasOwnProperty(i))){
                    labels[i] = product[i].ma_sp;
                    datas[i] = product[i].gia;
                }
                else{
                    labels[i] = 'not exist';
                    datas[i] = 0;
                }
            }

            let data = {
                    labels,
                    datasets: [{
                        data:datas,
                        label:"Biểu đồ cột",
                        backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                        ],
                    }],
                    
                };
            let config = {
                type: "bar",
                data: data,
                options: {
                    reponsive:true,
                },
            };
            let chart = new Chart(bar, config);

        }

</script>