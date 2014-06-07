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
 		var msg=$('#email').val();
 		//alert($('#email').val());
 		if (!$('#email').val())
 		{
 			alert('Debes de capturar un Email valido');
 			return false;
 		}
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
			//	self.location="login.html";
			}

		})
		.fail(function(resp) {  //false
			//alert(resp.error);
			$('span').html("Error al procesar");
		})
		.always(function() {
				
		});
 		//alert('usuario si existe');
		
	})
})

$(document).ready(function() {
 
	$('#register').submit(function(e) {
		e.preventDefault();
 		//var value=$('#password').val();
		//var match=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!-\/][:-@])[0-9a-zA-Z!-\/:-@.*]{8,}$/.test($('#password').val());
		if($('#password').val().length==0)
			return false;
		else if($('#firstname').val().length==0)
			return false;
		else if($('#lastname').val().length==0)
			return false;
		else if($('#gender').val().length==0)
			return false;
		else if($('#password').val()!=$('#passwordc').val())
			return false;
		

 		if(!$('#terms').prop('checked'))
 			return false;
 		if($('#email').val().length==0)
 			return false;
 		var value=$('#password').val();
 		var match=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!-\/][:-@])[0-9a-zA-Z!-\/:-@.*]{8,}$/.test(value);
 		//alert (match);
		if(!match)
			if (!confirm('Su password no es seguro, desea continuar?'))
				return false;
			
			//alert('Debes capturar al menos 8 caracteres para que sea un password seguro');
			//return false;
		//var value=$('#password').val();
		//var match=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!-\/][:-@])[0-9a-zA-Z!-\/:-@.*]{8,}$/.test(value);

		
		var data = $(this).serializeArray();
		data.push({name: 'tag', value: 'register'});
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
				alert(resp.msg);
				$('span').html(resp.msg);
			}
			else
			{
				//alert(resp.msg);
				$("#register").addClass('submited');
				//self.location="login.html";
			}

		})
		.fail(function(resp) {  //false
			//alert(resp.msg);
			$('span').html("Error al procesar");
		})
		
 		//alert('usuario si existe');
		
	})
})


//Validacion de forma
$(function()
{
// Validation
$("#register").validate(
{
// Rules for form validation
 //event.preventDefault();
rules:
{
username:
{
required: true
},
email:
{
required: true,
email: true
},
password:
{
required: true,
minlength: 8,
maxlength: 20
},
passwordConfirm:
{
required: true,
minlength: 8,
maxlength: 20,
equalTo: '#password'
},
firstname:
{
required: true
},
lastname:
{
required: true
},
gender:
{
required: true
},
terms:
{
required: true
}
},
// Messages for form validation
messages:
{
username:
{
required: 'Porfavor ingresa tu Usuario'
},
email:
{
required: 'Porfavor ingresa tu direccion E-mail',
email: 'Porfavor ingresa una direccion E-mail valida'
},
password:
{
required: 'Porfavor ingresa tu password'
},
passwordConfirm:
{
required: 'Porfavor ingresa tu password una vez mas',
equalTo: 'Porfavor ingresa el mismo password'
},
firstname:
{
required: 'Porfavor ingresa tu Nombre'
},
lastname:
{
required: 'Porfavor ingresa tu Apellido'
},
gender:
{
required: 'Porfavor selecciona tu genero'
},
terms:
{
required: 'Debes estar de acuerdo con los Terminos y Condiciones'
}
},
// Ajax form submition
submitHandler: function(form)
{
$(form).ajaxSubmit(
{
success: function()
{
//$("#register").addClass('submited');
}
});
},
// Do not change code below
errorPlacement: function(error, element)
{
error.insertAfter(element.parent());
}
});
});