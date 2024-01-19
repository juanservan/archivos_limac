<?php 
  $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); 
  mysqli_set_charset($connect,"utf8");
  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL, 'es_PE');

  require "../../../PHPMailer/PHPMailerAutoload.php";
  require '../../../MPDF57/mpdf.php';
  include_once "../../../variables.php";

  $codproyecto = $_POST['codproyecto'];

  $gwf = "SELECT * FROM cotizacion_limac where concat(id_cotizacion,date_code)='$codproyecto'";
  $rgwf = mysqli_query($connect,$gwf);
  $reg_rgwf = mysqli_fetch_array($rgwf,MYSQLI_ASSOC);
  $clientecot = $reg_rgwf['nombre_cliente'];
  $monedacot = $reg_rgwf['moneda'];
  $fecha_entrega = $reg_rgwf['fecha_entrega'];
  $correo_cliente = $reg_rgwf['correo_cliente'];
  $tipo_entrega = $reg_rgwf['tipo_entrega'];
  $subtotal = $reg_rgwf['subtotal'];
  $total = $reg_rgwf['total'];
  $remitente = $reg_rgwf['emisor'];
  $conf_pago = $reg_rgwf['conf_pago'];
  $discount = $reg_rgwf['dscto'];
  $monto_dscto = $reg_rgwf['monto_dscto'];
  $elcreado = date_create($reg_rgwf['created']);
  $elid = $_POST['elid'];
  $ttipo = $_POST['ttipo'];

  $reclamante = $reg_rgwf['reclamante'];

  $fecha = date("Y-m-d H:i");

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

  $length = 10;
  $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

  if($monedacot=='soles'){
    $symbol='S/';
    $valores = "Valores expresados en nuevos soles (S/ ).";
    $eemail = $usfrom;
    $ename = "LIMAC";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";
  }

  if($monedacot=='dolares'){
    $symbol='$';
    $valores = "Valores expresados en dólares americanos ($).";
    $eemail = $usfrom;
    $ename = "LIMAC";
    $elfooter = "R&E TRADUCCIONES S.A.C.<br>".$direccion.", Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a href='mailto:".$usfrom."'>".$usfrom."</a><br><br>";

  }

  if($monedacot=='euros'){
    $symbol='€';
    $valores = "Valores expresados en euros (€).";
    $eemail = "ventas@limac.com.es";
    $ename = "LIMAC ESPAÑA";
    $elfooter = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es'>ventas@limac.com.es</a><br><br>";
  }

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

  $asunto2 ="【RECIBO ELECTRÓNICO COTIZACIÓN N° ".$codproyecto." ".$reclamante."】";

  ///////////////////

  $mensaje2 = "
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
                <img border='0' src='https://www.limac.com.pe/mail/tracking_bol.php?id=".$randomletter."&to=".$correo_cliente."&numproy=".$codproyecto."&tipo=COTIZACION' style='display:none;' />
                <b><br>Estimado(a) cliente:</b>
                <p style='text-align: justify;'>
                  Le emitimos adjunto el recibo electrónico correspondiente a su proyecto de traducción. Ante cualquier consulta puede escribirnos a este mensaje.<br><br>
                </p>
              </td>
            </tr>
            
            <tr style='background:#FFF;'>
              <td align='left' style='background:#FFF;'>
                <p style='margin-left:10px; margin-right:10px;font-size:16px;'>
                  Cordialmente,<br><br>
                  Departamento de Ventas.
                </p>
              </td>
            </tr>

            <tr>
              <td align='left'>
                <div style='margin-left:10px !important;margin-right:10px !important;'>
                  <img src='https://www.limac.com.pe/assets/images/logos/logo_color2.jpg' width='150'
                  style='border:0px;vertical-align:middle;margin-bottom: 20px;'><br>
                  <div>
                    $address1<br>
                    $address2,<br> Lima, República del Perú<br>
                    (511) (01) 700 9040<br>
                    <a href='mailto:ventas@limac.com.pe' target='_blank'>ventas@limac.com.pe</a><br><a href='http://www.limac.com.pe' target='_blank'>www.limac.com.pe</a>
                  </div>
                </div>
              </td>
            </tr>

            <tr style='background:#FFF;'>
              <td align='left' style='font-size:10px; color:#aaa;background:#FFF;'>
                <div style='margin-left:10px; margin-right:10px; margin-bottom: 10px;'>
                  IMPORTANTE/CONFIDENCIAL<br>
                  Este documento contiene información personal y confidencial que va dirigida única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundida. Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. Si usted recibió este mensaje por error, sírvase informarlo al remitente y deshacerse de cualquier documento inmediatamente.
                  <br><br>
                </div>
              </td>
            </tr>

            <tr style='background-color:#0093DF;'>
              <td align='center' style='background-color:#0093DF;color:#FFF;'><br>
                <img src='https://www.limac.com.pe/assets/images/mail/firma3.png'>
              </td>
            </tr>

            <tr style='background-color:#0093DF;color:#FFF;'>
              <td align='center' style='font-size: 12px;color:#FFF;text-decoration:none;'>
                ".$elfooter."
              </td>
            </tr>
          </table>
          
        </td>
      </tr>
    </table>
  </body>
  </html>";



  $pdf_boleta = "
  <html>
  <head>
    <style type='text/css'>
      body {font-family: maven_pro !important;}
    </style>
  </head>
  <body>
    <br>
      <table style='width:100%;'>
        <tr>
          <td width='80'>
            <img src='https://www.limac.com.pe/assets/images/limac108.png' width='60'>
          </td>
          <td width='260' style='vertical-align:middle !important;'>
            <div style='margin-left:10px;'>";

              if($monedacot=="euros"){
                $pdf_boleta.="<b>LIMAC</b>
                <p style='font-size:12px;margin:0px !important;'>PASEO DE LA CASTELLANA 259C PISO 18<br>
                TORRE DE CRISTAL - MADRID - ESPAÑA</p>";
              } else {
                $pdf_boleta.="<b>R&E TRADUCCIONES S. A. C.</b>
                <p style='font-size:12px;margin:0px !important;'>".$address1." <br>
                ".$address2."</p>";
              }

    $pdf_boleta.="
            </div>                  
          </td>
          <td width='160'></td>
          <td style='border: 1px solid #CCC;text-align:center;'>
            R.U.C: 20551971300<br>
            RECIBO ELECTRÓNICO<br>
            001 - ".$codproyecto."
          </td>
        </tr>             
      </table>
      <br><br>
      
      <table style='width:689px;'>
        <tr>
          <td width='200' style='vertical-align:top;'>
            Adquiriente:<br>
            <b>".$clientecot."</b><br><br>                 
          </td>
          <td> Condición de pago:<br>
            <div style='font-size:14px;'><b>".$reg_rgwf['metodo_pago']."</b></div>
          </td>
          <td width='80' style='vertical-align:top;'>
            IGV<br>
            <p style='font-weight:600;margin:0px;'><b>18%</b></p>
          </td>
          <td width='150' style='text-align:left;vertical-align:top;'>
            Fecha de emisión<br>
            <p style='font-weight:600;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:10px;'><b>".$dd."-".$mm."-".$yy."</b></p><br>
          </td>
          <td width='80' style='text-align:left;vertical-align:top;'>
            Moneda<br>
            <p style='font-weight:600;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:10px;'><b>".strtoupper($reg_rgwf['moneda'])."</b></p><br>                  
          </td>
        </tr>
        <tr><td colspan='5' style='height:10px;'></td></tr>
      </table><br>
      
      <div style='width:800px;'><br>
        <table style='width:100%; border-collapse:collapse;'>
          <tr style='color: #000 !important;'>
            <th style='width:50px;font-size:12px;border-bottom: 3px solid #047ab7;'>
              <b>Cantidad</b>
            </th>
            <th style='text-align:center;font-size:12px;width:70px;border-bottom: 3px solid #047ab7;'>
              <b>Unidad</b>
            </th>
            <th style='text-align:center;width:380px;font-size:12px;border-bottom: 3px solid #047ab7;'>
              <b>Descripción</b>
            </th> 
            <th style='font-size:12px;border-bottom: 3px solid #047ab7;'>
              <b>V. Unitario (".$symbol.")</b>
            </th>
            <th style='font-size:12px;border-bottom: 3px solid #047ab7;'>
              <b>Importe (".$symbol.")</b>
            </th>
          </tr>";


          $lpo = "SELECT * FROM cotizacion_limac_reg where id_cotizacion='$codproyecto'";
          $rlpo = mysqli_query($connect,$lpo);

          $c = 0;

          while($rglpo = mysqli_fetch_array($rlpo)){

            if($c++%2==1){
              $pdf_boleta.="<tr style='background:#EDEDED !important;'>"; 
            } else {
              $pdf_boleta.="<tr style='background:#FFF !important;'>";
            }
                    
            $pdf_boleta.="<td style='background:#FFF;text-align:center;font-size:12px;'>".$rglpo['cantidad']."</td>
            <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$rglpo['tipo_unidad']."</td>
            <td style='font-size:12px;'>".$rglpo['detalle']." ".$rglpo['descripcion']." ".$rglpo['idiomas'];

            if($rglpo['dscto_mayor']== NULL || $rglpo['dscto_mayor']==''){
                $pdf_boleta.= "</td> 
                <td style='text-align:center;font-size:12px;'>".$rglpo['precio_unitario']."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$rglpo['importe']."</td></tr>";
            } else if($rglpo['dscto_mayor']!= NULL && $rglpo['dscto_mayor']!=''){

                $xx = $rglpo['cantidad'] * $rglpo['precio_unitario'];
                $prc = $rglpo['dscto_mayor'] / 100;
                $dsct = $xx * $prc;

                $pdf_boleta.= "</td> 
                <td style='text-align:center;font-size:12px;'>".$rglpo['precio_unitario']."</td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".number_format($xx, 2, '.', '')."</td></tr>

                <tr style='height:20px;background:#FFF;'>
                <td style='height:20px;text-align:center;background:#FFF;font-size:12px;'></td>
                <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
                <td style='font-size:12px;'>Descuento ".$rglpo['dscto_mayor']."%</td> 
                <td style='text-align:center;font-size:12px;'></td>
                <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>-".number_format($dsct, 2, '.', '')."</td>
                </tr>";
            }      
            

          }

          if($discount=='Si'){
              $pdf_boleta.="<tr>
              <td style='font-size:12px;background:#EDEDED;'></td>
              <td style='text-align:center;background:#EDEDED;'></td>
              <td style='text-align:center;background:#EDEDED;'>Descuento por promoción - Código</td>                  
              <td style='text-align:center;background:#EDEDED;'>-".$monto_dscto."</td>
              <td style='text-align:right;background:#EDEDED;'>-".$monto_dscto."</td>
              </tr>";
          }
          
          
          $pdf_boleta.="
          <tr style='height:20px;background:#EDEDED;'>
            <td style='text-align:center;background:#FFF;font-size:12px;'></td>
            <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'></td>
            <td style='height:20px;font-size:12px;'></td> 
            <td style='text-align:center;font-size:12px;'></td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
          </tr>
          <tr style='height:20px;background:#FFF;'>
            <td style='height:20px;text-align:center;background:#FFF;font-size:12px;'>".$c8."</td>
            <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tu8."</td>
            <td style='font-size:12px;'></td> 
            <td style='text-align:center;font-size:12px;'></td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'></td>
          </tr>
          <tr style='height:20px;background:#EDEDED;'>
            <td style='height:20px;text-align:center;background:#FFF;font-size:12px;'>".$c8."</td>
            <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tu8."</td>
            <td style='font-size:12px;'>".$serv8." ".$d8." ".$lang8." ".$de8."</td> 
            <td style='text-align:center;font-size:12px;'>".$pu8."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$i8."</td>
          </tr>
          <tr style='height:20px;background:#FFF;'>
            <td style='height:20px;text-align:center;background:#FFF;font-size:12px;'>".$c8."</td>
            <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tu8."</td>
            <td style='font-size:12px;'>".$serv8." ".$d8." ".$lang8." ".$de8."</td> 
            <td style='text-align:center;font-size:12px;'>".$pu8."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$i8."</td>
          </tr>
          <tr style='height:20px;background:#EDEDED;'>
            <td style='height:20px;text-align:center;background:#FFF;font-size:12px;'>".$c8."</td>
            <td style='text-align:center;border-left: 3px solid #047ab7;font-size:12px;'>".$tu8."</td>
            <td style='font-size:12px;'>".$serv8." ".$d8." ".$lang8." ".$de8."</td> 
            <td style='text-align:center;font-size:12px;'>".$pu8."</td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$i8."</td>
          </tr>
          <tr>
            <td style='background:#FFF;'></td>
            <td rowspan='3' colspan='2' style='border-left: 3px solid #047ab7;border-bottom:3px solid #047ab7;vertical-align:top;font-size:12px;'>
            <b>Notas: ".$valores.".<br>".$reg_rgwf['detalle_entrega']."</b></td>         
            <td style='text-align:right;font-size:12px;'><b>Subtotal:</b></td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$symbol." ".$reg_rgwf['subtotal']."</td>
          </tr>
          <tr>
            <td style='background:#FFF;'></td>
            <td style='text-align:right;font-size:12px;'><b>IGV (18%):</b></td>
            <td style='text-align:right;border-right: 3px solid #047ab7;font-size:12px;'>".$symbol." ".$reg_rgwf['igv']."</td>
          </tr>
          <tr style='background: #047ab7;color: #FFF;'>
            <td style='background:#FFF;'></td>
            <td style='text-align:right;color:#FFF;border-bottom:3px solid #047ab7;'><b>Total:</b></td>
            <td style='text-align:right;color:#FFF;border-right: 3px solid #047ab7;border-bottom:3px solid #047ab7;'>".$symbol." ".$reg_rgwf['total']."</td>
          </tr>
        </table>
      </div>";

          if($monedacot!="euros"){
            $pdf_boleta.="<br><h4 style='font-size:12px;margin-bottom:15px;'>Realice su pago mediante depósito o transferencia bancaria y envíe el comprobante de pago a <a style='text-decoration:none; color:#047AB7' href='mailto:".$eemail."'>".$eemail."</a> indicando en su mensaje el número de pedido.</h4>
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
              </table>
              <div style='font-size:12px;margin-top:5px;'>Swiftcode: BINPPEPL - Dirección: AV. CARLOS VILLARAN NR. 140, LA VICTORIA, LIMA, PERU</div>
              <br><br>";
          }
          

          $pdf_boleta.="</body></html>";

          $mpdf_boleta = new mPDF('','A4','','',14,14,4,'','',2);

          $footer_boleta = "<div style='width:800px; font-size:9px; color:#aaa;padding-bottom:5px;'>".
          "IMPORTANTE/CONFIDENCIAL<br>
          Este documento contiene información personal y confidencial que va dirigida única y exclusivamente a su destinatario y, de acuerdo a ley, no puede ser difundida. Está completamente prohibido realizar copias, parciales o totales, así como propagar su contenido a otras personas que no sean el destinatario. Si usted recibió este mensaje por error, sírvase informarlo al remitente y deshacerse de cualquier documento inmediatamente". strftime("%H:%M %p") ."</div><br>";

          $footer_boleta .= "<div style='width:800px; text-align:center;font-size:12px;'>".$elfooter.
          "</div><br>";

          $mpdf_boleta -> writeHTML($pdf_boleta);
          $mpdf_boleta ->SetHTMLFooter($footer_boleta);
          $attach = $mpdf_boleta -> Output('reporte.pdf','S');
          $nomfile = "COTIZACION - RECIBO - " . $codproyecto . ".pdf";
          $encoding = "base64";
          $type ="application/octet-stream";

          $path="../../../boletas/".$nomfile;
          $mpdf_boleta -> Output($path,'F');


      ///********************
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
      $mail2->AddStringAttachment($attach,$nomfile,$encoding,$type);
      $mail2->Send();


  ////////////////////////
  //// admin
  $sadm = "SELECT * FROM admin_limac where id_al='$elid'";
  $radm = mysqli_query($connect,$sadm);
  $gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
  $nomadm = $gadm['nombre']." ".$gadm['apellidos'];

  $sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','ENVIO_BOLETA','$fecha','$nomadm ha enviado una boleta al cliente $clientecot','$codproyecto','COTIZACION')";
  $resn = mysqli_query($connect,$sqln);

?>