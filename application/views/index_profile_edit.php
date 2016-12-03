

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Profile</li>
  <li class="active">View Profile</li>
</ol>

                  <div class="x_title">
                    <h2>Profile</h2>

                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Full Name </span>
                          <span class="value text-success"> <?php echo $uname; ?> </span>
                        </li>
                        <li>
                          <span class="name"> #Tel </span>
                          <span class="value text-success"> <?php echo $contact; ?> </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> National ID </span>
                          <span class="value text-success"> <?php echo $nid; ?> </span>
                        </li>
                      </ul>
                      <br />

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Address </span>
                          <span class="value text-success"> <?php echo $address; ?> </span>
                        </li>
                        <li>
                          <span class="name"> Email </span>
                          <span class="value text-success"> <?php echo $email; ?> </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> D.O.B </span>
                          <span class="value text-success"> <?php echo date("d-m-Y", strtotime($dob)); ?> </span>
                        </li>
                      </ul>
                      <br />

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Join date </span>
                          <span class="value text-success"> <?php echo date("d-m-Y", strtotime($created_date)); ?> </span>
                        </li>
                        <li>
                          <span class="name"> Member ID </span>
                          <span class="value text-success"> <?php echo $usrname; ?> </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name">  </span>
                          <span class="value text-success">  </span>
                        </li>
                      </ul>
                      <br />

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Bank Name </span><a href="#/pencil"><i class="fa fa-pencil"></i></a>
                          <span class="value text-success"> <?php echo $bank_name; ?> </span>
                        </li>
                        <li>
                          <span class="name"> Account Number </span><a href="#/pencil"><i class="fa fa-pencil"></i></a>
                          <span class="value text-success"> <?php echo $acc_num; ?> </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Holder Name </span><a href="#/pencil"><i class="fa fa-pencil"></i></a>
                          <span class="value text-success"> <?php echo $holder_name; ?> </span>
                        </li>
                      </ul>
                      <br />

<!--
          <div class="form-group" align="center">
          <button name="cancel" type="reset" class="btn btn-info">Cancel</button>
          <button name="submit" type="submit" class="btn btn-success">Edit</button>
          </div>
-->
                      <div id="mainb" style="height:350px;"></div>

                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- /page content -->

      </div>
    </div>
