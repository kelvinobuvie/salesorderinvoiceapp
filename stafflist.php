<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}


$statffstmt = $conn->prepare('SELECT * FROM staffs, states, departments WHERE staffs.staffState = states.stateID AND staffs.staffDepartment = departments.departmentID AND staffs.staffStatus = 1 ORDER BY staffs.staffFirstName ASC');
$statffstmt->execute();
$result = $statffstmt->fetchAll(PDO::FETCH_OBJ);

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
                <span class='fw-light'>Staff List</span>
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
              <table class="table table-bordered table-sm" id="stafftable">
              <thead>
              <tr class="table-success">
                <th>SN</th>
                <th>StaffID</th>
                <th>FirstName</th>
                <th>OtherNames</th>
                <th>LastName</th>
                <th>Telephone</th>
                <th>HomeAddress</th>
                <th>Department</th>
                <th>City</th>
                <th>State</th>
              </tr>
              </thead>
              <tbody>
              <?php $s = 0; foreach( $result as $row ) { $s++ ?>
              <tr>
                <td><?php echo $s; ?></td>
                <td><?php echo $row->staffID; ?></td>
                <td><?php echo $row->staffFirstName; ?></td>
                <td><?php echo $row->staffOtherNames; ?></td>
                <td><?php echo $row->staffLastName; ?></td>
                <td><?php echo $row->staffPhoneNumber; ?></td>
                <td><?php echo $row->staffHomeAddress; ?></td>
                <td><?php echo $row->departmentDescription; ?></td>
                <td><?php echo $row->staffCity; ?></td>
                <td><?php echo $row->stateDescription; ?></th>
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
    $('#stafftable').DataTable({
      ordering: true
    });
    } );
    </script>
  </body>
</html>