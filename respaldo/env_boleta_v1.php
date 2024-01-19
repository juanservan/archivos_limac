<?php
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); 
	mysqli_set_charset($connect,"utf8");
	date_default_timezone_set('America/Lima');
	setlocale(LC_ALL, 'es_PE');
	include ('../../../variables.php');


	date_default_timezone_set('America/Lima');
	setlocale(LC_ALL, 'es_PE');
	$datee = date('Y-m-d H:i:s');
	$creacion = date("Y-m-d H:i:s");
	$lafecha = date("d/m/Y");

	$dia=date("l"); // Saturday

    if ($dia=="Monday") $dia="Lunes";
    if ($dia=="Tuesday") $dia="Martes";
    if ($dia=="Wednesday") $dia="Miércoles";
    if ($dia=="Thursday") $dia="Jueves";
    if ($dia=="Friday") $dia="Viernes";
    if ($dia=="Saturday") $dia="Sabado";
    if ($dia=="Sunday") $dia="Domingo";

    $mes=date("F"); // November
    if ($mes=="January") $mes="Enero";
    if ($mes=="February") $mes="Febrero";
    if ($mes=="March") $mes="Marzo";
    if ($mes=="April") $mes="Abril";
    if ($mes=="May") $mes="Mayo";
    if ($mes=="June") $mes="Junio";
    if ($mes=="July") $mes="Julio";
    if ($mes=="August") $mes="Agosto";
    if ($mes=="September") $mes="Setiembre";
    if ($mes=="October") $mes="Octubre";
    if ($mes=="November") $mes="Noviembre";
    if ($mes=="December") $mes="Diciembre";

    $ano=date("Y"); // 2012

    $dia2 = date("d");
	$dia3 = date("l");
	$mes2 = date("F");
	$datecode = date("dmY");

	$code_fecha = date('dmY');

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

	//====================================
    //              DATOS
    //====================================
    $codproyecto = $_POST['codproyecto'];
    $idPersonal = $_POST['elid'];
    $perfilPersonal = $_POST['ttipo'];

    $sql = "	SELECT 
					clr.id_cotizacion,
					clr.descripcion,
					clr.paginas,
					clr.cantidad,
					clr.paginas,
					clr.precio_unitario,
					clr.detalle,
					clr.importe,
					clr.idiomas,
					clr.tipo_unidad,
					cl.nombre_cliente,
					cl.reclamante,
					cl.correo_cliente,
					cl.tipoCot,
					cl.sexo,
					cl.empresa,
					cl.subtotal,
					cl.igv,
					cl.total,
					cl.moneda,
					cl.total_soles,
					cl.fecha_entrega,
					cl.tiempo_entrega,
					cl.metodo_pago,
					cl.formato_entrega,
					cl.validez_oferta,
					cl.tipo_entrega,
					cl.emisor,
					cl.created
				FROM cotizacion_limac cl 
				LEFT JOIN cotizacion_limac_reg clr
				ON concat(cl.id_cotizacion,cl.date_code) = clr.id_cotizacion
				WHERE  concat(cl.id_cotizacion,cl.date_code) = '$codproyecto'";
    $result1 = mysqli_query($connect, $sql);
	$result2 = mysqli_query($connect, $sql);
	$result3 = mysqli_query($connect, $sql);
	$array_result = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    $empresa = $array_result['empresa'];
    $moneda = $array_result['moneda'];
    $total = $array_result['total'];
    $nombre_cliente=$array_result['nombre_cliente'];
	$correo=$array_result['correo_cliente'];
	$corr=split('\,',$correo);
	$firma=$array_result['emisor'];
    $sexo=$array_result['sexo'];
	$tipo_unidad=$array_result['tipo_unidad'];

	if($sexo=='Masculino'){
		$est = 'Estimado Sr. ';
	}

	if($sexo=='Femenino'){
		$est='Estimada Srta. ';
	}
    
	$desc=$array_result['descripcion'];
	$desc2=$array_result['paginas'];
	
	$img_banner = "https://www.limac.com.pe/assets/images/correo_limac.jpg";
	$img_logo = "https://www.limac.com.pe/assets/images/logos/logo_color2.jpg";
	$name_com = "Limac";

	$enc = "base64";
    $ty ="application/octet-stream";

	if($empresa=='Si'){
		$est='Dear Sirs ';
	}

	$idiomas=$array_result['idiomas'];
	$cantidad=$array_result['cantidad'];
	$paginas=$array_result['paginas'];
	$precio_unitario=$array_result['precio_unitario'];
	$detalles=$array_result['detalle'];
	$importe=$array_result['importe'];
	$subtotal=$array_result['subtotal'];
	$igv=$array_result['igv'];
	$total=$array_result['total'];

	$metodo_pago=$array_result['metodo_pago'];
	
	//$validez_oferta=$_POST['validez_oferta'];
	$tipo_entrega=$array_result['tipo_entrega'];


	$numFact = $_POST['codproyecto'];
	$referencial = $array_result['reclamante'];

	// $test = "
	// 		empresa:'$empresa'
	// 		moneda:'$moneda'
	// 		total:'$total'
	// 		nombre:'$nombre_cliente'
	// 		correo:'$correo'
	// 		firma:'$firma'
	// 		sexo:'$sexo'
	// 		desc:'$desc'
	// 		desc2:'$desc2'
	// 		idiomas:'$idiomas'
	// 		cantidad:'$cantidad'
	// 		paginas:'$paginas'
	// 		precio_unitario:'$precio_unitario'
	// 		detalles:'$detalles'
	// 		importe:'$importe'
	// 		subtotal:'$subtotal'
	// 		igv:'$igv'
	// 		total:'$total'
	// 		metodo_pago:'$metodo_pago'
	// 		validez_oferta:'$validez_oferta'
	// 		tipo_entrega:'$tipo_entrega'
	// 		numFact:'$numFact'
	// 		referencial:'$referencial'
	// 		array_result:'$array_result'
	// 		";
	// echo $test;
	// print_r($array_result);
	// while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
	// }

    if($moneda=='soles'){
		$symbol='S/';
		$valores = "Valores expresados en nuevos soles (S/ ).";
		$total_soles = $total;
		$eemail = $usfrom;
		$url_pay = "https://www.limac.com.pe/pagos/";
		$link_politica = "https://www.limac.com.pe/<br>politica/terminos-y-condiciones/";
		$enom = "LIMAC";
		$tt = $txcv;
		$em = "bruno.espino@limac.pe";

		if($firma=="RYE"){
 			$pie = "R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>".$direccion.", Lima<br>Teléfono: ".$txcv." * Correo Electrónico: <a style='text-decoration:none;' href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
			$dirr = "".$direccion.", Lima";
		} else if($firma=="LIMACDELPERU"){
 			$pie = "LIMAC DEL PERÚ E.I.R.L. - R.U.C. 20603296410<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a style='text-decoration:none;' href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
			$dirr = "".$direccion.", Lima";
		}
	}

	if($moneda=='dolares'){
		$symbol='$';
		$valores = "Valores expresados en dólares americanos ($).";
		$total_soles = $total * 3;
		$eemail = $usfrom;
		$url_pay = "https://www.limac.com.pe/pagos/";
		$link_politica = "https://www.limac.com.pe/<br>politica/terminos-y-condiciones/";
		$enom = "LIMAC";
		$tt = $txcv;
		$em = "bruno.espino@limac.pe";

		if($firma=="RYE"){
 			$pie = "R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a style='text-decoration:none;' href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
			$dirr = "".$direccion.", Lima";
		} else if($firma=="LIMACDELPERU"){
 			$pie = "LIMAC DEL PERÚ E.I.R.L. - R.U.C. 20603296410<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a style='text-decoration:none;' href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
			$dirr = "".$direccion.", Lima";
		}
	}

	if($moneda=='euros'){
		$symbol='€';
		$valores = "Valores expresados en euros (€).";
		$total_soles = $total * 3.70;

		$eemail = "ventas@limac.com.es";
		$url_pay = "https://www.limac.com.es/pagos/";
		$pie = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: ventas@limac.com.es<br>";
		$link_politica = "https://www.limac.com.es/<br>politica/terminos-y-condiciones/";
		$enom = "LIMAC ESPAÑA";
		$tt = $txcve;
		$em = "ventas@limac.com.es";
		$dirr = "Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España";
	}



	require "../../../PHPMailer/PHPMailerAutoload.php";
	require "../../../MPDF57/mpdf.php";

	$asunto ="【INVOICE N°. ".$numFact." - TRANSLATION ".$referencial."】";


