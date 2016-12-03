<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">



<div class="">


<!-- table user -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Admin</li>
  <li class="active">Manage User</li>
</ol>

<!-- notification -->
       <?php if($this->session->flashdata('message')){?>
          <div class="alert alert-success">      
            <?php echo $this->session->flashdata('message')?>
          </div>
        <?php } ?>                
                    <div class="x_title">
                        <h2>Members<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-bordered" id='datatable'>
                            <thead>
                                <tr>
                                    <th>Member ID</th>
                                    <th>Full Name</th>
                                    <th>Date Join</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($usrlist as $row){?>
                                <tr>
                                    <td>
                                        <?php echo $row->usrname;?></td>
                                    <td>
                                        <?php echo $row->fname;?></td>
                                    <td>
                                        <?php echo $row->created_date; ?></td>
                                    <td><a href="<?php //echo site_url('Manage/edit_cycle/'.$id_cyc.''); ?>">Edit</a></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
<!-- end of table cycle-->

</div>
</div>

