<?php 
  $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); 
  mysqli_set_charset($connect,"utf8"); 
  include ('../../../variables.php');
  require "../../../PHPMailer/PHPMailerAutoload.php"; 
?>

<?php 
date_default_timezone_set('America/Lima');
setlocale(LC_ALL, 'es_PE');
$fech = date("Y-m-d H:i:s");

$tipo = $_POST['tipo'];
$admins = $_POST['admins'];
$trads = $_POST['trads'];
$frees = $_POST['frees'];
$users = $_POST['users'];
$mensaje = $_POST['mensaje'];
$losarchivos = $_POST['losarchivos'];
$codproyecto = $_POST['codproyecto'];
$elid = $_POST['elid'];
$ttipo = $_POST['ttipo'];

$url = $_POST['enlace1'];
$filename = $_POST['nomfile1'];
$encoding = "base64";
$type ="application/octet-stream";

$var = 0;
foreach( $url as $key => $ff ) {

  $handle = substr($ff, strrpos($ff, '/') + 1);
  $cmd = 'curl -X GET "https://www.filestackapi.com/api/file/'.$handle.'/metadata"';
  $resultado = shell_exec($cmd);
  $json = json_decode($resultado);
  $size = $json->{'size'};

  $var+= $size;
}

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

$length = 10;
$randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

$SQLPS = "SELECT * FROM limac_pass where estado='ACTIVO'";
$RQLPS = mysqli_query($connect,$SQLPS);
$GQLPS = mysqli_fetch_array($RQLPS,MYSQLI_ASSOC);
$usrname = $GQLPS['username'];
$psword = $GQLPS['password'];
$usfrom = $GQLPS['from'];

$uid = getGUID();

$random = substr(md5(uniqid(rand(1,6))), 0, 12);

$sqlcot = "SELECT * FROM cotizacion_limac where concat(`id_cotizacion`,`date_code`)='$codproyecto'";
$rescot = mysqli_query($connect,$sqlcot);

$sqlped = "SELECT * FROM pedidos_traducciones where id_traduccion='$codproyecto'";
$resped = mysqli_query($connect,$sqlped);

if(mysqli_num_rows($rescot)>0){
  $regcot = mysqli_fetch_array($rescot,MYSQLI_ASSOC);
  $moneda = $regcot['moneda'];
  //recuperamos el reclamante
  $reclamante = $regcot['reclamante'];
  $tipocot = 'COTIZACION';
} else if(mysqli_num_rows($resped)>0){
  $regped = mysqli_fetch_array($resped,MYSQLI_ASSOC);
  $moneda = $regped['currency'];
  $tipocot = 'SHOPPINGCART';
}

$xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
$rxcv = mysqli_query($connect,$xcv);
$gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
$txcv = $gxcv['numero'];

$xcve = "SELECT * FROM telephone where estado='MOSTRAR_ESPANA'";
$rxcve = mysqli_query($connect,$xcve);
$gxcve = mysqli_fetch_array($rxcve,MYSQLI_ASSOC);
$txcve = $gxcve['numero'];

$sadmin = "SELECT * FROM admin_limac where id_al='$elid'";
$radmin = mysqli_query($connect,$sadmin);
$rgadmin = mysqli_fetch_array($radmin,MYSQLI_ASSOC);

$remitente = $rgadmin['nombre'].' '.$rgadmin['apellidos'];

