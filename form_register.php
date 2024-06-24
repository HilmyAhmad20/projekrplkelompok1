<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40; /* Warna latar belakang hitam */
            color: #fff; /* Warna teks putih */
        }
        .card {
            background-color: #495057; /* Warna latar belakang card */
            color: #fff; /* Warna teks di dalam card putih */
        }
        .card-header {
            background-color: #007bff; /* Warna latar belakang header card */
            color: #fff; /* Warna teks header card putih */
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff; /* Warna background tombol */
            border-color: #007bff; /* Warna border tombol */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Warna background tombol saat di-hover */
            border-color: #0056b3; /* Warna border tombol saat di-hover */
        }
        a {
            color: #007bff; /* Warna teks link */
        }
        a:hover {
            color: #0056b3; /* Warna teks link saat di-hover */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-auto">
                <div class="card-header">
                    <h3 class="text-center">Register</h3>
                </div>
                <div class="card-body">
                    <form action="aksi_register.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Level</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Pengguna">Pengguna</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
