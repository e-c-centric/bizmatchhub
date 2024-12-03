<?php
// filepath: /c:/xampp/htdocs/bizmatchhub/views/payments.php
session_start();

// Include common functions and menu items
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
    <title>Payments | BizMatch Hub</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Paystack Inline Script -->
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <style>
        /* Payments Page Styles */
        .payments-section {
            background-color: #f8f9fa;
            min-height: 80vh;
        }

        .action-btn {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .action-btn.pay {
            color: #28a745;
        }

        .action-btn.decline {
            color: #dc3545;
        }

        .action-btn {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.2rem;
            margin-right: 5px;
        }

        .approve-btn {
            color: #28a745;
        }

        .decline-btn {
            color: #dc3545;
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
        <!-- Payments Section -->
        <section class="payments-section py-5 px-3 px-sm-4 px-md-5">
            <div class="container">
                <h2 class="mb-4">Invoices</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Freelancer's Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Paid At</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                            <!-- Dynamically populated invoices will appear here -->
                        </tbody>
                    </table>
                    <p id="noPaymentsMessage" class="text-center text-muted" style="display: none;">No payments found.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="paymentForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Invoice Number:</strong> <span id="modalInvoiceNumber"></span></p>
                        <p><strong>Amount:</strong> GHS <span id="modalAmount"></span></p>
                        <p><strong>VAT (15%):</strong> GHS <span id="modalVAT"></span></p>
                        <p><strong>Total Amount:</strong> GHS <span id="modalTotalAmount"></span></p>
                        <div class="mb-3">
                            <label for="customerEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="customerEmail" placeholder="Enter your email" required>
                        </div>
                        <input type="hidden" id="hiddenTotalAmount" value="">
                        <input type="hidden" id="hiddenInvoiceNumber" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle mobile sidebar
            const navToggler = document.getElementById('nav-toggler');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-nav-overlay');

            navToggler.addEventListener('click', function() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Change navbar background on scroll
            window.addEventListener('scroll', function() {
                const topNav = document.getElementById('top-nav');
                if (window.scrollY > 50) {
                    topNav.classList.add('scrolled');
                } else {
                    topNav.classList.remove('scrolled');
                }
            });

            $(document).ready(function() {
                // Function to capitalize the first letter
                function capitalizeFirstLetter(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1);
                }

                // Fetch payment history and populate the table
                $.ajax({
                    url: '../actions/get_payment_history_action.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const payments = response.data;
                            const invoiceTableBody = $('#invoiceTableBody');

                            if (payments.length === 0) {
                                // No payments found
                                $('#noPaymentsMessage').show();
                            } else {
                                $('#noPaymentsMessage').hide();
                                payments.forEach(function(payment) {
                                    let actionButtons = '';
                                    if (payment.status.toLowerCase() === 'pending') {
                                        actionButtons = `
        <button class="action-btn approve-btn" data-invoice="${payment.invoice_number}" data-amount="${payment.amount}">
            <i class="bi bi-check-circle-fill"></i>
        </button>
        <button class="action-btn decline-btn" data-invoice="${payment.invoice_number}">
            <i class="bi bi-x-circle-fill"></i>
        </button>
    `;
                                    } else {
                                        actionButtons = capitalizeFirstLetter(payment.status);
                                    }
                                    const row = `
                                    <tr>
                                        <td>${payment.invoice_number}</td>
                                        <td>${payment.name}</td>
                                        <td>${payment.amount}</td>
                                        <td>${payment.paid_at}</td>
                                        <td>${actionButtons}</td>
                                    </tr>
                                `;
                                    invoiceTableBody.append(row);
                                });

                                // Attach event listeners after appending rows
                                attachEventListeners();
                            }
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch payment history:', error);
                        Swal.fire('Error', 'An error occurred while fetching payment history.', 'error');
                    }
                });

                function attachEventListeners() {
                    // Approve button click handler
                    $('.approve-btn').click(function() {
                        const invoiceNumber = $(this).data('invoice');
                        const amount = parseFloat($(this).data('amount'));

                        // Calculate VAT and total amount
                        const vat = amount * 0.15;
                        const totalAmount = amount + vat;

                        // Populate modal fields
                        $('#modalInvoiceNumber').text(invoiceNumber);
                        $('#modalAmount').text(amount.toFixed(2));
                        $('#modalVAT').text(vat.toFixed(2));
                        $('#modalTotalAmount').text(totalAmount.toFixed(2));
                        $('#hiddenTotalAmount').val(totalAmount.toFixed(2));
                        $('#hiddenInvoiceNumber').val(invoiceNumber);

                        // Show the modal
                        $('#paymentModal').modal('show');
                    });

                    // Handle payment form submission
                    $('#paymentForm').submit(function(e) {
                        e.preventDefault();
                        const email = $('#customerEmail').val();
                        const amount = $('#hiddenTotalAmount').val();
                        const invoiceNumber = $('#hiddenInvoiceNumber').val();

                        // Initialize Paystack payment
                        payWithPaystack(email, amount, invoiceNumber);
                    });

                    // Decline button click handler
                    $('.decline-btn').click(function() {
                        const invoiceNumber = $(this).data('invoice');
                        Swal.fire({
                            title: 'Confirm Decline',
                            text: `Are you sure you want to decline invoice ${invoiceNumber}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Decline',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '../actions/update_payment_status_action.php',
                                    type: 'POST',
                                    data: {
                                        invoice_number: invoiceNumber,
                                        status: 'failed'
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            Swal.fire('Declined', `Invoice ${invoiceNumber} has been declined.`, 'success').then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error', response.message, 'error');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Failed to update payment status:', error);
                                        Swal.fire('Error', 'An error occurred while updating payment status.', 'error');
                                    }
                                });
                            }
                        });
                    });
                }

                function payWithPaystack(email, amount, invoiceNumber) {
                    const amountInKobo = parseFloat(amount) * 100;
                    const og_invoiceNumber = invoiceNumber;

                    var handler = PaystackPop.setup({
                        key: 'pk_test_77ec42645ca666362284603f5c0c32866795216b',
                        email: email,
                        amount: amountInKobo,
                        currency: 'GHS',
                        ref: invoiceNumber + '_' + Math.floor((Math.random() * 1000000000) + 1),
                        callback: function(response) {

                            $.ajax({
                                url: '../actions/process_payment_action.php',
                                type: 'POST',
                                data: {
                                    invoice_number: invoiceNumber,
                                    status: 'completed',
                                    transaction_ref: response.reference
                                },
                                dataType: 'json',
                                success: function(serverResponse) {
                                    if (serverResponse.status === 'success') {
                                        Swal.fire('Payment Successful', `Invoice ${invoiceNumber} marked as Paid.`, 'success').then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error', serverResponse.message, 'error');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Failed to update payment status:', error);
                                    Swal.fire('Error', 'An error occurred while updating payment status.', 'error');
                                }
                            });
                        },
                        onClose: function() {
                            Swal.fire('Payment Cancelled', 'You cancelled the payment.', 'info');
                        }
                    });
                    handler.openIframe();
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