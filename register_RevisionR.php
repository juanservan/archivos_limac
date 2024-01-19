<?php $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8"); ?>
<?php
require "../../../PHPMailer/PHPMailerAutoload.php";
include_once "../../../variables.php";
$length = 10;
$randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

$fecha = date("Y-m-d H:i");
$obj = json_decode($_POST['myData'],true);
$idproy = $_POST["idproy"];
$tipo = $_POST["tipo"];
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$sexcl = $_POST["sexcl"];
$atencion = $_POST["atencion"];
$at = $_POST["at"];
$elid = $_POST['elid'];
$ttipo = $_POST['ttipo'];
$comentario = $_POST['comentario'];

// Recuperamos los datos de los arachivos
$losarchivos = $_POST['losarchivos'];
$url = $_POST['enlace1'];
$filename = $_POST['nomfile1'];

$encoding = "base64";
$type ="application/octet-stream";

if($sexcl=="Masculino" || $sexcl=="male"){
  $est="Estimado Sr. ";
}

if($sexcl=="Femenino" || $sexcl=="female"){
  $est="Estimada Srta. ";
}

if($sexcl=="empresa"){
  $est="Estimados Sres. ";
}

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

if($tipo=="COTIZACION"){


  $cott = "SELECT * FROM cotizacion_limac where concat(`id_cotizacion`,`date_code`)='$idproy'";
  $rescott = mysqli_query($connect,$cott);
  $regcott = mysqli_fetch_array($rescott,MYSQLI_ASSOC);
  $delivered = $regcott['delivered'];
  $moneda = $regcott['moneda'];
  //recuperamos el reclamante
  $reclamante = $regcott['reclamante'];

  if($moneda=='soles'){
    $symbol='S/';
    $valores = "Valores expresados en nuevos soles (S/ ).";
    $eemail = $usfrom;
    $ename = "LIMAC";
    $site = "www.limac.com.pe";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
    date_default_timezone_set('America/Lima');
    setlocale(LC_ALL, 'es_PE');
    $datetime = date("Y-m-d H:i:s");
  }

  if($moneda=='dolares'){
    $symbol='$';
    $valores = "Valores expresados en dólares americanos ($).";
    $eemail = $usfrom;
    $ename = "LIMAC";
    $site = "www.limac.com.pe";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
    date_default_timezone_set('America/Lima');
    setlocale(LC_ALL, 'es_PE');
    $datetime = date("Y-m-d H:i:s");
  }

  if($moneda=='euros'){
    $symbol='€';
    $valores = "Valores expresados en euros (€).";
    $eemail = "ventas@limac.com.es";
    $ename = "LIMAC ESPAÑA";
    $site = "www.limac.com.es";
    $elfooter = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
    date_default_timezone_set('Europe/Madrid');
    setlocale(LC_ALL, 'es_ES');
    $datetime = date("Y-m-d H:i:s");
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

  $uid = getGUID();

  $archivostotal = '';

  foreach ($obj as $data) { //explora cada traductor
    $personal = $data['personal'];
    $contable = $data['contable'];

    $translator_type = substr($personal, -4);//TRAD o FREE
    $id_traductor = substr( $personal, 0, strrpos( $personal, $translator_type ) );//id trad

    $random = substr(md5(uniqid(rand(1,6))), 0, 12);
    $archtotal = '';

    if($translator_type=="FREE"){

      if($contable=="yes"){

        foreach ($data["content"] as $content) {
          $language = $content['language'];
          $words = $content['words'];
          $wordsf = $content['wordsf'];
          $file = $content['archivo'];
          $nomfile = $content['nomarchivo'];

          $textocompleto = $content['textocompleto'];
          $textosolopalabras = $content['textosolopalabras'];
          $textocaracteres = $content['textocaracteres'];
          $textonumeros = $content['textonumeros'];
          $cantsolopalabras = $content['cantsolopalabras'];
          $cantnumeros = $content['cantnumeros'];
          $cantcaracteres = $content['cantcaracteres'];
          $cantcompleto = $content['cantcompleto'];

          $filess = '  <a target=_blank href='.$file.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfile.'</button></a> ';

          $sql = "INSERT INTO revision_words (cod_proyecto,tipo,traductor,archivos,idiomas,num_words,num_wordsf,fecha,random,tipo_traductor,text_onlywords,text_complete,num_wordsc,text_numbers,num_numbers,text_characters,num_characters) values ('$idproy','$tipo','$id_traductor','".mysqli_real_escape_string($connect,$filess)."','$language','$words','$wordsf','$fecha','$random','FREELANCE','".mysqli_real_escape_string($connect,$textosolopalabras)."','".mysqli_real_escape_string($connect,$textocompleto)."','$cantcompleto','$textonumeros','$cantnumeros','$textocaracteres','$cantcaracteres')";
          $res = mysqli_query($connect,$sql);
        }
      }

      foreach ($data["content"] as $contenido){
        $filex = $contenido['archivo'];
        $nomfilex = $contenido['nomarchivo'];

        // Obtenemos la extencion del archivo
        $nomfilex_explode = explode(".",$nomfilex);
        $extension = end($nomfilex_explode);
        if ($extension=="docx"){
          $icon = '<i class="fa fa-file-word-o word" aria-hidden="true"></i>';
          $tarjet = '_self';
        } else if ($extension=="pdf") {
          $icon = '<i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i>';
          $tarjet = '_blank';
        } else {
          $icon = '<i class="fa fa-file-text" aria-hidden="true"></i>';
          $tarjet = '_blank';
        }

        $archivostotal.= '<a target='.$tarjet.' href='.$filex.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfilex.'</button></a> ';
        $archtotal.= '<a class="archicoDoc" target='.$tarjet.' href='.$filex.'><div class="contenedor">'.$icon.' '.$nomfilex.'</div></a>';
      }

      $sqlp = "UPDATE freelance_propuesta SET estado='REVISIÓN' where id_freelance='$id_traductor' and id_codigo='$idproy'";
      $resp = mysqli_query($connect,$sqlp);

      $sqlrev = "INSERT INTO revision_obs(cod_proyecto,tipo_proyecto,cod_traductor,tipo_traductor,archivos,token) VALUES('$idproy','$tipo','$id_traductor','FREELANCE','".mysqli_real_escape_string($connect,$archtotal)."','$uid')";
      $resrev = mysqli_query($connect,$sqlrev);

      $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha,mensaje,random,traductor_asignado) values('$idproy','$elid','$ttipo','REVISIÓN','".mysqli_real_escape_string($connect,$archivostotal)."','$datetime','$comentario','$random','$id_traductor')";
      $resh = mysqli_query($connect,$sqlh);


    }else if ($translator_type=="TRAD"){
      if($contable=="yes"){
        foreach ($data["content"] as $content) {
          $language = $content['language'];
          $words = $content['words'];
          $wordsf = $content['wordsf'];
          $file = $content['archivo'];
          $nomfile = $content['nomarchivo'];

          $textocompleto = $content['textocompleto'];
          $textosolopalabras = $content['textosolopalabras'];
          $textocaracteres = $content['textocaracteres'];
          $textonumeros = $content['textonumeros'];
          $cantsolopalabras = $content['cantsolopalabras'];
          $cantnumeros = $content['cantnumeros'];
          $cantcaracteres = $content['cantcaracteres'];
          $cantcompleto = $content['cantcompleto'];

          $filess = '  <a target=_blank href='.$file.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfile.'</button></a> ';

          $sql = "INSERT INTO revision_words (cod_proyecto,tipo,traductor,archivos,idiomas,num_words,num_wordsf,fecha,random,tipo_traductor,text_onlywords,text_complete,num_wordsc,text_numbers,num_numbers,text_characters,num_characters) values('$idproy','$tipo','$id_traductor','".mysqli_real_escape_string($connect,$filess)."','$language','$words','$wordsf','$fecha','$random','TRADLIMAC','".mysqli_real_escape_string($connect,$textosolopalabras)."','".mysqli_real_escape_string($connect,$textocompleto)."','$cantcompleto','$textonumeros','$cantnumeros','$textocaracteres','$cantcaracteres')";
          $res = mysqli_query($connect,$sql);
        }

      }

      foreach ($data["content"] as $contenido){

        $filex = $contenido['archivo'];
        $nomfilex = $contenido['nomarchivo'];

        // Obtenemos la extencion del archivo
        $nomfilex_explode = explode(".",$nomfilex);
        $extension = end($nomfilex_explode);
        if ($extension=="docx"){
          $icon = '<i class="fa fa-file-word-o word" aria-hidden="true"></i>';
          $tarjet = '_self';
        } else if ($extension=="pdf") {
          $icon = '<i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i>';
          $tarjet = '_blank';
        } else {
          $icon = '<i class="fa fa-file-text" aria-hidden="true"></i>';
          $tarjet = '_blank';
        }

        $archivostotal.= '<a target='.$tarjet.' href='.$filex.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfilex.'</button></a> ';
        $archtotal.= '<a class="archicoDoc" target='.$tarjet.' href='.$filex.'><div class="contenedor">'.$icon.' '.$nomfilex.'</div></a> ';

      }

      // $sqlp = "UPDATE freelance_propuesta SET estado='REVISIÓN' where id_freelance='$personal' and id_codigo='$idproy'";
      // $resp = mysqli_query($connect,$sqlp);

      $sqlrev = "INSERT INTO revision_obs(cod_proyecto,tipo_proyecto,cod_traductor,tipo_traductor,archivos,token) VALUES('$idproy','$tipo','$id_traductor','TRADLIMAC','".mysqli_real_escape_string($connect,$archtotal)."','$uid')";
      $resrev = mysqli_query($connect,$sqlrev);

      $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha,mensaje,random,traductor_asignado) values('$idproy','$elid','$ttipo','REVISIÓN','".mysqli_real_escape_string($connect,$archivostotal)."','$datetime','$comentario','$random','$id_traductor')";
      $resh = mysqli_query($connect,$sqlh);

    }

  }//explora cada traductor

  $sqlc = "UPDATE cotizacion_limac set visto_bueno='Si',status='REVISIÓN',archivos_vistobueno='".mysqli_real_escape_string($connect,$archivostotal)."' where concat(`id_cotizacion`,`date_code`)='$idproy'";
  $resc = mysqli_query($connect,$sqlc);

  $NewDate = date('Y-m-d H:i', strtotime($delivered . " +15 days"));

  $addes = explode(',',$correo);

  foreach ($addes as $ads) {
    $uslim = "SELECT * FROM usuarios_limac where usuario='$correo'";
    $resuslim = mysqli_query($connect,$uslim);
    $reguslim = mysqli_fetch_array($resuslim,MYSQLI_ASSOC);
    $iduser = $reguslim['id_ul'];

    $NewDate = date('Y-m-d H:i', strtotime($delivered . " +15 days"));

    $autologin = "INSERT INTO autologin_vobo(id_user,token,cotizacion,created) values('$iduser','$uid','$idproy','$NewDate')";
    $res_autologin = mysqli_query($connect,$autologin);

  }


  $asunto='【REVISIÓN DE PROYECTO Nº '.$idproy.''.$reclamante.'】';

  //////////

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
                  <b><br>".$est.$nombre.":</b>
                  <p style='text-align: justify;'>Como parte de nuestro proceso de calidad, sírvase ingresar en el siguiente botón para que pueda revisar la traducción de su proyecto para su visto bueno
                  o enviarnos sus respectivas observaciones:<br></p>
                  <img border='0' src='https://www.limac.com.pe/mail/tracking_rev.php?id=".$randomletter."&to=".$correo."&numproy=".$idproy."&tipo=COTIZACION' style='display:none;' />";

  $mensaje.="<table width='100%' height='auto'>
                <tbody>
                <tr>
                  <td style='text-align:center;'><a href='https://".$site."/review/?t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button4.png'></a></td>
                </tr>
              </tbody></table>";

  if($comentario!=''){

    $mensaje.="
    <div style='padding-top: 8px;padding-bottom: 8px;'>
        <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
          <tr>
            <td><div style='display: inline-block;top: -8px;margin-left: 15px;position: relative;'><b>Comentarios:</b><br>".$comentario;
    $mensaje.="</div></td>
          </tr>
        </table>
    </div><hr>";

  }
  
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

  if($tipocot=='LANGUAGEHIVE'){
    foreach( $url as $key => $u ) {
      $mail->AddStringAttachment(file_get_contents($u),$filename[$key],$encoding,$type);
    }
  }else{
    foreach( $url as $key => $u ) {
      $mail->AddStringAttachment(file_get_contents($u),$filename[$key],$encoding,$type);
    }
  }


  if($mail->Send())
  {
  //$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
  echo 'Revisión enviada';
  }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


} else if($tipo=="SHOPPINGCART"){

$sql2 = "SELECT * FROM pedidos_traducciones WHERE id_traduccion='$idproy'";
$res2 = mysqli_query($connect,$sql2);
$reg2 = mysqli_fetch_array($res2,MYSQLI_ASSOC);

$usuario_limac = $reg2['usuario_limac'];
$delivered = $reg2['delivered'];
$monedacot = $reg2['currency'];

if($monedacot=='soles'){
  $symbol='S/';
  $valores = "Valores expresados en nuevos soles (S/ ).";
  $eemail = $usfrom;
  $ename = "LIMAC";
  $site = "www.limac.com.pe";
  $elfooter="R&E TRADUCCIONES S.A.C.<br>'.$direccion.', Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL, 'es_PE');
  $datetime = date("Y-m-d H:i:s");
}

if($monedacot=='dolares'){
  $symbol='$';
  $valores = "Valores expresados en dólares americanos ($).";
  $eemail = $usfrom;
  $ename = "LIMAC";
  $site = "www.limac.com.pe";
  $elfooter="R&E TRADUCCIONES S.A.C.<br>'.$direccion.', Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL, 'es_PE');
  $datetime = date("Y-m-d H:i:s");
}

if($monedacot=='euros'){
  $symbol='€';
  $valores = "Valores expresados en euros (€).";
  $eemail = "ventas@limac.com.es";
  $ename = "LIMAC ESPAÑA";
  $site = "www.limac.com.es";
  $elfooter="LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
  date_default_timezone_set('Europe/Madrid');
  setlocale(LC_ALL, 'es_ES');
  $datetime = date("Y-m-d H:i:s");
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

$uid = getGUID();

$archivostotal = '';

foreach ($obj as $data) { //explora cada traductor
  $personal = $data['personal'];
  $contable = $data['contable'];

  $translator_type = substr($personal, -4);//TRAD o FREE
  $id_traductor = substr( $personal, 0, strrpos( $personal, $translator_type ) );//id trad

  $random = substr(md5(uniqid(rand(1,6))), 0, 12);
  $archtotal = '';

  if($translator_type=="FREE"){

    if($contable=="yes"){

      foreach ($data["content"] as $content) {
          $language = $content['language'];
          $words = $content['words'];
          $wordsf = $content['wordsf'];
          $file = $content['archivo'];
          $nomfile = $content['nomarchivo'];

          $textocompleto = $content['textocompleto'];
          $textosolopalabras = $content['textosolopalabras'];
          $textocaracteres = $content['textocaracteres'];
          $textonumeros = $content['textonumeros'];
          $cantsolopalabras = $content['cantsolopalabras'];
          $cantnumeros = $content['cantnumeros'];
          $cantcaracteres = $content['cantcaracteres'];
          $cantcompleto = $content['cantcompleto'];

          $filess = '  <a target=_blank href='.$file.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfile.'</button></a> ';

          $sql = "INSERT INTO revision_words (cod_proyecto,tipo,traductor,archivos,idiomas,num_words,num_wordsf,fecha,random,tipo_traductor,text_onlywords,text_complete,num_wordsc,text_numbers,num_numbers,text_characters,num_characters) values('$idproy','$tipo','$id_traductor','".mysqli_real_escape_string($connect,$filess)."','$language','$words','$wordsf','$fecha','$random','FREELANCE','".mysqli_real_escape_string($connect,$textosolopalabras)."','".mysqli_real_escape_string($connect,$textocompleto)."','$cantcompleto','$textonumeros','$cantnumeros','$textocaracteres','$cantcaracteres')";
          $res = mysqli_query($connect,$sql);
      }

    }

    foreach ($data["content"] as $contenido){

      $filex = $contenido['archivo'];
      $nomfilex = $contenido['nomarchivo'];

      // Obtenemos la extencion del archivo
      $nomfilex_explode = explode(".",$nomfilex);
      $extension = end($nomfilex_explode);
      if ($extension=="docx"){
        $icon = '<i class="fa fa-file-word-o word" aria-hidden="true"></i>';
        $tarjet = '_self';
      } else if ($extension=="pdf") {
        $icon = '<i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i>';
        $tarjet = '_blank';
      } else {
        $icon = '<i class="fa fa-file-text" aria-hidden="true"></i>';
        $tarjet = '_blank';
      }

      $archivostotal.= '<a target='.$tarjet.' href='.$filex.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfilex.'</button></a> ';
      $archtotal.= '<a target='.$tarjet.' href='.$filex.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;">'.$icon.' '.$nomfilex.'</button></a> ';

    }

    $sqlp = "UPDATE freelance_propuesta SET estado='REVISIÓN' where id_freelance='$id_traductor' and id_codigo='$idproy'";
    $resp = mysqli_query($connect,$sqlp);

    $sqlrev = "INSERT INTO revision_obs(cod_proyecto,tipo_proyecto,cod_traductor,tipo_traductor,archivos,token) VALUES('$idproy','$tipo','$id_traductor','FREELANCE','".mysqli_real_escape_string($connect,$archtotal)."','$uid')";
    $resrev = mysqli_query($connect,$sqlrev);

    $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha,mensaje,random,traductor_asignado) values('$idproy','$elid','$ttipo','REVISIÓN','".mysqli_real_escape_string($connect,$archivostotal)."','$datetime','$comentario','$random','$id_traductor')";
    $resh = mysqli_query($connect,$sqlh);


  } else if ($translator_type=="TRAD"){


    if($contable=="yes"){

      foreach ($data["content"] as $content) {
          $language = $content['language'];
          $words = $content['words'];
          $wordsf = $content['wordsf'];
          $file = $content['archivo'];
          $nomfile = $content['nomarchivo'];

          $textocompleto = $content['textocompleto'];
          $textosolopalabras = $content['textosolopalabras'];
          $textocaracteres = $content['textocaracteres'];
          $textonumeros = $content['textonumeros'];
          $cantsolopalabras = $content['cantsolopalabras'];
          $cantnumeros = $content['cantnumeros'];
          $cantcaracteres = $content['cantcaracteres'];
          $cantcompleto = $content['cantcompleto'];

          $filess = '  <a target=_blank href='.$file.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfile.'</button></a> ';

          $sql = "INSERT INTO revision_words (cod_proyecto,tipo,traductor,archivos,idiomas,num_words,num_wordsf,fecha,random,tipo_traductor,text_onlywords,text_complete,num_wordsc,text_numbers,num_numbers,text_characters,num_characters) values('$idproy','$tipo','$id_traductor','".mysqli_real_escape_string($connect,$filess)."','$language','$words','$wordsf','$fecha','$random','TRADLIMAC','".mysqli_real_escape_string($connect,$textosolopalabras)."','".mysqli_real_escape_string($connect,$textocompleto)."','$cantcompleto','$textonumeros','$cantnumeros','$textocaracteres','$cantcaracteres')";
          $res = mysqli_query($connect,$sql);
      }

    }

    foreach ($data["content"] as $contenido){

      $filex = $contenido['archivo'];
      $nomfilex = $contenido['nomarchivo'];

      // Obtenemos la extencion del archivo
      $nomfilex_explode = explode(".",$nomfilex);
      $extension = end($nomfilex_explode);
      if ($extension=="docx"){
        $icon = '<i class="fa fa-file-word-o word" aria-hidden="true"></i>';
        $tarjet = '_self';
      } else if ($extension=="pdf") {
        $icon = '<i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i>';
        $tarjet = '_blank';
      } else {
        $icon = '<i class="fa fa-file-text" aria-hidden="true"></i>';
        $tarjet = '_blank';
      }

      $archivostotal.= '<a target=_blank href='.$filex.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;"><i class="fa fa-file-text" aria-hidden="true"></i> '.$nomfilex.'</button></a> ';
      $archtotal.= '<a target=_blank href='.$filex.'><button type="button" class="btn btn-default btn-sm" style="margin-right:5px;margin-bottom:5px;">'.$icon.' '.$nomfilex.'</button></a> ';

    }

    // $sqlp = "UPDATE freelance_propuesta SET estado='REVISIÓN' where id_freelance='$personal' and id_codigo='$idproy'";
    // $resp = mysqli_query($connect,$sqlp);

    $sqlrev = "INSERT INTO revision_obs(cod_proyecto,tipo_proyecto,cod_traductor,tipo_traductor,archivos,token) VALUES('$idproy','$tipo','$id_traductor','TRADLIMAC','".mysqli_real_escape_string($connect,$archtotal)."','$uid')";
    $resrev = mysqli_query($connect,$sqlrev);

    $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha,mensaje,random,traductor_asignado) values('$idproy','$elid','$ttipo','REVISIÓN','".mysqli_real_escape_string($connect,$archivostotal)."','$datetime','$comentario','$random','$id_traductor')";
    $resh = mysqli_query($connect,$sqlh);

  }

}//explora cada traductor

