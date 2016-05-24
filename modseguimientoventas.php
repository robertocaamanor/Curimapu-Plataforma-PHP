<?php
session_start();

if (!isset($_SESSION['email'])) {

    echo "No tienes permiso para entrar a esta pagina";
} else {
    include 'includes/header.php';
    include 'src/functions/dbfunctions.php';

    ini_set("display_errors", 1);
    $id = $_GET['id'];
//$id = '1';
    $conn = connectDB();
    $result = detalleVenta($id, $conn);
    $row = mssql_fetch_array($result);
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $razonsocial = $_POST['razonsocial'];
        $agricultor = $_POST['agricultor'];
//    $especie = $_POST['especie'];
        $fecha = $_POST['fecha'];
        $variedad = $_POST['variedad'];
        $ubicacion = $_POST['ubicacion'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $superficiesiembra = $_POST['superficiesiembra'];
        $intencionsiembra = $_POST['intencionsiembra'];
        $rendimientoanterior = $_POST['rendimientoanterior'];
//    $hibridos = $_POST['hibridos'];
        $hectareasriego = $_POST['hectareasriego'];
        $hectareassecano = $_POST['hectareassecano'];

        if (!$razonsocial) {
            array_push($errors, 'Debe ingresar la razon social');
        }
        if (!$agricultor) {
            array_push($errors, 'Debe ingresar el nombre del agricultor');
        }
//    if (!$especie) {
//        array_push($errors, 'Debe ingresar el nombre de la especie');
//    }
        if (!$fecha) {
            array_push($errors, 'Debe ingresar la fecha');
        }
        if (!$variedad) {
            array_push($errors, 'Debe ingresar el nombre de la variedad');
        }
        if (!$ubicacion) {
            array_push($errors, 'Debe ingresar la ubicación');
        }
        if (!$email) {
            array_push($errors, 'Debe ingresar el email');
        }
        if (!$telefono) {
            array_push($errors, 'Debe ingresar el telefono');
        }
        if (!$superficiesiembra) {
            array_push($errors, 'Debe ingresar la superficie de siembra');
        }
        if (!$intencionsiembra) {
            array_push($errors, 'Debe ingresar la intencion de siembra');
        }
        if (!$rendimientoanterior) {
            array_push($errors, 'Debe ingresar el rendimiento anterior');
        }
        if (!$hibridos) {
            array_push($errors, 'Debe ingresar los hibridos usados en la temporada pasada');
        }
        if (!$hectareasriego) {
            array_push($errors, 'Debe ingresar las hectareas de riego');
        }
        if (!$hectareassecano) {
            array_push($errors, 'Debe ingresar las hectareas de secano');
        }
        if (empty($errors)) {
            //require_once('core/DBManager.php')
            //require_once('core/login.php');
            // $result = checkLogin($user,$pass);
        }
    }
    ?>


    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Seguimiento de ventas</h3>
        </div>
        <div class="panel-body">
            <?php
            if (!empty($errors)) {
                echo '<div class="alert alert-warning alert-dismissible" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                foreach ($errors as $error) {
                    echo $error . '<br />';
                }
                echo '</div>';
            }
            ?>
            <form id="venta" action="updateVentas.php" method="POST">
                <div id="agricultor">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="razonsocial">Razon Social</label>
                                <input type="hidden" name="formularioId" value=" <?= $id; ?>">
                                <input type="hidden" name="agricultorId" value="
                            <?= $row['agricultorid'] ?>"
                                       placeholder="Ingrese razon social">
                                <input type="text" name="razonsocial" class="form-control" value=" <?= $row['razon'] ?>"
                                       placeholder="Ingrese razon social">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="agricultor">Agricultor</label>
                                <input type="text" name="agricultor" class="form-control"
                                       value=" <?= $row['agricultor'] ?>"
                                       placeholder="Ingrese el nombre del agricultor">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <input type="text" name="ubicacion" class="form-control"
                                       value=" <?= $row['ubicacion'] ?>"
                                       placeholder="Ingrese la ubicación">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" class="form-control" value=" <?= $row['email'] ?>"
                                       placeholder="hola@mail.com">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="<?= $row['fono'] ?>"
                                       placeholder="Ingrese el teléfono">
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div><!--div agricultor -->
                <div id="formularioVenta">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="text" name="fecha" class="form-control" placeholder="Ingrese fecha"
                                       value="<?php echo date_format(new DateTime($row['fecha']), "d-m-Y"); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="variedad">Variedad</label>
                                <select name="variedad" class="form-control" size=0>
                                    <?php
                                    $conn = connectDB();
                                    $sql = "select * from Variedad";
                                    $result = query($conn, $sql);
                                    while ($arreglo = mssql_fetch_array($result)) {
                                        $sel = "";
                                        if ($row['variedad_id'] == $arreglo['variedad_id']) $sel = "selected";
                                        ?>
                                        <option
                                            value="<?php echo $arreglo['Variedad_id'] ?>"<?= $sel ?>><?php echo $arreglo['Variedad_nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="superficiesiembra">Superficie sembrado temporada anterior</label>
                                <input type="text" name="superficiesiembra" class="form-control"
                                       value="<?= $row['superficiesiembra'] ?>"
                                       placeholder="Ingrese superficie">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="intencionsiembra">Intención de siembra</label>
                                <input type="text" name="intencionsiembra" class="form-control"
                                       value=" <?= $row['intencionsiembra'] ?>"
                                       placeholder="Ingrese intención de siembra">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="intencionsiembraanterior">Intención de siembra Anterior</label>
                                <input type="text" name="intencionsiembraanterior" class="form-control"
                                       value=" <?= $row['intencionsiembraanterior'] ?>"
                                       placeholder="Ingrese intención de siembra Anterior">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rendimientoanterior">Rendimiento temporada anterior</label>
                                <input type="text" name="rendimientoanterior" class="form-control"
                                       value="<?= $row['rendimiento'] ?>"
                                       placeholder="Ingrese rendimiento">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hibridos">Hibrido(s) usado temporada pasada</label>
                                <input type="text" name="hibridoscuri" class="form-control"
                                       value="<?= $row['hibridoscuri'] ?>"
                                       placeholder="Ingrese Hibridos">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hibridos">Hibrido(s) externo temporada pasada</label>
                                <input type="text" name="hibridosotros" class="form-control"
                                       value="<?= $row['hibridosotros'] ?>"
                                       placeholder="Ingrese Hibridos">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hectareasriego">Hectáreas riego</label>
                                <input type="text" name="hectareasriego" class="form-control"
                                       value="<?= $row['riego'] ?>" placeholder="Ingrese hectáreas riego">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hectareassecano">Hectáreas secano</label>
                                <input type="text" name="hectareassecano" class="form-control"
                                       value=" <?= $row['secano'] ?>" placeholder="Ingrese rendimiento">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comentario">Comentarios</label>
                            <textarea name="comentarios" id="comentario" class="form-control" cols="30"
                                      rows="10"><?= $row['comentario'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Img" />
                            </div>
                        </div>
                    </div>
                </div><!--div formularioVenta -->

                <button id="modificar" class="btn btn-success">Modificar</button>
                <a href="informeventapdf.php?id=<?php echo $id; ?>" class="btn btn-danger">Exportar PDF</a>
            </form>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#agricultor").find("*").attr('disabled', 'disabled');
            $("#formularioVenta").find("*").attr('disabled', 'disabled');

            $('#modificar').click(function () {
                if ($('#modificar').html() == 'Modificar') {
                    $("#formularioVenta").find("*").removeAttr('disabled');
                    $('#modificar').html("Guardar");
                    return false;
                }
            });
        });
    </script>
    <?php
    cerrar($conn);

    include 'includes/footer.php';
}
?>