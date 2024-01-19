<?php //include("bloque.php"); ?> 
<?php
//include("../limac_conexion/conexion.php"); 			
?>

<?php
	session_start();
	
	if(isset($_COOKIE['admin']) && $_COOKIE['admin'] != ''){
 	include("../../../limac_conexion/conexion.php");
	 $user_login = $_COOKIE['admin'];
	 //$mess .= "Cookie activada";
	 //get user data from mysql

	}else if(isset($_SESSION['admin']) && $_SESSION['admin'] !=''){
	 include("../../../limac_conexion/conexion.php");
	 $user_login = $_SESSION['admin'];
	 //get user data from mysql
	} else{
		header("Location: http://www.limac.com.pe/login/");
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Empresa de Traducción en Lima | Limac | Portal</title>
	<meta name="keywords" content="traduccion, interpretacion, lima, peru, limac, traductor, interprete, doblaje">
	<meta name="author" content="Limac Soluciones">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="description" content="Como empresa de traducción e interpretación líder en Lima, Perú, le brindamos calidad superior, total confidencialidad y tarifas atractivas. Tomamos todas las precauciones necesarias para asegurar que esté 100% satisfecho con el servicio brindado.">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../assets/images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../../../assets/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../../../assets/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="../../../assets/images/favicons/manifest.json">
	<link rel="mask-icon" href="../../../assets/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" type="text/css" href="../../../assets/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/hover.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/font-awesome.min.css">
	<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.sync.bootstrap.min.js"></script>
	<style>
	@import url('https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900');@import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css);@import url(https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i,900,900i);
	@charset "UTF-8";
	body{font-family:'Maven Pro', sans-serif;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}
	</style>
</head>
<body style="background:#0079a1;">

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
		<br><br><br>
<?php
		date_default_timezone_set('America/Lima');
		//setlocale(LC_ALL, 'es_PE');
		setlocale(LC_TIME, "es_PE");

		$dia=date("l"); // Saturday

        /*if ($dia=="Monday") $dia="Lunes";
        if ($dia=="Tuesday") $dia="Martes";
        if ($dia=="Wednesday") $dia="Miércoles";
        if ($dia=="Thursday") $dia="Jueves";
        if ($dia=="Friday") $dia="Viernes";
        if ($dia=="Saturday") $dia="Sabado";
        if ($dia=="Sunday") $dia="Domingo";*/

        $mes=date("F"); // November
        /*if ($mes=="January") $mes="Enero";
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
        if ($mes=="December") $mes="Diciembre";*/

        $ano=date("Y"); // 2012

        $dia2 = date("d");

		$code_fecha = date(dmY);

		//DATOS
		$nombre_cliente=$_POST['nombre'];
		$correo=$_POST['correo'];
		$tipo_unidad=$_POST['tipo_unidad'];

		$tipo_unidad2=$_POST['tipo_unidad2'];
		$tipo_unidad3=$_POST['tipo_unidad3'];
		$tipo_unidad4=$_POST['tipo_unidad4'];
		$tipo_unidad5=$_POST['tipo_unidad5'];
		$tipo_unidad6=$_POST['tipo_unidad6'];
		$tipo_unidad7=$_POST['tipo_unidad7'];
		$tipo_unidad8=$_POST['tipo_unidad8'];
		
		$sexo=$_POST['sexo'];

		$tipocot = $_POST['quote'];

		$SQLPS = "SELECT * FROM limac_pass where estado='ACTIVO'";
		$RQLPS = mysql_query($SQLPS);
		$GQLPS = mysql_fetch_array($RQLPS);
		$usrname = $GQLPS['username'];
		$psword = $GQLPS['password'];
		$usfrom = $GQLPS['from'];

		if($tipocot=='LANGUAGEHIVE'){
            $eemail = "ventas@languagehive.com";
            $url_pay = "https://www.languagehive.com/en-US/payment/";
        } else {
            $eemail = $usfrom;
            $url_pay = "https://www.limac.com.pe/pagos/";
        }

		if($sexo=='Masculino'){
			$est = 'Dear Mr. ';
		}

		if($sexo=='Femenino'){
			$est='Dear Miss ';
		}

		$empresa=$_POST['empresa'];


		$atencion=$_POST['atencion'];
		$at=$_POST['at'];


		if($empresa=='Yes'){
			$est='Dear Sirs ';
		}

		$moneda=$_POST['moneda'];

		if($moneda=='soles'){
			$symbol='S/';
			$valores='Values in Nuevos Soles (S/).';
		}

		if($moneda=='dolares'){
			$symbol='$';
			$valores='Values in US Dollar ($).';
		}

		$desc=$_POST['desc'];
		$idiomas=$_POST['idiomas'];
		$cantidad=$_POST['cantidad'];
		$precio_unitario=$_POST['precio_unitario'];
		$detalles=$_POST['detalles'];
		$importe=$_POST['importe'];
		$dest=$_POST['dest'];

		$desc2=$_POST['desc2'];
		$idiomas2=$_POST['idiomas2'];
		$cantidad2=$_POST['cantidad2'];
		$precio_unitario2=$_POST['precio_unitario2'];
		$detalles2=$_POST['detalles2'];
		$importe2=$_POST['importe2'];
		$dest2=$_POST['dest2'];

		$desc3=$_POST['desc3'];
		$idiomas3=$_POST['idiomas3'];
		$cantidad3=$_POST['cantidad3'];
		$precio_unitario3=$_POST['precio_unitario3'];
		$detalles3=$_POST['detalles3'];
		$importe3=$_POST['importe3'];
		$dest3=$_POST['dest3'];

		$desc4=$_POST['desc4'];
		$idiomas4=$_POST['idiomas4'];
		$cantidad4=$_POST['cantidad4'];
		$precio_unitario4=$_POST['precio_unitario4'];
		$detalles4=$_POST['detalles4'];
		$importe4=$_POST['importe4'];
		$dest4=$_POST['dest4'];

		$desc5=$_POST['desc5'];
		$idiomas5=$_POST['idiomas5'];
		$cantidad5=$_POST['cantidad5'];
		$precio_unitario5=$_POST['precio_unitario5'];
		$detalles5=$_POST['detalles5'];
		$importe5=$_POST['importe5'];
		$dest5=$_POST['dest5'];

		$desc6=$_POST['desc6'];
		$idiomas6=$_POST['idiomas6'];
		$cantidad6=$_POST['cantidad6'];
		$precio_unitario6=$_POST['precio_unitario6'];
		$detalles6=$_POST['detalles6'];
		$importe6=$_POST['importe6'];
		$dest6=$_POST['dest6'];

		$desc7=$_POST['desc7'];
		$idiomas7=$_POST['idiomas7'];
		$cantidad7=$_POST['cantidad7'];
		$precio_unitario7=$_POST['precio_unitario7'];
		$detalles7=$_POST['detalles7'];
		$importe7=$_POST['importe7'];
		$dest7=$_POST['dest7'];

		$desc8=$_POST['desc8'];
		$idiomas8=$_POST['idiomas8'];
		$cantidad8=$_POST['cantidad8'];
		$precio_unitario8=$_POST['precio_unitario8'];
		$detalles8=$_POST['detalles8'];
		$importe8=$_POST['importe8'];
		$dest8=$_POST['dest8'];



		$subtotal=$_POST['subtotal'];
		$igv=$_POST['igv'];
		$total=$_POST['total'];

		$fecha_entrega=$_POST['fecha_entrega'];
		$fecha_entrega2=$_POST['fecha_entrega2'];
		$metodo_pago=$_POST['mp2'];
		$formato_entrega=$_POST['forment2'];
		$validez_oferta=$_POST['validez_oferta'];
		$tipo_entrega=$_POST['forma2'];
		$detalle_entrega=$_POST['detalle_entrega'];

		$tipo_pago=$_POST['tipo_pago'];
		$payu=$_POST['payu'];
		
		$file_link=$_POST['file-link'];

		$lady_files=$_POST['lady_files'];
		$nathaly_files=$_POST['nathaly_files'];
	    $ruc_file=$_POST['ruc_file'];
	    $rnp_file=$_POST['rnp_file'];

	    $discount = $_POST['discount'];
	    $dmonto = $_POST['dmonto'];

	    $cpr=$_POST['cpr'];
	    $ctrust=$_POST['ctrust'];
	    $cgoogle=$_POST['cgoogle'];

	    $firma=$_POST['firma'];

	    if($ctrust!=''){
	    	$codigop = $ctrust;
	    }

	    if($cgoogle!=''){
	    	$codigop = $cgoogle;
	    }
		
		$sql="INSERT INTO cotizacion_limac (date_code,
			nombre_cliente,
			correo_cliente,
			sexo,
			empresa,
			atencion,
			at,
			desc01,
			idiomas01,
			cantidad01,
			unidad01,
			precio_unitario01,
			detalles01,
			importe01,
			desc02,
			idiomas02,
			cantidad02,
			unidad02,
			precio_unitario02,
			detalles02,
			importe02,
			desc03,
			idiomas03,
			cantidad03,
			unidad03,
			precio_unitario03,
			detalles03,
			importe03,
			desc04,
			idiomas04,
			cantidad04,
			unidad04,
			precio_unitario04,
			detalles04,
			importe04,
			desc05,
			idiomas05,
			cantidad05,
			unidad05,
			precio_unitario05,
			detalles05,
			importe05,
			desc06,
			idiomas06,
			cantidad06,
			unidad06,
			precio_unitario06,
			detalles06,
			importe06,
			desc07,
			idiomas07,
			cantidad07,
			unidad07,
			precio_unitario07,
			detalles07,
			importe07,
			desc08,
			idiomas08,
			cantidad08,
			unidad08,
			precio_unitario08,
			detalles08,
			importe08,
			dscto,
			monto_dscto,
			subtotal,
			igv,
			total,
			moneda,
			fecha_entrega,
			metodo_pago,
			formato_entrega,
			validez_oferta,
			tipo_entrega,
			detalle_entrega,
			codepromo,
			emisor,entidad) values ";
		$sql.="('$code_fecha',
			'$nombre_cliente',
			'$correo',
			'$sexo',
			'$empresa',
			'$atencion',
			'$at',
			'$desc',
			'$idiomas',
			'$cantidad',
			'$tipo_unidad',
			'$precio_unitario',
			'$detalles',
			'$importe',
			'$desc2',
			'$idiomas2',
			'$cantidad2',
			'$tipo_unidad2',
			'$precio_unitario2',
			'$detalles2',
			'$importe2',
			'$desc3',
			'$idiomas3',
			'$cantidad3',
			'$tipo_unidad3',
			'$precio_unitario3',
			'$detalles3',
			'$importe3',
			'$desc4',
			'$idiomas4',
			'$cantidad4',
			'$tipo_unidad4',
			'$precio_unitario4',
			'$detalles4',
			'$importe4',
			'$desc5',
			'$idiomas5',
			'$cantidad5',
			'$tipo_unidad5',
			'$precio_unitario5',
			'$detalles5',
			'$importe5',
			'$desc6',
			'$idiomas6',
			'$cantidad6',
			'$tipo_unidad6',
			'$precio_unitario6',
			'$detalles6',
			'$importe6',
			'$desc7',
			'$idiomas7',
			'$cantidad7',
			'$tipo_unidad7',
			'$precio_unitario7',
			'$detalles7',
			'$importe7',
			'$desc8',
			'$idiomas8',
			'$cantidad8',
			'$tipo_unidad8',
			'$precio_unitario8',
			'$detalles8',
			'$importe8',
			'$discount',
			'$dmonto',
			'$subtotal',
			'$igv',
			'$total',
			'$moneda',
			'$fecha_entrega"."$fecha_entrega2',
			'$metodo_pago',
			'$formato_entrega',
			'$validez_oferta',
			'$tipo_entrega',
			'$detalle_entrega',
			'$codigop',
			'LIMAC','$firma')";
		$result=mysql_query($sql);
		

		//Enviar email de cotización
		
		$sql_mail="Select concat(id_cotizacion,date_code) codigo_cotizacion,nombre_cliente,correo_cliente,
		desc01,idiomas01,cantidad01,precio_unitario01,detalles01,importe01,subtotal,igv,total 
		from cotizacion_limac ORDER BY id_cotizacion DESC LIMIT 1";
		$result_mail=mysql_query($sql_mail);
		$row_mail=mysql_fetch_array($result_mail);
		
		$asunto ="【QUOTE N° ".$row_mail['codigo_cotizacion']."】";

