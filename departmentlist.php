<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$deptstmt = $conn->prepare('SELECT * FROM departments WHERE departmentStatus = 1 ORDER BY departmentDescription ASC');
$deptstmt->execute();
$result = $deptstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Department List</span>
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
              <table class="table table-bordered table-sm" id="departmenttable">
              <thead>
              <tr class="table-success">
                <th>SN</th>
                <th>DepartmentName</th>
              </tr>
              </thead>
              <tbody>
              <?php $s = 0; foreach( $result as $row ) { $s++ ?>
              <tr>
                <td><?php echo $s; ?></td>
                <td><?php echo $row->departmentDescription; ?></td>
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
    $('#departmenttable').DataTable({
      ordering: true
    });
    } );
    </script>
  </body>
</html>