<?php 
  $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); 
  mysqli_set_charset($connect,"utf8"); 
  include ('../../../variables.php');

?>
<?php 

require '../../../socketio_php/vendor/autoload.php';
require "../../../PHPMailer/PHPMailerAutoload.php";
require '../../../MPDF57/mpdf.php';
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

date_default_timezone_set('America/Lima');
setlocale(LC_ALL, 'es_PE');


$tfree = $_POST['tfree'];
$ifree = $_POST['ifree'];
$cfree = $_POST['cfree'];
$fefree = $_POST['fefree'];
$fefreev1 = $_POST['fefreev1'];
$fefreev1DB = $fefreev1.':00';
$fpagofree = $_POST['fpagofree'];
$unit = $_POST['unit'];
$orden = $_POST['o'];
$enviar_correo = $_POST['enviar_correo'];

if($unit=='PAGINA'){
  $unidd = 'por página';
} else if($unit=='PALABRA'){
  $unidd = 'por palabra';
} else if($unit=='PROYECTO'){
  $unidd = 'por proyecto';
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


$elid = $_POST['elid'];
$ttipo = $_POST['ttipo'];
$codproyecto = $_POST['codproyecto'];

$tipotrad = $_POST['tipotrad'];
$filestr = $_POST['filestr'];

$created = date("Y-m-d H:i:s");
$fechaemision = date("Y-m-d H:i:s");

$datee = date_create($fefree);
$fefreel = date_format($datee,"Y-m-d H:i:s");

$fefreev = date_format($datee,"d-m-Y h:i A");
$fech_pago = date("d-m-Y",strtotime($fpagofree));

$gwf = "SELECT * FROM cotizacion_limac where concat(id_cotizacion,date_code)='$codproyecto'";
$rgwf = mysqli_query($connect,$gwf);
$reg_rgwf = mysqli_fetch_array($rgwf,MYSQLI_ASSOC);
$clientecot = $reg_rgwf['nombre_cliente'];

$reclamante = $regx['reclamante'];

$monedacot = $reg_rgwf['moneda'];
$fecha_entrega = ltrim($reg_rgwf['fecha_entrega']);

echo $fefreev1;
$correo_cliente = $reg_rgwf['correo_cliente'];
$tipo_entrega = $reg_rgwf['tipo_entrega'];
$subtotal = $reg_rgwf['subtotal'];
$total = $reg_rgwf['total'];
$remitente = $reg_rgwf['emisor'];
$conf_pago = $reg_rgwf['conf_pago'];
$discount = $reg_rgwf['dscto'];
$monto_dscto = $reg_rgwf['monto_dscto'];
$elcreado = date_create($reg_rgwf['created']);

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
  $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
}

if($monedacot=='dolares'){
  $symbol='$';
  $valores = "Valores expresados en dólares americanos ($).";
  $eemail = $usfrom;
  $ename = "LIMAC";
  $site = "www.limac.com.pe";
  $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
}

if($monedacot=='euros'){
  $symbol='€';
  $valores = "Valores expresados en euros (€).";
  $eemail = "ventas@limac.com.es";
  $ename = "LIMAC ESPAÑA";
  $site = "www.limac.com.es";
  $elfooter = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
}

//$fpr = "SELECT * FROM freelance_propuesta_reg where id_codigo='$codproyecto'";
//$sfpr = mysqli_query($connect,$fpr);
$fpr = "DELETE FROM freelance_propuesta_reg WHERE id_codigo='$codproyecto' and id_freelance='$tfree'";
$sfpr = mysqli_query($connect,$fpr);

$idtar="<tr><td style='text-align: center;background: #045D8B;color: #FFF;font-weight: 400;'>Unidad</td><td style='text-align: center;background: #045D8B;color: #FFF;font-weight: 400;'>Tarifa (S/)</td><td style='text-align: center;background: #045D8B;color: #FFF;font-weight: 400;'>Idiomas (Origen - Destino)</td></tr>";

foreach($ifree as $llave => $b) {
  $rr = "INSERT INTO freelance_propuesta_reg(id_codigo,idiomas,unidad,costo,id_freelance) values('$codproyecto','$b','$unit[$llave]','$cfree[$llave]','$tfree')";
  $ss = mysqli_query($connect,$rr);

  $unp = $unit[$llave];

  if($unp=='PAGINA'){
    $unipp = 'por página';
  } else if($unp=='PALABRA'){
    $unipp = 'por palabra';
  } else if($unp=='PROYECTO'){
    $unipp = 'por proyecto';
  }

  $idtar.="<tr><td style='text-align: center;background: #045D8B;color: #FFF;font-weight: 600;font-size: 1.6em;'>".$unipp."</td>
    <td style='text-align: center;background: #045D8B;color: #FFF;font-weight: 600;font-size: 1.6em;'>".$cfree[$llave]."</td>
    <td style='text-align: center;background: #045D8B;color: #FFF;font-weight: 600;font-size: 1.6em;'>".$b."</td>
  </tr>";

}

$ids = array();
$pds = array();

