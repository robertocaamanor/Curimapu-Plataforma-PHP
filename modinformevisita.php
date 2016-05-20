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
    $result = detalleVisita($id, $conn);
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
        $estadocrecimiento = $_POST['estadocrecimiento'];
        $enfermedadesbacteriales = $_POST['enfermedadesbacteriales'];
        $cultivo = $_POST['malezas'];
        $humedad = $_POST['humedad'];
        $plantaspormetro = $_POST['plantaspormetro'];
        $enfermedadesfungosas = $_POST['enfermedadesfungosas'];
        $insectos = $_POST['insectos'];
        $observaciones = $_POST['observaciones'];
        $recomendaciones = $_POST['recomendaciones'];

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
        if (!$estadocrecimiento) {
            array_push($errors, 'Debe ingresar el estado de crecimiento');
        }
        if (!$enfermedadesbacteriales) {
            array_push($errors, 'Debe ingresar enfermedades bacteriales');
        }
        if (!$enfermedadesfungosas) {
            array_push($errors, 'Debe ingresar enfermedades fungosas');
        }
        if (!$humedad) {
            array_push($errors, 'Debe ingresar humedad');
        }
        if (!$plantaspormetro) {
            array_push($errors, 'Debe ingresar plantas por metro');
        }
        if (!$enfermedadesfungosas) {
            array_push($errors, 'Debe ingresar enfermedades fungosas');
        }
        if (!$insectos) {
            array_push($errors, 'Debe ingresar insectos');
        }
        if (!$observaciones) {
            array_push($errors, 'Debe ingresar observaciones generales del cultivo');
        }
        if (!$recomendaciones) {
            array_push($errors, 'Debe ingresar recomendaciones');
        }
        if (empty($errors)) {
            //require_once('core/DBManager.php')
            //require_once('core/login.php');
            // $result = checkLogin($user,$pass);
        }
    }
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Informe visita cultivo</h3>
        </div>
        <div class="panel-body">
            <form action="updateVisita.php" method="POST">
                <div id="agricultor">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" name="formularioId" value="<?= $id; ?>">
                            <label for="razonsocial">Razón Social: </label>
                            <input type="text" name="razonsocial" class="form-control" value="<?= $row['razon'] ?>"
                                   placeholder="Ingrese razon social">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="agricultor">Agricultor: </label>
                            <input type="text" name="agricultor" class="form-control" value="<?= $row['agricultor'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ubicacion">Ubicación: </label>
                            <input type="text" name="ubicacion" class="form-control" value="<?= $row['ubicacion'] ?>"
                                   placeholder="Ingrese la ubicación">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">E-mail: </label>
                            <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>"
                                   placeholder="hola@mail.com">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telefono">Teléfono: </label>
                            <input type="text" name="telefono" class="form-control" value="<?= $row['fono'] ?>"
                                   placeholder="Ingrese el teléfono">
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div><!--div agricultor -->
                <div id="formularioVenta">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha: </label>
                            <input type="text" name="fecha" class="form-control"
                                   value="<?php $date = new DateTime($row['fechaVisita']);
                                   echo date_format($date, "d-m-Y"); ?>"
                                   placeholder="Ingrese fecha">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="variedad">Variedad: </label>
                            <select name="variedad" class="form-control">
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
                        <div class="form-group">
                            <label for="estadocrecimiento">1.Estado de crecimiento:</label>
                            <input type="text" name="estadocrecimiento" class="form-control"
                                   value="<?= $row['estadocrecimiento'] ?>"
                                   placeholder="Ingrese estado de crecimiento">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="plantaspormetro">5.Plantas por metro: </label>
                            <input type="text" hidden class="form-control" name="densidad"
                                   value="<?= $row['densidad'] ?>"
                                   placeholder="Ingrese plantas por metro">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="enfermedadesbacteriales">2.Enfermedades Bacteriales: </label>
                            <input type="text" name="enfermedadesbacteriales" class="form-control"
                                   value="<?= $row['bacteriales'] ?>"
                                   placeholder="Ingrese enfermedades bacteriales">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="enfermedadesfungosas">6.Enfermedades Fungosas: </label>
                            <input type="text" name="enfermedadesfungosas" class="form-control"
                                   value="<?= $row['fungosas'] ?>"
                                   placeholder="Ingrese enfermedades fungosas">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cultivo">3.Cultivo Limpio(1) - Sucio(10): </label>
                            <select name="malezas" class='form-control'>

                                <?php

                                for ($i = 1; $i <= 10; $i++) {
                                    $sel = "";
                                    if ($i == $row['malezas']) $sel = " selected";
                                    echo '<option value=' . $i . ' ' . $sel . '>' . $i . '</option>';

                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="insectos">7.Insectos: </label>
                            <input type="text" name="insectos" class="form-control" value="<?= $row['insectos'] ?>"
                                   placeholder="Ingrese insectos">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="humedad">4.Humedad: Seco(1) - Humedo(5) - Anegado(10): </label>
                            <select name="humedad" class='form-control'>
                                <?php
                                $i = 1;
                                while ($i <= 10) {
                                    $sel = "";
                                    if ($i == $row['humedad']) $sel = " selected";
                                    echo "<option value='" . $i . "' . $sel>" . $i . "</option>";
                                    $i++;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones generales del cultivo:</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" cols="30" rows="10"
                            ><?= $row['observaciones'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recomendaciones">Recomendaciones:</label>
                            <textarea name="recomendaciones" id="recomendaciones" class="form-control" cols="30"
                                      rows="10"><?= $row['recomendaciones'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div><!--div formularioVenta -->


                <button id="modificar" class="btn btn-primary">Modificar</button>
                <a href="informevisitapdf.php?id=<?php echo $id; ?>" class="btn btn-danger">Exportar PDF</a>
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