<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Works</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/unid-ico.ico">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Works</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="includes/log_out.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid padd">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios.php">
                                Usuarios
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link active" href="works.php">
                                Works
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Works</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro">Nuevo</button>
                        </div>
                    </div>
                </div>
                <h2>Works</h2>
                <div class="table-responsive view" id="show_data">
                    <table class="table table-striped table-sm" id="list-works">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>


                <div id="insert_data" class="view">
                    <form action="#" id="form_data">
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
                                <button type="button" class="btn btn-success" id="guardar_datos">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
          <td>
          <a href="#" data-id="${e.id_work}" class="editar_registro">Editar</a>
          <a href="#" data-id="${e.id_work}" class="eliminar_registro">Eliminar</a>
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
            let obj = {
                "accion": "insertar_works",
                "pname_work": pname_work,
                "description_work": description_work,
                "img_work": img_work
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
            let confirmacion = confirm('Desea eliminar este registro?');
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