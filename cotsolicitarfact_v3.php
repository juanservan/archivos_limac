<?php
  $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
  date_default_timezone_set("America/Lima");
  setlocale(LC_ALL, 'es_PE');

  require "../../../PHPMailer/PHPMailerAutoload.php";
  include_once "../../../variables.php";
?>

<?php 
	
	$idproyecto = $_POST['idproyecto'];
  $tipocot = $_POST['tipocot'];
  //$lang = $_POST['lang'];
  $elid = $_POST['elid'];
  $ttipo = $_POST['ttipo'];

	$sql = "SELECT * from cotizacion_limac where concat(id_cotizacion,date_code)='$idproyecto'";
	$res = mysqli_query($connect,$sql);
	$reg = mysqli_fetch_array($res,MYSQLI_ASSOC);

	$correo = $reg['correo_cliente'];
  $nomb = $reg['nombre_cliente'];
  $sxcliente = $reg['sexo'];
  $monedacot = $reg['moneda'];
  $reclamante = $reg['reclamante'];

  $xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
  $rxcv = mysqli_query($connect,$xcv);
  $gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
  $txcv = $gxcv['numero'];

  $xcve = "SELECT * FROM telephone where estado='MOSTRAR_ESPANA'";
  $rxcve = mysqli_query($connect,$xcve);
  $gxcve = mysqli_fetch_array($rxcve,MYSQLI_ASSOC);
  $txcve = $gxcve['numero'];

  $SQLPS = "SELECT * FROM limac_pass where estado='ACTIVO'";
  $RQLPS = mysqli_query($connect,$SQLPS);
  $GQLPS = mysqli_fetch_array($RQLPS,MYSQLI_ASSOC);
  $usrname = $GQLPS['username'];
  $psword = $GQLPS['password'];
  $usfrom = $GQLPS['from'];

  if($monedacot=='soles'){
    $symbol='S/';
    $valores = "Valores expresados en nuevos soles (S/ ).";
    $eemail = $usfrom;
    $ename = "LIMAC";
    $site = "www.limac.com.pe";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima..<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
  }

  if($monedacot=='dolares'){
    $symbol='$';
    $valores = "Valores expresados en dólares americanos ($).";
    $eemail = $usfrom;
    $ename = "LIMAC";
    $site = "www.limac.com.pe";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima..<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
  }

  if($monedacot=='euros'){
    $symbol='€';
    $valores = "Valores expresados en euros (€).";
    $eemail = "ventas@limac.com.es";
    $ename = "LIMAC ESPAÑA";
    $site = "www.limac.com.es";
    $elfooter = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
  }


  $scc = $reg['delivered'];  
  $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

  if($sxcliente=='' || $sxcliente==null){
    $sxcliente='Masculino';
  }

  $datee = date("Y-m-d H:i:s");

  function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = //chr(123)// "{"
                substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
                //.chr(125);// "}"
            return $uuid;
        }
    }

    $uid = getGUID();

  $sqlu = "SELECT * from usuarios_limac where usuario='$correo'";
  $resu = mysqli_query($connect,$sqlu);

  if(mysqli_num_rows($resu)>0){
    $regcons = mysqli_fetch_array($resu,MYSQLI_ASSOC);
    $idul = $regcons['id_ul'];
  } else {
        $eluser = "INSERT INTO usuarios_limac (nom_apellidos,sexo,email,usuario,pass,created) values('$nomb','$sxcliente','$correo','$correo','0000','$datee')";
        $reseluser = mysqli_query($connect,$eluser);

        $ss = "SELECT * from usuarios_limac where usuario='$correo'";
        $sss = mysqli_query($connect,$ss);
        $ssss = mysqli_fetch_array($sss,MYSQLI_ASSOC);
        $idul = $ssss['id_ul'];
  }

  $regauto = "INSERT INTO autologin(id_user,token,cotizacion,created) values('$idul','$uid','$idproyecto','$NewDate')";
  $resregauto = mysqli_query($connect,$regauto);

  $length = 10;
  $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

    $asunto = "【DATOS PARA COMPROBANTE DE PAGO Y/O ENTREGAS - PROYECTO N° ".$idproyecto." ".$reclamante."】";


