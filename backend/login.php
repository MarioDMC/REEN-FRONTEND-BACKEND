<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
	 crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="shortcut icon" href="img/unid-ico.ico">
</head>

<body class="text-center">
	<form class="form-signin">
		<img class="mb-4" src="img/logo.png" alt="reen">
		<h1 class="h3 mb-3 font-weight-normal" style='color:white;'>Login</h1>
		<label for="email_users" class="sr-only">Correo Electronico</label>
		<input type="email" id="email_users" class="form-control" placeholder="Correo Electronico" required autofocus>
		<label for="pswd_users" class="sr-only">Contraseña</label>
		<input type="password" id="pswd_users" class="form-control" placeholder="Contraseña" required>
		<div class="checkbox mb-3">
			<label style='color:white;'>
				<input type="checkbox" value="remember-me"> Recuerdame
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="button" id="buttonSign">Iniciar</button>
		<a href="../index.html" class="btn btn-sm btn-success btn-block" style="color: #fff;">FrontEnd</a>
		<div class="mensaje">
			<span class="alert alert-danger" id="error" style='display:none;'></span>
			<span class="alert alert-success" id="success" style='display:none;'></span>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
		<script>
			//$().(); SINTAXIS BASICA JQUERY
			//Pesitos = alias manda a llamar una clase, Usar jQuery cuando estemos utilizando un framework distinto
			//Primer parentesis siempre llevará selectores casi todos llevaran "" excepto unos selectores como document
			//Segundo parentesis llevará el evento se puede llamar una funcion anonima dentro del evento
			//Selector, evento, funcion
			
			$("#buttonSign").click(function () {
				// 1. Obtener el valor del email
				let correo = $("#email_users").val();
				// 2. Obtener el valor del password
				let password = $("#pswd_users").val();
				let obj = {
					"accion": "login",
					"usuario": correo,
					"password": password,
				};
				// 3. Enviar a validar esos valores
				//Tengo evento pero no selector
				$.post("includes/_funciones.php", obj, function (v) {
					// 4. En caso de no ser valido enviar mensaje de error
					if (v == 3) {
						$("#error").html("Campos vacios").fadeIn();
					}
					if (v == 2) {
						$("#error").html("Usuario Inexistente").fadeIn();
					}
					if (v == 0) {
						$("#error").html("Contraseña incorrecta").fadeIn();
						// 5. En caso de ser valido redireccionar a usuarios.php
					}
					if (v == 1) {
						window.location.href = "index.php";
					}
				});
			});
		</script>
	</form>
</body>

</html>