   
<script src="../assets/js/jquery-3.6.0.min.js"></script>
<?php


include"header.php"; 
include"../database.php"; 

    
    $i=0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

        // Prepare the SQL statement
        if($_POST['submit']=='add')
        {
            $ses=$_POST['session'];
            $sdate=$_POST['sdate'];
            $edate=$_POST['edate'];
            $sql = "INSERT INTO `sessiontb`(`session`, `startdate`, `enddate`) VALUES ('$ses','$sdate','$edate')";
            if ($con->query($sql)===TRUE){
                echo "<script> alert('Session add successful!'); </script>";
                // header("location:session.php");
                
            }
        }
        if($_POST['submit']=='save')
        {
            $ses=$_POST['session'];
            $sdate=$_POST['sdate'];
            $edate=$_POST['edate'];
            $sql = "UPDATE sessiontb SET `startdate`='$sdate',`enddate`='$edate'";
            if ($con->query($sql)===TRUE){
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
        if($_POST['submit']=='delete')
        {
            $sesid=$_POST['ses'];
            $sql = "DELETE FROM sessiontb WHERE session = '$sesid'";
            if ($con->query($sql)===TRUE){
                echo "<script> alert('Session delete successful!'); </script>";
                // header("location:session.php");
               /* $id='';
                $title="";
                $message="Session delete successful!";
                $btnvalue="";
                $hivalue="";
                $hname="";
                include"info_modal.php";
                echo "<script>
                            $('#mds').modal('show');
                        </script>"; */
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
                                    <h4 class="card-title mb-0">Session List</h4>
                                </div><!-- end card header -->
                                
                                <div class="card-body">
                                    <div class="listjs-table" id="customerList">
                                        <div class="row g-4 mb-1">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#aModal"><i class="ri-add-line align-bottom me-1"></i> Add Session</button>
                                                    <button class="btn btn-success add-btn" onclick="reloadPage()"><i class=" ri-refresh-line me-1"></i> Refresh</button>
                                                    <?php
                                                        $sql = "SELECT MAX(session) FROM sessiontb";
                                                        $result=mysqli_query($con,$sql);
                                                        while($row1=mysqli_fetch_array($result))
                                                        {
                                                            $last=$row1[0];
                                                        }
                                                        $id="aModal";
                                                        $title="Add Session";
                                                        $f1lbl="Session";
                                                        $f1name="session";
                                                        $f1value=$last+1;
                                                        $f2lbl="Start Date";
                                                        $f2name="sdate";
                                                        $f3lbl="End Date";
                                                        $f3name="edate";
                                                        $btnvalue="add";
                                                        include"input3_modal.php";
                                                    ?>
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
                                                        <th class="sort" data-sort="">Session</th>
                                                        <th class="sort" data-sort="date">Start Date</th>
                                                        <th class="sort" data-sort="date">End Date</th>
                                                        <th class="sort" data-sort="action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php
                                                        $query="select * from sessiontb";
                                                        $result=mysqli_query($con,$query);
                                                        while($row=mysqli_fetch_array($result,MYSQLI_NUM))
                                                        {
                                                            $i=$i+1;
                                                        
                                                    ?>
                                                    <tr>
                                                        
                                                        <!-- <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                            </div>
                                                        </th> -->
                                                        <td class="id" ><?php echo $i; ?> </td>
                                                        <td class="" name="tsession"><?php echo $row[0]; ?></td>
                                                        <td class="date" name="tsdate"><?php echo $row[1]; ?></td>
                                                        <td class="date" name="tedate"><?php echo $row[2]; ?></td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <div class="edit">
                                                                    <button class="btn btn-sm btn-success edit-item-btn" name="edit" type="submit" id="btnEdit" data-bs-toggle="modal" data-bs-target="#eModal">Edit</button>
                                                                    <?php 
                                                                        $id="eModal";
                                                                        $title="Edit Session";
                                                                        $f1lbl="Session";
                                                                        $f1name="session";
                                                                        $f2lbl="Start Date";
                                                                        $f2name="sdate";
                                                                        $f3lbl="End Date";
                                                                        $f3name="edate";
                                                                        $btnvalue="save";
                                                                        $f1value=$hivalue=$row[0];
                                                                        $f2value=$row[1];
                                                                        $f3value=$row[2];
                                                                        $hname="ses";
                                                                        include"input3_modal.php";
                                                                    ?>
                                                                </div>
                                                                
                                                                <div class="remove">
                                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">Delete</button>
                                                                    <!-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Verify</button> -->
                                                                    <?php
                                                                        $id="myModal";
                                                                        $title="Delete";
                                                                        $message="Are you sure?";
                                                                        $btnvalue="delete";
                                                                        $hivalue=$row[0];
                                                                        $hname="ses";
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