//*****PDF****//

$html = "
<html>
<head>
<style type='text/css'>
    body {
        font-family: maven_pro !important;
    }
</style>
</head>
<body>
    <div class='container' style='width:800px;'>
        <div style='width:800px;display:inline-block;margin-top:0px;margin-bottom:35px;font-family:Maven Pro;font-weight: bold;font-size:14px;background:#FFF;padding-left: 0px;padding-right: 0px;padding-top: 0px;'><br>
            <table style='width:100%;'>
                <tr>
                    <td width='80'>
                        <div>
							<img src='https://www.limac.com.pe/assets/images/limac_gradient.jpg' width='120'>
						</div>
                    </td>
                    <td width='260' style='vertical-align:middle !important;'>
                        <div style='margin-left:10px;'></div>
                    </td>
                    <td width='160'></td>
                    <td style='font-size:30px; text-align:center;'>
                        FACTURA<br><br>
                    </td>
                </tr>
            </table><br><br>
			
			<table style='width:100%;'>
                <tr>
                    <td width='300'>
                        <div style='width:220px; text-align:left;'>
                            R&E TRADUCCIONES S.A.C. <br> 
                            R.U.C. 20551971300<br>
							Calle German Schreiber 210 Oficina 302,<br>
                            San Isidro, Lima, Lima 15047,
                            Perú<br>+51 $txcv<br>
                        </div>
                    </td>
                    <td width='60' style='vertical-align:middle !important;'>
                        <div style='margin-left:10px;'>
						
						</div>
                    </td>
                    <td width='60'></td>
                    <td width='60' style='font-size:30px; text-align:center;'>
                        <table>
                            <tr>
                                <td style='text-align:right; font-weight:500;'>N° de Factura: </td>
                                <td style='text-align:left;'width='150'>$numFact</td>
                            </tr>
                            <tr>
                                <td style='text-align:right; font-weight:500;'width='150'>Fecha de Factura: </td>
                                <td style='text-align:left;'width='150'>$dia2 $mes $ano </td>
                            </tr>
                            <tr>
                                <td style='text-align:right; font-weight:500;'width='300'>Fecha de vencimiento: </td>
                                <td style='text-align:left; 'width='150'>$dia2 $mes $ano</td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
			<table style='width:100%;'>
                <tr>
                    <td width='80'>
                        <div></div>
                    </td>
                    <td width='160' style='vertical-align:middle !important;'>
						<div></div>
                        <div></div><br>
                        <div></div>
					</td>
                    <td width='160'></td>
                    <td width='60' style='background:#FFF;border: 1px solid #CCC;text-align:center;'>
                        <b>Monto a pagar: </b><br>
                        <b style='font-size:22px;'>$symbol $subtotal</b>
                        <br>
                    </td>
                </tr>             
            </table>
            <br>
			<hr>
			
			<table style='width:100%;'>
				<tr>
					<td width='280'>
						<div>Factura para:<br>
						<br>
						InSpectre Solutions, Inc.<br>
						Business ID 81-233115<br>
						24921 Dana Point Harbor Dr.<br>
						Suite B210 Dana Point, CA 92629<br>
						United States<br>
						+1 949-377-3074
						<br><br><br>
						<br>
						</div>
					</td>
					<td width='260' style='vertical-align:middle !important;'>
						<div style='margin-left:10px;'></div>
					</td>
					<td width='160'></td>
					<td style='font-size:30px; text-align:center;'>
						<br>
						<br>
						<br>
					</td>
				</tr>
			</table>
			<br><br>
			
			<div style='width:800px;'>
				<table style='width:800px; border-collapse:collapse;'>
					<tr style='background: #EDEDED;color: #000 !important;border: 2px solid #A5A3A3;'>
						<th style='font-size:18px;text-align:left;width:500px;'><b>Descripción</b></th>";

if($tipo_unidad == "por minuto"){
	$html.="
						<th style='font-size:18px;width:50px;'><b>Minutos</b></th>";
}elseif ($tipo_unidad == "por hora") {
	$html.="
						<th style='font-size:18px;width:50px;'><b>Horas</b></th>";
}else {
	$html.="
						<th style='font-size:18px;width:50px;'><b>Palabras</b></th>";
}
						

$html .="
						<th style='font-size:18px;text-align:right;'><b>Tarifa</b></th>
						<th style='font-size:18px;text-align:right;'><b>Cantidad</b></th>
					</tr>";

$c=0;

