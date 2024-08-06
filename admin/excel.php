<?php

include "../database.php";
include "../vendor/autoload.php";


$sql = "SELECT * FROM admissiontb";
$result = mysqli_query($con, $sql);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=data_export.xls");

if ($result->num_rows > 0) {
    // Column headers
    echo "
        SESSION_1\t
        ROLL_1\t
        REG_NO\t
        SESSION_2\t
        ROLL_2\t
        SESSION_3\t
        ROLL_3\t
        EXAM_USERNAME\t
        EXAM_PASSWORD\t
        COURSE\t
        ADM_DATE\t
        NAME\t
        FATHER'S_NAME\t
        DOB\t
        STD_CONTACT\t
        G_CONTACT\t
        EMAIL\t
        ADDRESS\t
        GENDER\t
        CATEGORY\t
        EXAM_1\t
        BOARD_1\t
        PER_1\t
        EXAM_2\t
        BOARD_2\t
        PER_2\t
        EXAM_3\t
        BOARD_3\t
        PER_3\t
        VERIFY\n";

    while ($row = $result->fetch_assoc()) {
        echo $row['session1'] . "\t" . 
             $row['roll1'] . "\t" . 
             $row['areg'] . "\t" . 
             $row['session2'] . "\t" . 
             $row['roll2'] . "\t" . 
             $row['session3'] . "\t" . 
             $row['roll3'] . "\t" . 
             $row['elgid'] . "\t" . 
             $row['elgpass'] . "\t" . 
             $row['course'] . "\t" . 
             $row['adate'] . "\t" . 
             $row['sname'] . "\t" . 
             $row['sfname'] . "\t" . 
             $row['sdob'] . "\t" . 
             $row['scontact'] . "\t" . 
             $row['gcontact'] . "\t" . 
             $row['semail'] . "\t" . 
             $row['saddress'] . "\t" . 
             $row['sgender'] . "\t" . 
             $row['scategory'] . "\t" . 
             $row['squalif1'] . "\t" . 
             $row['bqualif1'] . "\t" . 
             $row['pqualif1'] . "\t" . 
             $row['squalif2'] . "\t" . 
             $row['bqualif2'] . "\t" . 
             $row['pqualif2'] . "\t" . 
             $row['squalif3'] . "\t" . 
             $row['bqualif3'] . "\t" . 
             $row['pqualif3'] . "\t" . 
             $row['verify'] . "\n";
    }

    echo '<script type="text/javascript">
              alert("Export data successful.");
              window.location.href = "viewstd.php";
          </script>';
} else {
    echo "No data found";
}

$con->close();

?>