if($tipo == 'ADMIN'){
	$SQLB = "SELECT * FROM admin_limac where usuario='$admins'";
	$RSQLB = mysqli_query($connect,$SQLB);
	$GSQLB = mysqli_fetch_array($RSQLB,MYSQLI_ASSOC);

	$correo = $GSQLB['email'];
	$nombre = $GSQLB['nombre'].' '.$GSQLB['apellidos'];
	$IDC = $GSQLB['id_al'];

	$tipoper = 'ADMINISTRADOR';
	$laaccion = 'MENSAJE_A_ADMINISTRADOR';
	$linkc = 'https://www.limac.com.pe/nexus_admin/production/listado_v3_1.php';
  $eemail = $usfrom;
  $ename = "LIMAC";
  $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";

} else if($tipo == 'TRAD'){
	$SQLB = "SELECT * FROM personal_limac where id_pl='$trads'";
	$RSQLB = mysqli_query($connect,$SQLB);
	$GSQLB = mysqli_fetch_array($RSQLB,MYSQLI_ASSOC);

	$correo = $GSQLB['personal_email'];
	$nombre = $GSQLB['personal_nombres'].' '.$GSQLB['personal_apellido'];
	$IDC = $GSQLB['id_pl'];

	$tipoper = 'TRADUCTOR';
	$laaccion = 'MENSAJE_A_TRADUCTOR';
	$linkc = 'https://www.limac.com.pe/nexus_translator/production/listado_v3_1.php';
  $eemail = $usfrom;
  $ename = "LIMAC";
  $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";

} else if($tipo == 'FREE'){
	$SQLB = "SELECT * FROM personal_freelance where id_per='$frees'";
	$RSQLB = mysqli_query($connect,$SQLB);
	$GSQLB = mysqli_fetch_array($RSQLB,MYSQLI_ASSOC);

	$correo = $GSQLB['correo_usuario'];
	$nombre = $GSQLB['nombres_apellidos'];
	$IDC = $GSQLB['id_per'];

	$tipoper = 'FREELANCE';
	$laaccion = 'MENSAJE_A_FREELANCE';
	$linkc = 'https://www.limac.com.pe/nexus_translator/production/propuesta.php';
  $eemail = $usfrom;
  $ename = "LIMAC";
  $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";

} else if($tipo == 'USER'){
	$SQLB = "SELECT * FROM usuarios_limac where id_ul='$users'";
	$RSQLB = mysqli_query($connect,$SQLB);
	$GSQLB = mysqli_fetch_array($RSQLB,MYSQLI_ASSOC);

	$correo = $GSQLB['usuario'];
	$nombre = $GSQLB['nom_apellidos'];
	$IDC = $GSQLB['id_ul'];

	$tipoper = 'CLIENTE';
	$laaccion = 'MENSAJE_A_CLIENTE';

  if($moneda=='euros'){
    $linkc = 'https://www.limac.com.es/nexusv3/proyectos/pendientes/';
    $eemail = "ventas@limac.com.es";
    $ename = "LIMAC ESPAÑA";
    $elfooter = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
  } else {
    $linkc = 'https://www.limac.com.pe/nexusv3/proyectos/pendientes/';
    $eemail = $usfrom;
    $ename = "LIMAC";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
  }
	
}

$sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,mensaje,fecha,random,archivos) values('$codproyecto','$elid','$ttipo','$laaccion','$mensaje','$fech','$random','$losarchivos')";
$resh = mysqli_query($connect,$sqlh);

$sqlm = "INSERT INTO mensajes_proyectos (cod_remitente,tipo_remitente,cod_destinatario,tipo_destinatario,cod_proyecto,mensaje,archivos,random,created) VALUES ('$elid','$ttipo','$IDC','$tipoper','$codproyecto','$mensaje','$losarchivos','$random','$fech')";
$resm = mysqli_query($connect,$sqlm);

