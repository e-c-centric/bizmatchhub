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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <title>Freelancer Profile</title>

    <style>
        /* Freelancer Profile Styles */
        .profile-header {
            margin-bottom: 40px;
        }

        /* Justify Text */
        .text-justify {
            text-align: justify;
        }

        /* Button Styling */
        .d-flex.justify-content-between .btn {
            flex: 1;
            margin: 0 5px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {

            .profile-header .col-md-4,
            .profile-header .col-md-8 {
                text-align: center;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
            }

            .d-flex.justify-content-between .btn {
                margin: 5px 0;
                width: 100%;
            }
        }

        .profile-details p {
            margin-bottom: 10px;
        }

        /* Notification Count Styling */
        #notificationCount {
            font-size: 0.75em;
            /* Adjusts the size of the badge text */
            /* Position the badge at the top-right corner of the bell icon */
            top: 0;
            right: 0;
            transform: translate(25%, -25%);
        }

        /* Ensure the bell icon container is relative */
        .nav-item.dropdown a.nav-link {
            position: relative;
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

        @media (max-width: 768px) {
            #notificationCount {
                transform: translate(35%, -35%);
            }
        }

        /* Removed Unused Classes */
        /* .profile-details h3 {
    // Removed: .profile-details h3 is not used
} */

        /* .profile-actions .btn {
    // Removed: .profile-actions .btn is not used
} */

        /* .badge-danger {
    // Removed: .badge-danger is not used
} */

        /* .profile-image {
    // Removed: .profile-image is not used
} */
    </style>
</head>

