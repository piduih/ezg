<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<div class="right_col" role="main">

    <div class="x_title">
        <h2>Downline<small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="row">    
                <!--*************************  START  DISPLAY ALL THE RECODEDS *************************-->
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List<small></small></h2>
                       
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Package</th>
                                    <th>Introducer</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach($downline as $dl){?>
                                <tr>
                                    <td>
                                        <?=$dl->fname;?></td>
                                    <td>
                                        <?=number_format($dl->package_code);?></td>
                                    <td>
                                        <?=$dl->introducer_name;?></td>
                                </tr>

                                <?php }?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
<!--*********************  END  DISPLAY ALL THE RECODEDS ******************************-->
        </div>
    </div>

</div>

