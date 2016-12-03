<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">
<div class="">

<div id="container" class="container">

<div class="row">
 <div class="col-md-8 col-md-offset-2">
        <h2 class="text-center">Edit data Form in codeignter sample </h2>
        <br><br>
    <?php
      if(isset($view_data) && is_array($view_data) && count($view_data)): $i=1;
      foreach ($edit_data as $key => $data) { 
    ?>
    <form method="post" action="<?php echo site_url('Manage/update_cycle/'.$id_cyc.''); ?>" name="data_register">
        <label for="Name">Cycle days</label>
        <input type="text" class="form-control" name="cycle" value="<?php echo $data['cycle_days']; ?>" required >
        <br><br>
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
        <br><br>
    </form>
     <?php
        }endif;
     ?>
    <br><br>
 </div>
</div>
  
</div>
</div>
</div>