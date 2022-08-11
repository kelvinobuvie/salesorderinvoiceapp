<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}


if(isset($_GET['invoicenumber'])){
  $ordernumber = filter_var($_GET['invoicenumber'], FILTER_SANITIZE_STRING);
}else{
  header('location: ./invoicelist.php');
}

$orderstmt = $conn->prepare('SELECT *, SUM(salesTotal) AS total FROM salesorder, customers, carriers WHERE salesorder.salesOrderOwner = customers.customerID AND salesorder.salesOrderCarrier = carriers.carrierID AND salesorder.salesOrderStatus = 1 GROUP BY salesorder.salesOrderNumber ORDER BY salesorder.createdDate DESC');
$orderstmt->execute();
$result = $orderstmt->fetch(PDO::FETCH_OBJ);
$results = $orderstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Invoice - <?php echo $result->invoiceNumber; ?></span>
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
              <div class="card-body text-left">
              
              </div>
            </div>
          </div>
        </div>
      </section>
      
    </main> 
    
    <?php include('footer.php'); ?>
    <script>
    $(document).ready( function () {
    $('#customertable').DataTable();
    } );
    </script>
  </body>
</html>