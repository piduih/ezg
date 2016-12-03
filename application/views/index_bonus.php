<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">
<div class="row"><!--start div row -->


<!-- table user -->
<div class="col-xs-12 col-sm-6 col-md-8">
    <div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Network & Bonus</li>
  <li class="active">Bonus List</li>
</ol>
              
                    <div class="x_title">
                        <h2>Bonus Paring List<small>Calculated at 12am daily</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-bordered" cellspacing="0" id='datatable'>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($bonus as $row){?>
                                <tr>
                                    <td><?php echo date("d-m-Y", strtotime($row->bi_date)); ?></td>
                                    <td><?php echo $row->bi_amount;?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
<!-- end of table user-->


</div><!--end div row-->

<div class="row"><!--start div row -->
<!-- table user -->
<div class="col-xs-6 col-md-4">
    <div class="x_panel">
               
    <div class="x_title">
        <h2>Leg - Left<small></small></h2>
        <div class="clearfix"></div>
    </div>                
    <div class="x_content">
        <table class="table table-striped table-bordered" cellspacing="0" id=''>
        <thead>
            <tr>
            <th>Total Left</th>
            </tr>
        </thead>
        <tbody>
        <?php //foreach($dnline as $row){?>
            <tr>
            <td><?php echo $sumpacleft; ?></td>
            </tr>
        <?php //}?>
        </tbody>
        </table>

    </div>
    </div>
</div>
<!-- end of table user-->


<!-- table user -->
<div class="col-xs-6 col-md-4">
    <div class="x_panel">
               
    <div class="x_title">
        <h2>Leg - Right<small></small></h2>
        <div class="clearfix"></div>
    </div>                
    <div class="x_content">
        <table class="table table-striped table-bordered" cellspacing="0" id=''>
        <thead>
            <tr>
            <th>Total Right</th>
            </tr>
        </thead>
        <tbody>
        <?php //foreach($dnline as $row){?>
            <tr>
            <td><?php echo $sumpacright; ?></td>
            </tr>
        <?php //}?>
        </tbody>
        </table>

    </div>
    </div>
</div>
<!-- end of table user-->

</div><!--end div row-->
</div><!--end div main-->





