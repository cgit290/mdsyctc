<script src="../assets/js/jquery-3.6.0.min.js"></script>
<?php
session_start();

if (!isset($_SESSION['username'])=='' && !isset($_SESSION['password'])=='') {
    header("Location: login.php");
    exit();
}

include"header.php"; 
include"../database.php"; 
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="h-100">
                                                            
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