<body>
    <header>
        <!-- Top navbar -->
        <!-- filepath: /c:/xampp/htdocs/bizmatchhub/freelancer/profile.php -->
        <nav class="p-0 fixed-top text-white" id="top-nav">
            <div class="top-nav container-fluid py-3 d-flex justify-content-between align-items-center">
                <!-- Left Side: Toggle Button and Logo -->
                <div class="d-flex align-items-center">
                    <!-- Toggle Button for Mobile Sidebar -->
                    <button class="btn btn-link d-md-none me-3 p-0" id="nav-toggler" style="color: #ffffff; text-decoration: none;">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                    <!-- Logo -->
                    <a href="index.php" class="nav-logo d-flex align-items-center">
                        <img class="nav-logo-white d-block me-2" src="../assets/svg/logo.png" alt="BizMatch Hub" style="height: 40px;">
                        <img class="nav-logo-black d-none" src="../assets/svg/logo.png" alt="BizMatch Hub" style="height: 40px;">
                    </a>
                </div>

                <!-- Right Side: Menu Items -->
                <ul class="nav d-flex align-items-center mb-0">
                    <?php
                    // Render the general menu items
                    renderMenu($menuItems);

                    // Check user authentication status for additional menu items
                    if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Get Started</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../login/register.php">Register</a></li>
                                <li><a class="dropdown-item" href="../login/login.php">Login</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Notification Box -->
                        <li class="nav-item me-3">
                            <a class="nav-link" href="chat.php" id="notificationsLink" role="button" aria-label="Notifications" style="color: #ffffff;">
                                <i id="notificationIcon" class="bi bi-bell fs-4"></i>
                            </a>
                        </li>
                        <!-- Logout Button -->
                        <li class="nav-item">
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
                <div class="row profile-header" id="freelancerProfile">
                    <!-- Freelancer data will be loaded here via AJAX -->
                </div>
                <div class="profile-details mt-4" id="freelancerDetails" style="column-gap: 15px; text-align: justify;">
                    <!-- Freelancer details will be loaded here via AJAX -->
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


        <!-- Add Portfolio Modal -->
        <div class="modal fade" id="addPortfolioModal" tabindex="-1" aria-labelledby="addPortfolioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Portfolio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Add Portfolio Form -->
                        <form id="addPortfolioForm">
                            <div class="mb-3">
                                <label for="portfolioTitle" class="form-label">Portfolio Title</label>
                                <input type="text" class="form-control" id="portfolioTitle" name="portfolioTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="portfolioDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="portfolioDescription" name="portfolioDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="portfolioURL" class="form-label">URL</label>
                                <input type="url" class="form-control" id="portfolioURL" name="portfolioURL" placeholder="https://example.com" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Portfolio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update Categories Modal -->
        <div class="modal fade" id="updateCategoriesModal" tabindex="-1" aria-labelledby="updateCategoriesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Your Categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Update Categories Form -->
                        <form id="updateCategoriesForm">
                            <div class="mb-3">
                                <label for="categories" class="form-label">Select Categories and Set Experience Level</label>
                                <div id="categoriesContainer">
                                    <!-- Categories with Experience Level will be populated dynamically -->
                                    <div class="text-center">Loading categories...</div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning">Update Categories</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update Profile Modal -->
        <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Update Profile Form -->
                        <form id="updateProfileForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="${freelancer.name}" required>
                            </div>
                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" value="${freelancer.job_title}" required>
                            </div>
                            <!-- Add more fields as necessary -->
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
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



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <!-- Include jQuery before your custom script -->
    <script>
        $(document).ready(function() {

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

            $.ajax({
                url: '../actions/get_all_freelancers_action.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.freelancer_id) {
                        const freelancer = data;

                        // Extract categories and portfolios from the freelancer object
                        const categories = freelancer.categories.map(cat => ({
                            id: cat.category_id,
                            name: cat.category_name,
                            experience: cat.experience_level
                        }));

                        const portfolios = freelancer.portfolios.map(portfolio => ({
                            id: portfolio.portfolio_id,
                            title: portfolio.title,
                            description: portfolio.description,
                            url: portfolio.url
                        }));

                        // Populate profile header with enhanced layout
                        const profileHeader = `
                        <div class="row">
                            <!-- Left Column: Profile Image and Buttons -->
                            <div class="col-md-4 text-center">
                                <img src="${freelancer.profile_picture ? freelancer.profile_picture : 'https://www.w3schools.com/howto/img_avatar.png'}" alt="${freelancer.user_name}" class="img-fluid rounded mb-3">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortfolioModal">Add Portfolio</button>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateCategoriesModal">Update Categories</button>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Update Profile</button>
                                </div>
                            </div>
                            <!-- Right Column: Profile Information -->
                            <div class="col-md-8 text-justify">
                                <h3>${freelancer.user_name}</h3>
                                <p class="text-muted">${freelancer.job_title}</p>
                                <div class="d-flex flex-wrap align-items-center mb-3">
                                    <span class="me-4"><i class="bi bi-star-fill text-warning"></i> ${freelancer.total_rating} (${freelancer.num_ratings} ratings)</span>
                                    <span><i class="bi bi-people-fill text-info"></i> ${freelancer.num_ratings} Clients Served</span>
                                </div>
                                <!-- Categories Section -->
                                <div class="mb-3">
                                    <strong>Categories:</strong>
                                    <div>
                                        ${categories.map(cat => `
                                            <span class="badge rounded-pill ${getBadgeClass(cat.experience)} me-2 mb-2">
                                                ${cat.name} (${capitalizeFirstLetter(cat.experience)})
                                            </span>
                                        `).join('')}
                                    </div>
                                </div>
                                <!-- Portfolios Section -->
                                <div class="mb-3">
                                    <strong>Portfolios:</strong>
                                    <div class="row">
                                        ${portfolios.length > 0 ? portfolios.map(portfolio => `
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">${portfolio.title}</h5>
                                                        <p class="card-text">${portfolio.description}</p>
                                                        ${portfolio.url ? `<a href="${portfolio.url}" target="_blank" class="btn btn-primary">View Portfolio</a>` : ''}
                                                    </div>
                                                </div>
                                            </div>
                                        `).join('') : '<p>No portfolios available.</p>'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        $('#freelancerProfile').html(profileHeader);

                        // Populate profile details
                        const profileDetails = `
                <div class="row">
                    <div class="col-lg-6">
                        <p><strong>Introduction:</strong></p>
                        <p>${freelancer.introduction}</p>
                    </div>
                    <div class="col-lg-6">
                        <p><strong>Work Experience:</strong></p>
                        <p>${freelancer.work_experience} years</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Hourly Rate:</strong> $${freelancer.hourly_rate}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Available Work Hours:</strong> ${freelancer.work_hours}</p>
                    </div>
                </div>
            `;
                        $('#freelancerDetails').html(profileDetails);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Freelancer Not Found',
                            text: 'The freelancer you are looking for does not exist.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '../views/';
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an issue fetching the freelancer data. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            /**
             * Helper function to get badge class based on experience level
             * @param {string} level
             * @returns {string}
             */
            function getBadgeClass(level) {
                switch (level) {
                    case 'beginner':
                        return 'bg-primary';
                    case 'intermediate':
                        return 'bg-warning text-dark';
                    case 'expert':
                        return 'bg-success';
                    default:
                        return 'bg-secondary';
                }
            }

            /**
             * Helper function to capitalize the first letter of a string
             * @param {string} string
             * @returns {string}
             */
            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            function updateNotificationIcon(hasNotifications) {
                const notificationIcon = $('#notificationIcon');

                if (hasNotifications) {
                    // Change to filled red bell icon
                    notificationIcon.removeClass('bi-bell').addClass('bi-bell-fill text-danger');
                } else {
                    // Revert to outlined transparent bell icon
                    notificationIcon.removeClass('bi-bell-fill text-danger').addClass('bi-bell');
                }
            }

            function fetchNotificationStatus() {
                $.ajax({
                    url: '../actions/get_notifications.php', // Ensure this path is correct
                    type: 'GET',
                    dataType: 'json', // Adjust this based on your endpoint's response
                    success: function(data) {
                        /**
                         * Since the endpoint returns a single digit (0 or 1),
                         * we need to interpret 'data' directly.
                         * - 0 => No notifications
                         * - 1 => Notifications exist
                         */

                        // If dataType is 'json' and the response is a JSON number
                        const hasNotifications = data > 0;

                        // If dataType is 'text' and the response is a string '0' or '1'
                        // const hasNotifications = parseInt(data, 10) > 0;

                        updateNotificationIcon(hasNotifications);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch notifications:', error);
                    }
                });
            }

            function loadCategories() {
                $.ajax({
                    url: '../actions/get_all_categories_action.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var container = $('#categoriesContainer');
                        container.empty(); // Clear existing content

                        if (data.length === 0) {
                            container.append('<div class="text-center">No categories available.</div>');
                            return;
                        }

                        $.each(data, function(index, category) {
                            var categoryHTML = `
                            <div class="form-check mb-3">
                                <input class="form-check-input category-checkbox" type="checkbox" value="${category.category_id}" id="category_${category.category_id}">
                                <label class="form-check-label d-flex align-items-center" for="category_${category.category_id}">
                                    <span>${category.name}</span>
                                </label>
                                <div class="mt-2 ms-4 experience-level-container" style="display:none;">
                                    <label for="experience_${category.category_id}" class="form-label">Experience Level:</label>
                                    <select class="form-select experience-level" id="experience_${category.category_id}" name="experience_levels[${category.category_id}]">
                                        <option value="" selected disabled>Select level</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                </div>
                            </div>
                        `;
                            container.append(categoryHTML);
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an issue fetching the categories. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

            // Load categories when the modal is shown
            $('#updateCategoriesModal').on('show.bs.modal', function() {
                loadCategories();
            });

            // Toggle experience level selector based on checkbox
            $('#categoriesContainer').on('change', '.category-checkbox', function() {
                var categoryId = $(this).val();
                var experienceContainer = $('#experience_' + categoryId).closest('.experience-level-container');
                if ($(this).is(':checked')) {
                    experienceContainer.slideDown();
                    $('#experience_' + categoryId).attr('required', true);
                } else {
                    experienceContainer.slideUp();
                    $('#experience_' + categoryId).val('');
                    $('#experience_' + categoryId).attr('required', false);
                }
            });

            // Handle Update Categories Form Submission
            $('#updateCategoriesForm').on('submit', function(e) {
                e.preventDefault();
                var selectedCategories = [];
                var experienceLevels = {};

                $('.category-checkbox:checked').each(function() {
                    var categoryId = $(this).val();
                    var experience = $('#experience_' + categoryId).val();
                    selectedCategories.push(categoryId);
                    experienceLevels[categoryId] = experience;
                });

                if (selectedCategories.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Categories Selected',
                        text: 'Please select at least one category to update.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                console.log(selectedCategories);
                console.log(experienceLevels);

                $.ajax({
                    url: '../actions/add_freelancer_categories_action.php',
                    type: 'POST',
                    data: {
                        categories: selectedCategories,
                        experience_levels: experienceLevels
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Categories updated successfully.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#updateCategoriesModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Unable to update categories.',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an issue updating the categories. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
            $('#addPortfolioForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '../actions/add_freelancer_portfolio_action.php',
                    type: 'POST',
                    data: {
                        portfolioTitle: $('#portfolioTitle').val(),
                        portfolioDescription: $('#portfolioDescription').val(),
                        portfolioURL: $('#portfolioURL').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Portfolio added successfully.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#addPortfolioModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Unable to add portfolio.',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an issue adding the portfolio. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
            fetchNotificationStatus();
            setInterval(fetchNotificationStatus, 60000);

        });
    </script>
</body>

</html>