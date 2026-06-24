<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= isset($excel_title) ? $excel_title : 'Student Report' ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2, h3 { text-align: center; }
        table {
            border-collapse: collapse;
            width: 100% !important;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000 !important;
            padding: 5px 8px;
            text-align: center;
            font-size: 13px;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .header-title {
            border: 1px solid #000;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            background: #eaeaea;
        }
        .header-subtitle {
            border: 1px solid #000;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php foreach($allSheets as $sheet): 
        if(empty($sheet['students'])) continue; ?>

        <table>
            <tr>
                <th class="header-title" colspan="<?= count($sheet['fields']) + 1 ?>">
                    <?= isset($excel_title) ? $excel_title : 'Student Report' ?>
                </th>
            </tr>
            <tr>
                <th class="header-title" colspan="<?= count($sheet['fields']) + 1 ?>">
                    <?= htmlspecialchars($sheet['term']) ?> INFORMATION <?= htmlspecialchars($sheet['gender']) ?> - <?= htmlspecialchars($sheet['religion']) ?> - <?= htmlspecialchars($sheet['curr_year']) ?>
                </th>
            </tr>
            <tr>
                <th style="width: 60px;">SL No.</th>
                <?php foreach($sheet['fields'] as $field): ?>
                    <th><?= htmlspecialchars($field) ?></th>
                <?php endforeach; ?>
            </tr>
            <?php $j = 1; foreach($sheet['students'] as $student): ?>
                <tr>
                    <td><?= $j++ ?></td>
                    <?php foreach($sheet['fields'] as $field): ?>
                        <td>
                            <?php
                                if($field == 'dob' && !empty($student->dob)){
                                    echo date("d-m-Y", strtotime($student->dob));
                                } else if($field == 'student_name'){
                                    echo strtoupper($student->student_name);
                                } else if($field == 'doj'){
                                    if($student->doj != '1970-01-01' && $student->doj != '0000-00-00' && $student->doj != ''){
                                        echo date("d-m-Y", strtotime($student->doj));
                                    }
                                } else {
                                    echo isset($student->{$field}) ? htmlspecialchars($student->{$field}) : '';
                                }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <!-- <div style="page-break-after:always"></div> -->
    <?php endforeach; ?>
</body>
</html>