while( $row1 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) {
        

	$html.="    	<tr style='color:#868686;";

	if($c++%2==1){$html.="!important;height:20px;background:#EDEDED;'"; }else{$html.="!important;height:20px;'";}

	$html.=">
					<td style='vertical-align: text-top;'>";

	// $est2[$key]=' PAGINAS ';
	// if($desc2[$key]==''){
	// 	$est2[$key]=' ';
	// }
	$u = $row1['detalle'];
	if($u=='Traduccion Digital de'){
		$html.= "SERVICIO DE TRADUCCION DIGITAL DE ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row1['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row1['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row1['importe']."</td>
			</tr>";
	}elseif($u=='Traduccion Certificada de') {
		$html .= "SERVICIO DE TRADUCCION CERTIFICADA de ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row1['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row1['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row1['importe']."</td>
			</tr>";
	}elseif($u=='Traduccion Oficial de') {
		$html .= "SERVICIO DE TRADUCCION OFICIAL de ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Transcreacion de') {
		$html .= "SERVICIO DE TRANSCREACION DIGITAL de ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row1['precio_unitario']. "</td>
				<<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Revision de') {
		$html .= "SERVICIO DE REVISION DIGITAL de ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Copia de Traduccion de') {
		$html .= "SERVICIO DE COPIA DE TRADUCCION: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Envio a Domicilio') {
		$html .= "SERVICIO DE ENVIO A DOMICILIO: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Resumen') {
		$html .= "SERVICIO DE RESUMEN: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Tramite') {
		$html .= "SERVICIO DE TRAMITE: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Transcripcion') {
		$html .= "SERVICIO DE TRANSCRIPCION DIGITAL de ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Revision y Certificacion de Traduccion de') {
		$html .= "SERVICIO DE REVISION Y CERTIFICACION DE TRADUCCION: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Edición de') {
		$html .= "SERVICIO DE EDICION: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Subtitulacion de') {
		$html .= "SERVICIO DE SUBTITULACION: ".$row1['descripcion']." ".$row1['idiomas']."(CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Traduccion Digital Urgente de'){
		$html.= "SERVICIO DE TRADUCCION DIGITAL URGENTE de ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row1['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row1['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'>$ ".$row1['importe']."</td>
			</tr>";
	}elseif($u=='Traduccion Certificada Urgente de') {
		$html .= "SERVICIO DE TRADUCCION CERTIFICADA URGENTE de ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row1['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row1['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'>$ ".$row1['importe']."</td>
			</tr>";
	}elseif($u=='Traduccion Oficial Urgente de') {
		$html .= "SERVICIO DE TRADUCCION OFICIAL URGENTE de ".$row1['descripcion']." ".$row1['idiomas']." (CANTIDAD DE PÁGINAS: ".$row1['paginas'].")";
		$html.="</td> 
				<td style='text-align:center;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row1['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row1['importe'] . "</td>
			</tr>";
	}elseif($u=='Cargo Banco')  {
		$html .="RECARGO DE BANCO POR GIRO DE EEUU <br><br>";
		$html .="</td> 
				<td style='text-align:center;'>" . $row1['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row1['precio_unitario'] . "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'>$ " . $row1['importe'] . "</td>
			</tr>";
	}
}


$html.="
					<tr style='height:20px;background:#EDEDED;'>
						<td style='background:#FFF;'></td>
						<td rowspan='3' colspan='1' style='border-left: 3px ;border-bottom:3px ;vertical-align:top;'>$valoresx<br></td>
						<td style='text-align:right;'>Subtotal:</td>
						<td style='text-align:right;width:200px;border-right: 3px ;'>$ ".number_format($subtotal,2,'.',',')."</td>
					</tr>
					<tr style='background: #EDEDED;color: #FFF;'>
						<td style='background:#FFF;'></td>
						<td style='text-align:right;color:#000;'><b>Total:</b></td>
						<td style='text-align:right;color:#000;width:200px;border-right: 3px ;'><b>$ ".number_format($subtotal,2,'.',',')." ".$acron."</b></td>
					</tr>
				</table>
			</div><br>
			<hr><br>

			<table style='width:100%;'>
				<tr>
					<td width='50%'>
					<div>
						<b>Notas</b><br><br>RECLAMANTE $referencial
					</div>
					</td>

					<td width='10%'>
						
					</td>
					
					<td width='40%'>
						<div>
							<b>Términos y condiciones</b><br><br>
							Términos de pago Factura a 7 días
						</div>
					</td>
					
				</tr>
			</table>
			<br><br>";

$footer .= "<div style='width:800px; text-align:center;font-size:12px;'>R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>$direccion, Lima.<br>Teléfono: $txcv * Correo Electrónico: $usfrom<br></div>";



$length = 10;
$randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

$mensajea = "
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
                            <b><br>$est $nombre_cliente:</b>
							<img border='0' src='https://www.limac.com.pe/mail/tracking.php?id=".$randomletter."&to=".$correo."&numproy=".$codproyecto."' style='display:none;' />
                            <p style='text-align: justify;margin-bottom:12px;'>Please find attached the corresponding invoices.</p>";

$mensajex.="                <img border='0' src='https://www.limac.com.pe/mail/tracking_fac2.php?id=".$randomletter."&to=".$correo."&numproy=".$codproyecto."' style='display:none;' />
                            <p style='text-align: justify;margin-bottom:12px;'>Please find attached the final versions of your translations and corresponding invoices.</p>";

$mensaje.="Please consider that there is an additional $25 bank fee for wire transfers from abroad. If you have any questions please send us a message at <a href='mailto:$eemail'>$eemail</a> or call us at ";

if($moneda=='euros'){
	$mensaje.= $tt;
} else {
  	$numb = "SELECT * FROM telephone where estado='MOSTRAR'";
    $resn = mysqli_query($connect,$numb);
    $regn = mysqli_fetch_array($resn,MYSQLI_ASSOC);
    $mensaje.= $regn['numero'];
}

$mensaje.="</p>
		</td>
					</tr>
					<tr style='background:#FFF;'>
                        <td align='left' style='background:#FFF;'>
                            <p style='margin-left:20px; margin-right:20px;font-size:16px;'>Best regards,<br><br>
                            Sales Department</p>


                            <div style='padding:0px;font-size:12px;color:rgb(102,102,102); width:200px;padding-left:20px;padding-right:20px;'>
                                <img src='https://www.limac.com.pe/assets/images/logos/logo_color2.jpg' width='130' style='border:0px;vertical-align:middle;margin-bottom: 20px;'>
                                <br>
								$direccion,<br>
                                Lima, República del Perú<br>
                                (511) (01) 700 9040<br>
                                <a href='mailto:ventas@limac.com.pe' target='_blank'>ventas@limac.com.pe</a><br><a href='http://www.limac.com.pe' target='_blank'>www.limac.com.pe</a>
                                <table style='border-spacing: 0px;margin-top: 15px;'>
                                    <tbody>
                                    <tr>
                                        <td style='padding: 0px;'>
                                            <a href='https://www.facebook.com/LimacOficial' target='_blank'>
                                                <img src='https://www.limac.com.pe/assets/images/icons_sign/icon001.png' width='24'>
                                            </a>
                                        </td>
                                        <td width='1'></td>
                                        <td>
                                            <a href='https://twitter.com/LimacOficial' target='_blank'>
                                                <img src='https://www.limac.com.pe/assets/images/icons_sign/icon004.png' width='24'>
                                            </a>
                                        </td>
                                    <td width='1'></td>
                                    <td style='padding: 0px;'><a href='https://pe.linkedin.com/in/limac-soluciones-91b3ba9b' target='_blank'><img src='https://www.limac.com.pe/assets/images/icons_sign/icon003.png' width='24'></a></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
					<tr style='background:#FFF;'>
                        <td align='left' style='font-size:10px; color:#aaa;background:#FFF;'>
                            <div style='margin-left:20px; margin-right:20px; margin-bottom: 10px;text-align:justify;'>
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
                        <td align='center' style='background-color:#0093DF;color:#FFF;'><br><img src='https://www.limac.com.pe/assets/images/mail/firma3.png'></td>
                    </tr>
                    <tr style='background-color:#0093DF;color:#FFF;'>
                        <td align='center' style='font-size: 12px;color:#FFF;'>$pie</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>";




