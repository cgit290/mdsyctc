<?php 
    include "header.php"; 
    include "database.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array(); // Array to hold validation errors
        $name = strtoupper(mysqli_real_escape_string($con, $_POST['name']));
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
        $address = strtoupper(mysqli_real_escape_string($con, $_POST['address']));
        $message = strtoupper(mysqli_real_escape_string($con, $_POST['message']));

        if (empty($name)) $errors['name'] = "Name is required.";
        if (empty($email)) $errors['email'] = "Email is required.";
        if (empty($mobile)) $errors['mobile'] = "Mobile number is required.";
        if (empty($address)) $errors['address'] = "Address is required.";
        if (empty($message)) $errors['message'] = "Message is required.";

        if (empty($errors)) {
            $query = "INSERT INTO `callbacktb` (`name`, `email`, `mobile`, `address`, `askquery`) 
                      VALUES ('$name', '$email', '$mobile', '$address', '$message')";
            if (mysqli_query($con, $query)) {
                include"admin/del_modal.php";
                echo "<script>
                        alert('We will contact you soon.');
                        window.location.href = 'index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Something went wrong!');
                      </script>";
            }
        }
    }
?>


<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Contact Us</h1>
            </div>
            <ul class="edu-breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ul>
        </div>
    </div>
    <ul class="shape-group">
        <li class="shape-1">
            <span></span>
        </li>
        <li class="shape-2 scene"><img data-depth="2" src="assets/images/about/shape-13.png" alt="shape"></li>
        <li class="shape-3 scene"><img data-depth="-2" src="assets/images/about/shape-15.png" alt="shape"></li>
        <li class="shape-4">
            <span></span>
        </li>
        <li class="shape-5 scene"><img data-depth="2" src="assets/images/about/shape-07.png" alt="shape"></li>
    </ul>
</div>

<!--=====================================-->
<!--=       Contact Me Area Start       =-->
<!--=====================================-->
<section class="contact-us-area">
    <div class="container">
        <div class="row g-5">
            <div class="col-xl-4 col-lg-6">
                <div class="contact-us-info">
                    <h3 class="heading-title">We're Always Eager to Hear From You!</h3>
                    <ul class="address-list">
                        <li>
                            <h5 class="title">Address</h5>
                            <p>Mahishadal Bus Stop, Haldia - Tamluk - Mechada Rd., Mahishadal, West Bengal 721628</p>
                        </li>
                        <li>
                            <h5 class="title">Email</h5>
                            <p><a href="mailto:mahishadalsadar@gmail.com">mahishadalsadar@gmail.com</a></p>
                        </li>
                        <li>
                            <h5 class="title">Phone</h5>
                            <p><a href="tel:+919734397343">+91 97343 97343</a></p>
                        </li>
                    </ul>
                    <ul class="social-share">
                        <li><a href="https://whatsapp.com/channel/0029VaHBXkt4SpkOAdHNds37"><i class="icon-phone"></i></a></li>
                        <li><a href="https://www.facebook.com/mahishadalsadaryctc/"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://www.youtube.com/@MahishadalSadarYCTC"><i class="icon-youtube"></i></a></li>
                        <!-- <li><a href="#"><i class="icon-linkedin2"></i></a></li> -->
                    </ul>
                </div>
            </div>
            <div class="offset-xl-2 col-lg-6">
                <div class="contact-form form-style-2">
                    <div class="section-title">
                        <h4 class="title">Ask Query</h4>
                        <p>Fill out this form for contact with you.</p>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="row row--10">
                            <div class="form-group col-12">
                                <input type="text" name="name" id="contact-name" placeholder="Your name" required>
                            </div>
                            <div class="form-group col-12">
                                <input type="email" name="email" id="contact-email" placeholder="Email" required>
                            </div>
                            <div class="form-group col-12">
                                <input type="text" name="mobile" id="contact-phone" placeholder="Phone number" maxlength="10" minlength="10" required>
                            </div>
                            <div class="form-group col-12">
                                <input type="tel" name="address" id="contact-phone" placeholder="Address" required>
                            </div>
                            <div class="form-group col-12">
                                <textarea name="message" id="message" cols="30" rows="4" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group col-12">
                                <button class="rn-btn edu-btn btn-medium submit-btn" name="submit" type="submit">Submit Message <i class="icon-4"></i></button>
                            </div>
                        </div>
                    </form>
                    <ul class="shape-group">
                        <li class="shape-1 scene"><img data-depth="1" src="assets/images/about/shape-13.png" alt="Shape"></li>
                        <li class="shape-2 scene"><img data-depth="-1" src="assets/images/counterup/shape-02.png" alt="Shape"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=====================================-->
<!--=      Google Map Area Start        =-->
<!--=====================================-->
<div class="google-map-area">
    <div class="mapouter">
        <div class="gmap_canvas">
            <iframe id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14777.515579252391!2d87.9875528!3d22.1877026!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a02ed0dd6ee5765%3A0x6c87ba3858c54d1e!2sMahishadal%20Sadar%20Youth%20Computer%20Training%20Centre!5e0!3m2!1sen!2sin!4v1720937176390!5m2!1sen!2sin" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
    </div>
</div>
<?php include"footer.php"; ?>