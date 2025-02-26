@extends('Frontend.Layout.App')
@section('title','Welcome Our website')
@section('style')

<style>
    /* Welcome Section */
.welcome-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

/* Welcome Title */
.welcome-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
}

/* Notice Boxes */
.notice-box {
    max-height: 200px;
    overflow: hidden;
    padding: 10px;
    background: #fff;
    border-radius: 5px;
}

/* Notice List */
.notice-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.notice-list li {
    padding: 5px 0;
    border-bottom: 1px solid #ddd;
}

.notice-list li a {
    color: #333;
    font-weight: bold;
    text-decoration: none;
    display: block;
}

.notice-list li a:hover {
    color: #007bff;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    .welcome-section {
        padding: 15px;
    }

    .notice-box {
        max-height: 150px;
    }

    .notice-list li {
        font-size: 14px;
    }
}


.portfolio-item {
            position: relative;
            overflow: hidden;
            text-align: center;
            margin-bottom: 20px;
        }
        .portfolio-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .portfolio-item:hover img {
            transform: scale(1.1);
        }
        .portfolio-item figcaption {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .portfolio-item:hover figcaption {
            opacity: 1;
        }
        .portfolio-item h3 {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
        }

</style>
@endsection
@section('content')

<div class="container no-padding">
    <div class="row">
        <!-- Carousel Slideshow -->
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <!-- Carousel Indicators -->

            <div class="clearfix"></div>
            <!-- End Carousel Indicators -->
            <!-- Carousel Images -->
            <div class="carousel-inner">
                <div class="item active"><img
                        src="https://rzasc.com/uploads/frontend/images/logo117108410850319.png"
                        width="1080" height="400"></div>
                <div class="item"><img
                        src="https://rzasc.com/uploads/frontend/images/logo117108410850319.png"
                        width="1080" height="400"></div>
                <div class="item"><img
                        src="https://rzasc.com/uploads/frontend/images/logo117108410850319.png"
                        width="1080" height="400"></div>
            </div>
            <!-- End Carousel Images -->
            <!-- Carousel Controls -->
            <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
            <!-- End Carousel Controls -->
        </div>
        <!-- End Carousel Slideshow -->
    </div>
</div>

<div class="container">
    <div class="row margin-vert-30">
        <!-- Main Content Section -->
        <div class="col-md-9">
            <div class="welcome-section wow fadeInLeft" data-wow-duration="1.5s">
                <h2 class="welcome-title text-primary">
                    স্বাগতম রামনগর জেড.এ. স্কুল এন্ড কলেজের নিজস্ব ওয়েবসাইটে
                </h2>
                <p class="text-justify">
                    ২০০৭ সালে প্রতিষ্ঠিত রামনগর জেড.এ. উচ্চ বিদ্যালয় এর ধারাবাহিক সাফল্যে এলাকাবসীর দাবী ও শিক্ষার্থীদের চাহিদার প্রেক্ষিতে ডিজিটাল বাংলাদেশ গড়ার প্রত্যয়ে প্রতিষ্ঠিত করা হয়েছে।
                    <br>
                    <a href="fullview.php?msg=5" class="btn btn-primary btn-sm wow bounceIn">আরও পড়ুন</a>
                </p>
                <img class="img-responsive img-thumbnail animate fadeInUp" src="https://rzasc.com/uploads/frontend/home_page/wellcome116773260420225.jpeg" alt="Welcome Image">
            </div>
        </div>
        <!-- End Main Content Section -->

        <!-- Sidebar Section -->
        <div class="col-md-3">
            <!-- Important Notices -->
            <div class="panel panel-danger wow fadeInRight" data-wow-duration="1.5s">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-bell"></i> জরুরি বিজ্ঞপ্তি</h3>
                </div>
                <div class="panel-body notice-box">
                    <marquee direction="up" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">
                        <ul class="notice-list">
                            <li><a href="full_impnotice.php?id=2">শিক্ষা কার্যক্রম সংক্রান্ত নোটিশ</a></li>
                            <li><a href="full_impnotice.php?id=3">শিক্ষার্থীদের জন্য নির্দেশনা</a></li>
                            <li><a href="full_impnotice.php?id=4">নতুন অ্যাডমিশন নোটিশ</a></li>
                        </ul>
                    </marquee>
                </div>
            </div>

            <!-- General Notices -->
            <div class="panel panel-info wow fadeInRight" data-wow-delay="0.5s">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-info-sign"></i> সাধারণ বিজ্ঞপ্তি</h3>
                </div>
                <div class="panel-body notice-box">
                    <marquee direction="up" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">
                        <ul class="notice-list">
                            <li><a href="full_gnnotice.php?id=3">জাতীয় তথ্য ও যোগাযোগ প্রযুক্তি নীতিমালা</a></li>
                            <li><a href="full_gnnotice.php?id=4">নতুন শিক্ষাবর্ষের একাডেমিক ক্যালেন্ডার</a></li>
                            <li><a href="full_gnnotice.php?id=5">শিক্ষার্থীদের নতুন সময়সূচি</a></li>
                            <li><a href="full_gnnotice.php?id=5">শিক্ষার্থীদের নতুন সময়সূচি</a></li>
                            <li><a href="full_gnnotice.php?id=5">শিক্ষার্থীদের নতুন সময়সূচি</a></li>
                        </ul>
                    </marquee>
                </div>
            </div>
        </div>
        <!-- End Sidebar Section -->
    </div>
</div>



<div class="container background-gray-lighter py-5">
    <div class="row">
        <ul class="portfolio-group list-unstyled d-flex flex-wrap justify-content-between">
            <!-- Portfolio Item 1 -->
            <li class="portfolio-item col-md-3 col-sm-4 col-xs-6 wow fadeInUp mb-4" data-wow-delay="0.2s">
                <h3 class="text-center text-primary">সভাপতির বাণী</h3>
                <figure class="figure position-relative">
                    <img src="https://rzasc.com/uploads/frontend/home_page/featured-parallax116773259770225.jpeg" alt="সভাপতির ছবি" class="img-fluid rounded shadow-sm">
                    <figcaption class="figcaption position-absolute bottom-0 start-0 w-100 text-white p-3 bg-dark bg-opacity-50">
                        খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে।
                        <a href="fullview.php?msg=3" class="text-warning text-decoration-none">More..</a>
                    </figcaption>
                </figure>
            </li>
            <!-- Portfolio Item 2 -->
            <li class="portfolio-item col-md-3 col-sm-4 col-xs-6 wow fadeInUp mb-4" data-wow-delay="0.4s">
                <h3 class="text-center text-primary">প্রতিষ্ঠান প্রধানের বাণী</h3>
                <figure class="figure position-relative">
                    <img src="https://rzasc.com/uploads/images/staff/975fc2f6479d89d38604565673afa5b5.jpg" alt="প্রতিষ্ঠান প্রধান" class="img-fluid rounded shadow-sm">
                    <figcaption class="figcaption position-absolute bottom-0 start-0 w-100 text-white p-3 bg-dark bg-opacity-50">
                        খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে।
                        <a href="fullview.php?msg=3" class="text-warning text-decoration-none">More..</a>
                    </figcaption>
                </figure>
            </li>
            <!-- Portfolio Item 3 -->
            <li class="portfolio-item col-md-3 col-sm-4 col-xs-6 wow fadeInUp mb-4" data-wow-delay="0.6s">
                <h3 class="text-center text-primary">সহঃ প্রতিষ্ঠান প্রধান</h3>
                <figure class="figure position-relative">
                    <img src="https://rzasc.com/uploads/images/staff/20505a106d957f8bc277a9c1985c822a.jpg" alt="সহঃ প্রতিষ্ঠান প্রধান" class="img-fluid rounded shadow-sm">
                    <figcaption class="figcaption position-absolute bottom-0 start-0 w-100 text-white p-3 bg-dark bg-opacity-50">
                        খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে।
                        <a href="fullview.php?msg=3" class="text-warning text-decoration-none">More..</a>
                    </figcaption>
                </figure>
            </li>
            <!-- Portfolio Item 4 -->
            <li class="portfolio-item col-md-3 col-sm-4 col-xs-6 wow fadeInUp mb-4" data-wow-delay="0.8s">
                <h3 class="text-center text-primary">সহঃ প্রতিষ্ঠান প্রধান</h3>
                <figure class="figure position-relative">
                    <img src="https://rzasc.com/uploads/images/staff/20505a106d957f8bc277a9c1985c822a.jpg" alt="সহঃ প্রতিষ্ঠান প্রধান" class="img-fluid rounded shadow-sm">
                    <figcaption class="figcaption position-absolute bottom-0 start-0 w-100 text-white p-3 bg-dark bg-opacity-50">
                        খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে। খুব শীঘ্রই এই অংশটি আপডেট করা হবে।
                        <a href="fullview.php?msg=3" class="text-warning text-decoration-none">More..</a>
                    </figcaption>
                </figure>
            </li>
        </ul>
    </div>
</div>

<section class="container py-5">
    <h2 class="text-center text-primary border-bottom pb-3" style="margin-top:15px;">শিক্ষকমণ্ডলী</h2><hr>
    <div class="row">
        <!-- শিক্ষক ১ -->
        <div class="col-md-3 col-sm-6 mb-4  wow fadeInUp" data-wow-delay="0.2s">
            <div class="card shadow-sm">
                <img src="https://rzasc.com/uploads/frontend/home_page/featured-parallax116773259770225.jpeg" class="card-img-top" alt="শিক্ষক ১">
                <div class="card-body text-center">
                    <h5 class="card-title">জনাব মোঃ রহিম</h5>
                    <p class="card-text">গণিত শিক্ষক</p>
                    <a href="teacher_profile.php?id=1" class="btn btn-success">প্রোফাইল দেখুন</a>
                </div>
            </div>
        </div>
        <!-- শিক্ষক ২ -->
        <div class="col-md-3 col-sm-6 mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="card shadow-sm">
                <img src="https://rzasc.com/uploads/frontend/home_page/featured-parallax116773259770225.jpeg" class="card-img-top" alt="শিক্ষক ২">
                <div class="card-body text-center">
                    <h5 class="card-title">জনাবা রাশেদা পারভীন</h5>
                    <p class="card-text">ইংরেজি শিক্ষক</p>
                    <a href="teacher_profile.php?id=2" class="btn btn-success">প্রোফাইল দেখুন</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="card shadow-sm">
                <img src="https://rzasc.com/uploads/frontend/home_page/featured-parallax116773259770225.jpeg" class="card-img-top" alt="শিক্ষক ২">
                <div class="card-body text-center">
                    <h5 class="card-title">জনাবা রাশেদা পারভীন</h5>
                    <p class="card-text">ইংরেজি শিক্ষক</p>
                    <a href="teacher_profile.php?id=2" class="btn btn-success">প্রোফাইল দেখুন</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="card shadow-sm">
                <img src="https://rzasc.com/uploads/frontend/home_page/featured-parallax116773259770225.jpeg" class="card-img-top" alt="শিক্ষক ২">
                <div class="card-body text-center">
                    <h5 class="card-title">জনাবা রাশেদা পারভীন</h5>
                    <p class="card-text">ইংরেজি শিক্ষক</p>
                    <a href="teacher_profile.php?id=2" class="btn btn-success">প্রোফাইল দেখুন</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <h2 class="text-center text-primary pb-3 border-bottom" style="margin-top: 20px; font-size: 2.5rem; font-weight: bold;">গ্যালারি</h2>
    <hr class="mb-4">
    <div class="row g-4" style="padding: 15px;">
        <div class="col-md-4 col-sm-6 mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <a href="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSpt5zwCE8NvhXkgVxVORLHYkSyL5qg7NlkKF0Ra7RTEKwXJoy3FkSqNmiMfE8HJ8dGAEFh67BJR2cQeXTMgE6u2A" data-lightbox="gallery" data-title="Gallery Image 1">
                <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSpt5zwCE8NvhXkgVxVORLHYkSyL5qg7NlkKF0Ra7RTEKwXJoy3FkSqNmiMfE8HJ8dGAEFh67BJR2cQeXTMgE6u2A" alt="Gallery Image 1" class="img-fluid rounded shadow-sm hover-zoom">
            </a>
        </div>
        <div class="col-md-4 col-sm-6 mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <a href="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSpt5zwCE8NvhXkgVxVORLHYkSyL5qg7NlkKF0Ra7RTEKwXJoy3FkSqNmiMfE8HJ8dGAEFh67BJR2cQeXTMgE6u2A" data-lightbox="gallery" data-title="Gallery Image 2">
                <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSpt5zwCE8NvhXkgVxVORLHYkSyL5qg7NlkKF0Ra7RTEKwXJoy3FkSqNmiMfE8HJ8dGAEFh67BJR2cQeXTMgE6u2A" alt="Gallery Image 2" class="img-fluid rounded shadow-sm hover-zoom">
            </a>
        </div>
        <!-- Add more images as needed -->
    </div>
</section>

<style>
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.05);
    }
    /*.shadow-sm {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .rounded {
        border-radius: 10px;
    }*/
</style>



@endsection
