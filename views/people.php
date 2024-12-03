<?php
// filepath: /c:/xampp/htdocs/bizmatchhub/views/people.php
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

$menuItems = [
    [
        'label' => 'BizMatch Hub Business',
        'link' => 'business.php',
        'visible' => true, // Always visible
    ],
    [
        'label' => 'Browse Categories',
        'link' => 'hire.php',
        'visible' => true,
    ],
    // [
    //     'label' => 'Explore',
    //     'link' => 'explore.php',
    //     'visible' => true,
    // ],
    // [
    //     'label' => 'Languages',
    //     'subItems' => [
    //         [
    //             'label' => 'English',
    //             'link' => '#', // You can link to a language switch handler
    //         ],
    //         [
    //             'label' => 'French',
    //             'link' => '#', // You can link to a language switch handler
    //         ],
    //     ],
    //     'visible' => true,
    // ],
    [
        'label' => 'Currency',
        'subItems' => [
            [
                'label' => 'GHS',
                'link' => '#',
            ],
            // Add more currencies if needed
        ],
        'visible' => true,
    ],
];

function renderMenu($menuItems, $isMobile = false)
{
    foreach ($menuItems as $item) {
        if (!$item['visible']) {
            continue; // Skip items that shouldn't be visible
        }

        // Check if the item has sub-items (dropdown)
        if (isset($item['subItems']) && is_array($item['subItems'])) {
            // Dropdown menu
            echo '<li class="nav-item dropdown col-auto">';
            echo '<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">';
            echo htmlspecialchars($item['label']);
            echo '</a>';
            echo '<ul class="dropdown-menu">';

            foreach ($item['subItems'] as $subItem) {
                echo '<li><a class="dropdown-item" href="' . htmlspecialchars($subItem['link']) . '">';
                echo htmlspecialchars($subItem['label']);
                echo '</a></li>';
            }

            echo '</ul>';
            echo '</li>';
        } else {
            // Single link
            echo '<li class="nav-item col-auto">';
            echo '<a class="nav-link" href="' . htmlspecialchars($item['link']) . '">';
            echo htmlspecialchars($item['label']);
            echo '</a>';
            echo '</li>';
        }
    }
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
    <title>Freelancers - BizMatch Hub</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        /* Freelancer Card Styles */
        .freelancer-card img {
            width: 100%;
            height: 200px;
            /* Fixed height */
            object-fit: cover;
            /* Maintain aspect ratio */
            border-radius: 0.25rem;
        }

        /* Search Bar */
        .search-bar {
            max-width: 500px;
            margin: 20px auto;
        }

        /* No Results */
        .no-results,
        .no-freelancers {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: gray;
            font-size: 1.2rem;
        }

        /* Navbar Styles */
        #top-nav {
            background-color: rgba(0, 0, 0, 0.8);
            /* Semi-transparent dark background */
            transition: background-color 0.3s;
        }

        #top-nav.scrolled {
            background-color: rgba(0, 0, 0, 1);
            /* Fully opaque on scroll */
        }

        .nav-link {
            color: #ffffff !important;
            /* Ensure nav links are white */
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
        <!-- Freelancers Section -->
        <section class="freelancers py-5 px-3 px-sm-4 px-md-5" id="freelancers-section">
            <div class="container">
                <h2 class="mb-4">Freelancers</h2>
                <div class="row" id="freelancers-container">
                    <!-- Freelancer cards will be injected here by JavaScript -->
                </div>
                <div class="no-freelancers">No freelancers found.</div>
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

        // Function to get URL parameters
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Fetch category from URL
        const categoryId = getUrlParameter('category');

        // Fetch and render freelancers based on category
        fetchAndRenderFreelancers(categoryId);

        // Function to fetch freelancers from the server
        function fetchAndRenderFreelancers(categoryId) {
            $.ajax({
                url: '../actions/get_freelancers.php',
                type: 'GET',
                data: { category: categoryId },
                dataType: 'json',
                success: function(data) {
                    renderFreelancers(data);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch freelancers:', error);
                    $('#freelancers-container').empty().append('<p class="text-danger">Failed to load freelancers. Please try again later.</p>');
                }
            });
        }

        // Function to render freelancers
        function renderFreelancers(freelancersData) {
            const container = $('#freelancers-container');
            container.empty(); // Clear existing freelancers

            if (freelancersData.length === 0) {
                $('.no-freelancers').show();
                return;
            } else {
                $('.no-freelancers').hide();
            }

            freelancersData.forEach(freelancer => {
                // Map 'num_ratings' to 'numberOfClients'
                const numberOfClients = escapeHtml(freelancer.num_ratings);

                // Use profile_picture if available, else use a placeholder
                const profileImage = freelancer.profile_picture ? escapeHtml(freelancer.profile_picture) : 'https://via.placeholder.com/400x200.png?text=No+Image';

                // Extract category names
                const categoryNames = freelancer.categories && freelancer.categories.length > 0
                    ? freelancer.categories.map(cat => escapeHtml(cat.category_name)).join(', ')
                    : 'Uncategorized';

                const freelancerCard = `
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card freelancer-card h-100">
                            <img src="${profileImage}" class="card-img-top" alt="${escapeHtml(freelancer.name)}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${escapeHtml(freelancer.name)}</h5>
                                <p class="card-text mb-1"><strong>Job Title:</strong> ${escapeHtml(freelancer.job_title)}</p>
                                <p class="card-text mb-1"><strong>Rating:</strong> ${escapeHtml(freelancer.total_rating)} ⭐</p>
                                <p class="card-text mb-2"><strong>Clients Served:</strong> ${numberOfClients}</p>
                                <p class="card-text mb-3"><strong>Categories:</strong> ${categoryNames}</p>
                                <div class="mt-auto">
                                    <a href="profile.php?freelancer_id=${escapeHtml(freelancer.freelancer_id)}" class="btn btn-primary me-2">View Profile</a>
                                    <a href="chat.php?freelancer_id=${escapeHtml(freelancer.freelancer_id)}" class="btn btn-secondary">Chat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.append(freelancerCard);
            });
        }
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>