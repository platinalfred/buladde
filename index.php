
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buladde Financial Services</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
<style>
.lg{
	margin-bottom:20px;
}
#login_message{
	
}
</style>

  <body class="login">
    <div>
     
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
			<div class="col-md-12 center_col"><img style="width:80%;" src="img/logo.png"></div>
            <form method="post" action="login_script.php" id="login_form" name="login_form">
              <h1><i class="fa fa-unlock-alt"></i>&nbsp;&nbsp;&nbsp; Login </h1>
				<div class="col-md-12" id="login_message"></div>
              <div class="lg">
                <input  type="text" name="username" class="form-control needed" placeholder="Username" required />
              </div>
              <div class="lg">
                <input  type="password" name="password" class="form-control needed" placeholder="Password" required />
              </div>
              <div class="lg">
				 <a class="reset_pass" href="#">Lost your password?</a>
                <a class="btn btn-default submit loginbtn" id="login-submit">Log in</a>
               
              </div>
              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1 style="margin-bottom: 6px;"> Buladde Financial Services</h1>
                  <p>© <?php echo date("Y"); ?> All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
    <!-- jQuery -->
<script src="vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
	function highlightFields(){
		$(":input").filter('.needed').each(function(){
			if($.trim(($(this).val()))==''){
				$(this).addClass('highlight');
			}else{
				$(this).removeClass('highlight');
				$("#login_message").html("");
			}
		});
	}
	function submitLogin(formData, method, action){
		if($('.highlight').size() == 0){
			$.ajax({
				type: method,
				url: "login_script.php",
				data: formData,
				success: function(response){
					if(response.trim() != "success"){
						$("#login_message").html('<div class="alert alert-warning alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-info-circle"></i> '+response+'</div>');
						setTimeout(function(){
							$("#login_message").html("");
						}, 8888000);
					}else{
						window.location = "dashboard.php";
					}
				}
			});
		}else{
			$("#login_message").html('<div class="alert alert-warning alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-info-circle"></i> Please enter your Username/Password.</div>');
			setTimeout(function(){
				$("#login_message").html("");
				
			}, 5000);
		}
	}
	$(':input').keypress(function (e) {
		highlightFields();
		var formData = $(this).closest('form').serializeArray();
		var method = $(this).closest('form').attr("method");
		var action = $(this).closest('form').attr("action");
		if(e.which == 13) {
			submitLogin(formData, method, action);
		}
	});
	$(":input").keydown(function(){
		$(this).removeClass('highlight');
	});
	$("#login-submit").click(function(){
		highlightFields();
		var formData = $(this).closest('form').serializeArray();
		var method = $(this).closest('form').attr("method");
		var action = $(this).closest('form').attr("action");
		
		submitLogin(formData, method, action);
		return false
		
	})
</script>