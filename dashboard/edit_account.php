<?php 
session_start();
require 'includes/DbOperations.php';
$db = new DbOperations; 

if (!isset($_SESSION['full_name'])) {
      header("Location: ../index");
}

 $accountId = $_GET['dose_id'];

 $accountDetails = $db->getAllMedicineDetailsById($accountId);
 // $detailsTenant = $db->getAllTenants();
$success_message = '';  
if (isset($_POST['update'])) {
    $medicine_name = $_POST['medicine_name'];
    $category = $_POST['category'];
    $expire_date = $_POST['expire_date'];
    $qty = $_POST['qty'];
    $size = $_POST['size'];
    // $added_date = $_POST['added_date'];

    $result = $db->updateMedicineDetails($medicine_name, $category, $expire_date, $qty,$size,  $accountId); 
    
    if ($result == true) {
      ?>
      <script>
            alert('Medicine updated successfully');
            window.location.href = 'accountList';
          </script>
          <?php
    } elseif ($result == false) {
       $success_message = '<div class="alert alert-primary" role="alert">
                 Something went wrong...please try again later!
                </div>'; 
    }
    elseif ($result == ACCOUNT_EXIST) {
         $success_message = '<div class="alert alert-secondary" role="alert">
                      This Account already exists
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

  <title>Add Medicine</title>

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
                <h5 class="card-header">Edit Medicine</h5>
                <div class="card-body">
                  <form method="POST">
                    <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I">

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">medicine_name  <span class="text-danger">*</span></label>
                        <input type="text" name="medicine_name" id="medicine_name" class="form-control" value="<?php echo $accountDetails['medicine_name'] ?>">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> category   <span class="text-danger">*</span></label>
                        <input type="text" name="category" id="category" class="form-control" value="<?php echo $accountDetails['category'] ?>">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label">expire_date <span class="text-danger">*</span></label>
                        <input type="text" name="expire_date" id="expire_date" class="form-control" value="<?php echo $accountDetails['expire_date'] ?>">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> Qty   <span class="text-danger">*</span></label>
                        <input type="text" name="qty" id="category" class="form-control" value="<?php echo $accountDetails['qty'] ?>">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> size   <span class="text-danger">*</span></label>
                        <input type="text" name="size" id="category" class="form-control" value="<?php echo $accountDetails['size'] ?>">
                    </div>
                   

                    <div class="form-group mb-3">
                        <button class="btn btn-success" name="update" type="submit">Update</button>
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
