<?php
	$connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
	include("../../../limac_conexion/conexion.php");
	date_default_timezone_set('America/Lima');
	setlocale(LC_ALL, 'es_PE');
	//$user_login=$_SESSION["admin"];	
	include ('../../../variables.php');		
?>

<?php
		date_default_timezone_set('America/Lima');
		setlocale(LC_ALL, 'es_PE');
		$datee = date('Y-m-d H:i:s');
		$creacion = date("Y-m-d H:i:s");

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

		$code_fecha = date('dmY');

		$fecha_entrega2 = date('d/m');
		$fech_entrega=$_POST['fecha_entrega'];
		$fecha_entrega=date('d/m',strtotime($fech_entrega) );
		$fecha_entregav1 = date('d-m-y',strtotime($fech_entrega) );
		if (date("A", strtotime('+1 hours')) == 'AM'){
			$hora = '12:00';
		}elseif(date("A", strtotime('+8 hours')) == 'AM'){
			$fecha_entrega2 = date('d/m',strtotime('+1 days'));
			$hora = '12:00';
		}
		elseif(date("A", strtotime('+1 hours')) == 'PM'){
			$hora = '17:00';
		}

		$hora1=date('h:i A',strtotime($fech_entrega) );

		$hora2 = date('h:i A',strtotime($hora));

		//DATOS
		$elid = $_POST['elid'];
		$ttipo = $_POST['ttipo'];

		$nombre_cliente=$_POST['nombre'];
		$correo=$_POST['correo'];
		$tipo_unidad=$_POST['tipo_unidad'];
		$tipocot = $_POST['firma'];

		$sexo=$_POST['sexo'];

		if($sexo=='Masculino'){
			$est = 'Estimado Sr. ';
		}

		if($sexo=='Femenino'){
			$est='Estimada Srta. ';
		}

		$eemail = "ventas@limac.com.pe";
		$url_pay = "https://www.limac.com.pe/pagos/";

		$empresa=$_POST['empresa'];
		$atencion=$_POST['atencion'];
		$at=$_POST['at'];
		$url = $_POST['url'];
		$filename = $_POST['filename'];
		$enc = "base64";
        $ty ="application/octet-stream";


		if($empresa=='Si'){
			$est='Estimados Sres. ';
		}

		$moneda=$_POST['moneda'];	

		$tipo_pago=$_POST['tipo_pago'];

		$desc=$_POST['descripcion'];
		$idiomas=$_POST['idiomas'];
		$cantidad=$_POST['cantidad'];
		// agregamos paginas
		$paginas=$_POST['paginas'];
		$precio_unitario=$_POST['precio_unitario'];
		$detalles=$_POST['detalles'];
		$importe=$_POST['importe'];
		$dest=$_POST['dest'];
		$desc_mv = $_POST['desc_mv'];

		$discount = $_POST['descuento'];
		$codigo = $_POST['codigo'];
		$codigo_google = $_POST['codgoogle'];
		$codigo_trust = $_POST['codtrust'];
		$dmonto = $_POST['dmonto'];

		$urgencia = $_POST['urgencia'];
		$montourg = $_POST['montourg'];

		$subtotal=$_POST['subtotal'];
		$igv=$_POST['igv'];
		$total=$_POST['total'];

		$metodo_pago=$_POST['metodo_pago'];
		$formato_entrega=$_POST['formato_entrega'];
		$validez_oferta=$_POST['validez_oferta'];
		$tipo_entrega=$_POST['forma_entrega'];
		$detalle_entrega=$_POST['detalle_entrega'];
		$ctfiles=$_POST['ctfiles'];

		$idCot = $_POST['idcot'];

		// if($moneda=='soles'){
		// 	$symbol='S/';
		// 	$valores = "Valores expresados en nuevos soles (S/ ).";
		// 	$total_soles = $total;
		// }

		if($moneda=='soles'){
			$symbol='$';
			$valores = "Valores expresados en dólares americanos ($).";
			$total_soles = $total * 3;
		}

		if($moneda=='dolares'){
			$symbol='$';
			$valores = "Valores expresados en dólares americanos ($).";
			$total_soles = $total * 3;
		}

		$lady_files=$_POST['lady_files'];
		$ruc_file=$_POST['ruc_file'];
		$rnp_file=$_POST['rnp_file'];


		/*$sql="INSERT INTO cotizacion_limac (date_code,nombre_cliente,correo_cliente,sexo,empresa,atencion,at,dscto,monto_dscto,urgencia,monto_urgencia,subtotal,igv,total,fecha_entrega,metodo_pago,formato_entrega,validez_oferta,tipo_entrega,detalle_entrega,
			link_payu,created,moneda,archivos_cliente,total_soles) values ";
		$sql.="('$code_fecha','$nombre_cliente','$correo','$sexo','$empresa','$atencion','$at','$discount','$dmonto','$urgencia','$montourg','$subtotal','$igv','$total','$fecha_entrega $fecha_entrega2','".implode(', ',$metodo_pago)."','".implode(', ',$formato_entrega)."','$validez_oferta','".implode(', ',$tipo_entrega)."','$detalle_entrega',
			'$payu','$creacion','$moneda','$ctfiles','$total_soles')";*/
		$mpago = implode(', ',$metodo_pago);
		$fentrega = implode(', ',$formato_entrega);
		$tentrega = implode(', ',$tipo_entrega);

		$referencial = $_POST['referencial'];
		$referencial = strtoupper($referencial);
		$est2=" - ";
		if($referencial == ""){
			$est2=" ";
		}else
			$referencial=$est2.$referencial;

		$con33 = "SELECT * FROM cotizacion_limac where concat(id_cotizacion,date_code)='$idCot'";
		$sql33 = mysql_query($con33);
		$reg33 = mysql_fetch_array($sql33);
		$status = $reg33['status'];

		if($idCot=="" || $status!="GUARDADO"){
			$insert_fecha = $fecha_entregav1 . ' ' . $hora1;

			$sql="INSERT INTO cotizacion_limac (date_code,nombre_cliente,reclamante,correo_cliente,tipoCot,sexo,empresa,atencion,at,dscto,monto_dscto,urgencia,monto_urgencia,subtotal,igv,total,fecha_entrega,metodo_pago,formato_entrega,validez_oferta,tipo_entrega,detalle_entrega,link_payu,created,moneda,archivos_cliente,total_soles,emisor) values ('$code_fecha','$nombre_cliente','$referencial','$correo','1','$sexo','$empresa','$atencion','$at','$discount','$dmonto','$urgencia','$montourg','$subtotal','$igv','$total','$insert_fecha','$mpago','$fentrega','$validez_oferta','$tentrega','$detalle_entrega','$payu','$creacion','$moneda','$ctfiles','$total_soles','$tipocot')";
			$result=mysql_query($sql);

			//Recuperamos el ultimo id insertado para generar el codigo de la cotizacion en el Historial
			$sql_idv1 = "SELECT MAX(id_cotizacion) AS ultimoID FROM cotizacion_limac";
			$result_idv1 = mysqli_query($connect, $sql_idv1);
			$row_idv1 = mysqli_fetch_array($result_idv1);
			$ultimoIdInsertado = $row_idv1['ultimoID'];
			//$ultimoIdInsertado = mysqli_insert_id($connect);

			$usdr = explode(',',$correo);
			foreach ($usdr as $olp) {

			$sqlu = "SELECT * from usuarios_limac where usuario='$olp'";
			$resu = mysql_query($sqlu);

				if(mysql_num_rows($resu)>0){

				} else {
					$eluser = "INSERT INTO usuarios_limac (nom_apellidos,sexo,email,usuario,pass,created) values('$nombre_cliente','$sx','$olp','$olp','0000','$datee')";
					$reseluser = mysql_query($eluser);		    	
				}
			}

			//Enviar email de cotización
			
			$sql_mail="Select concat(id_cotizacion,date_code) codigo_cotizacion,nombre_cliente,correo_cliente,
			desc01,idiomas01,cantidad01,precio_unitario01,detalles01,importe01,subtotal,igv,total 
			from cotizacion_limac where correo_cliente='$correo' ORDER BY id_cotizacion DESC LIMIT 1";
			$result_mail=mysql_query($sql_mail);
			$row_mail=mysql_fetch_array($result_mail);
			$idtradd = $row_mail['codigo_cotizacion'];

			foreach($desc as $llave => $b) {
				$rr = "INSERT INTO cotizacion_limac_reg(id_cotizacion,descripcion,idiomas,tipo_unidad,detalle,cantidad,paginas,precio_unitario,importe,dscto_mayor,destino) values('$idtradd','$b','$idiomas[$llave]','$tipo_unidad[$llave]','$detalles[$llave]','$cantidad[$llave]','$paginas[$llave]','$precio_unitario[$llave]','$importe[$llave]','$desc_mv[$llave]','$dest[$llave]')";
				$ss = mysql_query($rr);
			}

		} else if($idCot!="" && $status=="GUARDADO"){
			$conn = "SELECT * FROM cotizacion_limac where concat(id_cotizacion,date_code)='$idCot' and status='GUARDADO'";
			$sqll = mysql_query($conn);

			if(mysql_num_rows($sqll)>0){
				$insert_fecha = $fecha_entregav1 . ' ' . $hora1;

				$sqlh = "UPDATE cotizacion_limac set nombre_cliente='$nombre_cliente',reclamante = '$referencial',correo_cliente = '$correo',sexo = '$sexo',empresa = '$empresa',atencion = '$atencion',";
				$sqlh .= "at = '$at',dscto = '$discount',";
				$sqlh .= "monto_dscto = '$dmonto',subtotal = '$subtotal',igv ='$igv',total = '$total',moneda = '$moneda',fecha_entrega = '$insert_fecha',";
				$sqlh .= "metodo_pago = '$mpago',formato_entrega = '$fentrega',validez_oferta = '$validez_oferta',tipo_entrega = '$tentrega',";
				$sqlh .= "detalle_entrega = '$detalle_entrega',codepromo = '$codigop', status='PENDIENTE DE PAGO', emisor='$tipocot', created='$creacion' where concat(id_cotizacion,date_code)='$idCot'";
				
				$resulth = mysql_query($sqlh);
				//$numCot = $idCot;

				$del = "DELETE FROM cotizacion_limac_reg WHERE id_cotizacion='$idCot'";
				$resdel = mysql_query($del);

				foreach($desc as $llave => $b) {
					$rr = "INSERT INTO cotizacion_limac_reg(id_cotizacion,descripcion,idiomas,tipo_unidad,detalle,cantidad,paginas,precio_unitario,importe,dscto_mayor,destino) values('$idCot','$b','$idiomas[$llave]','$tipo_unidad[$llave]','$detalles[$llave]','$cantidad[$llave]','$paginas[$llave]','$precio_unitario[$llave]','$importe[$llave]','$desc_mv[$llave]','$dest[$llave]')";
					$ss = mysql_query($rr);
				}
			}
			$idtradd = $idCot;
		}


		$SQLPS = "SELECT * FROM limac_pass where estado='ACTIVO'";
		$RQLPS = mysqli_query($connect,$SQLPS);
		$GQLPS = mysqli_fetch_array($RQLPS,MYSQLI_ASSOC);
		$usrname = $GQLPS['username'];
		$psword = $GQLPS['password'];
		$usfrom = $GQLPS['from'];

		$asunto ="【COTIZACIÓN N° ".$idtradd.$referencial."】";

		
		
		$length = 10;
		$randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

		$mensaje = "
					<html>
					<head>
						<style type='text/css'>
							body {
								font-family: maven_pro !important;
							}
							.abc {
								width:800px;
								display:inline-block;
								margin-top:35px;
								margin-bottom:35px;
								font-size:14px;
								font-family:Maven Pro,sans-serif;
								border:1px solid #ccc;
								background:#FFF;
								padding-left: 40px;
								padding-right: 40px;
								padding-top: 30px;
							}
						</style>
					</head>
					<body>
						<div class='container' style='width:900px;'>
							<div style='width:50px; text-align:center; display: inline-block; margin: 0;'></div>
							<div class='abc'>
								<div style='width:140px;display:inline-block;'>
									<img src='https://www.limac.com.pe/assets/images/limac_gradient.jpg' width='120'>
								</div>
								<div style='width:250px;display:inline-block;text-align:center;float:right;'>";

								if($tipocot=='RYE'){
									$mensaje .= "R&E TRADUCCIONES S. A. C.<br>R. U. C. 20551971300<br>";
								} else {
									$mensaje .= "LIMAC DEL PERÚ E.I.R.L.<br>R. U. C. 20603296410<br>";
								}

		$mensaje .="
									COTIZACIÓN N° $idtradd
								</div><br>
								<div style='width:800px; text-align:right; margin-top:40px;'>
									Lima, $dia2 de $mes del $ano</div><br>
								<div style='width:800px; text-align:left;font-weight: 600;font-size: 16px;'>$est $nombre_cliente:</div>";

									if($atencion=='Si'){
										$mensaje.="<div style='width:800px; text-align:left;font-size: 16px;'>Atención: ".$at."</div>";
									}

		$mensaje.="
								<img border='0' src='https://www.limac.com.pe/mail/tracking.php?id=".$randomletter."&to=".$correo."&numproy=".$idtradd."' style='display:none;' />
								<br>
								<div style='width:800px; text-align:justify;'>
									Gracias por comunicarse con nosotros para la cotización de su traducción, a continuación le presentamos los detalles de la cotización y le indicaremos qué incluye el precio de su proyecto.
								</div>
								<br><br>
								<div style='width:800px;'>
									<table style='width:100%; border-collapse:collapse;'>
										<tr style='border-bottom: 3px solid #047ab7;color: #000;'>
											<th><b>Cantidad</b></th>
											<th align='center' style='width:80px;'><b>Unidad</b></th>
											<th style='text-align:center;width:430px;'><b>Descripción</b></th> 
											<th><b>V. Unitario ($symbol)</b></th>
											<th><b>Importe ($symbol)</b></th>
										</tr>";

		$cc = 0;

		foreach( $desc as $keyy => $ub ) {

			if($desc_mv[$keyy]=='' || $desc_mv[$keyy]<1){
				$mensaje.="<tr style='color:#868686 !important;";

				if($cc++%2==1){$mensaje.="height:20px;background:#EDEDED;'"; }else{$mensaje.="height:20px;'";}

				$mensaje.=">
				<td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad[$keyy]."</td>
				<td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad[$keyy]."</td>
				<td style='font-size:12px;'>".$detalles[$keyy]." ".$ub." ".$idiomas[$keyy]." ".$dest[$keyy]." Cantidad de paginas: ".$paginas[$keyy]."</td> 
				<td style='text-align:center;font-size:12px;'>".$precio_unitario[$keyy]."</td>
				<td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe[$keyy]."</td>
				</tr>";

			} else {

	  			$imp[$keyy] = $cantidad[$keyy] * $precio_unitario[$keyy]; //1*118
	  			$pr_unitd[$keyy] = $precio_unitario[$keyy] * ($desc_mv[$keyy]/100);//118 * 0.05 = 5.9
	  			$impd[$keyy] = $cantidad[$keyy] * $pr_unitd[$keyy]; //1*5.9

				$mensaje.="<tr style='color:#868686 !important;";

				if($cc++%2==1){$mensaje.="height:20px;background:#EDEDED;'"; }else{$mensaje.="height:20px;'";}

				$mensaje.=">
				<td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad[$keyy]."</td>
				<td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad[$keyy]."</td>
				<td style='font-size:12px;'>".$detalles[$keyy]." ".$ub." ".$idiomas[$keyy]." ".$dest[$keyy]." Cantidad de paginas: ".$paginas[$keyy]."</td>
				<td style='text-align:center;font-size:12px;'>".$precio_unitario[$keyy]."</td>
				<td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".number_format($imp[$keyy],2,'.',',')."</td>
				</tr>";

				$mensaje.="<tr style='color:#868686 !important;";

				if($cc++%2==1){
					$mensaje.="height:20px;background:#EDEDED;'"; 
				}else{
					$mensaje.="height:20px;'";
				}

				$mensaje.=">
				<td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad[$keyy]."</td>
				<td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad[$keyy]."</td>
				<td style='font-size:12px;'>Descuento ".$desc_mv[$keyy]."%</td> 
				<td style='text-align:center;font-size:12px;'>-".number_format($pr_unitd[$keyy],2,'.',',')."</td>
				<td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>-".number_format($impd[$keyy],2,'.',',')."</td>
				</tr>";

			}
		}	  	

		if($discount=='Si'){
            $mensaje.="<tr style='color:#868686 !important;'>
            <td style='text-align:center;font-size:12px;'></td>
            <td style='text-align:center;background:#EDEDED;border-left: 3px solid #047ab7;font-size:12px;'></td>
            <td style='font-size:12px;background:#EDEDED;'>Descuento por promoción ";

            if($codigo=='TRUSTPILOT'){
                $mensaje.="- Código ".$codigo_trust;
            }

            if($codigo=='GOOGLE'){
                $mensaje.="- Código ".$codigo_google;
            }

            $mensaje.="</td> 
            <td style='text-align:center;font-size:12px;background:#EDEDED;'>-".$dmonto."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;background:#EDEDED;'>-".$dmonto."</td>
            </tr>";
        }

        if($urgencia=='Si'){
            $mensaje.="<tr style='color:#868686 !important;'>
            <td style='text-align:center;font-size:12px;'></td>
            <td style='text-align:center;background:#EDEDED;border-left: 3px solid #047ab7;font-size:12px;'></td>
            <td style='font-size:12px;background:#EDEDED;'>Monto por urgencia</td> 
            <td style='text-align:center;font-size:12px;background:#EDEDED;'>".$montourg."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;background:#EDEDED;'>".$montourg."</td>
            </tr>";
        }

        $mensaje.="
										<tr style='height:20px;background:#EDEDED;'>
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
										</tr>
										
										<tr>
											<td style='background:#FFF;'></td>
											<td rowspan='3' colspan='2' style='border-left: 3px solid #047ab7;border-bottom:3px solid #047ab7;vertical-align:top;'><b>Notas: </b>$valores<br>$detalle_entrega</td>
											<td style='text-align:right;'><b>Subtotal:</b></td>
											<td style='text-align:right;border-right: 3px solid #047ab7;'>".$symbol." ".number_format($row_mail['subtotal'],2,'.',',')."</td>
										</tr>
										<tr>
											<td style='background:#FFF;'></td>
											<td style='text-align:right;'><b>IGV 18%:</b></td>
											<td style='text-align:right;border-right: 3px solid #047ab7;'>".$symbol." ".number_format($row_mail['igv'],2,'.',',')."</td>
										</tr>
										<tr style='background: #047ab7;color: #FFF;'>
											<td style='background:#FFF;'></td>
											<td style='text-align:right;border-bottom:3px solid #047ab7;'><b>Total:</b></td>
											<td style='text-align:right;border-right: 3px solid #047ab7;border-bottom:3px solid #047ab7;'>".$symbol." ".number_format($row_mail['total'],2,'.',',')."</td>
										</tr>
									</table>
								</div>
								
								<br><br>
								<div style='width:800px;'>
									<b>Detalles Adicionales: </b>
								</div>
								
								<table style='width:100%; border-collapse:collapse;'>
									<tr>
										<td style='text-align:right; font-weight:500; width:45%;border-top:3px solid #72c3a9;'>Tiempo de Entrega</td>
										<td style='text-align:center; background:#72c3a9;border-top:3px solid #72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".$fecha_entrega." a las ".$hora1." con aprobación el<br>".$fecha_entrega2." antes de las ".$hora2."</td>
									</tr>

									<tr>
										<td style='text-align:right; font-weight:500;'>Método de pago</td>
										<td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".implode(', ',$metodo_pago)."</td>
									</tr>

									<tr>
										<td style='text-align:right; font-weight:500;'>Formato de Entrega</td>
										<td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".implode(', ',$formato_entrega)."</td>
									</tr>

									<tr>
										<td style='text-align:right; font-weight:500;'>Validez de oferta</td>
										<td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;'>".$validez_oferta."</td>
									</tr>

									<tr>
										<td style='text-align:right; font-weight:500;'>Tipo de Entrega</td>
										<td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;border-bottom:3px solid #72c3a9;'>".implode(', ',$tipo_entrega)."</td>
									</tr>
								</table>
								
								<h4 style='font-size:12px;'>
									Pague con su tarjeta crédito o débito ingresando a <a style='text-decoration:none; color:#0093df;' href='$url_pay' target='_blank'>$url_pay</a>
								</h4>
								<table style='width:100%;border-collapse:collapse;'>
									<tr style='text-align:center;'>
										<td style='text-align:center;'>
											<a href='$url_pay' target='_blank'>
												<img src='https://www.limac.com.pe/library/images/logos.jpg'>
											</a>
										</td>
									</tr>
								</table>";

								if($tipocot=='RYE'){

												/*$mensaje .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
													<table style='width:100%;border-collapse:collapse;'>
														<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
														</tr>

														<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
															<td><img src='http://www.limac.com.pe/assets/images/bcp-logo-gray.png' width='65'></td>
															<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
															<td style='font-size: 11px;text-align: center;'>Corriente</td>
															<td style='font-size: 11px;text-align: center;'>192-2172045-0-47</td>
															<td style='font-size: 11px;text-align: center;'>002-192-002172045047-33</td>
															<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
														</tr>

														<tr style='font-size: 11px;text-align: center;'>
															<td><img src='http://www.limac.com.pe/assets/images/bcp-logo-gray.png' width='65'></td>
															<td style='font-size: 11px;text-align: center;'>Dólar Estadounidense (USD)</td>
															<td style='font-size: 11px;text-align: center;'>Corriente</td>
															<td style='font-size: 11px;text-align: center;'>192-2145311-1-17</td>
															<td style='font-size: 11px;text-align: center;'>002-192-002145311117-37</td>
															<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
														</tr>

													</table>";*/

												$mensaje4 .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
													<table style='width:100%;border-collapse:collapse;'>
														<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
															<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
														</tr>

														<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
															<td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
															<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
															<td style='font-size: 11px;text-align: center;'>Corriente</td>
															<td style='font-size: 11px;text-align: center;'>0913001566459</td>
															<td style='font-size: 11px;text-align: center;'>003-091-003001566459-69</td>
															<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
														</tr>

														<tr style='font-size: 11px;text-align: center;'>
															<td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
															<td style='font-size: 11px;text-align: center;'>Dólar Estadounidense (USD)</td>
															<td style='font-size: 11px;text-align: center;'>Corriente</td>
															<td style='font-size: 11px;text-align: center;'>0913001566466</td>
															<td style='font-size: 11px;text-align: center;'>003-091-003001566466-64</td>
															<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
														</tr>

													</table>";

								} else {

												/*$mensaje .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
												<table style='width:100%;border-collapse:collapse;'>
													<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
														<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
														<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
														<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
														<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
														<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
														<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
													</tr>
													<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
														<td><img src='https://www.limac.com.pe/assets/images/bbva-continental.png' width='65'></td>
														<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
														<td style='font-size: 11px;text-align: center;'>Corriente</td>
														<td style='font-size: 11px;text-align: center;'>0011-0467-0100004771</td>
														<td style='font-size: 11px;text-align: center;width:180px;'>011-467-000100004771-80</td>
														<td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
													</tr>
												</table>";*/

												$mensaje4 .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
												<table style='width:100%;border-collapse:collapse;'>
												<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
													<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
													<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
													<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
													<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
													<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
													<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
												</tr>
												<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
													<td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
													<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
													<td style='font-size: 11px;text-align: center;'>Corriente</td>
													<td style='font-size: 11px;text-align: center;'>200-3001567347</td>
													<td style='font-size: 11px;text-align: center;width:180px;'>003-200-003001567347-35</td>
													<td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
												</tr>

												<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
													<td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
													<td style='font-size: 11px;text-align: center;'>Dólar Estadounidense (USD)</td>
													<td style='font-size: 11px;text-align: center;'>Corriente</td>
													<td style='font-size: 11px;text-align: center;'>200-3001567362</td>
													<td style='font-size: 11px;text-align: center;width:180px;'>003-200-003001567362-34</td>
													<td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
												</tr>
												</table>";

								}

		
		$mensaje .= "
								<br>
								<div style='width:800px;'>
									<p>Cordialmente,</p>
									<p>Departamento de Ventas.</p>
									<img src='https://www.limac.com.pe/assets/images/limac_gradient.jpg' width='120'><br>
								</div>
								
								<div style='width:800px; font-size:10px; color:#aaa;'>
									IMPORTANTE/CONFIDENCIAL<br>
									Este documento contiene información personal y confidencial que va dirigida única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundida. Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. Si usted recibió este mensaje por error, sírvase informarlo al remitente y deshacerse de cualquier documento inmediatamente.
								</div>
								<br>
								
								<div style='width:800px; text-align:center;'>";

									if($tipocot=='RYE'){
										$mensaje.="R&E TRADUCCIONES S.A.C.<br>";
									} else {
										$mensaje.="LIMAC DEL PERÚ E.I.R.L.<br>";
									}

									// OBTENER EL NUMERO DE CELULAR DESDE LA BASE DE DATOS
									$xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
									$rxcv = mysqli_query($connect,$xcv);
									$gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
									$numeroBD = $gxcv['numero'];

		$mensaje.= "
									$direccion, Lima.<br> Teléfono: $numeroBD * Correo Electrónico: $eemail<br>
								</div>
								<br><br>
								<div style='width:50px; text-align:center; display: inline-block; margin: 0;'></div>
							</body>
						</html>";

		require "../../../PHPMailer/PHPMailerAutoload.php";
		require "../../../MPDF57/mpdf.php";


		///////////////////

		$html = "<html><head><style type='text/css'>
        body {font-family: maven_pro !important;}
        </style></head><body><div class='container' style='width:900px;'>";
        //$html .= "<div style='width:50px; text-align:center; display: inline-block; margin: 0;'></div>";
        $html .= "<div style='width:900px;display:inline-block;margin-top:0px;margin-bottom:35px;font-family:Maven Pro;font-size:14px;background:#FFF;padding-left: 0px;
        padding-right: 0px;padding-top: 0px;'>";

		$html .= "<div style='width:260px;display:inline-block;'><img src='https://www.limac.com.pe/assets/images/limac_gradient.jpg' width='120'></div>";

        $html .= "<div style='width:218px;display:inline-block;text-align:center;float:right;margin-top:-50px;'>";

        if($tipocot=='RYE'){
			$html .= "R&E TRADUCCIONES S. A. C.<br>R. U. C. 20551971300<br>";
		} else {
			$html .= "LIMAC DEL PERÚ E.I.R.L.<br>R. U. C. 20603296410<br>";
		}

        $html.="COTIZACIÓN N° ".$idtradd."</div><br>";
        $html .= "<div style='width:800px; text-align:right; margin-top:30px;'>Lima, ".$dia2." de ".$mes." del ".$ano."</div><br>";
        $html .= "<div style='width:800px; text-align:left;font-weight: 600;font-size: 16px;'><b>".$est."InSpectre Solutions, Inc.:</b></div>";
        if($atencion=='Si'){
			$html.="<div style='width:800px; text-align:left;font-size: 14px;'>Atención: ".$at."</div>";
		}
        $html .= "<br><div style='width:800px; text-align:justify;font-size:13px;'>Gracias por comunicarse con nosotros para la cotización de su traducción, 
        a continuación le presentamos los detalles de la cotización y le indicaremos qué incluye el precio de su proyecto.</div><br>";
        $html .= "<div style='width:800px;'>".
        "<table style='width:100%; border-collapse:collapse;'>".
        "<tr style='color: #000 !important;border-bottom: 3px solid #047ab7;'>
        <th style='width:50px;font-size:12px;border-bottom: 3px solid #047ab7;'><b>Cantidad</b></th>
        <th style='font-size:12px;text-align:center;width:60px;border-bottom: 3px solid #047ab7;'><b>Unidad</b></th>
        <th style='text-align:center;width:390px;font-size:12px;border-bottom: 3px solid #047ab7;'><b>Descripción</b></th> 
        <th style='font-size:12px;border-bottom: 3px solid #047ab7;'><b>V. Unitario (".$symbol.")</b></th>
        <th style='font-size:12px;border-bottom: 3px solid #047ab7;'><b>Importe (".$symbol.")</b></th>
        </tr>";


        $c = 0;

		foreach( $desc as $key => $u ) {

			if($desc_mv[$key]=='' || $desc_mv[$key]<1){
				$html.="<tr style='color:#868686;";

				if($c++%2==1){$html.="!important;height:20px;background:#EDEDED;'"; }else{$html.="!important;height:20px;'";}

				$html.=">
				<td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad[$key]."</td>
				<td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad[$key]."</td>
				<td style='font-size:12px;'>".$detalles[$key]." ".$u." ".$idiomas[$key]." ".$dest[$key]."Cantidad de paginas: ".$paginas[$key]."</td> 
				<td style='text-align:center;font-size:12px;'>".$precio_unitario[$key]."</td>
				<td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$importe[$key]."</td>
				</tr>";

			} else {

	  			$imp[$key] = $cantidad[$key] * $precio_unitario[$key]; //1*118
	  			$pr_unitd[$key] = $precio_unitario[$key] * ($desc_mv[$key]/100);//118 * 0.05 = 5.9
	  			$impd[$key] = $cantidad[$key] * $pr_unitd[$key]; //1*5.9

				$html.="<tr style='color:#868686;";

				if($c++%2==1){$html.="!important;height:20px;background:#EDEDED;'"; }else{$html.="!important;height:20px;'";}

				$html.=">
				<td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad[$key]."</td>
				<td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad[$key]."</td>
				<td style='font-size:12px;'>".$detalles[$key]." ".$u." ".$idiomas[$key]." ".$dest[$key]."Cantidad de paginas: ".$paginas[$key]."</td> 
				<td style='text-align:center;font-size:12px;'>".$precio_unitario[$key]."</td>
				<td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".number_format($imp[$key],2,'.',',')."</td>
				</tr>";

				$html.="<tr style='color:#868686;";

				if($c++%2==1){$html.="!important;height:20px;background:#EDEDED;'"; }else{$html.="!important;height:20px;'";}

				$html.=">
				<td style='text-align:center;background:#FFF;font-size:12px;'>".$cantidad[$key]."</td>
				<td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tipo_unidad[$key]."</td>
				<td style='font-size:12px;'>Descuento ".$desc_mv[$key]."%</td> 
				<td style='text-align:center;font-size:12px;'>-".number_format($pr_unitd[$key],2,'.',',')."</td>
				<td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>-".number_format($pr_unitd[$key],2,'.',',')."</td>
				</tr>";
			}
		}

		if($discount=='Si'){
            $html.="<tr style='color:#868686 !important;'>
            <td style='text-align:center;font-size:12px;'></td>
            <td style='text-align:center;background:#EDEDED;border-left: 3px solid #047ab7;font-size:12px;'></td>
            <td style='font-size:12px;background:#EDEDED;'>Descuento por promoción ";

            if($codigo=='TRUSTPILOT'){
                $mensaje.="- Código ".$codigo_trust;
            }

            if($codigo=='GOOGLE'){
                $mensaje.="- Código ".$codigo_google;
            }

            $html.="</td> 
            <td style='text-align:center;font-size:12px;background:#EDEDED;'>-".$dmonto."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;background:#EDEDED;'>-".$dmonto."</td>
            </tr>";
        }

        if($urgencia=='Si'){
            $html.="<tr style='color:#868686 !important;'>
            <td style='text-align:center;font-size:14px;'></td>
            <td style='text-align:center;background:#EDEDED;border-left: 3px solid #047ab7;font-size:12px;'></td>
            <td style='font-size:12px;background:#EDEDED;'>Monto por urgencia</td> 
            <td style='text-align:center;font-size:12px;background:#EDEDED;'>".$montourg."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;background:#EDEDED;'>".$montourg."</td>
            </tr>";
        }


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
        
        $html.="<tr>
        <td style='background:#FFF;'></td>
        <td rowspan='3' colspan='2' style='border-left: 3px solid #047ab7;border-bottom:3px solid #047ab7;vertical-align:top;font-size:12px;'>
        <b>Notas: </b>".$valores."<br>".$detalle_entrega."
        </td>
        <td style='text-align:right;font-size:12px;'><b>Subtotal:</b></td>
        <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$symbol." ".number_format($row_mail['subtotal'],2,'.',',')."</td>
        </tr>".
        "<tr>
        <td style='background:#FFF;'></td>
        <td style='text-align:right;font-size:12px;'><b>IGV 18%:</b></td>
        <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$symbol." ".number_format($row_mail['igv'],2,'.',',')."</td>
        </tr>".
        "<tr style='background: #047ab7;color: #FFF;'>
        <td style='background:#FFF;'></td>
        <td style='text-align:right;color:#FFF;border-bottom:3px solid #047ab7;'><b>Total:</b></td>
        <td style='text-align:right;color:#FFF;border-right: 3px solid #047ab7;border-bottom:3px solid #047ab7;'>".$symbol." ".number_format($row_mail['total'],2,'.',',')."</td>
        </tr>".

        "</table></div>";

        $html .= "<br><div style='width:800px;'><b>Detalles Adicionales: </b></div>";
        $html .= "<table style='width:100%; border-collapse:collapse;'>
        

        <tr>
        <td style='text-align:right; font-weight:500; width:45%;border-top:3px solid #72c3a9;font-size:13px;'>Plazo de Entrega</td>
        <td style='text-align:center; background:#72c3a9;border-top:3px solid #72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$fecha_entrega." a las ".$hora1." con aprobación el<br>".$fecha_entrega2." antes de las ".$hora2."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Método de pago</td>
        <td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".implode(', ',$metodo_pago)."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Formato de Entrega</td>
        <td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".implode(', ',$formato_entrega)."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Validez de oferta</td>
        <td style='text-align:center;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".$validez_oferta."</td>
        </tr>

        <tr>
        <td style='text-align:right; font-weight:500;font-size:13px;'>Tipo de Entrega</td>
        <td style='text-align:center;background:#72c3a9;border-left:3px solid #72c3a9;border-right:3px solid #72c3a9;font-size:13px;'>".implode(', ',$tipo_entrega)."</td>
        </tr>

        </table>";

        $html .="<h4 style='font-size:12px;'>Pague con su tarjeta crédito o débito ingresando a <a style='text-decoration:none; color:#047AB7' href='".$url_pay."' target='_blank'>".$url_pay."</a></h4>";
        $html .="<table style='width:100%;border-collapse:collapse;'>
                <tr style='text-align:center;'>
                <td style='text-align:center;'><a href='".$url_pay."' target='_blank'><img src='https://www.limac.com.pe/library/images/logos.jpg'></a></td></tr></table>";

        if($tipocot=='RYE'){

			/*$html .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
				<table style='width:100%;border-collapse:collapse;'>
					<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
					</tr>

					<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
						<td><img src='http://www.limac.com.pe/assets/images/bcp-logo-gray.png' width='65'></td>
						<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
						<td style='font-size: 11px;text-align: center;'>Corriente</td>
						<td style='font-size: 11px;text-align: center;'>192-2172045-0-47</td>
						<td style='font-size: 11px;text-align: center;'>002-192-002172045047-33</td>
						<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
					</tr>

					<tr style='font-size: 11px;text-align: center;'>
						<td><img src='http://www.limac.com.pe/assets/images/bcp-logo-gray.png' width='65'></td>
						<td style='font-size: 11px;text-align: center;'>Dólar Estadounidense (USD)</td>
						<td style='font-size: 11px;text-align: center;'>Corriente</td>
						<td style='font-size: 11px;text-align: center;'>192-2145311-1-17</td>
						<td style='font-size: 11px;text-align: center;'>002-192-002145311117-37</td>
						<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
					</tr>
				</table>";*/

			$html4 .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
				<table style='width:100%;border-collapse:collapse;'>
					<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
						<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
					</tr>

					<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
						<td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
						<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
						<td style='font-size: 11px;text-align: center;'>Corriente</td>
						<td style='font-size: 11px;text-align: center;'>0913001566459</td>
						<td style='font-size: 11px;text-align: center;'>003-091-003001566459-69</td>
						<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
					</tr>

					<tr style='font-size: 11px;text-align: center;'>
						<td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
						<td style='font-size: 11px;text-align: center;'>Dólar Estadounidense (USD)</td>
						<td style='font-size: 11px;text-align: center;'>Corriente</td>
						<td style='font-size: 11px;text-align: center;'>0913001566466</td>
						<td style='font-size: 11px;text-align: center;'>003-091-003001566466-64</td>
						<td style='font-size: 11px;text-align: center;'>R&E Traducciones S.A.C.</td>
					</tr>
				</table>";

        } else {

			/*$html .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
            <table style='width:100%;border-collapse:collapse;'>
				<tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
					<td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
					<td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
					<td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
					<td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
					<td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
					<td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
				</tr>
				<tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
					<td><img src='https://www.limac.com.pe/assets/images/bbva-continental.png' width='65'></td>
					<td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
					<td style='font-size: 11px;text-align: center;'>Corriente</td>
					<td style='font-size: 11px;text-align: center;'>0011-0467-0100004771</td>
					<td style='font-size: 11px;text-align: center;width:180px;'>011-467-000100004771-80</td>
					<td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
				</tr>
            </table>";*/

            $html4 .="<h4 style='font-size:11.5px;'>También puede pagar mediante depósito o transferencia bancaria y enviar el comprobante de pago a <a style='text-decoration:none; color:#0093df;' href='mailto:ventas@limac.com.pe'>ventas@limac.com.pe</a></h4>
            <table style='width:100%;border-collapse:collapse;'>
            <tr style='background:#88847E;color:#FFF;text-align:center;font-size:11px;'>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Banco</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Moneda</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Tipo de Cuenta</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Número de cuenta</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Código Interbancario(CCI)</td>
                <td style='color:#FFF;text-align:center;font-size:11px;'>Titular</td>
            </tr>
            <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
                <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
                <td style='font-size: 11px;text-align: center;'>Soles (PEN)</td>
                <td style='font-size: 11px;text-align: center;'>Corriente</td>
                <td style='font-size: 11px;text-align: center;'>200-3001567347</td>
                <td style='font-size: 11px;text-align: center;width:180px;'>003-200-003001567347-35</td>
                <td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
            </tr>

            <tr style='background:#EEEEEE;font-size: 11px;text-align: center;'>
                <td><img src='https://www.limac.com.pe/assets/images/interbank.png' width='65'></td>
                <td style='font-size: 11px;text-align: center;'>Dólar Estadounidense (USD)</td>
                <td style='font-size: 11px;text-align: center;'>Corriente</td>
                <td style='font-size: 11px;text-align: center;'>200-3001567362</td>
                <td style='font-size: 11px;text-align: center;width:180px;'>003-200-003001567362-34</td>
                <td style='font-size: 11px;text-align: center;width:150px;'>LIMAC DEL PERÚ E.I.R.L.</td>
            </tr>
            </table>";

        }
        

        $html .= "<div style='width:800px;font-size:12px;'>".
        "<p>Cordialmente,<br>
		Departamento de Ventas.</p>";

		$html .= "<img src='https://www.limac.com.pe/assets/images/limac_gradient.jpg' width='120'><br>";

        $html.="</div></body></html>";


       	$mpdf = new mPDF('', // mode - default ''
            'A4', // format - A4, for example, default ''
            '', // font size - default 0
            '', // default font family
            14, //margin-left
            14, //margin-right
            10, //margin-top
            40, // margin-bottom
            '', //margin-header
            2); //margin-footer
                //L-landscape; P-portrait

		

		$footer = "
					<div style='width:800px; font-size:9px; color:#aaa;'>
						IMPORTANTE/CONFIDENCIAL<br>
						Este documento contiene información personal y confidencial que va dirigida única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundida. Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. Si usted recibió este mensaje por error, sírvase informarlo al remitente y deshacerse de cualquier documento inmediatamente
					<div style='width:800px; text-align:center;font-size:12px;'>";

        if($tipocot=='RYE'){
			$footer.="R&E TRADUCCIONES S.A.C.<br>";
		} else {
			$footer.="LIMAC DEL PERÚ E.I.R.L.<br>";
		}

        $footer.= $direccion;

        // if($tipocot=='RYE'){
		// 	$footer.="Schreiber 210";
		// } else {
		// 	$footer.="Schreiber 210";
		// }

        $footer.=", Lima.<br>
        Teléfono: ";

		$xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
		$rxcv = mysqli_query($connect,$xcv);
		$gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
		$footer .= $gxcv['numero'];

        $footer.=" * Correo Electrónico: ".$eemail."<br>".
        "</div><br>";
        $mpdf ->SetHTMLFooter($footer);
		$mpdf -> writeHTML($html);		
		$attach = $mpdf -> Output('reporte.pdf','S');
		$nomfile = "COTIZACION - TRADUCCION - " . $row_mail['codigo_cotizacion'] . ".pdf";
		$encoding = "base64";
		$type ="application/octet-stream";

		$path="../../../quotes/".$nomfile;
		$mpdf -> Output($path,'F');

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
		$mail->Username = "informes@limac.pe";
		$mail->Password = $psword;
		$mail->From = "ventas@limac.com.pe";

		$mail->FromName = "LIMAC";
		$mail->Subject = $asunto;

		//$mail->addAddress($correo);
		$addr = explode(',',$correo);

		foreach ($addr as $ad) {
			$mail->AddAddress( trim($ad) );
		}

		$mail->IsHTML(true);
		$mail->MsgHTML($mensaje);

		$mail->AddStringAttachment($attach,$nomfile,$encoding,$type);

		foreach( $url as $key => $ff ) {
            //echo "Url: ".$u.", Filename: ".$filename[$key]."<br>";
            $mail->AddStringAttachment(file_get_contents($ff),$filename[$key],$enc,$ty);
		}

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

		if($mail->Send()){
			echo $row_mail['codigo_cotizacion'];
		}

		// ====================================
		// INSERTAR HISTORIAL
		// ====================================
		/*admin*/
		$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
		$radm = mysqli_query($connect,$sadm);
		$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
		$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

		$ultimoidCotv1 = $ultimoIdInsertado.$code_fecha;
		$comentario = $nomadm . " ha enviado una cotización a InSpectre Solutions " .$referencial. " - (" . $correo. ")";
		$sqlcot = "INSERT INTO historial (cod_proyecto,cod_usuario,tipo_usuario,accion,fecha,mensaje) values('$ultimoidCotv1','$elid','$ttipo','COTIZACIONV1','$datee','$comentario')";
		$rescot = mysqli_query($connect,$sqlcot);
?>