$html2 = "
<html>
<head>
    <style type='text/css'>
        body {
            font-family: maven_pro !important;
        }
    </style>
</head>
<body>
	<div class='container' style='width:800px;'>
		<div style='width:800px;display:inline-block;margin-top:0px;margin-bottom:35px;font-family:Maven Pro;font-weight: bold;font-size:14px;background:#FFF;padding-left: 0px;padding-right: 0px;padding-top: 0px;'><br>
			<table style='width:100%;'>
				<tr>
					<td width='80'>
						<div>
							<img src='https://www.limac.com.pe/assets/images/limac_gradient.jpg' width='120'>
						</div>
					</td>
					<td width='260' style='vertical-align:middle !important;'>
						<div style='margin-left:10px;'></div>
					</td>
					<td width='160'></td>
					<td style='font-size:30px; text-align:center;'>
						INVOICE<br><br>
					</td>
				</tr>
			</table><br><br>

			<table style='width:100%;'>
                <tr>
                    <td width='300'>
                        <div style='width:220px; text-align:left;'>
                            R&E TRADUCCIONES S.A.C. <br> 
                            R.U.C. 20551971300<br>
                            Calle German Schreiber 210, Oficina 302,<br> 
                            San Isidro, Lima, Lima 15047, 
							Perú<br>+51 $txcv<br>
                        </div>
                    </td>
                    <td width='60' style='vertical-align:middle !important;'>
                        <div style='margin-left:10px;'>
						
						</div>
                    </td>
                    <td width='60'></td>
                    <td width='60' style='font-size:30px; text-align:center;'>
                        <table>
                            <tr>
                                <td style='text-align:right; font-weight:500;'>Invoice #: </td>
                                <td style='text-align:left;'width='150'>$numFact</td>
                            </tr>
                            <tr>
								<td style='text-align:right; font-weight:500;'width='150'>Invoice Date: </td>
								<td style='text-align:left;'width='150'>$mes2 $dia2 $ano</td>
                            </tr>
                            <tr>
								<td style='text-align:right; font-weight:500;'width='300'>Due Date: </td>
                                <td style='text-align:left; 'width='150'>$mes2 $dia2 $ano</td>
                            </tr>
                            <tr></tr>
                            <tr></tr>        
                        </table>
                    </td>
                </tr>
            </table>
			<br>
			<table style='width:100%;'>
                <tr>
                    <td width='80'>
                        <div></div>
                    </td>
                    <td width='160' style='vertical-align:middle !important;'>
						<div></div>
                        <div></div><br>
                        <div></div>
					</td>
                    <td width='160'></td>
                    <td width='60' style='background:#FFF;border: 1px solid #CCC;text-align:center;'>
                        <b>Amount due: </b><br>
                        <b style='font-size:22px;'>$symbol $subtotal</b><br>
                        <br>
                    </td>
                </tr>             
            </table> <br>
			<hr>
			<table style='width:100%;'>
                <tr>
                    <td width='280'>
                        <div>Bill to:<br>
                            <br>InSpectre Solutions, Inc.<br>
                            Business ID 81-233115<br>
                            24921 Dana Point Harbor Dr.<br>
                            Suite B210 Dana Point, CA 92629<br>
                            United States<br><br>
                            +1 949-377-3074<br>
                            <br><br><br>
                            <br>
                        </div>
                    </td>
                    <td width='260' style='vertical-align:middle !important;'>
                        <div style='margin-left:10px;'>
						
						</div>
                    </td>
                    <td width='160'></td>
                    <td style='font-size:30px; text-align:center;'>
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
            </table>
            <br><br>
			
			<div style='width:800px;'>
				<table style='width:800px; border-collapse:collapse;'>
					<tr style='background: #EDEDED;color: #000 !important;border: 2px solid #a5a3a3;'>
                        <th style='font-size:18px;text-align:left;width:500px;'><b>Description</b></th>";
if ($tipo_unidad == "por minuto") {
	$html2.="
						<th style='font-size:18px;width:50px;'><b>Minutes</b></th>";
}elseif ($tipo_unidad == "por hora") {
	$html2.="
						<th style='font-size:18px;width:50px;'><b>Hours</b></th>";
}else {
	$html2.="
						<th style='font-size:18px;width:50px;'><b>Words</b></th>";
}
					
$html2.="
						<th style='font-size:18px;text-align:right;'><b>Rate</b></th>
                        <th style='font-size:18px;text-align:right;'><b>Amount</b></th>
                    </tr>";

$c=0;

