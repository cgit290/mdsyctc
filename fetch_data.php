<?php
    include"database.php";
    if (isset($_POST['value'])) {
        $value = $_POST['value'];
        if($value=='NA') echo json_encode(array('cn' => '', 'cd' => ''));
        $sql = "SELECT coursename,duration FROM coursetb WHERE course = '$value'";
        $result =mysqli_query($con,$sql);
        while($row = mysqli_fetch_array($result)) {
            echo json_encode(array('cn' => $row["coursename"], 'cd' => $row["duration"]));
            }
    
    }
?>
