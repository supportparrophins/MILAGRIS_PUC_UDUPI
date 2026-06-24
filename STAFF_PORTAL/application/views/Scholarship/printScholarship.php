<style>
.break {
    page-break-before: always;
}

.break_after {
    page-break-before: none;
}



table {

    width: 100% !important;

}



/*.border{

    border: 2px solid black;

}*/

.text-center {
    text-align: center;
}
.text-white {
    color: white;
}


.border_full {

    border: 1px solid black;

    /* height: 90% !important; */

}

.border_bottom {

    border-bottom: 1px solid black;

}

.hr_line {

    margin: 0px;

    color: black;

}



.table_bordered {

    border-collapse: collapse;

}

.table_bordered th,
.table_bordered td {

    border-top: 1px solid black;

    border-right: 1px solid black;

    padding: 6px;

}



.table_bordered th .border_right_none,
.table_bordered td .border_right_none {

    border-right: 1px solid transparent !important;

}
.table {
            width: 100%;
            border-collapse: collapse;
        }
        .text_highlight {
            font-family: Arial, sans-serif;
        }
        .mt-2 {
            margin-top: 20px;
        }
        
        .mt-0 {
            margin-top: 0;
        }
        .logo {
            display: block;
            margin: 0 auto;
        }
        .title {
            font-size: 19px;
            margin: 0;
        }
        .address {
            font-size: 16px;
            margin: 0;
        }
</style>

<?php 
 

?>

<div class="container border_full">
    <!-- Header Section -->
    <div class="row">
        <table class="table text_highlight mt-0">
            <tr>
                <td class="text-center" width="20%">
                    <img class="mt-0 logo" width="100" height="100" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                </td>
                <td width="80%">
                <div class="text-center">
                    <b class="title"> &emsp;&nbsp; &emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo SCHOLARSHIP_TITLE; ?></b><br>
                    <p class="address"> &emsp;&nbsp;<?php echo SCHOLARSHIP_ADDRESS; ?>
                     </p>
                </div>
            </td>
            </tr>
        </table>
    </div>
    
   

    <!-- Scholarship Information Section -->
    <table class="table-bordered text-highlight" style="width: 100%; border-collapse: collapse;">
    <!-- Table Header -->
    <tr>
        <td colspan="4" class="text-center text-white" style="background-color: #4e73df; padding: 8px; font-size: 18px; font-weight: bold;">
            SCHOLARSHIP DETAILS
        </td>
    </tr>

    <!-- Profile Image Row -->
    <tr>
        <td style="background:white;"  rowspan="2" width="25%" class="p-0">
            <div class="profile-img" style="padding: 8px;">
                <?php
                    $profileImg = $scholarshipRecords->photo_url;
                    if(!empty($profileImg)){ ?>
                        <img src="<?php echo base_url(); ?><?php echo $profileImg; ?>" class="img-thumbnail" alt="Profile Image" style="width: 100px; height: 100px;">
                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="img-thumbnail" alt="Profile default" style="width: 100px; height: 100px;">
                <?php } ?>
            </div>
        </td>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left" width="25%"><b>NAME</b></td>
        <td style="padding: 8px; font-size: 13px; text-align:left" width="25%" colspan="2"><?php echo strtoupper($scholarshipRecords->student_row_id); ?></td>
    </tr>

    <!-- Scholarship Information Rows -->
    <tr>
        
    <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left" width="25%"><b>APPLICATION NUMBER</b></td>
    <td style="padding: 8px; font-size: 13px; text-align:left" colspan="2"><?php echo $scholarshipRecords->application_number; ?></td>
        
    </tr>
    <tr>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>SOCIETY</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->scholarship_society); ?></td>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>TERM NAME</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->term_name); ?></td>
    </tr>
    <tr>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>SCHOLARSHIP CODE</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->scholarship_code); ?></td>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>SCHOLARSHIP TYPE</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->scholarship_type); ?></td>
    </tr>

    <tr>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>APPLICATION DATE</b></td>
        <td style="padding: 8px; text-align:left"><?php echo date('d-m-Y', strtotime($scholarshipRecords->application_date)); ?></td>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>AMOUNT REQUESTED</b></td>
        <td style="padding: 8px; text-align:left"><?php echo $scholarshipRecords->amount_requested; ?></td>
    </tr>

    <tr>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px;text-align:left"><b>SCHOLARSHIP AMOUNT</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->scholarship_amount); ?></td>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>PAYMENT DATE</b></td>
        <td style="padding: 8px; text-align:left"><?php echo date('d-m-Y', strtotime($scholarshipRecords->payment_date)); ?></td>
    </tr>

    <tr>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>DEBIT A/C NO.</b></td>
        <td style="padding: 8px;text-align:left"><?php echo strtoupper($scholarshipRecords->debit_ac_no); ?></td>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>CREDIT A/C NO.</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->credit_ac_no); ?></td>
    </tr>

    <tr>
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; text-align:left"><b>RECOMMENDED BY</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->recommended_by); ?></td>
        
    </tr><td style="background-color: #f4f4f4; padding: 8px; font-size: 13px;text-align:left"><b>SANCTIONED BY</b></td>
        <td style="padding: 8px; text-align:left"><?php echo strtoupper($scholarshipRecords->sanctioned_by); ?></td>

    <tr>
    <!-- <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; border-bottom: 1px solid black; text-align:left"><b>TERM NAME</b></td>
    <td style="padding: 8px; font-size: 13px; border-bottom: 1px solid black; text-align:left"><?php //echo $scholarshipRecords->term_name; ?></td> -->
        <td style="background-color: #f4f4f4; padding: 8px; font-size: 13px; border-bottom: 1px solid black; text-align:left"><b>REMARKS</b></td>
        <td style="padding: 8px; font-size: 13px; border-bottom: 1px solid black; text-align:left" colspan="3"><?php echo $scholarshipRecords->remarks; ?></td>
        
    </tr>
