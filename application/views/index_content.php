<?php 

defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-sitemap"></i> Register Wallet</span>
                <div class="count"><?php echo number_format($reg_rw);?></div>
                <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-eur"></i> Cash Wallet</span>
                <div class="count"><?php echo number_format($ch_cw); ?></div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-eur"></i> Product Wallet</span>
                <div class="count"><?php echo number_format($pd_pw); ?></div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-suitcase"></i> Bonus Wallet</span>
                <div class="count"><?php echo number_format($bns_bw);?></div>
                <!--<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-eur"></i> Sponsor Wallet</span>
                <div class="count"><?=number_format($sp_sw);?></div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-eur"></i> Total Income</span>
                <div class="count green"><?php echo $bns_bw + $pd_pw + $sp_sw ;?></div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
            </div>
        </div>

<!-- pie chart -->
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cycle <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content2">
                    <div id="graph_donut" style="width:100%; height:200px;"></div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Hibah <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content2">
                    <div id="graph_donut2" style="width:100%; height:200px;"></div>
                  </div>
                </div>
              </div>
<!-- /Pie chart -->

<!-- members info -->
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Members Info<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left input_mask">
                            <!------
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo $uname; ?>">
                                </div>

                            </div>
                            ------>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Member ID</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">

                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo $usrname; ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Package</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo number_format($package_id); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Role</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo $role_desc; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Join</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo date("d-m-Y", strtotime($created_date)); ?>">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
<!-- end members info -->

<!-- table ROI-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Next ROI / Hibah<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-bordered" cellspacing="0" id='datatable'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ROI Date</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach($roidate as $row){?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row->roi_date));?></td>
                                    <td><?php if ((date("d-m-Y")) >= ($row->roi_date)) { ?><i class="fa fa-check-square-o"></i><?php } ?></td>
                                </tr>
                                <?php $i++; }?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
<!-- end of table ROI-->

<!-- Start table news-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>News Section<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="bs-example" data-example-id="simple-jumbotron">
                            <div class="jumbotron">
                                <h1></h1>
                                <p>-No news yet-</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
<!-- end of table news-->
        </div>
</div></div></div></div>

    <!-- jQuery -->
    <script src="<?php echo base_url("assets/vendors/jquery/dist/jquery.min.js");?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url("assets/vendors/bootstrap/dist/js/bootstrap.min.js");?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url("assets/vendors/fastclick/lib/fastclick.js");?>"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url("assets/vendors/nprogress/nprogress.js");?>"></script>
    <!-- morris.js -->
    <script src="<?php echo base_url("assets/vendors/raphael/raphael.min.js");?>"></script>
    <script src="<?php echo base_url("assets/vendors/vendors/morris.js/morris.min.js");?>"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php //echo base_url("assets/build/js/custom.min.js");?>"></script>

    <!-- morris.js -->
    <script>
      $(document).ready(function() {

        Morris.Donut({
          element: 'graph_donut',
          data: [
            {label: '<?php echo $cyc_days; ?> days', value: <?php echo $cyc_days; ?>},
          ],
          colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          formatter: function (y) {
            //return y + "days";
            return "cycle";
          },
          resize: true
        });

        $MENU_TOGGLE.on('click', function() {
          $(window).resize();
        });
      });
    </script>
    <script>
      $(document).ready(function() {

        Morris.Donut({
          element: 'graph_donut2',
          data: [
            {label: '<?php echo $hibah_per;?>%', value: <?php echo $hibah_per;?>},
          ],
          colors: ['#34495E', '#ACADAC', '#3498DB'],
          formatter: function (y) {
            //return y + "days";
            return "hibah";
          },
          resize: true
        });

        $MENU_TOGGLE.on('click', function() {
          $(window).resize();
        });
      });
    </script>
    <!-- /morris.js -->