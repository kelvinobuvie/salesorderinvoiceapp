<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}


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
                <span class='fw-light'>New Customer</span>
              </h3>
            </div>
          </div>
        </div>
      </section>
      <!-- Demos section-->
      <section class="container pt-2 pb-3 pb-lg-5">
        <div class="row pt-2">
        <div class="col-lg-2 col-md-2">
        </div>
          <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card product-card-alt">
              <div class="card-body text-center">
                <form id="submitcustomer" name="submitcustomer">
                <table class="table table-bordered table-sm">
                  <tr>
                    <td>CUSTOMER NAME</td>
                    <td><input type="text" name="customerName" id="customerName" class="form-control" placeholder="">
                    <span id="customerNameError" class="error"></span>
                    </td>
                    <td>CONTACT NAME</td>
                    <td><input type="text" name="contactName" id="contactName" class="form-control" placeholder="">
                    <span id="contactNameError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>CONTACT TELEPHONE</td>
                    <td colspan="3"><textarea name="contactTelephone" id="contactTelephone" class="form-control" placeholder=""></textarea>
                    <span id="contactTelephoneError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>BILLING ADDRESS</td>
                    <td colspan="3"><textarea name="billingAddress" id="billingAddress" class="form-control" placeholder=""></textarea>
                    <span id="billingAddressError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>SHIPPING ADDRESS</td>
                    <td colspan="3"><textarea name="shippingAddress" id="shippingAddress" class="form-control" placeholder=""></textarea>
                    <span id="shippingAddressError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td>CITY</td>
                    <td><input type="text" name="customerCity" id="customerCity" class="form-control" placeholder=""/>
                    <span id="customerCityError" class="error"></span>
                    </td>
                    <td>STATE</td>
                    <td>
                      <select name="customerState" id="customerState" class="form-select">
                        <option value="">Select...</option>
                        <?php foreach($stateresult as $staterow) { ?>
                        <option value="<?php echo $staterow->stateID; ?>">
                        <?php echo $staterow->stateDescription; ?>
                        </option>
                        <?php } ?>
                      </select>
                      <span id="customerStateError" class="error"></span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <button name="submitcustomer" id="submitcustomer" class="btn btn-info">Submit</button>
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
$("#submitcustomer").on('submit',(function(e) {

  e.preventDefault();

  $(".error").empty();

  var customerName = $("#customerName").val();
  var contactName = $("#contactName").val();
  var contactTelephone = $("#contactTelephone").val();
  var billingAddress = $("#billingAddress").val();
  var shippingAddress = $("#shippingAddress").val();
  var customerCity = $("#customerCity").val();
  var customerState = $("#customerState").val();

  if(customerName === ""){
    $("#customerNameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Customer name is required</div>');
    $('#customerNameError').show();
    return;
  }

  if(contactName === ""){
    $("#contactNameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Contact name is required.</div>');
    $('#contactNameError').show();
    return;
  }

  if(contactTelephone === ""){
    $("#contactTelephoneError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Contact telephone number is required.</div>');
    $('#contactTelephoneError').show();
    return;
  }

  if(billingAddress === ""){
    $("#billingAddressError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Billing address is required.</div>');
    $('#billingAddressError').show();
    return;
  }

  if(shippingAddress === ""){
    $("#shippingAddressError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Shipping address is required.</div>');
    $('#shippingAddressError').show();
    return;
  }

  if(customerCity === ""){
    $("#customerCityError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; City is required.</div>');
    $('#customerCityError').show();
    return;
  }

  if(customerState === ""){
    $("#customerStateError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; State is required.</div>');
    $('#customerStateError').show();
    return;
  }

  $.ajax({
      url: "customer_post.php",
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