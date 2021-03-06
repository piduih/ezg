<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">



<div class="row">


<!-- table user -->
            <div class="col-xs-12 col-sm-6 col-md-8">
                <div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Cash</li>
  <li class="active">Cash Transaction</li>
</ol>

<!-- notification -->
       <?php if($this->session->flashdata('message')){?>
          <div class="alert alert-success">      
            <?php echo $this->session->flashdata('message')?>
          </div>
        <?php } ?>                
                    <div class="x_title">
                        <h2>Cash Transaction<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-bordered" id='datatable'>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Amount DB</th>
                                    <th>Amount KT</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($casht as $row){?>
                                <tr>
                                    <td>
                                        <?php echo date("d-m-Y", strtotime($row->ch_date)); ?></td>
                                    <!--<td><a href="<?php //echo site_url('Manage/edit_cycle/'.$id_cyc.''); ?>">Edit</a></td>-->
                                    <td>
                                        <?php echo $row->ch_from;?></td>
                                    <td>
                                        <?php echo $row->ch_to;?></td>
                                    <td>
                                        <?php if (($row->ch_amount) >= 0) { echo number_format($row->ch_amount); } ?></td>
                                    <td>
                                        <?php if (($row->ch_amount) < 0) { echo number_format($row->ch_amount); } ?></td>
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

