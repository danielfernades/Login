<?php

//<script type="text/javascript">alert("Hola");</script>
$tag = $_POST['tag'];
$user =$_POST['username'];
$pass=$_POST['password'];
if (isset($tag) && $tag !== '') {

		if ($tag == 'login') {
			//echo true;
			  $conexion = mysql_connect("localhost", "root", "");
    		mysql_select_db("prueba", $conexion);
    		$queEmp = "SELECT * FROM usuarios where username='".$user."' and pass='".sha1($pass)."'";
    		$resEmp = mysql_query($queEmp,$conexion)or die(mysql_error());
		    if  (mysql_num_rows($resEmp)>0)
    		{
        		//<script language='JavaScript'>alert('usuario si existe'); </script>;
        		echo true;
    		}
    		else
    		{
    			echo false;
    		}
			
		}
	}
 
?>