
<style>

.break { page-break-before: always; } 
.break_after { page-break-before: none; } 


.table_bordered{
    border-collapse: collapse;
    width: 100%;
    font-size: 13px;
}

.table_bordered tr td{
    border-top: 1px solid black;
    border-left: 1px solid black;
    width: 45%;
    padding: 3px 3px;
    font-weight: 600;
    color: black !important;
}
.table_bordered tr th{
    border-top: 1px solid black;
    border-right: 1px solid black;
    font-weight: 400;
    text-align: left !important;
    width: 55%;
    padding: 3px 3px;
    font-weight: 600;
    color: black !important;
}

.table_bordered tr:last-child td,.table_bordered tr:last-child th {
   border-bottom: 1px solid black !important;
}

.table_info, .table_content{
    border-collapse: collapse;
    width: 100%;
    font-size: 13px;
}
.table_last{
    width: 100%;
    font-size: 13px;
}

.table_last tr th{
    text-align: left !important;
    color: black !important;
}

.table_info tr th{
    border-top: 1px solid black;
    font-weight: 400;
    text-align: left !important;
    padding: 3px 3px;
    color: black !important;
}
.table_info tr td{
    border-top: 1px solid black;
    padding: 3px 3px;
    color: black !important;
}


.mb_10{
    margin-bottom: 7px !important;
}
.mb_3{
    margin-bottom: 5px !important;
}
.mb_15{
    margin-bottom: 9px !important;
}

.ml_2{
    margin-left: 5px !important;
}

.tc_info{
    color: black !important;
}

p{
    margin-bottom: 2px !important;
}
</style>


<?php

$totalStudentCount = count($studentInfo);
foreach($studentInfo as $std){
?>
    
    <div class="container tc_info">
        <table>
            <tr>
                <td width="500" style="text-align:center;">
                    <p style="font-size: 20px; font-weight: bold;">ST ALOYSIUS GONZAGA SCHOOL</p>
                    <p style="font-size: 16px; font-weight: bold;">PO Box No. - 720, Kodialbail, Mangaluru - 575003</p>
                    <p style="font-size: 13px; font-weight: bold;">Phone : 0824-2449724</p>
                    <p style="font-size: 12px; font-weight: bold;">(No Objection Certificate by Karnataka Govt.No. ED.208 PGC 2012)</p>
                    <p style="font-size: 12px; font-weight: bold;">(Affiliated to CBSE, New Delhi - Affiliation No. 830650, School Code - 45575)</p>
                    <p style="font-size: 13px; font-weight: bold;">DISE CODE: 29240302811</p>
                    <p style="font-size: 17px; font-weight: bold;"><u>TRANSFER CERTIFICATE</u></p>
                </td>
            </tr>
        </table>
        <table style="font-size: 13.5px;">
        </table>
        <table class="table_bordered"> 
            <tr>
                <td>1. Name of the Student</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>2. Gender</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>3. Mother's Name</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>4. Father's/Guardian's Name</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>5. Date of Birth (in figures and in words)</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>6. Proof for Date of Birth submitted at the time of &nbsp;&nbsp;&nbsp;&nbsp;admission</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
        <!-- </table>
        <table class="table_info">   , '.strtoupper($std->section_name)-->
            <tr>
                <td>7. Nationality  <span style="padding-left:5px;">&nbsp;&nbsp;&nbsp;&nbsp; </span></td>
                <th> <span style="padding-left:5px;">&nbsp;&nbsp;&nbsp;&nbsp; </span></th>
            </tr>
        </table>
        <table class="table_bordered"> 
            <tr>
                <td>8. Whether the candidate belongs to S.C./S.T./OBC</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>9. Date of first admission in the School with Class</td>
                <th><span style="text-align: right;">:</span></th>
            </tr>
            <tr>
                <td>10. Class in which the pupil last studied <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(in figures and in words)</td>
                <th><span style="text-align: right;">:</span> CLASS </th>
            </tr>
            <tr>
                <td>11. School/Board Annual examination last taken with &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;result</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>12. Whether failed, if so once/twice in the same class</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>13. Subjects studied</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>14. Whether qualified for the promotion to higher &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;class</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>15. Month up to which the pupil has paid the school &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dues</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>16. Any fee concession availed of if so, the nature of &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;such concession</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>17. Total  No. of working days in the academic session</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>18. Total  No. of working days pupil present in the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;school</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>19. Whether NCC Cadet/Boy Scout/Girl Guide</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>20. Games played or extra curricular activities in &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;which the pupil usually took part</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>21. Whether school is under &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Govt./Minority/Independent Category</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>22. General Conduct</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>23. Date of application for certificate</td>
                <th><span style="text-align: right;">:</span>  </th>
            </tr>
            <tr>
                <td>24. Date on which pupil's name was struck off the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rolls of the school</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>25. Date of issue of certificate</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>26. Reason for leaving the school</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
            <tr>
                <td>27. Any other remarks</td>
                <th><span style="text-align: right;">:</span> </th>
            </tr>
        </table> 
        <table class="table_content">
            <tr>
                <td style="border-top: 1px solid black;"></td>
            </tr>
        </table> 
        <table class="table_last mb_10">
            <tr>
                <td>I hereby declare that the above information including  Name of the Student, Father's Name, Mother's Name and Date of Birth furnished above is correct as per school records.</td>
            </tr>
            <tr>
                <td>Date: </td>
            </tr>
        </table> 
        <table class="table_last mb_15">
            <tr>
                <td>Receiver's Signature with Date: ..................................... </td>
            </tr>
        </table>
        <table class="table_last">
            <tr>
                <td style="width:550px;float:left;">Name in full: ................................................................... </td>
                <td style="text-align: right;">Signature of Principal</td>
            </tr>
        </table>
    </div>

<?php 

    if($totalStudentCount != 0){
        echo '<div class="break"></div>';
    }else{
        echo '<div class="break_after"></div>';
    }
} ?>