while( $row2 = mysqli_fetch_array($result3, MYSQLI_ASSOC) ) {
        

	$html2.="    	<tr style='color:#868686;";

	if($c++%2==1){$html2.="!important;height:20px;background:#EDEDED;'"; }else{$html2.="!important;height:20px;'";}

	$html2.=">
					<td style='vertical-align: text-top;'>";

	// $est2[$key]=' PAGINAS ';
	// if($desc2[$key]==''){
	// 	$est2[$key]=' ';
	// }

	$languages='';
	if($row2['idiomas']=='ESP (Perú) - ING (EE.UU.)'){
		$languages.='SPA (Peru) - ENG (USA)';
	}elseif($row2['idiomas']=='ESP (Perú) - ING (Reino Unido)'){
		$languages.='SPA (Peru) - ENG (UK)';
	}elseif($row2['idiomas']=='ESP (Perú) - ING (Australia)'){
		$languages.='SPA (Peru) - ENG (Australia)';
	}elseif($row2['idiomas']=='ESP (Perú) - ING (Canada)'){
		$languages.='SPA (Peru) - ENG (Canada)';
	}elseif($row2['idiomas']=='ESP (Perú) - ING (Emiratos Arabes)'){
		$languages.='SPA (Peru) - ENG (United Arab Emirates)';
	}elseif($row2['idiomas']=='ESP (Perú) - FRA (Francia)'){
		$languages.='SPA (Peru) - FRE (France)';
	}elseif($row2['idiomas']=='ESP (Perú) - FRA (Canadá)'){
		$languages.='SPA (Peru) - FRE (Canada)';
	}elseif($row2['idiomas']=='ESP (Perú) - POR (Brasil)'){
		$languages.='SPA (Peru) - POR (Brasil)';
	}elseif($row2['idiomas']=='ESP (Perú) - POR (Portugal)'){
		$languages.='SPA (Peru) - POR (Portugal)';
	}elseif($row2['idiomas']=='ESP (Perú) - ALE (Alemania)'){
		$languages.='SPA (Peru) - GER (Germany)';
	}elseif($row2['idiomas']=='ESP (Perú) - ITA (Italia)'){
		$languages.='SPA (Peru) - ITA (Italy)';
	}elseif($row2['idiomas']=='ESP (Perú) - JAP (Japón)'){
		$languages.='SPA (Peru) - JAP (Japan)';
	}elseif($row2['idiomas']=='ESP (Perú) - RUS (Rusia)'){
		$languages.='SPA (Peru) - RUS (Russia)';
	}elseif($row2['idiomas']=='ESP (Perú) - CHI (China)'){
		$languages.='SPA (Peru) - CHI (China)';
	}elseif($row2['idiomas']=='ESP (España) - ING (EE.UU.)'){
		$languages.='SPA (Spain) - ENG (USA)';
	}elseif($row2['idiomas']=='ESP (España) - ING (Reino Unido)'){
		$languages.='SPA (Spain) - ENG (UK)';
	}elseif($row2['idiomas']=='ESP (España) - FRA (Francia)'){
		$languages.='SPA (Spain) - FRE (France)';
	}elseif($row2['idiomas']=='ESP (España) - FRA (Canadá)'){
		$languages.='SPA (Spain) - FRE (Canada)';
	}elseif($row2['idiomas']=='ESP (España) - POR (Brasil)'){
		$languages.='SPA (Spain) - POR (Brasil)';
	}elseif($row2['idiomas']=='ESP (España) - POR (Portugal)'){
		$languages.='SPA (Spain) - POR (Portugal)';
	}elseif($row2['idiomas']=='ESP (España) - ALE (Alemania)'){
		$languages.='SPA (Spain) - GER (Germany)';
	}elseif($row2['idiomas']=='ESP (España) - ITA (Italia)'){
		$languages.='SPA (Spain) - ITA (Italy)';
	}elseif($row2['idiomas']=='ESP (España) - JAP (Japón)'){
		$languages.='SPA (Spain) - JAP (Japan)';
	}elseif($row2['idiomas']=='ESP (España) - RUS (Rusia)'){
		$languages.='SPA (Spain) - RUS (Russia)';
	}elseif($row2['idiomas']=='ESP (España) - CHI (China)'){
		$languages.='SPA (Spain) - CHI (China)';
	}
	elseif($row2['idiomas']=='CHI (China) - ESP (Perú)'){
		$languages.='CHI (China) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='TAI (Tailandia) - ING (EE.UU.)'){
		$languages.='THA (Thailand) - ENG (USA)';
	}
	elseif($row2['idiomas']=='ESP (Perú) - PER (Irán)'){
		$languages.='SPA (Peru) - PER (Iran)';
	}
	elseif($row2['idiomas']=='PER (Irán) - ESP (Perú)'){
		$languages.='PER (Iran) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='LIT (Lituania) - ESP (España)'){
		$languages.='LIT (Lithuania) - SPA (Spain)';
	}
	elseif($row2['idiomas']=='LIT (Lituania) - ESP (Perú)'){
		$languages.='LIT (Lithuania) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='ING (EE.UU.) - ESP (Perú)'){
		$languages.='ENG (USA) - SPA (Peru)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - ESP (España)'){
		$languages.='ENG (USA) - SPA (Spain)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - FRA (Francia)'){
		$languages.='ENG (USA) - FRE (France)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - FRA (Canadá)'){
		$languages.='ENG (USA) - FRE (Canada)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - POR (Brasil)'){
		$languages.='ENG (USA) - POR (Brazil)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - POR (Portugal)'){
		$languages.='ENG (USA) - POR (Portugal)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - ALE (Alemania)'){
		$languages.='ENG (USA) - GER (Germany)';
	}elseif($row2['idiomas']=='ING (EE.UU.) - ITA (Italia)'){
		$languages.='ENG (USA) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='ING (Reino Unido) - ESP (Perú)'){
		$languages.='ENG (UK) - SPA (Peru)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - ESP (España)'){
		$languages.='ENG (UK) - SPA (Spain)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - FRA (Francia)'){
		$languages.='ENG (UK) - FRE (France)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - FRA (Canadá)'){
		$languages.='ENG (USA) - FRE (Canada)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - POR (Brasil)'){
		$languages.='ENG (UK) - POR (Brazil)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - POR (Portugal)'){
		$languages.='ENG (UK) - POR (Portugal)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - ALE (Alemania)'){
		$languages.='ENG (UK) - GER (Germany)';
	}elseif($row2['idiomas']=='ING (Reino Unido) - ITA (Italia)'){
		$languages.='ENG (UK) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='ING (Australia) - ESP (Perú)'){
		$languages.='ENG (Australia) - SPA (Peru)';
	}elseif($row2['idiomas']=='ING (Australia) - ESP (España)'){
		$languages.='ENG (Australia) - SPA (Spain)';
	}elseif($row2['idiomas']=='ING (Australia) - FRA (Francia)'){
		$languages.='ENG (Australia) - FRE (France)';
	}elseif($row2['idiomas']=='ING (Australia) - FRA (Canadá)'){
		$languages.='ENG (Australia) - FRE (Canada)';
	}elseif($row2['idiomas']=='ING (Australia) - POR (Brasil)'){
		$languages.='ENG (Australia) - POR (Brazil)';
	}elseif($row2['idiomas']=='ING (Australia) - POR (Portugal)'){
		$languages.='ENG (Australia) - POR (Portugal)';
	}elseif($row2['idiomas']=='ING (Australia) - ALE (Alemania)'){
		$languages.='ENG (Australia) - GER (Germany)';
	}elseif($row2['idiomas']=='ING (Australia) - ITA (Italia)'){
		$languages.='ENG (Australia) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='ING (Canada) - ESP (Perú)'){
		$languages.='ENG (Canada) - SPA (Peru)';
	}elseif($row2['idiomas']=='ING (Canada) - ESP (España)'){
		$languages.='ENG (Canada) - SPA (Spain)';
	}elseif($row2['idiomas']=='ING (Canada) - FRA (Francia)'){
		$languages.='ENG (Canada) - FRE (France)';
	}elseif($row2['idiomas']=='ING (Canada) - FRA (Canadá)'){
		$languages.='ENG (Canada) - FRE (Canada)';
	}elseif($row2['idiomas']=='ING (Canada) - POR (Brasil)'){
		$languages.='ENG (Canada) - POR (Brazil)';
	}elseif($row2['idiomas']=='ING (Canada) - POR (Portugal)'){
		$languages.='ENG (Canada) - POR (Portugal)';
	}elseif($row2['idiomas']=='ING (Canada) - ALE (Alemania)'){
		$languages.='ENG (Canada) - GER (Germany)';
	}elseif($row2['idiomas']=='ING (Canada) - ITA (Italia)'){
		$languages.='ENG (Canada) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='ING (Emiratos Arabes) - ESP (Perú)'){
		$languages.='ENG (United Arab Emirates) - SPA (Peru)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - ESP (España)'){
		$languages.='ENG (United Arab Emirates) - SPA (Spain)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - FRA (Francia)'){
		$languages.='ENG (United Arab Emirates) - FRE (France)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - FRA (Canadá)'){
		$languages.='ENG (United Arab Emirates) - FRE (Canada)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - POR (Brasil)'){
		$languages.='ENG (United Arab Emirates) - POR (Brazil)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - POR (Portugal)'){
		$languages.='ENG (United Arab Emirates) - POR (Portugal)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - ALE (Alemania)'){
		$languages.='ENG (United Arab Emirates) - GER (Germany)';
	}elseif($row2['idiomas']=='ING (Emiratos Arabes) - ITA (Italia)'){
		$languages.='ENG (United Arab Emirates) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='FRA (Francia) - ESP (Perú)'){
		$languages.='FRE (France) - SPA (Peru)';
	}elseif($row2['idiomas']=='FRA (Francia) - ESP (España)'){
		$languages.='FRE (France) - SPA (Spain)';
	}elseif($row2['idiomas']=='FRA (Francia) - ALE (Alemania)'){
		$languages.='FRE (France) - GER (Germany)';
	}elseif($row2['idiomas']=='FRA (Francia) - POR (Brasil)'){
		$languages.='FRE (France) - POR (Brazil)';
	}elseif($row2['idiomas']=='FRA (Francia) - POR (Portugal)'){
		$languages.='FRE (France) - POR (Portugal)';
	}elseif($row2['idiomas']=='FRA (Francia) - ING (EE.UU.)'){
		$languages.='FRE (France) - ENG (USA)';
	}elseif($row2['idiomas']=='FRA (Francia) - ING (Reino Unido)'){
		$languages.='FRE (France) - ENG (UK)';
	}elseif($row2['idiomas']=='FRA (Francia) - ING (Australia)'){
		$languages.='FRE (France) - ENG (Australia)';
	}elseif($row2['idiomas']=='FRA (Francia) - ING (Canada)'){
		$languages.='FRE (France) - ENG (Canada)';
	}elseif($row2['idiomas']=='FRA (Francia) - ING (Emiratos Arabes)'){
		$languages.='FRE (France) - ENG (United Arab Emirates)';
	}elseif($row2['idiomas']=='FRA (Francia) - ITA (Italia)'){
		$languages.='FRE (France) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='FRA (Canadá) - ESP (Perú)'){
		$languages.='FRE (Canada) - SPA (Peru)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ESP (España)'){
		$languages.='FRE (Canada) - SPA (Spain)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ALE (Alemania)'){
		$languages.='FRE (Canada) - GER (Germany)';
	}elseif($row2['idiomas']=='FRA (Canadá) - POR (Brasil)'){
		$languages.='FRE (Canada) - POR (Brazil)';
	}elseif($row2['idiomas']=='FRA (Canadá) - POR (Portugal)'){
		$languages.='FRE (Canada) - POR (Portugal)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ING (EE.UU.)'){
		$languages.='FRE (Canada) - ENG (USA)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ING (Reino Unido)'){
		$languages.='FRE (Canada) - ENG (UK)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ING (Australia)'){
		$languages.='FRE (Canada) - ENG (Australia)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ING (Canada)'){
		$languages.='FRE (Canada) - ENG (Canada)';
	}elseif($row2['idiomas']=='FRA (Canadá) - ING (Emiratos Arabes)'){
		$languages.='FRE (Canada) - ENG (United Arab Emirates)';
	}
	elseif($row2['idiomas']=='FRA (Canadá) - ITA (Italia)'){
		$languages.='FRE (Canada) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='POR (Brasil) - ESP (Perú)'){
		$languages.='POR (Brazil) - SPA (Peru)';
	}elseif($row2['idiomas']=='POR (Brasil)) - ESP (España)'){
		$languages.='POR (Brazil) - SPA (Spain)';
	}elseif($row2['idiomas']=='POR (Brasil) - FRA (Francia)'){
		$languages.='POR (Brazil) - FRE (France)';
	}elseif($row2['idiomas']=='POR (Brasil) - FRA (Canadá)'){
		$languages.='POR (Brazil) - FRE (Canada)';
	}elseif($row2['idiomas']=='POR (Brasil) - ALE (Alemania)'){
		$languages.='POR (Brazil) - GER(Germany)';
	}elseif($row2['idiomas']=='POR (Brasil) - ING (EE.UU.)'){
		$languages.='POR (Brazil) - ENG (USA)';
	}elseif($row2['idiomas']=='POR (Brasil) - ING (Reino Unido)'){
		$languages.='POR (Brazil)- ENG (UK)';
	}elseif($row2['idiomas']=='POR (Brasil) - ING (Australia)'){
		$languages.='POR (Brazil) - ENG (Australia)';
	}elseif($row2['idiomas']=='POR (Brasil) - ING (Canada)'){
		$languages.='POR (Brazil) - ENG (Canada)';
	}elseif($row2['idiomas']=='POR (Brasil) - ING (Emiratos Arabes)'){
		$languages.='POR (Brazil) - ENG (United Arab Emirates)';
	}
	elseif($row2['idiomas']=='POR (Brasil) - ITA (Italia)'){
		$languages.='POR (Brazil) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='POR (Portugal) - ESP (Perú)'){
		$languages.='POR (Portugal) - SPA (Peru)';
	}elseif($row2['idiomas']=='POR (Portugal) - ESP (España)'){
		$languages.='POR (Portugal) - SPA (Spain)';
	}elseif($row2['idiomas']=='POR (Portugal) - FRA (Francia)'){
		$languages.='POR (Portugal) - FRE (France)';
	}elseif($row2['idiomas']=='POR (Portugal) - FRA (Canadá)'){
		$languages.='POR (Portugal) - FRE (Canada)';
	}elseif($row2['idiomas']=='POR (Portugal) - ALE (Alemania)'){
		$languages.='POR (Portugal) - GER (Germany)';
	}elseif($row2['idiomas']=='POR (Portugal) - ING (EE.UU.)'){
		$languages.='POR (Portugal) - ENG (USA)';
	}elseif($row2['idiomas']=='POR (Portugal) - ING (Reino Unido)'){
		$languages.='POR (Portugal) - ENG (UK)';
	}elseif($row2['idiomas']=='POR (Portugal) - ING (Australia)'){
		$languages.='POR (Portugal) - ENG (Australia)';
	}elseif($row2['idiomas']=='POR (Portugal) - ING (Canada)'){
		$languages.='POR (Portugal) - ENG (Canada)';
	}elseif($row2['idiomas']=='POR (Portugal) - ING (Emiratos Arabes)'){
		$languages.='POR (Portugal) - ENG (United Arab Emirates)';
	}elseif($row2['idiomas']=='POR (Portugal) - ITA (Italia)'){
		$languages.='POR (Portugal) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='ALE (Alemania) - ESP (Perú)'){
		$languages.='GER (Germany) - SPA (Peru)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ESP (España)'){
		$languages.='GER (Germany) - SPA (Spain)';
	}elseif($row2['idiomas']=='ALE (Alemania) - FRA (Francia)'){
		$languages.='GER (Germany) - FRE (France)';
	}elseif($row2['idiomas']=='ALE (Alemania) - FRA (Canadá)'){
		$languages.='GER (Germany) - FRE (Canada)';
	}elseif($row2['idiomas']=='ALE (Alemania) - POR (Brasil)'){
		$languages.='GER (Germany) - POR (Brazil)';
	}elseif($row2['idiomas']=='ALE (Alemania) - POR (Portugal)'){
		$languages.='GER (Germany) - POR (Portugal)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ING (EE.UU.)'){
		$languages.='GER (Germany) - ENG (USA)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ING (Reino Unido)'){
		$languages.='GER (Germany) - ENG (UK)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ING (Australia)'){
		$languages.='GER (Germany) - ENG (Australia)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ING (Canada)'){
		$languages.='GER (Germany) - ENG (Canada)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ING (Emiratos Arabes)'){
		$languages.='GER (Germany) - ENG (United Arab Emirates)';
	}elseif($row2['idiomas']=='ALE (Alemania) - ITA (Italia)'){
		$languages.='GER (Germany) - ITA (Italy)';
	}
	elseif($row2['idiomas']=='ITA (Italia) - ESP (Perú)'){
		$languages.='ITA (Italy) - SPA (Peru)';
	}elseif($row2['idiomas']=='ITA (Italia) - ESP (España)'){
		$languages.='ITA (Italy) - SPA (Spain)';
	}elseif($row2['idiomas']=='ITA (Italia) - FRA (Francia)'){
		$languages.='ITA (Italy) - FRE (France)';
	}elseif($row2['idiomas']=='ITA (Italia) - FRA (Canadá)'){
		$languages.='ITA (Italy) - FRE (Canada)';
	}elseif($row2['idiomas']=='ITA (Italia) - POR (Brasil)'){
		$languages.='ITA (Italy) - POR (Brazil)';
	}elseif($row2['idiomas']=='ITA (Italia) - POR (Portugal)'){
		$languages.='ITA (Italy)- POR (Portugal)';
	}elseif($row2['idiomas']=='ITA (Italia) - ING (EE.UU.)'){
		$languages.='ITA (Italy) - ENG (USA)';
	}elseif($row2['idiomas']=='ITA (Italia) - ING (Reino Unido)'){
		$languages.='ITA (Italy) - ENG (UK)';
	}elseif($row2['idiomas']=='ITA (Italia) - ING (Australia)'){
		$languages.='ITA (Italy) - ENG (Australia)';
	}elseif($row2['idiomas']=='ITA (Italia) - ING (Canada)'){
		$languages.='ITA (Italy) - ENG (Canada)';
	}elseif($row2['idiomas']=='ITA (Italia) - ING (Emiratos Arabes)'){
		$languages.='ITA (Italy) - ENG (United Arab Emirates)';
	}
	elseif($row2['idiomas']=='ESP (Perú) - COR (Corea)'){
		$languages.='SPA (Peru) - KOR (Korea)';
	}
	elseif($row2['idiomas']=='COR (Corea) - ESP (Perú)'){
		$languages.='KOR (Korea) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='ESP (Perú) - IDN (Indonesia)'){
		$languages.='SPA (Peru) - IND (Indonesia)';
	}
	elseif($row2['idiomas']=='IDN (Indonesia) - ESP (Perú)'){
		$languages.='IND (Indonesia) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='HOL (Holanda) - ESP (España)'){
		$languages.='DUT (Netherlands) - SPA (Spain)';
	}
	elseif($row2['idiomas']=='HOL (Holanda) - ESP (Perú)'){
		$languages.='DUT (Netherlands) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='ESP (Perú) - QUE (Perú)'){
		$languages.='SPA (Peru) - QUE (Peru)';
	}
	elseif($row2['idiomas']=='QUE (Perú) - ESP (Perú)'){
		$languages.='QUE (Perú) - SPA (Peru)';
	}
	elseif($row2['idiomas']=='QUECHUA (Perú)'){
		$languages.='QUECHUA (Perú)';
	}
	elseif($row2['idiomas']=='ESPAÑOL (Perú)'){
		$languages.='SPANISH (Peru)';
	}
	elseif($row2['idiomas']=='ESPAÑOL (España)'){
		$languages.='SPANISH (Spain)';
	}
	elseif($row2['idiomas']=='INGLÉS (EE.UU.)'){
		$languages.='ENGLISH (USA)';
	}
	elseif($row2['idiomas']=='INGLÉS (Reino Unido)'){
		$languages.='ENGLISH (UK)';
	}
	elseif($row2['idiomas']=='INGLÉS (Australia)'){
		$languages.='ENGLISH (Australia)';
	}
	elseif($row2['idiomas']=='INGLÉS (Canada)'){
		$languages.='ENGLISH (Canada)';
	}
	elseif($row2['idiomas']=='INGLÉS (Emiratos Arabes)'){
		$languages.='ENGLISH (United Arab Emirates)';
	}
	elseif($row2['idiomas']=='FRANCÉS (Francia)'){
		$languages.='FRENCH (France)';
	}
	elseif($row2['idiomas']=='PERSIAN (Irán)'){
		$languages.='PERSIAN (Iran)';
	}
	elseif($row2['idiomas']=='COREANO (Corea)'){
		$languages.='KOREAN (Korea)';
	}
	elseif($row2['idiomas']=='RUSO (Rusia)'){
		$languages.='RUSSIAN (Russia)';
	}
    elseif($row2['idiomas']=='CHINO MANDARÍN (China)'){
		$languages.='MANDARIN CHINESE (China)';
	}
	elseif($row2['idiomas']=='FRANCÉS (Canadá)'){
		$languages.='FRENCH (Canada)';
	}
	elseif($row2['idiomas']=='ALEMÁN (Alemania'){
		$languages.='GERMAN (Germany)';
	}
	elseif($row2['idiomas']=='ITALIANO (Italia)'){
		$languages.='ITALIAN (Italy)';
	}
	elseif($row2['idiomas']=='PORTUGUÉS (Brasil)'){
		$languages.='PORTUGUESE (Brazil)';
	}
	elseif($row2['idiomas']=='PORTUGUÉS (Portugal)'){
		$languages.='PORTUGUESE (Portugal)';
	}
	elseif($row2['idiomas']=='JAPONÉS (Japón)'){
		$languages.='JAPANESE (Japan)';
	}

	$u2 = $row2['detalle'];
	if($u2=='Traduccion Digital de'){
		$html2.= "DIGITAL TRANSLATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row2['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row2['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row2['importe']."</td>
			</tr>";
	}elseif($u2=='Traduccion Certificada de') {
		$html2 .= "CERTIFIED TRANSLATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row2['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row2['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row2['importe']."</td>
			</tr>";
	}elseif($u2=='Traduccion Oficial de') {
		$html2 .= "OFFICIAL TRANSLATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Transcreacion de') {
		$html2 .= "DIGITAL TRANSCREATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Revision de') {
		$html2 .= "DIGITAL TRANSCRETION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Copia de Traduccion de') {
		$html2 .= "TRANSLATION COPY SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Envio a Domicilio') {
		$html2 .= "HOME DELIVERY SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Resumen') {
		$html2 .= "SUMMARY SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Tramite') {
		$html2 .= "PROCESSING SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Tramite') {
		$html2 .= "PROCESSING SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Transcripcion') {
		$html2 .= "DIGITAL TRANSCRIPTION SERVICE ".$row2['descripcion']." ".$languages."";
		$html2.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;vertical-align: text-top;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Revision y Certificacion de Traduccion de') {
		$html2 .= "TRANSLATION PROOFREADING AND CERTIFICATION SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Edición de') {
		$html2 .= "EDITING SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Subtitulacion de') {
		$html2 .= "SUBTITLING SERVICE: ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario']. "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'> $ " . $row2['importe'] . "</td>
			</tr>";
	}elseif($u2=='Traduccion Digital Urgente de'){
		$html2.= "URGENT DIGITAL TRANSLATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row2['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row2['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row2['importe']."</td>
			</tr>";
	}elseif($u2=='Traduccion Certificada Urgente de'){
		$html2.= "URGENT CERTIFIED TRANSLATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row2['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row2['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row2['importe']."</td>
			</tr>";
	}elseif($u2=='Traduccion Certificada Urgente de'){
		$html2.= "URGENT OFFICIAL TRANSLATION SERVICE OF ".$row2['descripcion']." " .$languages." (AMOUNT OF PAGES: ".$row2['paginas'].")";
		$html2.="</td> 
				<td style='text-align:center;vertical-align: text-top;'>".$row2['cantidad']."</td>
				<td style='text-align:center;vertical-align: text-top;'> $ ".$row2['precio_unitario']."</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ ".$row2['importe']."</td>
			</tr>";
	}
	elseif($u2=='Cargo Banco')  {
		$html2 .="BANK FEE FOR WIRE TRANSFER FROM USA <br><br>";
		$html2 .="</td> 
				<td style='text-align:center;'>" . $row2['cantidad'] . "</td>
				<td style='text-align:center;'> $ " . $row2['precio_unitario'] . "</td>
				<td style='text-align:right;border-right: 3px ;vertical-align: text-top;'>$ " . $row2['importe'] . "</td>
			</tr>";
	}
}


