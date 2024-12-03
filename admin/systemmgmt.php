<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>System Management - BizMatch Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            padding-top: 50px;
        }

        .container-fluid {
            max-width: 1200px;
        }

        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        table th,
        table td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h1 class="text-center">System Management</h1>



        <!-- Category Management Section -->
        <section>
            <h2>Category Management</h2>
            <!-- Add Category Form -->
            <form action="../actions/add_category_action.php" method="POST" class="row g-3 mb-4">
                <div class="col-md-8">
                    <label for="category_name" class="form-label">New Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                </div>
                <div class="col-md-8">
                    <label for="category_name" class="form-label">Image URL</label>
                    <input type="text" class="form-control" id="image_url" name="image_url" required>
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary w-100">Add Category</button>
                </div>
            </form>

            <!-- Categories Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categories-table-body">
                    <!-- Dynamic Category Rows Will Be Inserted Here -->
                </tbody>
            </table>

            <!-- Loading Indicator -->
            <div id="loading-indicator" class="text-center my-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </section>

        <!-- Review Management Section -->
        <section>
            <h2>Review Management</h2>
            <!-- Reviews Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Review ID</th>
                        <th>Contractor ID</th>
                        <th>Freelancer ID</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Placeholder Review Rows -->
                    <tr>
                        <td>101</td>
                        <td>5</td>
                        <td>12</td>
                        <td>5</td>
                        <td>Excellent work!</td>
                        <td>
                            <form action="delete_review.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                <input type="hidden" name="review_id" value="101">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>7</td>
                        <td>15</td>
                        <td>4</td>
                        <td>Great attention to detail.</td>
                        <td>
                            <form action="delete_review.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                <input type="hidden" name="review_id" value="102">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <!-- Add more placeholder rows as needed -->
                </tbody>
            </table>
        </section>

        <!-- User Management Section -->
        <section>
            <h2>User Management</h2>
            <!-- Users Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    <!-- Dynamic User Rows Will Be Inserted Here -->
                </tbody>
            </table>

            <!-- Loading Indicator -->
            <div id="loading-indicator-2" class="text-center my-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </section>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sweetalert2 css, js, and jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add Category Form Submission
            $('form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                $.post(url, formData, function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Category added successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }, 'json');
            });
        });

        $(document).ready(function() {
            // Show the loading indicator while fetching categories
            $('#loading-indicator').show();

            // Fetch all categories via AJAX
            $.ajax({
                url: '../actions/get_all_categories_action.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Hide the loading indicator after receiving data
                    $('#loading-indicator').hide();

                    const tbody = $('#categories-table-body');
                    tbody.empty(); // Clear existing content

                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function(index, category) {
                            const row = `
                        <tr>
                            <td>${category.category_id}</td>
                            <td>${category.name}</td>
                            <td>
                                <form action="../actions/delete_category_action.php" method="POST" class="delete-category-form">
                                    <input type="hidden" name="category_id" value="${category.category_id}">
                                    <button type="submit" class="btn btn-danger btn-sm delete-category-btn">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `;
                            tbody.append(row);
                        });
                    } else {
                        const noDataRow = `
                    <tr>
                        <td colspan="3" class="text-center">No categories found.</td>
                    </tr>
                `;
                        tbody.append(noDataRow);
                    }
                },
                error: function(xhr, status, error) {
                    // Hide the loading indicator in case of an error
                    $('#loading-indicator').hide();
                    console.error('Error fetching categories:', error);

                    const tbody = $('#categories-table-body');
                    tbody.empty();
                    const errorRow = `
                <tr>
                    <td colspan="3" class="text-center text-danger">Failed to load categories.</td>
                </tr>
            `;
                    tbody.append(errorRow);
                }
            });

            // Event listener for delete buttons using event delegation
            $(document).on('click', '.delete-category-btn', function(e) {
                e.preventDefault();

                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this category?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(form.attr('action'), form.serialize(), function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Category deleted successfully!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }, 'json');
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#loading-indicator-2').show();

            $.ajax({
                url: '../actions/get_all_users_action.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#loading-indicator-2').hide();

                    const tbody = $('#users-table-body');
                    tbody.empty();

                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function(index, user) {
                            const isActive = user.is_active === "1" ? "Yes" : "No";
                            const userTypeCapitalized = user.user_type.charAt(0).toUpperCase() + user.user_type.slice(1);

                            const row = `
                        <tr>
                            <td>${user.user_id}</td>
                            <td>${user.email}</td>
                            <td>${user.phone_number}</td>
                            <td>${user.name}</td>
                            <td>${userTypeCapitalized}</td>
                            <td>${isActive}</td>
                            <td>
                                <form action="../actions/deactivate_user_action.php" method="POST" class="deactivate-user-form">
                                    <input type="hidden" name="user_id" value="${user.user_id}">
                                    <button type="submit" class="btn btn-warning btn-sm deactivate-user-btn">
                                        <i class="bi bi-person-x"></i> Deactivate
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `;
                            tbody.append(row);
                        });
                    } else {
                        const noDataRow = `
                    <tr>
                        <td colspan="7" class="text-center">No users found.</td>
                    </tr>
                `;
                        tbody.append(noDataRow);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading-indicator-2').hide();
                    console.error('Error fetching users:', error);

                    const tbody = $('#users-table-body');
                    tbody.empty();
                    const errorRow = `
                <tr>
                    <td colspan="7" class="text-center text-danger">Failed to load users.</td>
                </tr>
            `;
                    tbody.append(errorRow);
                }
            });

            $(document).on('click', '.deactivate-user-btn', function(e) {
                e.preventDefault();

                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to deactivate this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, deactivate it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(form.attr('action'), form.serialize(), function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'User deactivated successfully!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }, 'json');
                    }
                });
            });
        });
    </script>
</body>

</html>