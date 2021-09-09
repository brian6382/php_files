<?php 
session_start();
require 'includes/DbOperations.php';
$db = new DbOperations; 

if (!isset($_SESSION['full_name'])) {
      header("Location: ../index");
}

 $today = date("Y-m-d");




$success_message = '';  
if (isset($_POST['saveAndClose'])) {
    $medicine_name = strtoupper($_POST['medicine_name']);
    $category = $_POST['category'];
    $expire_date = $_POST['expire_date'];
    $qty = $_POST['qty'];
    $size = $_POST['size'];
    $status = 'Pending';

    $start_date = strtotime($today);
              $end_date = strtotime($_POST['expire_date']);

              $daysLeft = ($end_date - $start_date)/60/60/24;
  
    // $account_number = $db->generateRandomString(6);
  
    $result = $db-> addMedicine($medicine_name, $category, $expire_date,$qty,$size,$status,$daysLeft); 

    if ($result == USER_CREATED) {
         header("Location: accountList"); 
    } elseif ($result == USER_FAILURE) {
       $success_message = '<div class="alert alert-primary" role="alert">
                 Something went wrong...please try again later!
                </div>'; 
    }elseif ($result == USER_EXISTS) {
         $success_message = '<div class="alert alert-danger" role="alert">
                      This Medicine already exists
                    </div>'; 
    }

}elseif (isset($_POST['saveAndContinue'])) {
   $medicine_name = strtoupper($_POST['medicine_name']);
    $category = $_POST['category'];
    $expire_date = $_POST['expire_date'];
    $qty = $_POST['qty'];
    $size = $_POST['size'];
    $status = 'pending';

    $start_date = strtotime($today);
              $end_date = strtotime($_POST['expire_date']);

              $daysLeft = ($end_date - $start_date)/60/60/24;
  
    // $account_number = $db->generateRandomString(6);
  
    $result = $db->addMedicine($medicine_name, $category, $expire_date,$qty,$size,$status,$daysLeft); 

    if ($result == USER_CREATED) {
         $success_message = '<div class="alert alert-success" role="alert">
                 Medicine added successfully!
                </div>'; 
    } elseif ($result == USER_FAILURE) {
       $success_message = '<div class="alert alert-primary" role="alert">
                 Something went wrong...please try again later!
                </div>'; 
    }elseif ($result == USER_EXISTS) {
         $success_message = '<div class="alert alert-danger" role="alert">
                      This Medicine already exists
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

  <title>Apartment Manager - Add Floor</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
   <?php require 'includes/aside.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require 'includes/header.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card">
                <h5 class="card-header">Add Medicine</h5>
                <div class="card-body">
                  <form method="post">
                    <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I">

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Medicine Name <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="medicine_name" placeholder="Add Medicine Name :" required class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label">category   <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="category" placeholder="Add category e.g injection,Capsules,Tablet,:" required class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Expire Date  <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="date" name="expire_date" required class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> QTY  <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="qty" placeholder="Add QTY e.g 2 boxes :" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> Medicine Size   <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="size" placeholder="Add  Medicine Size 50ml :" required class="form-control">
                    </div>



                    <div class="form-group mb-3">
                      <button type="reset" class="btn btn-danger">Reset</button>
                       <button class="btn btn-warning" name="saveAndClose" type="submit">Save & Close</button>
                        <button class="btn btn-success" name="saveAndContinue" type="submit">Save & Continue</button>
                    </div>
                  </form>
                  <?php 
                    if (isset($success_message)) {
                      echo $success_message;
                    }
                  ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="includes/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
