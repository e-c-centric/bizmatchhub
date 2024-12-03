<?php
// filepath: /c:/xampp/htdocs/bizmatchhub/views/hire.php
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
    <title>Hire Services - BizMatch Hub</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Fuse.js for Fuzzy Search -->
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.6.2/dist/fuse.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        /* Additional styles specific to hire.php */
        .category-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .category-card img {
            width: 100%;
            height: 200px;
            /* Set a fixed height */
            object-fit: cover;
            /* Ensure the image covers the container without distortion */
            border-radius: 0.25rem;
            /* Optional: Match Bootstrap card rounding */
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            max-width: 500px;
            margin: 20px auto;
        }

        .no-results {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: gray;
            font-size: 1.2rem;
        }

        /* Mobile Sidebar Styles (if any specific) */
        /* Adjust the sidebar width as needed */
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
        }

        .mobile-nav-overlay.active {
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <!-- Top navbar -->
        <nav class="p-0 fixed-top text-green" id="top-nav">
            <div class="top-nav row mx-auto my-auto pt-3 pb-3 w-100 container-fluid text-green">
                <div class="toggle-btn col-auto text-green text-start p-0 d-md-none" style="cursor: pointer;" id="nav-toggler">
                    <span class="bi bi-list fs-2 text-start ms-0 me-auto"></span>
                </div>
                <a href="index.php" class="nav-logo col-sm col-8 mx-auto mx-sm-0 text-sm-start text-center my-auto">
                    <div style="width: fit-content;" class="mx-auto mx-sm-0">
                        <img class="nav-logo-white d-block" src="../assets/svg/logo.png" alt="BizMatch Hub">
                        <img class="nav-logo-black d-none" src="../assets/svg/logo.png" alt="BizMatch Hub">
                    </div>
                </a>
                <ul class="d-none d-md-flex text-black col-auto row fw-semibold my-auto">
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
                            <a href="../login/login.php" class="nav-link">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!--  -->
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
                        <li class="col-auto my-2 fs-6"><a href="signin.php">Sign in</a></li>
                    <?php else: ?>
                        <li class="col-auto my-2 fs-6"><a href="logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
                <p class="fw-semibold text-black mt-4">General</p>
                <hr>
                <ul class="fw-normal d-flex flex-column mx-auto">
                    <?php
                    // Replicate authentication menu items if needed
                    if (!isset($_SESSION['user_id'])): ?>
                        <li class="col-auto my-2 fs-6"><a href="signin.php">Sign in</a></li>
                    <?php else: ?>
                        <li class="col-auto my-2 fs-6"><a href="logout.php">Logout</a></li>
                    <?php endif; ?>
                    <!-- Additional consistent menu items can go here -->
                </ul>
            </div>
            <div class="mobile-nav-overlay d-none"></div>
        </nav>
    </header>

    <main>
        <div class="mt-5 pt-5" style="margin-top: 20;">
            <!-- Search Bar -->
            <section class="search-bar">
                <input type="text" id="search-input" class="form-control" placeholder="Search for a category...">
            </section>

            <!-- Categories Section -->
            <section class="categories py-5 px-3 px-sm-4 px-md-5">
                <div class="container">
                    <div class="row" id="categories-container">
                        <!-- Category cards will be injected here by JavaScript -->
                    </div>
                    <div class="no-results">No categories found.</div>
                </div>
            </section>
        </div>
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
                    <li class="py-2 px-2">
                        <svg width="20" height="17" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path
                                d="M20 1.875C19.25 2.25 18.5 2.375 17.625 2.5C18.5 2 19.125 1.25 19.375 0.25C18.625 0.75 17.75 1 16.75 1.25C16 0.5 14.875 0 13.75 0C11.625 0 9.75 1.875 9.75 4.125C9.75 4.5 9.75 4.75 9.875 5C6.5 4.875 3.375 3.25 1.375 0.75C1 1.375 0.875 2 0.875 2.875C0.875 4.25 1.625 5.5 2.75 6.25C2.125 6.25 1.5 6 0.875 5.75C0.875 7.75 2.25 9.375 4.125 9.75C3.75 9.875 3.375 9.875 3 9.875C2.75 9.875 2.5 9.875 2.25 9.75C2.75 11.375 4.25 12.625 6.125 12.625C4.75 13.75 3 14.375 1 14.375C0.625 14.375 0.375 14.375 0 14.375C1.875 15.5 4 16.25 6.25 16.25C13.75 16.25 17.875 10 17.875 4.625C17.875 4.5 17.875 4.25 17.875 4.125C18.75 3.5 19.5 2.75 20 1.875Z">
                            </path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path
                                d="M20 10.0022C20.0004 8.09104 19.4532 6.2198 18.4231 4.61003C17.393 3.00026 15.9232 1.71938 14.1877 0.919062C12.4522 0.118741 10.5237 -0.167503 8.63053 0.0942223C6.73739 0.355948 4.9589 1.15468 3.50564 2.39585C2.05237 3.63701 0.985206 5.26863 0.430495 7.0975C-0.124217 8.92636 -0.143239 10.8759 0.37568 12.7152C0.894599 14.5546 1.92973 16.2067 3.35849 17.476C4.78726 18.7453 6.54983 19.5786 8.4375 19.8772V12.8922H5.89875V10.0022H8.4375V7.79843C8.38284 7.28399 8.44199 6.76382 8.61078 6.2748C8.77957 5.78577 9.05386 5.33986 9.4142 4.96866C9.77455 4.59746 10.2121 4.31007 10.6959 4.12684C11.1797 3.94362 11.6979 3.86905 12.2137 3.90843C12.9638 3.91828 13.7121 3.98346 14.4525 4.10343V6.56718H13.1925C12.9779 6.53911 12.7597 6.55967 12.554 6.62733C12.3484 6.69498 12.1607 6.80801 12.0046 6.95804C11.8486 7.10807 11.7283 7.29127 11.6526 7.49408C11.577 7.69689 11.5479 7.91411 11.5675 8.12968V10.0047H14.3412L13.8975 12.8947H11.5625V19.8834C13.9153 19.5112 16.058 18.3114 17.6048 16.4999C19.1516 14.6884 20.001 12.3842 20 10.0022Z">
                            </path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="21" height="20" viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path
                                d="M19.125 0H0.875C0.375 0 0 0.375 0 0.875V19.25C0 19.625 0.375 20 0.875 20H19.25C19.75 20 20.125 19.625 20.125 19.125V0.875C20 0.375 19.625 0 19.125 0ZM5.875 17H3V7.5H6V17H5.875ZM4.5 6.25C3.5 6.25 2.75 5.375 2.75 4.5C2.75 3.5 3.5 2.75 4.5 2.75C5.5 2.75 6.25 3.5 6.25 4.5C6.125 5.375 5.375 6.25 4.5 6.25ZM17 17H14V12.375C14 11.25 14 9.875 12.5 9.875C11 9.875 10.75 11.125 10.75 12.375V17.125H7.75V7.5H10.625V8.75C11 8 12 7.25 13.375 7.25C16.375 7.25 16.875 9.25 16.875 11.75V17H17Z">
                            </path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path
                                d="M10 0C4.5 0 0 4.5 0 10C0 14.25 2.625 17.875 6.375 19.25C6.25 18.5 6.25 17.25 6.375 16.375C6.5 15.625 7.5 11.375 7.5 11.375C7.5 11.375 7.25 10.875 7.25 10C7.25 8.625 8.125 7.5 9.125 7.5C10 7.5 10.375 8.125 10.375 8.875C10.375 9.75 9.875 11 9.5 12.25C9.25 13.25 10 14 11 14C12.75 14 14.125 12.125 14.125 9.375C14.125 7 12.375 5.25 10 5.25C7.125 5.25 5.5 7.375 5.5 9.625C5.5 10.5 5.875 11.375 6.25 11.875C6.25 12.125 6.25 12.25 6.25 12.375C6.125 12.75 6 13.375 6 13.5C6 13.625 5.875 13.75 5.625 13.625C4.375 13 3.625 11.25 3.625 9.75C3.625 6.625 5.875 3.75 10.25 3.75C13.75 3.75 16.375 6.25 16.375 9.5C16.375 13 14.25 15.75 11.125 15.75C10.125 15.75 9.125 15.25 8.875 14.625C8.875 14.625 8.375 16.5 8.25 17C8 17.875 7.375 19 7 19.625C8 19.875 9 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0Z">
                            </path>
                        </svg>
                    </li>
                    <li class="py-2 px-2">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="grey">
                            <path
                                d="M15.1814 6.06504C15.8442 6.06504 16.3814 5.52778 16.3814 4.86504C16.3814 4.2023 15.8442 3.66504 15.1814 3.66504C14.5187 3.66504 13.9814 4.2023 13.9814 4.86504C13.9814 5.52778 14.5187 6.06504 15.1814 6.06504Z">
                            </path>
                            <path
                                d="M10 15C7.2425 15 5 12.7575 5 10C5 7.2425 7.2425 5 10 5C12.7575 5 15 7.2425 15 10C15 12.7575 12.7575 15 10 15ZM10 7.5C8.62125 7.5 7.5 8.62125 7.5 10C7.5 11.3787 8.62125 12.5 10 12.5C11.3787 12.5 12.5 11.3787 12.5 10C12.5 8.62125 11.3787 7.5 10 7.5Z">
                            </path>
                            <path
                                d="M15 20H5C2.43 20 0 17.57 0 15V5C0 2.43 2.43 0 5 0H15C17.57 0 20 2.43 20 5V15C20 17.57 17.57 20 15 20ZM5 2.5C3.83125 2.5 2.5 3.83125 2.5 5V15C2.5 16.1912 3.80875 17.5 5 17.5H15C16.1688 17.5 17.5 16.1688 17.5 15V5C17.5 3.83125 16.1688 2.5 15 2.5H5Z">
                            </path>
                        </svg>
                    </li>
                </ul>
                <ul class="d-flex align-items-center my-auto">
                    <li class="p-2">
                        <a href="#">
                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" fill="grey">
                                <path
                                    d="M9 1C4.58875 1 1 4.58875 1 9C1 13.4113 4.58875 17 9 17C13.4113 17 17 13.4113 17 9C17 4.58875 13.4113 1 9 1ZM8.53125 4.92676C7.81812 4.89612 7.11218 4.7959 6.43811 4.63293C6.54578 4.37781 6.6626 4.13281 6.78857 3.90063C7.30542 2.94824 7.93994 2.27991 8.53125 2.03784V4.92676ZM8.53125 5.86499V8.53125H5.60339C5.64465 7.4906 5.82202 6.45752 6.11536 5.51782C6.8927 5.71362 7.70874 5.83215 8.53125 5.86499ZM8.53125 9.46875V12.135C7.70874 12.1678 6.8927 12.2864 6.11536 12.4822C5.82202 11.5425 5.64465 10.5094 5.60339 9.46875H8.53125ZM8.53125 13.0732V15.9622C7.93994 15.7201 7.30542 15.0518 6.78857 14.0994C6.6626 13.8672 6.54578 13.6222 6.43811 13.3671C7.11218 13.2041 7.81799 13.1039 8.53125 13.0732ZM9.46875 13.0732C10.1819 13.1039 10.8878 13.2041 11.5619 13.3671C11.4542 13.6222 11.3374 13.8672 11.2114 14.0994C10.6946 15.0518 10.0601 15.7201 9.46875 15.9622V13.0732ZM9.46875 12.135V9.46875H12.3966C12.3553 10.5094 12.178 11.5425 11.8846 12.4822C11.1073 12.2864 10.2913 12.1678 9.46875 12.135ZM9.46875 8.53125V5.86499C10.2913 5.83215 11.1073 5.71362 11.8846 5.51782C12.178 6.45752 12.3553 7.4906 12.3966 8.53125H9.46875ZM9.46875 4.92676V2.03784C10.0601 2.27991 10.6946 2.94824 11.2114 3.90063C11.3374 4.13281 11.4542 4.37781 11.5619 4.63293C10.8878 4.7959 10.1819 4.89612 9.46875 4.92676ZM12.0354 3.45349C11.8007 3.02087 11.5457 2.63953 11.2769 2.31421C12.2141 2.63428 13.0631 3.14636 13.7771 3.8031C13.3699 4.02124 12.931 4.21069 12.4694 4.36902C12.3384 4.0509 12.1936 3.74487 12.0354 3.45349ZM5.9646 3.45349C5.8064 3.74487 5.66162 4.0509 5.53064 4.36902C5.06897 4.21069 4.63013 4.02112 4.2229 3.8031C4.93689 3.14636 5.78589 2.63428 6.72314 2.31421C6.45435 2.63953 6.19946 3.02075 5.9646 3.45349ZM5.2135 5.25012C4.89355 6.27368 4.70544 7.38953 4.66492 8.53125H1.95349C2.05383 7.00769 2.63892 5.61438 3.5564 4.50525C4.06555 4.79724 4.62317 5.047 5.2135 5.25012ZM4.66492 9.46875C4.70544 10.6106 4.89355 11.7263 5.2135 12.7499C4.62317 12.953 4.06555 13.2028 3.5564 13.4948C2.63892 12.3856 2.05383 10.9923 1.95349 9.46875H4.66492ZM5.53064 13.631C5.66162 13.9491 5.8064 14.2551 5.9646 14.5465C6.19946 14.9791 6.45435 15.3605 6.72314 15.6858C5.78589 15.3657 4.93689 14.8536 4.22302 14.1969C4.63 13.9789 5.06897 13.7893 5.53064 13.631ZM12.0354 14.5465C12.1936 14.2551 12.3384 13.9491 12.4694 13.631C12.931 13.7893 13.3699 13.9789 13.7771 14.1969C13.0631 14.8536 12.2141 15.3657 11.2769 15.6858C11.5457 15.3605 11.8005 14.9792 12.0354 14.5465ZM12.7865 12.7499C13.1064 11.7263 13.2946 10.6105 13.3351 9.46875H16.0465C15.9462 10.9923 15.3611 12.3856 14.4436 13.4948C13.9344 13.2028 13.3768 12.953 12.7865 12.7499ZM13.3351 8.53125C13.2946 7.3894 13.1064 6.27368 12.7865 5.25012C13.3768 5.047 13.9344 4.79724 14.4436 4.50525C15.3611 5.61438 15.9462 7.00769 16.0465 8.53125H13.3351Z"
                                    stroke-width="0.2"></path>
                            </svg>
                            English
                        </a>
                    </li>
                    <li class="p-2">
                        <a href="#">
                            GHS
                        </a>
                    </li>
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

            // Function to render categories
            function renderCategories(filteredCategories) {
                const container = $('#categories-container');
                container.empty(); // Clear existing categories

                if (filteredCategories.length === 0) {
                    $('.no-results').show();
                    return;
                } else {
                    $('.no-results').hide();
                }

                filteredCategories.forEach(category => {
                    const imageUrl = category.image ? category.image : 'https://via.placeholder.com/400x200.png?text=' + encodeURIComponent(category.name);
                    const card = `
                        <div class="col-md-4 col-sm-6 mb-4 category-item">
                            <div class="card category-card h-100" data-name="${category.name}" style="cursor: pointer;" data-category-id="${category.category_id}">
                                <img src="${imageUrl}" class="card-img-top" alt="${category.name}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">${category.name}</h5>
                                </div>
                            </div>
                        </div>
                    `;
                    container.append(card);
                });
            }

            // Initialize Fuse.js for fuzzy search
            const fuseOptions = {
                keys: ['name'],
                threshold: 0.3 // Adjust based on desired sensitivity
            };
            let fuse;

            // Fetch categories dynamically
            $.ajax({
                url: '../actions/get_all_categories_action.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (Array.isArray(data)) {
                        // Initialize Fuse.js with fetched data
                        fuse = new Fuse(data, fuseOptions);

                        // Initial render of all categories
                        renderCategories(data);
                    } else {
                        console.error('Unexpected data format:', data);
                        $('.no-results').text('Failed to load categories.').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching categories:', textStatus, errorThrown);
                    $('.no-results').text('Error loading categories. Please try again later.').show();
                }
            });

            // Search functionality
            $('#search-input').on('input', function() {
                const query = $(this).val().trim();
                if (query === "" || !fuse) {
                    $.ajax({
                        url: '../actions/get_all_categories_action.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (Array.isArray(data)) {
                                renderCategories(data);
                            }
                        }
                    });
                    return;
                }

                const results = fuse.search(query);
                const matchedCategories = results.map(result => result.item);
                renderCategories(matchedCategories);
            });

            // Redirect to people.php on category click
            $(document).on('click', '.category-card', function() {
                const categoryName = $(this).data('name');
                const categoryId = $(this).data('category-id');
                window.location.href = `people.php?category=${encodeURIComponent(categoryId)}`;
            });
        });
    </script><!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="../assets/script.js"></script>

</body>

</html>