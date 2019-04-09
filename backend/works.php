<?php
    session_start();
    error_reporting(0);
    $varsesion = $_SESSION['usuario'];
    if (isset($varsesion)){
?>
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
        <h1 class="h2">Latest Works</h1>

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
        <table class="table table-striped table-sm" id="list-works" class="display">
          <thead>
            <tr>
                <th>Project Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
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
            <label for="pname">Project Name</label>
            <input type="text" id="pname_work" name="pname" class="form-control">
        </div>
       <div class="form-group">
            <label for="description">Descripción</label>
            <input type="text" id="description_work" name="description" class="form-control">
        </div>
       
       <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="nada">Seleccione Status</option>
                <option value="top">top</option>
                <option value="bot">bot</option>
            </select>
        </div>
        </div>
  <div class="col">
        <div class="form-group">
            <label for="img">Imagen</label>
            <input type="file" name="foto" id="foto">
            <input type="hidden" readonly="readonly" name="ruta" id="ruta">
            <div id="preview"></div>
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
function change_view(vista = 'show_data') {
            $("#main").find(".view").each(function () {
                // $(this).addClass("d-none");
                $(this).slideUp('fast');
                let id = $(this).attr("id");
                if (vista == id) {
                    $(this).slideDown(300);
                    // $(this).removeClass("d-none");
                }
            });
        }
function consultar() {
            let obj = {
                "accion": "consultar_works"
            };
            $.post("includes/_funciones.php", obj, function (respuesta) {
                let template = ``;
                $.each(respuesta, function (i, e) {
                    template +=
                        `
          <tr>
          <td>${e.pname_work}</td>
          <td>${e.description_work}</td>
          <td><img src="${e.img_work}" class="img-thumbnail" width="100" height="100"/></td>
          <td>${e.status}</td>

          <td>
                <a href="#" data-id="${e.id_work}" class="editar_registro"><i class="fas fa-pen"></i> Editar</a>
          </td>
          <td>
                <a href="#" data-id="${e.id_work}" class="eliminar_registro"><i class="fas fa-user-minus"></i> Eliminar</a>
          </td>
          </tr>
          `;
                });
                $("#list-works tbody").html(template);
            }, "JSON");
        }
        $(document).ready(function () {
            consultar();
            change_view();
        });
        $("#nuevo_registro").click(function () {
            change_view('insert_data');
            $("#guardar_datos").text("Guardar").data("editar", 0);
            $("#preview").html("");
            $('#ruta').attr('value', '');
            $("#form_data")[0].reset();
        });
        $("#guardar_datos").click(function () {
            let pname_work = $('#pname_work').val();
            let description_work = $('#description_work').val();
            let img_work = $('#ruta').val();
            let status = $('#status').val();
            let obj = {
                "accion": "insertar_works",
                "pname_work": pname_work,
                "description_work": description_work,
                "img_work": img_work,
                "status" : status
            };
            $("#form_data").find("input").each(function () {
                $(this).removeClass("has-error");
                if ($(this).val() != "") {
                    obj[$(this).prop("name")] = $(this).val();
                } else {
                    $(this).addClass("has-error").focus();
                    return false;
                }
            });
            if ($(this).data("editar") == 1) {
                obj["accion"] = "editar_works";
                obj["id"] = $(this).data("id");
                $(this).text("Guardar").data("editar", 0);
                $("#form_data")[0].reset();
            }
            $.post("includes/_funciones.php", obj, function (respuesta) {
                alert(respuesta);
                if (respuesta == "Se inserto el work en la BD ") {
                    change_view();
                    consultar();
                }
                if (respuesta == "Se edito el work correctamente") {
                    change_view();
                    consultar();
                }
            });
        });
        //EDITAR
        $('#list-works').on("click", ".editar_registro", function (e) {
            e.preventDefault();
            let id = $(this).data('id'),
                obj = {
                    "accion": "editar_registrow",
                    "id": id
                };
            $("#form_data")[0].reset();
            change_view('insert_data');
            $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);
            $.post("includes/_funciones.php", obj, function (r) {
                $("#pname_work").val(r.pname_work);
                $("#description_work").val(r.description_work);
                $("#status").val(r.status);
                let template =
                    `
                    <img src="${r.img_work}" class="img-thumbnail" width="200" height="200"/>
                    `;
                $("#ruta").val(r.img_work);
                $("#preview").html(template);
            }, "JSON");
        });
        /* Eliminar */
        $("#main").on("click", ".eliminar_registro", function (e) {
            e.preventDefault();
            let confirmacion = confirm('¿Desea eliminar este registro?');
            if (confirmacion) {
                let id = $(this).data('id'),
                    obj = {
                        "accion": "eliminar_works",
                        "id": id
                    };
                $.post("includes/_funciones.php", obj, function (respuesta) {
                    alert(respuesta);
                    consultar();
                });
            } else {
                alert('El registro no se ha eliminado intente nuevamente');
            }
        });
        //FOTO
        $("#foto").on("change", function (e) {
            let formDatos = new FormData($("#form_data")[0]);
            formDatos.append("accion", "carga_foto");
            $.ajax({
                url: "includes/_funciones.php",
                type: "POST",
                data: formDatos,
                contentType: false,
                processData: false,
                success: function (datos) {
                    let respuesta = JSON.parse(datos);
                    if (respuesta.status == 0) {
                        alert("no se cargo la foto xd");
                    }
                    let template =
                        `
                    <img src="${respuesta.archivo}" class="img-thumbnail" width="200" height="200"/>
                    `;
                    $("#ruta").val(respuesta.archivo);
                    $("#preview").html(template);
                }
            });
        });
        $("#main").find(".cancelar").click(function () {
            change_view();
            $("#form_data")[0].reset();
            $("#preview").html("");
            if ($("#guardar_datos").data("editar") == 1) {
                $("#guardar_datos").text("Guardar").data("editar", 0);
                consultar();
            }
        });

 

</script>

</body>
</html>
<?php
    }else{
        header("Location:login.php");
    }
?>