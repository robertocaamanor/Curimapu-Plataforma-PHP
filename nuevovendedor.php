<?php
session_start(); 

    if(!isset($_SESSION['email'])) 
    { 

        echo "No tienes permiso para entrar a esta pagina"; 
    } 
    else 
    {   
include 'includes/header.php';
?>

<div class="panel-principal">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Nuevo vendedor</h3>
        </div>
        <div class="panel-body">
            <form action="agregarvendedor.php" method="POST" id="vendedor_validation">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombrevendedor">Nombre vendedor</label>
                            <input type="text" name="nombrevendedor" class="form-control"
                                   placeholder="Ingrese nombre" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control"
                                   placeholder="Ingrese telefono" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rut">R.U.T.</label>
                            <input type="text" name="rut" id="rut" class="form-control"
                                   placeholder="Ingrese R.U.T." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="Ingrese email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Ingrese contraseña" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="repetirpassword">Repetir contraseña</label>
                            <input type="password" id="password_confirm" name="password_confirm" class="form-control"
                                   placeholder="Repita contraseña" required>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-block">Listo!</button>
            </form>
        </div>     
    </div>
</div>

<?php include 'includes/footer.php'; } ?>