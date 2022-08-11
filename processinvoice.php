<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}
 
 $userID = $_SESSION['userID'];

if(isset($_GET['ordernumber'])){
  $ordernumber = filter_var($_GET['ordernumber'], FILTER_SANITIZE_STRING);
}else{
  header('location: ./salesorderlist.php');
}

$custstmt = $conn->prepare('SELECT * FROM salesorder, customers, carriers, staffs WHERE salesorder.salesOrderOwner = customers.customerID AND salesorder.salesOrderCarrier AND salesorder.assignedTo = staffs.userID AND salesorder.salesOrderStatus = 1 AND salesorder.salesOrderNumber = :salesOrderNumber');
$custstmt->bindParam(':salesOrderNumber', $ordernumber, PDO::PARAM_STR);
$custstmt->execute();
$custresult = $custstmt->fetch(PDO::FETCH_OBJ);

$orderstmt = $conn->prepare('SELECT * FROM salesorder, items WHERE salesorder.salesOrderNumber = :salesOrderNumber AND salesorder.itemName = items.itemID AND salesorder.salesOrderStatus = 1');
$orderstmt->bindParam(':salesOrderNumber', $ordernumber, PDO::PARAM_STR);
$orderstmt->execute();
$orderresult = $orderstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Process Order Number - <?php echo $custresult->salesOrderNumber; ?></span>
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
                <form name="processinvoice" id="processinvoice">
                  <table class="table table-bordered table-sm">
                    <tbody>
                    <tr>
                      <td style="font-weight:bold;">CUSTOMER NAME</td>
                      <td>
                        <?php echo strtoupper($custresult->customerName); ?>
                        <input type="hidden" class="form-control" name="ordernumber" id="ordernumber" value="<?php echo $custresult->salesOrderNumber; ?>">
                      </td>
                      <td style="font-weight:bold;">ORDER DESCRIPTION</td>
                      <td>
                      <?php echo strtoupper($custresult->salesOrderDescription); ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">CUSTOMER TELEPHONE</td>
                      <td>
                      <?php echo $custresult->customerPhoneNumber; ?>
                        </td>
                      <td style="font-weight:bold;">PURCHASE ORDER NUMBER</td>
                      <td>
                      <?php echo $custresult->purchaseOrderNumber; ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">CONTACT NAME</td>
                      <td>
                      <?php echo $custresult->contactName; ?>
                        </td>
                      <td style="font-weight:bold;">DUE DATE</td>
                      <td>
                      <?php echo $custresult->dueDate; ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">COURIER/DELIVERY</td>
                      <td>
                      <?php echo $custresult->carrierDescription; ?>
                      </td>
                      <td style="font-weight:bold;">ASSIGNED TO</td>
                      <td>
                      <?php echo $custresult->staffFirstName ." ". $custresult->staffLastName; ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">BILLING ADDRESS</td>
                      <td>
                      <?php echo $custresult->billingAddress; ?>
                      </td>
                      <td style="font-weight:bold;">SHIPPING ADDRESS</td>
                      <td>
                      <?php echo $custresult->shippingAddress; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      <table class="table table-condensed table-bordered" id="tblData">
                        <thead>
                          <th>SN</th>
                          <th>ITEM DESCRIPTION</th>
                          <th>QUANTITY</th>
                          <th>UNIT PRICE</th>
                          <th>TOTAL</th>
                        </thead>
                        <tbody>
                          <?php 
                          $i = 0;
                          $total = 0;
                          foreach($orderresult as $orderrow){
                            $i++; 
                            $total += $orderrow->salesTotal;
                          ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $orderrow->itemDescription; ?></td>
                          <td><?php echo $orderrow->itemQuantity; ?></td>
                          <td><?php echo $orderrow->itemUnitPrice; ?></td>
                          <td><?php echo number_format($orderrow->salesTotal,2); ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">SALES TOTAL</td>
                      <td>
                        <?php echo number_format($total,2); ?>
                      </td>
                      <td style="font-weight:bold;">ADJUSTMENT</td>
                      <td>
                      <?php echo $custresult->salesAdjustment; ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">SALES COMMISSION</td>
                      <td>
                      <?php echo $custresult->salesCommission; ?>
                      </td>
                      <td style="font-weight:bold;">SALES TAX</td>
                      <td>
                      <?php echo $custresult->salesOrderTax; ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight:bold;">ADDITIONAL INFORMATION</td>
                      <td colspan="3">
                      <?php echo $custresult->additionalInformation; ?>
                      </td>
                    </tr>
                    <tr>
                    <td colspan="4">
                      <button class="btn btn-info">Process</button>
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

//$('#submitcustomer').click(function(e) {
$("#processinvoice").on('submit',(function(e) {

  e.preventDefault();

  var ordernumber = $("#ordernumber").val();
   
  if(ordernumber === ""){
    $("#reponse").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Invalid order number, cannot process invoice!</div>');
    $('#response').show();
    return;
  }


  $.ajax({
      url: "processinvoice_post.php",
      method: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      beforeSend:function(){
                        
      },
      success:function(data){
      if(data === '1'){
        window.location.replace("./invoicelist.php");
      }else{
        $('#response').html(data);
      }
      //$('#issuedrecords').html(data);
      }
  });

    
}));
});
</script>
  </body>
</html>