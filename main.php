<?php 


function enviarEmail($mail_destino,$nombre_destino,$subject,$body)
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
            $mail->Subject = $subject; 
           // $mail->AltBody = "Registro exitoso!"; 
            $mail->MsgHTML($body); 
            //$mail->AddAttachment("files/files.zip"; 
            //$mail->AddAttachment("files/img03.jpg"; 
            $mail->AddAddress($mail_destino, $nombre_destino); 
            $mail->IsHTML(true); 
            if(!$mail->Send()) 
                return false;
            else
                return true;
}
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
                //echo "hola2";
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
           /* if ($mail_destino=='')
            {
                $output=array('error'=> '1','msg'=>'Debe capturar un email');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }*/

            $conexion = mysql_connect("localhost", "root", "");
            mysql_select_db("prueba", $conexion);
            $queEmp = "SELECT * FROM usuarios where email='".$mail_destino."'";
            $resEmp = mysql_query($queEmp,$conexion)or die(mysql_error());
            if  (mysql_num_rows($resEmp)>0)
            {
                $row = mysql_fetch_array($resEmp);
                $id_usuario_req=$row['id_user'];
                $nombre_destino=$row['name'].' '.$row['lastname'];
                $query="select fecha_expiracion,now() as fecha_actual from forgot_password where id_user='".$id_usuario_req."'";
                $res=mysql_query($query,$conexion)or die(mysql_error());
                if (mysql_num_rows($res)>0)
                {
                    $row=mysql_fetch_array($res);
                    
                   // $fecha_actual=(new \DateTime())->format('Y-m-d H:i:s');
                    $fecha_actual=date_create($row['fecha_actual']);
                    $fecha_exp=date_create($row['fecha_expiracion']);
                    //echo $fecha_actual->format('Y-m-d H:i:s');
                    if ($fecha_exp>$fecha_actual)
                    {
                        //echo $row['fecha_expiracion'];
                      //  echo $fecha_actual;
                        //echo strftime("%F %T");
                        $output=array('error'=> '1','msg'=>'Ya se te ah enviado un codigo al email registrado, por favor verificalo');
                        echo json_encode($output,JSON_FORCE_OBJECT);
                        return true;
                    }
                    else
                    {
                        mysql_query("delete from forgot_password where id_user='".$id_usuario_req."'",$conexion);
                    }
                }

                $query="INSERT INTO forgot_password (id_user,codigo,fecha_expiracion) values ('".$id_usuario_req."',LEFT(SHA1(DATE_FORMAT(NOW(), '%d %m %Y')+".$id_usuario_req."),20),ADDDATE(NOW(),INTERVAL 60 MINUTE))";
                mysql_query($query,$conexion)or die(mysql_error());

                $query="SELECT * FROM forgot_password where id_user='".$id_usuario_req."'";
                try{
                $resEmp = mysql_query($query,$conexion) or die('error');
                    }
                    catch(exception $e){echo 'popo';}
                if (mysql_error()){
            //    echo "hola despues rror";
            }
                $row = mysql_fetch_array($resEmp);
                $body="<table align=\"center\">
                                <caption>Correo de prueba</caption>
                                <tbody>
                                <tr>
                                <h1><b>MLP</b></h1>

                                </tr>

                                <tr>
                                <h2>Informacion</h2>
                                </tr>

                                <tr>
                                <p>Para cambiar el password ingresa a http://192.168.0.130/Login/reset.html?code=".$row['codigo']."</p>
                                <p>Este codigo solo es valido hasta el dia ".$row['fecha_expiracion']."</p>
                                </tr>

                                <tr>
                                <th>Firma</th>
                                </tr>

                                <tr>
                                <th>Correos</th>
                                </tr>
                                </tbody>
                                </table>"; 
               
               

                if(!enviarEmail($mail_destino,$nombre_destino,'Recupera tu password!',$body)) 
                { 

                    $output=array('error'=> '1','msg'=>( 'Error al enviar el echo'));
                    json_encode($output,JSON_FORCE_OBJECT);
                    
                }
                else 
                {
                    $output=array('error'=> '0','msg'=>'Código enviado al email');
                    echo json_encode($output,JSON_FORCE_OBJECT);
                    
                }
            }
            else
            {
                  $output=array('error'=> '1','msg'=>'El email no esta registrado');
                  echo json_encode($output,JSON_FORCE_OBJECT);
            }

           
        }
        elseif($tag=='register')
        {
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $name=$_POST['firstname'];
            $lastname=$_POST['lastname'];
            $gender=$_POST['gender'];

            $conexion = mysql_connect("localhost", "root", "");
            mysql_select_db("prueba", $conexion);
           
            $query="SELECT * FROM USUARIOS WHERE USERNAME='".$username."'";
            $res=mysql_query($query,$conexion)or die(mysql_error());

            if (mysql_num_rows($res)>0)
            {
                $output=array('error'=> '1','msg'=>'El usuario ya se ha registrado');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }    

            $query="SELECT * FROM USUARIOS WHERE email='".$email."'";
            $res=mysql_query($query,$conexion)or die(mysql_error());

            if (mysql_num_rows($res)>0)
            {
                $output=array('error'=> '2','msg'=>'El email ya esta registrado');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }    
            
            $query="SELECT * FROM USUARIOS WHERE USERNAME='".$name."'";
            $res=mysql_query($query,$conexion)or die(mysql_error());

            if (mysql_num_rows($res)>0)
            {
                $output=array('error'=> '1','msg'=>'El usuario ya se ha registrado');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }    

            $query="INSERT INTO USUARIOS (email,pass,username,name,lastname,gender) values ('#email',left('#password',20),'#username','#name','#lastname','#gender')";
            $query=str_replace('#name', $name,str_replace('#username', $username,str_replace('#password', sha1($password), str_replace('#email', $email, $query))));
            $query=str_replace('#gender', $gender, str_replace('#lastname', $lastname, $query));
            $res=mysql_query($query,$conexion)or die(mysql_error());

            $subject="Bienvnido a nuestra pagina!";
            $body="<table align=\"center\">
                            <caption>Registro de Usuario</caption>
                            <tbody>
                            <tr>
                            <h1><b>MLP</b></h1>

                            </tr>

                            <tr>
                            <h2>Informacion</h2>
                            </tr>

                            <tr>
                            <p>Gracias por registrate con nosotros</p>
                            <p></p>
                            </tr>

                            <tr>
                            <th>morrocode</th>
                            </tr>

                            <tr>
                            <th>admin@morrocode.com</th>
                            </tr>
                            </tbody>
                            </table>";
            //$firstname.' '.$lastname

            if (enviarEmail($email,$name.' '.$lastname,$subject,$body))
            {
                $output=array('error'=> '0','msg'=>'Usuario registrado exitosamente');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }

        }
        elseif($tag=='check_id')
        {
            $codigo=$_POST['code'];
            $conexion = mysql_connect("localhost", "root", "");
            mysql_select_db("prueba", $conexion);
            $queEmp = "SELECT * FROM forgot_password where codigo='".$codigo."' and fecha_expiracion>=now()";
            $resEmp = mysql_query($queEmp,$conexion)or die(mysql_error());
            if (mysql_num_rows($resEmp)==0)
            {
                $output=array('error'=> '1','msg'=>'El codigo no es valido o ha expirado');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }
            $row=mysql_fetch_array($resEmp);
            $output=array('error'=> '0','msg'=>$row['id_user']);
            echo json_encode($output,JSON_FORCE_OBJECT);
            return true;

        }
        elseif($tag=='reset_password')
        {
            $id_user=$_POST['id_user'];
            $conexion = mysql_connect("localhost", "root", "");
            mysql_select_db("prueba", $conexion);
           
            $query = "SELECT * FROM forgot_password where id_user='".$id_user."' and fecha_expiracion>=now()";
            $res=mysql_query($query,$conexion)or die(mysql_error());

            if (mysql_num_rows($res)==0)
            {   
                $output=array('error'=> '1','msg'=>'El codigo no es valido o ha expirado');
                echo json_encode($output,JSON_FORCE_OBJECT);
                return true;
            }
            $query = "update usuarios set pass='#pass' where id_user='#id_user'";
            $query=str_replace('#pass', sha1($_POST['password']), $query);
            $query=str_replace('#id_user', $id_user, $query);
            mysql_query($query,$conexion)or die(mysql_error());

            $query="delete from forgot_password where id_user='#id_user'";
            $query=str_replace('#id_user', $id_user, $query);
            mysql_query($query,$conexion)or die(mysql_error());

            $output=array('error'=> '0','msg'=>'Su password se ha cambiado correctamente');
            echo json_encode($output,JSON_FORCE_OBJECT);
            return true;
        }
    
    }
	
 
?>