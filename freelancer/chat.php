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

        /* Conversations Panel */
        #conversationsList .conversation-item {
            cursor: pointer;
        }

        #conversationsList .conversation-item:hover {
            background-color: #f1f1f1;
        }

        /* Messages Panel */
        #chatHistory {
            background-color: #f8f9fa;
        }

        /* Message Bubbles */
        .bg-primary {
            background-color: #0d6efd !important;
        }

        .bg-light {
            background-color: #e9ecef !important;
        }

        /* Scrollbar Styling */
        .overflow-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
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
        <div class="container-fluid vh-100">
            <div class="row h-100">
                <!-- Conversations Panel -->
                <div class="col-md-4 border-end d-flex flex-column p-0">
                    <div class="p-3 border-bottom">
                        <h5>Chats</h5>
                    </div>
                    <div class="flex-grow-1 overflow-auto" id="conversationsList">
                        <!-- Example Conversation Item -->
                        <div class="d-flex align-items-center p-3 conversation-item border-bottom" data-user-id="1">
                            <img src="../assets/svg/profile.png" alt="User" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">John Doe</h6>
                                <small class="text-muted">Hey, how are you?</small>
                            </div>
                        </div>
                        <!-- Repeat Conversation Items as Needed -->
                    </div>
                </div>

                <!-- Messages Panel -->
                <div class="col-md-8 d-flex flex-column p-0">
                    <!-- Conversation Header -->
                    <div class="p-3 border-bottom d-flex align-items-center">
                        <img src="../assets/svg/profile.png" alt="User" class="rounded-circle me-3" width="50" height="50">
                        <h5 class="mb-0">John Doe</h5>
                    </div>

                    <!-- Chat History -->
                    <div class="flex-grow-1 overflow-auto p-3" id="chatHistory">
                        <!-- Example Message -->
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <img src="../assets/svg/profile.png" alt="User" class="rounded-circle" width="40" height="40">
                            </div>
                            <div>
                                <div class="bg-light p-2 rounded">
                                    Hello! How are you?
                                </div>
                                <small class="text-muted">10:00 AM</small>
                            </div>
                        </div>
                        <!-- Example Received Message -->
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <div class="bg-primary text-white p-2 rounded">
                                    I'm good, thanks! How about you?
                                </div>
                                <small class="text-muted">10:05 AM</small>
                            </div>
                            <div class="ms-3">
                                <img src="../assets/svg/profile.png" alt="User" class="rounded-circle" width="40" height="40">
                            </div>
                        </div>
                        <!-- Repeat Messages as Needed -->
                    </div>

                    <!-- Message Input -->
                    <div class="p-3 border-top">
                        <form id="messageForm" class="d-flex">
                            <input type="text" class="form-control me-2" id="messageInput" placeholder="Type a message" required>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
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

            $('.conversation-item').click(function() {
                // Remove active class from all conversations
                $('.conversation-item').removeClass('active');
                // Add active class to the clicked conversation
                $(this).addClass('active');

                // Fetch User ID from data attribute
                var userId = $(this).data('user-id');

                // TODO: Implement AJAX call to fetch messages for the selected conversation
                // For now, we'll simulate with static content

                // Update Conversation Header
                var userName = $(this).find('h6').text();
                $('h5.mb-0').text(userName);
                var userImage = $(this).find('img').attr('src');
                $('div.p-3.border-bottom img').attr('src', userImage);

                // Clear Chat History
                $('#chatHistory').empty();

                // TODO: Populate #chatHistory with fetched messages

                // Example Messages (Replace with dynamic content)
                var messages = [{
                        sender: 'other',
                        text: 'Hello! How are you?',
                        time: '10:00 AM'
                    },
                    {
                        sender: 'self',
                        text: "I'm good, thanks! How about you?",
                        time: '10:05 AM'
                    }
                ];

                messages.forEach(function(msg) {
                    if (msg.sender === 'other') {
                        $('#chatHistory').append(`
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <img src="${userImage}" alt="User" class="rounded-circle" width="40" height="40">
                            </div>
                            <div>
                                <div class="bg-light p-2 rounded">
                                    ${msg.text}
                                </div>
                                <small class="text-muted">${msg.time}</small>
                            </div>
                        </div>
                    `);
                    } else {
                        $('#chatHistory').append(`
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <div class="bg-primary text-white p-2 rounded">
                                    ${msg.text}
                                </div>
                                <small class="text-muted">${msg.time}</small>
                            </div>
                            <div class="ms-3">
                                <img src="../assets/svg/profile.png" alt="User" class="rounded-circle" width="40" height="40">
                            </div>
                        </div>
                    `);
                    }
                });

                // Scroll to Bottom
                $('#chatHistory').scrollTop($('#chatHistory')[0].scrollHeight);
            });

            // Handle Message Form Submission
            $('#messageForm').submit(function(e) {
                e.preventDefault();
                var message = $('#messageInput').val().trim();
                if (message === '') return;

                // TODO: Implement AJAX call to send the message

                // Append Sent Message
                $('#chatHistory').append(`
                <div class="d-flex justify-content-end mb-3">
                    <div>
                        <div class="bg-primary text-white p-2 rounded">
                            ${message}
                        </div>
                        <small class="text-muted">Now</small>
                    </div>
                    <div class="ms-3">
                        <img src="../assets/svg/profile.png" alt="User" class="rounded-circle" width="40" height="40">
                    </div>
                </div>
            `);

                $('#messageInput').val('');

                $('#chatHistory').scrollTop($('#chatHistory')[0].scrollHeight);
            });
        });
    </script>
</body>

</html>