</table>


    <br>

   <!-- Document Checklist Section -->
<table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; border-radius: 5px; overflow: hidden;">
    <thead class="thead-light" style="background-color: #4e73df; color: #fff; text-align: center;">
        <tr>
            <th class="text-center text-black" style="padding: 12px; font-size: 14px; border-right: 1px solid #dee2e6; background-color: #4e73df; font-weight: bold;">SUBMISSION OF DOCUMENTS</th>
            <th class="text-center text-black" style="padding: 12px; font-size: 14px; border-right: 1px solid #dee2e6; background-color: #4e73df; font-weight: bold;">YES</th>
            <th class="text-center text-black" style="padding: 12px; font-size: 14px; border-right: 1px solid #dee2e6; background-color: #4e73df; font-weight: bold;">NO</th>
            <th class="text-center text-black" style="padding: 12px; font-size: 14px; background-color: #4e73df; font-weight: bold;">NA</th>
        </tr>
    </thead>
    <?php
                

                if (strpos($scholarshipRecords->application, ',') !== false) {
                    $application = explode(',', $scholarshipRecords->application);
                } else {
                    $application = $scholarshipRecords->application;
                }
                // If $application is not an array, make it one
                if (!is_array($application)) {
                    $application = explode(',', $application);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->student_aadhar, ',') !== false) {
                    $student_aadhar = explode(',', $scholarshipRecords->student_aadhar);
                } else {
                    $student_aadhar = $scholarshipRecords->student_aadhar;
                }
                // If $application is not an array, make it one
                if (!is_array($student_aadhar)) {
                    $student_aadhar = explode(',', $student_aadhar);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->parents_aadhar, ',') !== false) {
                    $parents_aadhar = explode(',', $scholarshipRecords->parents_aadhar);
                } else {
                    $parents_aadhar = $scholarshipRecords->parents_aadhar;
                }
                // If $application is not an array, make it one
                if (!is_array($parents_aadhar)) {
                    $parents_aadhar = explode(',', $parents_aadhar);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->bank_pass_book, ',') !== false) {
                    $bank_pass_book = explode(',', $scholarshipRecords->bank_pass_book);
                } else {
                    $bank_pass_book = $scholarshipRecords->bank_pass_book;
                }
                // If $application is not an array, make it one
                if (!is_array($bank_pass_book)) {
                    $bank_pass_book = explode(',', $bank_pass_book);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->income_certificate, ',') !== false) {
                    $income_certificate = explode(',', $scholarshipRecords->income_certificate);
                } else {
                    $income_certificate = $scholarshipRecords->income_certificate;
                }
                // If $application is not an array, make it one
                if (!is_array($income_certificate)) {
                    $income_certificate = explode(',', $income_certificate);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->marks_card, ',') !== false) {
                    $marks_card = explode(',', $scholarshipRecords->marks_card);
                } else {
                    $marks_card = $scholarshipRecords->marks_card;
                }
                // If $application is not an array, make it one
                if (!is_array($marks_card)) {
                    $marks_card = explode(',', $marks_card);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->recommendation_letter, ',') !== false) {
                    $recommendation_letter = explode(',', $scholarshipRecords->recommendation_letter);
                } else {
                    $recommendation_letter = $scholarshipRecords->recommendation_letter;
                }
                // If $application is not an array, make it one
                if (!is_array($recommendation_letter)) {
                    $recommendation_letter = explode(',', $recommendation_letter);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->fee_payment_receipt, ',') !== false) {
                    $fee_payment_receipt = explode(',', $scholarshipRecords->fee_payment_receipt);
                } else {
                    $fee_payment_receipt = $scholarshipRecords->fee_payment_receipt;
                }
                // If $application is not an array, make it one
                if (!is_array($fee_payment_receipt)) {
                    $fee_payment_receipt = explode(',', $fee_payment_receipt);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->passport_size_photo, ',') !== false) {
                    $passport_size_photo = explode(',', $scholarshipRecords->passport_size_photo);
                } else {
                    $passport_size_photo = $scholarshipRecords->passport_size_photo;
                }
                // If $application is not an array, make it one
                if (!is_array($passport_size_photo)) {
                    $passport_size_photo = explode(',', $passport_size_photo);  // Convert it to an array if it's a string
                }

                if (strpos($scholarshipRecords->institution_transfer_of_scholarship_letter, ',') !== false) {
                    $institution_transfer_of_scholarship_letter = explode(',', $scholarshipRecords->institution_transfer_of_scholarship_letter);
                } else {
                    $institution_transfer_of_scholarship_letter = $scholarshipRecords->institution_transfer_of_scholarship_letter;
                }
                // If $application is not an array, make it one
                if (!is_array($institution_transfer_of_scholarship_letter)) {
                    $institution_transfer_of_scholarship_letter = explode(',', $institution_transfer_of_scholarship_letter);  // Convert it to an array if it's a string
                }
