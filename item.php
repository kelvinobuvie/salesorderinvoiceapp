<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

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
                <span class='fw-light'>New Item</span>
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
                <form id="submititem" name="submititem">
                <table class="table table-bordered table-sm">
                  <tr>
                    <td>ITEM DESCRIPTION</td>
                    <td><textarea name="itemDescription" id="itemDescription" class="form-control"></textarea>
                    <span id="itemDescriptionError" class="error"></span>
                    </td>
                    <td>UNIT PRICE</td>
                    <td><input type="text" name="unitPrice" id="unitPrice" class="form-control" placeholder="">
                    <span id="unitPriceError" class="error"></span>
                  </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <button name="submititem2" id="submititem2" class="btn btn-info">Submit</button>
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
$("#submititem").on('submit',(function(e) {

  e.preventDefault();

  $(".error").empty();

  var itemDescription = $("#itemDescription").val();
  var unitPrice = $("#unitPrice").val();


  if(itemDescription === ""){
    $("#itemDescriptionError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Item description is required</div>');
    $('#itemDescriptionError').show();
    return;
  }

  if(unitPrice === ""){
    $("#unitPriceError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Item unit price is required.</div>');
    $('#unitPriceError').show();
    return;
  }


  $.ajax({
      url: "item_post.php",
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