$sqlp = "UPDATE pedidos_traducciones set archivos_trad1='".mysqli_real_escape_string($connect,$archivostotal)."',estado='REVISIÓN' where id_traduccion='$idproy'";
$resp = mysqli_query($connect,$sqlp);

$NewDate = date('Y-m-d H:i', strtotime($delivered . " +15 days"));

$uslim = "SELECT * FROM usuarios_limac where usuario='$correo'";
$resuslim = mysqli_query($connect,$uslim);
$reguslim = mysqli_fetch_array($resuslim,MYSQLI_ASSOC);
$iduser = $reguslim['id_ul'];

$autologin = "INSERT INTO autologin_vobo(id_user,token,cotizacion,created) values('$iduser','$uid','$idproy','$NewDate')";
$res_autologin = mysqli_query($connect,$autologin);


$asunto='【REVISIÓN DE PROYECTO Nº '.$idproy.''.$reclamante.'】';

//////////

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
                  <b><br>".$est.$nombre.":</b>
                  <p style='text-align: justify;'>
                    Como parte de nuestro proceso de calidad, sírvase ingresar en el siguiente botón para que pueda revisar la traducción de su proyecto para su visto bueno
                    o enviarnos sus respectivas observaciones:<br>
                  </p>
                  <img border='0' src='https://www.limac.com.pe/mail/tracking_rev.php?id=".$randomletter."&to=".$usuario_limac."&numproy=".$idproy."&tipo=SHOPPINGCART' style='display:none;' />";

  $mensaje.="<table width='100%' height='auto'>
                <tbody>
                <tr>
                  <td style='text-align:center;'><a href='https://".$site."/review/?t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button4.png'></a></td>
                </tr>
              </tbody></table>";

  if($comentario!=''){

    $mensaje.="
    <div style='padding-top: 8px;padding-bottom: 8px;'>
        <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
          <tr>
            <td><div style='display: inline-block;top: -8px;margin-left: 15px;position: relative;'><b>Comentarios:</b><br>".$comentario;
    $mensaje.="</div></td>
          </tr>
        </table>
    </div><hr>";

  }
  
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

  $mail->addAddress($usuario_limac);

  $mail->IsHTML(true);
  $mail->MsgHTML($mensaje);

  if($mail->Send())
  {
  //$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
  echo 'Revisión enviada';
  }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}//shoppingcart


////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','REVISION','$datetime','$nomadm ha enviado una revisión del proyecto al cliente $nombre','".$idproy."','$tipo')";
$resn = mysqli_query($connect,$sqln);


?>