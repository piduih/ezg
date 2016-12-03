<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">

                <div class="x_title">
                    <h2>Downline Registration<small></small></h2>

                    <div class="clearfix"></div>
                </div>
                
                <?php echo validation_errors(); ?>

                <?php // echo form_open('Reg_downline/submit_data'); ?>

            <?php $attributes = array("name" => "signupform");
            echo form_open("Reg_downline", $attributes);?>

               <form method="post" action="<?php echo site_url('reg_downline/submit_data');?>" name="data_register" id="reg_mbr" data-parsley-validate class="form-control">
                    <!-- -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">

                        <div class="x_panel">
                                    <div class="x_title">
                                    <h2>Register New Member</h2>
                                    </br>
                                    </br>
                                    <small>Cash Wallet Balance: 0.00</br>Register Wallet Balance: 0.00</small>

                                    <div class="clearfix"></div>
                                </div>

                                <br />

                                    <div class="form-group">
                                        <label for="uname" class="control-label col-md-3 col-sm-3 col-xs-12">Member ID </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="username" value="<?php echo set_value('username'); ?>" id="uname"  class="form-control col-md-7 col-xs-12">
                                            <span class="text-danger"><?php echo form_error('username'); ?></span>
                                        </div>
                                    </div>
<!--
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Activation Method</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="activ_metod">
                                                <option value="RWCW">Register Wallet + Cash Wallet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Package</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="package">
                                                <option value="1">100</option>
                                                <option value="2">300</option>
                                                <option value="3">500</option>
                                                <option value="4">750</option>
                                                <option value="5">1000</option>
                                                <option value="6">3000</option>
                                                <option value="7">5000</option>
                                                <option value="8">10000</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Binary Position</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="binary_pos">
                                                <option value="L">Left</option>
                                                <option value="R">Right</option>
                                            </select>
                                        </div>
                                    </div>
                        </div>
                        </div>
                    </div>
-->
                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Introducer Info<small></small></h2>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="intro" class="control-label col-md-3 col-sm-3 col-xs-12">Introducer </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="intro" name="introducer"  class="form-control col-md-7 col-xs-12" value="<?php echo set_value('introducer'); ?>">
                                        </div>
                                    </div>
                        </div>
                        </div>
                    </div>
<!--
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Account Info<small></small></h2>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname" class="control-label col-md-3 col-sm-3 col-xs-12">Full Name </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" required="required" id="fullname" name="fname" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday" class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="birthday" required="required" class="date-picker form-control col-md-7 col-xs-12"  type="text" name="dob">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="gen" class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select id="gen" class="form-control" name="gender">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-no" class="control-label col-md-3 col-sm-3 col-xs-12">Contact No.
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input required="required" type="text" id="contact-no"  class="form-control col-md-7 col-xs-12" name="contact">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="e-mail">Email
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input required="required" type="email" id="e-mail" class="form-control col-md-7 col-xs-12" name="email" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="national-id">National ID
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input required="required" type="text" id="national-id" class="form-control col-md-7 col-xs-12" name="national_id" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="add" class="control-label col-md-3 col-sm-3 col-xs-12">Address
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                          <textarea class="form-control" rows="3" name="address" required="required" ></textarea>
                                        </div>
                                    </div> 
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Nominee Info<small></small></h2>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nominee-name">Nominee Name
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="nominee-name" class="form-control col-md-7 col-xs-12" name="nominee_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nominee-contact-no">Nominee Contact No
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="nominee-contact-no" class="form-control col-md-7 col-xs-12" name="nominee_contact">
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="checkbox">
                                        <label for="declare">
                                            <input id="declare" type="checkbox" class="flat" name="declaration" value="Yes" required="required"> I hereby declare that all information given on this form is true and accurate. By accepting this declaration forms an aggrement between me and EuroZoneGlobal or its subsidiaries. I agree and accept that if any part of this declaration is found to be false or incorrect, EuroZoneGlobal or its subsidiaries reserve the right to terminate my account contract immediately without any prior notification.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12" align="right">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>


                            </form>
                            <script>
                                $("#reg_mbr").validate();
                            </script>
                </div>
            </div>





        </div>

</div>