// 		$mensaje = "<html><body>";
// 		$mensaje .= "<table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;background:#DDD;'>
// 		<tr><td align='center'>";
// 		$mensaje .= "<div class='container' style='width:900px;'>";
//  		$mensaje .= "<div style='width:50px; text-align:center; display: inline-block; margin: 0;'></div>";
//  		$mensaje .= "<div style='width:800px;display:inline-block;margin-top:35px;margin-bottom:35px;font-size:14px;font-family:Maven Pro,sans-serif;border:1px solid #ccc;background:#FFF;padding-left: 40px;
//  		padding-right: 40px;padding-top: 30px;'>";
// /*
//  		if($tipocot=='LANGUAGEHIVE'){
//             $mensaje .= "<div style='width:140px;display:inline-block;float:left;'><img src='https://www.languagehive.com/en-US/assets/images/lh_logo_new.png' width='260'></div>";
//         } else {*/
//             $mensaje .= "<div style='width:140px;display:inline-block;float:left;'><img src='https://www.limac.com.pe/assets/images/logos/firma.jpg' width='160'></div>";
//         //}

//  		$mensaje .= "<div style='width:200px;display:inline-block;text-align:center;float:right;'>";

// 		//if($tipocot=='LANGUAGEHIVE'){
//             $mensaje .= "R&E TRADUCCIONES S. A. C.<br>R. U. C. 20551971300<br>";
//         /*} else {
//             $mensaje .= "LIMAC DEL PERÚ E.I.R.L.<br>R. U. C. 20603296410<br>";
//         }*/

// 		$mensaje .="QUOTE N° ".$row_mail['codigo_cotizacion']."</div><br>";
// 		$mensaje .= "<div style='width:800px; text-align:left; margin-top:75px;clear:both;'>".$mes." ".$dia2.", ".$ano."</div><br>";
// 		$mensaje .= "<div style='width:800px; text-align:left;font-weight: 600;font-size: 16px;'>".$est.$row_mail['nombre_cliente'].":</div>";

