<?php
    include"../database.php";
    $sesid=$_POST['value'];
    $sql = "SELECT * FROM sessiontb WHERE session = '$sesid'";
    $result=$con->query($sql);
    while($row = mysqli_fetch_array($result,MYSQLI_NUM)){
        echo json_encode(array('sd' => $row[1], 'ed' => $row[2]));
    }
?>