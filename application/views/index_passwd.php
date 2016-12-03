<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">



<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Profile</li>
  <li class="active">Change Password</li>
</ol>

  <?php echo $this->session->flashdata('msg'); ?>

      <div class="x_title" align="right">
          <h2>Change Password</h2>
          <div class="clearfix"></div>
        </div>


  <div class="x_content2">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

<?php $this->load->library('form_validation');?>
<?php echo validation_errors('<div class="alert alert-danger text-center">', '</div>');?>
<div class="content">

<?php echo form_open('profile'); ?>
<table class="table table-bordered">

<tbody>
<!--
<tr>
<td><small><?php echo "Old Password:";?></small></td>
<td><?php echo form_password('opassword');?></td>
</tr>
-->
<tr>
<td><?php echo "New Password:";?></td>
<td><?php echo form_password('npassword');?></td>

</tr>
<tr>
<td><?php echo "Confirm Password:";?></td>
<td><?php echo form_password('cpassword');?></td>
</tr>
</tbody>
</table>
&nbsp;&nbsp;<div align="right" id="some"style="position:relative;"><button type="submit" class="btn btn-primary"><i class=" icon-ok-sign icon-white"></i>&nbsp;Submit</button>

<?php

echo form_close();

?>
</div>
    </div>
    </div></div></div></div>
  </div>
</div>
</div>
</div>
</div>