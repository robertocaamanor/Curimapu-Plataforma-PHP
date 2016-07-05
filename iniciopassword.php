<?php
include 'src/functions/dbfunctions.php';
    $conn = ConnectDB();
?>
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
        <link rel="shortcut icon" href="http://i.imgur.com/akQX3eo.png">
</head>
<body>

<div class="header-form">
</div>

<form action="cambiopassword.php" class="form_password" method="POST">
    <div class="form-group">
      <label for="email">Ingrese nueva contraseña</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese su contraseña" required>
    </div>
    <div class="form-group">
      <label for="email">Confirmar nueva contraseña</label>
      <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Confirme su contraseña" required>
    </div>
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <div class="form-final">
      <button type="submit" class="btn btn-warning btn-block">Email</button>
    </div>
</form>

<div class="footer-form">
    <p>Desarrollado por XHOST</p>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
        jQuery('#form_validation').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                password_confirm: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }
            }
        });
        jQuery.extend(jQuery.validator.messages, {
          required: "Este campo es obligatorio.",
              remote: "Por favor, rellena este campo.",
              email: "Por favor, escribe una dirección de correo válida",
              url: "Por favor, escribe una URL válida.",
              date: "Por favor, escribe una fecha válida.",
              dateISO: "Por favor, escribe una fecha (ISO) válida.",
              number: "Por favor, escribe un número entero válido.",
              digits: "Por favor, escribe sólo dígitos.",
              creditcard: "Por favor, escribe un número de tarjeta válido.",
              equalTo: "Por favor, escribe el mismo valor de nuevo.",
              accept: "Por favor, escribe un valor con una extensión aceptada.",
              maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
              minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
              rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
              range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
              max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
              min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
        });
    }
</script>
</body>
</html>