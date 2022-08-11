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
      <?php include('navbar2.php'); ?>

      <!-- Hero section-->
      <section style="background-color:#4E54C8;">
        <div class="container py-2">
          <div class="row justify-content-left">
            <div class="col-lg-12 col-md-12 col-sm-12 text-left">
              <h3 class="text-light">
                <span class='fw-light'>Login</span>
              </h3>
            </div>
          </div>
        </div>
      </section>
      <!-- Demos section-->
      <section class="container pt-2 pb-3 pb-lg-5">
      <div class="row pt-2">
          <div class="col-lg-4 col-md-4 col-sm-3">
            <div class="card product-card-alt">
              
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="card product-card-alt">
              
              <div class="card-body text-center">
                <h3 class="product-title fs-lg pt-2">
                <form id="loginform" name="loginform">
                <table class="" style="border:none; width:100%;">
                <tr>
                  <td>
                    <p>
                      <img class="img img-responsive" src="img/placeholder.png" alt="" title="" style="width:100px; height:100px;" />
                    </p>
                  </td>
                </tr>
                <tr>
                <td>
                  <p>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" />
                    <span id="usernameError" class="error"></span>
                  </p>
                </td>
                </tr>
                <tr>
                <td>
                  <p>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="off" />
                    <span id="passwordError" class="error"></span>
                  </p>
                </td>
                </tr>
                <tr>
                <td>
                  <center>
                    <p>
                    <input type="submit" name="submit" id="submit" class="form-control btn btn-secondary" value="Login" style="width:50%;" />
                    <span id="response" class="error"></span>
                    </p>
                  </center>
                </td>
                </tr>
                </table>
                </form>
                </h3>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-3">
            <div class="card product-card-alt">
             
            </div>
          </div>
        </div>
      </section>
      
    </main> 
    
    <?php include('footer.php'); ?>
    <script>
    $( document ).ready(function() {
    
    //SUbmit sales order form
    $(".error").empty();
    //$('#submitcustomer').click(function(e) {
    $("#loginform").on('submit',(function(e) {

    e.preventDefault();
    $(".error").empty();

    var username = $("#username").val();
    var password = $("#password").val();

    if(username === ""){
    $("#usernameError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Username is required</div>');
    $('#usernameError').show();
    return;
    }

    if(password === ""){
    $("#passwordError").append('<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Password is required</div>');
    $('#passwordError').show();
    return;
    }

    $.ajax({
      url: "login_post.php",
      method: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      beforeSend:function(){
                        
      },
      success:function(data){
  
        if(data === '1'){
        window.location.replace("./index.php");
        }else{
        $('#response').html(data);
        }
      }
    }); 

    }));

    });
    </script>
  </body>
</html>