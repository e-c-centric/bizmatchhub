<?php
// filepath: /c:/xampp/htdocs/bizmatchhub/views/profile.php
session_start();

// Redirect admin users if necessary
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if ($user_type == 3) {
        header('Location: ../admin/systemmgmt.php');
        exit();
    }
}

// Include common functions and menu items
require_once 'common.php';

// Sample Freelancers Data (In a real application, fetch this from a database)
$freelancersData = [
    "101" => [
        "name" => "Alice Johnson",
        "job_title" => "Senior Web Developer",
        "work_experience" => "5 years in full-stack web development specializing in PHP and JavaScript.",
        "introduction" => "Passionate about building responsive and user-friendly websites.",
        "total_rating" => 4.5,
        "num_ratings" => 120,
        "num_clients" => 80,
        "hourly_rate" => "$50",
        "work_hours" => "Flexible",
        "profileLink" => "profile.php?freelancer_id=101",
        "image" => "https://via.placeholder.com/400x200.png?text=Alice+Johnson"
    ],
    "102" => [
        "name" => "Bob Smith",
        "job_title" => "UI/UX Designer",
        "work_experience" => "7 years in designing intuitive user interfaces and experiences.",
        "introduction" => "Dedicated to creating visually appealing and functional designs.",
        "total_rating" => 4.8,
        "num_ratings" => 200,
        "num_clients" => 150,
        "hourly_rate" => "$75",
        "work_hours" => "Full-time",
        "profileLink" => "profile.php?freelancer_id=102",
        "image" => "https://via.placeholder.com/400x200.png?text=Bob+Smith"
    ],
    "201" => [
        "name" => "Charlie Davis",
        "job_title" => "Content Writer",
        "work_experience" => "4 years of experience in creating engaging content for various industries.",
        "introduction" => "Skilled in crafting compelling stories and SEO-friendly articles.",
        "total_rating" => 4.6,
        "num_ratings" => 85,
        "num_clients" => 60,
        "hourly_rate" => "$60",
        "work_hours" => "Part-time",
        "profileLink" => "profile.php?freelancer_id=201",
        "image" => "https://via.placeholder.com/400x200.png?text=Charlie+Davis"
    ],
    "202" => [
        "name" => "Dana Lee",
        "job_title" => "Digital Marketer",
        "work_experience" => "6 years in developing and implementing digital marketing strategies.",
        "introduction" => "Expert in SEO, PPC, and social media marketing to drive business growth.",
        "total_rating" => 4.7,
        "num_ratings" => 95,
        "num_clients" => 70,
        "hourly_rate" => "$55",
        "work_hours" => "Flexible",
        "profileLink" => "profile.php?freelancer_id=202",
        "image" => "https://via.placeholder.com/400x200.png?text=Dana+Lee"
    ]
    // Add more freelancers as needed
];

// Retrieve freelancer_id from URL parameter
$freelancer_id = isset($_GET['freelancer_id']) ? $_GET['freelancer_id'] : null;

// Fetch freelancer data
$freelancer = isset($freelancersData[$freelancer_id]) ? $freelancersData[$freelancer_id] : null;