log_message('debug','application'.print_r($parents_aadhar,true))
    ?>
    <tbody style="background-color: #f9f9f9;">
        <!-- Example: Application Document -->
        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Application</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
            <?php 
if (!empty($application) && $application[0] === '0') {
    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
} else {
    echo ''; // Display blank if not checked
}
?>

            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $application)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $application)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
        </tr>


        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Aadhar Card of the Student</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
            <?php 
if (!empty($student_aadhar) && $student_aadhar[0] === '0') {
    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
} else {
    echo ''; // Display blank if not checked
}
?>

            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $student_aadhar)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $student_aadhar)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Aadhar Card of Parents</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (!empty($parents_aadhar) && $parents_aadhar[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                
                ?>
            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $parents_aadhar)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $parents_aadhar)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Bank Pass Book</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
            <?php 
                if (!empty($bank_pass_book) && $bank_pass_book[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>

            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $bank_pass_book)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $bank_pass_book)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Income Caste Certificate</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
            <?php 
            if (!empty($income_certificate) && $income_certificate[0] === '0') {
                echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
            } else {
                echo ''; // Display blank if not checked
            }
            ?>

            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $income_certificate)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $income_certificate)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Marks Card</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (!empty($marks_card) && $marks_card[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $marks_card)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $marks_card)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Recommendation Letter</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (!empty($recommendation_letter) && $recommendation_letter[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $recommendation_letter)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $recommendation_letter)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Fee Payment Receipt</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (!empty($fee_payment_receipt) && $fee_payment_receipt[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $fee_payment_receipt)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $fee_payment_receipt)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Passport Size Photo - 2</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                
                if (!empty($passport_size_photo) && $passport_size_photo[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $passport_size_photo)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $passport_size_photo)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>

        <tr style="text-align: center; border-bottom: 1px solid #dee2e6;">
            <td style="padding: 8px; font-size: 14px; border-right: 1px solid #dee2e6;">Institutional Transfer of Scholarship Letter</td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (!empty($institution_transfer_of_scholarship_letter) && $institution_transfer_of_scholarship_letter[0] === '0') {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo ''; // Display blank if not checked
                }
                ?>
            </td>
            <td style="padding: 8px; border-right: 1px solid #dee2e6;">
                <?php 
                if (in_array(1, $institution_transfer_of_scholarship_letter)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
            <td style="padding: 8px;">
                <?php 
                if (in_array(2, $institution_transfer_of_scholarship_letter)) {
                    echo '<img height="20" width="20" src="' . base_url() . 'assets/images/check.png" alt="checked" />';
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>
        <!-- Add other documents similarly -->
        
    </tbody>
</table>

<style>
    /* Add some styles to improve the design */
    .table {
        width: 100%;
        margin: 10px 0;
        border-collapse: collapse;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
        padding: 6px;
        text-align: center;
    }

    .thead-light {
        background-color: #6c757d;
        color: #ffffff;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    td img {
        vertical-align: middle;
    }
</style>

</div>



