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
date_default_timezone_set("America/Santiago");
$conn = connectDB();
if(isset($_POST['inicio'],$_POST['final'])){
  $inicio = $_POST['inicio'];
  $final = $_POST['final'];
  $result = listarvisitasfecha($conn, $inicio, $final);
}elseif(isset($_POST['busquedaagricultor'])){
  $buscaragricultor = $_POST['busquedaagricultor'];
  $result = listarvisitasagricultor($conn, $buscaragricultor);
}elseif(isset($_POST['busquedavendedor'])){
  $buscarvendedor = $_POST['busquedavendedor'];
  $result = listarvisitasvendedor($conn, $buscarvendedor);
}
else{
  $result = listarVisitas($conn);
}
?>
<div class="sitio-principal" >
<h4>Informes Visita Cultivo</h4><hr/>
<div class="row">
  <div class="col-lg-6">
    <a href="listadoventasexcel.php" class="btn btn-success">Descargar Excel</a><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><hr/>
 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Buscar por fecha</a></li>
    <li><a data-toggle="tab" href="#menu1">Buscar por agricultor</a></li>
    <li><a data-toggle="tab" href="#menu2">Buscar por vendedor</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <form class="formulario form-inline" action="listarvisitas.php" method="POST">
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
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
    </div>
    <div id="menu1" class="tab-pane fade">
      <form class="formulario form-inline" action="listarvisitas.php" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail2">Agricultor</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" class="form-control" name="busquedaagricultor" placeholder="Buscar agricultor..."></div>
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
    </div>
    <div id="menu2" class="tab-pane fade">
      <form class="formulario form-inline" action="listarvisitas.php" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail2">Vendedor</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" class="form-control" name="busquedavendedor" placeholder="Buscar vendedor..."></div>
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
    </div>
  </div>

<hr/>
   <?php 
          $hoy = date( "d-m-y" );
          $ayer = date( "d-m-y", strtotime("-1 day",strtotime($hoy)));
          $primero = 1;
          while($row=mssql_fetch_array($result))
          {
           $date = date_format(new DateTime($row['fecha']), 'd-m-y');
            //$date = date_format($row['fecha'],'d-m-y');
           if($primero){
            $compare = $date;
            $primero = 0;?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><?php
                if($date == $hoy)
                  echo "Hoy";
                else echo $date ?></h3>
              </div>
              <div class="panel-body">
           <?php }
           if($compare==$date){?>
              <div class="list-group">
                <a href="modinformevisita.php?id=<?php echo $row['id']; ?>" class="list-group-item">
                  <div class="grupo">
                      <div class="img-principal">
                          <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                      </div>
                      <div class="cuerpo-principal">
                          <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                          <p class="list-group-item-text"><b>Vendedor: <?php echo $row['usuario']; ?></b></p>
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
             <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><?php
                if($date == $hoy)
                  echo "Hoy";
                else echo $date ?></h3>
              </div>
              <div class="panel-body">
              <div class="list-group">
                <a href="modinformevisita.php?id=<?php echo $row['id']; ?>" class="list-group-item">
                  <div class="grupo">
                      <div class="img-principal">
                          <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                      </div>
                      <div class="cuerpo-principal">
                          <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                          <p class="list-group-item-text"><b>Vendedor: <?php echo $row['usuario']; ?></b></p>
                          <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                      </div>
                  </div>
                </a>
              </div>
          <?php } 
          } 
          cerrar($conn) ?>
</div>
<?php include 'includes/footer.php'; } ?>