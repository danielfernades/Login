<?php 
//<script type="text/javascript">alert("Hola");</script>
$tag = $_POST['tag'];

if (isset($tag) && $tag !== '') {

		if ($tag == 'login') 
        {
			//echo true;
            $user =$_POST['username'];
            $pass=$_POST['password'];
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

        elseif ($tag=='forgot')
        {
            $mail_destino=$_POST['email'];
            if ($mail_destino=='')
            {
                $output=array('error'=> '1','msg'=>'Debe capturar un email');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }

            $conexion = mysql_connect("localhost", "root", "");
            mysql_select_db("prueba", $conexion);
            $queEmp = "SELECT * FROM usuarios where email='".$mail_destino."'";
            $resEmp = mysql_query($queEmp,$conexion)or die(mysql_error());
            if  (mysql_num_rows($resEmp)>0)
            {
                $row = mysql_fetch_array($resEmp);
                $id_usuario_req=$row['id_user'];
                $query="INSERT INTO forgot_password (id_user,codigo,fecha_expiracion) values ('".$id_usuario_req."',LEFT(SHA1(DATE_FORMAT(NOW(), '%d %m %Y')+".$id_usuario_req."),20),ADDDATE(NOW(),INTERVAL 60 MINUTE))";
                mysql_query($query,$conexion)or die(mysql_error());
               
                $query="SELECT * FROM forgot_password where id_user='".$id_usuario_req."'";
                $resEmp = mysql_query($query,$conexion)or die(mysql_error());
                $row = mysql_fetch_array($resEmp);

                include("class.phpmailer.php"); 
                include("class.smtp.php"); 
               
                $mail = new PHPMailer(); 
                $mail->IsSMTP(); 
                $mail->SMTPAuth = true; 
                $mail->SMTPSecure = "ssl"; 
                $mail->Host = "smtp.gmail.com"; 
                $mail->Port = 465; 
                $mail->Username = "mm.marin16@gmail.com"; 
                $mail->Password = "alejandro1990";
                $mail->From = "mm.marin16@gmail.com"; 
                $mail->FromName = "Test Login"; 
                $mail->Subject = "Recupera tu password!"; 
                $mail->AltBody = "Este es un mensaje de prueba."; 
                $mail->MsgHTML("<table align=\"center\">
<caption>Correo de prueba</caption>
<tbody>
<tr>
<h1><b>MLP</b></h1>

</tr>

<tr>
<h2>Informacion</h2>
</tr>

<tr>
<p>Para cambiar el password ingresa a http://localhost/Login/reset.html?code=".$row['codigo']."</p>
</tr>

<tr>
<th>Firma</th>
</tr>

<tr>
<th>Correos</th>
</tr>
</tbody>
</table>"); 
                //$mail->AddAttachment("files/files.zip"; 
                //$mail->AddAttachment("files/img03.jpg"; 
                $mail->AddAddress($mail_destino, "Manuel Marin"); 
                $mail->IsHTML(true); 
                if(!$mail->Send()) 
                { 

                    $output=array('error'=> '1','msg'=>( $mail->ErrorInfo));
                    echo json_encode($output,JSON_FORCE_OBJECT);
                    
                }
                else 
                {
                    $output=array('error'=> '0','msg'=>'Código enviado el email');
                    echo json_encode($output,JSON_FORCE_OBJECT);
                    
                }
            }
            else
            {
                  $output=array('error'=> '1','msg'=>'El email no esta registrado');
                  echo json_encode($output,JSON_FORCE_OBJECT);
            }

           
        }
    
    }
	
 
?>