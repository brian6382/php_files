<?php  
  session_start();
  require 'includes/DbOperations.php';
  $db = new DbOperations; 

    // define('DB_HOST', 'localhost');
    // define('DB_USER', 'root');
    // define('DB_PASSWORD', '');
    // define('DB_NAME', 'ams_mb');

  $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $tenants = $db->getAllTenants();

  if (!isset($_SESSION['full_name'])) {
      header("Location: ../index");
  } 
  $success_message = '';  
  if (isset($_POST['saveAndClose'])) {
    //$tenantDetails = $db->geTenantDetailsById($_POST['tenant_id']);
  
   
  $sql="INSERT INTO `tbl_deposits`(`deposit_amount`) VALUES ('$_POST[deposit_amount]')"; 

    if(mysqli_query($link, $sql)) {
      header("Location: deposit_setup");

    }

    mysqli_close($link);
   
    // $result = $db->addTenant($tenant_name, $email, $contact, $address, $national_id, $floor_no, $unit_no, $advance, $deposit, $rent, $issue_date, $r_gone_date, $r_password, $image, $status, $rent_month, $rent_year, $branch_id); 

  

    // if ($result == USER_CREATED) {
    //      header("Location: unitlist"); 
    // } elseif ($result == USER_FAILURE) {
    //    $success_message = '<div class="alert alert-primary" role="alert">
    //              Something went wrong...please try again later!
    //             </div>'; 
    // }elseif ($result == USER_EXISTS) {
    //      $success_message = '<div class="alert alert-secondary" role="alert">
    //                   This Unit already exists
    //                 </div>'; 
    // }

}
  if (isset($_POST['deleteOwner'])) {
    # code...
    $id = $_POST['id'];

    if ($db->deleteOwner($id)) {
        ?>
          <script>
            alert('Owner deleted successfully');
            window.location.href = 'owner-table';
          </script>
        <?php
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

  <title>Apartment Manager - Unit List</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                <h5 class="card-header">Deposit Setup</h5>
                <div class="card-body">
                  <form method="post">
                    <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I">

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Deposit Amount<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="deposit_amount" placeholder="Enter Amount :" required class="form-control">
                    </div>         
                    <div style="float: right;" class="form-group mb-3">
                      <button type="reset" class="btn btn-warning">Reset</button>
                       <button class="btn btn-success" name="saveAndClose" type="submit">Save information</button>
                    </div>
                  </form>
                  <?php 
                    if (isset($success_message)) {
                      echo $success_message;
                    }
                  ?>
                </div>
            </div><br>

          <!-- Page Heading -->
          <!-- <h1 class="h3 mb-2 text-gray-800">Vehicle Owners</h1>
          <p class="mb-4">List of all Lankana Sacco Vehicle owners.</p> -->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary float-left"> Deposit</h6>
              <!-- <a href="addbill" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Bill</a> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Deposit Amount</th>
                      <th>Action</th>
                     
                    </tr>
                  </thead>
                      
                      <?php  
                        $result = mysqli_query($link,"Select * from tbl_deposits order by id asc");
                        while($row = mysqli_fetch_array($result)){
                          //$floor = $db->getFlooById($unit['floor_no']);
                          // $tenantDetails = $db->geTenantDetailsById($row['rid']);
                          // $month = $db->getMonthDetail($row['month_id']);
                         // $bill = $db->getBillTypeById($row['bill_type']);
                          ?>
                          <tbody>
                            <tr>
                              <td><?php echo $row['id'] ?></td>
                              <td><?php echo $row['deposit_amount']; ?></td>
                              
                            
                      
                              <td>
                                  <a href="update-floor" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                              <form method="POST">
                                <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I"> 
                                <input type="hidden" name="id" value="<?php echo $floor['added_date'] ?>">                          
                                <button class="btn btn-danger btn-sm dltBtn" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" name="deleteOwner" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                  </form>
                              </td>
                            </tr>
                          </tbody>
                          <?
                        }

                      ?>
                  
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Deposit Amount</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
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
            <span>Copyright &copy; Your Website 2020</span>
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

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Delete" below if you want to delete this owner... this action is irreversible.</div>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/jqzoom.js"></script>
</body>

</html>
