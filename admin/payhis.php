<?php

include"header.php"; 
include"../database.php"; 

    $i=0;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        if($_POST['submit']=='delete'){
            $sesid=$_POST['ses'];
            $sql = "DELETE FROM coursetb WHERE id = '$sesid'";
            $result=mysqli_query($con,$sql) or die("Query delete could not run");
            if($result) echo "<script> alert('Course delete successful.')</script>";
        }
        // if($_POST['submit']=='edit'){
        //     $id=$_POST['id'];
        //    $_SESSION['id']=$id;
        //     header("Location : editcourse.php");
        // }
        
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
                                        <h4 class="card-title mb-0">Payment History List</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="listjs-table" id="customerList">
                                            <div class="row g-4 mb-1">
                                                <div class="col-sm-auto">
                                                    <div>
                                                        <a href="pay.php" class="btn btn-success add-btn" ><i class="ri-add-line align-bottom me-1"></i> Pay</a>
                                                        <a href="payhis.php">
                                                        <button class="btn btn-success add-btn"><i class=" ri-refresh-line me-1"></i> Refresh</button>
                                                        </a>
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
                                                            <th class="sort" data-sort="">Pay ID</th>
                                                            <th class="sort" data-sort="">Reg ID</th>
                                                            <th class="sort" data-sort="date">Amount</th>
                                                            <th class="sort" data-sort="date">Date</th>
                                                            <th class="sort" data-sort="date">Pay type</th>
                                                            <th class="sort" data-sort="date">Pay mode</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        <?php
                                                            $query="SELECT `payid`, `amount`, `date`, `type`, `mode`, `transimg`, areg FROM `paymenttb` inner join admissiontb on paymenttb.stdid=admissiontb.stdid";
                                                            $result=mysqli_query($con,$query);
                                                            while($row=mysqli_fetch_array($result,MYSQLI_NUM))
                                                            {
                                                                $i=$i+1;
                                                                $payid=$row[0];
                                                                $amt=$row[1];
                                                                $date=$row[2];
                                                                $type=$row[3];
                                                                $mode=$row[4];
                                                                $timg=$row[5];
                                                                $reg=$row[6];

                                                                $pid="MDS".date('Ymd',strtotime($date)).$payid;
                                                            
                                                        ?>
                                                        <tr>
                                                            
                                                            <!-- <th scope="row">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                                                </div>
                                                            </th> -->
                                                            <td class="id" ><?php echo $i; ?> </td>
                                                            <td class="" name="tsession"><?php echo $pid; ?></td>
                                                            <td class="date" name="tsdate"><?php echo $reg; ?></td>
                                                            <td class="date" name="tedate"><?php echo $amt; ?></td>
                                                            <td class="date" name="tedate"><?php echo $date; ?></td>
                                                            <td class="date" name="tedate"><?php echo $type; ?></td>
                                                            <td class="date" name="tedate">
                                                                <?php echo $mode; ?>
                                                                <a href="uploads/payment/<?php echo $timg ?>" <?php if(empty($timg)) echo "hidden";  ?> class="btn btn-sm btn-success">View</a>
                                                            </td>
                                                            <!-- <td>
                                                                <div class="d-flex gap-2">
                                                                    <div class="edit"> 
                                                                            <a href="editcourse.php?id=<?php echo $row[3] ?>" class="btn btn-sm btn-success edit-item-btn">Edit</a>
                                                                    </div>
                                                                    
                                                                    <div class="remove">
                                                                         <button type="button" class="btn btn-sm btn-warning " data-bs-toggle="modal" data-bs-target="#myModal">View</button> 
                                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">Delete</button>
                                                                        <?php
                                                                            $id="myModal";
                                                                            $title="Delete";
                                                                            $message="Are you sure?";
                                                                            $btnvalue="delete";
                                                                            $hivalue=$row[3];
                                                                            $hname="ses";
                                                                            include"del_modal.php";
                                                                        } 
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </td> -->
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
        </div>
        <!-- container-fluid -->
    </div>
</div>
        
           

<?php
include"footer.php";
?>