if($var <=10485760){

  $asunto='【MENSAJE ACERCA DEL PROYECTO Nº '.$codproyecto.' '.$reclamante.'】';
  ///////////
  $mssj = "
  <html>
  <body style='background:#a4a4a4;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
        <tr>
          <td align='center'>
            <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
              <tr>
                <td style='padding:0px;background:#FFF;'>";
  $mssj.="<img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>";
  $mssj.="</td>
            </tr>
              
            <tr>
              <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                  <b><br>Estimado(a) ".$nombre.",</b>
                  <p style='text-align: justify;'>El administrador ".$remitente." ha enviado el siguiente mensaje:<br><br></p>";

  $mssj.="
  <img border='0' src='https://www.limac.com.pe/mail/tracking_msj.php?id=".$randomletter."&to=".$correo."&numproy=".$codproyecto."&tipo=".$tipocot."&per=".$tipo."' style='display:none;' />
  <div>
  <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
    <tr>
      <td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Mensaje:</b><br>".$mensaje."</div></td>
    </tr>
  </table>
  </div>
  <hr>";

  $mssj.="
  <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: -8px;margin-left: 15px;position: relative;'>Responder este mensaje al emisor desde el portal NEXUS, seleccionando la opción <b>Enviar mensaje</b></div></td>
        </tr>
      </table>
  </div><hr>";

  $mssj.="<table width='100%' height='auto'>
                <tbody>
                <tr>
                  <td style='text-align:center;'><a href='".$linkc."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
                </tr>
              </tbody></table>";

  $mssj.="</td></tr>";

  $mssj.='<tr style="background:#FFF;">
            <td align="left" style="background:#FFF;">
              <p style="margin-left:10px; margin-right:10px;font-size:16px;">Cordialmente,<br><br>
              Departamento de Ventas.</p>
            </td>
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

  $mssj.= "<tr style='background:#FFF;'>
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
  $mail->MsgHTML($mssj);

  foreach( $url as $key => $u ) {
  //echo "Url: ".$u.", Filename: ".$filename[$key]."<br>";
  $mail->AddStringAttachment(file_get_contents($u),$filename[$key],$encoding,$type);
  }

  if($mail->Send())
  {
  //$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
  echo 'Revisión enviada';
  }

} else if($var>10485760){

  $NewDate = date('Y-m-d H:i', strtotime($fech . " +60 days"));
  $autologin = "INSERT INTO autologin_vobo(id_user,token,cotizacion,created) values('$IDC','$uid','$codproyecto','$NewDate')";
  $res_autologin = mysqli_query($connect,$autologin);

  $sqll = "INSERT INTO registro_vistobueno(codigo,tipo_proyecto,archivos,fecha) values('$codproyecto','COTIZACION','$losarchivos','$fech')";
  $ress = mysqli_query($connect,$sqll);

  $asunto='【MENSAJE ACERCA DEL PROYECTO Nº '.$codproyecto.''.$reclamante.'】';

  /////////////

  $mssj = "
  <html>
  <body style='background:#a4a4a4;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
        <tr>
          <td align='center'>
            <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
              <tr>
                <td style='padding:0px;background:#FFF;'>";
  $mssj.="<img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>";
  $mssj.="</td>
            </tr>
              
            <tr>
              <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                  <b><br>Estimado(a) ".$nombre.",</b>
                  <p style='text-align: justify;'>El administrador ".$remitente." ha enviado el siguiente mensaje:<br><br></p>";

  $mssj.="
  <img border='0' src='https://www.limac.com.pe/mail/tracking_msj.php?id=".$randomletter."&to=".$correo."&numproy=".$codproyecto."&tipo=".$tipocot."&per=".$tipo."' style='display:none;' />
  <div>
  <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
    <tr>
      <td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Mensaje:</b><br>".$mensaje."</div></td>
    </tr>
  </table>
  </div>
  <hr>";

  $mssj.="
  <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: -8px;margin-left: 15px;position: relative;'>Sírvase ingresar en el siguiente enlace para que pueda revisar los archivos:</div></td>
        </tr>
      </table>
  </div><hr>";

  $mssj.="<table width='100%' height='auto'>
                <tbody>
                <tr>
                  <td style='text-align:center;'><a href='https://www.limac.com.pe/review/cc.php?t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
                </tr>
              </tbody></table>";

  $mssj.="</td></tr>";

  $mssj.='<tr style="background:#FFF;">
            <td align="left" style="background:#FFF;">
              <p style="margin-left:10px; margin-right:10px;font-size:16px;">Cordialmente,<br><br>
              Departamento de Ventas.</p></td>
          </tr><tr>
            <td align="left">
              <div style="margin-left:10px !important;margin-right:10px !important;">
                <img src="https://www.limac.com.pe/assets/images/logos/logo_color2.jpg" width="150"
                style="border:0px;vertical-align:middle;margin-bottom: 20px;"><br>
                <div>
                  '.$address1.', <br>
                  '.$address2.',<br> Lima, República del Perú<br>
                  (511) (01) 700 9040<br>
                  <a href="mailto:ventas@limac.com.pe" target="_blank">ventas@limac.com.pe</a><br><a href="http://www.limac.com.pe" target="_blank">www.limac.com.pe</a>
                </div>
              </div>
            </td>
          </tr>';

  $mssj.= "<tr style='background:#FFF;'>
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
  $mail->MsgHTML($mssj);


  if($mail->Send())
  {
  //$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
  echo 'Revisión enviada';
  }

}


////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','ENVIO_MENSAJE','$fech','$nomadm ha enviado un mensaje a $nombre','$codproyecto','$tipocot')";
$resn = mysqli_query($connect,$sqln);


?>