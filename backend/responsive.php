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
        <h1 class="h2">Responsive</h1>

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
        <table class="table table-striped table-sm" id="list-responsive" class="display">
          <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Texto</th>
                <th>Imagen</th>
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
            <label for="titulo_resposive">Titulo</label>
            <input type="text" id="titulo_responsive" name="titulo_responsive" class="form-control">
        </div>
       <div class="form-group">
            <label for="texto_responsive">Texto</label>
            <input type="text" id="texto_responsive" name="texto_responsive" class="form-control">
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
                "accion": "consultar_responsive"
            };
            $.post("includes/_funciones.php", obj, function (respuesta) {
                let template = ``;
                $.each(respuesta, function (i, e) {
                    template +=
                        `
          <tr>

          <td>${e.id_responsive}</td>
          <td>${e.titulo_responsive}</td>
          <td>${e.texto_responsive}</td>
          <td><img src="${e.img_responsive}" class="img-thumbnail" width="100" height="100"/></td>

          <td>
                <a href="#" data-id="${e.id_responsive}" class="editar_registro"><i class="fas fa-pen"></i> Editar</a>
          </td>
          <td>
                <a href="#" data-id="${e.id_responsive}" class="eliminar_registro"><i class="fas fa-user-minus"></i> Eliminar</a>

          </td>
          </tr>
          `;
                });
                $("#list-responsive tbody").html(template);
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
            let titulo_responsive = $('#titulo_responsive').val();
            let texto_responsive = $('#texto_responsive').val();
            let img_responsive = $('#ruta').val();

            let obj = {
                "accion": "insertar_responsive",
                "titulo_responsive": titulo_responsive,
                "texto_responsive": texto_responsive,

                "img_responsive": img_responsive,

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
                obj["accion"] = "editar_responsive";
                obj["id"] = $(this).data("id");
                $(this).text("Guardar").data("editar", 0);
                $("#form_data")[0].reset();
            }
            $.post("includes/_funciones.php", obj, function (respuesta) {
                alert(respuesta);
                if (respuesta == "Se inserto el responsive en la BD ") {
                    change_view();
                    consultar();
                }
                if (respuesta == "Se edito el responsive correctamente") {
                    change_view();
                    consultar();
                }
            });
        });
        //EDITAR
        $('#list-responsive').on("click", ".editar_registro", function (e) {
            e.preventDefault();
            let id = $(this).data('id'),
                obj = {
                    "accion": "editar_registroww",
                    "id": id
                };
            $("#form_data")[0].reset();
            change_view('insert_data');
            $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);
            $.post("includes/_funciones.php", obj, function (r) {
                $("#titulo_responsive").val(r.titulo_responsive);
                $("#texto_responsive").val(r.texto_responsive);

                let template =
                    `
                    <img src="${r.img_responsive}" class="img-thumbnail" width="200" height="200"/>
                    `;
                $("#ruta").val(r.img_responsive);
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
                        "accion": "eliminar_responsive",
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

