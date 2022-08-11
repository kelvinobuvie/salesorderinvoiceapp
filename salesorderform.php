<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$userID = $_SESSION['userID'];

$custstmt = $conn->prepare('SELECT * FROM customers WHERE customerStatus = 1 ORDER BY customerName ASC');
$custstmt->execute();
$custresult = $custstmt->fetchAll(PDO::FETCH_OBJ);

$carrierstmt = $conn->prepare('SELECT * FROM carriers WHERE carrierStatus = 1 ORDER BY carrierDescription ASC');
$carrierstmt->execute();
$carrierresult = $carrierstmt->fetchAll(PDO::FETCH_OBJ);

$staffstmt = $conn->prepare('SELECT * FROM staffs WHERE staffStatus = 1 ORDER BY staffLastName ASC');
$staffstmt->execute();
$staffresult = $staffstmt->fetchAll(PDO::FETCH_OBJ);

$itemstmt = $conn->prepare('SELECT * FROM items WHERE itemStatus = 1 ORDER BY itemDescription ASC');
$itemstmt->execute();
$itemresult = $itemstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>New Order</span>
              </h3>
            </div>
          </div>
        </div>
      </section>
      <!-- Demos section-->
      <section class="container pt-2 pb-3 pb-lg-5">
        <div class="row pt-2">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card product-card-alt">
              <div class="card-body text-center">
                <form name="salesform" id="salesform">
                  <table class="table table-bordered table-sm">
                    <tbody>
                    <tr>
                      <td>CUSTOMER NAME</td>
                      <td>
                        <select name="customerName" id="customerName" class="form-select">
                        <option value="">Select...</option>
                        <?php foreach($custresult as $custrow) { ?>
                        <option value="<?php echo $custrow->customerID ;?>"><?php echo strtoupper($custrow->customerName) ;?></option>
                        <?php } ?>
                        </select>
                        <span id="customerNameError" class="error"></span>
                      </td>
                      <td>ORDER DESCRIPTION</td>
                      <td>
                        <textarea name="salesOrderDescription" id="salesOrderDescription" class="form-control"></textarea>
                        <span id="salesOrderDescriptionError" class="error"></span>
                      </td>
                    </tr>
                    <tr>
                      <td>CUSTOMER TELEPHONE</td>
                      <td>
                        <input type="text" name="customerTelephone" id="customerTelephone" class="form-control" readonly>
                        
                        </td>
                      <td>PURCHASE ORDER NUMBER</td>
                      <td>
                      <input type="text" name="purchaseOrderNumber" id="purchaseOrderNumber" class="form-control"/>
                      <span id="purchaseOrderNumberError" class="error"></span>
                      </td>
                    </tr>
                    <tr>
                      <td>CONTACT NAME</td>
                      <td>
                        <input type="text" name="contactName" id="contactName" class="form-control" readonly>
                        </td>
                      <td>DUE DATE</td>
                      <td>
                      <input type="text" name="dueDate" id="dueDate" class="form-control" readonly/>
                      <span id="dueDateError" class="error"></span>
                      </td>
                    </tr>
                    <tr>
                      <td>COURIER/DELIVERY</td>
                      <td>
                        <select name="salesOrderCarrier" id="salesOrderCarrier" class="form-select">
                        <option value="">Select...</option>
                        <?php foreach($carrierresult as $carrierrow) { ?>
                        <option value="<?php echo $carrierrow->carrierID; ?>"><?php echo $carrierrow->carrierDescription; ?></option>
                        <?php } ?>
                        </select>
                        <span id="salesOrderCarrierError" class="error"></span>
                        </td>
                      <td>ASSIGNED TO</td>
                      <td>
                      <select name="assignedTo" id="assignedTo" class="form-select">
                        <option value="">Select...</option>
                        <?php foreach($staffresult as $staffrow) { ?>
                        <option value="<?php echo $staffrow->userID; ?>">
                        <?php echo strtoupper($staffrow->staffLastName) . " " . 
                        strtoupper($staffrow->staffOtherNames) . " " . 
                        strtoupper($staffrow->staffFirstName); ?></option>
                        <?php } ?>
                      </select>
                      <span id="assignedToError" class="error"></span>
                      </td>
                    </tr>
                    <tr>
                      <td>BILLING ADDRESS</td>
                      <td>
                      <textarea name="billingAddress" id="billingAddress" class="form-control" readonly></textarea>
                      </td>
                      <td>SHIPPING ADDRESS</td>
                      <td>
                        <textarea name="shippingAddress" id="shippingAddress" class="form-control" readonly></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      <table class="table table-condensed table-sm" id="tblValue" style="text-align:left;">
                      <tr>
                        <td>ITEM DESCRIPTION
                          <select name="itemDescription" id="itemDescription" class="form-select">
                            <option value="">Select item...</option>
                            <?php foreach($itemresult as $itemrow) { ?>
                            <option value="<?php echo $itemrow->itemID; ?>">
                            <?php echo $itemrow->itemDescription; ?>
                            </option>
                            <?php } ?>
                          </select>
                          <input type="hidden" name="itemDesc" id="itemDesc" class="form-control">
                        </td>
                        <td>ITEM QUANTITY
                          <input type="text" name="itemQuantity" id="itemQuantity" class="form-control">
                        </td>
                        <td>UNIT PRICE
                          <input type="text" name="unitPrice" id="unitPrice" class="form-control" readonly>
                        </td>
                        <td>
                          <button class="btn btn-secondary mt-4" name="add-item" id="add-item">Add Item</button>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4">
                        <span id="itemsSelection" class="error"></span>
                        </td>
                      </tr>
                      </table>
                      <table class="table table-condensed table-bordered" id="tblData">
                        <thead>
                          <th>SN</th>
                          <th>ITEM DESCRIPTION</th>
                          <th>QUANTITY</th>
                          <th>UNIT PRICE</th>
                          <th>DELETE</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                      </table>
                      </td>
                    </tr>
                    <tr>
                      <td>SALES TOTAL</td>
                      <td>
                        <input type="text" name="salesTotal" id="salesTotal" class="form-control" readonly>
                        <span id="salesTotalError" class="error"></span>
                      </td>
                      <td>ADJUSTMENT</td>
                      <td>
                      <input type="text" name="salesAdjustment" id="salesAdjustment" class="form-control"/>
                      </td>
                    </tr>
                    <tr>
                      <td>SALES COMMISSION</td>
                      <td>
                      <input type="text" name="salesCommission" id="salesCommission" class="form-control"/>
                      </td>
                      <td>SALES TAX</td>
                      <td>
                        <input type="text" name="salesTax" id="salesTax" class="form-control"/>
                        <span id="salesTaxError" class="error"></span>
                      </td>
                    </tr>
                    <tr>
                      <td>ADDITIONAL INFORMATION</td>
                      <td colspan="3">
                        <textarea name="additionalInformation" id="additionalInformation" class="form-control"></textarea>
                      </td>
                    </tr>
                    <tr>
                    <td colspan="4">
                      <button class="btn btn-info">Submit</button>
                      <span id="response" class="error"></span>
                    </td>
                    </tr>
                    </tbody>
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

        $("#dueDate").datepicker({
          dateFormat: "dd-mm-yy",
          selectOtherMonths: true,
          prevText: "<<<",
          nextText: ">>>"
        });


        $('#customerName').change(function(event){

          event.preventDefault();
          var customerID = $('#customerName').val();
          
          if(customerID === ''){
            alert("Kindly select a customer");
            return;
          }

            $.ajax({
                  type: "POST",
                  url: "customer_fetch_post.php",
                  data: {"customerID":customerID}, // serializes the form
                  success: function(data)
                  { 
                    
                    if(data === '0'){
                      $("span#response").text = ('<div id="response" class="btn btn-info btn-md" style="width:30%;">There was a problem executing the query.</div>');
                    }else if(data === '1'){
                      $("span#response").text = ('<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to fetch record, kindly contact your administrator.</div>');
                    }else{
                      var record = JSON.parse(data);
                      $('#customerTelephone').val(record[0]['customerContactNumber']);
                      $('#contactName').val(record[0]['customerContactName']);
                      $('#billingAddress').val(record[0]['billingAddress']);
                      $('#shippingAddress').val(record[0]['shippingAddress']);
                    }
                  }
            });
          
          });  


          
        $('#itemDescription').change(function(event){

          event.preventDefault();
          
          var itemDescription = $('#itemDescription').val();
          
          if(itemDescription === ''){
            alert("Kindly select an Item");
            return;
          }

            $.ajax({
                  type: "POST",
                  url: "item_fetch_post.php",
                  data: {"itemDescription":itemDescription}, // serializes the form
                  success: function(data)
                  { 
                    
                    if(data === '0'){
                      $("span#response").text = ('<div id="response" class="btn btn-info btn-md" style="width:30%;">There was a problem executing the query.</div>');
                    }else if(data === '1'){
                      $("span#response").text = ('<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to fetch record, kindly contact your administrator.</div>');
                    }else{
                     
                      var record = JSON.parse(data);

                      $('#unitPrice').val(record['itemUnitPrice']);
                      $('#itemDesc').val(record['itemDescription']);
                    }
                  }
            });
          
          }); 

    
    
        var emptyRow = "<tr><td colspan='5' class='text-center'>No Records Available</td></tr>";
        var newvalue = 0;
        $('#salesTotal').val("");
        $('#salesAdjustment').val("");
        $('#salesCommission').val("");
        $('#salesTax').val("");
        $('#additionalInformation').val("");

        $("#tblData tbody").append(emptyRow); //Adding empty row on your page load

        //Add Sales Item to sales order
        $("#add-item").click(function(e){
          e.preventDefault();
          var itemDescription = $("#itemDescription").val().trim();
          var itemDesc = $("#itemDesc").val().trim();
          var itemQuantity = $("#itemQuantity").val().trim();
          var unitPrice = $("#unitPrice").val().trim();
          var sumtotal = itemQuantity * unitPrice;

          if(itemDescription != "" && itemQuantity != "" && unitPrice != ""){ //Validation

            if($("#tblData tbody").children().children().length == 1){
              $("#tblData tbody").html("");
            }

            var srNo = $("#tblData tbody").children().length + 1;
            //creating dynamic HTML string
            var dynamicTr = "<tr>" + 
            "<td>" + srNo + "</td>" + 
            "<td><input type='hidden' class='form-control' name='arritemDescription[]' id='arritemDescription[]' value='"+itemDescription+"' readonly>" + itemDesc + "</td>" + 
            "<td><input type='hidden' class='form-control' name='arritemQuantity[]' id='arritemQuantity[]' value='"+itemQuantity+"' readonly>" + itemQuantity + "</td>" + 
            "<td><input type='hidden' class='form-control' name='arrunitPrice[]' id='arrunitPrice[]' value='"+unitPrice+"' readonly>" + unitPrice + "<input type='hidden' name='sumtotal' id='sumtotal' class='salestotalfield' value='"+sumtotal+"'></td>" + 
            "<td><button class='btn btn-danger btn-sm'>X</button></td>" + 
            "</tr>";

            $("#tblData tbody").append(dynamicTr); //appending dynamic string to table tbody
            $("#itemQuantity").val("");
            $("#unitPrice").val("");
            //$("#txtMobile").val("");

            //Sum up the value of the individual fields and add to the Total Sales Field
            var sum = 0;
            $('.salestotalfield').each(function() {
                sum = sum + parseInt($(this).val()); // Or parseFloat if you are going to allow floating point numbers.
            });
            $('#salesTotal').val(sum.toFixed(2));


            //registering function for delete button
            $(".btn-sm").click(function(e){ 
              //e.preventDefault();
              $(this).parent().parent().remove();

            //Remove the value of the deleted row from total sales field
            var sum = 0;
            $('.salestotalfield').each(function() {
                sum = sum + parseInt($(this).val()); // Or parseFloat if you are going to allow floating point numbers.
            });
            $('#salesTotal').val(sum.toFixed(2));


              if($("#tblData tbody").children().children().length == 0){
                $("#tblData tbody").append(emptyRow);
              }
            });


          }else{
            alert("Please provide values as expected!");
          }
        });


  //SUbmit sales order form
  $(".error").empty();
  //$('#submitcustomer').click(function(e) {
  $("#salesform").on('submit',(function(e) {
  e.preventDefault();
  $(".error").empty();
  
  
  var customerName = $("#customerName").val();
  var salesOrderDescription = $("#salesOrderDescription").val();
  var purchaseOrderNumber = $("#purchaseOrderNumber").val();
  var dueDate = $("#dueDate").val();
  var salesOrderCarrier = $("#salesOrderCarrier").val();
  var assignedTo = $("#assignedTo").val();
  var salesTotal = $("#salesTotal").val();
  var salesTax = $('#salesTax').val();
  

  if(customerName === ""){
    $("#customerNameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Customer selection is required</div>');
    $('#customerNameError').show();
    return;
  }

  if(salesOrderDescription === ""){
    $("#salesOrderDescriptionError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Order description is required</div>');
    $('#salesOrderDescriptionError').show();
    return;
  }

  if(purchaseOrderNumber === ""){
    $("#purchaseOrderNumberError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Purchase order number is required</div>');
    $('#purchaseOrderNumberError').show();
    return;
  }

  if(dueDate === ""){
    $("#dueDateError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Due date selection is required</div>');
    $('#dueDateError').show();
    return;
  }

  if(salesOrderCarrier === ""){
    $("#salesOrderCarrierError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Courier/Delivery selection is required</div>');
    $('#salesOrderCarrierError').show();
    return;
  }

  if(assignedTo === ""){
    $("#assignedToError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Sales person selection is required</div>');
    $('#assignedToError').show();
    return;
  }

  if(salesTotal === ""){
    $("#salesTotalError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Sales total amount is required</div>');
    $('#salesTotalError').show();
    return;
  }

  if(salesTax === ""){
    $("#salesTaxError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Sales tax amount is required</div>');
    $('#salesTaxError').show();
    return;
  }

  $.ajax({
      url: "salesorderform_post.php",
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