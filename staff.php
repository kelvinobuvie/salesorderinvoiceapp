<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$userID = $_SESSION['userID'];

$deptstmt = $conn->prepare('SELECT * FROM departments WHERE departmentStatus = 1 ORDER BY departmentDescription ASC');
$deptstmt->execute();
$deptresult = $deptstmt->fetchAll(PDO::FETCH_OBJ);

$statestmt = $conn->prepare('SELECT * FROM states WHERE stateStatus = 1 ORDER BY stateDescription ASC');
$statestmt->execute();
$stateresult = $statestmt->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sales Order Processing & Invoicing System</title>
    <?php include('header.php'); ?>
    <!-- Google Tag Manager-->
    <script>
      
    </script>
  </head>
  <!-- Body-->
  <body class="handheld-toolbar-enabled">
    <main class="page-wrapper">
      
      <?php include('navbar.php'); ?>

      <!-- Hero section-->
      <section style="background-color:#4E54C8;">
        <div class="container py-2">
          <div class="row justify-content-left">
            <div class="col-lg-12 col-md-12 col-sm-12 text-left">
              <h3 class="text-light">
                <span class='fw-light'>New Staff</span>
              </h3>
            </div>
          </div>
        </div>
      </section>
      <!-- Demos section-->
      <section class="container pt-2 pb-3 pb-lg-5">
        <div class="row pt-2">
        <div class="col-lg-1 col-md-1">
        </div>
          <div class="col-lg-10 col-md-10 col-sm-12">
            <div class="card product-card-alt">
              <div class="card-body text-center">
                <form id="submitstaff" name="submitstaff">
                <table class="table table-bordered table-sm">
                  <tr>
                    <td>STAFF ID</td>
                    <td><input type="text" name="staffID" id="staffID" class="form-control" placeholder="">
                    <span id="staffIDError" class="error"></span>
                    </td>
                    <td>FIRST NAME</td>
                    <td><input type="text" name="firstName" id="firstName" class="form-control" placeholder="">
                    <span id="firstNameError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>OTHER NAMES</td>
                    <td><input type="text" name="otherNames" id="otherNames" class="form-control" placeholder="">
                    <span id="otherNamesError" class="error"></span>
                  </td>
                  <td>LAST NAME</td>
                    <td><input type="text" name="lastName" id="lastName" class="form-control" placeholder="">
                    <span id="lastNameError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>TELEPHONE NUMBER</td>
                    <td><input type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="">
                    <span id="phoneNumberError" class="error"></span>
                  </td>
                  <td>DEPARTMENT</td>
                    <td><select name="department" id="department" class="form-select">
                      <option value="">Select...</option>
                    <?php foreach($deptresult as $deptrow) { ?>
                      <option value="<?php echo $deptrow->departmentID; ?>"><?php echo $deptrow->departmentDescription; ?></option>
                    <?php } ?>
                    </select>
                    <span id="departmentError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>HOME ADDRESS</td>
                    <td colspan="3"><textarea name="homeAddress" id="homeAddress" class="form-control" placeholder=""></textarea>
                    <span id="homeAddressError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>PERMANENT ADDRESS</td>
                    <td colspan="3"><textarea name="permanentAddress" id="permanentAddress" class="form-control" placeholder=""></textarea>
                    <span id="permanentAddressError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>CITY</td>
                    <td><input type="text" name="staffCity" id="staffCity" class="form-control" placeholder=""/>
                    <span id="staffCityError" class="error"></span>
                    </td>
                    <td>STATE</td>
                    <td>
                      <select name="staffState" id="staffState" class="form-select">
                        <option value="">Select...</option>
                        <?php foreach($stateresult as $staterow) { ?>
                        <option value="<?php echo $staterow->stateID; ?>">
                        <?php echo $staterow->stateDescription; ?>
                        </option>
                        <?php } ?>
                      </select>
                      <span id="staffStateError" class="error"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>USERNAME</td>
                    <td><input type="text" name="username" id="username" class="form-control" placeholder="">
                    <span id="usernameError" class="error"></span>
                  </td>
                  <td>PASSWORD</td>
                    <td>
                    <input type="password" name="password" id="password" class="form-control" placeholder="">
                    <span id="passwordError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <button class="btn btn-info">Submit</button>
                      <span id="response" class="error"></span>
                    </td>
                  </tr>
                </table>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
      
    </main> 
    
    <?php include('footer.php'); ?>
<script>
$( document ).ready(function() {

  $(".error").empty();

  //$('#submitcustomer').click(function(e) {
  $("#submitstaff").on('submit',(function(e) {

  e.preventDefault();

  $(".error").empty();

  var staffID = $("#staffID").val();
  var firstName = $("#firstName").val();
  var lastName = $("#lastName").val();
  var phoneNumber = $("#phoneNumber").val();
  var department = $("#department").val();
  var homeAddress = $("#homeAddress").val();
  var permanentAddress = $("#permanentAddress").val();
  var staffCity = $("#staffCity").val();
  var staffState = $("#staffState").val();
  var username = $("#username").val();
  var password = $("#password").val();

  if(staffID === ""){
    $("#staffIDError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff ID is required</div>');
    $('#staffIDError').show();
    return;
  }

  if(firstName === ""){
    $("#firstNameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff firstname is required.</div>');
    $('#firstNameError').show();
    return;
  }

  if(lastName === ""){
    $("#lastNameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff lastname is required.</div>');
    $('#lastNameError').show();
    return;
  }

  if(phoneNumber === ""){
    $("#phoneNumberError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff telephone number is required.</div>');
    $('#phoneNumberError').show();
    return;
  }

  if(department === ""){
    $("#departmentError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff department selection is required.</div>');
    $('#departmentError').show();
    return;
  }

  if(homeAddress === ""){
    $("#homeAddressError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff home address is required.</div>');
    $('#homeAddressError').show();
    return;
  }

  if(permanentAddress === ""){
    $("#permanentAddressError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff permanent address is required.</div>');
    $('#permanentAddressError').show();
    return;
  }

  if(staffCity === ""){
    $("#staffCityError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Staff City is required.</div>');
    $('#staffCityError').show();
    return;
  }

  if(staffState === ""){
    $("#staffStateError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; State selection is required.</div>');
    $('#staffStateError').show();
    return;
  }

  if(username === ""){
    $("#usernameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Username is required.</div>');
    $('#usernameError').show();
    return;
  }

  if(password === ""){
    $("#passwordError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Password is required.</div>');
    $('#passwordError').show();
    return;
  }

  $.ajax({
      url: "staff_post.php",
      method: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      beforeSend:function(){
                        
      },
      success:function(data){
      $('#response').html(data);
      //$('#issuedrecords').html(data);
      }
  });

    
}));
});
</script>
  </body>
</html>