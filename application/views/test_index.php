<div id="container" class="container" >

<!--******************** START SESSION SETFLASH MESSAGES *****************************-->
       <?php if($this->session->flashdata('message')){?>
          <div class="alert alert-success">      
            <?php echo $this->session->flashdata('message')?>
          </div>
        <?php } ?>
<!--************************* END SESSION SETFLASH MESSAGES   ************************-->


        <br>
        <div align="center"> 
          <a href="<?php echo site_url('Welcome/add_data'); ?>">Click to add new Record</a>
        </div>
        <br>


<!--*************************  START  DISPLAY ALL THE RECODEDS *************************-->
        <table class="table table-bordered table-hover table-striped" >
            <thead>
            <tr>
                <th>No.</th>
                <th>User name</th>
                <th>Email</th>
                <th>Sex</th>
                <th>Address</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody>
              <?php
                if(isset($view_data) && is_array($view_data) && count($view_data)): $i=1;
                foreach ($view_data as $key => $data) { 
                ?>
                <tr <?php if($i%2==0){echo 'class="even"';}else{echo'class="odd"';}?>>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['username']; ?></td>            
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['sex']; ?></td>
                    <td><?php echo $data['address']; ?></td>
                    <td><a href="<?php echo site_url('Welcome/edit_data/'. $data['id'].''); ?>">Edit</a></td>            
                    <td><a href="<?php echo site_url('Welcome/delete_data/'. $data['id'].''); ?>">Delete</a></td>
                </tr>
                <?php
                    $i++;
                      }
                    else:
                ?>
                <tr>
                    <td colspan="7" align="center" >No Records Found..</td>
                </tr>
                <?php
                    endif;
                ?>

            </tbody>                                
        </table>
<!--*********************  END  DISPLAY ALL THE RECODEDS ******************************-->
</div>