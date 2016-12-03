<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">



<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Network & Bonus</li>
  <li class="active">Register Downline</li>
</ol>

	<?php echo $this->session->flashdata('msg'); ?>
    	<div class="x_title" align="right">
        	<small>Register Wallet:</small> <?php echo number_format($reg_rw);?>
        	| <small>Cash Wallet:</small> <?php echo number_format($ch_cw);?>
        	| <small>Total Balance:</small> <strong><?php echo number_format($reg_rw + $ch_cw);?></strong><br><br>
        	<h2>Signup New Member</h2>
        	<div class="clearfix"></div>
        </div>


  <div class="x_content2">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">


        <div class="x_content">
			<?php $attributes = array("name" => "signupform");
			echo form_open("reg_downline", $attributes);?>
			
			<div class="form-group">
				<!--<label for="usrnme">Member ID</label>-->
				<input class="form-control" id="usrnme" name="usrnme" placeholder="Member ID" type="text" value="<?php echo set_value('usrnme'); ?>" />
				<span class="text-danger"><?php echo form_error('usrnme'); ?></span>
			</div>			

			<div class="form-group">
				<label for="intro_name">Introducer</label>				
				<input class="form-control" readonly="readonly" name="intro_name" placeholder="<?php echo $usrname; ?>" type="text" value="<?php echo set_value($usrname); ?>" />
				<span class="text-danger"><?php echo form_error('usrname'); ?></span>
			</div>
	
			<div class="form-group">
				<label for="activ_metod">Active Method</label>
				
                <select class="form-control" name="activ_metod">
                	<!--<option value="RW">Register Wallet</option>-->
                	<option value="RWCW">Register Wallet + Cash wallet</option>
                </select>
				<span class="text-danger"><?php echo form_error('activ_metod'); ?></span>
<!--
				<label for="activ_metod">Total Balance:</label>
				<input class="form-control" readonly="readonly" name="activ_bal" placeholder="<?php echo number_format($reg_rw + $ch_cw);?>" type="text" value="<?php echo set_value('activ_bal'); ?>" />
				<span class="text-danger"><?php echo form_error('activ_bal'); ?></span>