// 		if($atencion=='Yes'){
// 			$mensaje.="<div style='width:800px; text-align:left;font-size: 16px;'>Attention: ".$at."</div>";
// 		}

// 		$mensaje .= "<br><div style='width:800px; text-align:justify;'>Thank you for contacting us for the quote of translation service as you request. 
//         Provided below are the details of the quote and will indicate what the price of the service includes.</div><br><br>";

// 		$mensaje .= "<div style='width:800px;'>".
// 		"<table style='width:100%; border-collapse:collapse;'>".
// 		"<tr style='border-bottom: 3px solid #047ab7;color: #000;'>
// 	    <th><b>Quantity</b></th>
// 	    <th align='center' style='width:80px;'><b>Unit</b></th>
// 	    <th style='text-align:center;width:430px;'><b>Description</b></th> 
// 	    <th><b>Unit Price (".$symbol.")</b></th>
// 	    <th><b>Price (".$symbol.")</b></th>
// 	  	</tr>
// 	  	<tr style='color:#868686;'>
// 	    <td style='text-align:center;background:#FFF;'>".$row_mail['cantidad01']."</td>
// 	    <td style='border-top: 3px solid #047ab7;text-align:center;background:#FFF;border-left: 3px solid #047ab7;'>".$tipo_unidad."</td>
// 	    <td style=''>".$row_mail['detalles01']." ".$row_mail['desc01']." ". $row_mail['idiomas01'] ." ".$dest."</td> 
// 	    <td style='text-align:center;'>".$row_mail['precio_unitario01']."</td>
// 	    <td style='text-align:right;border-right: 3px solid #047ab7;'>".$row_mail['importe01']."</td>
// 	 	</tr>";

// 	 	if($cantidad!=''){  

//             if($cantidad2!=''){
//                 $mensaje .= "<tr style='color:#868686 !important;height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad2."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;height:20px;font-size:14px;'>".$tipo_unidad2."</td>
//                 <td style='font-size:14px;'>".$detalles2." ".$desc2." ".$idiomas2." ".$dest2."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario2."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe2."</td>
//                 </tr>";
//             }

//             if($cantidad3!=''){
//                 $mensaje.="<tr style='color:#868686 !important;height:20px;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad3."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:14px;'>".$tipo_unidad3."</td>
//                 <td style='height:20px;font-size:14px;'>".$detalles3." ".$desc3." ".$idiomas3." ".$dest3."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario3."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe3."</td>
//                 </tr>";
//             }

//             if($cantidad4!=''){
//                 $mensaje.="<tr style='color:#868686 !important;height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad4."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:14px;'>".$tipo_unidad4."</td>
//                 <td style='height:20px;font-size:14px;'>".$detalles4." ".$desc4." ".$idiomas4." ".$dest4."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario4."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe4."</td>
//                 </tr>";
//             }

//             if($cantidad5!=''){
//                 $mensaje.="<tr style='color:#868686 !important;height:20px;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad5."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:14px;'>".$tipo_unidad5."</td>
//                 <td style='height:20px;font-size:14px;'>".$detalles5." ".$desc5." ".$idiomas5." ".$dest5."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario5."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe5."</td>
//                 </tr>";
//             }

//             if($cantidad6!=''){
//                 $mensaje.="<tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad6."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:14px;'>".$tipo_unidad6."</td>
//                 <td style='height:20px;font-size:14px;'>".$detalles6." ".$desc6." ".$idiomas6." ".$dest6."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario6."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe6."</td>
//                 </tr>";
//             }


//              if($cantidad7!=''){
//                 $mensaje.="<tr style='height:20px;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad7."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:14px;'>".$tipo_unidad7."</td>
//                 <td style='height:20px;font-size:14px;'>".$detalles7." ".$desc7." ".$idiomas7." ".$dest7."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario7."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe7."</td>
//                 </tr>";
//             }

//             if($cantidad8!=''){
//                 $mensaje.="<tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:14px;'>".$cantidad8."</td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:14px;'>".$tipo_unidad8."</td>
//                 <td style='font-size:14px;'>".$detalles8." ".$desc8." ".$idiomas8." ".$dest8."</td> 
//                 <td style='text-align:center;font-size:14px;'>".$precio_unitario8."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;'>".$importe8."</td>
//                 </tr>";
//             }

//             if($discount=='Si'){
//                 $mensaje.="<tr style='color:#868686 !important;'>
//                 <td style='text-align:center;font-size:14px;'></td>
//                 <td style='text-align:center;background:#EDEDED;border-left: 3px solid #047ab7;font-size:14px;'></td>
//                 <td style='font-size:14px;background:#EDEDED;'>Descuento por promoción ";

//                 if($cpr=='TRUSTPILOT'){
//                     $mensaje.="- Código ".$ctrust;
//                 }

//                 if($cpr=='GOOGLE'){
//                     $mensaje.="- Código ".$cgoogle;
//                 }

//                 $mensaje.="</td> 
//                 <td style='text-align:center;font-size:14px;background:#EDEDED;'>-".$dmonto."</td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:14px;background:#EDEDED;'>-".$dmonto."</td>
//                 </tr>";
//             }

//             if($cantidad2=='' && $cantidad3=='' && $cantidad4=='' && $cantidad5=='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
//                 $mensaje.="<tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>
//                 <tr style='height:20px;background:#FFF;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>
//                 <tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>";
//             }

//             if($cantidad!='' && $cantidad2!='' && $cantidad3=='' && $cantidad4=='' && $cantidad5=='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
//                 $mensaje.="<tr style='height:20px;background:#FFF;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>
//                 <tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>";
//             }

//             if($cantidad!='' && $cantidad2!='' && $cantidad3!='' && $cantidad4=='' && $cantidad5=='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
//                 $mensaje.="<tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>";
//             }

//              if($cantidad!='' && $cantidad2!='' && $cantidad3!='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
//                 $mensaje.="<tr style='height:20px;background:#EDEDED;'>
//                 <td style='text-align:center;background:#FFF;font-size:12px;'></td>
//                 <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
//                 <td style='height:20px;font-size:12px;'></td> 
//                 <td style='text-align:center;font-size:12px;'></td>
//                 <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
//                 </tr>";
//             }

            


//         }

	  	
// 	  	$mensaje .= "<tr>
// 	  	<td style='background:#FFF;'></td>
// 	  	<td rowspan='3' colspan='2' style='border-left: 3px solid #047ab7;border-bottom:3px solid #047ab7;vertical-align:top;'>
// 	  	<b>Notes: </b>".$valores."<br>".$detalle_entrega."
// 	    </td>
// 	    <td style='text-align:right;'><b>Subtotal:</b></td>
// 	    <td style='text-align:right;border-right: 3px solid #047ab7;'>".$symbol." ".number_format($row_mail['subtotal'],2,'.',',')."</td>
// 	  	</tr>".
// 	  	"<tr>
// 	  	<td style='background:#FFF;'></td>
// 	    <td style='text-align:right;'><b>Sales Tax 18%:</b></td>
// 	    <td style='text-align:right;border-right: 3px solid #047ab7;'>".$symbol." ".number_format($row_mail['igv'],2,'.',',')."</td>
// 	  	</tr>".
// 	  	"<tr style='background: #047ab7;color: #FFF;'>
// 	  	<td style='background:#FFF;'></td>
// 	    <td style='text-align:right;border-bottom:3px solid #047ab7;'><b>Total:</b></td>
// 	    <td style='text-align:right;border-right: 3px solid #047ab7;border-bottom:3px solid #047ab7;'>".$symbol." ".number_format($row_mail['total'],2,'.',',')."</td>
// 	  	</tr>".

