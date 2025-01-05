<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SimpleEnglish.lk - wellcome</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0" style="width: 100%;justify-content: space-between;">
            <a href="/" class="navbar-brand">
                <h1 class="m-0 text-primary"><i class="fa fa-book-reader me-3"></i>SimpleEnglish.lk</h1>
            </a>
            
            <div>
                @if (session()->has('user_id'))
                    
                <a href="{{ route('dashboard')}}" style="display: block !important" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">dashboard<i class="fa fa-arrow-right ms-3"></i></a>

                @else
                    
                <a href="{{ route('login','student')}}" style="display: block !important" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
                @endif
            </div>
        </nav>
        <!-- Navbar End -->


        <!-- Carousel Start -->
        <div class="container-fluid p-0 mb-5">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    {{-- <h1 class="display-2 text-white animated slideInDown mb-4">The Best Kindergarten School For Your Child</h1>
                                    <p class="fs-5 fw-medium text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea elitr.</p> --}}
                                    {{-- <a href="" class="btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3 animated slideInLeft">Learn More</a>
                                    <a href="" class="btn btn-dark rounded-pill py-sm-3 px-sm-5 animated slideInRight">Our Classes</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    {{-- <h1 class="display-2 text-white animated slideInDown mb-4">Make A Brighter Future For Your Child</h1>
                                    <p class="fs-5 fw-medium text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea elitr.</p> --}}
                                    {{-- <a href="" class="btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3 animated slideInLeft">Learn More</a>
                                    <a href="" class="btn btn-dark rounded-pill py-sm-3 px-sm-5 animated slideInRight">Our Classes</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <div>
            <iframe src="https://www.youtube.com/embed/Ucdbz0XWzT8?autoplay=1&loop=1&playlist=Ucdbz0XWzT8" frameborder="0" width="100%" height="500"></iframe>
        </div>
        

        


        <!-- Facilities Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Class Facilities</h1>
                    <p>Below are all the Class Facilities provided annually. Join today and elevate your English learning experience to new heights!</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="facility-item">
                            <div class="facility-icon bg-primary">
                                <span class="bg-primary"></span>
                                <i class="fa fa-bus-alt fa-3x text-primary"></i>
                                <span class="bg-primary"></span>
                            </div>
                            <div class="facility-text bg-primary">
                                <h3 class="text-primary mb-3">Videos</h3>
                                <p class="mb-0">Lifetime recordings are offered after every online class, allowing students to review lessons anytime at their own pace.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="facility-item">
                            <div class="facility-icon bg-success">
                                <span class="bg-success"></span>
                                <i class="fa fa-futbol fa-3x text-success"></i>
                                <span class="bg-success"></span>
                            </div>
                            <div class="facility-text bg-success">
                                <h3 class="text-success mb-3">Tutes</h3>
                                <p class="mb-0">Monthly tutorials are provided for free. These include all planned lessons to ensure a structured and effective learning process.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="facility-item">
                            <div class="facility-icon bg-warning">
                                <span class="bg-warning"></span>
                                <i class="fa fa-home fa-3x text-warning"></i>
                                <span class="bg-warning"></span>
                            </div>
                            <div class="facility-text bg-warning">
                                <h3 class="text-warning mb-3">Tests</h3>
                                <p class="mb-0">Online quizzes are conducted regularly in the system, and students are graded automatically to track their performance.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="facility-item">
                            <div class="facility-icon bg-info">
                                <span class="bg-info"></span>
                                <i class="fa fa-chalkboard-teacher fa-3x text-info"></i>
                                <span class="bg-info"></span>
                            </div>
                            <div class="facility-text bg-info">
                                <h3 class="text-info mb-3">Other</h3>
                                <p class="mb-0">The classes are conducted using amazing, high-quality technology, ensuring an engaging and seamless learning experience.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facilities End -->


        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="mb-4">earn More About Our Work And Our Cultural Activities</h1>
                        <p>At our Online English Class, we are dedicated to creating a learning environment that goes beyond traditional teaching methods. Our mission is to empower students with language skills that open doors to new opportunities, both personally and professionally.</p>
                        <p class="mb-4"><strong>Our Work</strong><br>
                            We focus on a well-rounded approach to English learning. From live interactive classes to lifetime recordings, we ensure that every student has access to quality resources tailored to their needs. Our monthly tutorials and online quizzes are designed to reinforce lessons and track progress effectively.</p>
                        
                        <p>In addition to regular classes, we offer monthly model paper and past paper discussions, where students can practice and refine their skills by working through real exam-style questions. This not only prepares students for academic assessments but also builds their confidence in using English in practical and professional contexts.    </p>
                            <div class="row g-4 align-items-center">
                            
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle flex-shrink-0" src="img/user.png" alt="" style="width: 45px; height: 45px;">
                                    <div class="ms-3">
                                        <h6 class="text-primary mb-1">Asela S. Rathnayaka</h6>
                                        <small>CEO & Founder</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 about-img wow fadeInUp" data-wow-delay="0.5s">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img class="img-fluid w-75 rounded-circle bg-light p-3" src="img/about-1.jpg" alt="">
                            </div>
                            <div class="col-6 text-start" style="margin-top: -150px;">
                                <img class="img-fluid w-100 rounded-circle bg-light p-3" src="img/about-2.jpg" alt="">
                            </div>
                            <div class="col-6 text-end" style="margin-top: -150px;">
                                <img class="img-fluid w-100 rounded-circle bg-light p-3" src="img/about-3.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Call To Action Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded">
                    <div class="row g-0">
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                            <div class="position-relative h-100">
                                <img class=" w-100 h-100 rounded" src="img/1.jpg" style="object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="h-100 d-flex flex-column justify-content-center p-5">
                                <h1 class="mb-4">About  Asela S. Rathnayaka</h1>
                                <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos.
                                    Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet
                                </p>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call To Action End -->


        <!-- Classes Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Online Classes</h1>
                    <p>Our Online English Classes are designed to provide an amazing and enriching learning experience for all students. With a focus on excellence, we ensure that every class is engaging, interactive, and tailored to meet the needs of modern learners.</p>
                </div>
                <div class="row g-4">
                    @php
                        $classes = \App\Models\Classes::where('class_type', 1)->get();
                        $status = ['', 'On Going', 'Completed', 'Upcoming'];
                    @endphp
                
                    @foreach ($classes as $class)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="classes-item">
                            <div class="bg-light rounded-circle w-75 mx-auto p-3">
                                <img class="img-fluid rounded-circle" src="img/classes-1.jpg" alt="Class Image">
                            </div>
                            <div class="bg-light rounded p-4 pt-5 mt-n5">
                                <a class="d-block text-center h3 mt-3 mb-4" href="#">{{ $class->name }}</a>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle flex-shrink-0" src="img/user.png" alt="Teacher Image" style="width: 45px; height: 45px;">
                                        <div class="ms-3">
                                            <h6 class="text-primary mb-1">Asela S. Rathnayaka</h6>
                                            <small>Teacher</small>
                                        </div>
                                    </div>
                                    <span class="bg-primary text-white rounded-pill py-2 px-3">{{ $status[$class->status] }}</span>
                                </div>
                                <div class="row g-1">
                                    {{-- <div class="col-4">
                                        <div class="border-top border-3 border-primary pt-2">
                                            <h6 class="text-primary mb-1">Grade:</h6>
                                            <small>{{ $class->grade }}</small>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-4">
                                        <div class="border-top border-3 border-success pt-2">
                                            <h6 class="text-success mb-1">Time:</h6>
                                            <small>{{ date("H:i", strtotime($class->class_start_date)) }}</small>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>

        <!-- Classes Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Physical Classes</h1>
                    <p>Our English Physical Classes are conducted at the prestigious Simple English Academy, providing students with a dynamic, immersive, and engaging learning environment.</p>
                </div>
                <div class="row g-4">
                    @php
                        $classes = \App\Models\Classes::where('class_type', 2)->get();
                        $status = ['', 'On Going', 'Completed', 'Upcoming'];
                    @endphp
                
                    @foreach ($classes as $class)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="classes-item">
                            <div class="bg-light rounded-circle w-75 mx-auto p-3">
                                <img class="img-fluid rounded-circle" src="img/classes-1.jpg" alt="Class Image">
                            </div>
                            <div class="bg-light rounded p-4 pt-5 mt-n5">
                                <a class="d-block text-center h3 mt-3 mb-4" href="#">{{ $class->name }}</a>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle flex-shrink-0" src="img/user.png" alt="Teacher Image" style="width: 45px; height: 45px;">
                                        <div class="ms-3">
                                            <h6 class="text-primary mb-1">Asela S. Rathnayaka</h6>
                                            <small>Teacher</small>
                                        </div>
                                    </div>
                                    <span class="bg-primary text-white rounded-pill py-2 px-3">{{ $status[$class->status] }}</span>
                                </div>
                                <div class="row g-1">
                                    {{-- <div class="col-4">
                                        <div class="border-top border-3 border-primary pt-2">
                                            <h6 class="text-primary mb-1">Grade:</h6>
                                            <small>{{ $class->grade }}</small>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-4">
                                        <div class="border-top border-3 border-success pt-2">
                                            <h6 class="text-success mb-1">Time:</h6>
                                            <small>{{ date("H:i", strtotime($class->class_start_date)) }}</small>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Classes End -->


      
        <div>
            <div class="row g-4">
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <img style="width: 100%" src="img/1.jpeg" alt="">
                </div><div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <img style="width: 100%" src="img/2.jpeg" alt="">
                </div><div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <img style="width: 100%" src="img/3.jpeg" alt="">
                </div>
            </div> 
        </div>

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-6 col-md-6">
                        <h3 class="text-white mb-4">Get In Touch</h3>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Galgamuwa</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+94718578372</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>asela20@gmail.com</p>
                        <div class="d-flex pt-2">
                            {{-- <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a> --}}
                            <a class="btn btn-outline-light btn-social" href="https://web.facebook.com/profile.php?viewas=100000686899395&id=100034507491570"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/@aselasrathnayaka"><i class="fab fa-youtube"></i></a>
                            {{-- <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a> --}}
                        </div>
                        <p class="mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia amet doloremque quisquam excepturi nihil, et possimus atque nulla eveniet laudantium reprehenderit similique dicta molestias esse maiores tenetur maxime veritatis ratione.</p>
                    </div>
                    {{-- <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Quick Links</h3>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div> --}}
                    <div class="col-lg-6 col-md-6">
                        <h3 class="text-white mb-4">Photo Gallery</h3>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/classes-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/classes-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/classes-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/classes-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/classes-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/classes-6.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Newsletter</h3>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    
                    </div> --}}
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="/">SimpleEnglish.lk</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							{{-- Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> --}}
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="/">Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>