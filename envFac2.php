<?php //include("../bloque.php"); ?> 
<?php
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
  require "../../../PHPMailer/PHPMailerAutoload.php";
  include_once "../../../variables.php";

  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL, 'es_PE');
?>

<?php 

	$url = $_POST['enlace1'];
	$filename = $_POST['nomfile1'];
	$remitente = $_POST['remitente1'];
	$id = $_POST['id1'];
	$sexcl = $_POST['sexcl1'];
	$atencion = $_POST['atencion1'];
	$at = $_POST['at1'];
	$nombre = $_POST['nombre1'];
	$correo = $_POST['correo1'];
	$files = $_POST['files1'];
  $empresa = $_POST['empresa'];
  $fecha = date("d-m-Y");
  $fech = date("Y-m-d H:i");
  $elid = $_POST['elid'];
  $ttipo = $_POST['ttipo'];
  $tproy = $_POST['tproy'];
  $tipocot = $_POST['tipocot'];

	$encoding = "base64";
  $type ="application/octet-stream";

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

  $length = 10;
  $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

    if($sexcl=="Masculino"){
      $est="Estimado Sr. ";
    }

    if($sexcl=="Femenino"){
      $est="Estimada Srta. ";
    }

    if($empresa=="Si"){
      $est="Estimados Sres. ";
    }

    if($tproy=='COTIZACION'){
      $sql = "UPDATE cotizacion_limac set factura='$files' where concat(`id_cotizacion`,`date_code`)='$id'";
      $res = mysqli_query($connect,$sql);

    } else if($tproy=='SHOPPINGCART'){
      $sql = "UPDATE pedidos_traducciones set factura='$files' where id_traduccion='$id'";
      $res = mysqli_query($connect,$sql);
    }

    $sqlcot = "SELECT * FROM cotizacion_limac where concat(`id_cotizacion`,`date_code`)='$id'";
    $rescot = mysqli_query($connect,$sqlcot);

    $sqlped = "SELECT * FROM pedidos_traducciones where id_traduccion='$id'";
    $resped = mysqli_query($connect,$sqlped);

    if(mysqli_num_rows($rescot)>0){
      $regcot = mysqli_fetch_array($rescot,MYSQLI_ASSOC);
      $moneda = $regcot['moneda'];
      $reclamante = $regcot['reclamante'];

    } else if(mysqli_num_rows($resped)>0){
      $regped = mysqli_fetch_array($resped,MYSQLI_ASSOC);
      $moneda = $regped['currency'];
    }

    if($moneda=='euros'){
      $eemail = "ventas@limac.com.es";
      $ename = "LIMAC ESPAÑA";
      $elfooter="LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
    } else {
      $eemail = $usfrom;
      $ename = "LIMAC";
      $elfooter="R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
    }

    $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha) values('$id','$elid','$ttipo','FACTURA','$files','$fech')";
    $resh = mysqli_query($connect,$sqlh);
    
    $asunto='【ENVÍO DE FACTURA - COTIZACIÓN Nº '.$id.''.$reclamante.'】';

    //////////////////

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
                      <b><br>Estimado(a) cliente:</b>
    <img border='0' src='https://www.limac.com.pe/mail/tracking_fac.php?id=".$randomletter."&to=".$correo."&numproy=".$id."&tipo=".$tproy."' style='display:none;' />";

    $mensaje.="<p style='text-align: justify;'>Le adjuntamos la facturación correspondiente de su Proyecto Nº ".$id."<br><br></p>";
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
    
    $mail = new PHPMailer;
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
        
          //$mail->addAddress($correo);

          $addr = explode(',',$correo);

          foreach ($addr as $ad) {
              $mail->AddAddress( trim($ad) );
          }

          $mail->IsHTML(true);
          
        
          $mail->MsgHTML($mensaje);

          foreach( $url as $key => $u ) {
            //echo "Url: ".$u.", Filename: ".$filename[$key]."<br>";
            $mail->AddStringAttachment(file_get_contents($u),$filename[$key],$encoding,$type);
          } 

      if($mail->Send()){
	      //$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
        echo 'Factura enviada';
      }



////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','ENVIO_FACTURA','$fech','$nomadm ha enviado una factura al cliente $nombre','$id','$tproy')";
$resn = mysqli_query($connect,$sqln);



?>