$html2.="           <tr style='height:20px;background:#EDEDED;'>
                        <td style='background:#FFF;'></td>
                        <td rowspan='3' colspan='1' style='border-left: 3px ;border-bottom:3px ;vertical-align:top;'>".$valoresx."<br></td>
                        <td style='text-align:right;'>Subtotal:</td>
                        <td style='text-align:right;;width:200px;border-right: 3px ;'>$ ".number_format($subtotal,2,'.',',')."</td>
                    </tr>
					<tr style='background: #EDEDED;color: #FFF;'>
                        <td style='background:#FFF;'></td>
                        <td style='text-align:right;color:#000;'><b>Total:</b></td>
                        <td style='text-align:right;color:#000;width:200px;border-right: 3px ;'><b>$ ".number_format($subtotal,2,'.',',')." ".$acron."</b></td>
                    </tr>
				</table>
            </div>
			<br><hr><br>
            <table style='width:100%;'>
				<tr>
					<td width='50%' style='vertical-align:top;'>
						<div>
							<b>Notes</b><br><br>CLAIMANT ".$referencial."
						</div>
					</td>

					<td width='10%'></td>
					
					<td width='40%' style='vertical-align:top;'>
						<div><b>Terms and Conditions</b><br><br>Payment terms Net 7</div>
					</td>
					
				</tr>
				</table>
            <br><br>";

