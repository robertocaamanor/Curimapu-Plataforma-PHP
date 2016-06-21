<?php 
session_start(); 

  if(!isset($_SESSION['email'])) 
  { 

    echo "No tienes permiso para entrar a esta pagina"; 
  } 
  else 
  {   
include 'includes/header.php'; 
include 'src/functions/dbfunctions.php';
                
   $conn = connectDB();
  $fechahoy = date( "Y-m-d" );
  $semana = date( "Y-m-d", strtotime("-7 days",strtotime($fechahoy)));
if(isset($_POST['inicio'],$_POST['final'], $_POST['busquedaagricultor'])){
  $inicio = $_POST['inicio'];
  $final = $_POST['final'];
  $agricultor = $_POST['busquedaagricultor'];
  $result = listarventasagricultormixto($conn, $inicio, $final, $agricultor);
}elseif(isset($_POST['inicio'],$_POST['final'], $_POST['busquedavendedor'])){
  $inicio = $_POST['inicio'];
  $final = $_POST['final'];
  $vendedor = $_POST['busquedavendedor'];
  $result = listarventasvendedormixto($conn, $inicio, $final, $vendedor);
}
else{
  $result = listarVentas($conn, $semana, $fechahoy);
}
?>
<div class="sitio-principal">
<h4>Informes Seguimiento de Ventas</h4><hr/>
<div class="row">
  <div class="col-lg-6">
    <a href="listadoventasexcel.php" class="btn btn-success">Descargar Excel</a><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><hr/>
<ul class="nav nav-tabs">
    <li class="active"><a class="tablas" data-toggle="tab" href="#home">Fecha y agricultor</a></li>
    <li><a class="tablas" data-toggle="tab" href="#menu1">Fecha y vendedor</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <form class="formulario form-inline" action="listarventas.php" method="POST">
        <div class="form-group">
          <label for="exampleInputName2">Desde</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange1" name="inicio" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Hasta</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange2" name="final" placeholder="Buscar fecha..."></div>
        </div>
        <div id="opcional" class="form-group">
          <label for="exampleInputEmail2">Agricultor</label>
          <div class="input-group">    
         <?php
                $sql = mssql_query("select * from agricultorr order by Agricultorr_nombre");

                // Verifica que te llegaron datos de respuesta:
                if (mssql_num_rows($sql) > 0)
                {
                  // Recoge los datos recibidos. 
                  // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

                  // Yo he elegido mostrarlos directamente en el select:
                  echo"<select name='busquedaagricultor' class='form-control'>\n";
                  
                  // Aquí recorres los datos recibidos:
                  while ($temp = mssql_fetch_array($sql))
                  {
                    print" <option value='".$temp["Agricultorr_nombre"]."'>".$temp["Agricultorr_nombre"]."</option>\n";
                  }

                  echo"  </select>\n";
                }
                else
                {  echo"No hay datos";  }

                // Cierras la consulta
                mssql_free_result($sql);  
            ?>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox"> Buscar tambien con agricultor
          </label>
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
        </div>
        
      </form>
    </div>
    <div id="menu1" class="tab-pane fade">
      <form class="formulario form-inline" action="listarventas.php" method="POST">
        <div class="form-group">
          <label for="exampleInputName2">Desde</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange3" name="inicio" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Hasta</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange4" name="final" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Vendedor</label>
          <div class="input-group">    
         <?php
                $sql = mssql_query("select * from [gam].[User]");

                // Verifica que te llegaron datos de respuesta:
                if (mssql_num_rows($sql) > 0)
                {
                  // Recoge los datos recibidos. 
                  // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

                  // Yo he elegido mostrarlos directamente en el select:
                  echo"<select name='busquedavendedor' class='form-control'>\n";
                  
                  // Aquí recorres los datos recibidos:
                  while ($temp = mssql_fetch_array($sql))
                  {
                    print" <option value='".$temp["UserNameSpace"]."'>".$temp["UserFirstName"]." ".$temp["UserLastName"]."</option>\n";
                  }

                  echo"  </select>\n";
                }
                else
                {  echo"No hay datos";  }

                // Cierras la consulta
                mssql_free_result($sql);  
            ?>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox"> Buscar tambien con vendedor
          </label>
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
        </div>
        
      </form>
    </div>
  </div>
<hr/>
   <?php 
      $hoy = date( "Y-m-d" );
      $ayer = date( "Y-m-d", strtotime("-1 day",strtotime($hoy)));
      $primero = 1;
       do {
      while($row=mssql_fetch_array($result))
      {
       $date = date_format(new DateTime($row['fecha']), 'Y-m-d');
       if($primero){
        $compare = $date;
        $primero = 0;?>
        <div class="panelsemilllas">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php
            if($date == $hoy)
              echo "Hoy";
            else echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">

       <?php }
       if($compare==$date){?>
          <div class="list-group">
            <a href="modseguimientoventas.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['nombreespecie']; ?></b></p>
                      <p class="list-group-item-text"><b>Comuna: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                  </div>
              </div>
            </a>
          </div>
      <?php }
      else{
        $compare = $date?>
        </div>
        </div>
         <div class="panelsemilllas">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">
          <div class="list-group">
            <a href="modseguimientoventas.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['nombreespecie']; ?></b></p>
                      <p class="list-group-item-text"><b>Comuna: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                  </div>
              </div>
            </a>
          </div>
      <?php } 
      }
      } while(mssql_next_result($result));
      cerrar($conn) ?>
  </div>
</div>
<?php include 'includes/footer.php'; } ?>