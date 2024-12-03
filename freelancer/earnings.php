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
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <title>Earnings</title>

    <style>
        main {
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* Table Styling */
        .table-wrapper {
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.25rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-dark th {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        .table tbody td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        /* Button Styling */
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 0.25rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .table-wrapper {
                padding: 10px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        /* Navbar and Sidebar Styling (Retained for layout consistency) */
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
        <section class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Earnings</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#issueInvoiceModal">
                    <i class="bi bi-plus-circle me-2"></i> Issue Invoice
                </button>
            </div>

            <div class="table-wrapper shadow-sm rounded">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Contractor Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Issued At</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                            <!-- Table rows will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>


    <!-- Issue Invoice Modal -->
    <div class="modal fade" id="issueInvoiceModal" tabindex="-1" aria-labelledby="issueInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="issueInvoiceModalLabel" class="modal-title">Issue New Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="issueInvoiceForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="contractorSelect" class="form-label">Select Contractor</label>
                            <select class="form-select" id="contractorSelect" name="contractor_id" required>
                                <option value="">-- Select Contractor --</option>
                                <!-- Options will be populated via AJAX -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="invoiceAmount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="invoiceAmount" name="amount" min="1" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Issue Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            function updateNotificationIcon(hasNotifications) {
                const notificationIcon = $('#notificationIcon');

                if (hasNotifications) {
                    notificationIcon.removeClass('bi-bell bi-bell-fill text-white').addClass('bi-bell-fill text-danger');
                } else {
                    notificationIcon.removeClass('bi-bell bi-bell-fill text-danger').addClass('bi-bell-fill text-white');
                }
            }

            function fetchNotificationStatus() {
                $.ajax({
                    url: '../actions/get_notifications.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const hasNotifications = data > 0;
                        updateNotificationIcon(hasNotifications);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch notifications:', error);
                    }
                });
            }

            fetchNotificationStatus();
            setInterval(fetchNotificationStatus, 60000);

            $('#issueInvoiceModal').on('show.bs.modal', function() {
                const contractorSelect = $('#contractorSelect');
                contractorSelect.empty().append('<option value="">Loading...</option>');

                $.ajax({
                    url: '../actions/get_all_users_action.php',
                    data: {
                        user_type: 'contractor'
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        contractorSelect.empty().append('<option value="">-- Select Contractor --</option>');
                        data.forEach(function(user) {
                            contractorSelect.append(`<option value="${user.user_id}">${user.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch contractors:', error);
                        contractorSelect.empty().append('<option value="">Failed to load contractors</option>');
                    }
                });
            });

            $('#issueInvoiceForm').submit(function(e) {
                e.preventDefault();

                const contractorId = $('#contractorSelect').val();
                const amount = $('#invoiceAmount').val();

                if (!contractorId || !amount) {
                    Swal.fire('Error', 'Please select a contractor and enter the amount.', 'error');
                    return;
                }

                $.ajax({
                    url: '../actions/generate_invoice_action.php',
                    type: 'POST',
                    data: {
                        contractor_id: contractorId,
                        amount: amount
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', response.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to issue invoice:', error);
                        Swal.fire('Error', 'An error occurred while issuing the invoice.', 'error');
                    }
                });
            });

            $.ajax({
                url: '../actions/get_payment_history_action.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const payments = response.data;
                        const invoiceTableBody = $('#invoiceTableBody');

                        payments.forEach(function(payment) {
                            const row = `
                                <tr>
                                    <td>${payment.invoice_number}</td>
                                    <td>${payment.name}</td>
                                    <td>${payment.amount}</td>
                                    <td>${payment.paid_at}</td>
                                    <td>${capitalizeFirstLetter(payment.status)}</td>
                                </tr>
                            `;
                            invoiceTableBody.append(row);
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch payment history:', error);
                    Swal.fire('Error', 'An error occurred while fetching payment history.', 'error');
                }
            });

        });
    </script>
</body>

</html>