<?php 

include_once("_db.php");

switch ($_POST["accion"]) {
	case 'login':
		login();
		break;
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
	case 'carga_foto':
		carga_foto();
		break;

	default:
 
		break;

}

	function login(){
		global $db;
		$mail= $_POST["mail"];
		$pswd = $_POST["password"];

		if (empty($mail) && empty($pswd)) {
		//Ingresa Usuario y Contraseña	
	       echo"4";
	    }  
	    	else if(empty($pswd)) {
	    	//Ingresa un Usuario y contraseña
	      		echo"3";
	    	}
	   			else {

	    $stmt = $db->prepare("SELECT * FROM smoothop_REEN.users where pswd_users =? ");
	    $stmt->execute(array($mail));
		$row_count = $stmt->rowCount();

	   	if ($row_count == 0) {
	   	//Correo no existe
	    	 echo "2";
	    }
		    else {
		    	$stmt = $db->prepare("SELECT * FROM smoothop_REEN.users where pswd_users =? and email_users =? and status_users =?");
		    	$stmt->execute(array($mail, $pswd, 1));
				$row_count = $stmt->rowCount();
					if ($row_count == 0) {
					//Contraseña Incorrecta	
						echo "1";
					}
					else{
					//Acceso Correcto
						echo "0";
						session_start();
	       				error_reporting(0);
	        			$_SESSION['user'] = $mail;
					}
		    	}
		    }
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


 ?>