// 		"</table></div>";

// 		/*$mensaje .= "<br><table style='width:100%; border-collapse:collapse;'><tr><td style='width:70px;'><b>Notas: </b></td><td>".$detalle_entrega."</td></tr></table>";*/

// 		$mensaje .= "<br><br><div style='width:800px;text-align:left;'><b>Additional Details: </b></div>";
// 		$mensaje .= "<table style='width:100%; border-collapse:collapse;'>
		

// 		<tr>
// 		<td style='text-align:right; font-weight:500; width:45%;border-top:3px solid #72c3a9;'>Delivery Time</td>
// 		<td style='text-align:center; background:#72c3a9;border-top:3px solid #72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".$fecha_entrega.$fecha_entrega2."</td>
// 		</tr>

// 		<tr>
// 		<td style='text-align:right; font-weight:500;'>Payment Method</td>
// 		<td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".$metodo_pago."</td>
// 		</tr>

// 		<tr>
// 		<td style='text-align:right; font-weight:500;'>Delivery Format</td>
// 		<td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".$formato_entrega."</td>
// 		</tr>

// 		<tr>
// 		<td style='text-align:right; font-weight:500;'>Quote valid for</td>
// 		<td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".$validez_oferta."</td>
// 		</tr>

// 		<tr>
// 		<td style='text-align:right; font-weight:500;'>Delivery</td>
// 		<td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;border-bottom:3px solid #72c3a9;'>".$tipo_entrega."</td>
// 		</tr>


// 		</table>";

// 		if($tipo_pago=='deposito'){

// 		$mensaje .="<br><h4 style='text-align:left;'font-size:11px;'>Make your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#047AB7' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
// 		<table style='width:100%;border-collapse:collapse;'>
// 		<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
// 			<td>Bank</td>
// 			<td>Currency</td>
// 			<td>Account Type</td>
// 			<td>Account Number</td>
// 			<td>Interbank Account Code (IAC)</td>
// 			<td>Owner</td>
// 		</tr>

// 		<tr style='font-size: 11px;text-align: center;'>
// 			<td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
// 			<td>USA Dollars(USD)</td>
// 			<td>Current</td>
// 			<td>192-2145311-1-17</td>
// 			<td>002-192-002145311117-37</td>
// 			<td>R&E Traducciones S.A.C.</td>
// 		</tr>

// 		<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
// 			<td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
// 			<td>Soles (PEN)</td>
// 			<td>Current</td>
// 			<td>192-2172045-0-47</td>
// 			<td>002-192-002172045047-33</td>
// 			<td>R&E Traducciones S.A.C.</td>
// 		</tr>


// 		</table>
// 		<div style='font-size:9px;color:#000'>SWIFT: BCPLPEPL | MAIN ADDRESS: CALLE CENTENARIO NRO. 156 URB. LAS LADERAS DE MELGAREJO LA MOLINA, LIMA 12, PERÚ<br><br></div>";

// 		} else if($tipo_pago=='tarjeta'){
// 			$mensaje .="<h4 style='font-size:11px;text-align:left;'>Pay with credit or debit card via ";

// 			if($moneda=="soles"){
// 				$mensaje.="PayU";
// 			}

// 			if($moneda=="dolares"){
// 				$mensaje.="PayPal";
// 			}


// 			$mensaje.=":</h4>
//             <table style='width:100%;border-collapse:collapse;'>
//             <tr style='text-align:center;'>
//             <td style='text-align:center; border-right:2px solid #047AB7;'><a href='".$payu."' target='_blank'><img src='https://www.limac.com.pe/login-admin/images/logos.jpg'></a></td>
//             <td style='text-align:center;'>";

//                 if($moneda=="soles"){
// 	            	$mensaje.="<a href='".$payu."' target='_blank'><img src='https://www.limac.com.pe/login-admin/images/button-payu-pay.png'></a>";
// 	            }

// 	            if($moneda=="dolares"){
// 	            	$mensaje.="<a href='".$payu."' target='_blank'><img src='https://www.limac.com.pe/assets/images/b1.png'></a>";
// 	            }

//             /*$mensaje.="</td>
//             </tr>
//             </table>

//             <h4 style='font-size:11px;text-align:left;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#047AB7' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
//             <table style='width:100%;border-collapse:collapse;'>
//             <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
//             </tr>

//             <tr style='font-size: 11px;text-align: center;'>
//                 <td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>192-2145311-1-17</td>
//                 <td style='font-size: 11px;text-align: center;'>002-192-002145311117-37</td>
//                 <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
//             </tr>

//             <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
//                 <td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>192-2172045-0-47</td>
//                 <td style='font-size: 11px;text-align: center;'>002-192-002172045047-33</td>
//                 <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
//             </tr>


//             </table>
//             <div style='font-size:9px;color:#000;text-align:left !important;'>SWIFT: BCPLPEPL | MAIN ADDRESS: CALLE CENTENARIO NRO. 156 URB. LAS LADERAS DE MELGAREJO LA MOLINA, LIMA 12, PERÚ<br><br></div>";

//             $mensaje.="</td>
//             </tr>
//             </table>

//             <h4 style='font-size:11px;text-align:left;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#047AB7' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
//             <table style='width:100%;border-collapse:collapse;'>
//             <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
//             </tr>
//             <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
//                 <td><img src='https://www.limac.com.pe/assets/images/bbva-continental.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>0011-0467-0100004771</td>
//                 <td style='font-size: 11px;text-align: center;'>011-467-000100004771-80</td>
//                 <td style='font-size: 11px;text-align: center;'>LIMAC DEL PERÚ E.I.R.L.</td>
//             </tr>
//             </table>";
// 		}

// 		$mensaje .="<h4 style='font-size:12px;'>Pay with credit or debit card via <a style='text-decoration:none; color:#047AB7' href='".$url_pay."' target='_blank'>".$url_pay."</a></h4>";
//         $mensaje .="<table style='width:100%;border-collapse:collapse;'>
//                 <tr style='text-align:center;'>
//                 <td style='text-align:center;'><a href='".$url_pay."' target='_blank'><img src='https://www.limac.com.pe/login-admin/images/logos.jpg'></a></td></tr></table>";


//         if($tipocot=='LANGUAGEHIVE'){

//             /*$mensaje .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@languagehive.com'>ventas@languagehive.com</a></h4>
//                 <table style='width:100%;border-collapse:collapse;'>
//             <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
//             </tr>

//             <tr style='font-size: 11px;text-align: center;'>
//                 <td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>192-2145311-1-17</td>
//                 <td style='font-size: 11px;text-align: center;'>002-192-002145311117-37</td>
//                 <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
//             </tr>

//             <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
//                 <td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>192-2172045-0-47</td>
//                 <td style='font-size: 11px;text-align: center;'>002-192-002172045047-33</td>
//                 <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
//             </tr>
//             </table>
//             <div style='font-size:9px;color:#000'>SWIFT: BCPLPEPL | MAIN ADDRESS: CALLE CENTENARIO NRO. 156 URB. LAS LADERAS DE MELGAREJO LA MOLINA, LIMA 12, PERÚ<br><br></div>";*/