-->
			</div>

			<div class="form-group">			
				<label for="package">Package</label>
				<!--<input class="form-control" name="password" placeholder="Password" type="password" />-->
				<!--
				<select class="form-control" name="package">
				<?php foreach($packages as $package) { ?>
                	<option value="<?php echo $package->package_code; ?>"><?php echo number_format($package->package_code); ?></option>
				<?php } ?>	
				</select>
				-->

				<!-- $reg_rw+$ch_cw -->

				<?php if ((($reg_rw) < 100*(70/100)) || ($ch_cw) < 100*(30/100))
				{
				echo "<select class='form-control' name='package' disabled='disabled'></select>";
				echo "<span class='text-danger'>You cannot register. Your balance RW or CW to low, please buy from Paymaster.</span>";
				} 
				elseif ((($reg_rw) >= 100*(70/100)) && (($reg_rw) < 300*(70/100)) || (($ch_cw) >= 100*(30/100)) && (($ch_cw) < 300*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
				</select>";
				}
				elseif ((($reg_rw) >= 300*(70/100)) && (($reg_rw) < 500*(70/100)) || (($ch_cw) >= 300*(30/100)) && (($ch_cw) < 500*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
				</select>";
				}
				elseif ((($reg_rw) >= 500*(70/100)) && (($reg_rw) < 750*(70/100)) || (($ch_cw) >= 500*(30/100)) && (($ch_cw) < 750*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
					<option value='500'>500</option>
				</select>";
				}
				elseif ((($reg_rw) >= 750*(70/100)) && (($reg_rw) < 1000*(70/100)) || (($ch_cw) >= 750*(30/100)) && (($ch_cw) < 1000*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
					<option value='500'>500</option>
					<option value='750'>750</option>
				</select>";
				}
				elseif ((($reg_rw) >= 1000*(70/100)) && (($reg_rw) < 3000*(70/100)) || (($ch_cw) >= 1000*(30/100)) && (($ch_cw) < 3000*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
					<option value='500'>500</option>
					<option value='750'>750</option>
					<option value='1000'>1,000</option>
				</select>";
				}
				elseif ((($reg_rw) >= 3000*(70/100)) && (($reg_rw) < 5000*(70/100)) || (($ch_cw) >= 3000*(30/100)) && (($ch_cw) < 5000*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
					<option value='500'>500</option>
					<option value='750'>750</option>
					<option value='1000'>1,000</option>
					<option value='3000'>3,000</option>
				</select>";					
				}
				elseif ((($reg_rw) >= 5000*(70/100)) && (($reg_rw) < 10000*(70/100)) || (($ch_cw) >= 5000*(30/100)) && (($ch_cw) < 10000*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
					<option value='500'>500</option>
					<option value='750'>750</option>
					<option value='1000'>1,000</option>
					<option value='3000'>3,000</option>
					<option value='5000'>5,000</option>
				</select>";
				}
				elseif ((($reg_rw) >= 10000*(70/100)) || (($ch_cw) >= 10000*(30/100)))
				{
				echo "<select class='form-control' name='package'>
					<option value='100'>100</option>
					<option value='300'>300</option>
					<option value='500'>500</option>
					<option value='750'>750</option>
					<option value='1000'>1,000</option>
					<option value='3000'>3,000</option>
					<option value='5000'>5,000</option>
					<option value='10000'>10,000</option>
				</select>";
				} ?>
			</div>
			<!-- end of select -->

			<div class="form-group">
				<label for="binary_pos">Binary Position</label>
				<!--<input class="form-control" name="cpassword" placeholder="Confirm Password" type="password" />-->
                <select class="form-control" name="binary_pos">
                	<option value="L">Left</option>
                	<option value="R">Right</option>
                </select>				
				<span class="text-danger"><?php echo form_error('binary_pos'); ?></span>
			</div>

			<br>
        	<div class="x_title">
        		<h2>Account Info<small></small></h2>
        		<div class="clearfix"></div>
        	</div>

			<div class="form-group">
				<!--<label for="fullname">Full Name</label>-->
				<input class="form-control" name="fullname" placeholder="Full Name" type="text" value="<?php echo set_value('fullname'); ?>" />
				<span class="text-danger"><?php echo form_error('fullname'); ?></span>
			</div>	

			<div class="form-group">
				<!--<label for="birthday">Date Of Birth</label>-->
				<input id="birthday" class="date-picker form-control" name="birthday" placeholder="Date Of Birth" type="text" value="<?php echo set_value('birthday'); ?>" />
				<span class="text-danger"><?php echo form_error('birthday'); ?></span>
			</div>	

			<div class="form-group">
				<label for="gen">Gender</label>
				<!--<input class="form-control" name="cpassword" placeholder="Confirm Password" type="password" />-->
                <select class="form-control" name="gen">
                	<option value="Male">Male</option>
                	<option value="Female">Female</option>
                </select>				
				<span class="text-danger"><?php echo form_error('gen'); ?></span>
			</div>	

			<div class="form-group">
				<!--<label for="contact-no">Contact No.</label>-->
				<input class="form-control" name="contact" placeholder="Contact No." type="text" value="<?php echo set_value('contact'); ?>" />
				<span class="text-danger"><?php echo form_error('contact'); ?></span>
			</div>		

			<div class="form-group">
				<!--<label for="contact-no">Contact No.</label>-->
				<input class="form-control" name="email" placeholder="Email" type="email" value="<?php echo set_value('email'); ?>" />
				<span class="text-danger"><?php echo form_error('email'); ?></span>
			</div>		

			<div class="form-group">
				<!--<label for="contact-no">Contact No.</label>-->
				<input class="form-control" name="national_id" placeholder="National ID" type="text" value="<?php echo set_value('national_id'); ?>" />
				<span class="text-danger"><?php echo form_error('national_id'); ?></span>
			</div>

			<div class="form-group">
				<!--<label for="contact-no">Contact No.</label>-->
				<textarea class="form-control" name="address" placeholder="Address" value="<?php echo set_value('address'); ?>" /></textarea>
				<span class="text-danger"><?php echo form_error('address'); ?></span>
			</div>

			<br>
        	<div class="x_title">
        		<h2>Nominee Info<small></small></h2>
        		<div class="clearfix"></div>
        	</div>

			<div class="form-group">
				<!--<label for="contact-no">Contact No.</label>-->
				<input class="form-control" name="nominee_name" placeholder="Nominee Name" type="text" value="<?php echo set_value('nominee-name'); ?>" />
				<span class="text-danger"><?php echo form_error('nominee_name'); ?></span>
			</div>

			<div class="form-group">
				<!--<label for="contact-no">Contact No.</label>-->
				<input class="form-control" name="nominee_contact" placeholder="Nominee Contact No" type="text" value="<?php echo set_value('nominee_contact'); ?>" />
				<span class="text-danger"><?php echo form_error('nominee_contact'); ?></span>
			</div>

			<div class="form-group">
				<label for="declaration">
				<input id="declare" type="checkbox" class="flat" name="declaration" value="Yes"> I hereby declare that all information given on this form is true and accurate. By accepting this declaration forms an aggrement between me and EuroZoneGlobal or its subsidiaries. I agree and accept that if any part of this declaration is found to be false or incorrect, EuroZoneGlobal or its subsidiaries reserve the right to terminate my account contract immediately without any prior notification.</label>
				<!--<input class="form-control" name="nominee-contact-no" placeholder="Nominee Contact No" type="text" value="<?php echo set_value('nominee-contact-no'); ?>" />-->
				<span class="text-danger"><?php echo form_error('declaration'); ?></span>
			</div>

			<div class="form-group" align="right">
				<button name="cancel" type="reset" class="btn btn-info">Cancel</button>
				<?php if ((($reg_rw) < 100*(70/100)) || ($ch_cw) < 100*(30/100))
				{ ?>
					<button name="submit" type="submit" disabled="disabled" class="btn btn-success">Signup</button>
				<?php } else { ?>
					<button name="submit" type="submit" class="btn btn-success">Signup</button>
				<?php } ?>
			</div>
			<?php echo form_close(); ?>
			
		</div>
		</div></div></div></div>
	</div>
</div>
</div>
</div>
</div>


