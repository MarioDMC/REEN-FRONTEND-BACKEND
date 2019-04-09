<?php 

include_once("_db.php");

switch ($_POST["accion"]) {
	case 'consultar_usuarios':
		consultar_usuarios();
		break;
	case 'insertar_usuarios':
		insertar_usuarios();
		break;
	case 'eliminar_registro':
		eliminar_usuarios($registro= $_POST["id"]);
		break;	
	case 'editar_registro':
		editar_registro($registro= $_POST["id"]);
		break;	
	case 'consultar_registro':
		consultar_registro($registro= $_POST["id"]);
		break;

//WORKS
	case 'login':
		login();
		break;
	case 'consultar_works';
		consultar_works();
		break;
	case 'insertar_works';
		insertar_works();
		break;
	case 'editar_works';
		editar_works($_POST['id']);
		break;
	case 'editar_registrow';
		editar_registrow($_POST['id']);
		break;
	case 'eliminar_works';
		eliminar_works($_POST['id']);
		break;
	case 'carga_foto':
		carga_foto();
		break;

//WORKS
	case 'consultar_works';
		consultar_works();
		break;
	case 'insertar_works';
		insertar_works();
		break;
	case 'editar_works';
		editar_works($_POST['id']);
		break;
	case 'editar_registrow';
		editar_registrow($_POST['id']);
		break;
	case 'eliminar_works';
		eliminar_works($_POST['id']);
		break;

	default:
 
		break;

}

	function consultar_usuarios(){
	 	global $db;
	 	$query = "SELECT * FROM smoothop_REEN.users";
    	$array = [];
    	foreach($db->query($query) as $fila){
			array_push($array, $fila);
					}
    	echo json_encode($array);
	 }

	function eliminar_usuarios($id){
	 	global $db;
	 	$query = "DELETE FROM smoothop_REEN.users WHERE id_users =?";
	 	$stmt = $db->prepare($query);
    	$stmt->execute(array($id));
    	$row_count = $stmt->rowCount();
				if ($row_count == 1) {
					echo "1";
				}
				else{
					echo "0";
				}
	 }


	function insertar_usuarios(){
		$nombre= $_POST["nombre"];
		$tel= $_POST["telefono"];
		$mail = $_POST["mail"];
		$pswd = $_POST["password"];
		 	global $db;
		 	$stmt = $db->prepare("INSERT INTO smoothop_REEN.users (id_users, name_users, pswd_users, email_users, phone_users, status_users)  VALUES ('',?,?,?,?,'1')");
		 	$stmt->execute(array($nombre, $pswd, $mail, $tel));
		 	$affected_rows = $stmt->rowCount();
		 	if ($affected_rows > 0) {
		 		echo "1";
		 	} else {
		 		echo"0";
		 	}

		 }

	function editar_registro($id){
	 	$nombre= $_POST["nombre"];
		$tel= $_POST["telefono"];
		$mail = $_POST["mail"];
		$pswd = $_POST["password"];
	 global $db;
	 	$stmt = $db->prepare("UPDATE smoothop_REEN.users SET name_users =?, pswd_users =?, email_users =?, phone_users =? WHERE id_users =? ");
	 	$stmt->execute(array($nombre, $pswd, $mail, $tel, $id));
	 	$affected_rows = $stmt->rowCount();
	 	if ($affected_rows > 0) {
	 		echo "2";
	 	} else {
	 		echo"3";
	 	}
	 }

 	function consultar_registro($id){
	 	global $db;
	 	$query = "SELECT * FROM smoothop_REEN.users WHERE id_users =? LIMIT 1";
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($id));
    	$fila = $stmt->fetch(PDO::FETCH_ASSOC);
    	echo json_encode($fila);
	 }

