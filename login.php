<?php

ob_start();
session_start();

include 'header.php';
include 'database.php'; // Include the database configuration file

$pass="";
$error_msg="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['algusername'];
    $password = $_POST['algpassword'];
    $logger = $_POST['logger'];

    // Prepare and bind
    $query ="SELECT algpass FROM admintb WHERE algid = '$username' AND role = '$logger'";
    $result=mysqli_query($con, $query);
    while($row=mysqli_fetch_array($result,MYSQLI_NUM))
    {
        $pass=$row[0];
    }

    // Validate the password
    if ($pass==$password) {
        // Password is correct, start a session
        session_start();
        ob_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['user_type'] = $logger;

        // Redirect to the appropriate dashboard
        if ($logger == 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: dashboard/index.php");
        }
        exit();
    } else {
        // Invalid credentials
        $error_msg="Invalid username or password";
    }
}


ob_flush();
?>

        <!--=====================================-->
        <!--=          Login Area Start         =-->
        <!--=====================================-->
        <section class="account-page-area section-gap-equal">
            <div class="container position-relative">
                <div class="row g-5 justify-content-center">
                    <div class="col-lg-5">
                        <div class="login-form-box">
                            <h3 class="title">Sign in</h3>
                            <!-- <p>Don’t have an account? <a href="#">Sign up</a></p> -->
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <span class="text-danger"><?php echo $error_msg; ?> </span> 
                                <div class="form-group">
                                    <label for="current-log-email">Username</label>
                                    <input type="text" name="algusername" id="current-log-email" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="current-log-password">Password*</label>
                                    <input type="password" name="algpassword" id="current-log-password" placeholder="Password">
                                    <span class="password-show"><i class="icon-76"></i></span>
                                </div>
                                <div class="form-group chekbox-area">
                                    <div class="edu-form-check">
                                        <input type="hidden" id="std" name="logger" value="student">
                                        <input type="checkbox" id="adm" name="logger" value="admin">
                                        <label for="adm">Admin</label>
                                    </div>
                                    <a href="#" class="password-reset">Lost your password?</a>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="edu-btn btn-medium">Sign in <i class="icon-4"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <ul class="shape-group">
                    <li class="shape-1 scene"><img data-depth="2" src="assets/images/about/shape-07.png" alt="Shape"></li>
                    <li class="shape-2 scene"><img data-depth="-2" src="assets/images/about/shape-13.png" alt="Shape"></li>
                    <li class="shape-3 scene"><img data-depth="2" src="assets/images/counterup/shape-02.png" alt="Shape"></li>
                </ul>
            </div>
        </section>
<?php include"footer.php"; ?>
