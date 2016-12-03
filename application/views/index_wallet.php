

<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>
<div class="right_col" role="main">
<!--
<div class="x_title">
	<h2>Downline Registration<small></small></h2>
	<div class="clearfix"></div>
</div>
-->
<!--<div class="container">-->


<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="x_panel">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard');?>">Home</a></li>
  <li>Wallet</li>
  <li class="active">Wallet Transfer</li>
</ol>

	<?php echo $this->session->flashdata('msg'); ?>
    	<div class="x_title" align="right">
        	<small>Register Wallet:</small> <?php echo number_format($reg_rw);?>
        	| <small>Cash Wallet:</small> <?php echo number_format($ch_cw);?>
        	| <small>Total Balance:</small> <strong><?php echo number_format($reg_rw + $ch_cw);?></strong><br><br>
        	<h2>Wallet Transfer</h2>
        		<div class="clearfix"></div>
        	</div>

        <div class="x_content">
			<?php $attributes = array("name" => "signupform");
			echo form_open("wallet", $attributes);?>
			
			<div class="form-group">
				<!--<label for="usrnme">Member ID</label>-->
				<input class="form-control" id="amount" name="amount" placeholder="Amount transfer" type="number" value="<?php echo set_value('amount'); ?>" />
				<span class="text-danger"><?php echo form_error('amount'); ?></span>
			</div>

			<div class="form-group">

				<label for="package">Transfer to (Member ID)</label>
				<select class="form-control" name="transto">
				<?php foreach($members as $member) { ?>
                	<option value="<?php echo $member->usrname; ?>"><?php echo $member->usrname; ?></option>
				<?php } ?>	
				</select>

				<!--<label for="usrnme">Member ID</label>
				<input class="form-control" id="transto" name="transto" placeholder="Transfer to (Member ID)" type="text" value="<?php echo set_value('transto'); ?>"/>
				-->
				<span class="text-danger"><?php echo form_error('transto'); ?></span>
			</div>	

<!--
			<div class="form-group">
				<!--<label for="usrnme">Member ID</label>
				<input class="form-control" id="passwd" name="passwd" placeholder="Password.." type="Password" value="<?php echo set_value('passwd'); ?>" />
				<span class="text-danger"><?php echo form_error('passwd'); ?></span>
			</div>		
	
			<div class="form-group">
				<label for="from">From my</label>
                <select class="form-control" name="trans_from">
                	<option value="RW">Register Wallet</option>
                	<option value="CW">Cash Wallet</option>
                </select>
				<span class="text-danger"><?php echo form_error('trans_from'); ?></span>
			</div>

			<div class="form-group">
				<label for="from">To</label>
                <select class="form-control" name="trans_to">
                	<option value="RW">Register Wallet</option>
                	<option value="CW">Cash Wallet</option>
                </select>
				<span class="text-danger"><?php echo form_error('trans_to'); ?></span>
			</div>
-->
			<div class="form-group">
				<label for="from">Transfer type</label>
				<?php if ($reg_rw <= 0)
				{ ?>
                
                	<select class="form-control" name="transf_type">
                		<option value="CW">Cash Wallet</option>
                	</select>
					<span class="text-danger"><?php echo form_error('transf_type'); ?></span>
				
				<?php } elseif ($ch_cw <= 0) 
				{ ?>

					<select class="form-control" name="transf_type">
                		<option value="RW">Register Wallet</option>
                	</select>
					<span class="text-danger"><?php echo form_error('transf_type'); ?></span>

				<?php } else 
				{ ?>

					<select class="form-control" name="transf_type">
                		<option value="RW">Register Wallet</option>
                		<option value="CW">Cash Wallet</option>
                	</select>
					<span class="text-danger"><?php echo form_error('transf_type'); ?></span>

				<?php } ?>
			</div>

			<div class="form-group" align="right">
				<button name="cancel" type="reset" class="btn btn-info">Cancel</button>

				<?php if (($reg_rw <= 0) || ($ch_cw <=0))
				{ ?>

					<button disabled="disabled" name="submit" type="submit" class="btn btn-success">Transfer</button>

				<?php } else
				{ ?>

					<button name="submit" type="submit" class="btn btn-success">Transfer</button>

				<?php } ?>

			</div>
			<?php echo form_close(); ?>
			
		</div>
	</div>
</div>
</div>
</div>
<!--</div>-->