if($tfree=='Todos'){
    //$CVB = "SELECT * FROM personal_freelance WHERE estado='ACTIVO' and (correo_usuario='dlopezc90@gmail.com' or correo_usuario='cribilleros_90@hotmail.com')";
    $CVB = "SELECT * FROM personal_freelance WHERE estado='ACTIVO'";
    $RCVB = mysqli_query($connect,$CVB);    

    while($RGCVB = mysqli_fetch_array($RCVB,MYSQLI_ASSOC)){
        $idt = $RGCVB['id_per'];
        $cusr = $RGCVB['correo_usuario'];

        $ids[] = $cusr; 

        $mm = "SELECT * FROM freelance_propuesta WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
        $rmm = mysqli_query($connect,$mm);

        if(mysqli_num_rows($rmm)>0){
          $INS="UPDATE freelance_propuesta SET tipo_traduccion='$tipotrad',archivos='$filestr',fecha_entrega='$fefreel',fecha_pago='$fpagofree',created='$created',tipo_asignado='INDIVIDUAL' WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
          $RINS = mysqli_query($connect,$INS);

        } else {
          $INS = "INSERT INTO freelance_propuesta(id_freelance,id_codigo,tipo_traduccion,archivos,fecha_entrega,fecha_pago,created,tipo_asignado) values('$idt','$codproyecto','$tipotrad','$filestr','$fefreel','$fpagofree','$created','INDIVIDUAL')";
          $RINS = mysqli_query($connect,$INS);
        }

        $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$codproyecto','$elid','$ttipo','ASIGNAR_FREELANCE','$filestr','$idt','$created')";
        $resh = mysqli_query($connect,$sqlh);
    }

    $correos = implode(", ", $ids);

} else if($tfree=='TCERT'){
    //$CVB = "SELECT * FROM personal_freelance WHERE estado='ACTIVO' and (correo_usuario='dlopezc90@gmail.com' or correo_usuario='cribilleros_90@hotmail.com') and certificado='Si'";
    $CVB = "SELECT * FROM personal_freelance WHERE estado='ACTIVO' and certificado='Si'";
    $RCVB = mysqli_query($connect,$CVB);    

    while($RGCVB = mysqli_fetch_array($RCVB,MYSQLI_ASSOC)){
        $idt = $RGCVB['id_per'];
        $cusr = $RGCVB['correo_usuario'];

        $ids[] = $cusr;

        $mm = "SELECT * FROM freelance_propuesta WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
        $rmm = mysqli_query($connect,$mm);

        if(mysqli_num_rows($rmm)>0){
          $INS="UPDATE freelance_propuesta SET tipo_traduccion='$tipotrad',archivos='$filestr',fecha_entrega='$fefreel',fecha_pago='$fpagofree',created='$created',tipo_asignado='INDIVIDUAL' WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
          $RINS = mysqli_query($connect,$INS);

        } else {
          $INS = "INSERT INTO freelance_propuesta(id_freelance,id_codigo,tipo_traduccion,archivos,fecha_entrega,fecha_pago,created,tipo_asignado) values('$idt','$codproyecto','$tipotrad','$filestr','$fefreel','$fpagofree','$created','INDIVIDUAL')";
          $RINS = mysqli_query($connect,$INS);
        }

        $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$codproyecto','$elid','$ttipo','ASIGNAR_FREELANCE','$filestr','$idt','$created')";
        $resh = mysqli_query($connect,$sqlh);
    }

    $correos = implode(", ", $ids);

} else if($tfree=='TNOCERT'){
    //$CVB = "SELECT * FROM personal_freelance WHERE estado='ACTIVO' and (correo_usuario='dlopezc90@gmail.com' or correo_usuario='cribilleros_90@hotmail.com') and certificado='No'";
    $CVB = "SELECT * FROM personal_freelance WHERE estado='ACTIVO' and certificado='No'";
    $RCVB = mysqli_query($connect,$CVB);    

    while($RGCVB = mysqli_fetch_array($RCVB,MYSQLI_ASSOC)){
        $idt = $RGCVB['id_per'];
        $cusr = $RGCVB['correo_usuario'];

        $ids[] = $cusr; 

        $mm = "SELECT * FROM freelance_propuesta WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
        $rmm = mysqli_query($connect,$mm);

        if(mysqli_num_rows($rmm)>0){
          $INS="UPDATE freelance_propuesta SET tipo_traduccion='$tipotrad',archivos='$filestr',fecha_entrega='$fefreel',fecha_pago='$fpagofree',created='$created',tipo_asignado='INDIVIDUAL' WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
          $RINS = mysqli_query($connect,$INS);

        } else {
          $INS = "INSERT INTO freelance_propuesta(id_freelance,id_codigo,tipo_traduccion,archivos,fecha_entrega,fecha_pago,created,tipo_asignado) values('$idt','$codproyecto','$tipotrad','$filestr','$fefreel','$fpagofree','$created','INDIVIDUAL')";
          $RINS = mysqli_query($connect,$INS);

        }

        $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$codproyecto','$elid','$ttipo','ASIGNAR_FREELANCE','$filestr','$idt','$created')";
        $resh = mysqli_query($connect,$sqlh);    
    }

    $correos = implode(", ", $ids);

} else if($tfree=='POSTCERT'){

  //$CVB = "SELECT DISTINCT(`id_postulante`) FROM idiomas_trad_combinacion where certificado='Si' and `id_postulante`='240'";
  $CVB = "SELECT DISTINCT(`id_postulante`) FROM idiomas_trad_combinacion where certificado='Si'";
  $RCVB = mysqli_query($connect,$CVB);

  while($RGCVB = mysqli_fetch_array($RCVB,MYSQLI_ASSOC)){
    $idpost = $RGCVB['id_postulante'];

    $PST = "SELECT * FROM postulantes where idpostulantes='$idpost'";
    $RPST = mysqli_query($connect,$PST);
    $RGPST = mysqli_fetch_array($RPST,MYSQLI_ASSOC);

    $emailpost = $RGPST['email'];
    $nomapes = $RGPST['nombres'].' '.$RGPST['apellidos'];

    $pds[] = $emailpost;

    $zz = "SELECT * FROM personal_freelance WHERE correo_usuario='$emailpost'";
    $rzz = mysqli_query($connect,$zz);

    if(mysqli_num_rows($rzz)<1){
      $gmw = "INSERT INTO personal_freelance (nombres_apellidos,correo_usuario,clave,certificado,created) VALUES ('$nomapes','$emailpost','0000','Si','$created')";
      $rgmw = mysqli_query($connect,$gmw);
    }

    $kk = "SELECT * FROM personal_freelance WHERE correo_usuario='$emailpost'";
    $rkk = mysqli_query($connect,$kk);
    $rgkk = mysqli_fetch_array($rkk,MYSQLI_ASSOC);
    $idt = $rgkk['id_per'];


    $mm = "SELECT * FROM freelance_propuesta WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
    $rmm = mysqli_query($connect,$mm);

    if(mysqli_num_rows($rmm)>0){
      $INS="UPDATE freelance_propuesta SET tipo_traduccion='$tipotrad',archivos='$filestr',fecha_entrega='$fefreel',fecha_pago='$fpagofree',created='$created',tipo_asignado='INDIVIDUAL' WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
      $RINS = mysqli_query($connect,$INS);

    } else {
      $INS = "INSERT INTO freelance_propuesta(id_freelance,id_codigo,tipo_traduccion,archivos,fecha_entrega,fecha_pago,created,tipo_asignado) values('$idt','$codproyecto','$tipotrad','$filestr','$fefreel','$fpagofree','$created','INDIVIDUAL')";
      $RINS = mysqli_query($connect,$INS);

    }

    $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$codproyecto','$elid','$ttipo','ASIGNAR_FREELANCE','$filestr','$idt','$created')";
    $resh = mysqli_query($connect,$sqlh);

  }


} else if($tfree=='POSTNOCERT'){

  //$CVB = "SELECT DISTINCT(`id_postulante`) FROM idiomas_trad_combinacion AS DFRR where (select Count(*) from idiomas_trad_combinacion where `idiomas_trad_combinacion`.`id_postulante`=DFRR.`id_postulante` and `idiomas_trad_combinacion`.`certificado`='Si')<1 and `id_postulante`='240'";
  $CVB = "SELECT DISTINCT(`id_postulante`) FROM idiomas_trad_combinacion AS DFRR where (select Count(*) from idiomas_trad_combinacion where `idiomas_trad_combinacion`.`id_postulante`=DFRR.`id_postulante` and `idiomas_trad_combinacion`.`certificado`='Si')<1";
  $RCVB = mysqli_query($connect,$CVB);

  while($RGCVB = mysqli_fetch_array($RCVB,MYSQLI_ASSOC)){
    $idpost = $RGCVB['id_postulante'];

    $PST = "SELECT * FROM postulantes where idpostulantes='$idpost'";
    $RPST = mysqli_query($connect,$PST);
    $RGPST = mysqli_fetch_array($RPST,MYSQLI_ASSOC);

    $emailpost = $RGPST['email'];
    $nomapes = $RGPST['nombres'].' '.$RGPST['apellidos'];

    $pds[] = $emailpost;

    $zz = "SELECT * FROM personal_freelance WHERE correo_usuario='$emailpost'";
    $rzz = mysqli_query($connect,$zz);

    if(mysqli_num_rows($rzz)<1){
      $gmw = "INSERT INTO personal_freelance (nombres_apellidos,correo_usuario,clave,certificado,created) VALUES ('$nomapes','$emailpost','0000','No','$created')";
      $rgmw = mysqli_query($connect,$gmw);
    }

    $kk = "SELECT * FROM personal_freelance WHERE correo_usuario='$emailpost'";
    $rkk = mysqli_query($connect,$kk);
    $rgkk = mysqli_fetch_array($rkk,MYSQLI_ASSOC);
    $idt = $rgkk['id_per'];

    $mm = "SELECT * FROM freelance_propuesta WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
    $rmm = mysqli_query($connect,$mm);

    if(mysqli_num_rows($rmm)>0){
      $INS="UPDATE freelance_propuesta SET tipo_traduccion='$tipotrad',archivos='$filestr',fecha_entrega='$fefreel',fecha_pago='$fpagofree',created='$created',tipo_asignado='INDIVIDUAL' WHERE id_freelance='$idt' and id_codigo='$codproyecto'";
      $RINS = mysqli_query($connect,$INS);

    } else {
      $INS = "INSERT INTO freelance_propuesta(id_freelance,id_codigo,tipo_traduccion,archivos,fecha_entrega,fecha_pago,created,tipo_asignado) values('$idt','$codproyecto','$tipotrad','$filestr','$fefreel','$fpagofree','$created','INDIVIDUAL')";
      $RINS = mysqli_query($connect,$INS);

    }

    $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$codproyecto','$elid','$ttipo','ASIGNAR_FREELANCE','$filestr','$idt','$created')";
    $resh = mysqli_query($connect,$sqlh);

  }

} else {

  $mm = "SELECT * FROM freelance_propuesta WHERE id_freelance='$tfree' and id_codigo='$codproyecto'";
  $rmm = mysqli_query($connect,$mm);

  if(mysqli_num_rows($rmm)>0){
      $sql = "UPDATE freelance_propuesta SET tipo_traduccion='$tipotrad',archivos='$filestr',fecha_entrega='$fefreel',fecha_pago='$fpagofree',created='$created',tipo_asignado='INDIVIDUAL' WHERE id_freelance='$tfree' and id_codigo='$codproyecto'";
      $res = mysqli_query($connect,$sql);
  } else {
      $sql = "INSERT INTO freelance_propuesta(id_freelance,id_codigo,tipo_traduccion,archivos,fecha_entrega,fecha_pago,created,tipo_asignado) values('$tfree','$codproyecto','$tipotrad','$filestr','$fefreel','$fpagofree','$created','INDIVIDUAL')";
      $res = mysqli_query($connect,$sql);
  }


  $sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$codproyecto','$elid','$ttipo','ASIGNAR_FREELANCE','$filestr','$tfree','$created')";
  $resh = mysqli_query($connect,$sqlh);

  $sqlp = "SELECT * FROM personal_freelance where id_per='$tfree'";
  $resp = mysqli_query($connect,$sqlp);
  $regp = mysqli_fetch_array($resp,MYSQLI_ASSOC);

  $nomtrad = $regp['nombres_apellidos'];
  $correoza = $regp['correo_usuario'];
  $length = 10;
  $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

    $asunto ="【PROPUESTA - PROYECTO DE TRADUCCIÓN N° ".$codproyecto." ".$reclamante."】";

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
                      <b><br>Estimado(a) ".$nomtrad.":</b>
                      <p>Tenemos una propuesta para la traducción de unos documentos:<br><br></p>
    <img border='0' src='https://www.limac.com.pe/mail/tracking_propuesta.php?id=".$randomletter."&to=".$correoza."&numproy=".$codproyecto."&tipo=COTIZACION' style='display:none;' />";

    $mensaje.="
    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'><tbody>".$idtar."</tbody></table><hr>
    </div>

    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>";
        
        if (empty($fefreev1)) {
          $mensaje.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Fecha de Entrega:</b><br>".$fefreel."</div></td>";
        }else{
          $mensaje.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Fecha de Entrega:</b><br>".$fefreev1."</div></td>";
        }
        
        $mensaje.="
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Tipo de proyecto:</b><br>".$tipotrad."</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Fecha de pago:</b><br>".$fech_pago."</div></td>
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


    $mensaje.="<br>
            <table width='100%' height='auto'>
            <tbody>
            <tr>
              <td style='text-align:center;'><a href='https://www.limac.com.pe/autofree/?I=".$tfree."&t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
            </tr>
          </tbody></table>";

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
                          <td style="padding: 0px;">
                            <a href="https://www.facebook.com/LimacOficial" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24">
                            </a>
                          </td>

                          <td width="1"></td>
                          <td>
                            <a href="https://twitter.com/LimacOficial" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24">
                            </a>
                          </td>
                          <td width="1"></td>
                          <td style="padding: 0px;">
                            <a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png" width="24">
                            </a>
                          </td>
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
    $mail->From = $usfrom;
    $mail->FromName = "LIMAC";
    $mail->Subject = $asunto;

    $mail->addAddress($correoza);

    /*$addr = explode(',',$correos);

    foreach ($addr as $ad) {
      $mail->AddAddress( trim($ad) );
    }*/

    $mail->IsHTML(true);

    $mail->MsgHTML($mensaje);

    if($mail->Send()){
      echo "Confirmación de orden de servicio enviada";
    }


    //ELIMINAR PROPUESTAS ANTERIORES
    $mbb = "SELECT * FROM freelance_propuesta WHERE id_freelance!='$tfree' and id_codigo='$codproyecto'";
    $rbb = mysqli_query($connect,$mbb);

    if(mysqli_num_rows($rbb)>0){
      while($gbb = mysqli_fetch_array($rbb,MYSQLI_ASSOC)){
        $idfree = $gbb['id_freelance'];
        

        $zzw = "SELECT * FROM personal_freelance WHERE id_per='$idfree'";
        $rzzw = mysqli_query($connect,$zzw);
        $gzzw = mysqli_fetch_array($rzzw,MYSQLI_ASSOC);
        $cm_free = $gzzw['correo_usuario'];
        $nomtradE = $gzzw['nombres_apellidos'];


        $wdd = "DELETE FROM freelance_propuesta where id_freelance='$idfree' and id_codigo='$codproyecto'";
        $rdd = mysqli_query($connect,$wdd);

        $wddc = "DELETE FROM freelance_propuesta_reg where id_freelance='$idfree' and id_codigo='$codproyecto'";
        $rddc = mysqli_query($connect,$wddc);

        $length = 10;
        $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);


        $Wasunto ="【PROPUESTA ANULADA - PROYECTO DE TRADUCCIÓN N° ".$codproyecto." ".$reclamante."】";
    
        //////////////////////

        $Wmensaje = "
        <html>
        <body style='background:#a4a4a4;'>
              <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
                <tr>
                  <td align='center'>
                    <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
                      <tr>
                        <td style='padding:0px;background:#FFF;'>
                          <img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>
                        </td>
                    </tr>
                      
                    <tr>
                      <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                        <b><br>Estimado(a) $nomtradE:</b>
                        <p>La propuesta de traducción del proyecto Nº $codproyecto ya no se encuentra disponible por el momento o ya está siendo realizado por otro traductor, estaremos en contacto contigo para futuros proyectos.<br><br></p>
                        <img border='0' src='https://www.limac.com.pe/mail/tracking_reject.php?id=$randomletter&to=$cm_free&numproy=$codproyecto&tipo=COTIZACION' style='display:none;' />
                      </td>
                    </tr>";

        $Wmensaje.='<tr style="background:#FFF;">
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
                              <td style="padding: 0px;">
                                <a href="https://www.facebook.com/LimacOficial" target="_blank">
                                  <img src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24">
                                </a>
                              </td>
    
                              <td width="1"></td>
                              <td>
                                <a href="https://twitter.com/LimacOficial" target="_blank">
                                  <img src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24">
                                </a>
                              </td>
                              <td width="1"></td>
                              <td style="padding: 0px;">
                                <a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b" target="_blank">
                                  <img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png" width="24">
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>

                      </div>
                    </td>
                  </tr>';

        $Wmensaje.= "<tr style='background:#FFF;'>
                        <td align='left' style='font-size:10px; color:#aaa;background:#FFF;'>
                          <div style='margin-left:10px; margin-right:10px; margin-bottom: 10px;'>
                          IMPORTANTE/CONFIDENCIAL<br>
                          Este documento contiene información personal y confidencial que va dirigida única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundida. Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. Si usted recibió este mensaje por error, sírvase informarlo al remitente y deshacerse de cualquier documento inmediatamente.
                          <br><br>
                          </div>
                        </td>
                      </tr>
                      <tr style='background-color:#0093DF;'><td align='center' style='background-color:#0093DF;color:#FFF;'><br><img src='https://www.limac.com.pe/assets/images/mail/firma3.png'></td></tr>
                      <tr style='background-color:#0093DF;color:#FFF;'><td align='center' style='font-size: 12px;color:#FFF;text-decoration:none;'>$elfooter</td></tr>
                    </table>
                  </td>
                </tr>
              </table>
              </body></html>";

        $bmail = new PHPMailer;
        $bmail->CharSet = "UTF-8";
        //indico a la clase que use SMTP
        $bmail->IsSMTP();
        //permite modo debug para ver mensajes de las cosas que van ocurriendo
        //$mail->SMTPDebug = 2;
        //Debo de hacer autenticación SMTP
        $bmail->SMTPAuth = true;
        $bmail->SMTPSecure = "ssl";
        //indico el servidor de Gmail para SMTP
        $bmail->Host = "smtp.gmail.com";
        //indico el puerto que usa Gmail
        $bmail->Port = 465;
        //indico un usuario / clave de un usuario de gmail
        $bmail->Username = $usrname;
        $bmail->Password = $psword;
        $bmail->From = $usfrom;
        $bmail->FromName = "LIMAC";
        $bmail->Subject = $Wasunto;
        $bmail->addAddress($cm_free);
        $bmail->IsHTML(true);
        $bmail->MsgHTML($Wmensaje);
        $bmail->Send();


        $client = new Client(new Version2X('https://www.limac.com.pe:3002'));
        $client->initialize();
        $client->emit('removeProy', ['idtrad' => $idfree,'numcot'=>$codproyecto]);
        $client->close();

      }
    }
    ///////////////

}


