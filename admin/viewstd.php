<?php

include"header.php"; 
include"../database.php"; 

    $i=0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'yes') {
        $regid=$_POST['regid'];
        // Prepare the SQL statement
        $sql = "UPDATE admissiontb SET verify = 1 WHERE sreg = '$regid'";
    
        // Execute the query
        if ($con->query($sql) === TRUE) header("location:viewstd.php");
        // exit();
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
                                    <h4 class="card-title mb-0">Student List</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="listjs-table" id="customerList">
                                        <div class="row g-4 mb-3">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <a href="addstd.php" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Add Student</a>
                                                    <a href="viewstd.php" class="btn btn-success add-btn"><i class=" ri-refresh-line me-1"></i> Refresh</a>                                                    
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
                                            <div class="col-sm-auto">
                                                <div>
                                                    <a href="excel.php" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i>Excel</a>
                                                    <a href="viewstd.php" class="btn btn-danger add-btn"><i class=" ri-refresh-line me-1"></i>PDF</a>                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive table-card mt-3 mb-1">
                                            <table class="table align-middle table-nowrap" id="customerTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" style="width: 50px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th class="sort" data-sort="ID">SL</th>
                                                        <th class="sort" data-sort="">Reg ID</th>
                                                        <th class="sort" data-sort="customer_name">Name</th>
                                                        <th class="sort" data-sort="customer_name">Father's Name</th>
                                                        <th class="sort" data-sort="customer_name">Course</th>
                                                        <th class="sort" data-sort="date">Admision Date</th>
                                                        <th class="sort" data-sort="status">Verify Status</th>
                                                        <th class="sort" data-sort="action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <tr>
                                                        <?php
                                                            $query="select areg,sname,sfname,course,adate,verify,stdid from admissiontb";
                                                            $result=mysqli_query($con,$query);
                                                            while($row=mysqli_fetch_array($result,MYSQLI_NUM))
                                                            {
                                                                $i=$i+1;
                                                                $areg=$row[0];
                                                                $sname=$row[1];
                                                                $sfname=$row[2];
                                                                $course=$row[3];
                                                                $adate=$row[4];
                                                                $verify=$row[5];
                                                                $stdid=$row[6];
                                                            
                                                        ?>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                            </div>
                                                        </th>
                                                        <td class="id"><?php echo $i; ?> </td>
                                                        <td class=""><?php echo $areg; ?></td>
                                                        <td class="customer_name"><?php echo $sname; ?></td>
                                                        <td class="customer_name"><?php echo $sfname; ?></td> 
                                                        <td class="customer_name"><?php echo $course; ?></td> 
                                                        <td class="date"><?php echo $adate; ?></td>
                                                        <td class="status">
                                                        <?php
                                                                if($verify==0)
                                                                {
                                                        ?>
                                                        <span class="badge bg-danger">Not Verify</span>
                                                        <?php
                                                                }
                                                                else{
                                                        ?>
                                                            <span class="badge bg-success">Verified</span>
                                                        </td>
                                                        <?php
                                                                }
                                                        ?>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <div class="edit">
                                                                    <a href="editstd.php?id=<?php echo $stdid ?>" class="btn btn-sm btn-success edit-item-btn" <?php if($verify==1) echo "hidden"; ?>>Edit</a>
                                                                </div>
                                                                <div class="remove">
                                                                    <button class="btn btn-sm btn-warning remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">View</button>
                                                                </div>
                                                                <div class="remove">
                                                                    <button class="btn btn-sm btn-danger" <?php if($row[5]==1) echo "hidden"; ?> data-bs-toggle="modal" data-bs-target="#myModal">Verify</button>
                                                                    <!-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Verify</button> -->
                                                                     <?php
                                                                        $id="myModal";
                                                                        $title="Verification";
                                                                        $message="Is all information correct?";
                                                                        $btnvalue="yes";
                                                                        $hivalue=$row[0];
                                                                        $hname="regid";
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
                    <!-- end row -->             
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
</div>
        
 
<!-- prismjs plugin -->
<script src="assets/libs/prismjs/prism.js"></script>
<script src="assets/libs/list.js/list.min.js"></script>
<script src="assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- listjs init -->
    <script src="assets/js/pages/listjs.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    
    <!-- Sweet Alert css-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <!-- <script src="assets/js/layout.js"></script> -->

<?php
include"footer.php";
?>

