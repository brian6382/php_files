<?php 
session_start();
require 'includes/DbOperations.php';
$db = new DbOperations; 

if (!isset($_SESSION['full_name'])) {
      header("Location: ../index");
}
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$floors = $db->getAllFloor();
$units = $db->getAllUnits();
$years = $db->getYears();
$months = $db->getMonths();
$success = "none";
$type = 'Rented';
$floor_no = '';
$unit_no = '';
$month_id = '';
$xyear = date('Y');
$rent = '0.00';
$water_bill = '0.00';
$electric_bill = '0.00';
$gas_bill = '0.00';
$security_bill = '0.00';
$utility_bill = '0.00';
$other_bill = '0.00';
$total_rent = '0.00';
$issue_date = '';
$branch_id = '';
// $title = $_data['add_new_rent'];
// $button_text = $_data['save_button_text'];
// $successful_msg = $_data['added_rent_successfully'];
// $form_url = WEB_URL . "fair/addfair.php";
$id="";
$hdnid="0";

//new
$reneted_name = '';
$rid = 0;
$success_message = '';  
if (isset($_POST['saveAndClose'])) {
    $tenantDetails = $db->geTenantDetailsById($_POST['tenant_id']);
  
   
  $sql = "INSERT INTO tbl_add_bill(bill_type, bill_date, bill_month, bill_year, total_amount, deposit_bank_name, bill_details, branch_id) values('$_POST[ddlBillType]','$_POST[txtBillDate]',0,'$xyear','$_POST[txtTotalAmount]','Equity Bank','$_POST[txtBillDetails]',0)";

    if(mysqli_query($link, $sql)) {
      header("Location: bill_list");

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
                <h5 class="card-header">Add Maintenance</h5>
                <div class="card-body">
                  <form method="post">
                    <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I">
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Bill Type <span class="text-danger">*</span></label>
                        <select name="ddlBillType" class="form-control">
                          <?php 
                          $billType = $db->getBillType();
                            foreach ($billType as $bill) {
                              ?>
                                <option value="<?php echo  $bill['bt_id']?>"><?php echo  $bill['bill_type']?></option>
                              <?php
                            }
                          ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Total Amount<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="number" name="txtTotalAmount" placeholder="Enter Amount :" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Details<span class="text-danger">*</span></label>
                        <textarea name="txtBillDetails" placeholder="Enter Details :" required class="form-control"></textarea>
                    </div>
                 <!--    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">NID(National ID) <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="national_id" placeholder="Add ID :" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Email<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="email" placeholder="Add Email :" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Contact <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="contact" placeholder="Add Contact :" required class="form-control">
                    </div> -->
                   

                  <!--   <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Advance Rent<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="number" name="advance" placeholder="Add Advance Rent :" required class="form-control">
                    </div>
 -->
                     <!-- <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Deposit<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="number" name="deposit" placeholder="Add Deposit :" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Rent Per Month<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="number" name="rent" placeholder="Add Rent Per Month :" required class="form-control">
                    </div> -->

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Bill Date<span class="text-danger">*</span></label>
                        <input id="inputTitle" type="date" name="txtBillDate" placeholder="Add Bill Date" required class="form-control">
                    </div>

                    
<!-- 
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Rent Year <span class="text-danger">*</span></label>
                        <select name="rent_year" class="form-control">
                          </?php 
                            foreach ($years as $year) {
                              ?>
                                <option value="</?php echo  $year['y_id']?>"></?php echo  $year['xyear']?></option>
                              </?php
                            }
                          ?>
                        </select>
                    </div> -->

                    <div class="form-group mb-3">
                      <button type="reset" class="btn btn-warning">Reset</button>
                       <button class="btn btn-success" name="saveAndClose" type="submit">Save & Close</button>
                        <button class="btn btn-success" name="regsister" type="submit">Save & Continue</button>
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
