<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit();
}
include"header.php"; 
include"../database.php"; 
    $rid1 = 1;
    $stdid=1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = array(); // Array to hold validation errors

        // Sanitize and validate input data
        $ses1 = mysqli_real_escape_string($con, $_POST['ses1']);
        $course = mysqli_real_escape_string($con, $_POST['course']);
        $fcourse = mysqli_real_escape_string($con, $_POST['fcourse']);
        $duration = mysqli_real_escape_string($con, $_POST['duration']);
        $name = strtoupper(mysqli_real_escape_string($con, $_POST['name']));
        $fname = strtoupper(mysqli_real_escape_string($con, $_POST['fname']));
        $dob = mysqli_real_escape_string($con, $_POST['dob']);
        $email = strtolower(mysqli_real_escape_string($con, $_POST['email']));
        $contactno1 = mysqli_real_escape_string($con, $_POST['contactno1']);
        $contactno2 = mysqli_real_escape_string($con, $_POST['contactno2']);
        $address = strtoupper(mysqli_real_escape_string($con, $_POST['address']));
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $exam1 = strtoupper(mysqli_real_escape_string($con, $_POST['exam1']));
        $exam2 = strtoupper(mysqli_real_escape_string($con, $_POST['exam2']));
        $exam3 = strtoupper(mysqli_real_escape_string($con, $_POST['exam3']));
        $board1 = strtoupper(mysqli_real_escape_string($con, $_POST['board1']));
        $board2 = strtoupper(mysqli_real_escape_string($con, $_POST['board2']));
        $board3 = strtoupper(mysqli_real_escape_string($con, $_POST['board3']));
        $per1 = mysqli_real_escape_string($con, $_POST['per1']);
        $per2 = mysqli_real_escape_string($con, $_POST['per2']);
        $per3 = mysqli_real_escape_string($con, $_POST['per3']);

        // Validate required fields
        if (empty($ses1)) $errors[] = "Session is required.";
        if (empty($course)) $errors[] = "Course is required.";
        if (empty($fcourse)) $errors[] = "Course name is required.";
        if (empty($duration)) $errors[] = "Course duration is required.";
        if (empty($name)) $errors[] = "Name is required.";
        if (empty($fname)) $errors[] = "Father's name is required.";
        if (empty($dob)) $errors[] = "Date of birth is required.";
        if (empty($email)) $errors[] = "Email is required.";
        if (empty($contactno1)) $errors[] = "Student contact number is required.";
        if (empty($address)) $errors[] = "Address is required.";
        if (empty($gender)) $errors[] = "Gender is required.";
        if (empty($category)) $errors[] = "Category is required.";
        if (empty($board1)) $errors[] = "10th board is required.";
        if (empty($per1)) $errors[] = "10th percentage is required.";

        // Handle file uploads
        if (empty($_FILES['photo']['name'])) $errors[] = "Photograph is required.";
        if (empty($_FILES['sign']['name'])) $errors[] = "Signature is required.";
        if (empty($_FILES['gsign']['name'])) $errors[] = "Guardian signature is required.";

        // Check for file size (not exceeding 50KB)
        if ($_FILES['photo']['size'] > 51200) $errors[] = "Photograph must not exceed 50KB.";
        if ($_FILES['sign']['size'] > 51200) $errors[] = "Signature must not exceed 50KB.";
        if ($_FILES['gsign']['size'] > 51200) $errors[] = "Guardian signature must not exceed 50KB.";

        // Specify the upload directory and create it if it doesn't exist
        $photo_dir = "uploads/admission/photo/";
        $sign_dir = "uploads/admission/sign/";
        $gsign_dir = "uploads/admission/gsign/";
        $query1 = "SELECT MAX(roll1) FROM admissiontb WHERE session1='$ses1'";
        $result1 = mysqli_query($con, $query1);
        while ($row = mysqli_fetch_array($result1)) {
            $rid1 = $row[0];
        }

        $refid1 = "YSMDS" . $ses1 . sprintf("%03d", $rid1);
        

        // Change file names based on refid1
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo = 'photo' . $refid1 . '.' . $extension;
        $photo_target = $photo_dir . $photo;

        $extension = pathinfo($_FILES['sign']['name'], PATHINFO_EXTENSION);
        $sign = 'sign' . $refid1 . '.' . $extension;
        $sign_target = $sign_dir . $sign;

        $extension = pathinfo($_FILES['gsign']['name'], PATHINFO_EXTENSION);
        $gsign = 'gsign' . $refid1 . '.' . $extension;
        $gsign_target = $gsign_dir . $gsign;

        // Move uploaded files to the specified directory if no errors
        if (empty($errors)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target) &&
                move_uploaded_file($_FILES['sign']['tmp_name'], $sign_target) &&
                move_uploaded_file($_FILES['gsign']['tmp_name'], $gsign_target)) {

                $elgid=$refid1.'@GMAIL.COM';
                $elgpass='MDS@'.sprintf("%03d", $rid1);
                $adate=date('Y-m-d');
                // Insert data into the database
                $query = "INSERT INTO admissiontb (session1, roll1, areg, elgid, elgpass, course, adate, sname, sfname, sdob, scontact, gcontact, semail, saddress, sgender, scategory, squalif1, bqualif1, pqualif1, squalif2, bqualif2, pqualif2, squalif3, bqualif3, pqualif3, photo, sign, gsign, verify)
                                            VALUES ('$ses1', '$rid', '$refid1', '$elgid', '$elgpass', '$course', '$adate', '$name', '$fname', '$dob', '$contactno1', '$contactno2', '$email', '$address', '$gender', '$category', '$exam1', '$board1', '$per1', '$exam2', '$board2', '$per2', '$exam3', '$board3', '$per3', '$photo', '$sign', '$gsign', 0);";

                $qrun=mysqli_query($con, $query) or die("Could not insert");

                 $query11 = "SELECT stdid FROM admissiontb WHERE areg='$refid1'";
                 $result11 = mysqli_query($con, $query11);
                 while ($row1 = mysqli_fetch_array($result11)) {
                     $stdid = $row1[0];
                 }     

                $queryl="INSERT INTO `logintb`(`stdid`, `userid`, `password`)
                                       VALUES ('$stdid','$elgid','$elgpass')";
                 mysqli_query($con, $queryl) or die("Could not insert");
                if ( $qrun) {
                    // Redirect to success page
                    echo '<script type="text/javascript">
                            alert("Student added succesful.");
                            window.location.href = "addstd.php";
                        </script>';
                    // echo "<script>alert('Student added successful.');</script>";
                    // header("Location: addstd.php");
                    // exit();
                } else {
                    echo "<script>alert('Error submitting application.');</script>";
                }
            } else {
                $errors[] = "Error moving uploaded files.";
            }
        }

        // Display errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<script>alert('$error');</script>";
            }
        }

        // Close the database connection
        mysqli_close($con);

        // Redirect back to the form page
        // header("Location: index.php");
        // exit();
        // ob_end_flush();
}
?>
<script src="../assets/js/jquery-3.6.0.min.js"></script> 
<script src="../assets/js/my-script.js"></script>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col">
                    <div class="h-100">
                        <div class="card p-3">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">New Student Data Entry Form</h4>
                                <div class="flex-shrink-0">
                                    <!-- <div class="form-check form-switch form-switch-right form-switch-md">
                                        <label for="form-grid-showcode" class="form-label text-muted">Show Code</label>
                                        <input class="form-check-input code-switcher" type="checkbox" id="form-grid-showcode">
                                    </div> -->
                                </div>
                            </div><!-- end card header -->
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                    <label for="" class="form-label">Select Session<span class="text-danger"> *</span></label>
                                    <select class="form-select" name="ses1" id="mySes" required style="font-size: 11pt;">
                                        <option value="NA"></option>
                                    <?php
                                        $query="select * from sessiontb order by session DESC";
                                        $result=mysqli_query($con,$query);

                                        while($row1=mysqli_fetch_array($result,MYSQLI_NUM))
                                        {
                                            $ses=$row1[0];
                                            // $sdate=$row1[1];
                                            // $edate=$row1[2];
                                        
                                        
                                    ?>
                                        <option value="<?php echo "$ses"; ?>"><?php echo "$ses"; ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                    <!-- <button type="submit" class="edu-btn btn-small ">Get</button> -->
                                    </div>
                                    <div class="mb-3 col-md-4" >
                                    <label for="" class="form-label">Start Date<span class="text-danger"> *</span></label>
                                    <input type="text" name="fcourse" id="sdate" readonly class="form-control"> 
                                    </div>
                                    <div class="mb-3 col-md-4">
                                    <label for="" class="form-label">End Date<span class="text-danger"> *</span></label>
                                    <input type="text" name="duration" id="edate" readonly class="form-control">
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#mySes').change(function() {
                                                var selectedValue = $(this).val();
                                                if(selectedValue) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'fetch_ses.php',
                                                        data: { value: selectedValue },
                                                        success: function(data) {
                                                            var responses = JSON.parse(data);
                                                            $('#sdate').val(responses.sd);
                                                            $('#edate').val(responses.ed);
                                                        }
                                                    });
                                                } else {
                                                    $('#result').html('');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-2">
                                    <label for="" class="form-label">Select Course<span class="text-danger"> *</span></label>
                                    <select class="form-select" name="course" id="mySelect" required style="font-size: 11pt;">
                                        <option value="NA"></option>
                                    <?php
                                        $query="select course,coursename,duration,id from coursetb";
                                        $result=mysqli_query($con,$query);

                                        while($row=mysqli_fetch_array($result,MYSQLI_NUM))
                                        {
                                            $rcourse=$row[0];
                                            // $rname=$row[1];
                                            // $rdura=$row[2];
                                            // $rid=$row[3];
                                        
                                        
                                    ?>
                                        <option value="<?php echo "$rcourse"; ?>"><?php echo "$rcourse"; ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                    <!-- <button type="submit" class="edu-btn btn-small ">Get</button> -->
                                    </div>
                                    <div class="mb-3 col-md-7" >
                                    <label for="" class="form-label">Course Name<span class="text-danger"> *</span></label>
                                    <input type="text" name="fcourse" id="cresult" readonly class="form-control"> 
                                    </div>
                                    <div class="mb-3 col-md-3">
                                    <label for="" class="form-label">Course Duration<span class="text-danger"> *</span></label>
                                    <input type="text" name="duration" id="dresult" readonly class="form-control">
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#mySelect').change(function() {
                                                var selectedValue = $(this).val();
                                                if(selectedValue) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '../fetch_data.php',
                                                        data: { value: selectedValue },
                                                        success: function(data) {
                                                            var responses = JSON.parse(data);
                                                            $('#cresult').val(responses.cn);
                                                            $('#dresult').val(responses.cd);
                                                        }
                                                    });
                                                } else {
                                                    $('#result').html('');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                    <label for="" class="form-label">Name<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control text-uppercase" required maxlength="30" name="name" id="" placeholder="Enter your full name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                    <label for="" class="form-label">Father's Name<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control text-uppercase" required maxlength="30" name="fname" id=""  placeholder="Enter your father name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="" class="form-label">Date of Birth<span class="text-danger"> *</span></label>
                                        <input type="date" class="form-control" required name="dob" id="" >
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="" class="form-label">Email<span class="text-danger"> *</span></label>
                                        <input type="email" class="form-control text-lowercase" required name="email" id="" placeholder="">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="" class="form-label">Student Contact no<span class="text-danger"> *</span>(10 digits)</label>
                                        <input type="text" class="form-control" required maxlength="10" minlength="10" name="contactno1" id="" placeholder="">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="" class="form-label">Gaurdian Contact no (10 digits)</label>
                                        <input type="text" class="form-control" maxlength="10" minlength="10" name="contactno2" id=""  placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="" class="form-label">Address<span class="text-danger"> *</span></label>
                                    <textarea name="address" id="" class="form-control text-uppercase" required placeholder="Enter your full address"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                        <label for="" class="form-label">Gender<span class="text-danger"> *</span></label>
                                        <select class="form-select  text-uppercase" name="gender" id="" required style="font-size: 11pt;">
                                                <option selected value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Category<span class="text-danger"> *</span></label>
                                            <select class="form-select text-uppercase" name="category" id="" required style="font-size: 11pt;">
                                                <option selected value="general">General</option>
                                                <option value="sc">SC</option>
                                                <option value="st">ST</option>
                                                <option value="obc">OBC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <label for="" class="form-label fw-bold">Educational Qualification</label>
                                    <div class="mb-3 col-md-2">
                                        <label for="" class="form-label">Examination</label>
                                        <input type="text" class="form-control mb-2  text-uppercase" required name="exam1" id=""  value="10th" readonly>
                                        <input type="text" class="form-control mb-2 text-uppercase" name="exam2" id="" value="12th" readonly>
                                        <input type="text" class="form-control text-uppercase"  name="exam3" id="" value="graduation" readonly>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <label for="" class="form-label">Board/University</label>
                                        <input type="text" class="form-control mb-2 text-uppercase" required name="board1" id=""  placeholder="">
                                        <input type="text" class="form-control mb-2  text-uppercase" name="board2" id=""  placeholder="">
                                        <input type="text" class="form-control text-uppercase" name="board3" id="" placeholder="">
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="" class="form-label">Percentage </label>
                                        <input type="number" class="form-control mb-2" required maxlength="4" name="per1" id="" max="100">
                                        <input type="number" class="form-control mb-2 " name="per2" maxlength="4" id=""   max="100">
                                        <input type="number" class="form-control" name="per3" id="" maxlength="4"   max="100">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <label for="" class="form-label">Photograph<span class="text-danger" > *(Not exceed 50KB)</span></label>
                                        <input type="file" id="fileInput" accept=".jpg,.jpeg,.png" name="photo" >
                                        <div id="imageContainer">
                                            <img id="image" src="">
                                        </div>
                                        <span id="lmsg1" class="text-danger"><?php echo isset($photo_error) ? $photo_error : ''; ?></span>
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label">Signature<span class="text-danger"> *(Not exceed 50KB)</span></label>
                                        <input type="file" id="signInput" accept=".jpg,.jpeg,.png" name="sign" required>
                                        <div id="imageContainer">
                                            <img id="imgsign" src="" >
                                        </div>
                                        <span id="lmsg2" class="text-danger"><?php echo isset($sign_error) ? $sign_error : ''; ?></span>
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label">Gaurdian Signature<span class="text-danger"> *(Not exceed 50KB)</span></label>
                                        <input type="file" id="gsignInput" accept=".jpg,.jpeg,.png" name="gsign" required >
                                        <div id="imageContainer">
                                            <img id="gimgsign" src=""  >
                                        </div>
                                        <span id="lmsg3" class="text-danger"><?php echo isset($gsign_error) ? $gsign_error : ''; ?></span>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <p><span class="fw-bold">Delcaration :-</span> The perticulars are true to the best of my knowledge. I fully well understand that application is liable to be cancelled in case any discrepancy is found in the data submitted. I shall abide by the rules and regulations of the Mahishadal Sadar Youth Computer Training Centre.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-grid gap-2 col-md-6">
                                        <button type="submit" name="" id="" class="btn btn-secondary bg-gradient waves-effect waves-light">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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