$sqlb = "UPDATE cotizacion_limac set status='FREELANCE' where concat(`id_cotizacion`,`date_code`)='$codproyecto'";
$resb = mysqli_query($connect,$sqlb);



$dd = date_format($elcreado,"d");
$mm = date_format($elcreado,"M");

if($mm=='Jan'){ $mm='ENE';
} else if($mm=='Feb'){ $mm='FEB';
} else if($mm=='Mar'){ $mm='MAR';
} else if($mm=='Apr'){ $mm='ABR';
} else if($mm=='May'){ $mm='MAY';
} else if($mm=='Jun'){ $mm='JUN';
} else if($mm=='Jul'){ $mm='JUL';
} else if($mm=='Aug'){ $mm='AGO';
} else if($mm=='Sep'){ $mm='SET';
} else if($mm=='Oct'){ $mm='OCT';
} else if($mm=='Nov'){ $mm='NOV';
} else if($mm=='Dec'){ $mm='DIC';
} 

$yy = date_format($elcreado,"Y");


$uwf = "SELECT * FROM usuarios_limac where email='$correo_cliente'";
$ruwf = mysqli_query($connect,$uwf);
$reg_ruwf = mysqli_fetch_array($ruwf,MYSQLI_ASSOC);
$idul = $reg_ruwf['id_ul'];
$direccion = $reg_ruwf['direccion'];

