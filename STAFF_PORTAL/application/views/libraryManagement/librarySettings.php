<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
?>
    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
?>
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>
<?php
$warning = $this->session->flashdata('warning');
if ($warning) {
?>
    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
    </div>
<?php } ?>
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container  px-3">
    <!-- Page Header -->
    <!-- Page Header -->

    <div class="row mt-1 mb-2">
        <div class="col column_padding_card">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <div class="row c-m-b">
                        <div class="col-lg-9 col-sm-9 col-9">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">settings</i>Library Settings
                            </span>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-3 box-tools">
                        <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#category">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Category Info</h6>
            </div>
            <div id="category" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addCategory" action="<?php echo base_url() ?>addBookCategory" method="post" role="form">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                                </div>
                            </div>
                        </form>
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 ">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table_row_background">
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php if (!empty($categoryInfo)) {
                                            foreach ($categoryInfo as $category) { ?>
                                                <tr class="text-dark">
                                                    <td><?php echo $category->category_name; ?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-danger deleteBookCategory" href="#" data-row_id="<?php echo $category->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <td colspan="2" style="background-color: #83c8ea7d;">Category Not Found</td>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card End -->
            </div>
            <!--collapse End -->
        </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#author">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Author Info</h6>
            </div>
            <div id="author" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addAuthor" action="<?php echo base_url() ?>addBookAuthor" method="post" role="form">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="author" name="author" placeholder="Enter Author" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                                </div>
                            </div>
                        </form>
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 ">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table_row_background">
                                            <th>Author</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php if (!empty($authorInfo)) {
                                            foreach ($authorInfo as $author) { ?>
                                                <tr class="text-dark">
                                                    <td><?php echo $author->author_name; ?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-danger deleteBookauthor" href="#" data-row_id="<?php echo $author->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <td colspan="2" style="background-color: #83c8ea7d;">Author Not Found</td>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card End -->
            </div>
            <!--collapse End -->
        </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#publisher">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Publisher Info</h6>
            </div>
            <div id="publisher" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addPublisher" action="<?php echo base_url() ?>addBookPublisher" method="post" role="form">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Enter Publisher" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                                </div>
                            </div>
                        </form>
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 ">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table_row_background">
                                            <th>Publisher</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php if (!empty($publisherInfo)) {
                                            foreach ($publisherInfo as $publisher) { ?>
                                                <tr class="text-dark">
                                                    <td><?php echo $publisher->publisher_name; ?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-danger deleteBookPublisher" href="#" data-row_id="<?php echo $publisher->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <td colspan="2" style="background-color: #83c8ea7d;">Publisher Not Found</td>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card End -->
            </div>
            <!--collapse End -->
        </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#shelf">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Shelf No. Info</h6>
            </div>
            <div id="shelf" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addShelf" action="<?php echo base_url() ?>addBookShelf" method="post" role="form">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="shelf_no" name="shelf_no" placeholder="Enter Shelf No." autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                                </div>
                            </div>
                        </form>
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 ">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table_row_background">
                                            <th>Shelf No.</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php if (!empty($shelfInfo)) {
                                            foreach ($shelfInfo as $shelf) { ?>
                                                <tr class="text-dark">
                                                    <td><?php echo $shelf->shelf_no; ?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-danger deleteBookShelf" href="#" data-row_id="<?php echo $shelf->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <td colspan="2" style="background-color: #83c8ea7d;">Shelf Not Found</td>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card End -->
            </div>
            <!--collapse End -->
        </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#fineData">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Fine Info</h6>
            </div>
            <div id="fineData" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addFine" action="<?php echo base_url() ?>addBookFine" method="post" role="form">
                            <div class="row form-contents">
                                <div class="col-5">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="fine_name" name="fine_name" placeholder="Enter Fine Name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="fine_amount" name="fine_amount" placeholder="Amount" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                                </div>
                            </div>
                        </form>
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 ">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table_row_background">
                                            <th>Fine Name</th>
                                            <th>Fine Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php if (!empty($fineInfo)) {
                                            foreach ($fineInfo as $fine) { ?>
                                                <tr class="text-dark">
                                                    <td><?php echo $fine->fine_name; ?></td>
                                                    <td><?php echo $fine->fine_amount; ?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-danger deleteBookFine" href="#" data-row_id="<?php echo $fine->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <td colspan="3" style="background-color: #83c8ea7d;">Fine info Not Found</td>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card End -->
            </div>
            <!--collapse End -->
        </div>
    </div>
</div>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        jQuery(document).ready(function() {
            $('select').selectpicker();

            //delete Category
            jQuery(document).on("click", ".deleteBookCategory", function(){
                var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteBookCategory",
                currentRow = $(this);
                
                var confirmation = confirm("Are you sure to delete this Book Category ?");
                if(confirmation)
                {
                    jQuery.ajax({
                    type : "POST",
                    dataType : "json",
                    url : hitURL,
                    data : { row_id : row_id } 
                    }).done(function(data){
                            
                        currentRow.parents('tr').remove();
                        if(data.status = true) { alert("Book Category successfully deleted"); }
                        else if(data.status = false) { alert("Category deletion failed"); }
                        else { alert("Access denied..!"); }
                    });
                }
            });

            //delete Author
            jQuery(document).on("click", ".deleteBookauthor", function(){
                var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteBookauthor",
                currentRow = $(this);
                
                var confirmation = confirm("Are you sure to delete this Book Author ?");
                if(confirmation)
                {
                    jQuery.ajax({
                    type : "POST",
                    dataType : "json",
                    url : hitURL,
                    data : { row_id : row_id } 
                    }).done(function(data){
                            
                        currentRow.parents('tr').remove();
                        if(data.status = true) { alert("Book Author successfully deleted"); }
                        else if(data.status = false) { alert("Author deletion failed"); }
                        else { alert("Access denied..!"); }
                    });
                }
            });

            //delete Publisher
            jQuery(document).on("click", ".deleteBookPublisher", function(){
                var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteBookPublisher",
                currentRow = $(this);
                
                var confirmation = confirm("Are you sure to delete this Book Publisher ?");
                if(confirmation)
                {
                    jQuery.ajax({
                    type : "POST",
                    dataType : "json",
                    url : hitURL,
                    data : { row_id : row_id } 
                    }).done(function(data){
                            
                        currentRow.parents('tr').remove();
                        if(data.status = true) { alert("Book Publisher successfully deleted"); }
                        else if(data.status = false) { alert("Publisher deletion failed"); }
                        else { alert("Access denied..!"); }
                    });
                }
            });

            //delete Shelf
            jQuery(document).on("click", ".deleteBookShelf", function(){
                var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteBookShelf",
                currentRow = $(this);
                
                var confirmation = confirm("Are you sure to delete this Book Shelf No. ?");
                if(confirmation)
                {
                    jQuery.ajax({
                    type : "POST",
                    dataType : "json",
                    url : hitURL,
                    data : { row_id : row_id } 
                    }).done(function(data){
                            
                        currentRow.parents('tr').remove();
                        if(data.status = true) { alert("Book Shelf No. successfully deleted"); }
                        else if(data.status = false) { alert("Shelf deletion failed"); }
                        else { alert("Access denied..!"); }
                    });
                }
            });

            //delete fine info
            jQuery(document).on("click", ".deleteBookFine", function(){
                var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteBookFine",
                currentRow = $(this);
                
                var confirmation = confirm("Are you sure to delete this Book Fine Info ?");
                if(confirmation)
                {
                    jQuery.ajax({
                    type : "POST",
                    dataType : "json",
                    url : hitURL,
                    data : { row_id : row_id } 
                    }).done(function(data){
                            
                        currentRow.parents('tr').remove();
                        if(data.status = true) { alert("Book Fine Info successfully deleted"); }
                        else if(data.status = false) { alert("Fine Info deletion failed"); }
                        else { alert("Access denied..!"); }
                    });
                }
            });
        });
    </script>