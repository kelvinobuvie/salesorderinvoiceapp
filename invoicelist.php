<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
 header('Location: login.php');
}
$userID = $_SESSION['userID'];

$invoicestmt = $conn->prepare('SELECT *, SUM(salesTotal) AS total FROM salesorder, customers, staffs WHERE salesorder.salesOrderOwner = customers.customerID AND salesorder.assignedTo = staffs.userID AND salesorder.salesOrderStatus = 1 GROUP BY salesorder.salesOrderNumber ORDER BY salesorder.invoiceNumber DESC');
$invoicestmt->execute();
$result = $invoicestmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Invoice List</span>
              </h3>
            </div>
          </div>
        </div>
      </section>
      <!-- Demos section-->
      <section class="container-fluid">
        <div class="row pt-2">
          <div class="col-lg-12 col-md-12 col-sm-12" style="background-color: #fff;">
      
              <table class="table table-bordered table-sm" id="carriertable">
              <thead>
              <tr class="table-success">
                <th>SN</th>
                <th>Invoice Number</th>
                <th>Created Date</th>
                <th>Due Date</th>
                <th>Sales Order Number</th>
                <th>Order Description</th>
                <th>Customer Name</th>
                <th>Total</th>
                <th>Adjustment</th>
                <th>Tax</th>
                <th>Prepared By</th>
                <th>Shipping Address</th>
              </tr>
              </thead>
              <tbody>
              <?php 
              $s = 0; 
              foreach( $result as $row ) { 
              $s++; 
              if(!empty($row->invoiceNumber)){
              ?>
              <tr>
                <td><?php echo $s; ?></td>
                <td>
                <a href="./makepdf.php?invoicenumber=<?php echo $row->invoiceNumber; ?>" title="<?php echo "Download " . $row->invoiceNumber; ?>" target="_blank">
                <button class="btn btn-success">
                  <?php echo $row->invoiceNumber; ?>
                </button>
                </a>
                </td>
                <td><?php echo $row->createdDate; ?></td>
                <td><?php echo $row->dueDate; ?></td>
                <td><?php echo $row->salesOrderNumber; ?></td>
                <td><?php echo $row->salesOrderDescription; ?></td>
                <td><?php echo $row->customerName; ?></td>
                <td><?php echo $row->total; ?></td>
                <td><?php echo $row->salesAdjustment; ?></td>
                <td><?php echo $row->salesOrderTax; ?></td>
                <td><?php echo $row->staffFirstName . " " . $row->staffLastName; ?></td>
                <td><?php echo $row->shippingAddress; ?></td>
              </tr>
              <?php } } ?>
              </tbody>
              </table>
              
          </>
        </div>
      </section>
      
    </main> 
    
    <?php include('footer.php'); ?>
    <script>
    $(document).ready( function () {
    $('#carriertable').DataTable({
      ordering: true
    });
    } );
    </script>
  </body>
</html>