$tt = explode(" ", $fecha_entrega);

$t1 = $tt[0]; //3 dias o 24 horas
$t2 = $tt[1]; //días u horas
$t3 = $tt[2]; //útil o calendario

function addWorkingHours($timestamp, $hoursToAdd, $skipWeekends = false)
{
  // Set constants
  $dayStart = 8;
  $dayEnd = 18;

  // For every hour to add
  for($i = 0; $i < $hoursToAdd; $i++)
  {
      // Add the hour
      $timestamp += 3600;

      // If the time is between 1800 and 0800
      if ((date('G', $timestamp) >= $dayEnd && date('i', $timestamp) >= 0 && date('s', $timestamp) > 0) || (date('G', $timestamp) < $dayStart))
      {
          // If on an evening
          if (date('G', $timestamp) >= $dayEnd)
          {
              // Skip to following morning at 08XX
              $timestamp += 3600 * ((24 - date('G', $timestamp)) + $dayStart);
          }
          // If on a morning
          else
          {
              // Skip forward to 08XX
              $timestamp += 3600 * ($dayStart - date('G', $timestamp));
          }
      }

      // If the time is on a weekend
      if ($skipWeekends && (date('N', $timestamp) == 7))
      //if ($skipWeekends && (date('N', $timestamp) == 7))
      {
          // Skip to Monday
          $timestamp += 3600 * (24 * (8 - date('N', $timestamp)));
      }
  }


  // Return
  return $timestamp;
}

