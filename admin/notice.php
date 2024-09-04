   
<script src="../assets/js/jquery-3.6.0.min.js"></script>
<?php


include"header.php"; 
include"../database.php"; 
$errors=[];
    
    $i=0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Prepare the SQL statement
        if($_POST['submit']=='add')
        {
            
            $title=$_POST['title'];
            $photo=$_FILES['photo']['name'];

            // Handle file uploads
            if (empty($_FILES['photo']['name'])) {
                $errors['photo'] = "Attachment is required.";
            } else {
                // Check for file size (not exceeding 50KB)
                if ($_FILES['photo']['size'] > 1048576) $errors['photo'] = "Attachment must not exceed 1MB.";

                // Check for file extension
                // $allowed_extensions = ['jpg', 'jpeg', 'png'];
                // $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                // if (!in_array(strtolower($extension), $allowed_extensions)) {
                //     $errors['photo'] = "Attachment must be a valid image format (jpg, jpeg, png).";
                // }
            }

            // Specify the upload directory and create it if it doesn't exist
            $photo_dir = "uploads/notice/";
           
            if (!is_dir($photo_dir)) {
                mkdir($photo_dir, 0777, true);
            }
           
            $photo_target = $photo_dir . $photo;
            
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target)) {
                $sql = "INSERT INTO `noticetb`(`title`, `filename`,active) VALUES ('$title','$photo',1)";
                if ($con->query($sql)===TRUE){
                    echo "<script> alert('Notice add successful!'); </script>";
                    // header("location:session.php");
                    
                }
            }
        }
        if($_POST['submit']=='del')
        {
            $id=$_POST['id'];
            $nfile=$_POST['file'];
            unlink('uploads/notice/'.$nfile);
            $sql = "DELETE FROM noticetb where id='$id'";
            if ($con->query($sql)===TRUE){
                echo "<script> alert('Notice delete successful!'); </script>";
                // echo "<script> alert('Session edit successful!'); </script>";
                // header("location:session.php");
                /*$id="";
                $title="";
                $message="Session delete successful!";
                $btnvalue="";
                $hivalue="";
                $hname="";
                include"info_modal.php";
                echo "<script>
                            function showModal() {
                            $('#mds').modal('show'); }
                        </script>"; */
                // $_POST=array();
            }
        }   
        if($_POST['submit']=='act')
        {
            $id=$_POST['id'];
            // $filename='uploads/notice/' . $id;
            $stmt = "UPDATE noticetb SET active = CASE WHEN active = 1 THEN 0 ELSE 1 END WHERE id = '$id'";
            if (mysqli_query($con,$stmt)) {
                echo "<script> alert('Notice active status change successful!'); </script>";
            }else{
                echo "error" . $con->error;
                // echo "<script> alert('error!'); </script>";
            }
            
        }
    
        // Execute the query
        // $_POST=array();
        // header("location:session.php");
        
        // exit();
    }   
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="h-100">
                    <!-- <div class="row">
                        <div class="">
                            <div class="card">
                                <div class="card-header align-items-center d-flex col-xxl-12">
                                    <h4 class="card-title mb-0 flex-grow-1">Add Session</h4>
                                    
                                </div>end card header
                                <div class="card-body">
                                    <p class="text-muted">Example of vertical form using <code>form-control</code> class. No need to specify row and col class to create vertical form.</p>
                                    <div class="live-preview ">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row">
                                            <div class="mb-3 col-md-4">
                                                <label for="employeeName" class="form-label">Session</label>
                                                <input type="number" name="session" class="form-control" id="ses" placeholder="Enter session">
                                            </div>
                                            <div class="mb-3">
                                                <label for="employeeUrl" class="form-label">Employee Department URL</label>
                                                <input type="url" class="form-control" id="employeeUrl" placeholder="Enter emploree url">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="StartleaveDate" class="form-label">Start Date</label>
                                                <input type="date" name="sdate" class="form-control" data-provider="flatpickr" id="StartDate">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="EndleaveDate" class="form-label">End Date</label>
                                                <input type="date" name="edate" class="form-control" data-provider="flatpickr" id="EndDate">
                                            </div>
                                            <div class="mb-3">
                                                <label for="VertimeassageInput" class="form-label">Message</label>
                                                <textarea class="form-control" id="VertimeassageInput" rows="3" placeholder="Enter your message"></textarea>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary" name="submit" value="add">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Notice List</h4>
                                </div><!-- end card header -->
                                
                                <div class="card-body">
                                    <div class="listjs-table" id="customerList">
                                        <div class="row g-4 mb-1">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#nModal"><i class="ri-add-line align-bottom me-1"></i> Add Notice</button>
                                                    <a href="notice.php"><button class="btn btn-success add-btn"><i class=" ri-refresh-line me-1"></i> Refresh</button></a>
                                                    <!-- Add and Edit Session Modal -->
                                                    <div id="nModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="myModalLabel">Add Notice</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="employeeName" class="form-label">Title</label>
                                                                            <input type="text" name="title" class="form-control" id="title" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="StartleaveDate" class="form-label">Attachment</label>
                                                                            <input type="file" name="photo" class="form-control" id="photo" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button> -->
                                                                        <button type="submit" class="btn btn-primary " name="submit" value="add">Add</button>
                                                                    </div>
                                                                </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="d-flex justify-content-sm-end">
                                                    <div class="search-box ms-2">
                                                        <input type="text" class="form-control search" placeholder="Search...">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive table-card mt-3 mb-1">
                                            <table class="table align-middle table-nowrap" id="customerTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <!-- <th scope="col" style="width: 50px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th> -->
                                                        <th class="sort" data-sort="ID">SL</th>
                                                        <th class="sort" data-sort="">Title</th>
                                                        <th class="sort" data-sort="">Attachment</th>
                                                        <th class="sort" data-sort="date">Date</th>
                                                        <th class="sort" data-sort="action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php
                                                        $query="select id,title,filename,sdate,active from noticetb";
                                                        $result=mysqli_query($con,$query);
                                                        while($row=mysqli_fetch_array($result,MYSQLI_NUM))
                                                        {
                                                            $i=$i+1;
                                                            $ids=$row[0];
                                                            $title=$row[1];
                                                            $file=$row[2];
                                                            $date= $row[3]; 
                                                            $act=$row[4];
                                                        
                                                    ?>
                                                    <tr>
                                                        
                                                        <!-- <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                            </div>
                                                        </th> -->
                                                        <td class="id" ><?php echo $i; ?> </td>
                                                        <td class="" name="tsession"><?php echo $title; ?></td>
                                                        <td class="date" name="tsdate"><?php echo $file ?></td>
                                                        <td class="date" name="tedate"><?php echo $date ?></td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <div class="edit">
                                                                    <a href="uploads/notice/<?php echo $file; ?>" target="_blank" class="btn btn-sm btn-primary edit-item-btn" name="view" role="button" id="view">View</a>
                                                                    
                                                                </div>
                                                                
                                                                <div class="remove">
                                                                    <input type="hidden" value="<?php echo $ids ?>" name="ids">
                                                                    <?php if($act){ ?>
                                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#myModal" value="act" name="submit" >Active</button>
                                                                    <?php }else{ ?>
                                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#myModal" value="act" name="submit">In-Active</button>
                                                                    <?php } ?>
                                                                    <button type="button" class="btn btn-sm btn-secondary " data-bs-toggle="modal" data-bs-target="#dModal">Delete</button>
                                                                    <?php
                                                                        $id="myModal";
                                                                        $title="Status Update";
                                                                        $message="Are you sure?";
                                                                        $btnvalue="act";
                                                                        $hivalue=$ids;
                                                                        $hname="id";
                                                                        include"del_modal.php";
                                                                        $id="dModal";
                                                                        $title="Delete";
                                                                        $message="Are you sure?";
                                                                        $btnvalue="del";
                                                                        $hfile=$file;
                                                                        $hivalue=$ids;
                                                                        $hname="id";
                                                                        include"del_modal.php";
                                                                     } 
                                                                     ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <div class="pagination-wrap hstack gap-2">
                                                <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                                    Previous
                                                </a>
                                                <ul class="pagination listjs-pagination mb-0"></ul>
                                                <a class="page-item pagination-next" href="javascript:void(0);">
                                                    Next
                                                </a>
                                            </div>
                                        </div>
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
        <!-- container-fluid -->
    </div>
</div>
        
         

<?php
include"footer.php";
?>