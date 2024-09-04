<?php 
    include"database.php";
    include"header.php";
    
?>
<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Our Course</h1>
            </div>
            <ul class="edu-breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Course</li>
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
<!--=        Courses Area Start         =-->
<!--=====================================-->
<div class="edu-course-area course-area-1 gap-tb-text">
            <div class="container">
                <div class="edu-sorting-area">
                    <div class="sorting-left">
                        <?php
                         $query="select * from coursetb";
                         $result=mysqli_query($con,$query);
                         $num_row=mysqli_num_rows($result);
                        ?>
                        <h6 class="showing-text">We found <span><?php echo "$num_row" ?></span> courses available for you</h6>
                    </div>
                    <!-- <div class="sorting-right">
                        <div class="layout-switcher">
                            <label>Grid</label>
                            <ul class="switcher-btn">
                                <li><a href="course-one.html" class="active"><i class="icon-53"></i></a></li>
                                <li><a href="course-four.html" class=""><i class="icon-54"></i></a></li>
                            </ul>
                        </div>
                        <div class="edu-sorting">
                            <div class="icon"><i class="icon-55"></i></div>
                            <select class="edu-select">
                                <option>Filters</option>
                                <option>Low To High</option>
                                <option>High Low To</option>
                                <option>Last Viewed</option>
                            </select>
                        </div>
                    </div> -->
                </div>
                
                <div class="row g-5">
                    <!-- Start Single Course  -->
                    <?php
                        $query="select department,course,coursename,duration,fees,eligibility,thumbnail from coursetb";
                        $result=mysqli_query($con,$query);
                        $num_row=mysqli_num_rows($result);
                        
                        while($row=mysqli_fetch_array($result,MYSQLI_NUM))
                        {
                            
                            $dept=$row[0];
                            $course=$row[1];
                            $fcourse=$row[2];
                            $dura=$row[3];
                            $fees=$row[4];
                            $elig=$row[5];
                            $pic=$row[6];

                            //Deparment Short name
                            $ddpt1=strtok($dept," ");
                            $ddpt2=strtok(" ");
                            $dname= substr($ddpt1,0,1).substr($ddpt2,0,1);
                    ?>
                            <div class="col-md-6 col-lg-4 col-xl-4" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                            <div class="edu-course course-style-1 course-box-shadow hover-button-bg-white">
                                    <div class="inner">
                                        <div class="thumbnail">
                                            <a href="<?php echo strtolower($dname); ?>.php">
                                                <img src="admin/uploads/course/<?php echo "$pic"; ?>" alt="Course Meta">
                                            </a>
                                            <div class="time-top">
                                                <span class="duration"><i class="icon-61"></i><?php echo "$dura"; ?></span>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <span class="course-level"><?php echo "$dept"; ?></span>
                                            <h6 class="title">
                                                <a href="<?php echo strtolower($dname); ?>.php"><?php echo "$fcourse($course)"; ?></a>
                                            </h6>
                                            <div class="course-rating">
                                                <div class="rating">
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                </div>
                                                <span class="rating-count">(5.0 /9 Rating)</span>
                                            </div>
                                            <div class="course-price"><?php echo "Rs $fees.00"; ?></div>
                                            <ul class="course-meta">
                                                <li><i class="icon-24"></i><?php echo "Eligibility - $elig"; ?></li>
                                                <!-- <li><i class="icon-25"></i>31 Students</li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="course-hover-content-wrapper">
                                        <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    </div>
                                    <div class="course-hover-content-wrapper">
                                        <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    </div>
                                    <div class="course-hover-content">
                                        <div class="content">
                                            <button class="wishlist-btn"><i class="icon-22"></i></button>
                                            <span class="course-level">Advanced</span>
                                            <h6 class="title">
                                                <a href="course-details.html">The Complete Camtasia Course for Content Creators</a>
                                            </h6>
                                            <div class="course-rating">
                                                <div class="rating">
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                    <i class="icon-23"></i>
                                                </div>
                                                <span class="rating-count">(5.0 /9 Rating)</span>
                                            </div>
                                            <div class="course-price">$49.00</div>
                                            <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor.</p>
                                            <ul class="course-meta">
                                                <li><i class="icon-24"></i>15 Lessons</li>
                                                <li><i class="icon-25"></i>31 Students</li>
                                            </ul>
                                            <a href="course-details.html" class="edu-btn btn-secondary btn-small">Enrolled <i class="icon-4"></i></a>
                                        </div>
                                    </div>-->
                                </div>
                            </div> 
                    <?php
                        }
                     ?>
                    
            </div>
        </div>
    </div>
<?php
    include"footer.php"; 
?>