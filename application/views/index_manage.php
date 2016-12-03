<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">



<div class="">


<!-- table cycle -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Admin</li>
  <li class="active">Setting</li>
</ol>

<!-- notification -->
       <?php if($this->session->flashdata('message')){?>
          <div class="alert alert-success">      
            <?php echo $this->session->flashdata('message')?>
          </div>
        <?php } ?>
                    <div class="x_title">
                        <h2>Cycle<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-bordered" id='basic'>
                            <thead>
                                <tr>
                                    <th>Cycle</th>
                                    <th>Update by</th>
                                    <th>Update date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo $cyc_days;?> days</td>
                                    <td>
                                        <?php echo $up_by;?></td>
                                    <td>
                                        <?php echo $up_date; ?></td>
                                    <td><a href="<?php echo site_url('Manage/edit_cycle/'.$id_cyc.''); ?>">Edit</a></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
<!-- end of table cycle-->

</div>
</div>

