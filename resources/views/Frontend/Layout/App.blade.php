<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->

<head>
    <!-- Title -->
    <title>”প্রতিষ্ঠানের নাম “ সবাইকে স্বাগতম</title>
    <!-- Meta -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description"
        content="খুব শিঘ্রই এই অংশটি আপডেট করা হবে। ">
    <meta name="author" content="”প্রতিষ্ঠানের নাম “">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    @include('Frontend.Include.Style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        new WOW().init();
    </script>
</head>

<body>
    <div id="body_bg">

        <div id="pre_header" class="container"><!-- pre_header start -->
            <div class="row margin-top-10 visible-lg"><!-- row margin-top-10 visible-lg start -->
                <div class="col-md-6"><!-- col-md-6 start -->
                    <p>
                        <strong>Phone :</strong>&nbsp; +88 01XXX XXXXX
                    </p>
                </div><!-- col-md-6 end -->

                <div class="col-md-6 text-right"><!-- col-md-6 text-right start -->
                    <p>
                        <strong>Email :</strong>&nbsp; info@yourwebsite.com
                    </p>
                </div><!-- col-md-6 text-right end -->
            </div><!-- row margin-top-10 visible-lg end -->
        </div><!-- pre_header end -->
        <div class="primary-container-group">
            <!-- Background -->
            <div class="primary-container-background">
                <div class="primary-container"></div>
                <div class="clearfix"></div>
            </div>
            <!--End Background -->
            <div class="primary-container">
               @include('Frontend.Include.Header')
                <!-- Top Menu -->
                @include('Frontend.Include.Menu')
                <!-- End Top Menu -->
                <!-- === END HEADER === -->
                <!-- === BEGIN CONTENT === -->
                <div id="content">

                  <!-- Marquee Notice Start -->
					<div class="container no-padding">
						<div class="notice-bar bg-light p-2 rounded shadow-sm">
							<marquee scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
								<a href="full_impnotice.php?id=2" class="text-danger fw-bold">
									📢 গুরুত্বপূর্ণ বিজ্ঞপ্তি: খুব শিগগিরই এই অংশটি আপডেট করা হবে। অনুগ্রহ করে অপেক্ষা করুন! &nbsp; | &nbsp;
									📢 নতুন ফিচার আসছে খুব শিগগিরই! &nbsp; | &nbsp;
									📢 ওয়েবসাইট সংক্রান্ত যেকোনো সমস্যার জন্য আমাদের সাথে যোগাযোগ করুন।
								</a>
							</marquee>
						</div>
					</div>
					<!-- Marquee Notice End -->

                <!-- Marque notice end --> 



                    @yield('content')
                </div>
            </div>
        </div>
        <!-- === END CONTENT === -->
        <!-- === BEGIN FOOTER === -->
        <div id="base">
            <div class="container padding-vert-30 margin-top-40">
                <div class="row">
                    <!-- Important Links -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-15 text-primary">Important Links</h3>
                        <ul class="menu">
                            <li><a class="fa-link" href="http://bangladesh.gov.bd/" target="_blank">National Portal (BD)</a></li>
                            <li><a class="fa-link" href="http://www.dshe.gov.bd/" target="_blank">DSHE</a></li>
                            <li><a class="fa-link" href="http://www.nctb.gov.bd/" target="_blank">NCTB</a></li>
                            <li><a class="fa-link" href="http://emis.gov.bd/main/App_Pages/Client/Default.aspx" target="_blank">EMIS</a></li>
                            <li><a class="fa-link" href="http://www.ictd.gov.bd/" target="_blank">ICT Department</a></li>
                            <li><a class="fa-link" href="http://ntrca.gov.bd/">NTRCA</a></li>
                        </ul>
                    </div>

                    <!-- Additional Important Links -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-15 text-primary">Additional Links</h3>
                        <ul class="menu">
                            <li><a class="fa-link" href="http://www.ebook.gov.bd/page.php?section=general&class=1">E-book</a></li>
                            <li><a class="fa-link" href="http://www.moedu.gov.bd/" target="_blank">Education Ministry</a></li>
                            <li><a class="fa-link" href="https://www.teachers.gov.bd/" target="_blank">Teachers Portal</a></li>
                            <li><a class="fa-link" href="http://www.dainikshiksha.com/">Dainikshiksha.com</a></li>
                            <li><a class="fa-link" href="all_board_result.php">Result of SSC & JSC</a></li>
                            <li><a class="fa-link" href="http://bangladesh.gov.bd/site/view/all_eservices/%E0%A6%B8%E0%A6%95%E0%A6%B2-%E0%A6%87-%E0%A6%B8%E0%A7%87%E0%A6%AC%E0%A6%BE" target="_blank">All e-services</a></li>
                        </ul>
                    </div>

                    <!-- Attendance Info -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-15 text-primary">Attendance</h3>
                        <ul class="menu">
                            <li><a class="fa-angle-double-right" href="#">Total Students: 500</a></li>
                            <li><a class="fa-angle-double-right" href="#">Present: 450</a></li>
                            <li><a class="fa-angle-double-right" href="#">Absent: 50</a></li>
                            <li><a class="fa-angle-double-right" href="#">Total Teachers/Staff: 22</a></li>
                            <li><a class="fa-angle-double-right" href="#">Present: 21</a></li>
                            <li><a class="fa-angle-double-right" href="#">Absent: 1</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-15 text-primary">Contact Us</h3>
                        <p><strong>“Institution Name”</strong><br> Address: প্রতিষ্ঠানের ঠিকানা</p>
                        <p>
                            <span class="fa-phone">:</span> <a href="http://it-fast.com/education_management.html">+88 01XXX XXXXX</a><br>
                            <span class="fa-envelope">:</span> <a href="mailto:info@yourwebsite.com">info@yourwebsite.com</a>
                        </p>

                        <br />
                        <a class="fa-users" href="#">Total Visitors: 58</a><br />
                        <a class="fa-user" href="#">Visitor Today: 0</a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <!-- Footer Menu -->
        @include('Frontend.Include.Footer')
        <!-- JS -->
       @include('Frontend.Include.Script')
    </div> <!-- End JS -->
</body>

</html>
