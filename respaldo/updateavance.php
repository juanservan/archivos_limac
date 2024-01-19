<?php 
$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8"); 
date_default_timezone_set("America/Lima");
setlocale(LC_ALL, 'es_PE');

require "../../../PHPMailer/PHPMailerAutoload.php";
?>

<?php 

$idproyecto = $_POST['idproyecto'];
$traductor = $_POST['traductor'];
$avancep = $_POST['avancep'];
$totalp = $_POST['totalp'];
$avancepg = $_POST['avancepg'];
$totalpg = $_POST['totalpg'];
$archivos = $_POST['archivos'];
$tipo = $_POST['tipo'];

$fecha = date("Y-m-d H:i");
$elid = $_POST['elid'];
$ttipo = $_POST['ttipo'];

/*$sqll = "select * from notificaciones where idnotificaciones='$idnot'";
$ress = mysql_query($sqll);

if(mysql_num_rows($ress)>0){*/
	/*$sqlr = "UPDATE notificaciones set traduccion='$destino' where idnotificaciones='$idnot'";
	$resr = mysql_query($sqlr);*/
//}

$sqlcot = "SELECT * FROM cotizacion_limac where concat(`id_cotizacion`,`date_code`)='$idproyecto'";
$rescot = mysqli_query($connect,$sqlcot);
$regcot = mysqli_fetch_array($rescot,MYSQLI_ASSOC);
$clientecot = $regcot['nombre_cliente'];
$monedacot = $regcot['moneda'];

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

if($monedacot=='euros'){
    $eemail = "ventas@limac.com.es";
    $ename = "LIMAC ESPAÑA";
    $pie = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
    $link_politica = "https://www.limac.com.es/<br>politica/terminos-y-condiciones/";
    $url_pay = "https://www.limac.com.es/pagos/";
    $site = "www.limac.com.es";
} else {
    $eemail = $usfrom;
    $ename = "LIMAC";
    $pie = "R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>Avenida El Derby 055, Torre 1 - Piso 7, Santiago de Surco, Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: ".$usfrom."<br>";
    $link_politica = "https://www.limac.com.pe/<br>politica/terminos-y-condiciones/";
    $url_pay = "https://www.limac.com.pe/pagos/";
    $site = "www.limac.com.pe";
}


$mol = "SELECT * FROM personal_limac where id_pl='$traductor'";
$rmol = mysqli_query($connect,$mol);

$fee = "SELECT * FROM personal_freelance where id_per='$traductor'";
$rfee = mysqli_query($connect,$fee);

$afee = "SELECT * FROM admin_limac where id_al='$traductor'";
$arfee = mysqli_query($connect,$afee);

if(mysqli_num_rows($rmol)>0){
	$TIPO = "TRADUCTOR";
} else if(mysqli_num_rows($rfee)>0){
	$TIPO = "TRADUCTOR_FREELANCE";
} else if(mysqli_num_rows($arfee)>0){
	$TIPO = "ADMINISTRADOR";
}

$sql = "INSERT INTO registro_avances(codigo,tipo_proyecto,id_traductor,archivos,num_words,total_words,num_pages,total_pages,fecha) values('$idproyecto','$tipo','$traductor','$archivos','$avancep','$totalp','$avancepg','$totalpg','$fecha')";
$res = mysqli_query($connect,$sql);

function sendMessage(){
	$idproyecto = $_POST['idproyecto'];
	$content = array(
		"en" => "Se ha registrado avance de proyecto Nº ".$idproyecto
	);

	$heading = array(
		"en" => "NEXUS - AVANCE DE PROYECTO"
	);
	
	$fields = array(
		'app_id' => "5ee7a794-10d2-40a5-9570-124b3bc0786a",
		'included_segments' => array("Administrador"),
		'data' => array("foo" => "bar"),
		'contents' => $content,
		'headings' => $heading,
		'url' => 'https://www.limac.com.pe/nexus_admin/production/listado_v3_2.php'
	);
	
	$fields = json_encode($fields);
	print("\nJSON sent:\n");
	print($fields);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												'Authorization: Basic NWIzOWMwYWYtMzJlOC00ZDA2LWI3NzEtNTA2ZjM2Njc1ZDE2'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	curl_close($ch);
	
	return $response;
}
	
$response = sendMessage();
$return["allresponses"] = $response;
$return = json_encode( $return);

function sendMessage2(){
	$idproyecto = $_POST['idproyecto'];
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8"); 

	$sql2 = "SELECT * FROM proyecto_revisado where codigo='$idproyecto'";
	$res2 = mysqli_query($connect,$sql2);
	$reg2 = mysqli_fetch_array($res2,MYSQLI_ASSOC);
	$idtrad = $reg2['id_traductor'];

	$sql3 = "SELECT * from cuenta_personal where id_personal='$idtrad'";
	$res3 = mysqli_query($connect,$sql3);
	$reg3 = mysqli_fetch_array($res3,MYSQLI_ASSOC);
	$usertrad = $reg3['user_personal'];

	$sql4 = "Select * from onesignal where usuario='$usertrad'";
	$reso = mysqli_query($connect,$sql4);

	$ids = array(); 
	while ($row = mysqli_fetch_array($reso,MYSQLI_ASSOC)){
		$ids[] = $row["onesignalID"]; 
	} 

	$content = array(
		"en" => "Se ha registrado avance de proyecto Nº ".$idproyecto
	);

	$heading = array(
		"en" => "NEXUS - AVANCE DE PROYECTO"
	);
	
	$fields = array(
		'app_id' => "5ee7a794-10d2-40a5-9570-124b3bc0786a",
		'include_player_ids' => $ids,
		'data' => array("foo" => "bar"),
		'contents' => $content,
		'headings' => $heading,
		'url' => 'https://www.limac.com.pe/nexus_translator/production/listado_v3_2.php'
	);
	
	$fields = json_encode($fields);
	print("\nJSON sent:\n");
	print($fields);
	
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


$sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,fecha,num_words,total_words,num_pages,total_pages) values('$idproyecto','$traductor','$TIPO','AVANCE','$archivos','$fecha','$avancep','$totalp','$avancepg','$totalpg')";
$resh = mysqli_query($connect,$sqlh);



////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','SUBIR_AVANCE','$fecha','$nomadm ha subido un avance del proyecto del cliente $clientecot','".$idproyecto."','COTIZACION')";
$resn = mysqli_query($connect,$sqln);


?>