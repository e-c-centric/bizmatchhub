<?php
// filepath: /c:/xampp/htdocs/bizmatchhub/login/register.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - BizMatch Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
    <style>
        body {
            background: url('R.jpg') no-repeat center center fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .register-container h2 {
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
            background-color: #0069d9;
            border-color: #0062cc;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0053ba;
            border-color: #0041a3;
        }

        .input-group-text {
            background-color: #f0f0f0;
            border-right: none;
        }

        .form-control:focus {
            border-color: #0069d9;
            box-shadow: none;
        }

        /* Freelancer Fields Header */
        #freelancerFields h4 {
            margin-top: 30px;
            margin-bottom: 20px;
            color: #333333;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .register-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Create Your Account</h2>
        <form id="registerForm">
            <!-- Full Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address<span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span></label>
                <input type="tel" pattern="[0-9]{10,15}" class="form-control" id="phone" name="phone" placeholder="1234567890" required>
                <div class="form-text">Enter digits only. e.g., 1234567890</div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                <input type="password" minlength="6" class="form-control" id="password" name="password" placeholder="********" required>
                <div class="form-text">Minimum 6 characters.</div>
            </div>

            <!-- User Type -->
            <div class="mb-3">
                <label for="userType" class="form-label">Register As<span class="text-danger">*</span></label>
                <select class="form-select" id="userType" name="userType" required>
                    <option value="" selected disabled>Select user type</option>
                    <option value="contractor">Contractor</option>
                    <option value="freelancer">Freelancer</option>
                </select>
            </div>

            <!-- Freelancer Additional Fields -->
            <div id="freelancerFields" style="display: none;">
                <h4>Freelancer Details</h4>
                <!-- Work Experience -->
                <div class="mb-3">
                    <label for="workExperience" class="form-label">Work Experience (Years)<span class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control" id="workExperience" name="workExperience">
                </div>
                <!-- Job Title -->
                <div class="mb-3">
                    <label for="jobTitle" class="form-label">Job Title<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="Graphic Designer">
                </div>
                <!-- Introduction -->
                <div class="mb-3">
                    <label for="introduction" class="form-label">Introduction<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="introduction" name="introduction" rows="3" placeholder="Tell us about yourself"></textarea>
                </div>
                <!-- Hourly Rate -->
                <div class="mb-3">
                    <label for="hourlyRate" class="form-label">Hourly Rate (USD)<span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" class="form-control" id="hourlyRate" name="hourlyRate" placeholder="25.00">
                </div>
                <!-- Work Hours -->
                <div class="mb-3">
                    <label for="workHours" class="form-label">Work Hours<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="workHours" name="workHours" placeholder="9 AM - 5 PM">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Register</button>

            <div class="mt-3 text-center">
                Already have an account? <a href="login.php" class="text-decoration-none">Login Here</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userType').change(function() {
                if ($(this).val() === 'freelancer') {
                    $('#freelancerFields').slideDown();
                    $('#freelancerFields input, #freelancerFields textarea').attr('required', true);
                } else {
                    $('#freelancerFields').slideUp();
                    $('#freelancerFields input, #freelancerFields textarea').attr('required', false);
                }
            });

            $('#registerForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '../actions/register_action.php',
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
                                window.location.href = 'login.php';
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