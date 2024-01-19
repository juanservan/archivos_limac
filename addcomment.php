<?php
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
	require "../../../PHPMailer/PHPMailerAutoload.php";
	include_once "../../../variables.php";

	//$user_login=$_SESSION["admin"];
	date_default_timezone_set('America/Lima');
	setlocale(LC_ALL, 'es_PE');

	$fecha = date("Y-m-d H:i");
	$id = $_POST['ids'];
	$comentario = $_POST['comentario'];
	$tipo = $_POST['tipo'];
	$elid = $_POST['elid'];
	$ttipo = $_POST['ttipo'];

	$sql = "INSERT INTO comentarios (codigo,tipo_proyecto,comentarios,fecha) values('$id','$tipo','$comentario','$fecha')";
	$res = mysqli_query($connect,$sql);

	$sqlh = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,mensaje,fecha) values('$id','$elid','$ttipo','COMENTARIO','$comentario','$fecha')";
    $resh = mysqli_query($connect,$sqlh);

    $sqlc = "SELECT * FROM cotizacion_limac where concat(id_cotizacion,date_code)='$id'";
    $rqlc = mysqli_query($connect,$sqlc);

    $sqlp = "SELECT * FROM pedidos_traducciones where id_traduccion='$id'";
    $rqlp = mysqli_query($connect,$sqlp);

    if(mysqli_num_rows($rqlc)>0){
		$gqlc = mysqli_fetch_array($rqlc,MYSQLI_ASSOC);
		$nomb = $gqlc['nombre_cliente'];
    } else if(mysqli_num_rows($rqlp)>0){
		$gqlp = mysqli_fetch_array($rqlp,MYSQLI_ASSOC);
		$usuario = $gqlc['usuario_limac'];

    	$ss = "SELECT * from usuarios_limac where usuario='$usuario'";
		$sss = mysqli_query($connect,$ss);
		$ssss = mysqli_fetch_array($sss,MYSQLI_ASSOC);
		$nomb = $ssss['nom_apellidos'];
    }


    $xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
    $rxcv = mysqli_query($connect,$xcv);
    $gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
    $txcv = $gxcv['numero'];

    $xcve = "SELECT * FROM telephone where estado='MOSTRAR_ESPANA'";
    $rxcve = mysqli_query($connect,$xcve);
    $gxcve = mysqli_fetch_array($rxcve,MYSQLI_ASSOC);
    $txcve = $gxcve['numero'];

    $elfooter="R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a><br><br>";


    ////////////////////////
	//// admin
	$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
	$radm = mysqli_query($connect,$sadm);
	$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
	$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

	$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','COMENTARIO','$fecha','$nomadm ha ingresado un comentario en el proyecto del cliente $nomb','$id','$tipo')";
	$resn = mysqli_query($connect,$sqln);

?>