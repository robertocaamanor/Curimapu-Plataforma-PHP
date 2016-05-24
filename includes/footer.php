<script src="js/jquery.min.js"></script>
<script src="js/menu.js"></script>

	
	<script>
	$(document).ready(function(){ 
	   $('#alternar-respuesta-ej2').on('click',function(){
	      $('#respuesta-ej2').toggle('slow');
	   });
	   $("#rut").Rut({
		   on_error: function(){ alert('El rut ingresado es incorrecto'); }
		});
	   jQuery.validator.setDefaults({
			debug: true,
			success: "valid",
			highlight: function (element, errorClass, validClass) {
		        $(element).closest('.form-group').addClass('has-error');
		    },
		    unhighlight: function (element, errorClass, validClass) {
		        $(element).closest('.form-group').removeClass('has-error');
		    }
		});
		$( "#vendedor_validation" ).validate({
			rules: {
				telefono: {
					required: true,
					number: true,
					minlength: 7
				},
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
			date: "Por favor, escribe una fecha válida.",
			number: "Por favor, escribe un número entero válido.",
			equalTo: "Por favor, escribe el mismo valor de nuevo.",
			maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
			minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres.")
		});
	});
	</script>
	
</body>
</html>