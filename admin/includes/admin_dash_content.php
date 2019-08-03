<div class="container-fluid">

                <!-- Page Heading -->


                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            DASHBOARD
                            <small>Baker</small>
                        </h1>

                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo count($suppliers = Supplier::find_all()->data); ?></div>
                                                <div>Suppliers</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="suppliers.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-money fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo count(Supplier::listTransfers()); ?></div>
                                                <div>Photos</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="transactions.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Transfers</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-cogs fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">1

                                                </div>

                                                <div>Users</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">Admin</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                        </div> <!--First Row-->

                        <div class="row">
                            <script type="text/javascript">
                                google.charts.load('current', {'packages':['corechart']});
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {

                                    var data = google.visualization.arrayToDataTable([
                                        ['Task', 'Hours per Day'],
                                        ['Completed',     2],
                                        ['Abandone',      25],
                                        ['Failed',  2],
                                        ['Others', 2],
                                    ]);

                                    var options = {
                                        title: 'Tranfers Details'
                                    };

                                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                                    chart.draw(data, options);
                                }
                            </script>

                            <div id="piechart" style="width: 900px; height: 500px;"></div>


                        </div>

                    </div>
                </div>
                <!-- /.row -->

</div>
<!-- /.container-fluid -->