//             $mensaje .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@languagehive.com'>ventas@languagehive.com</a></h4>
//                 <table style='width:100%;border-collapse:collapse;'>
//                 <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
//                     <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
//                     <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
//                     <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
//                     <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
//                     <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
//                     <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
//                 </tr>

//                 <tr style='font-size: 11px;text-align: center;'>
//                     <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
//                     <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
//                     <td style='font-size: 11px;text-align: center;'>Current</td>
//                     <td style='font-size: 11px;text-align: center;'>0913001566466</td>
//                     <td style='font-size: 11px;text-align: center;'>003-091-003001566466-64</td>
//                     <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
//                 </tr>

//                 <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
//                     <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
//                     <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
//                     <td style='font-size: 11px;text-align: center;'>Current</td>
//                     <td style='font-size: 11px;text-align: center;'>0913001566459</td>
//                     <td style='font-size: 11px;text-align: center;'>003-091-003001566459-69</td>
//                     <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
//                 </tr>
//             </table>";

//         } else {

//             /*$mensaje .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>

//             <table style='width:100%;border-collapse:collapse;'>
//             <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
//             </tr>

//             <tr style='font-size: 11px;text-align: center;'>
//                 <td><img src='https://www.limac.com.pe/assets/images/bbva-continental.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>0011-0467-0100004771</td>
//                 <td style='font-size: 11px;text-align: center;'>011-467-000100004771-80</td>
//                 <td style='font-size: 11px;text-align: center;'>LIMAC DEL PERÚ E.I.R.L.</td>
//             </tr>
//             </table>";*/

//             $mensaje .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
//             <table style='width:100%;border-collapse:collapse;'>
//             <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
//                 <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
//             </tr>
//             <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
//                 <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>200-3001567347</td>
//                 <td style='font-size: 11px;text-align: center;width:180px;'>003-200-003001567347-35</td>
//                 <td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
//             </tr>

//             <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
//                 <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
//                 <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
//                 <td style='font-size: 11px;text-align: center;'>Current</td>
//                 <td style='font-size: 11px;text-align: center;'>200-3001567362</td>
//                 <td style='font-size: 11px;text-align: center;width:180px;'>003-200-003001567362-34</td>
//                 <td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
//             </tr>
//             </table>";

//         }


// 		if($firma=="ventas"){
//             $mensaje .= "<div style='width:800px;font-size:13px;text-align:left;'>".
//             "<p>Sincerely Yours,<br>
//             Sales Department.</p>";

//             if($tipocot=='LANGUAGEHIVE'){
//                 $mensaje .= "<div style='width:140px;display:inline-block;'><img src='https://www.languagehive.com/en-US/assets/images/lh_logo_new.png' width='180'></div>";
//             } else {
//                 $mensaje .= "<div style='width:140px;display:inline-block;'><img src='https://www.limac.com.pe/assets/images/logos/firma.jpg' width='120'></div>";
//             }

//             $mensaje.="</div>";

//         } else if($firma=="bruno"){
//             $mensaje .= "<div style='width:800px;font-size:13px;text-align:left;'>".
//             "<p>Sincerely Yours,</p>
//             <div style='margin-left:15px;'>   
//             <img src='https://www.limac.com.pe/assets/images/firma-bruno.jpg' width='100'></div>".
//             "Bruno Salvatore Espino Vallarino<br>General Manager<br>R&E Traducciones S.A.C.".
//             "</div>";
//         }
		

// 		$mensaje .= "<div style='width:800px; font-size:10px; color:#aaa; text-align:left;'>".
// 		"IMPORTANT/ CONFIDENTIAL<br>
//         This document contains personal and confidential information that are directed only and exclusively to its recipient and, in accordance with the law, 
//         it may not be spread. It is completely forbidden to make partial or total copies, as well as to spread content to others that are not the recipient. 
//         If you received this document for error, please inform to the sender and dispose of the document immediately. This quote has been issued at ". strftime("%H:%M %p") ."</div><br>";

// 		$mensaje .= "<div style='width:800px; text-align:center;'>";

// 		if($tipocot=='LANGUAGEHIVE'){
//             $mensaje.="R&E TRADUCCIONES S.A.C.<br>";
//         } else {
//             $mensaje.="LIMAC DEL PERÚ E.I.R.L.<br>";
//         }


// 		$mensaje.="Avenida El Derby 055 ";

// 		if($tipocot=='LANGUAGEHIVE'){
//             $mensaje.="Torre 1 - Piso 7";
//         } else {
//             $mensaje.="Torre 1 - Piso 7";
//         }

// 		$mensaje.=", Santiago de Surco, Lima.<br>
// 		Telephone: ";

// 		if($tipocot=='LANGUAGEHIVE'){
//             $numb = "SELECT * FROM telephone where estado='LANGUAGEHIVE'";
//             $resn = mysql_query($numb);
//             $regn = mysql_fetch_array($resn);
//             $mensaje.= $regn['numero'];
//         } else {
//             $numb = "SELECT * FROM telephone where estado='MOSTRAR'";
//             $resn = mysql_query($numb);
//             $regn = mysql_fetch_array($resn);
//             $mensaje.= $regn['numero'];
//         }

// 		$mensaje.=" * E-mail: ".$eemail."<br>".
// 		"</div><br><br>";
//  		$mensaje .= "<div style='width:50px; text-align:center; display: inline-block; margin: 0;'></div>";
// 		$mensaje .="</td></tr></table></body></html>";


//////////////////////////
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
          <b><br>".$est.$nombre_cliente.":</b>";


  if($atencion=='Yes'){
    $mensaje.="<div style='text-align:left;'>Attention: ".$at."</div>";
  }

$mensaje.="<p style='text-align: justify;'>We send your requested quote for Translation service. For more information, download the quote attached to this e-mail.<br><br></p>";
// $mensaje.="<p style='font-family:Maven Pro,sans-serif;text-align: justify;'>We send your requested quote for Translation service including these details:<br><br></p>";

// $mensaje.="
// <div><b>Quote Resume:</b>
// <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
// <tr>
// <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon004.png'></div></td>
// <td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Total:</b><br>".$symbol." ".number_format($row_mail['total'],2,'.',',')."</div></td>
// </tr>
// </table>
// </div>
// <hr>
// <div style='padding-top: 8px;padding-bottom: 8px;'>
// <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
// <tr>
// <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon002.png'></div></td>
// <td><div style='display: inline-block;top: 0px;    margin-left: 15px;position: relative;'><b>Delivery:</b><br>".$tipo_entrega."</div></td>
// </tr>
// </table>
// </div>
// <hr>";


// $mensaje.="
// <div style='padding-top: 8px;padding-bottom: 8px;'>
// <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
// <tr>
//   <td style='width:60px;'><div style='display: inline-block;top: 0px;position: relative;'><img src='https://www.limac.com.pe/assets/images/mail/icon001.png'></div></td>
//   <td><div style='display: inline-block;top: -8px;    margin-left: 15px;position: relative;'><b>Delivery Time:</b><br>".$fecha_entrega.$fecha_entrega2."</div></td>
// </tr>
// </table>
// </div><hr>";

