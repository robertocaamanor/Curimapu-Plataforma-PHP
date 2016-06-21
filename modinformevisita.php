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
    ?>
<div class="sitio-principal">
 <div class="panelsemilllas">
        <div class="panel-titulo">
            <h3 class="panel-title">Informe Visita Cultivo</h3>
        </div>
        <div class="panel-cuerpo">
            <form action="updateVisita.php" method="POST">
                <div id="agricultor">
                <div class="row">  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="agricultor">Agricultor: </label>
                            <input type="text" name="agricultor" class="form-control" value="<?= $row['agricultor'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ubicacion">Comuna: </label>
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
                        <div class="form-group">                        
                            <label for="fecha">Fecha: </label>
                            <input type="text" name="fecha" class="form-control"
                                   value="<?php $date = new DateTime($row['fechaVisita']);
                                   echo date_format($date, "Y-m-d"); ?>"
                                   placeholder="Ingrese fecha">
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input type="text" name="contacto" class="form-control" value="<?= $row['contacto'] ?>"
                                       placeholder="Ingrese el teléfono">
                            </div>
                        </div>
                    <div class="col-md-4">
                        <div class="form-group">                        
                            <label for="variedad">Especie</label>
                            <input type="text" name="telefono" class="form-control" value="<?= $row['nombreespecie'] ?>"
                                   placeholder="Ingrese el teléfono">
                        </div>
                    </div>    
                    <div class="col-md-4">
                        <div class="form-group">                        
                            <label for="variedad">Variedad</label>
                            <input type="text" name="telefono" class="form-control" value="<?= $row['variedad'] ?>"
                                   placeholder="Ingrese el teléfono">
                        </div>
                    </div>                                    
                </div>
                </div><!--div agricultor -->
                <div id="formularioVenta">  
                <div class="row">                  
                    <div class="col-md-4">
                        <div class="form-group">
                        <input type="hidden" name="visitaid" class="form-control" value="<?php echo $id; ?>">
                            <label for="estadocrecimiento">1.Estado de crecimiento:</label>
                             <select name="estadocrecimiento" class="form-control">

                            <?php
                                $conn = connectDB();
                                $sql = "select FormularioVisita_estCrecimient from FormularioVisita where FormularioVisita_id='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['estadocrecimiento'] == $arreglo['FormularioVisita_estCrecimient']) $sel = "selected";
                                    ?>
                                    <option
                                        value="<?php echo $arreglo['FormularioVisita_estCrecimient'] ?>"<?= $sel ?>><?php echo $arreglo['FormularioVisita_estCrecimient']; ?></option>
                                <?php } ?>
                              <option value="Siembra">Siembra</option>
                              <option value="Emergencia">Emergencia</option>
                              <option value="Aplicacion Nitrogeno">Aplicacion Nitrogeno</option>
                              <option value="Riego">Riego</option>
                              <option value="Pre-Cosecha">Pre-Cosecha</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="enfermedades">2.Enfermedades y Plagas: </label>
                            <input type="text" name="enfermedades" class="form-control"
                                   value="<?= $row['enfermedades'] ?>"
                                   placeholder="Ingrese enfermedades bacteriales">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="malezas">3.Malezas: </label>
                            <select name="malezas" class="form-control">

                            <?php
                                $conn = connectDB();
                                $sql = "select FormularioVisita_estMalezas from FormularioVisita where FormularioVisita_id='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['malezas'] == $arreglo['FormularioVisita_estMalezas']) $sel = "selected";
                                    ?>
                                    <option
                                        value="<?php echo $arreglo['FormularioVisita_estMalezas'] ?>"<?= $sel ?>><?php echo $arreglo['FormularioVisita_estMalezas']; ?></option>
                                <?php } ?>
                              <option value="Nula">Nula</option>
                              <option value="Regular">Regular</option>
                              <option value="Alta">Alta</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="humedad">4.Humedad: </label>
                            <select name="humedad" class="form-control">

                            <?php
                                $conn = connectDB();
                                $sql = "select FormularioVisita_humdad from FormularioVisita where FormularioVisita_id='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['humedad'] == $arreglo['FormularioVisita_humdad']) $sel = "selected";
                                    ?>
                                    <option
                                        value="<?php echo $arreglo['FormularioVisita_humdad'] ?>"<?= $sel ?>><?php echo $arreglo['FormularioVisita_humdad']; ?></option>
                                <?php } ?>
                              <option value="Nula">Excelente</option>
                              <option value="Regular">Buena</option>
                              <option value="Alta">Regular</option>
                              <option value="Alta">Mala</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poblacion">5.Población: </label>
                            <input type="text" hidden class="form-control" name="poblacion"
                                   value="<?= $row['poblacion'] ?>"
                                   placeholder="Ingrese plantas por metro">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dossemsiembra">6.Dosis de Semilla a la Siembra: </label>
                            <input type="text" name="dossemsiembra" class="form-control" value="<?= $row['dsemillasiembra'] ?>"
                                   placeholder="Ingrese insectos">
                        </div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                            $imagen = $row['imagen'];
                            $imagenes = explode(':', $imagen);
                        ?>
                                
                            </div>
                        </div>
                    </div>
                </div><!--div formularioVenta -->
                <a class="btn btn-info" href="http://xcom.ddns.net/semillas/PublicTempStorage/multimedia/<?php echo trim($imagenes[1]); ?>">Ver imagen</a>
                <?php if($_SESSION['perfil'] == 2) { ?>
                <button id="modificar" class="btn btn-success">Modificar</button>
                <?php } ?>
                <a href="informevisitapdf.php?id=<?php echo $id; ?>" class="btn btn-danger">Exportar PDF</a>
            </form>
        </div>

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