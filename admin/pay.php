<?php

include"header.php"; 
include"../database.php"; 

$session="";
$today = date('Y-m-d');

// Query to select session based on the current date
$stmtSession = "SELECT session FROM Sessiontb WHERE startdate <= CURDATE() AND enddate >= CURDATE();";
$SessionResult = $con->query($stmtSession);

if ($SessionResult) {
    $numSession = $SessionResult->num_rows;
    
    if ($numSession > 0) {
        // Fetch the session value(s)
        while ($row = $SessionResult->fetch_assoc()) {
            $session = $row['session'];
            // echo "Session: " . $session . "<br>";
        }
    } else {
        echo "No sessions found for today.";
    }
} else {
    echo "Error retrieving Sessions: " . $con->error;
}
$errors = [];
$pcount;
$s1;
$s2;
$s3;

$roll2=0;
$roll3=0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if($_POST['submit']=='add'){
        $stdid=$_POST['sid'];
        $reg=$_POST['reg'];
        $amt=$_POST['amt'];
        $amtt=$_POST['amtt'];
        $mode=$_POST['mode'];
       
        $pcount =intval($amtt);
        // echo "<script>alert('Error stmt1 exec $pcount $amtt');</script>";die;

            // Validate required fields
        if (empty($amt)) $errors['amt'] = "Amount is required.";
        if (empty($amtt)) $errors['amtt'] = "Amount type code is required.";
        if (empty($mode)) $errors['mode'] = "Mode is required.";
        if (empty($reg)) $errors['reg'] = "Registration ID is required.";
        // if (empty($fees) || !is_numeric($fees)) $errors['fees'] = "Valid fees amount is required.";
        // if (empty($adamt) || !is_numeric($adamt)) $errors['adamt'] = "Valid admission amount is required.";
        // if (empty($insamt) || !is_numeric($insamt)) $errors['insamt'] = "Valid installment amount is required.";
        // if (empty($noi) || !is_numeric($noi)) $errors['noi'] = "Valid number of installments is required.";
        // if (empty($elig)) $errors['elig'] = "Eligibility criteria is required.";
        // if (empty($content)) $errors['content'] = "Syllabus content is required.";

        if($mode=="online"){
            if (empty($_FILES['photo']['name'])) {
            $errors['photo'] = "Transaction screenshot is required.";
            } else {
                // Check for file size (not exceeding 50KB)
                if ($_FILES['photo']['size'] > 204800) $errors['photo'] = "Transaction screenshot must not exceed 200KB.";

                // Check for file extension
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            }
        }

        // If no validation errors, move the uploaded file and insert into the database
        if (empty($errors)) {


            if ($pcount == 5) {
                $stmt1 = $con->prepare("SELECT session1, MAX(roll2) as max_roll2 FROM admissiontb WHERE stdid = ?");
                if ($stmt1) {
                    $stmt1->bind_param('i', $stdid);
                    if ($stmt1->execute()) {
                        $result1 = $stmt1->get_result();
                        if ($result1->num_rows > 0) {
                            $row = $result1->fetch_assoc();
                            $s1 = $row['session1'];
                            $roll2 = $row['max_roll2'];
                            // echo "<script>alert('Error executing stmt1 $s2 - $roll2');</script>";die;
                        }
                    } else {
                        echo "<script>alert('Error executing stmt1');</script>";
                    }
                }
            
                $s2 = $s1 + 1;
                $roll2 += 1;
                $stmt2 = $con->prepare("UPDATE admissiontb SET roll2 = ?, session2 = ? WHERE stdid = ?");
                if ($stmt2) {
                    $stmt2->bind_param('iii', $roll2, $s2, $stdid);
                    if ($stmt2->execute()) {
                        echo "<script>alert('Record Updated. New Session = $s2 and Roll = $roll2');</script>";
                    } else {
                        echo "<script>alert('Error executing stmt2');</script>";
                    }
                }
            }
            
            if ($pcount == 11) {
                $stmt1 = $con->prepare("SELECT session2, MAX(roll3) as max_roll3 FROM admissiontb WHERE stdid = ?");
                if ($stmt1) {
                    $stmt1->bind_param('i', $stdid);
                    if ($stmt1->execute()) {
                        $result1 = $stmt1->get_result();
                        if ($result1->num_rows > 0) {
                            $row = $result1->fetch_assoc();
                            $s2 = $row['session2'];
                            $roll3 = $row['max_roll3'];
                        }
                    } else {
                        echo "<script>alert('Error executing stmt1');</script>";
                    }
                }
            
                $s3 = $s2 + 1;
                $roll3 += 1;
            
                $stmt2 = $con->prepare("UPDATE admissiontb SET roll3 = ?, session3 = ? WHERE stdid = ?");
                if ($stmt2) {
                    $stmt2->bind_param('iii', $roll3, $s3, $stdid);
                    if ($stmt2->execute()) {
                        echo "<script>alert('Record Updated. New Session = $s3 and Roll = $roll3');</script>";
                    } else {
                        echo "<script>alert('Error executing stmt2');</script>";
                    }
                }
            }

            $query = "INSERT INTO `paymenttb`(`stdid`, `amount`, `type`, `mode`) VALUES ('$sid','$amt','$amtt','$mode')";
            $result=mysqli_query($con,$query) or die("Could Not Perform the Query Insert course");

            $query1="SELECT payid,date FROM paymenttb WHERE stdid='$stdid' and date='$today'";
            $result1=mysqli_query($con,$query1) or die("Could Not Perform the Query ");
            while($row=mysqli_fetch_array($result1)){
                $pid=$row[0];
                $pd=$row[1];
            }


            if($mode=="online"){
                
                $prid="MDS".date('Ymd',strtotime($pd)).$pid;
                // Specify the upload directory and create it if it doesn't exist
                $photo_dir = "uploads/payment/";
                if (!is_dir($photo_dir)) {
                    mkdir($photo_dir, 0777, true);
                }
                    $photo = $prid . '.' . $extension;
                    $photo_target = $photo_dir . $photo;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target);
                    $query3 = "UPDATE `paymenttb` SET transimg = '$photo' WHERE payid='$pid'";
                    $result3=mysqli_query($con,$query3) or die("Could Not Perform the Query Update");
                    echo "<script>alert('success');</script>";
            }


                
            }

    }
}
?>
<script src="../assets/js/jquery-3.6.0.min.js"></script> 
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="h-100">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Payment Entry </h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="listjs-table" id="customerList">
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Student Reg. No<span class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">YSMDS</div>
                                                        <input type="number" name="reg" id="mySes" class="form-control" value="<?php echo $session ?>" required autofocus tabindex="1"> 
                                                        <?php if (isset($errors['reg'])): ?>
                                                            <span style="color:red;"><?= $errors['reg'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="hidden" name="sid" id="sid">
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#mySes').change(function() {
                                                                var selectedValue = $(this).val();
                                                                if(selectedValue) {
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: 'fetch_std.php',
                                                                        data: { value: selectedValue },
                                                                        success: function(data) {
                                                                            var responses = JSON.parse(data);
                                                                            $('#sid').val(responses.sid);
                                                                            $('#name').val(responses.sn);
                                                                            $('#fname').val(responses.sfn);
                                                                            $('#course').val(responses.cs);
                                                                            $('#amtt').val(responses.amtt);
                                                                            $('#amt').val(responses.amt);
                                                                            let damt = responses.damt;
                                                                            if(damt<=0){
                                                                                $('#pdata').hide();
                                                                                $('#cmsg').show();
                                                                            }else{
                                                                                $('#pdata').show();
                                                                                $('#cmsg').hide();
                                                                            }
                                                                        }
                                                                    });
                                                                } else {
                                                                    $('#name').val(responses.error);
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Name<span class="text-danger"> *</span></label>
                                                    <input type="text" name="name" id="name" class="form-control bg-light" required readonly>  
                                                    <?php if (isset($errors['name'])): ?>
                                                        <span style="color:red;"><?= $errors['name'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Father's Name<span class="text-danger"> *</span></label>
                                                    <input type="text" name="fname" id="fname" class="form-control bg-light" required readonly>  
                                                    <?php if (isset($errors['fname'])): ?>
                                                        <span style="color:red;"><?= $errors['fname'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Course<span class="text-danger"> *</span></label>
                                                    <input type="text" name="course" id="course" class="form-control bg-light" required readonly>  
                                                    <?php if (isset($errors['course'])): ?>
                                                        <span style="color:red;"><?= $errors['course'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row" id="pdata">
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Payment Type<span class="text-danger"> *</span></label>
                                                    <input type="text" name="amtt" id="amtt" class="form-control bg-light" required readonly> 
                                                    <?php if (isset($errors['amtt'])): ?>
                                                        <span style="color:red;"><?= $errors['amtt'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Amount<span class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">&#8377;</div>
                                                        <input type="number" name="amt" id="amt" class="form-control bg-light" required readonly> 
                                                        <?php if (isset($errors['amt'])): ?>
                                                            <span style="color:red;"><?= $errors['amt'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label for="" class="form-label">Mode<span class="text-danger"> *</span></label>
                                                    <select name="mode" id="edate" class="form-control" required tabindex="2">
                                                        <option value="cash">Cash</option>
                                                        <option value="online">Online</option>
                                                    </select>
                                                    <?php if (isset($errors['mode'])): ?>
                                                        <span style="color:red;"><?= $errors['mode'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label for="" class="form-label">Transaction Screenshot<span class="text-danger" tabindex="3">(Max size 200KB)</span></label>
                                                    <input type="file" accept=".jpg,.png,.jpeg" name="photo" class="form-control">
                                                    <?php if (isset($errors['photo'])): ?>
                                                        <span style="color:red;"><?= $errors['photo'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-start">
                                                    <button type="submit" class="btn btn-secondary bg-gradient waves-effect waves-light" value="add" name="submit" tabindex="4">Submit</button>
                                                </div>
                                            </div>
                                                <span style="color:red;display:none" id="cmsg" >Your payment is completed.</span>                                            
                                            </form>
                                        </div>
                                    </div><!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                                    
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
</div>
        
   

<?php
include"footer.php";
?>
