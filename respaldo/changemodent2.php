
<?php
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
	//$user_login=$_SESSION["admin"];
  date_default_timezone_set("America/Lima");
  setlocale(LC_ALL, 'es_PE');
  include_once "../../../variables.php";

  $datee = date("Y-m-d H:i");

  require "../../../PHPMailer/PHPMailerAutoload.php";
?>

<?php 

  $idproyecto = $_POST['idproyecto'];
  $forma = $_POST['forma'];
  $formato = $_POST['formato'];
  $elid = $_POST['elid'];
  $ttipo = $_POST['ttipo'];
  $tipocot = $_POST['tipocot'];

  $length = 10;
  $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);


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

    $sql = "UPDATE cotizacion_limac set tipo_entrega='$forma',formato_entrega='$formato' where concat(id_cotizacion,date_code)='$idproyecto'";
    $res = mysqli_query($connect,$sql);

    $sql2 = "select * from cotizacion_limac where concat(id_cotizacion,date_code)='$idproyecto'";
    $res2 = mysqli_query($connect,$sql2);
    $reg2 = mysqli_fetch_array($res2,MYSQLI_ASSOC);
    $correo = $reg2['correo_cliente'];
    $monedacot = $reg2['moneda'];
    $nomb = $reg['nombre_cliente'];
    $reclamante = $reg['reclamante'];

    if($monedacot=='soles'){
      $symbol='S/';
      $valores = "Valores expresados en nuevos soles (S/ ).";
      $eemail = $usfrom;
      $ename = "LIMAC";
      $site = "www.limac.com.pe";
      $elfooter="R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima..<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
    }

    if($monedacot=='dolares'){
      $symbol='$';
      $valores = "Valores expresados en dólares americanos ($).";
      $eemail = $usfrom;
      $ename = "LIMAC";
      $site = "www.limac.com.pe";
      $elfooter="R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima..<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
    }

    if($monedacot=='euros'){
      $symbol='€';
      $valores = "Valores expresados en euros (€).";
      $eemail = "ventas@limac.com.es";
      $ename = "LIMAC ESPAÑA";
      $site = "www.limac.com.es";
      $elfooter="LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
    }

    $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,mensaje,fecha) values('$idproyecto','$elid','$ttipo','CAMBIO DE ENTREGA','$forma - $formato','$datee')";
    $resh = mysqli_query($connect,$sqlh);

    $asunto='【CAMBIO DE TIPO DE ENTREGA - COTIZACIÓN Nº '.$idproyecto.' '.$reclamante.'】';

    ////////////////////

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

    $mensaje.="<p style='text-align: justify;'>Le notificamos que la forma de entrega de su traducción ha sido cambiada a:<br></p>";

    $mensaje.="
    <img border='0' src='https://www.limac.com.pe/mail/tracking_entt.php?id=".$randomletter."&to=".$correo."&numproy=".$idproyecto."&tipo=COTIZACION' style='display:none;' />
    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Tipo de Entrega:</b><br>".$forma."</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Formato de Entrega:</b><br>".$formato."</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td style='text-align:center;'><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Para mayor detalle sírvase ingresar en el siguiente enlace (INGRESAR) y darnos una respuesta.</b></div></td>
        </tr>
      </table>
    </div>";

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
                      Este documento contiene información personal, confidencial que van dirigidos única y 
                      exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundido. 
                      Está completamente prohibido realizar copias, parciales o totales, 
                      así como propagar su contenido a otras personas que no sean el destinatario. 
                      Si usted recibió este documento por error, sírvase informarlo al remitente y deshacerse del documento inmediatamente.
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
    $mail->addAddress($correo);
    $mail->IsHTML(true);
    $mail->MsgHTML($mensaje);

    /*foreach( $url as $key => $u ) {
      //echo "Url: ".$u.", Filename: ".$filename[$key]."<br>";
      $mail->AddStringAttachment(file_get_contents($u),$filename[$key],$encoding,$type);
     } */

    $mail->Send();

////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','CAMBIO_ENTREGA','$datee','$nomadm ha realizado un cambio de entrega al proyecto del cliente $nomb','$idproyecto','COTIZACION')";
$resn = mysqli_query($connect,$sqln);


?>