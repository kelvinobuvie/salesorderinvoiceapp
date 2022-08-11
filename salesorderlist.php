<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$userID = $_SESSION['userID'];

$orderstmt = $conn->prepare('SELECT *, SUM(salesTotal) AS total FROM salesorder, customers, carriers WHERE salesorder.salesOrderOwner = customers.customerID AND salesorder.salesOrderCarrier = carriers.carrierID AND salesorder.assignedTo = :assignedto AND salesorder.salesOrderStatus = 1 GROUP BY salesorder.salesOrderNumber ORDER BY salesorder.createdDate DESC');
$orderstmt->bindParam(':assignedto', $userID, PDO::PARAM_INT);
$orderstmt->execute();
$result = $orderstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Sales Order List</span>
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
              <table class="table table-bordered" id="customertable">
              <thead>
              <tr class="table-success">
                <th>SN</th>
                <th>ORDER NUMBER</th>
                <th>PURCHASE ORDER NUMBER</th>
                <th>CUSTOMER</th>
                <th>SALES DESCRIPTION</th>
                <th>CONTACT NAME</th>
                <th>CONTACT PHONE</th>
                <th>DUE DATE</th>
                <th>CARRIER</th>
                <th>SALES TOTAL</th>
              </tr>
              </thead>
              <tbody>
              <?php 
                $s = 0; 
                foreach( $result as $row ) { 
                $s++;
                if(empty($row->invoiceNumber)){
              ?>
              <tr>
                <td><?php echo $s; ?></td>
                <td><a href="./processinvoice.php?ordernumber=<?php echo $row->salesOrderNumber; ?>" title="Click to view more"><?php echo $row->salesOrderNumber; ?></a></td>
                <td><?php echo $row->purchaseOrderNumber; ?></td>
                <td><?php echo strtoupper($row->customerName); ?></td>
                <td><?php echo $row->salesOrderDescription; ?></td>
                <td><?php echo $row->contactName; ?></td>
                <td><?php echo $row->customerPhoneNumber; ?></td>
                <td><?php echo $row->dueDate; ?></td>
                <td><?php echo $row->carrierDescription; ?></td>
                <td><?php echo number_format($row->total,2); ?></td>
              </tr>
              <?php } } ?>
              </tbody>
              </table>
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