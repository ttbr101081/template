<!doctype html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<section class="ftco-section">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
						<div class="icon d-flex align-items-center justify-content-center">
							<span class="fa fa-user-o"></span>
						</div>
						<h3 class="text-center mb-4">Iniciar Sesion</h3>
						<form action="#" class="login-form" method="POST">
							<div class="form-group">
								<input type="text" name="cedula" id="cedula" class="form-control rounded-left" placeholder="Cedula" required>
							</div>
							<div class="form-group d-flex">
								<input type="password" name="password" id="password" class="form-control rounded-left" placeholder="Contraseña" required>
							</div>
							<div class="form-group d-md-flex">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Ingresar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<?php
		require "data/conex.php";
		
		session_start();
		if(isset($_POST['cedula']) && isset($_POST['password'])){
			$cedula = $_POST['cedula'];
			$password = $_POST['password'];
			$_SESSION['cedu'] = $cedula;
			if($cedula=='' && $password==''){
				echo '<script language="javascript">alert("Debe ingresar los datos requeridos");window.location.href="login.php"</script>';
			}else{
				$sql = "SELECT * FROM empleado where cedula = '$cedula' and password = '$password'";
				$r = mysqli_query($l, $sql);
				$n = mysqli_num_rows($r);
				if($n==1){
					$resultado = $r -> fetch_assoc();
					if($resultado["rol"]==1){
						echo '<script language="javascript">alert("Comprobacion existosa");window.location.href="index.php"</script>';
					}else{
						echo '<script language="javascript">alert("Comprobacion existosa");window.location.href="crear.php"</script>';
					}
				}
			}
		}
	?>

</body>

</html>