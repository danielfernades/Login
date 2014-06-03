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
            $conexion = mysql_connect("localhost", "root", "");
            mysql_select_db("prueba", $conexion);
            $queEmp = "SELECT * FROM usuarios where email='".$mail_destino."'";
            $resEmp = mysql_query($queEmp,$conexion)or die(mysql_error());
            if  (mysql_num_rows($resEmp)>0)
            {
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
                $mail->Subject = "Recupera tu contraseña!"; 
                $mail->AltBody = "Este es un mensaje de prueba."; 
                $mail->MsgHTML("<b>Este es un mensaje de prueba</b>."); 
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
            /*else
            {
                echo true;
            }*/
        }
	
 
?>