//EMPIEZA WORKS/////////////////////////////////////////////////////////////////
	 function login(){
		//Conectar a la BD
		global $mysqli;
		$email = $_POST["usuario"];
		$pass = $_POST["password"];
		//Si el usuario y pass están vacios imprimir 3
		if (empty($email) && empty($pass)) {
			echo "3";
		//Si no están vacios consultar a la bd que el usuario exista.
		}else {
			$sql = "SELECT * FROM users WHERE email_users = '$email'";
			$rsl = $mysqli->query($sql);
			$row = $rsl->fetch_assoc();
			//Si el usuario no existe, imprimir 2
			if ($row == 0) {
				echo "2";
			//Si hay resultados verificar datos
			}else{
				$sql = "SELECT * FROM users WHERE email_users = '$email' AND pswd_users = '$pass'";
				$rsl = $mysqli->query($sql);
				$row = $rsl->fetch_assoc();
				//Si el password no es correcto, imprimir 0
				if ($row["pswd_users"] != $pass) {
					echo "0";
				//Si el usuario es correcto, imprimir 1
				}elseif ($email == $row["email_users"] && $pass == $row["pswd_users"]) {
					echo "1";
					session_start();
					error_reporting(0);
					$_SESSION['usuario'] = $email;
				}
			}
		} 	
	}

	 function consultar_works(){
		global $mysqli;
		$consulta = "SELECT * FROM works";
		$resultado = mysqli_query($mysqli,$consulta);
		$arreglo = [];
		while($fila = mysqli_fetch_array($resultado)){
			array_push($arreglo, $fila);
		}
		echo json_encode($arreglo); //Imprime el JSON ENCODEADO
	}
	function insertar_works(){
		global $mysqli;
		$pname_work = $_POST['pname_work'];
		$description_work = $_POST['description_work'];
		$img_work = $_POST['img_work'];

		$status = $_POST['status'];

		if ($pname_work == "") {
			echo "Llena el campo Project Name";
		}elseif ($description_work == "") {
			echo "Llena el campo Description";

		}elseif ($img_work == ""){
			echo "Llena el campo Imagen";
		}elseif ($status == "nada") {
			echo "Seleccione el status";
		}else{
		$consulta = "INSERT INTO works VALUES ('','$pname_work','$description_work','$img_work','$status')";

		$resultado = mysqli_query($mysqli,$consulta);
		echo "Se inserto el work en la BD ";
		}
	}
	
	function eliminar_works($id){
		global $mysqli;
		$consulta = "DELETE FROM works WHERE id_work = $id";
		$resultado = mysqli_query($mysqli,$consulta);
		if ($resultado) {
			echo "Se elimino correctamente";
		}else{
			echo "Se genero un error, intenta nuevamente";
		}
		
	}
	function editar_registrow($id){
		global $mysqli;
		$consulta = "SELECT * FROM works WHERE id_work = '$id'";
		$resultado = mysqli_query($mysqli,$consulta);
		
		$fila = mysqli_fetch_array($resultado);
		echo json_encode($fila);
	}
	
	function editar_works($id){
		global $mysqli;
		$pname_work = $_POST['pname_work'];
		$description_work = $_POST['description_work'];
		$img_work = $_POST['img_work'];

		$status = $_POST['status'];


		if ($pname_work == "") {
			echo "Llene el campo Project name";
		}elseif ($description_work == "") {
			echo "Llene el campo Description";
		}elseif ($img_work == "") {
			echo "Llene el campo Img";

		}elseif ($status == "nada") {
			echo "Seleccione el status";
		}else{
		echo "Se edito el work correctamente";
		$consulta = "UPDATE works SET pname_work = '$pname_work', description_work = '$description_work', img_work = '$img_work', status = '$status' WHERE id_work = '$id'";

		$resultado = mysqli_query($mysqli,$consulta);
		
			}
	}


	function carga_foto(){
		if (isset($_FILES["foto"])) {
			$file = $_FILES["foto"];
			$nombre = $_FILES["foto"]["name"];
			$temporal = $_FILES["foto"]["tmp_name"];
			$tipo = $_FILES["foto"]["type"];
			$tam = $_FILES["foto"]["size"];
			$dir = "../img/";
			$respuesta = [
				"archivo" => "img/white-logo.png",
				"status" => 0
			];
			if(move_uploaded_file($temporal, $dir.$nombre)){
				$respuesta["archivo"] = "img/".$nombre;
				$respuesta["status"] = 1;
			}
			echo json_encode($respuesta);
		}
	}


	 //TERMINA WORKS



 ?>