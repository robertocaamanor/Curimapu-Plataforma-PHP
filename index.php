<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Curimapu</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
</head>
<body>

<div class="header-form">
    <h1>Sistema de monitoreo Curimapu</h1>
</div>

<form action="log_action.php" class="form" method="POST">
    <div class="avatar-form">
        <img src="http://i.imgur.com/XyMZ0m9.png" alt="...">
    </div>
    <div class="form-group">
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Ingrese su correo" required>
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Ingrese su contraseña"
               required>
    </div>
    <div class="form-final">
        <button type="submit" class="btn btn-success btn-block">Iniciar sesion</button>
    </div>
    <div class="form-final"><a href="">¿Olvido su contraseña?</a></div>

</form>

<div class="footer-form">
    <p>Desarrollado por XHOST</p>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>