$(document).ready(function() {
 
	$('form').submit(function(e) {
		e.preventDefault();
 		
		var data = $(this).serializeArray();
		data.push({name: 'tag', value: 'login'});
		//alert(data[2].value);
		$.ajax({
			url: 'buscar.php',
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