<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}


$customerstmt = $conn->prepare('SELECT * FROM customers WHERE customerStatus = 1 ORDER BY customerName ASC');
$customerstmt->execute();
$result = $customerstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Customers List</span>
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
              <table class="table table-bordered table-sm" id="customertable">
              <thead>
              <tr class="table-success">
                <th>SN</th>
                <th>CustomerName</th>
                <th>ContactName</th>
                <th>ContactNumber</th>
                <th>BillingAddress</th>
                <th>MailingAddress</th>
                <th>City</th>
                <th>State</th>
              </tr>
              </thead>
              <tbody>
              <?php $s = 0; foreach( $result as $row ) { $s++ ?>
              <tr>
                <td><?php echo $s; ?></td>
                <td><?php echo $row->customerName; ?></td>
                <td><?php echo $row->customerContactName; ?></td>
                <td><?php echo $row->customerContactNumber; ?></td>
                <td><?php echo $row->billingAddress; ?></td>
                <td><?php echo $row->shippingAddress; ?></td>
                <td><?php echo $row->customerCity; ?></td>
                <td><?php echo $row->customerState; ?></th>
              </tr>
              <?php } ?>
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
    $('#customertable').DataTable({
      ordering: true
    });
    } );
    </script>
  </body>
</html>