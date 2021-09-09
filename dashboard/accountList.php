<?php  
  session_start();
  require 'includes/DbOperations.php';
  $db = new DbOperations; 
  $accounts = $db->getAllMedicine();

  if (!isset($_SESSION['full_name'])) {
      header("Location: ../index");
  } 
  if (isset($_POST['deleteMedicine'])) {
    # code...
    $dose_id = $_POST['dose_id'];

    if ($db->deleteMedicine($dose_id)) {
        ?>
          <script>
            alert('Medicine deleted successfully');
            window.location.href = 'accountList';
          </script>
        <?php
    }
  }

  if (isset($_POST['updateStatusDetails'])) {
    # code...
    $dose_id = $_POST['dose_id'];
    $status =  "Verifired";

    if ($db->updateStatusDetails($status, $dose_id)) {
        ?>
          <script>
            alert('Medicine verifired  successfully');
            window.location.href = 'accountList';
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

  <title>Lankana Sacco - Owners</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

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

          <!-- Page Heading -->
          <!-- <h1 class="h3 mb-2 text-gray-800">Vehicle Owners</h1>
          <p class="mb-4">List of all Lankana Sacco Vehicle owners.</p> -->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary float-left">Accounts</h6>
              <a href="addAccount" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Account</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Medicine Name </th>
                      <th>Category  </th>
                      <th>Expire Date </th>
                      <th>Qty </th>
                      <th>SIZE </th>
                      <th>Status </th>
                      <th class="text-center">Action</th>
                     
                    </tr>
                  </thead>
                      
                      <?php  
                        foreach ($accounts as $account) {
                          ?>
                          <tbody>
                            <tr>
                              <td><?php echo $account['dose_id'] ?></td>
                              <td><?php echo $account['medicine_name']; ?></td>
                              <td><?php echo $account['category'] ?></td>
                              <td><?php echo $account['expire_date'] ?></td>
                              <td><?php echo $account['qty'] ?></td>
                              <td><?php echo $account['size'] ?></td>
                             <?php if ($account['status']== "Verifired") {
                               ?>

                              <td>
                                <form method="POST">
                                <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I"> 
                                <input type="hidden" name="dose_id" value="<?php echo $account['dose_id'] ?>">                          
                                <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" name="updateStatusDetails" title="Click Here To verifired all recived medicine "><?php echo $account['status'] ?></button>
                                  </form>
                              </td>
                               <?php 
                             }else{
                                ?>
                               
                              <td>
                                <form method="POST">
                                <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I"> 
                                <input type="hidden" name="dose_id" value="<?php echo $account['dose_id'] ?>">                          
                                <button class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" name="updateStatusDetails" title="Click Here To verifired all recived medicine "><?php echo $account['status'] ?></button>
                                  </form>
                              </td>
                               <?php
                             }

                              ?>
                              <td>
                                  <a href="edit_account?dose_id=<?php echo $account['dose_id'] ?>" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                              <form method="POST">
                                <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I"> 
                                <input type="hidden" name="dose_id" value="<?php echo $account['dose_id'] ?>">                          
                                <button class="btn btn-danger btn-sm dltBtn" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" name="deleteMedicine" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                  </form>
                              </td>
                            </tr>
                          </tbody>
                          <?
                        }

                      ?>
                  
                  <tfoot>
                    <tr>
                      <th>No.</th>
                      <th>Medicine Name</th>
                      <th>Category  </th>
                      <th>Expire Date</th>
                      <th>Qty </th>
                      <th>SIZE </th>
                      <th>Status </th>
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

  <!-- DataTables  & Plugins -->
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugin/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugin/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugin/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugin/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugin/jszip/jszip.min.js"></script>
<script src="plugin/pdfmake/pdfmake.min.js"></script>
<script src="plugin/pdfmake/vfs_fonts.js"></script>
<script src="plugin/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugin/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugin/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/jqzoom.js"></script>

  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>

</html>
