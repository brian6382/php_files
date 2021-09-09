<?php
session_start();
error_reporting();
require 'dashboard/includes/DbOperations.php';
$db = new DbOperations; 
$alert = ''; 
if (isset($_SESSION["contacts"])) {
    header("Location: dashboard/");
}

if (isset($_POST['login_login'])) {
    $password = $_POST['password'];
    $email = $_POST['email'];

    $result = $db->adminLogin($email, $password);

    if ($result == USER_AUTHENTICATED) {
         $admin = $db->getAdminByPhone($email);
         $_SESSION["id"] = $admin['id'];
         $_SESSION["contacts"] = $admin['phone_number'];
         $_SESSION["full_name"] = $admin['full_name'];
         header("Location: dashboard/"); 
    } elseif ($result == USER_NOT_FOUND) {
       $alert = '<div class="alert alert-primary" role="alert">
                  This email does not exist!
                </div>'; 
    }elseif ($result == USER_PASSWORD_DO_NOT_MATCH) {
         $alert = '<div class="alert alert-secondary" role="alert">
                      Password entered is Wrong!
                    </div>'; 
    }
} 


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Apartment Manager - Login</title>

  <!-- Custom fonts for this template-->
  <link href="dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="dashboard/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email ......">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="login_login">Login</button>
                   </form><br>
                    <?php 
                    if (isset($alert)) {
                      echo $alert;
                     } 
                    ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="dashboard/vendor/jquery/jquery.min.js"></script>
  <script src="dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="dashboard/js/sb-admin-2.min.js"></script>

</body>

</html>
