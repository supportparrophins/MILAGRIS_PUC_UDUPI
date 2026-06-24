<?php 
    $weekname = array('MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY');
?>
<div class="main-content-container container-fluid px-4">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
            <div class="card card-small p-0">
                <div class="card-body p-2 ml-2">
                <span class="page-title time_table_title_mobile">
                    <i class="material-icons">access_time</i> Time Table 2019-20 <?php echo $term_name; ?> <?php echo $section_name; ?>
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
                <table class="table table-responsive table-bordered table_timeTable">
                    <tr class="time_table_heading text-center">
                        <th class="pb-0">Week Name</th>
                        <?php
                    
                        foreach($classTimings as $time)
                        { 
                        ?>
                        <th class="pb-0"><?php echo $time->start_time; ?> - <?php echo $time->end_time; ?></th>
                        <?php } ?>
                    </tr>
                    <?php for($i=0;$i<=5;$i++) {
                        
                        $subjects = array();
                        $staff_name = array();
                        $sub_type = array();
                    ?>
                    <tr>
                        <td><?php echo $weekname[$i]; ?></td>
                        <?php 
                            for($l=0;$l<=6;$l++){
                                $subjects[$l] = "";
                                $staff_name[$l] = "";
                                $sub_type[$l] = "";
                            }
                            foreach($timetableInfo as $time){ 
                               
                                if($weekname[$i] == $time->week_name){ 
                                    if($time->time_row_id == 1){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[0] .= strtoupper($time->sub_name).',';
                                            $staff_name[0] .= $time->staff_name.',';
                                            $sub_type[0] .= $time->subject_type.',';
                                        }else{
                                            $subjects[0] .= strtoupper($time->sub_name);
                                            $staff_name[0] .= $time->staff_name;
                                            $sub_type[0] .= $time->subject_type;
                                        }
                                    }  
                                    if($time->time_row_id == 2){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[1] .= strtoupper($time->sub_name).',';
                                            $staff_name[1] .= $time->staff_name.',';
                                            $sub_type[1] .= $time->subject_type.',';
                                        }else{
                                            $subjects[1] .= strtoupper($time->sub_name);
                                            $staff_name[1] .= $time->staff_name;
                                            $sub_type[1] .= $time->subject_type;
                                        }
                                    }  
                                    if($time->time_row_id == 3){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[2] .= strtoupper($time->sub_name).',';
                                            $staff_name[2] .= $time->staff_name.',';
                                            $sub_type[2] .= $time->subject_type.',';
                                        }else{
                                            $subjects[2] .= strtoupper($time->sub_name);
                                            $staff_name[2] .= $time->staff_name;
                                            $sub_type[2] .= $time->subject_type;
                                        }
                                    }  
                                    if($time->time_row_id == 4){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[3] .= strtoupper($time->sub_name).',';
                                            $staff_name[3] .= $time->staff_name.',';
                                            $sub_type[3] .= $time->subject_type.',';
                                        }else{
                                            $subjects[3] .= strtoupper($time->sub_name);
                                            $staff_name[3] .= $time->staff_name;
                                            $sub_type[3] .= $time->subject_type;
                                        }
                                    }  
                                    if($time->time_row_id == 5){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[4] .= strtoupper($time->sub_name).',';
                                            $staff_name[4] .= $time->staff_name.',';
                                            $sub_type[4] .= $time->subject_type.',';
                                        }else{
                                            $subjects[4] .= strtoupper($time->sub_name);
                                            $staff_name[4] .= $time->staff_name;
                                            $sub_type[4] .= $time->subject_type;
                                        }
                                    }  
                                    if($time->time_row_id == 6){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[5] .= strtoupper($time->sub_name).',';
                                            $staff_name[5] .= $time->staff_name.',';
                                            $sub_type[5] .= $time->subject_type.',';
                                        }else{
                                            $subjects[5] .= strtoupper($time->sub_name);
                                            $staff_name[5] .= $time->staff_name;
                                            $sub_type[5] .= $time->subject_type;
                                        }
                                    }  
                                    if($time->time_row_id == 7){
                                        if($time->sub_type == 'LANGUAGE'){
                                            $subjects[6] .= strtoupper($time->sub_name).',';
                                            $staff_name[6] .= $time->staff_name.',';
                                            $sub_type[6] .= $time->subject_type.',';
                                        }else{
                                            $subjects[6] .= strtoupper($time->sub_name);
                                            $staff_name[6] .= $time->staff_name;
                                            $sub_type[6] .= $time->subject_type;
                                        }
                                    }  
                                } 
                            } 
                            for($s=0;$s<=6;$s++){
                                echo '<td><span style="color:#115bb3;">'.$subjects[$s].'</span><br>'.$staff_name[$s].'<br><span style="color:#4db309;">'.$sub_type[$s].'</span></td>';
                            }   
                        ?>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>  
</div>