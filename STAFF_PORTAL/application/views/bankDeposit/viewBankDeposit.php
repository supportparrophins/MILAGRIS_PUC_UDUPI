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



<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fa fa-book"></i> Bank Deposit </span>
                            </span>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4 text-center">
                            <b class="text-dark" style="font-size: 20px;">Total Deposits: <?php echo $bankRecordsCount; ?></b>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4">
                            <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_LIBRARY || $role == ROLE_PRINCIPAL || $role == VICE_PRINCIPAL || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) {
                            if($accessInfo->can_add == 1){
                                ?>
                            <button class="btn btn-primary float-right mobile-btn border_right_radius" data-toggle="modal" data-target="#addNewDocModel"><i
                                    class="fa fa-plus"></i> Add New</button>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">

                <div class="table-responsive-sm">
                    <table class="table table-hover table-bordered mb-0">
                        <tr class="row_filter">
                            <form action="<?php echo base_url() ?>viewBankDeposit" method="POST" id="byFilterMethod">

                                <th>
                                    <input type="text" name="by_date" id="by_date" value="<?php echo $by_date ?>"
                                        class="form-control input-sm pull-right datepicker"
                                        placeholder="By Date" autocomplete="off"/>
                                </th>
                                <th>
                                    <input type="text" name="by_name" id="by_name" value="<?php echo $by_name ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By name" />
                                </th>
                                <th>
                                    <input type="text" name="by_amount" id="by_amount" value="<?php echo $by_amount ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By amount" />
                                </th>
                                <th>
                                    <input type="text" name="deposit_type" id="deposit_type" value="<?php echo $deposit_type ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By Type" />
                                </th>
                                <th>
                                    <input type="text" name="deposit_account" id="deposit_account" value="<?php echo $deposit_account ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By account" />
                                </th>
                               
                                <th>
                                    <input type="text" name="doc_name" id="doc_name" value="<?php echo $doc_name ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By Document" />
                                </th>
                                <th>
                            </th>
                                <th class="text-center"><button type="submit"
                                        class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button></th>
                            </form>
                        </tr>

                        <tr class="table_row_background text-dark text-center">

                            <th width="100">Date</th>
                            <th>Depositer Name</th>
                            <th>Deposit Amount</th>
                            <th>Deposit Type</th>
                            <th>Deposit Account</th>
                            <th>Document</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                    if(!empty($bankRecords))
                    {
                        foreach($bankRecords as $record)
                        {
                    ?>
                        <tr>

                            <td class="text-center"><?php echo date('d-m-Y',strtotime($record->date)); ?> </td>
                            <td class="text-center"><?php echo $record->depositer_name; ?></td>
                            <td class="text-center"><?php echo $record->amount; ?></td>
                            <td class="text-center"><?php echo $record->deposit_type; ?></td>
                            <td class="text-center"><?php echo $record->deposit_account; ?></td>
                            <td class="text-center"><a href="<?php echo base_url().$record->document_name_url; ?>" download>Download</a>
                            </td>
                            <td><?php echo $record->description; ?></td>
                            <td class="text-center">
                                <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_LIBRARY || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) { ?>
                                <?php if($accessInfo->can_delete == 1) { ?>
                                <a class="btn btn-sm btn-danger deleteBank px-2 py-1" href="#"
                                    data-row_id="<?php echo $record->row_id; ?>" title="Delete Staff"><i
                                        class="fa fa-trash"></i></a>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php
                        }
                    }else{ ?>
                        <tr class="card_heading_title text-dark">
                            <td class="text-center" colspan="9">
                                Bank Deposit not found!.
                            </td>
                        </tr>
                        <?php }
                        ?>

                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- The Modal -->
<div class="modal" id="addNewDocModel">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Bank Deposit</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body --> 
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>addNewBankDeposit" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="text-center" id="alertMsg"></div>
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <div class="form-group">
                                    <label for="date">Select Date:</label>
                                    <input type="text" class="form-control required" id="date"
                                        name="date" placeholder="Date" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label for="depositer_name">Depositer Name</label>
                                    <input type="text" class="form-control required" id="depositer_name"
                                        name="depositer_name" placeholder="Depositer Name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-6">
                                <div class="form-group">
                                    <label for="amount">Deposite Amount</label>
                                    <input type="text" class="form-control required" id="amount"
                                        name="amount" placeholder="Deposit Amount" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label for="deposit_type">Deposite Type</label>
                                    <select class="form-control input-sm" id="deposit_type" name="deposit_type" required>
                                        <?php if(!empty($deposit_type)){ ?>
                                        <option value="<?php echo $deposit_type; ?>">Selected: <?php echo $deposit_type; ?></option>
                                        <?php } ?>
                                        <option value="">Select Deposit Type</option>
                                        <?php if(!empty($deposittypeInfo)){  
                                            foreach($deposittypeInfo as $record){ ?>
                                        <option value="<?php echo $record->deposit_type; ?>"><?php echo $record->deposit_type; ?></option>
                                        <?php } } ?>
                                    </select>
                                    <!-- <input type="text" class="form-control required" id="by_type"
                                        name="by_type" placeholder="Deposit Type" autocomplete="off" required> -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label for="deposit_account">Deposit Account</label>
                                    <select class="form-control input-sm" id="deposit_account" name="deposit_account" required>
                                        <?php if(!empty($deposit_account)){ ?>
                                        <option value="<?php echo $deposit_account; ?>">Selected: <?php echo $deposit_account; ?></option>
                                        <?php } ?>
                                        <option value="">Select Deposit account</option>
                                        <?php if(!empty($depositaccountInfo)){  
                                            foreach($depositaccountInfo as $record){ ?>
                                        <option value="<?php echo $record->deposit_account; ?>"><?php echo $record->deposit_account; ?></option>
                                        <?php } } ?>
                                    </select>
                                    <!-- <input type="text" class="form-control required" id="by_account"
                                        name="by_account" placeholder="Deposit Account" autocomplete="off" required> -->
                                </div>
                            </div>
                                            </div>
                    
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <img src="<?php echo base_url(); ?>assets/images/file.png" class="avatar  img-thumbnail"
                                        width="50" height="10" src="#" id="uploadedImage" name="userfile" width="80"
                                        height="80" alt="avatar">
                                    <label for="fname">Select a Document(Upload Slip)</label>
                                    <input type="file" class="form-control" id="doc_path" name="doc_path" required>
                                </div>
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Write Remarks here..."
                                        id="description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-3">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bankDeposit.js" charset="utf-8"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('.selectpicker').selectpicker('refresh');

    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    $(document).ready(function() {
    $("#date").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    });
});
    
    $('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate : 0,
        startDate : "01-03-2020",
    });

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "viewBankDeposit/" + value);
        jQuery("#searchList").submit();
    });

});
</script>