////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','SOLICITUD_DATOS_ENTREGA','$datee','$nomadm ha solicitado datos de entrega al cliente $nomb','$idproyecto','COTIZACION')";
$resn = mysqli_query($connect,$sqln);

  ///////////////////////////

  $mensaje = "
  <html>
  <body style='background:#a4a4a4;'>
        <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
          <tr>
            <td align='center'>
              <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
                <tr>
                  <td style='padding:0px;background:#FFF;'>";
  $mensaje.="<img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>";
  $mensaje.="</td>
              </tr>
                
              <tr>
                <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                    <b><br>Estimado(a) cliente,</b>";

  $mensaje.="<p style='text-align: justify;'>Sírvase ingresar en el siguiente enlace para completar o actualizar el formulario con la finalidad de programar el envío de sus documentos y/o enviar el comprobante de pago correspondiente.<br></p>
  <img border='0' src='https://www.limac.com.pe/mail/tracking_ent.php?id=".$randomletter."&to=".$correo."&numproy=".$idproyecto."&tipo=COTIZACION' style='display:none;' />";

  $mensaje.="<table width='100%' height='auto'>
          <tbody>
          <tr>
            <td style='text-align:center;'><a href='https://".$site."/autologin/login.php?I=".$idul."&t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
          </tr>
        </tbody></table>";

  $mensaje.="
  <div style='padding-top: 8px;padding-bottom: 8px;'>
    <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
      <tr>
        <td style='text-align:center;'><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'>* Si tiene alguna duda o inquietud puede escribirnos a <a href='mailto:".$eemail."'>".$eemail."</a> o llamarnos al ";

  if($monedacot=='euros'){
    $mensaje.= $txcve;
  } else {
    $mensaje.= $txcv;
  }

  $mensaje.="</div></td>
      </tr>
    </table>
  </div>";


  $mensaje.="</td></tr>";

  $mensaje.='<tr style="background:#FFF;">
              <td align="left" style="background:#FFF;">
                <p style="margin-left:10px; margin-right:10px;font-size:16px;">Cordialmente,<br><br>
                Departamento de Ventas.</p></td>
            </tr><tr>
              <td align="left">
                <div style="margin-left:10px !important;margin-right:10px !important;">
              

                  <img src="https://www.limac.com.pe/assets/images/logos/logo_color2.jpg" width="150"
                  style="border:0px;vertical-align:middle;margin-bottom: 20px;"><br>
                  <div>
                    '.$address1.' <br>
                    '.$address2.',<br> Lima, República del Perú<br>
                    (511) (01) 700 9040<br>
                    <a href="mailto:ventas@limac.com.pe" target="_blank">ventas@limac.com.pe</a><br><a href="http://www.limac.com.pe" target="_blank">www.limac.com.pe</a>
                  </div>
                    
                  <table style="border-spacing: 0px;margin-top: 15px;">
                    <tbody>
                      <tr>
                        <td style="padding: 0px;"><a href="https://www.facebook.com/LimacOficial" target="_blank"><img
                              src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24"></a></td>
                        <td width="1"></td>
                        <td><a href="https://twitter.com/LimacOficial" target="_blank"><img
                              src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24"></a></td>
                        <td width="1"></td>
                        <td style="padding: 0px;"><a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b"
                            target="_blank"><img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png"
                              width="24"></a></td>
                      </tr>
                    </tbody>
                  </table>





                </div>
              </td>
            </tr>';

  $mensaje.= "<tr style='background:#FFF;'>
                  <td align='left' style='font-size:10px; color:#aaa;background:#FFF;'>
                    <div style='margin-left:10px; margin-right:10px; margin-bottom: 10px;'>
                    IMPORTANTE/CONFIDENCIAL<br>
                    Este documento contiene información personal y confidencial que va dirigida única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundida. Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. Si usted recibió este mensaje por error, sírvase informarlo al remitente y deshacerse de cualquier documento inmediatamente.
                    <br><br>
                    </div>
                  </td>
                </tr>
                <tr style='background-color:#0093DF;'><td align='center' style='background-color:#0093DF;color:#FFF;'><br><img src='https://www.limac.com.pe/assets/images/mail/firma3.png'></td></tr>
                <tr style='background-color:#0093DF;color:#FFF;'><td align='center' style='font-size: 12px;color:#FFF;text-decoration:none;'>".$elfooter."</td></tr>
              </table>
            </td>
          </tr>
        </table>
        </body></html>";

  //}
    
    $mail = new PHPMailer();
    $mail->CharSet = "UTF-8";
      
	  //indico a la clase que use SMTP
	      $mail->IsSMTP();
	  
	      //permite modo debug para ver mensajes de las cosas que van ocurriendo
	      //$mail->SMTPDebug = 2;

	  //Debo de hacer autenticación SMTP
	      $mail->SMTPAuth = true;
	      $mail->SMTPSecure = "ssl";

	  //indico el servidor de Gmail para SMTP
	      $mail->Host = "smtp.gmail.com";

	  //indico el puerto que usa Gmail
	      $mail->Port = 465;

	  //indico un usuario / clave de un usuario de gmail
        $mail->Username = $usrname;
        $mail->Password = $psword;
        $mail->From = $eemail;
        $mail->FromName = $ename;
	      $mail->Subject = $asunto;
	      $mail->addAddress($correo);
	      $mail->IsHTML(true);
	      $mail->Body = $mensaje;

	      if($mail->Send())
		    {
		      echo "OK";
		    }
		    else
		    {
		    echo "Lo siento, ha habido un error al enviar el mensaje a $email";
		    }


?>