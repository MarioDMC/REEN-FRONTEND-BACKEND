
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>REEN</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
        <link rel="stylesheet" href="css/style.css"/>
        

</head>

<body class="adminbody">

<div id="main">

	<!-- top bar navigation -->
	<div class="headerbar">

 <?php include "includes/_navbar.php" ?>

 <?php include "includes/_sidebar.php" ?>
	

    <div class="content-page">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">

				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>

        <div  style="z-index: 2; position: absolute; display: none;" class="alert alert-danger" id="infoD"></div>
        <div style="z-index: 2; position: absolute; display: none;" class="alert alert-success" id="infoS"></div>

        <div class="btn-toolbar mb-2 mb-md-0">
          <article class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-danger cancelar" id="cancelar" >Cancelar</button>
            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro" >Nuevo</button>
          </article>
        </div>
      </div>

      <div class="table-responsive view" id="show_data" >
        <table class="table table-striped table-sm" id="list_usuarios" class="display">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
    
          </tbody>
        </table>
      </div>
       <div id="insert_data" class="view">
       <form action="#" id="form_data" enctype="multipart/form-data">
  <div class="row">
  <div class="col">
       <div class="form-group">
       <label for="nombre">Nombre</label>
       <input type="text" id="nombre" name="nombre" class="form-control">
     </div>
       <div class="form-group">
        <label for="correo">Correo Electronico</label>
       <input type="email" id="mail" name="mail" class="form-control">
       </div>
       </div>
  <div class="col">
        <div class="form-group">
        <label for="telefono">Teléfono</label>
       <input type="tel" id="telefono" name="telefono" class="form-control">
       </div>
       <div class="form-group">
        <label for="password">Contraseña</label>
       <input type="password" id="password" name="password" class="form-control">
       </div>
     </div>
     </div>
     <div class="row">
       <div class="col">
         <button type="button" class="btn btn-success " id="guardar_datos">Guardar</button>
       </div>
     </div>
     </div>
       </form>
					
            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
<!-- END content-page -->
  
<footer class="footer">
		<span class="text-right">
		Copyright <a target="_blank" href="#">REEN</a>
		</span>
		<span class="float-right">
		Powered by <a target="_blank" href="https://www.smoothoperators.com.mx/REEN"><b>SmoothOp</b></a>
		</span>
	</footer>

</div>

<!-- BEGIN Java Script for this page -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="js/admin.js"></script>
    <script>

  function change_view(vista ='show_data'){
    $("#main").find(".view").each(function() {
      $(this).slideUp('fast');
      let id = $(this).attr("id");
      if (vista == id) {
        $(this).slideDown(300);
      }
      
    });
  }

  function  consultar(){
    let obj = {
      "accion" : "consultar_usuarios"
    };

    $.post('includes/_funciones.php', obj, function(r) {
     let template = ``;
    $.each(r, function(i, e) {
    template += `
            <tr>
              <td>${e.name_users}</td>
              <td>${e.email_users}</td>
              <td>
                <a href="#" data-id="${e.id_users}" class="editar_registro"><i class="fas fa-pen"></i> Editar</a>
              </td>
              <td>
                <a href="#" data-id="${e.id_users}" class="eliminar_registro"><i class="fas fa-user-minus"></i> Eliminar</a>
			  </td>
            </tr>
          `;
    });
    $("#list_usuarios tbody").html(template);
  }, "JSON");
  }

	  
  $("#nuevo_registro").click(function() {
   change_view('insert_data');
   });

  $("#cancelar").click(function() {
   consultar();
   });

  $("#guardar_datos").click(function(r) {
   let nombre = $("#nombre").val();
   let telefono = $("#telefono").val();
   let mail = $("#mail").val();
   let pswd = $("#password").val();
   let obj ={
    "accion" : "insertar_usuarios",
    "nombre" : nombre,
    "telefono" : telefono,
    "mail" : mail,
    "password" : pswd
   }

   $("#form_data").find("input").each(function(){
    $(this).removeClass("has-error");
   if ($(this).val() != "") {
      obj[$(this).prop("name")] = $(this).val();
   }else{
    $(this).addClass("has-error").focus();
    return false;
   }
  });

    if($(this).data("editar") == 1) {
    obj["accion"] = "editar_registro";
    obj["id"] = $(this).data('id');
    $(this).text("Guardar").removeData("editar").removeData("id");
   }

   if (mail == "" || pswd == "" || telefono == "" || nombre == "") {

    $("#infoD").html("Completa Todos los Campos").show().delay(2000).fadeOut(400);

    }else{

   $.post('includes/_funciones.php', obj, function(a) {

    if (a == "1") {
       $("#infoS").html("Usuario Insertado Correctamente").show().delay(2000).fadeOut(400); 
       $("#form_data")[0].reset();
       consultar();
       change_view();

     } else if(a == "0") {
       $("#infoD").html("Error al Insertar Usuario").show().delay(2000).fadeOut(400);
     }
     else if (a == "2") {
       $("#infoS").html("Usuario Editado Correctamente").show().delay(2000).fadeOut(400);
       $("#form_data")[0].reset();
       consultar();
       change_view();
     }
     else if(a == "3") {
       $("#infoD").html("Error al Editar el Usuario").show().delay(2000).fadeOut(400);

     }

   });

   }

});

  $("#list_usuarios").on("click",".eliminar_registro", function(e){
    e.preventDefault();
    let c = confirm('Desea Eliminar Este Registro');
    if (c) {
       let id = $(this).data('id');
       obj = {
        "accion" : "eliminar_registro",
        "id" : id
       };
       $.post('includes/_funciones.php', obj, function(i) {

       if (i == "1") {
       $("#infoS").html("Usuario Eliminado Correctamente").show().delay(2000).fadeOut(400);
       consultar();
     } else {
       $("#infoD").html("Error al Eliminar Usuario").show().delay(2000).fadeOut(400);
      
     }
       });
    }else{
      $("#infoD").html("El Registro No Se a Eliminado").show().delay(2000).fadeOut(400);
      
    }
  });

    $("#list_usuarios").on("click",".editar_registro", function(e){
    e.preventDefault();
    $("#form_data")[0].reset();
    change_view('insert_data');
    let id = $(this).data('id');
    let obj = {
      "accion" : "consultar_registro",
      "id" : id
    }; 

    $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);   
    $.post('includes/_funciones.php', obj, function(r) {
     $("#nombre").val(r.name_users);
     $("#mail").val(r.email_users);
     $("#telefono").val(r.phone_users);
     $("#password").val(r.pswd_users);
  }, "JSON");
  });

  $(document).ready(function(){
    consultar();
    change_view();
  }); 

  $("#main").find(".cancelar").click(function() {
  	consultar();
    change_view();
    $("#form_data")[0].reset();
  });


$("#foto").on("change", function (e){
 let formDatos = new FormData($("#form_data")[0]);
 formDatos.append("accion", "carga_foto");
  $.ajax({
    url: 'includes/_funciones.php',
    type: 'POST',
    data: formDatos,
    contentType: false,
    processData: false,
    success: function(datos) {
      let respuesta = JSON.parse(datos);
      if (respuesta.status == 0){
        alert("No cargó la foto");
      }
  let template = `<img src="${respuesta.archivo}" alt="" class="img-fluid" />`;
  $("#ruta").val(respuesta.archivo);
  $("#preview").html(template);
    }
  });
  });

</script>

</body>
</html>