

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <!-- pie chart -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cycle <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content2">
                    <div id="graph_donut" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div>
              <!-- /Pie chart -->
            </div>
            
          </div>
        </div>
        <!-- /page content -->


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
    <script src="<?php echo base_url("assets/build/js/custom.min.js");?>"></script>

    <!-- morris.js -->
    <script>
      $(document).ready(function() {

        Morris.Donut({
          element: 'graph_donut',
          data: [
            {label: '30 days', value: 30},
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
    <!-- /morris.js -->
