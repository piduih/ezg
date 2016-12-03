<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Profile</li>
  <li class="active">Change Password</li>
</ol>

<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="x_panel">
  <?php echo $this->session->flashdata('msg'); ?>
      <div class="x_title" align="right">
          <h2>Change Password</h2>
          <div class="clearfix"></div>
        </div>


  <div class="x_content2">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

        <?php echo validation_errors();?>

        <div class="x_content">
      <?php echo form_open('profile/changepwd'); ?>
      
      <div class="form-group">
        <!--
        <label for="usrnme">Member ID</label>
        <input class="form-control" id="currpass" name="currpass" placeholder="Current password" type="password" value="<?php echo set_value('currpass'); ?>" />
        <span class="text-danger"><?php echo form_error('currpass'); ?></span>
        -->
        <td><small><?php echo "Old Password:";?></small></td>
        <td><?php echo form_password('opassword');?></td>
      </div> 

      <div class="form-group">
        <!--<label for="usrnme">Member ID</label>-->
        <!--
        <input class="form-control" id="newpass" name="newpass" placeholder="New password" type="password" value="<?php echo set_value('newpass'); ?>" />
        <span class="text-danger"><?php echo form_error('newpass'); ?></span>
        -->
        <td><small><?php echo "New Password:";?></small></td>
        <td><?php echo form_password('npassword');?></td>
      </div>  

      <div class="form-group">
        <!--<label for="usrnme">Member ID</label>-->
        <!--
        <input class="form-control" id="confpass" name="confpass" placeholder="Confirm password" type="password" value="<?php echo set_value('confpass'); ?>" />
        <span class="text-danger"><?php echo form_error('confpass'); ?></span>
        -->
        <td><small><?php echo "Confirm Password:";?></small></td>
        <td><?php echo form_password('cpassword');?></td>
      </div>      


      <div class="form-group" align="right">
        <button name="cancel" type="reset" class="btn btn-info">Cancel</button>
        <button name="submit" type="submit" class="btn btn-success">Update</button>
      </div>
      <?php echo form_close(); ?>
      
    </div>
    </div></div></div></div>
  </div>
</div>
</div>
</div>
</div>


