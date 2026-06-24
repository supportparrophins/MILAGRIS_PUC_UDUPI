<div class="col-md-12">

    <?php

        $this->load->helper('form');

        $error = $this->session->flashdata('error');

        if($error)

        {

    ?>

    <div class="alert alert-danger alert-dismissable">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <?php echo $this->session->flashdata('error'); ?>                    

    </div>

    <?php } ?>

    <?php  

        $success = $this->session->flashdata('success');

        if($success)

        {

    ?>

    <div class="alert alert-success alert-dismissable">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <?php echo $this->session->flashdata('success'); ?>

    </div>

    <?php } ?>



    <?php  

        $noMatch = $this->session->flashdata('nomatch');

        if($noMatch)

        {

    ?>

    <div class="alert alert-warning alert-dismissable">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <?php echo $this->session->flashdata('nomatch'); ?>

    </div>

    <?php } ?>

    

    <div class="row">

        <div class="col-md-12">

            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>

        </div>

    </div>

</div>

<div class="main-content-container container-fluid px-4">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <div class="row mt-1 mb-2">

            <div class="col padding_left_right_null">

            <div class="card card-small p-0 card_head_dashboard">

                <div class="card-body p-2 ml-2">

                <span class="page-title">

                    <i class="fa fa-book"></i> Study Materials

                </span>

                <a onclick="window.history.back();" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>

                </div>

            </div>

            </div>

        </div>

    </section>

    <div class="row form-employee">

        <div class="col-12 padding_left_right_null">

            <div class="card card-small c-border p-2">

                <form action="<?php echo base_url(); ?>viewstudyMaterials" method="POST" id="byFilterMethod">

                    <div class="row">

                        <div  class="col-lg-3 col-md-3 col-12"> 

                            <div class="form-group position-relative mb-1">

                                <input class="form-control mobile-width" value="<?php echo $searchName; ?>" type="text" name="by_name" id="name" class="form-control input-sm"  style="text-transform: uppercase" placeholder="By Document Name" autocomplete="off">

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-12">  

                            <div class="form-group mb-1">

                                <select class="form-control" id="exampleFormControlSelect1" name="by_type" id="by_type">

                                <?php if(!empty($searchType)){ ?>

                                    <option value="<?php echo $searchType; ?>" selected><b>Selected: <?php echo $searchType; ?></b></option>

                                <?php } ?>

                                <option value="">By Document Type</option>

                                <option value="Question Paper">Question Paper</option>

                                <option value="E-book">E-book</option>

                                <option value="Notes">Notes</option>

                                <option value="Other">Other</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-12"> 

                            <div class="form-group mb-1">

                                <input class="form-control mobile-width" value="<?php echo $searchDescription; ?>" type="text" name="by_description" id="by_description" class="form-control input-sm"  style="text-transform: uppercase" placeholder="By Description" autocomplete="off">

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-12"><button type="submit"class="btn btn-success btn-block mobile-width"> Search</button></div>

                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>Material Name</th>

                                <th class="text-center">Type</th>

                                <th class="text-center">Description</th>

                                <th class="text-center">Action</th>

                            </tr>

                        </thead>

                        <?php 

                            if(!empty($studyMaterialInfo)){

                            foreach($studyMaterialInfo as $studyMaterial){ 

                        ?>

                            <tr>

                                <td><?php echo date('d-m-Y', strtotime($studyMaterial->created_date_time)); ?></td>

                                <td><img src="<?php echo base_url(); ?>assets/dist/img/pdf.png" width="20"> <?php echo $studyMaterial->name; ?></td>

                                <td class="text-center"><?php echo $studyMaterial->type; ?></td>

                                <td class="text-center"><?php echo $studyMaterial->description; ?></td>

                                <td width="200" class="text-center">

                                    <a  href="<?php echo ADMIN_PATH.$studyMaterial->document_name_url; ?>" download target="_blank"  class="btn btn_download p-2" ><i class="fa fa-download"></i></a>

                                    <a href="<?php echo ADMIN_PATH.$studyMaterial->document_name_url; ?>" target="_blank"class="btn btn-primary p-2"><i class="fa fa-eye"></i> View</a></td>

                            </tr>

                        <?php } }else{?>

                            <tr>



                                <td colspan="5" class="text-center">Study Material not found!</td>

                                

                            </tr>

                        <?php } ?>

                        

                    </table>

                    <?php echo $this->pagination->create_links(); ?>

                </div>

            </div>

        </div>

    </div>  

</div>

<script type="text/javascript">

    jQuery('ul.pagination li a').click(function (e) {

        e.preventDefault();            

        var link = jQuery(this).get(0).href;            

        var value = link.substring(link.lastIndexOf('/') + 1);

        jQuery("#byFilterMethod").attr("action", baseURL + "viewstudyMaterials/" + value);

        jQuery("#byFilterMethod").submit();

    });

});

</script>