$mpdf = new mPDF('','A4','','',14,14,4,'','',2);
$mpdf -> WriteHTML($html);

$attach = $mpdf -> Output('','S');
$mpdf2 = new mPDF('','A4','','',14,14,4,'','',2);
$mpdf2 -> WriteHTML($html2);
$attach2 = $mpdf2 -> Output('','S');
$nomfile = "FACTURA N° ".$numFact." - TRADUCCION " . $referencial . ".pdf";
$nomfile2 = "INVOICE # ".$numFact." - TRANSLATION " . $referencial . ".pdf";

$encoding = "base64";
$type ="application/octet-stream";

$path="../../../quotes/".$nomfile;
$path2="../../../quotes/".$nomfile2;
file_put_contents($path, $attach);  // Guardar el primer archivo
file_put_contents($path2, $attach2);  // Guardar el segundo archivo
//////////////////

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
$mail->FromName = $enom;

$mail->Subject = $asunto;
//$mail->addAddress($correo);
$addr = explode(',',$correo);

foreach ($addr as $ad) {
    $mail->AddAddress( trim($ad) );
}

$mail->IsHTML(true);
if($filename!=''){
	$mail->MsgHTML($mensajea.$mensajex.$mensaje);
}
else  $mail->MsgHTML($mensajea.$mensajec.$mensaje);

$mail->AddStringAttachment($attach,$nomfile,$encoding,$type);
$mail->AddStringAttachment($attach2,$nomfile2,$encoding,$type);


if($mail->Send()){
	echo  $codproyecto;
}
// ====================================
// 			INSERTAR HISTORIAL
// ====================================
/*admin*/
$sadm = "SELECT * FROM admin_limac where id_al='$idPersonal'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$comentario = "El $perfilPersonal $nomadm  ha enviado recibo a InSpectre Solutions " .$referencial. " - (" . $correo. ")";
$sql_recibo_historial = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,fecha,mensaje) values('$codproyecto','$idPersonal','$perfilPersonal','RECIBOV1','$datee','$comentario')";
$res_recibo_historial = mysqli_query($connect,$sql_recibo_historial);
?>
