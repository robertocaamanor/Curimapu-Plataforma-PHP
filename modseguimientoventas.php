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
    ?>
<div class="sitio-principal">
 <div class="panelsemilllas">
        <div class="panel-titulo">
            <h3 class="panel-title">Informe Seguimiento de Ventas</h3>
        </div>
        <div class="panel-cuerpo">
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
                                <label for="agricultor">Agricultor</label>
                                <input type="text" name="agricultor" class="form-control"
                                       value=" <?= $row['agricultor'] ?>"
                                       placeholder="Ingrese el nombre del agricultor">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ubicacion">Comuna</label>
                                <input type="text" name="ubicacion" class="form-control"
                                       value=" <?= $row['ubicacion'] ?>"
                                       placeholder="Ingrese la ubicación">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>"
                                       placeholder="hola@mail.com">
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="<?= $row['fono'] ?>"
                                       placeholder="Ingrese el teléfono">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            
                                <label for="fecha">Fecha</label>
                                <input type="text" name="fecha" class="form-control" placeholder="Ingrese fecha"
                                       value="<?php echo date_format(new DateTime($row['fecha']), "Y-m-d"); ?>">
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
                                       placeholder="Ingrese variedad">
                            </div>
                        </div>              
                    </div>
                </div><!--div agricultor -->
                <div id="formularioVenta">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <input type="hidden" name="formularioId" value="<?= $id; ?>">
                                <label for="superficiesiembra">Superficie sembrado temp. anterior (Has)</label>
                                <input type="text" name="superficiesiembra" class="form-control"
                                       value="<?= $row['superficiesiembra'] ?>"
                                       placeholder="Ingrese superficie">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="intencionsiembra">Intención de siembra total (Has)</label>
                                <input type="text" name="intencionsiembra" class="form-control"
                                       value="<?= $row['intencionsiembra']?>"
                                       placeholder="Ingrese intención de siembra">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="intencionsiembraanterior">Intención de siembra Curimapu (Has)</label>
                                <input type="text" name="intencionsiembraanterior" class="form-control"
                                       value="<?= $row['intencionsiembraanterior'] ?>"
                                       placeholder="Ingrese intención de siembra Anterior">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rendimientoanterior">Rendimiento temporada anterior  (qq/has)</label>
                                <input type="text" name="rendimientoanterior" class="form-control"
                                       value="<?= $row['rendimiento'] ?>"
                                       placeholder="Ingrese rendimiento">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hibridos">Hibrido(s) usado temporada pasada</label>
                                <input type="text" name="hibridoscuri" class="form-control"
                                       value="<?= $row['hibridoscuri'] ?>"
                                       placeholder="Ingrese Hibridos">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hibridos">Hibrido(s) externo temporada pasada</label>
                                <input type="text" name="hibridosotros" class="form-control"
                                       value="<?= $row['hibridosotros'] ?>"
                                       placeholder="Ingrese Hibridos">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hectareasriego">Hectáreas riego (Has)</label>
                                <input type="text" name="hectareasriego" class="form-control"
                                       value="<?= $row['riego'] ?>" placeholder="Ingrese hectáreas riego">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hectareassecano">Hectáreas secano (Has)</label>
                                <input type="text" name="hectareassecano" class="form-control"
                                       value="<?= $row['secano'] ?>" placeholder="Ingrese rendimiento">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comentario">Observaciones</label>
                            <textarea name="comentarios" id="comentario" class="form-control" cols="30"
                                      rows="10"><?= $row['comentario'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comentario">Recomendaciones</label>
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
                
                <?php
                    if(trim($imagenes[1]) != null ){
                ?>
                <a class="btn btn-info" href="http://xcom.ddns.net/semillas/PublicTempStorage/multimedia/<?php echo trim($imagenes[1]); ?>">Ver imagen</a>
                <?php
                    }
                ?>
                <?php if($_SESSION['perfil'] == 2) { ?>
                <button id="modificar" class="btn btn-success">Modificar</button>
                <?php } ?>
                <a href="informeventapdf.php?id=<?php echo $id; ?>" class="btn btn-danger">Exportar PDF</a>
            </form>
        </div>
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