// If freelancer not found, redirect or show error
if (!$freelancer) {
    echo "<script>alert('Freelancer not found.'); window.location.href='people.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title><?php echo htmlspecialchars($freelancer['name']); ?> - Profile | BizMatch Hub</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        /* Freelancer Profile Styles */
        .profile-header {
            margin-bottom: 40px;
        }

        .profile-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0.25rem;
            border: 1px solid #ddd;
        }

        .profile-details h3 {
            margin-top: 20px;
            font-weight: 700;
        }

        .profile-details p {
            margin-bottom: 10px;
        }

        .profile-actions .btn {
            margin-right: 10px;
        }

        /* Navbar Styles */
        #top-nav {
            background-color: rgba(0, 0, 0, 0.8);
            transition: background-color 0.3s;
        }

        #top-nav.scrolled {
            background-color: rgba(0, 0, 0, 1);
        }

        .nav-link {
            color: #ffffff !important;
        }

        /* Mobile Sidebar Styles */
        #sidebar {
            width: 250px;
            margin-left: -250px;
            transition: margin-left 0.3s;
        }

        #sidebar.active {
            margin-left: 0;
        }

        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            display: none;
        }

        .mobile-nav-overlay.active {
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <!-- Top navbar -->
        <nav class="p-0 fixed-top text-white" id="top-nav">
            <div class="top-nav row mx-auto my-auto pt-3 pb-3 w-100 container-fluid text-white">
                <div class="toggle-btn col-auto text-white text-start p-0 d-md-none" style="cursor: pointer;" id="nav-toggler">
                    <span class="bi bi-list fs-2 text-start ms-0 me-auto"></span>
                </div>
                <a href="index.php" class="nav-logo col-sm col-8 mx-auto mx-sm-0 text-sm-start text-center my-auto">
                    <div style="width: fit-content;" class="mx-auto mx-sm-0">
                        <img class="nav-logo-white d-block" src="../assets/svg/logo.png" alt="BizMatch Hub">
                        <img class="nav-logo-black d-none" src="../assets/svg/logo.png" alt="BizMatch Hub">
                    </div>
                </a>
                <ul class="d-none d-md-flex text-white col-auto row fw-semibold my-auto">
                    <?php
                    // Render the general menu items
                    renderMenu($menuItems);

                    // Check user authentication status for additional menu items
                    if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown col-auto">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Get Started</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../login/register.php">Register</a></li>
                                <li><a class="dropdown-item" href="../login/login.php">Login</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item col-auto">
                            <a href="payment.php" class="nav-link">Payments</a>
                        </li>
                        <li class="nav-item col-auto">
                            <a href="../login/logout.php" class="nav-link">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <!-- Mobile sidebar -->
        <nav class="mobile-nav text-nowrap" id="mobile-nav">
            <div class="fixed-top text-muted bg-white vh-100 px-3 pt-3" id="sidebar">
                <ul class="fw-normal d-flex flex-column mx-auto">
                    <?php
                    // Render the general menu items
                    renderMenu($menuItems, true);

                    // Authentication-related menu items
                    if (!isset($_SESSION['user_id'])): ?>
                        <li class="join-btn col-auto mt-2 mb-3 fs-6 px-3 w-80 py-2 fw-semibold text-white border rounded-2" style="background-color: var(--primary--color-p);">
                            Join BizMatch Hub
                        </li>
                        <li class="col-auto my-2 fs-6"><a href="../login/signin.php">Sign in</a></li>
                    <?php else: ?>
                        <li class="col-auto my-2 fs-6"><a href="../login/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
                <p class="fw-semibold text-black mt-4">General</p>
                <hr>
                <ul class="fw-normal d-flex flex-column mx-auto">
                    <?php
                    // Replicate authentication menu items if needed
                    if (!isset($_SESSION['user_id'])): ?>
                        <li class="col-auto my-2 fs-6"><a href="../login/signin.php">Sign in</a></li>
                    <?php else: ?>
                        <li class="col-auto my-2 fs-6"><a href="../login/logout.php">Logout</a></li>
                    <?php endif; ?>
                    <!-- Additional consistent menu items can go here -->
                </ul>
            </div>
            <div class="mobile-nav-overlay d-none"></div>
        </nav>
    </header>

    <main class="mt-5 pt-5">
        <!-- Freelancer Profile Section -->
        <section class="freelancer-profile py-5 px-3 px-sm-4 px-md-5">
            <div class="container">
                <div class="row profile-header">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <img src="<?php echo htmlspecialchars($freelancer['image']); ?>" alt="<?php echo htmlspecialchars($freelancer['name']); ?>" class="profile-image">
                    </div>
                    <div class="col-md-8">
                        <h3><?php echo htmlspecialchars($freelancer['name']); ?></h3>
                        <p class="text-muted"><?php echo htmlspecialchars($freelancer['job_title']); ?></p>
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <span class="me-4"><i class="bi bi-star-fill text-warning"></i> <?php echo htmlspecialchars($freelancer['total_rating']); ?> (<?php echo htmlspecialchars($freelancer['num_ratings']); ?> ratings)</span>
                            <span><i class="bi bi-people-fill text-info"></i> <?php echo htmlspecialchars($freelancer['num_clients']); ?> Clients Served</span>
                        </div>
                        <div class="profile-actions">
                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#chatModal">Chat</a>
                        </div>
                    </div>
                </div>
                <div class="profile-details mt-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <p><strong>Introduction:</strong></p>
                            <p><?php echo htmlspecialchars($freelancer['introduction']); ?></p>
                        </div>
                        <div class="col-lg-6">
                            <p><strong>Work Experience:</strong></p>
                            <p><?php echo htmlspecialchars($freelancer['work_experience']); ?></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Hourly Rate:</strong> <?php echo htmlspecialchars($freelancer['hourly_rate']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Available Work Hours:</strong> <?php echo htmlspecialchars($freelancer['work_hours']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer pt-5 pb-3 px-3 px-sm-4 px-md-5 border-top border-1 border-opacity-10 text-muted">
        <div class="footer-links d-flex flex-wrap justify-content-lg-between" style="column-gap: 15px;">
            <div class="mb-4 links-categories" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">Categories</p>
                <ul>
                    <li><a href="#">Graphics & Design</a></li>
                    <li><a href="#">Digital Marketing</a></li>
                    <li><a href="#">Writing & Translation</a></li>
                    <li><a href="#">Video & Animation</a></li>
                    <li><a href="#">Music & Audio</a></li>
                    <li><a href="#">Programming & Tech</a></li>
                </ul>
            </div>
            <div class="mb-4 links-about" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">About</p>
                <ul>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press & News</a></li>
                    <li><a href="#">Partnerships</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="mb-4 links-support" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">Support</p>
                <ul>
                    <li><a href="#">Help & Support</a></li>
                    <li><a href="#">Trust & Safety</a></li>
                    <li><a href="#">Selling on BizMatch Hub</a></li>
                    <li><a href="#">Buying on BizMatch Hub</a></li>
                </ul>
            </div>
            <div class="mb-4 links-community" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">Community</p>
                <ul>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Forum</a></li>
                    <li><a href="#">Community Standards</a></li>
                    <li><a href="#">Podcast</a></li>
                </ul>
            </div>
            <div class="mb-4 links-more" style="min-width: 160px;">
                <p class="text-black fw-semibold fs-6">More From BizMatch Hub</p>
                <ul>
                    <li><a href="#">BizMatch Hub Business</a></li>
                    <li><a href="#">BizMatch Hub Pro</a></li>
                    <li><a href="#">BizMatch Hub Studios</a></li>
                    <li><a href="#">BizMatch Hub Guides</a></li>
                    <li><a href="#">Get Inspired</a></li>
                    <li><a href="#">BizMatch Hub Select</a></li>
                </ul>
            </div>
        </div>
        <div
            class="footer-rights-wrapper py-3 my-auto border-top border-1 border-opacity-10 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between align-items-center">
            <div class="footer-rights d-flex flex-column flex-md-row justify-content-center align-items-center"
                style="gap: 18px;">
                <img src="../assets/svg/logo.png" alt="BizMatch Hub">
                <div class="text-center align-middle my-auto">© BizMatch Hub</div>
            </div>
            <div class="footer-social d-flex flex-column flex-md-row justify-content-center align-items-center"
                style="column-gap: 15px;">
                <ul class="d-flex align-items-center my-auto" style="gap: 10px;">
                    <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                    <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                    <li><a href="#"><i class="bi bi-linkedin"></i></a></li>
                    <!-- Add more social icons as needed -->
                </ul>
                <ul class="d-flex align-items-center my-auto">
                    <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                    <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                    <!-- Add more social icons as needed -->
                </ul>
            </div>
        </div>
    </footer>

    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatModalLabel">Chat with <?php echo htmlspecialchars($freelancer['name']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="chatBox" style="height: 400px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px;">
                        <!-- Chat messages will appear here -->
                    </div>
                    <form id="chatForm" class="mt-3">
                        <div class="input-group">
                            <input type="text" id="chatMessage" class="form-control" placeholder="Type your message..." required>
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Toggle mobile sidebar
            $('#nav-toggler').click(function() {
                $('#sidebar').addClass('active');
                $('.mobile-nav-overlay').addClass('active');
            });

            $('.mobile-nav-overlay').click(function() {
                $('#sidebar').removeClass('active');
                $(this).removeClass('active');
            });

            // Change navbar background on scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('#top-nav').addClass('scrolled');
                } else {
                    $('#top-nav').removeClass('scrolled');
                }
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>