// $mensaje.="
// <div style='padding-top: 8px;padding-bottom: 8px;'>
// <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
// <tr>
//   <td style='width:60px;text-align:center;'><b>For more information, download the quote attached to this e-mail.</b></td>
// </tr>
// </table>
// </div><hr>";

$mensaje.="<br><div style='margin-bottom:12px;'>If you have any question, you can write us ".$usfrom." o call us (01) 700 9040";
$mensaje.="</div>";
$mensaje.="</td></tr>";
$mensaje.='<tr style="background:#FFF;">
    <td align="left" style="background:#FFF;">
      <p style="margin-left:10px; margin-right:10px;font-size:16px;">Sincerely,<br><br>
      Sales Department.</p></td>
  </tr><tr>
    <td align="left">
      <div style="margin-left:10px !important;margin-right:10px !important;">
           
      </div>
    </td>
  </tr>';

$mensaje.= "<tr style='background:#FFF;'>
        <td align='left' style='font-size:10px; color:#aaa;background:#FFF;'>
          <div style='margin-left:10px; margin-right:10px; margin-bottom: 10px;'>
          IMPORTANT/ CONFIDENTIAL<br>
        This document contains personal and confidential information that are directed only and exclusively to its recipient and, in accordance with the law, 
        it may not be spread. It is completely forbidden to make partial or total copies, as well as to spread content to others that are not the recipient. 
        If you received this document for error, please inform to the sender and dispose of the document immediately.
          <br><br>
          </div>
        </td>
      </tr>
      <tr style='background-color:#0093DF;'><td align='center' style='background-color:#0093DF;color:#FFF;'><br><img src='https://www.limac.com.pe/assets/images/mail/firma3.png'></td></tr>
      <tr style='background-color:#0093DF;color:#FFF;'><td align='center' style='font-size: 12px;color:#FFF;text-decoration:none;'>";

if($firma=="RYE"){
	$mensaje.="R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>Avenida El Derby 055, Torre 1 - Piso 7, Santiago de Surco, Lima.<br>Telephone number: (01) 700 9040 * E-mail: ".$usfrom."<br>";
} else if($firma=="LIMACDELPERU"){
	$mensaje.="LIMAC DEL PERÚ E.I.R.L. - R.U.C. 20603296410<br>Avenida El Derby 055, Torre 1 - Piso 7, Santiago de Surco, Lima.<br>Telephone number: (01) 700 9040 * E-mail: ".$usfrom."<br>";
}

$mensaje.="</td></tr>
    </table>
  </td>
