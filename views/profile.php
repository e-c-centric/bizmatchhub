<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if ($user_type == 3) {
        header('Location: ../admin/systemmgmt.php');
        exit();
    }
}

require_once 'common.php';

$freelancer_id = isset($_GET['freelancer_id']) ? $_GET['freelancer_id'] : null;

if (!$freelancer_id) {
    header('Location: hire.php');
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
    <!-- Bootstrap Icons -->
    <title>Freelancer Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <div id="profile-content">
                    <!-- Profile content will be injected here -->
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
                </ul>
                <ul class="d-flex align-items-center my-auto">
                    <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                    <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

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

            function escapeHtml(text) {
                if (typeof text !== 'string') {
                    return text;
                }
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Fetch freelancer_id from PHP variable
            const freelancerId = '<?php echo htmlspecialchars($freelancer_id); ?>';

            // Fetch and render freelancer data
            fetchFreelancerData(freelancerId);

            function fetchFreelancerData(freelancerId) {
                $.ajax({
                    url: '../actions/get_freelancer_by_id_action.php',
                    type: 'GET',
                    data: {
                        freelancer_id: freelancerId
                    },
                    dataType: 'json',
                    success: function(data) {
                        renderFreelancerProfile(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch freelancer data:', error);
                        // Redirect to browse categories page on error
                        window.location.href = 'people.php';
                    }
                });
            }

            function renderFreelancerProfile(freelancer) {
                if (!freelancer || !freelancer.freelancer_id) {
                    // Redirect if freelancer data is invalid
                    window.location.href = 'people.php';
                    return;
                }

                // Use profile_picture if available, else use a placeholder
                const profileImage = freelancer.profile_picture ? escapeHtml(freelancer.profile_picture) : 'https://via.placeholder.com/400x200.png?text=No+Image';

                // Extract categories and experience levels
                const categories = freelancer.categories && freelancer.categories.length > 0 ?
                    freelancer.categories.map(cat => `<span class="badge bg-secondary me-1">${escapeHtml(cat.category_name)} (${escapeHtml(cat.experience_level)})</span>`).join(' ') :
                    '<span class="badge bg-secondary">Uncategorized</span>';

                // Extract portfolios
                const portfolios = freelancer.portfolios && freelancer.portfolios.length > 0 ?
                    freelancer.portfolios.map(portfolio => `
                        <div class="portfolio-item mb-3">
                            <h5>${escapeHtml(portfolio.title)}</h5>
                            <p>${escapeHtml(portfolio.description)}</p>
                            <a href="${escapeHtml(portfolio.url)}" target="_blank">View Portfolio</a>
                        </div>
                    `).join('') :
                    '<p>No portfolios available.</p>';

                // Generate profile HTML
                const profileHtml = `
                    <div class="row profile-header">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <img src="${profileImage}" alt="${escapeHtml(freelancer.user_name)}" class="profile-image">
                        </div>
                        <div class="col-md-8">
                            <h3>${escapeHtml(freelancer.user_name)}</h3>
                            <p class="text-muted">${escapeHtml(freelancer.job_title)}</p>
                            <div class="d-flex flex-wrap align-items-center mb-3">
                                <span class="me-4"><i class="bi bi-star-fill text-warning"></i> ${escapeHtml(freelancer.total_rating)} (${escapeHtml(freelancer.num_ratings)} ratings)</span>
                                <span><i class="bi bi-people-fill text-info"></i> ${escapeHtml(freelancer.num_ratings)} Clients Served</span>
                            </div>
                            <div class="profile-actions">
                                <a href="chat.php?freelancer_id=${escapeHtml(freelancer.freelancer_id)}" class="btn btn-secondary">Chat</a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-details mt-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <p><strong>Introduction:</strong></p>
                                <p>${escapeHtml(freelancer.introduction)}</p>
                            </div>
                            <div class="col-lg-6">
                                <p><strong>Work Experience:</strong></p>
                                <p>${escapeHtml(freelancer.work_experience)} years</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Hourly Rate:</strong> $${escapeHtml(freelancer.hourly_rate)}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Available Work Hours:</strong> ${escapeHtml(freelancer.work_hours)}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <p><strong>Categories and Experience Levels:</strong></p>
                                ${categories}
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h4>Portfolios</h4>
                                ${portfolios}
                            </div>
                        </div>
                    </div>
                `;

                // Inject profile HTML into the page
                $('#profile-content').html(profileHtml);
            }
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>