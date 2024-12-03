<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - BizMatch Hub</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../assets/style.css" rel="stylesheet">
    <style>
        /* Custom Styles for Login Page */

        body {
            background: url('R.jpg') no-repeat center center fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
        }

        .login-container h2 {
            margin-bottom: 30px;
            font-weight: 700;
            color: #333333;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #555555;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        /* Remember Me Checkbox */
        .form-check-label {
            user-select: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Welcome Back!</h2>
        <form id="loginForm">
            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address<span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
            </div>

            <!-- Remember Me Checkbox -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>

            <!-- Forgot Password Link -->
            <div class="mt-3 text-center">
                <a href="forgot_password.php" class="text-decoration-none">Forgot Your Password?</a>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            Don't have an account? <a href="register.php" class="text-decoration-none">Register Here</a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle Form Submission
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                // Prepare form data
                var formData = $(this).serialize();

                $.ajax({
                    url: '../actions/login_action.php', // Ensure this path is correct
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.href = '../views/';
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An unexpected error occurred.',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
</body>

</html>