</tr>
</table>
</body></html>";

		/////////////////////////

		require "../../../PHPMailer/PHPMailerAutoload.php";
		require('../../../MPDF57/mpdf.php');

		///////////////////

		$html = "<html><head><style type='text/css'>
        body {font-family: maven_pro !important;}
        </style></head><body><div class='container' style='width:900px;'>";
        //$html .= "<div style='width:50px; text-align:center; display: inline-block; margin: 0;'></div>";
        $html .= "<div style='width:900px;display:inline-block;margin-top:0px;margin-bottom:35px;font-family:Maven Pro;font-size:14px;background:#FFF;padding-left: 0px;padding-right: 0px;padding-top: 0px;'>";

        /*if($tipocot=='LANGUAGEHIVE'){
            $html .= "<div style='display:inline-block;'><img src='https://www.languagehive.com/en-US/assets/images/lh_logo_new.png' width='260'></div>";
        } else {*/
            $html .= "<div style='display:inline-block;'><img src='https://www.limac.com.pe/assets/images/logos/logo_color2.jpg' width='160'></div>";
        //}

        $html .= "<div style='width:200px;display:inline-block;text-align:center;float:right;margin-top:-40px;'>";

        if($firma=="RYE"){
            $html .= "R&E TRADUCCIONES S. A. C.<br>R. U. C. 20551971300<br>";
        } else if($firma=="LIMACDELPERU"){
            $html .= "LIMAC DEL PERÚ E.I.R.L.<br>R. U. C. 20603296410<br>";
        }

        $html.="QUOTE N° ".$row_mail['codigo_cotizacion']."</div><br>";
        $html .= "<div style='width:800px; text-align:left; margin-top:20px;'>".$mes." ".$dia2.", ".$ano."</div><br>";
        $html .= "<div style='width:800px; text-align:left;font-weight: 600;font-size: 15px;'><b>".$est.$row_mail['nombre_cliente'].":</b></div>";
        if($atencion=='Yes'){
			$html.="<div style='width:800px; text-align:left;font-size: 15px;'>Attention: ".$at."</div>";
		}
        $html .= "<br><div style='width:800px; text-align:justify;font-size:14px;'>Thank you for contacting us for the quote of translation service as you request. 
        Provided below are the details of the quote and will indicate what the price of the service includes.</div><br>";
        $html .= "<div style='width:800px;'>".
        "<table style='width:100%; border-collapse:collapse;'>".
        "<tr style='color: #000 !important;'>
        <th style='width:50px;font-size:12px;'><b>Quantity</b></th>
        <th style='font-size:12px;text-align:center;width:70px;'><b>Unit</b></th>
        <th style='text-align:center;width:400px;font-size:12px;'><b>description</b></th> 
        <th style='font-size:12px;width:100px;'><b>Unit Price (".$symbol.")</b></th>
        <th style='font-size:12px;width:80px;'><b>Price (".$symbol.")</b></th>
        </tr>
        <tr style='color:#868686 !important;'>
        <td style='border-top: 3px solid #047ab7;text-align:center;background:#FFF;font-size:12px;'>".$row_mail['cantidad01']."</td>
        <td style='border-top: 3px solid #047ab7;text-align:center;background:#FFF;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad."</td>
        <td style='border-top: 3px solid #047ab7;font-size:12px;'>".$row_mail['detalles01']." ".$row_mail['desc01']." ".$row_mail['idiomas01']." ".$dest."</td> 
        <td style='border-top: 3px solid #047ab7;text-align:center;font-size:12px;'>".$row_mail['precio_unitario01']."</td>
        <td style='border-top: 3px solid #047ab7;text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$row_mail['importe01']."</td>
        </tr>";

        if($cantidad!=''){  

            if($cantidad2!=''){
                $html .= "<tr style='color:#868686 !important;height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad2."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;height:20px;font-size:12px;'>".$tipo_unidad2."</td>
                <td style='font-size:12px;'>".$detalles2." ".$desc2." ".$idiomas2." ".$dest2."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario2."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe2."</td>
                </tr>";
            }

            if($cantidad3!=''){
                $html.="<tr style='color:#868686 !important;height:20px;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad3."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad3."</td>
                <td style='height:20px;font-size:12px;'>".$detalles3." ".$desc3." ".$idiomas3." ".$dest3."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario3."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe3."</td>
                </tr>";
            }

            if($cantidad4!=''){
                $html.="<tr style='color:#868686 !important;height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad4."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad4."</td>
                <td style='height:20px;font-size:12px;'>".$detalles4." ".$desc4." ".$idiomas4." ".$dest4."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario4."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe4."</td>
                </tr>";
            }

            if($cantidad5!=''){
                $html.="<tr style='color:#868686 !important;height:20px;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad5."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad5."</td>
                <td style='height:20px;font-size:12px;'>".$detalles5." ".$desc5." ".$idiomas5." ".$dest5."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario5."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe5."</td>
                </tr>";
            }

            if($cantidad6!=''){
                $html.="<tr style='color:#868686;height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad6."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad6."</td>
                <td style='height:20px;font-size:12px;'>".$detalles6." ".$desc6." ".$idiomas6." ".$dest6."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario6."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe6."</td>
                </tr>";
            }


             if($cantidad7!=''){
                $html.="<tr style='color:#868686;height:20px;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad7."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad7."</td>
                <td style='height:20px;font-size:12px;'>".$detalles7." ".$desc7." ".$idiomas7." ".$dest7."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario7."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe7."</td>
                </tr>";
            }

            if($cantidad8!=''){
                $html.="<tr style='color:#868686;height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad8."</td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad8."</td>
                <td style='font-size:12px;'>".$detalles8." ".$desc8." ".$idiomas8." ".$dest8."</td> 
                <td style='text-align:center;font-size:12px;'>".$precio_unitario8."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe8."</td>
                </tr>";
            }

            if($discount=='Si'){
                $html.="<tr style='color:#868686 !important;'>
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:center;background:#EDEDED;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='font-size:12px;background:#EDEDED;'>Descuento por promoción ";

                if($cpr=='TRUSTPILOT'){
                    $html.="- Código ".$ctrust;
                }

                if($cpr=='GOOGLE'){
                    $html.="- Código ".$cgoogle;
                }

                $html.="</td> 
                <td style='text-align:center;font-size:12px;background:#EDEDED;'>-".$dmonto."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;background:#EDEDED;'>-".$dmonto."</td>
                </tr>";
            }

            if($cantidad2=='' && $cantidad3=='' && $cantidad4=='' && $cantidad5=='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
                $html.="<tr style='height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>
                <tr style='height:20px;background:#FFF;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>
                <tr style='height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>";
            }

            if($cantidad!='' && $cantidad2!='' && $cantidad3=='' && $cantidad4=='' && $cantidad5=='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
                $html.="<tr style='height:20px;background:#FFF;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>
                <tr style='height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>";
            }

            if($cantidad!='' && $cantidad2!='' && $cantidad3!='' && $cantidad4=='' && $cantidad5=='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
                $html.="<tr style='height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>";
            }

             if($cantidad!='' && $cantidad2!='' && $cantidad3!='' && $cantidad6=='' && $cantidad7=='' && $cantidad8==''){
                $html.="<tr style='height:20px;background:#EDEDED;'>
                <td style='text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='height:20px;font-size:12px;'></td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
                </tr>";
            }
        }
        
        $html .="<tr>
        <td style='background:#FFF;'></td>
        <td rowspan='3' colspan='2' style='border-left: 3px solid #047ab7;border-bottom:3px solid #047ab7;vertical-align:top;font-size:12px;'>
        <b>Notas: </b>".$valores."<br>".$detalle_entrega."
        </td>
        <td style='text-align:right;font-size:12px;'><b>Subtotal:</b></td>
        <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$symbol." ".number_format($row_mail['subtotal'],2,'.',',')."</td>
        </tr>".
        "<tr>
        <td style='background:#FFF;'></td>
        <td style='text-align:right;font-size:12px;'><b>Sales Tax 18%:</b></td>
        <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$symbol." ".number_format($row_mail['igv'],2,'.',',')."</td>
        </tr>".
        "<tr style='background: #047ab7;color: #FFF;'>
        <td style='background:#FFF;'></td>
        <td style='text-align:right;color:#FFF;border-bottom:3px solid #047ab7;'><b>Total:</b></td>
        <td style='text-align:right;color:#FFF;border-right: 3px solid #047ab7;border-bottom:3px solid #047ab7;'>".$symbol." ".number_format($row_mail['total'],2,'.',',')."</td>
        </tr>".

        "</table></div>";

        /*$html .= "<br><table style='width:100%; border-collapse:collapse;'><tr><td style='width:70px;'><b>Notas: </b></td><td>".$detalle_entrega."</td></tr></table>";*/
        $html .= "<br><div style='width:800px;'><b>Additional Details: </b></div>";
        $html .= "<table style='width:100%; border-collapse:collapse;'>
        

        <tr>
        <td style='text-align:right; font-weight:500; width:45%;border-top:3px solid #72c3a9;font-size:13px;'>Delivery Time</td>
        <td style='text-align:center; background:#72c3a9;border-top:3px solid #72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$fecha_entrega.$fecha_entrega2."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Payment Method</td>
        <td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$metodo_pago."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Delivery Format</td>
        <td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$formato_entrega."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Quote valid for</td>
        <td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$validez_oferta."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Delivery</td>
        <td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$tipo_entrega."</td>
        </tr>

        </table>";

        $html .="<h4 style='font-size:12px;'>Pay with credit or debit card via <a style='text-decoration:none; color:#047AB7' href='".$url_pay."' target='_blank'>".$url_pay."</a></h4>";
        $html .="<table style='width:100%;border-collapse:collapse;'>
                <tr style='text-align:center;'>
                <td style='text-align:center;'><a href='".$url_pay."' target='_blank'><img src='https://www.limac.com.pe/login-admin/images/logos.jpg'></a></td></tr></table>";


        //if($tipocot=='LANGUAGEHIVE'){

            /*$html .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@languagehive.com'>ventas@languagehive.com</a></h4>
                <table style='width:100%;border-collapse:collapse;'>
            <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
            </tr>
            <tr style='font-size: 11px;text-align: center;'>
                <td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
                <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
                <td style='font-size: 11px;text-align: center;'>Current</td>
                <td style='font-size: 11px;text-align: center;'>192-2145311-1-17</td>
                <td style='font-size: 11px;text-align: center;'>002-192-002145311117-37</td>
                <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
            </tr>
            <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
                <td><img src='http://www.limac.com.pe/assets/images/bcp-logo.png' width='65'></td>
                <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
                <td style='font-size: 11px;text-align: center;'>Current</td>
                <td style='font-size: 11px;text-align: center;'>192-2172045-0-47</td>
                <td style='font-size: 11px;text-align: center;'>002-192-002172045047-33</td>
                <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
            </tr>
            </table>
            <div style='font-size:9px;color:#000'>SWIFT: BCPLPEPL | MAIN ADDRESS: CALLE CENTENARIO NRO. 156 URB. LAS LADERAS DE MELGAREJO LA MOLINA, LIMA 12, PERÚ<br><br></div>";*/

            if($firma=="RYE"){

            	$html .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
                <table style='width:100%;border-collapse:collapse;'>
                <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
                </tr>

                <tr style='font-size: 11px;text-align: center;'>
                    <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
                    <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
                    <td style='font-size: 11px;text-align: center;'>Current</td>
                    <td style='font-size: 11px;text-align: center;'>0913001566466</td>
                    <td style='font-size: 11px;text-align: center;'>003-091-003001566466-64</td>
                    <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
                </tr>

                <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
                    <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
                    <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
                    <td style='font-size: 11px;text-align: center;'>Current</td>
                    <td style='font-size: 11px;text-align: center;'>0913001566459</td>
                    <td style='font-size: 11px;text-align: center;'>003-091-003001566459-69</td>
                    <td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
                </tr>
            </table>";

			} else if($firma=="LIMACDELPERU"){

				$html .="<h4 style='font-size:11.5px;'>Make also your payment by bank deposit or transfer and send the proof of payment to <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
                <table style='width:100%;border-collapse:collapse;'>
                <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Bank</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Currency</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Account Type</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Account Number</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Interbank Account Code (IAC)</td>
                    <td style='color:#FFF;text-align:center;font-size:11px;'>Owner</td>
                </tr>

                <tr style='font-size: 11px;text-align: center;'>
                    <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
                    <td style='font-size: 11px;text-align: center;'>USA Dollars(USD)</td>
                    <td style='font-size: 11px;text-align: center;'>Current</td>
                    <td style='font-size: 11px;text-align: center;'>200-3001567362</td>
                    <td style='font-size: 11px;text-align: center;'>003-200-003001567362-34</td>
                    <td style='font-size: 11px;text-align: center;'>LIMAC DEL PERÚ E.I.R.L.</td>
                </tr>

                <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
                    <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
                    <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
                    <td style='font-size: 11px;text-align: center;'>Current</td>
                    <td style='font-size: 11px;text-align: center;'>200-3001567347</td>
                    <td style='font-size: 11px;text-align: center;'>003-200-003001567347-35</td>
                    <td style='font-size: 11px;text-align: center;'>LIMAC DEL PERÚ E.I.R.L.</td>
                </tr>
            </table>";

			}

		$html .= "<div style='width:800px;font-size:13px;'>".
            "<p>Sincerely Yours,<br>
            Sales Department.</p>";
        $html.= "<div style='width:140px;display:inline-block;'><img src='https://www.limac.com.pe/assets/images/logos/logo_color2.jpg' width='120'></div>";
        $html.="</div>";


       	$mpdf = new mPDF('', // mode - default ''
            'A4', // format - A4, for example, default ''
            '', // font size - default 0
            '', // default font family
            14, //margin-left
            14, //margin-right
            6, //margin-top
            '', // margin-bottom
            '', //margin-header
            2); //margin-footer
                //L-landscape; P-portrait

		

		/*$footer = "<div style='width:800px; font-size:10px; color:#aaa;'>".
        "IMPORTANTE/CONFIDENCIAL<br>
        Este documento contiene información personal, confidencial que van dirigidos única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundido. 
        Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. 
        Si usted recibió este documento por error, sírvase informarlo al remitente y deshacerse del documento inmediatamente. Esta cotización ha sido emitida a las ". strftime("%H:%M %p") ."</div><br>";*/

        $footer = "<div style='width:800px; font-size:9px; color:#aaa;'>".
		"IMPORTANT/ CONFIDENTIAL<br>
        This document contains personal and confidential information that are directed only and exclusively to its recipient and, in accordance with the law, 
        it may not be spread. It is completely forbidden to make partial or total copies, as well as to spread content to others that are not the recipient. 
        If you received this document for error, please inform to the sender and dispose of the document immediately. This quote has been issued at ". strftime("%H:%M %p") ."</div>";

        if($firma=="RYE"){
        	$footer .= "<div style='width:800px; text-align:center;font-size:12px;'>
	        R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>Avenida El Derby 055, Torre 1 - Piso 7, Santiago de Surco, Lima.<br>Telephone number: (01) 700 9040 * E-mail: ".$usfrom."<br>
	        </div><br>";

        } else if($firma=="LIMACDELPERU"){
        	$footer .= "<div style='width:800px; text-align:center;font-size:12px;'>
	        LIMAC DEL PERÚ E.I.R.L. - R.U.C. 20603296410<br>Avenida El Derby 055, Torre 1 - Piso 7, Santiago de Surco, Lima.<br>Telephone number: (01) 700 9040 * E-mail: ".$usfrom."<br>
	        </div><br>";
        }

		$mpdf -> writeHTML($html);

		$mpdf ->SetHTMLFooter($footer);
		$attach = $mpdf -> Output('reporte.pdf','S');
		$filename = "COTIZACION - TRADUCCION - " . $row_mail['codigo_cotizacion'] . ".pdf";
		$encoding = "base64";
		$type ="application/octet-stream";

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

	      if($tipocot=='LANGUAGEHIVE'){

            $mail->Username = "admin@languagehive.com";
            $mail->Password = "ftmpedyvabtsedoe";
            $mail->From = "ventas@languagehive.com";

            $mail->FromName = "LANGUAGEHIVE";

          } else {

            $mail->Username = $usrname;
            $mail->Password = $psword;
            $mail->From = $usfrom;

            $mail->FromName = "LIMAC";

          }
	    
	      $mail->Subject = $asunto;
	    
	      //$mail->addAddress($correo);

	      $addr = explode(',',$correo);

			foreach ($addr as $ad) {
			    $mail->AddAddress( trim($ad) );       
			}

	      $mail->IsHTML(true);
	      
	    
	      $mail->MsgHTML($mensaje);

	      $mail->AddStringAttachment($attach,$filename,$encoding,$type);

	      

	      if($lady_files=='Si'){
	      	$mail->addAttachment('../../../translator_files/CV Lady Principe - LIMAC.pdf');
	      	$mail->addAttachment('../../../translator_files/ACREDITACION COLEGIATURA LADY PRINCIPE - LIMAC.pdf');
	      }

	      /*if($nathaly_files=='Si'){
	      	$mail->addAttachment('../translator_files/CV Nathaly Vasquez - LIMAC-1.pdf');
	      	$mail->addAttachment('../translator_files/CONSTANCIA COLEGIATURA NATHALY VASQUEZ - LIMAC.pdf');
	      }*/

	      if($ruc_file=='Si'){
	      	$mail->addAttachment('../../../translator_files/FICHA RUC - LIMAC.pdf');
	      }

	      if($rnp_file=='Si'){
	      	$mail->addAttachment('../../../translator_files/RNP R&E TRADUCCIONES SAC.pdf');
	  	  }

	      //$mail->addAttachment();
	      //if ($adjunto ["size"] > 0)
			//{           
			//	$mail->addAttachment($adjunto ["tmp_name"], $adjunto ["name"]);
			//}

		if($mail->Send())
		{
		//$msg= "En hora buena el mensaje ha sido enviado con exito a $email";
		//header( "Location: http://www.limac.com.pe/gracias/" );
		/*echo'
		<div id="alerta2" class="alert alert-success fade in" role="alert">
  		<i class="fa fa-check" aria-hidden="true"></i> Le hemos enviado un correo de notificación.
		</div>';*/
		echo '<div class="container text-center">
		<div id="alerta2" class="alert alert-success fade in" role="alert">
  		<i class="fa fa-check" aria-hidden="true"></i> Quote has sent.
		</div>
		<a href=../cotizacion_traduccion_en.php><button class="btn btn-primary">RETURN</button></a>
		</div>';
		}else{
		//echo "Lo siento, ha habido un error al enviar el mensaje a $correo_usuario";
		echo '<div class="container text-center">
	  	<div id="alerta" class="alert alert-danger fade in" role="alert">
		<i class="fa fa-exclamation" aria-hidden="true"></i> Error.</div>
		<a href=../cotizacion_traduccion_en.php><button class="btn btn-primary">RETURN</button></a>
		</div>';
		}

?>

		</div>
	</div>
</div>
</body>
</html>