function fecha_LIMACP($a,$b,$c){// 24 , horas, útiles
  $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL, 'es_PE');

  $sql = "SELECT * FROM feriados WHERE pais='PERU' and (estado!='JUEVES_SANTO' AND estado!='VIERNES_SANTO')";
  $res = mysqli_query($connect,$sql);

  $sql2 = "SELECT * FROM feriados WHERE pais='PERU' and (estado='JUEVES_SANTO' OR estado='VIERNES_SANTO')";
  $res2 = mysqli_query($connect,$sql2);

  $freedays = [];
  $freedaysT = [];

  while($regdays = mysqli_fetch_array($res,MYSQLI_ASSOC)){
    $freedays[] = $regdays['mes_dia'];
  }

  while($regdaysST = mysqli_fetch_array($res2,MYSQLI_ASSOC)){
    $freedaysT[] = $regdaysST['mes_dia'];
  }

  if($c=="útil" || $c=="útiles"){

    if($b=="horas" || $b=="hora"){

      if($a==1 || $a==3 || $a==6 || $a==12){

        // Usage
              $timestamp = time();
              $tt = addWorkingHours($timestamp, $a); // timestamp

              while($reg = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                $monthday = $reg['mes_dia'];
                //$freedays[] = $monthday;
                if(date("m-d",$tt)==$monthday){
                  $tt = $tt + 86400;
                }
              }

              $sc = date("d-m-Y h:i A", $tt);
            $scc = date("Y-m-d H:i", $tt);
            $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

            return array($sc, $scc, $NewDate);

              /*while($reg2 = mysqli_fetch_array($res2,MYSQLI_ASSOC)){
                $monthday2 = $reg2['mes_dia'];
                $freedaysT[] = $monthday2;
              }

              if(in_array( date("m-d",$tt) , $freedaysT )){
                $c=strtotime("monday 09:00");
                $sc = date("d-m-Y h:i A", $c);
              $scc = date("Y-m-d H:i", $c);
              $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
              } else if(in_array( date("m-d",$tt) , $freedays )){
                $tt = $tt + 86400;
                $sc = date("d-m-Y h:i A", $tt);
              $scc = date("Y-m-d H:i", $tt);
              $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
              }*/

      } else {

        if((date('H') >= 0 && date('H')<8) && (date('w')!=0 || date('w')==6)){
              $c = strtotime("now 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 13 && date('H')<24) && (date('w')==6)){ 
              $c = strtotime("next monday 08:00");
              $fecha = date('Y-m-d h:i A', $c);
            } else if((date('H') >= 18 && date('H')<24) && (date('w')!=0 && date('w')!=6 && date('w')!=5)){
              $c = strtotime("tomorrow 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 13 && date('H')<18) && (date('w')==5)){
              $c = strtotime("+1 day");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 18 && date('H')<24) && (date('w')==5)){
              $c = strtotime("monday 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if(date('w')==0){
              $c=strtotime("tomorrow 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if(in_array(date("m-d"), $freedays)){
              if(date('w')==5 || date('w')==6 || date('w')==0){
                $c = strtotime("monday 08:00");
                    $fecha = date("Y-m-d h:i A", $c);
              } else {
                $c = strtotime("tomorrow 08:00");
                    $fecha = date("Y-m-d h:i A", $c);
              }
            } else if(date('H') >= 8 && date('H')<18){
                $fecha = date('Y-m-d h:i A');
            }

        $d = new DateTime( $fecha );
        $t = $d->getTimestamp();

        // loop for X days
        for($i=0; $i<$a; $i++){

            // add 1 day to timestamp
            $addDay = 3600;
            // get what day it is next day
            $nextDay = date('w', ($t+$addDay));
            //get holidays date
            $dateHoliday = date('m-d',($t+$addDay));
            // if it's Saturday or Sunday get $i-1
            if($nextDay == 0 || in_array($dateHoliday, $freedaysT) || in_array($dateHoliday, $freedays)) {
                $i--;
            }
            // modify timestamp, add 1 day
            $t = $t+$addDay;
        }

        $d->setTimestamp($t);
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);
      }

    } else if($b=="día" || $b=="días"){

      if((date('H') >= 0 && date('H')<8) && (date('w')!=0 || date('w')==6)){
              $c = strtotime("now 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 13 && date('H')<24) && (date('w')==6)){ 
              $c = strtotime("next monday 08:00");
              $fecha = date('Y-m-d h:i A', $c);
            } else if((date('H') >= 18 && date('H')<24) && (date('w')!=0 && date('w')!=6 && date('w')!=5)){
              $c = strtotime("tomorrow 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 13 && date('H')<18) && (date('w')==5)){
              $c = strtotime("+1 day");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 18 && date('H')<24) && (date('w')==5)){
              $c = strtotime("monday 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if(date('w')==0){
              $c=strtotime("tomorrow 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if(in_array(date("m-d"), $freedays)){
              if(date('w')==5 || date('w')==6 || date('w')==0){
                $c = strtotime("monday 08:00");
                    $fecha = date("Y-m-d h:i A", $c);
              } else {
                $c = strtotime("tomorrow 08:00");
                    $fecha = date("Y-m-d h:i A", $c);
              }
            } else if(date('H') >= 8 && date('H')<18){
                $fecha = date('Y-m-d h:i A');
            }

          $d = new DateTime( $fecha );
        $t = $d->getTimestamp();
        // loop for X days
        for($i=0; $i<$a; $i++){

              // add 1 day to timestamp
              $addDay = 86400;
              // get what day it is next day
              $nextDay = date('w', ($t+$addDay));
              //get holidays date
              $dateHoliday = date('m-d',($t+$addDay));
              // if it's Saturday or Sunday get $i-1
              if($nextDay == 0 || in_array($dateHoliday, $freedaysT) || in_array($dateHoliday, $freedays)) {
                  $i--;
              }
              // modify timestamp, add 1 day
              $t = $t+$addDay;
        }

        $d->setTimestamp($t);
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);

    }//dia

  } else if($c=="calendario"){

    if($b=="horas" || $b=="hora"){
      $my_date_time = date("Y-m-d h:i A", strtotime("+$a hours"));
      $d = new DateTime( $my_date_time );
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);

    } else if($b=="día" || $b=="días") {

      $my_date_time = date("Y-m-d h:i A", strtotime("+$a days"));
      $d = new DateTime( $my_date_time );
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);

    }

  }

}

function fecha_LIMACES($a,$b,$c){
  $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
  date_default_timezone_set('Europe/Madrid');
    setlocale(LC_ALL, 'es_ES');

  $sql = "SELECT * FROM feriados WHERE pais='ESPAÑA'";
  $res = mysqli_query($connect,$sql);

  $freedays = [];

  while($regdays = mysqli_fetch_array($res,MYSQLI_ASSOC)){
    $freedays[] = $regdays['mes_dia'];
  }

  if($c=="útil" || $c=="útiles"){

    if($b=="horas" || $b=="hora"){

      if($a==1 || $a==3 || $a==6 || $a==12){

        // Usage
        $timestamp = time();
        $tt = addWorkingHours($timestamp, $a); // timestamp

        while($reg = mysqli_fetch_array($res,MYSQLI_ASSOC)){
          $monthday = $reg['mes_dia'];
          //$freedays[] = $monthday;
          if(date("m-d",$tt)==$monthday){
            $tt = $tt + 86400;
          }
        }

        $sc = date("d-m-Y h:i A", $tt);
        $scc = date("Y-m-d H:i", $tt);
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);
      } else {

        if((date('H') >= 0 && date('H')<8) && (date('w')!=0 || date('w')==6)){
            $c = strtotime("now 08:00");
            $fecha = date("Y-m-d h:i A", $c);
          } else if((date('H') >= 13 && date('H')<24) && (date('w')==6)){ 
            $c = strtotime("next monday 08:00");
            $fecha = date('Y-m-d h:i A', $c);
          } else if((date('H') >= 18 && date('H')<24) && (date('w')!=0 && date('w')!=6 && date('w')!=5)){
            $c = strtotime("tomorrow 08:00");
            $fecha = date("Y-m-d h:i A", $c);
          } else if((date('H') >= 13 && date('H')<18) && (date('w')==5)){
            $c = strtotime("+1 day");
            $fecha = date("Y-m-d h:i A", $c);
          } else if((date('H') >= 18 && date('H')<24) && (date('w')==5)){
            $c = strtotime("monday 08:00");
            $fecha = date("Y-m-d h:i A", $c);
          } else if(date('w')==0){
            $c=strtotime("tomorrow 08:00");
            $fecha = date("Y-m-d h:i A", $c);
          } else if(in_array(date("m-d"), $freedays)){
            if(date('w')==5 || date('w')==6 || date('w')==0){
              $c = strtotime("monday 08:00");
                  $fecha = date("Y-m-d h:i A", $c);
            } else {
              $c = strtotime("tomorrow 08:00");
                  $fecha = date("Y-m-d h:i A", $c);
            }
          } else if(date('H') >= 8 && date('H')<18){
              $fecha = date('Y-m-d h:i A');
          }

          $d = new DateTime( $fecha );
          $t = $d->getTimestamp();

          // loop for X days
          for($i=0; $i<$a; $i++){

            // add 1 day to timestamp
            $addDay = 3600;
            // get what day it is next day
            $nextDay = date('w', ($t+$addDay));
            //get holidays date
            $dateHoliday = date('m-d',($t+$addDay));
            // if it's Saturday or Sunday get $i-1
            if($nextDay == 0 || in_array($dateHoliday, $freedays)) {
                $i--;
            }
            // modify timestamp, add 1 day
            $t = $t+$addDay;
          }

          $d->setTimestamp($t);
          $sc = $d->format( 'd-m-Y h:i A' );
          $scc = $d->format( 'Y-m-d H:i' );
          $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

          return array($sc, $scc, $NewDate);
      }

    } else if($b=="día" || $b=="días"){

      if((date('H') >= 0 && date('H')<8) && (date('w')!=0 || date('w')==6)){
              $c = strtotime("now 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 13 && date('H')<24) && (date('w')==6)){ 
              $c = strtotime("next monday 08:00");
              $fecha = date('Y-m-d h:i A', $c);
            } else if((date('H') >= 18 && date('H')<24) && (date('w')!=0 && date('w')!=6 && date('w')!=5)){
              $c = strtotime("tomorrow 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 13 && date('H')<18) && (date('w')==5)){
              $c = strtotime("+1 day");
              $fecha = date("Y-m-d h:i A", $c);
            } else if((date('H') >= 18 && date('H')<24) && (date('w')==5)){
              $c = strtotime("monday 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if(date('w')==0){
              $c=strtotime("tomorrow 08:00");
              $fecha = date("Y-m-d h:i A", $c);
            } else if(in_array(date("m-d"), $freedays)){
              if(date('w')==5 || date('w')==6 || date('w')==0){
                $c = strtotime("monday 08:00");
                    $fecha = date("Y-m-d h:i A", $c);
              } else {
                $c = strtotime("tomorrow 08:00");
                    $fecha = date("Y-m-d h:i A", $c);
              }
            } else if(date('H') >= 8 && date('H')<18){
                $fecha = date('Y-m-d h:i A');
            }

          $d = new DateTime( $fecha );
        $t = $d->getTimestamp();
        // loop for X days
        for($i=0; $i<$a; $i++){

              // add 1 day to timestamp
              $addDay = 86400;
              // get what day it is next day
              $nextDay = date('w', ($t+$addDay));
              //get holidays date
              $dateHoliday = date('m-d',($t+$addDay));
              // if it's Saturday or Sunday get $i-1
              if($nextDay == 0 || in_array($dateHoliday, $freedays)) {
                  $i--;
              }
              // modify timestamp, add 1 day
              $t = $t+$addDay;
        }

        $d->setTimestamp($t);
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);

    }//dia

  } else if($c=="calendario"){

    if($b=="horas" || $b=="hora"){
      $my_date_time = date("Y-m-d h:i A", strtotime("+$a hours"));
      $d = new DateTime( $my_date_time );
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);

    } else if($b=="día" || $b=="días") {

      $my_date_time = date("Y-m-d h:i A", strtotime("+$a days"));
      $d = new DateTime( $my_date_time );
        $sc = $d->format( 'd-m-Y h:i A' );
        $scc = $d->format( 'Y-m-d H:i' );
        $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

        return array($sc, $scc, $NewDate);

    }

  }

}

if($t2=="mes" || $t2=="meses"){

  $fecha = date('d-m-Y h:i A');
  $sc = date("d-m-Y h:i A", strtotime("+$t1 months"));
  $scc = date("Y-m-d H:i", strtotime("+$t1 months"));

  if((date('H') >= 0 && date('H')<9) && (date('w')!=0 && date('w')!=6 && date('w')!=5)){
    $c = strtotime("now 09:00");
    $fecha = date("Y-m-d h:i A", $c);
    $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
    $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
    $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  }

  if(date('H') >= 17 || date('H')<24 || date('w')==0){
    $c=strtotime("tomorrow 09:00");
    $fecha = date("Y-m-d h:i A", $c);
    $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
    $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
    $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  }

  if(date('w')==6){
    $c=strtotime("monday 09:00");
    $fecha = date("Y-m-d h:i A", $c);
    $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
    $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
    $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  }

} else {

  if($monedacot=="soles" || $monedacot=="dolares"){
    $fch = fecha_LIMACP($t1,$t2,$t3);
    $sc = $fch[0];
    $scc = $fch[1];
    $NewDate = $fch[2];
  } else if($monedacot=="euros"){
    $fch = fecha_LIMACES($t1,$t2,$t3);
    $sc = $fch[0];
    $scc = $fch[1];
    $NewDate = $fch[2];
  }

}


//////////////////////


if($conf_pago=='Si'){
    $sqlb = "UPDATE cotizacion_limac set status='FREELANCE' where concat(`id_cotizacion`,`date_code`)='$codproyecto'";
    $resb = mysqli_query($connect,$sqlb);
} else {
    $length = 10;
    $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

    $regauto = "INSERT INTO autologin(id_user,token,cotizacion,created) values('$idul','$uid','$codproyecto','$NewDate')";
    $resregauto = mysqli_query($connect,$regauto);

    $sql222 = "INSERT INTO confirmaciones_pago (codigo,tipo,cliente,correo_cliente,fecha,moneda,monto_noigv,monto_igv,emisor) values('$codproyecto','COTIZACION','$clientecot','$correo_cliente','$fechaemision','$monedacot','$subtotal','$total','$remitente')";
    $res222 = mysqli_query($connect,$sql222);

    $sql333 = "DELETE from asignados where codigo = '$codproyecto'";
    $res333 = mysqli_query($connect,$sql333);

    //Identificar si es v1 o no
    $consulta = "select * from cotizacion_limac where tipoCot = '1' and concat(id_cotizacion,date_code)='$codproyecto'";
    $resul = mysqli_query($connect,$consulta);
    if (mysqli_num_rows($resul) > 0) {
      $fechaFormateada = date('d-m-Y h:i A', strtotime($fefreev1));
      $fechaFormateada2 = $fefreev1;
      $fechaFormateada2 .= ':00';

      $sqlbv = "UPDATE cotizacion_limac set status='FREELANCE', fecha_entrega = '$fechaFormateada', tiempo_entrega='[$fechaFormateada]', delivered='$fechaFormateada2', conf_pago='Si' where concat(`id_cotizacion`,`date_code`)='$codproyecto'";
      $resbv = mysqli_query($connect,$sqlbv);
    } else {
      $sqlbv = "UPDATE cotizacion_limac set status='FREELANCE', fecha_entrega = '$fecha_entrega [$sc]', tiempo_entrega='[$sc]', delivered='$scc', conf_pago='Si' where concat(`id_cotizacion`,`date_code`)='$codproyecto'";
      $resbv = mysqli_query($connect,$sqlbv);
    }
    


    if($orden=="Si"){

          ///confirmacion de pago
          $asunto2 ="【CONFIRMACIÓN DE ORDEN DE SERVICIO - COTIZACIÓN N° ".$codproyecto." " .$reclamante."】";

          //////////////////////////////////


          $mensaje2 = "
          <html>
          <body style='background:#a4a4a4;'>
                <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
                  <tr>
                    <td align='center'>
                      <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
                        <tr>
                          <td style='padding:0px;background:#FFF;'>";
          $mensaje2.="<img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>";
          $mensaje2.="</td>
                      </tr>
                        
                      <tr>
                        <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                            <b ><br>Estimado(a) cliente:</b>
                            <p style='text-align: justify;'>Hemos recibido la orden de servicio conforme, estamos empezando con el proceso de traducción de su proyecto.<br><br></p>
          <img border='0' src='https://www.limac.com.pe/mail/tracking_confo.php?id=".$randomletter."&to=".$correo_cliente."&numproy=".$codproyecto."&tipo=COTIZACION' style='display:none;' />";

          $mensaje2.="
          <div>
            <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
              <tr>
                <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon001.png'></div></td>
                <td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Tiempo de Entrega Estimado:</b><br>".$fecha_entrega." [".$sc."]</div></td>
              </tr>
            </table>
          </div>
          <hr>
          <div style='padding-top: 8px;padding-bottom: 8px;'>
            <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
              <tr>
                <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon002.png'></div></td>
                <td><div style='display: inline-block;top: 0px;    margin-left: 15px;position: relative;'><b>Forma de Entrega:</b><br>".$tipo_entrega."</div></td>
              </tr>
            </table>
          </div>
          <hr>";

          if($tfree!='Todos' || $tfree!='TCERT' || $tfree!='TNOCERT'){

            $mensaje2.="
            <div style='padding-top: 8px;padding-bottom: 8px;'>
                <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
                  <tr>
                    <td style='width:60px;'><div style='display: inline-block;top: 0px;position: relative;'><img src='https://www.limac.com.pe/assets/images/mail/icon003.png'></div></td>
                    <td><div style='display: inline-block;top: -8px;    margin-left: 15px;position: relative;'><b>Traductor Asignado:</b><br>".$nomtrad."</div></td>
                  </tr>
                </table>
            </div><hr>";

          }

          if($tipotrad!="Traducción Simple"){
            $mensaje2.="<br><div style='margin-bottom:12px;'> Sírvase ingresar en el siguiente enlace y completar un formulario con la finalidad de programar el envío de sus documentos en caso haya solicitado la entrega impresa o requiera una boleta/factura electrónica.</div>
                    <table width='100%' height='auto'>
                    <tbody>
                    <tr>
                      <td style='text-align:center;'><a href='https://".$site."/autologin/?I=".$idul."&t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
                    </tr>
                  </tbody></table>";

          }

          $mensaje2.="</td></tr>";

          $mensaje2.='<tr style="background:#FFF;">
                      <td align="left" style="background:#FFF;">
                        <p style="margin-left:10px; margin-right:10px;font-size:16px;">Cordialmente,<br><br>
                        Departamento de Ventas.</p></td>
                    </tr><tr>
                      <td align="left">
                        <div style="margin-left:10px !important;margin-right:10px !important;">
                          

                          <img src="https://www.limac.com.pe/assets/images/logos/logo_color2.jpg" width="150"
                          style="border:0px;vertical-align:middle;margin-bottom: 20px;"><br>
                          <div>
                            '.$address1.'<br>
                            '.$address2.',<br> Lima, República del Perú<br>
                            (511) (01) 700 9040<br>
                            <a href="mailto:ventas@limac.com.pe" target="_blank">ventas@limac.com.pe</a><br><a href="http://www.limac.com.pe" target="_blank">www.limac.com.pe</a>
                          </div>
                          
                          <table style="border-spacing: 0px;margin-top: 15px;">
                            <tbody>
                              <tr>
                                <td style="padding: 0px;">
                                  <a href="https://www.facebook.com/LimacOficial" target="_blank">
                                    <img src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24">
                                  </a>
                                </td>
      
                                <td width="1"></td>
                                <td>
                                  <a href="https://twitter.com/LimacOficial" target="_blank">
                                    <img src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24">
                                  </a>
                                </td>
                                <td width="1"></td>
                                <td style="padding: 0px;">
                                  <a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b" target="_blank">
                                    <img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png" width="24">
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>


                        </div>
                      </td>
                    </tr>';

          $mensaje2.= "<tr style='background:#FFF;'>
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

          ///*********************/

    } else {
          if (mysqli_num_rows($resul) > 0) {
            ///confirmacion de pago
            $asunto2 ="【CONFIRMACIÓN DE SERVICIO - COTIZACIÓN N° ".$codproyecto." " .$reclamante."】";
          } else {
            ///confirmacion de pago
            $asunto2 ="【CONFIRMACIÓN DE PAGO - COTIZACIÓN N° ".$codproyecto." " .$reclamante."】";
          }

          //////////////////////

          $mensaje2 = "
          <html>
          <body style='background:#a4a4a4;'>
                <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#a4a4a4;'>
                  <tr>
                    <td align='center'>
                      <table style='background-color:#FFF;border:0;border-collapse:collapse;border-spacing:0;width:750px;position:relative;margin-top:20px;margin-bottom:20px;'>
                        <tr>
                          <td style='padding:0px;background:#FFF;'>";
          $mensaje2.="<img src='https://www.limac.com.pe/assets/images/mail/banner_correo3.png' width='100%' height='auto' style='border:none;clear:both;display:block;height:auto;max-width:100%;outline:none;text-decoration:none;width:100%;'>";
          $mensaje2.="</td>
                      </tr>
                        
                      <tr>
                        <td align='left' style='padding-left:20px;padding-top:20px;padding-right:20px;padding-bottom:0px;font-size:16px;'>
                            <b ><br>Estimado(a) cliente:</b>
                            <p style='text-align: justify;'>Hemos recibido el pago conforme, estamos empezando con el proceso de traducción de su proyecto.<br><br></p>
          <img border='0' src='https://www.limac.com.pe/mail/tracking_confp.php?id=".$randomletter."&to=".$correo_cliente."&numproy=".$codproyecto."&tipo=COTIZACION' style='display:none;' />";

          $mensaje2.="
          <div>
            <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
              <tr>
                <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon001.png'></div></td>";
                
                
                if (mysqli_num_rows($resul) > 0) {
                  $mensaje2.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Tiempo de Entrega Estimado:</b><br>".$fechaFormateada."</div></td>";
                } else {
                  $mensaje2.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Tiempo de Entrega Estimado:</b><br>".$fecha_entrega." [".$sc."]</div></td>";
                }
          
          $mensaje2.="
              </tr>
            </table>
          </div>
          <hr>
          <div style='padding-top: 8px;padding-bottom: 8px;'>
            <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
              <tr>
                <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon002.png'></div></td>
                <td><div style='display: inline-block;top: 0px;    margin-left: 15px;position: relative;'><b>Forma de Entrega:</b><br>".$tipo_entrega."</div></td>
              </tr>
            </table>
          </div>
          <hr>";

          if($tfree!='Todos' || $tfree!='TCERT' || $tfree!='TNOCERT'){

            $mensaje2.="
            <div style='padding-top: 8px;padding-bottom: 8px;'>
                <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
                  <tr>
                    <td style='width:60px;'><div style='display: inline-block;top: 0px;position: relative;'><img src='https://www.limac.com.pe/assets/images/mail/icon003.png'></div></td>
                    <td><div style='display: inline-block;top: -8px;    margin-left: 15px;position: relative;'><b>Traductor Asignado:</b><br>".$nomtrad."</div></td>
                  </tr>
                </table>
            </div><hr>";

          }

          if($tipotrad!="Traducción Simple"){
            $mensaje2.="<br><div style='margin-bottom:12px;'> Sírvase ingresar en el siguiente enlace y completar un formulario con la finalidad de programar el envío de sus documentos en caso haya solicitado la entrega impresa o requiera una boleta/factura electrónica.</div>
                    <table width='100%' height='auto'>
                    <tbody>
                    <tr>
                      <td style='text-align:center;'><a href='https://".$site."/autologin/?I=".$idul."&t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
                    </tr>
                  </tbody></table>";

          }

          $mensaje2.="</td></tr>";

          $mensaje2.='<tr style="background:#FFF;">
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
                              <td style="padding: 0px;">
                                <a href="https://www.facebook.com/LimacOficial" target="_blank">
                                  <img src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24">
                                </a>
                              </td>
    
                              <td width="1"></td>
                              <td>
                                <a href="https://twitter.com/LimacOficial" target="_blank">
                                  <img src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24">
                                </a>
                              </td>
                              <td width="1"></td>
                              <td style="padding: 0px;">
                                <a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b" target="_blank">
                                  <img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png" width="24">
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>


                        </div>
                      </td>
                    </tr>';

          $mensaje2.= "<tr style='background:#FFF;'>
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

          ///*********************/

    }


    $mail2 = new PHPMailer;
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
    $mail2->From = $eemail;
    $mail2->FromName = $ename;

    $mail2->Subject = $asunto2;

    //$mail->addAddress($correo);

    $addr2 = explode(',',$correo_cliente);

    foreach ($addr2 as $ad) {
        $mail2->AddAddress( trim($ad) );
    }

    $mail2->IsHTML(true);
    $mail2->MsgHTML($mensaje2);
    //$mail2->AddStringAttachment($attach,$nomfile,$encoding,$type);
    $mail2->Send();

}


if(!empty($ids)){

  foreach ($ids as $llav => $em) {

    $NVB = "SELECT * FROM personal_freelance WHERE correo_usuario='$em'";
    $RNVB = mysqli_query($connect,$NVB);
    $GNVB = mysqli_fetch_array($RNVB, MYSQLI_ASSOC);
    $nomtrad = $GNVB['nombres_apellidos'];
    $tfree = $GNVB['id_per'];

    $length = 10;
    $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

    $asunto ="【PROPUESTA - PROYECTO DE TRADUCCIÓN N° ".$codproyecto." ".$reclamante."】";
    
    //////////////////////

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
                      <b><br>Estimado(a) ".$nomtrad.":</b>
                      <p>Tenemos una propuesta para la traducción de unos documentos:<br><br></p>
    <img border='0' src='https://www.limac.com.pe/mail/tracking_propuesta.php?id=".$randomletter."&to=".$em."&numproy=".$codproyecto."&tipo=COTIZACION' style='display:none;' />";

    $mensaje.="
    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'><tbody>".$idtar."</tbody></table><hr>
    </div>

    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>";

        if($fefreev1 == " "){
          $mensaje.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Fecha de Entrega:</b><br>".$fefree."</div></td>";
        }else{
          $mensaje.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Fecha de Entrega:</b><br>".$fefreev1."</div></td>";
        }

          
    $mensaje.="
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Tipo de proyecto:</b><br>".$tipotrad."</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Fecha de pago:</b><br>".$fech_pago."</div></td>
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


    $mensaje.="<br><div style='margin-bottom:12px;'></div>
            <table width='100%' height='auto'>
            <tbody>
            <tr>
              <td style='text-align:center;'><a href='https://www.limac.com.pe/autofree/?I=".$tfree."&t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
            </tr>
          </tbody></table>";

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
                      '.$address1.'<br>
                      '.$address2.',<br> Lima, República del Perú<br>
                      (511) (01) 700 9040<br>
                      <a href="mailto:ventas@limac.com.pe" target="_blank">ventas@limac.com.pe</a><br><a href="http://www.limac.com.pe" target="_blank">www.limac.com.pe</a>
                    </div>
                    
                    <table style="border-spacing: 0px;margin-top: 15px;">
                      <tbody>
                        <tr>
                          <td style="padding: 0px;">
                            <a href="https://www.facebook.com/LimacOficial" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24">
                            </a>
                          </td>

                          <td width="1"></td>
                          <td>
                            <a href="https://twitter.com/LimacOficial" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24">
                            </a>
                          </td>
                          <td width="1"></td>
                          <td style="padding: 0px;">
                            <a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png" width="24">
                            </a>
                          </td>
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
    $mail->From = $usfrom;
    $mail->FromName = "LIMAC";
    $mail->Subject = $asunto;

    $mail->addAddress($em);

    /*$addr = explode(',',$em);

    foreach ($addr as $ad) {
      $mail->AddAddress( trim($ad) );
    }*/

    $mail->IsHTML(true);

    $mail->MsgHTML($mensaje);

    $mail->Send();

  }//foreach

}//$ids


if(!empty($pds)){

  foreach ($pds as $llav => $em) {

    $NVB = "SELECT * FROM personal_freelance WHERE correo_usuario='$em'";
    $RNVB = mysqli_query($connect,$NVB);
    $GNVB = mysqli_fetch_array($RNVB, MYSQLI_ASSOC);
    $nomtrad = $GNVB['nombres_apellidos'];
    $tfree = $GNVB['id_per'];

    function getGUIDD(){
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

    $uidd = getGUIDD();

    $length = 10;
    $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);


    $asunto ="【PROPUESTA - PROYECTO DE TRADUCCIÓN N° ".$codproyecto."".$reclamante."】";

    ///////////////

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
                      <b><br>Estimado(a) ".$nomtrad.":</b>
                      <p>Te enviamos este mensaje dado que has postulado en nuestra bolsa de trabajo y te tenemos una propuesta de traducción de unos documentos:<br><br></p>
    <img border='0' src='https://www.limac.com.pe/mail/tracking_propuesta.php?id=".$randomletter."&to=".$em."&numproy=".$codproyecto."&tipo=COTIZACION' style='display:none;' />";

    $mensaje.="
    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'><tbody>".$idtar."</tbody></table><br>
    </div>

    <div>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>";


        if($fefreev1 == " "){
          $mensaje.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Fecha de Entrega:</b><br>".$fefree."</div></td>";
        }else{
          $mensaje.="<td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Fecha de Entrega:</b><br>".$fefreev1."</div></td>";
        }


    $mensaje.="
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Tipo de proyecto:</b><br>".$tipotrad."</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Fecha de pago:</b><br>".$fech_pago."</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td style='text-align:center;'><div style='display: inline-block;top: 0px;margin-left: 15px;position: relative;'><b>Si estás interesado y para mayor detalle sírvase ingresar a nuestro sistema NEXUS en el siguiente enlace (INGRESAR) donde nos podrás brindar tu respuesta.</b></div></td>
        </tr>
      </table>
    </div>";


    $mensaje.="<br>
            <table width='100%' height='auto'>
            <tbody>
            <tr>
              <td style='text-align:center;'><a href='https://www.limac.com.pe/autofree/?I=".$tfree."&t=".$uidd."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
            </tr>
          </tbody></table>

          <div style='font-size:10px;'><b>NOTA: Las traducciones certificadas aplican solo para traductores profesionales colegiados del CTP. Si usted no cuenta con este requisito, ignore este mensaje.</b></div>";

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
                          <td style="padding: 0px;">
                            <a href="https://www.facebook.com/LimacOficial" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon001.png" width="24">
                            </a>
                          </td>

                          <td width="1"></td>
                          <td>
                            <a href="https://twitter.com/LimacOficial" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon004.png" width="24">
                            </a>
                          </td>
                          <td width="1"></td>
                          <td style="padding: 0px;">
                            <a href="https://pe.linkedin.com/in/limac-soluciones-91b3ba9b" target="_blank">
                              <img src="https://www.limac.com.pe/assets/images/icons_sign/icon003.png" width="24">
                            </a>
                          </td>
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
    $mail->From = $usfrom;
    $mail->FromName = "LIMAC";
    $mail->Subject = $asunto;

    $mail->addAddress($em);

    /*$addr = explode(',',$em);

    foreach ($addr as $ad) {
      $mail->AddAddress( trim($ad) );
    }*/

    $mail->IsHTML(true);

    $mail->MsgHTML($mensaje);

    $mail->Send();

  }//foreach

}



////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','EN_TRADUCCION','$created','$nomadm ha asignado el proyecto de $clientecot EN TRADUCCIÓN','$codproyecto','COTIZACION')";
$resn = mysqli_query($connect,$sqln);



?>