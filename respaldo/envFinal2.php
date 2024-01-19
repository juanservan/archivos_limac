<?php //include("../bloque.php"); ?>
<?php
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
    require "../../../PHPMailer/PHPMailerAutoload.php";
	include_once "../../../variables.php";
?>

<?php 

	$id = $_POST['cot'];
	$files = $_POST['files'];
	$correo = $_POST['correo1'];
    $entrega = $_POST['entrega1'];
    $fecha = $_POST['fecha1'];
    $hora = $_POST['hora1'];
    $remitente = $_POST['remitente1'];
    $trust = $_POST['trust'];
    $copy = $_POST['copy'];
    $url = $_POST['link1'];
    $filename = $_POST['nombreff1'];
    $factura = $_POST['incluir_facturav1'];


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

    $uid = getGUID();

    $encoding = "base64";
    $type ="application/octet-stream";

    $incluyearchivos = $_POST['incluyearchivos'];
    $interno = $_POST['interno'];
    $elid = $_POST['elid'];
    $ttipo = $_POST['ttipo'];

    $tipocot = $_POST['tipocot'];

    $sql22 = "SELECT * FROM cotizacion_limac where concat(`id_cotizacion`,`date_code`)='$id'";
    $res22 = mysqli_query($connect,$sql22);
    $reg22 = mysqli_fetch_array($res22,MYSQLI_ASSOC);

    $nombre_cliente = $reg22['nombre_cliente'];
    $sexo = $reg22['sexo'];
    $empresa = $reg22['empresa'];
    $atencion = $reg22['atencion'];
    $at = $reg22['at'];
    $monedacot = $reg22['moneda'];
    $reclamante = $reg22['reclamante'];

    $SQLPS = "SELECT * FROM limac_pass where estado='ACTIVO'";
    $RQLPS = mysqli_query($connect,$SQLPS);
    $GQLPS = mysqli_fetch_array($RQLPS,MYSQLI_ASSOC);
    $usrname = $GQLPS['username'];
    $psword = $GQLPS['password'];
    $usfrom = $GQLPS['from'];

    $xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
    $rxcv = mysqli_query($connect,$xcv);
    $gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
    $txcv = $gxcv['numero'];

    $xcve = "SELECT * FROM telephone where estado='MOSTRAR_ESPANA'";
    $rxcve = mysqli_query($connect,$xcve);
    $gxcve = mysqli_fetch_array($rxcve,MYSQLI_ASSOC);
    $txcve = $gxcve['numero'];

    if($monedacot=='soles'){
        $symbol='S/';
        $valores = "Valores expresados en nuevos soles (S/ ).";
        $eemail = $usfrom;
        $ename = "LIMAC";
        $site = "www.limac.com.pe";
        $elfooter="R&E TRADUCCIONES S.A.C.<br>$direccion, Lima.<br>Teléfono: $txcv * Correo Electrónico: <a href='mailto:$usfrom'>$usfrom</a><br><br>";

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL, 'es_PE');
        $date = date("Y-m-d H:i");
    }

    if($monedacot=='dolares'){
        $symbol='$';
        $valores = "Valores expresados en dólares americanos ($).";
        $eemail = $usfrom;
        $ename = "LIMAC";
        $site = "www.limac.com.pe";
        $elfooter="R&E TRADUCCIONES S.A.C.<br>$direccion, Lima.<br>Teléfono: $txcv * Correo Electrónico: <a href='mailto:$usfrom'>$usfrom</a><br><br>";

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL, 'es_PE');
        $date = date("Y-m-d H:i");
    }

    if($monedacot=='euros'){
        $symbol='€';
        $valores = "Valores expresados en euros (€).";
        $eemail = "ventas@limac.com.es";
        $ename = "LIMAC ESPAÑA";
        $site = "www.limac.com.es";
        $elfooter="LIMAC<br>$direccion, Lima.<br>Teléfono: $txcve * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";

        date_default_timezone_set('Europe/Madrid');
        setlocale(LC_ALL, 'es_ES');
        $date = date("Y-m-d H:i");
    }
    

    


    if($incluyearchivos=='sifiles'){
        $sql11 = "UPDATE cotizacion_limac set status='FINALIZADO', archivos_final='$files' where concat(`id_cotizacion`,`date_code`)='$id'";
        $res11 = mysqli_query($connect,$sql11);

        $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha) values('$id','$elid','$ttipo','FINALIZADO','$files','$date')";
        $resh = mysqli_query($connect,$sqlh);

    } else {
        $sql11 = "UPDATE cotizacion_limac set status='FINALIZADO' where concat(`id_cotizacion`,`date_code`)='$id'";
        $res11 = mysqli_query($connect,$sql11);

        $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,fecha) values('$id','$elid','$ttipo','FINALIZADO','$date')";
        $resh = mysqli_query($connect,$sqlh);
    }


    $sfin = "SELECT * FROM freelance_propuesta where id_codigo='$id'";
    $rfin = mysqli_query($connect,$sfin);

    if(mysqli_num_rows($rfin)>0){
        $ssfin = "UPDATE freelance_propuesta set estado='FINALIZADO' WHERE id_codigo='$id'";
        $rrfin = mysqli_query($connect,$ssfin);
    }

    if($sexo=='Masculino' || $sexo=='male'){
        $est= "Estimado cliente: ";
    }

    if($sexo=='Femenino' || $sexo=='female'){
        $est= "Estimada cliente: ";
    }

    if($empresa=='Si'){
        $est = "Estimados Sres. $nombre_cliente: ";
    }

    $SQLB = "SELECT * FROM usuarios_limac where usuario='$correo'";
    $RSQLB = mysqli_query($connect,$SQLB);
    $GSQLB = mysqli_fetch_array($RSQLB,MYSQLI_ASSOC);
    $IDC = $GSQLB['id_ul'];

    if($var>10485760){

        $NewDate = date('Y-m-d H:i', strtotime($date . " +60 days"));
        $autologin = "INSERT INTO autologin_vobo(id_user,token,cotizacion,created) values('$IDC','$uid','$id','$NewDate')";
        $res_autologin = mysqli_query($connect,$autologin);

        $sqll = "INSERT INTO registro_vistobueno(codigo,tipo_proyecto,archivos,fecha) values('$id','COTIZACION','$files','$date')";
        $ress = mysqli_query($connect,$sqll);

    }



    function sendMessage2(){
        $id = $_POST['cot'];

        $content = array(
            "en" => "Se ha finalizado el proyecto"
            );

        $heading = array(
            "en" => "FINALIZADO - PROYECTO Nº ".$id
            );
        
        $fields = array(
            'app_id' => "5ee7a794-10d2-40a5-9570-124b3bc0786a",
            'included_segments' => array("Administrador"),
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $heading,
            'url' => 'https://www.limac.com.pe/nexus_admin/production/listado_v3_4.php'
        );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic NWIzOWMwYWYtMzJlOC00ZDA2LWI3NzEtNTA2ZjM2Njc1ZDE2'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
        
    $response2 = sendMessage2();
    $return2["allresponses"] = $response2;
    $return2 = json_encode( $return2);

    function sendMessage3(){
        $id = $_POST['cot'];

        $content = array(
            "en" => "Se ha finalizado el proyecto"
            );

        $heading = array(
            "en" => "FINALIZADO - PROYECTO Nº ".$id
            );
        
        $fields = array(
            'app_id' => "5ee7a794-10d2-40a5-9570-124b3bc0786a",
            'included_segments' => array("Traductores"),
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $heading,
            'url' => 'https://www.limac.com.pe/nexus_translator/production/listado_v3_4.php'
        );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic NWIzOWMwYWYtMzJlOC00ZDA2LWI3NzEtNTA2ZjM2Njc1ZDE2'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
        
    $response3 = sendMessage3();
    $return3["allresponses"] = $response3;
    $return3 = json_encode( $return3);

    
    if($interno!='interno'){

        //envio de correo

        $asunto='【PROYECTO FINALIZADO - PROYECTO Nº '.$id.' '.$reclamante.'】';


        ///////////////////////

        $mensaje = "
        <html>
        <body style='background:#a4a4a4;'>
            <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
                <tr>
                <td align='center'>
                    <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
                    <tr>
                        <td style='padding:0px;background:#FFF;'>
        <img border='0' src='https://www.limac.com.pe/mail/tracking_fin.php?id=".$randomletter."&to=".$correo."&numproy=".$id."&tipo=COTIZACION' style='display:none;' />";
        $mensaje.="<img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>";
        $mensaje.="</td>
                    </tr>
                    
                    <tr>
                    <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                        <b><br>$est</b><br>";

        if($atencion=='Si'){
            $mensaje.="<b> Atención: $at</b><br>";
        }

        if($entrega=='Recojo' || $entrega=='RecojoSurco' || $entrega=='RecojoLima'){
            $mensaje.= "<p style='text-align: justify;'>Hemos culminado satisfactoriamente con el proceso de traducción de su proyecto.";

            if($incluyearchivos=='sifiles' && $var<=10485760){
                $mensaje.= " Adicionalmente adjuntamos los archivos correspondientes.";
            } else if($incluyearchivos=='sifiles' && $var>10485760){
                $mensaje.= " Sírvase ingresar en el siguiente enlace para que pueda revisar los archivos: <div style='text-align:center;'> <a href='https://www.limac.com.pe/review/cc.php?t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></div>";
            }

            $mensaje.= " Puede recoger sus documentos en nuestras oficinas ";

            if($entrega=='RecojoSurco'){
                $mensaje.="en nuestra sede en Surco ";
            }
            if($entrega=='RecojoLima'){
                $mensaje.="en nuestra sede en Cercado de Lima ";
            }

            $mensaje.="el $fecha  en el horario de $hora Me despido cordialmente no sin antes volver a agradecer su preferencia.</p>";
        }

        if($entrega=='Correo'){
            $mensaje.= "<p style='text-align: justify;'>Hemos culminado satisfactoriamente con el proceso de traducción de su proyecto.";
            if($incluyearchivos=='sifiles' && $var<=10485760){
                $mensaje.= " Adicionalmente adjuntamos los archivos correspondientes.";
            } else if($incluyearchivos=='sifiles' && $var>10485760){
                $mensaje.= " Sírvase ingresar en el siguiente enlace para que pueda revisar los archivos: <div style='text-align:center;'> <a href='https://www.limac.com.pe/review/cc.php?t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></div>";
            }
            $mensaje.= " Si tiene alguna consulta no dude en comunicarse con nosotros, con gusto lo atenderemos. Me despido cordialmente no sin antes volver a agradecer su preferencia.</p>";
        }

        if($entrega=='EnvíoD'){
            $mensaje.= "<p style='text-align: justify;'>Hemos culminado satisfactoriamente con el proceso de traducción de su proyecto.";
            if($incluyearchivos=='sifiles' && $var<=10485760){
                $mensaje.= " Adicionalmente adjuntamos los archivos correspondientes.";
            } else if($incluyearchivos=='sifiles' && $var>10485760){
                $mensaje.= " Sírvase ingresar en el siguiente enlace para que pueda revisar los archivos: <div style='text-align:center;'> <a href='https://www.limac.com.pe/review/cc.php?t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></div>";
            }
            $mensaje.=" Sus documentos serán entregados el $fecha  en el horario de $hora Me despido cordialmente no sin antes volver a agradecer su preferencia.</p>";
        }

        if($entrega=='EnvíoP'){
            $mensaje.= "<p style='text-align: justify;'>Hemos culminado satisfactoriamente con el proceso de traducción de su proyecto.";
            if($incluyearchivos=='sifiles' && $var<=10485760){
                $mensaje.= " Adicionalmente adjuntamos los archivos correspondientes.";
            } else if($incluyearchivos=='sifiles' && $var>10485760){
                $mensaje.= " Sírvase ingresar en el siguiente enlace para que pueda revisar los archivos: <div style='text-align:center;'> <a href='https://www.limac.com.pe/review/cc.php?t=$uid'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></div>";
            }
            $mensaje.=" Procederemos con el envío de su traducción vía Olva Courier, sus documentos serán entregados en un plazo entre 3 a 7 días hábiles dependiendo de su ubicación. 
            Me despido cordialmente no sin antes volver a agradecer su preferencia.</p>";
        }


        $mensaje.="
        <div style='padding-top: 8px;padding-bottom: 8px;'>
            <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
            <tr>
                <td style='text-align:center;'><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'>* Si tiene alguna duda o inquietud puede escribirnos a <a href='mailto:$eemail'>$eemail</a> o llamarnos al ";

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
                    <tr style='background-color:#0093DF;'>
                        <td align='center' style='background-color:#0093DF;color:#FFF;'>
                            <br>
                            <img src='https://www.limac.com.pe/assets/images/mail/firma3.png'>
                        </td>
                    </tr>
                    <tr style='background-color:#0093DF;color:#FFF;'>
                        <td align='center' style='font-size: 12px;color:#FFF;text-decoration:none;'>
                            $elfooter
                        </td>
                    </tr>
                    </table>
                </td>
                </tr>
            </table>
            </body></html>";

        
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
        $addr = explode(',',$correo);
        foreach ($addr as $ad) {
            $mail->AddAddress( trim($ad) );
        }

        $copyr = explode(',',$copy);
        foreach ($copyr as $ccc) {
            $mail->AddCC( trim($ccc) );
        }
            
        $mail->IsHTML(true);
        $mail->Body = $mensaje;
                
            //if ($adjunto ["size"] > 0)
                //{
                
                //$mail->addAttachment($adjunto ["tmp_name"], $adjunto ["name"]);
                //}

        if($incluyearchivos=='sifiles' && $var<=10485760){
            foreach( $url as $key => $u ) {
            //echo "Url: ".$u.", Filename: ".$filename[$key]."<br>";
            $mail->AddStringAttachment(file_get_contents($u),$filename[$key],$encoding,$type);
            }
        }
        if ($factura == 'si') {
            $directorio = "../../../quotes/";

            // Iterar sobre cada archivo en el directorio
            $archivos = scandir($directorio);
            foreach ($archivos as $archivo) {
                // Filtrar archivos que contienen la cadena "105913142023" en el nombre
                if (strpos($archivo, $id) !== false) {
                    $rutaCompleta = $directorio . $archivo;
                    $mail->addAttachment($rutaCompleta, $archivo);
                }
            }
        }

        if($mail->Send())
        {
            //$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
            echo 'Traducción enviada';
        }


        if($trust=="si"){
            $mail2 = new PHPMailer();
            $mail2->CharSet = "UTF-8";
            //indico a la clase que use SMTP
            $mail2->IsSMTP();
            //permite modo debug para ver mensajes de las cosas que van ocurriendo
            //$mail->SMTPDebug = 2;
            //Debo de hacer autenticación SMTP
            $mail2->SMTPAuth = true;
            $mail2->SMTPSecure = "ssl";
            //indico el servidor de Gmail para SMTP
            $mail2->Host = "smtp.gmail.com";
            //indico el puerto que usa Gmail
            $mail2->Port = 465;
            //indico un usuario / clave de un usuario de gmail
            $mail2->Username = $usrname;
            $mail2->Password = $psword;
            $mail2->From = $usfrom;
            $mail2->FromName = "LIMAC";
            $mail2->Subject = "invitation";
            $mail2->addAddress('e3bf206486@invite.trustpilot.com');
            $mail2->IsHTML(true);
            $mail2->Body = '<script type="application/json+trustpilot">
            {
                "recipientName": "'.$nombre_cliente.'",
                "referenceId": "'.$id.'",
                "recipientEmail": "'.$correo.'"
                
            }
            </script>';
            $mail2->Send();
        }

    }

    ////////////////////////
    //// admin
    $sadm = "SELECT * FROM admin_limac where id_al='$elid'";
    $radm = mysqli_query($connect,$sadm);
    $gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
    $nomadm = $gadm['nombre']." ".$gadm['apellidos'];

    $sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','FINALIZADO','$date','$nomadm ha finalizado el proyecto del cliente $nombre_cliente','$id','COTIZACION')";
    $resn = mysqli_query($connect,$sqln);



?>