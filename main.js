$(document).ready(function() {
 
	$('#login').submit(function(e) {
		e.preventDefault();
 		
		var data = $(this).serializeArray();
		data.push({name: 'tag', value: 'login'});
		//alert(data[2].value);
		$.ajax({
			url: 'main.php',
			type: 'POST',
			dataType: 'json',
			data: data
			
		})
		.done(function() {  //true
			$('span').html("Datos correctos");
			self.location="top.html";

		})
		.fail(function() {  //false
			$('span').html("Datos incorrectos");
		})
		.always(function() {
				
		});
 		//alert('usuario si existe');
		
	})
})

$(document).ready(function() {
 
	$('#forgot').submit(function(e) {
		e.preventDefault();
 		
		var data = $(this).serializeArray();
		data.push({name: 'tag', value: 'forgot'});
		//data.push({name:'email_text',value: document.getElementById('email').value});
		//alert(data[0].value);
		$.ajax({
			url: 'main.php',
			type: 'POST',
			dataType: 'json',
			data: data
			
		})
		.done(function(resp) {  //true
			//$('span').html("Codigo enviado a su email");
			if (resp.error>0)
			{
					$('span').html(resp.msg);
			}
			else
			{
					alert(resp.msg);
				self.location="login.html";
			}

		})
		.fail(function(resp) {  //false
			alert(resp.error);
			$('span').html("Error al procesar");
		})
		.always(function() {
				
		});
 		//alert('usuario si existe');
		
	})
})

$(function()
			{
				// Validacion
				$("#login").validate(
				{					
					// Reglas del form de validacion
					rules:
					{
						email:
						{
							required: true,
							email: true
						},
						password:
						{
							required: true,
							minlength: 3,
							maxlength: 20
						}
					},
										
					// Mensajes del form de validacion
					messages:
					{
						email:
						{
							required: 'Porfavor ingresa tu direccion E-mail',
							email: 'Porfavor ingresa una direccion E-mail valida'
						},
						password:
						{
							required: 'Porfavor ingresa tu password'
						}
					},					
					
					// Ajax form submit					
					submitHandler: function(form)
					{
						$(form).ajaxSubmit(
						{
							success: function()
							{
								$("#login").addClass('submited');
							}
						});
					},
					
					// Dejar codigo en paz...
					errorPlacement: function(error, element)
					{
						error.insertAfter(element.parent());
					}
				});
			});			