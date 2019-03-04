
<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WBS</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
   
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
   
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
    <script src="<?php echo base_url('assets/Chart.js/Chart.bundle.js');?>"></script>

    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
</head> 
<body>
    <div class="container">
<!--       <div class="h3">1 tampilkan nomorB, waktu, type, dan durasi</div>-->

       <div class="panel panel-default">
            <div class="panel-body">
                <table id="tbl1" class="table table-striped table-bordered " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NomerB</th>
                            <th>Tipe</th>
                            <th>Waktu</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tabel1 as $key => $value) { ?>
                            <tr>
                                <td><?php echo $value->nomerB ?></td>
                                <td><?php echo $value->tipe ?></td>
                                <td><?php echo $value->Waktu ?></td>
                                <td><?php echo $value->durasi ?></td>
                                <td class="text-right">
                                    <a href="#<?php echo $value->nomerB; ?>" class="btn btn-primary btn-xs"><b class="glyphicon glyphicon-edit"></b></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>NomerB</td>
                            <td>Tipe</td>
                            <td>Waktu</td>
                            <td>Durasi</td>
                            <td>Aksi</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

       <!--<div class="h3">2 tampilkan nmor B(distinct), jumlah nomor B.</div>-->
       <div class="panel panel-default">
            <div class="panel-body">
                <table id="tbl2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NomerB</th>
                            <th>Jumlah</th>
                            <!--<th>Aksi</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tabel2 as $key => $value) { ?>
                            <tr>
                                <td><?php echo $value->nomerB ?></td>
                                <td><?php echo $value->cb ?></td>
                                <!--<td class="text-right">
                                    <a href="#<?php echo $value->nomerB; ?>" class="btn btn-primary btn-xs"><b class="glyphicon glyphicon-edit"></b></a>
                                </td>-->
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>NomerB</td>
                            <td>Jumlah</td>
                            <!--<td>Aksi</td>-->
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

       <div class="row">
           <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                       <!--<div class="h3">1. Bentuk Diagram  Jumlah VAS, Voice, MO dan SMS pada kolom type keseluruhan</div>-->
                       <canvas id="chart1" width="100" height="100"></canvas>
                    </div>
                </div>
           </div>
           <div class="col-md-6">
               <!--<div class="h3">2.Prosentase jumlah nomor B keseluruhan</div>-->
               <div class="panel panel-default">
                    <div class="panel-body">
                        <canvas id="chart2" width="100" height="100"></canvas>
                    </div>
                </div>
           </div>
        </div>
        <div class="row">
           <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                       <!--<div class="h3">3. prosentase jumlah voice MO berdasarkan nomor B</div>-->
                       <select id="sChart3" class="form-control" onchange="sChart3(this.value);">
                           <?php foreach ($tabel2 as $v) {
                               echo '<option value="'.$v->nomerB.'">'.$v->nomerB.'</option>';
                           } ?>
                       </select>
                       <canvas id="chart3" width="100" height="100"></canvas>
                    </div>
                </div>
           </div>
           <div class="col-md-6">
               <!--<div class="h3">4. prosentase  jumlah nomor B terhadap range tanggal</div>-->
               <div class="panel panel-default">
                    <div class="panel-body">
                       <form action="javascript:actChart4()" id="fChart4" class="input-group">
                           <input value="<?php echo date('Y-m-d') ?>" class="form-control datepicker" name="tgl[]">
                           <span class="input-group-addon"><b>-</b></span>
                           <input value="<?php echo date('Y-m-d') ?>" class="form-control datepicker" name="tgl[]">
                           <div class="input-group-btn">
                               <button type="submit" class="btn btn-secondary"><b>OK</b></button>
                           </div>
                       </form>
                       <div id="infChart4" class="alert alert-info" style="display: none;">Mencari data...</div>
                        <canvas id="chart4" width="100" height="100"></canvas>
                    </div>
                </div>
               
           </div>
       </div>


        <br>
    </div>
    <?php 
        $c1 = $chart1[0];
        $maxChart1 = max($chart3) +2;
    ?>
    <script type="text/javascript">
    // DataTable------------------------------------------------------------------------------------------
        $('#tbl1').DataTable({
            "columnDefs": [{ 
                "targets": [ -1 ],
                "orderable": false,
            }]
        });

        $('#tbl2').DataTable({
            "columnDefs": [{ 
                "targets": [ -1 ],
                "orderable": false,
            }]
        });
    // ---------------------------------------------------------------------------------------------------
    // ChartJS--------------------------------------------------------------------------------------------
        var Chart1 = new Chart(document.getElementById("chart1"), {
            type: 'polarArea',
            data: {
                labels: ["SMS(<?php echo $c1->sS;?>)(<?php echo $c1->Sigma;?>)","VAS(<?php echo $c1->sVs;?>)(<?php echo $c1->Sigma;?>)","Voice MO(<?php echo $c1->sVoi;?>)(<?php echo $c1->Sigma;?>)"],
                datasets: [{
                        label: 'Grafik Persentase Tipe VAS, Voice MO dan SMS',
                        data: [<?php echo round($c1->SMS,2).','.round($c1->VAS,2).','.round($c1->VoiceMO,2); ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            
                        ],
                        borderWidth: 1
                    }]
            },
            options: {
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                }
            }
        });

        var Chart2 = new Chart(document.getElementById("chart2"), {
            type: 'bar',
            data: {
                labels: [<?php
                    foreach ($chart2 as $v ) {
                        echo $v->nomerB.',';
                    }
                    ?>],
                datasets: [{
                        label: 'Prosentase jumlah nomor B keseluruhan',
                        data: [<?php 
                            foreach ($chart2 as $v) {
                                echo $v->rate.',';
                            }
                            ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            
                        ],
                        borderWidth: 1
                    }]
            },
            options: {
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                }
            }
        });

        var datachart3 = <?php echo json_encode($chart3); ?>;
        s = $('#sChart3').val();
        var chart3 = new Chart(document.getElementById("chart3"),{
            type: 'bar',
            data: {
                labels: ["Voice MO "+s],
                datasets: [{
                        label: 'Prosentase jumlah '+s,
                        data: [(datachart3[s])?datachart3[s]:0,],
                        backgroundColor: [
                        'rgba(54, 162, 235,0.6)',
                        
                    ],borderWidth: 1 
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max : <?php echo $maxChart1; ?>,
                            }
                        }]
                }
            }
        });
        var ctx4 = document.getElementById("chart4");
        var config = {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chart4['label']); ?>,
                datasets: <?php echo json_encode($chart4['dataset']); ?>
            },
            options: {
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max : <?php echo $maxChart1; ?>,
                            }
                        }]
                }
            }
        };
        var chart4 = new Chart(ctx4,config);
    // ---------------------------------------------------------------------------------------------------

    // Action & function ---------------------------------------------------------------------------------
        function sChart3(v){
            d = (datachart3[v])?datachart3[v]:0;
            chart3.data.labels[0] = "Voice MO "+v;
            chart3.data.datasets[0].data = [d,14,100];
            chart3.data.datasets[0].label = 'Prosentase jumlah '+v;
            chart3.update();
        }

        function actChart4(){
            $('#infChart4').show('fade');
            $.ajax({
                url : '<?php echo base_url('index.php/baru/getrange') ?>',
                type : 'POST',
                data : $('#fChart4').serializeArray(),
                error : function(e){ alert(e.status+' '+e.statusText); },
                success : function(r){
                    d = JSON.parse(r); 
                    config.data.labels = d.label;
                    config.data.datasets = d.dataset;
                    chart4 = new Chart(ctx4,config);
                    console.log(r);
                    $('#infChart4').hide('fade');
                }
            })
        }

        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            todayBtn: true,
        });
    // ---------------------------------------------------------------------------------------------------
    </script>
</body>
</html>