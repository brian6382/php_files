<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
         header("Location: ../index.php");
    }
    include 'includes/DbOperations.php'; 
      $db = new DbOperations;

if(isset($_POST['updtPwd'])) {
    $currentpassword= $_POST['oldpass'];
    $newpassword = $_POST['password'];
    
    $resultUpdatePassword = $db->updatePassword($currentpassword, $newpassword, $_SESSION["username"]);
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

    $id_number = $_SESSION["username"];
    $imageName = $id_number.'.'.$imageFileType;
    $imagePath = $target_dir."/".$imageName;
    // $finalImagePath = "https://bureau.co.ke/".$imagePath;

      // Check extension
    if( in_array($imageFileType, $extensions_arr) ){
        // Upload file
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $imagePath);
      // Insert record

        if ($db->createProfilePic($imageName, $id_number)) {
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
<?php

?>
<html dir="ltr" lang="en">
<head>
     <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/extra-libs/multicheck/multicheck.css">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

    <link href="assets/libs/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
    <link href="assets/extra-libs/calendar/calendar.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/quill/dist/quill.snow.css">
    <link href="assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
    <link href="assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <script src="assets/libs/magnific-popup/meg.init.js"></script>
    <link href="assets/libs/jquery-steps/jquery.steps.css" rel="stylesheet">
    <link href="assets/libs/jquery-steps/steps.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
       
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
        
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Chart-1 -->
            <div class="card">
               <!--  profile picture -->
                <div class="row el-element-overlay" >
                 <div class="col-lg-3 col-md-6" style="margin-left: 400px;">
                        <div class="card">
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1"> <img id='blah' src="profilePhotos/<?php echo $users['profile_pic'];?>" alt="<?php echo $users['username'];?>" />
                                    <div class="el-overlay">
                                        <ul class="list-style-none el-info">
                                            <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="profilePhotos/<?php echo $users['profile_pic'];?>"><i class="mdi mdi-magnify-plus"></i></a></li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <div class="el-card-content">
                                    <h4 class="m-b-0"><?php echo $users['username'];?></h4> <span class="text-muted"><?php echo $users['phone_number'];?></span>
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
                <!-- End Charts -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include 'includes/footer.php'; ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include 'includes/models.php'; ?>
    <script>
        // Basic Example with form
    var form = $("#example-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
    $('#password, #confirm_password').on('keyup', function () {
      if ($('#password').val() == $('#confirm_password').val()) {
        $("#buttonActivate").prop("disabled", false);  // to enable the button
        $('#message').html('Password Matching').css('color', 'green');
      } else {
        $('#message').html('Password Not Matching').css('color', 'red');
        $("#buttonActivate").prop("disabled", true); // to disablethe button
        }
    });        

    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

        $("#validatedCustomFile").change(function() {
        readURL(this);
        });

    </script>
</body>

</html>