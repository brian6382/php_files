<?php 
session_start();
require 'includes/DbOperations.php';
$db = new DbOperations; 

if (!isset($_SESSION['full_name'])) {
      header("Location: ../index");
}

 // $users = $db->getAdminByPhone($full_name);
  

if(isset($_POST['updtPwd'])) {
    $currentpassword= $_POST['oldpass'];
    $newpassword = $_POST['password'];
    
    $resultUpdatePassword = $db->updatePassword($currentpassword, $newpassword, $_SESSION["full_name"]);
        if ($resultUpdatePassword == PASSWORD_CHANGED) {
           ?>
                <script>
                    alert('Password updated successfully');
                    window.location.href = 'index.php';
                </script> 
            <?php
            // $success_message_2 = 'Password updated successfully'; 
        } elseif ($resultUpdatePassword == PASSWORD_DO_NOT_MATCH) {
             //$success_message_2 = 'please provide a valid credential'; 
             ?>
                <script>
                    alert('please provide a valid credential');
                    window.location.href = 'prof.php';
                </script> 
            <?php
        } elseif ($resultUpdatePassword ==PASSWORD_NOT_CHANGED) {
           // $success_message_2 = 'Something went wrong please try again later!!!'; 
            ?>
                <script>
                    alert('Something went wrong please try again later!!!');
                    window.location.href = 'prof.php';
                </script> 
            <?php
        } 
}
if (isset($_POST['changeProfile'])) {
    $profilePic = $_FILES['profile_pic']['name'];
    $target_dir = "profilePhotos/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);

     // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

     // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png");

    $email_address = $_SESSION["full_name"];
    $imageName = $email_address.'.'.$imageFileType;
    $imagePath = $target_dir."/".$imageName;
    // $finalImagePath = "https://bureau.co.ke/".$imagePath;

      // Check extension
    if( in_array($imageFileType, $extensions_arr) ){
        // Upload file
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $imagePath);
      // Insert record

        if ($db->createProfilePic($imageName, $email_address)) {
             ?>
                <script>
                    alert('Profile Changed Successfully');
                </script>
             <? 
        } else {
             $success_message = '<div class="text-danger">Something Went Wrong</div>'; 
        }     

    } else {
        ?>
            <script>
                alert('Wrong file type');
            </script>
        <?php
         $success_message = 'Wrong file type'; 
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

  <title>SB Admin 2 - Tables</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include("includes/aside.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
       
          <!-- Topbar Navbar -->
          <?php include("includes/header.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="card">
               <!--  profile picture -->
                <div class="row el-element-overlay" >
                 <div class="col-lg-3 col-md-6" style="margin-left: 400px;">
                        <div class="card">
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1"> <img id='blah' src="profilePhotos/<?php echo $users['profile_pic'];?>" alt="<?php echo $users['full_name'];?>" />
                                    <div class="el-overlay">
                                        <ul class="list-style-none el-info">
                                            <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="profilePhotos/<?php echo $users['profile_photo'];?>"><i class="mdi mdi-magnify-plus"></i></a></li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <div class="el-card-content">
                                    <h4 class="m-b-0"><?php echo $users['full_name'];?></h4> <span class="text-muted"><?php echo $users['phone_number'];?></span>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row" style="padding-left: 400px;">
                        <label class="col-md-3">Profile Picture</label>
                        <div class="col-md-9">
                            <div class="custom-file">
                                <input type="file" name="profile_pic" class="custom-file-input" id="validatedCustomFile" required>
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                 <div class="border-top">
                                    <div class="card-body">
                                        <button name="changeProfile" type="submit" class="btn btn-primary">Change Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    </div>  
                  <!--   end of profile picture -->    
                 <div class="row" style="margin-left: 10px;">
                    <form id="example-form" action="#" method="POST" class="m-t-40">
                         <h3>Password Change</h3>
                                <section>
                                    <label for="old">Old Password *</label>
                                    <input id="oldpass" name="oldpass" type="password" class="required form-control">
                                    <label for="password">Password *</label>
                                    <input name="password" id="password" type="password" class="required form-control">
                                    <label for="confirm">Confirm Password *</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="required form-control">
                                    <p> <span id='message'></span></p>
                                     <?php  
                                         if(isset($success_message_2))  
                                         {  
                                              echo $success_message_2;  
                                         }  
                                         ?> 
                                </section>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button name="updtPwd" type="submit" disabled="true" id="buttonActivate" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                    </form>
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
          <a class="btn btn-primary" href="login.html">Logout</a>
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

</body>

</html>
