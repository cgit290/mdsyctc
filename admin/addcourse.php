<?php

include"header.php"; 
include"../database.php"; 



$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if($_POST['submit']=='add'){
        $dept=$_POST['dept'];
        $course=$_POST['course'];
        $fcourse=$_POST['fcourse'];
        $duration=$_POST['duration'];
        $fees=$_POST['fees'];
        $adamt=$_POST['adamt'];
        $insamt=$_POST['insamt'];
        $noi=$_POST['noi'];
        $elig=$_POST['elig'];
        $content=$_POST['content'];

        

            // Validate required fields
        if (empty($dept)) $errors['dept'] = "Department is required.";
        if (empty($course)) $errors['course'] = "Course code is required.";
        if (empty($fcourse)) $errors['fcourse'] = "Full course name is required.";
        if (empty($duration)) $errors['duration'] = "Duration is required.";
        if (empty($fees) || !is_numeric($fees)) $errors['fees'] = "Valid fees amount is required.";
        if (empty($adamt) || !is_numeric($adamt)) $errors['adamt'] = "Valid admission amount is required.";
        if (empty($insamt) || !is_numeric($insamt)) $errors['insamt'] = "Valid installment amount is required.";
        if (empty($noi) || !is_numeric($noi)) $errors['noi'] = "Valid number of installments is required.";
        if (empty($elig)) $errors['elig'] = "Eligibility criteria is required.";
        if (empty($content)) $errors['content'] = "Syllabus content is required.";

        // Handle file uploads
        if (empty($_FILES['photo']['name'])) {
            $errors['photo'] = "Thumbnail is required.";
        } else {
            // Check for file size (not exceeding 50KB)
            if ($_FILES['photo']['size'] > 51200) $errors['photo'] = "Thumbnail must not exceed 50KB.";

            // Check for file extension
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed_extensions)) {
                $errors['photo'] = "Thumbnail must be a valid image format (jpg, jpeg, png).";
            }
        }

        // Specify the upload directory and create it if it doesn't exist
        $photo_dir = "uploads/course/";
        if (!is_dir($photo_dir)) {
            mkdir($photo_dir, 0777, true);
        }

        // Change file names based on the course code
        $photo = $course . '.' . $extension;
        $photo_target = $photo_dir . $photo;

        // If no validation errors, move the uploaded file and insert into the database
        if (empty($errors)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target)) {
                $query = "INSERT INTO `coursetb` (`department`, `course`, `coursename`, `duration`, `eligibility`, `fees`, `admamount`, `insamount`, `nofinstallment`, `syllabus`, `thumbnail`) 
                        VALUES ('$dept', '$course', '$fcourse', '$duration', '$elig', '$fees', '$adamt', '$insamt', '$noi', '$content', '$photo')";
                $result1=mysqli_query($con,$query) or die("Could Not Perform the Query Insert course");
                if($result1!=""){
                    // Redirect to success page
                    echo "<script>alert('Course added successfully.');</script>";
                    header("Location: addcourse.php");
                }
                    
            } else {
                $errors['photo'] = "Error moving uploaded file.";
            }
        }
    }
}
?>

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
                                        <h4 class="card-title mb-0">New Course Entry Form</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="listjs-table" id="customerList">
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Department<span class="text-danger"> *</span></label>
                                                    <input type="text" name="dept" id="sdate" class="form-control" required> 
                                                    <?php if (isset($errors['dept'])): ?>
                                                        <span style="color:red;"><?= $errors['dept'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Course<span class="text-danger"> *</span></label>
                                                    <input type="text" name="course" id="sdate" class="form-control" required> 
                                                    <?php if (isset($errors['course'])): ?>
                                                        <span style="color:red;"><?= $errors['course'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-6" >
                                                    <label for="" class="form-label">Course Name<span class="text-danger"> *</span></label>
                                                    <input type="text" name="fcourse" id="sdate" class="form-control" required>  
                                                    <?php if (isset($errors['fcourse'])): ?>
                                                        <span style="color:red;"><?= $errors['fcourse'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label for="" class="form-label">Duration<span class="text-danger"> *</span></label>
                                                    <select name="duration" id="edate" class="form-control" required>
                                                        <option value="6 Months">6 Months</option>
                                                        <option value="12 Months">12 Months</option>
                                                        <option value="18 Months">18 Months</option>
                                                    </select>
                                                    <?php if (isset($errors['duration'])): ?>
                                                        <span style="color:red;"><?= $errors['duration'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Course Fees<span class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">&#8377;</div>
                                                        <input type="number" name="fees" id="sdate" class="form-control" required> 
                                                        <?php if (isset($errors['fees'])): ?>
                                                            <span style="color:red;"><?= $errors['fees'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Admission Amount<span class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">&#8377;</div>
                                                        <input type="number" name="adamt" id="sdate" class="form-control" required>  
                                                        <?php if (isset($errors['adamt'])): ?>
                                                            <span style="color:red;"><?= $errors['adamt'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-3" >
                                                    <label for="" class="form-label">Installment Amount<span class="text-danger"> *</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">&#8377;</div>
                                                        <input type="number" name="insamt" id="sdate" class="form-control" required>  
                                                        <?php if (isset($errors['insamt'])): ?>
                                                            <span style="color:red;"><?= $errors['insamt'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label for="" class="form-label">No. of Installment<span class="text-danger"> *</span></label>
                                                    <input type="number" name="noi" id="sdate" class="form-control" required>
                                                    <?php if (isset($errors['noi'])): ?>
                                                        <span style="color:red;"><?= $errors['noi'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label for="" class="form-label">Eligibility<span class="text-danger"> *</span></label>
                                                    <select name="elig" id="edate" class="form-control" required>
                                                        <option value="10th">10th</option>
                                                        <option value="12th">12th</option>
                                                        <option value="Graduate">Graduate</option>
                                                        <option value="Post Graduate">Post Graduate</option>
                                                    </select>
                                                    <?php if (isset($errors['elig'])): ?>
                                                        <span style="color:red;"><?= $errors['elig'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="mb-3 col-md-6" >
                                                    <label for="" class="form-label">Syllabus Covered<span class="text-danger"> *</span></label>
                                                    <textarea class="form-control" name="content"></textarea>
                                                    <?php if (isset($errors['content'])): ?>
                                                        <span style="color:red;"><?= $errors['content'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label for="" class="form-label">Course Thumbnail<span class="text-danger"> * (Max size 50KB)</span></label>
                                                    <input type="file" accept=".jpg,.png,.jpeg" name="photo" class="form-control" required>
                                                </div>
                                                <?php if (isset($errors['photo'])): ?>
                                                    <span style="color:red;"><?= $errors['photo'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-secondary bg-gradient waves-effect waves-light" value="add" name="submit">Add</button>
                                            </div>
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
