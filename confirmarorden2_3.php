
<?php $connect = mysqli_connect("localhost", "root", "Pass8520456+", "limac_portal"); mysqli_set_charset($connect,"utf8");
require "../../../PHPMailer/PHPMailerAutoload.php";
 ?> 
<?php

  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL, 'es_PE');
  $fech = date("Y-m-d H:i");
?>

<?php 

	$infopago = $_POST["infopago1"];
	$remitente = $_POST["remitente1"];
	$forma_entrega = $_POST["forma_entrega1"];
	$id = $_POST["id1"];
	$sexcliente = $_POST["sexcliente1"];
	$atencion = $_POST["atencion1"];
	$at1 = $_POST["at1"];
	$nombre = $_POST["nombre1"];
	$correo = $_POST["correo1"];
	$tiempo_entrega = ltrim($_POST["tiempo_entrega1"]);
  //$idtrad = $_POST['idtrad1'];
  //$files = $_POST['files1'];
  $revisor = $_POST['rev'];
  $tipo = $_POST['tipo'];
  $elid = $_POST['elid'];
  $ttipo = $_POST['ttipo'];
  $tipocot = $_POST['tipocot'];

  $xcv = "SELECT * FROM telephone where estado='MOSTRAR'";
  $rxcv = mysqli_query($connect,$xcv);
  $gxcv = mysqli_fetch_array($rxcv,MYSQLI_ASSOC);
  $txcv = $gxcv['numero'];

  $xcve = "SELECT * FROM telephone where estado='MOSTRAR_ESPANA'";
  $rxcve = mysqli_query($connect,$xcve);
  $gxcve = mysqli_fetch_array($rxcve,MYSQLI_ASSOC);
  $txcve = $gxcve['numero'];


  $sqltrad = "SELECT * FROM personal_limac where id_pl='$idtrad'";
  $restrad = mysqli_query($connect,$sqltrad);
  $regtrad = mysqli_fetch_array($restrad,MYSQLI_ASSOC);
  $tradnom = $regtrad['personal_nombres'];
  $tradape = $regtrad['personal_apellido'];

  $tradfree = $_POST['tf'];
  $nomtradfree = $_POST['ntf'];

  $astr = $_POST['astr'];//trad
  $link = $_POST['link'];//archivo trad

  $archivos = $_POST['archivos'];

  $SQLPS = "SELECT * FROM limac_pass where estado='ACTIVO'";
  $RQLPS = mysqli_query($connect,$SQLPS);
  $GQLPS = mysqli_fetch_array($RQLPS,MYSQLI_ASSOC);
  $usrname = $GQLPS['username'];
  $psword = $GQLPS['password'];
  $usfrom = $GQLPS['from'];

  /*if($files==''){
    $files = $archivos;
  }*/

  if($idtrad=='4014'){
    $traductor= $tradnom.' '.$tradape.' - CTP Nº 0667';
  } else if($idtrad=='4037'){
    $traductor= $tradnom.' '.$tradape.' - CTP Nº 0648';
  } else if($idtrad=='4044'){
    $traductor= $tradnom.' '.$tradape.' - CTP Nº 0790';
  } else if($idtrad=='4000'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4007'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4023'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4042'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4045'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4046'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4047'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4048'){
    $traductor= $tradnom.' '.$tradape;
  } else if($idtrad=='4049'){
    $traductor= $tradnom.' '.$tradape;
  } else {
    $traductor= $idtrad;
  }

  ////
  $length = 10;
  $randomletter = substr(str_shuffle("0987654321abcdefghijklmnopqrstuvwxyzQAZWSXEDCRFVTGBYHNUJMIKOLP"), 0, $length);

  $sqlcot = "SELECT * FROM cotizacion_limac where concat(`id_cotizacion`,`date_code`)='$id'";
  $rescot = mysqli_query($connect,$sqlcot);
  $regcot = mysqli_fetch_array($rescot,MYSQLI_ASSOC);
  $clientecot = $regcot['nombre_cliente'];
  $correocot = $regcot['correo_cliente'];
  $monedacot = $regcot['moneda'];
  $subtotal = $regcot['subtotal'];
  $total = $regcot['total'];

  if($monedacot=='euros'){
    $eemail = "ventas@limac.com.es";
    $ename = "LIMAC ESPAÑA";
    $pie = "LIMAC<br>Paseo de la Castellana 259C Piso 18, Torre de Cristal, Madrid, España<br>Teléfono: ".$txcve." * Correo Electrónico: <a href='mailto:ventas@limac.com.es' style='color:#FFF;text-decoration:none;'>ventas@limac.com.es</a><br>";
    $link_politica = "https://www.limac.com.es/<br>politica/terminos-y-condiciones/";
    $url_pay = "https://www.limac.com.es/pagos/";
    $site = "www.limac.com.es";
  } else {
    $eemail = $usfrom;
    $ename = "LIMAC";
    $pie = "R&E TRADUCCIONES S.A.C. - R.U.C. 20551971300<br>Avenida El Derby 055, Torre 1 - Piso 7, Santiago de Surco, Lima.<br>Teléfono: ".$txcv." * Correo Electrónico: <a style='color:#FFF;text-decoration:none;' href='mailto:".$usfrom."'>".$usfrom."</a><br>";
    $link_politica = "https://www.limac.com.pe/<br>politica/terminos-y-condiciones/";
    $url_pay = "https://www.limac.com.pe/pagos/";
    $site = "www.limac.com.pe";
  }


  function get_mx($email)
  {
      // Get domain name from email
      $domain = substr(strrchr($email, "@"), 1);

      // get MX records for domain
      getmxrr($domain, $mxhosts);

      // Match records with three options
      preg_match('/google|hotmail|yahoo/i', implode(' ', $mxhosts), $matches);

      // return option
      return strtolower($matches[0]);
  }


	$tt = explode(" ", $tiempo_entrega);

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

  function fecha_LIMACP($a,$b,$c){
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


  // if($monedacot=="euros"){

  //   date_default_timezone_set('Europe/Madrid');
  //   setlocale(LC_ALL, 'es_ES');
  //   $fech = date("Y-m-d H:i");


  //   if($t2=='horas' || $t2==" horas" || $t2==" hora" || $t2=="hora"){


  //     if($t1==1 || $t1==3 || $t1==6 || $t1==12){
  //         function addWorkingHours($timestamp, $hoursToAdd, $skipWeekends = false)
  //         {
  //             // Set constants
  //             $dayStart = 9;
  //             $dayEnd = 17;

  //             // For every hour to add
  //             for($i = 0; $i < $hoursToAdd; $i++)
  //             {
  //                 // Add the hour
  //                 $timestamp += 3600;

  //                 // If the time is between 1800 and 0800
  //                 if ((date('G', $timestamp) >= $dayEnd && date('i', $timestamp) >= 0 && date('s', $timestamp) > 0) || (date('G', $timestamp) < $dayStart))
  //                 {
  //                     // If on an evening
  //                     if (date('G', $timestamp) >= $dayEnd)
  //                     {
  //                         // Skip to following morning at 08XX
  //                         $timestamp += 3600 * ((24 - date('G', $timestamp)) + $dayStart);
  //                     }
  //                     // If on a morning
  //                     else
  //                     {
  //                         // Skip forward to 08XX
  //                         $timestamp += 3600 * ($dayStart - date('G', $timestamp));
  //                     }
  //                 }

  //                 // If the time is on a weekend
  //                 //if ($skipWeekends && (date('N', $timestamp) == 6 || date('N', $timestamp) == 7))
  //                 if ($skipWeekends && (date('N', $timestamp) == 7))
  //                 {
  //                     // Skip to Monday
  //                     $timestamp += 3600 * (24 * (8 - date('N', $timestamp)));
  //                 }
  //             }


  //             // Return
  //             return $timestamp;
  //         }

  //         // Usage
  //         $timestamp = time();
  //         $tt = addWorkingHours($timestamp, $t1); // timestamp
  //         //echo $tt;

  //         while(date("m-d",$tt)=='01-01' || date("m-d",$tt)=='08-15' || date("m-d",$tt)=='10-12' || date("m-d",$tt)=='11-01' || date("m-d",$tt)=='12-06' || date("m-d",$tt)=='12-09' || date("m-d",$tt)=='12-25'){
  //             $tt = $tt + 86400;

  //         }

  //         $sc = date("d-m-Y h:i A", $tt);
  //         $scc = date("Y-m-d H:i", $tt);
  //         $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

  //     } else {

  //       $fecha = date('Y-m-d h:i A');

  //       if((date('H') >= 0 && date('H')<9) && (date('w')!=0 || date('w')!=6)){
  //         $c = strtotime("now 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       if((date('H') >= 17 && date('H')<24) && (date('w')!=0 || date('w')!=6)){
  //         $c = strtotime("tomorrow 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       if((date('H') >= 17 && date('H')<24) && (date('w')==5)){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //       /*if (date('H') >= 18 && date('H')<24 && (date('w')==6)){
  //           $c=strtotime("+1 weekdays 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }*/

  //       if(date('w')==6){
  //           $c=strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       if(date('w')==0){
  //           $c=strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Asunción de la Virgen (jueves)
  //       if(date("d-m")=='15-08'){
  //         $c = strtotime("tomorrow 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Día de la Hispanidad (sábado)
  //       if(date("d-m")=='12-10'){
  //         $c = strtotime("monday 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Día de Todos los Santos (viernes)
  //       if(date("d-m")=='01-11'){
  //           $c = strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Día de la Constitución (viernes)
  //       if(date("d-m")=='06-12'){
  //           $c = strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Navidad (miércoles)
  //       if(date("d-m")=='25-12'){
  //           $c = strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Lunes 9 de diciembre (Fiesta de la Inmaculada
  //       if(date("d-m")=='09-12'){
  //           $c = strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Año Nuevo
  //       if(date("d-m")=='01-01' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //           $c = strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       } else if(date("d-m")=='01-01' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //           $c = strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //////

  //       $d = new DateTime( $fecha );

  //       $t = $d->getTimestamp();

  //       // loop for X days
  //       for($i=0; $i<$t1; $i++){

  //           // add 1 day to timestamp
  //           $addDay = 3600;

  //           // get what day it is next day
  //           $nextDay = date('w', ($t+$addDay));

  //           //get holidays date
  //           $dateHoliday = date('d-m',($t+$addDay));

  //           // if it's Saturday or Sunday get $i-1
  //           if($nextDay == 6 || $nextDay == 0 || $dateHoliday=='01-01' || $dateHoliday=='15-08' || $dateHoliday=='12-10' || $dateHoliday=='01-11' || $dateHoliday=='06-12' || $dateHoliday=='09-12' || $dateHoliday=='25-12') {
  //               $i--;
  //           }

  //           // modify timestamp, add 1 day
  //           $t = $t+$addDay;
  //       }

  //       $d->setTimestamp($t);

  //       $sc = $d->format( 'd-m-Y h:i A' );
  //       $scc = $d->format( 'Y-m-d H:i' );
  //       $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //     }
  //   }


  //   if($t2=='dias' || $t2=='días' || $t2==' dias' || $t2==' días' || $t2==' día' || $t2=='día'){

  //     $fecha = date('Y-m-d h:i A');

  //     if((date('H') >= 0 && date('H')<9) && (date('w')!=0 || date('w')!=6)){
  //       $c = strtotime("now 09:00");
  //       $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     if((date('H') >= 17 && date('H')<24) && (date('w')!=0 || date('w')!=6)){
  //       $c = strtotime("tomorrow 09:00");
  //       $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     if((date('H') >= 17 && date('H')<24) && (date('w')==5)){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //     if(date('w')==6){
  //         $c=strtotime("monday 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     if(date('w')==0){
  //         $c=strtotime("tomorrow 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     //Asunción de la Virgen (jueves)
  //       if(date("d-m")=='15-08'){
  //         $c = strtotime("tomorrow 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Día de la Hispanidad (sábado)
  //       if(date("d-m")=='12-10'){
  //         $c = strtotime("monday 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Día de Todos los Santos (viernes)
  //       if(date("d-m")=='01-11'){
  //           $c = strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Día de la Constitución (viernes)
  //       if(date("d-m")=='06-12'){
  //           $c = strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Navidad (miércoles)
  //       if(date("d-m")=='25-12'){
  //           $c = strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Lunes 9 de diciembre (Fiesta de la Inmaculada
  //       if(date("d-m")=='09-12'){
  //           $c = strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Año Nuevo
  //       if(date("d-m")=='01-01' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //           $c = strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       } else if(date("d-m")=='01-01' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //           $c = strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //////

  //     $d = new DateTime( $fecha );

  //       $t = $d->getTimestamp();

  //       // loop for X days
  //       for($i=0; $i<$t1; $i++){

  //           // add 1 day to timestamp
  //           $addDay = 86400;

  //           // get what day it is next day
  //           $nextDay = date('w', ($t+$addDay));

  //           //get holidays date
  //           $dateHoliday = date('d-m',($t+$addDay));

  //           // if it's Saturday or Sunday get $i-1
  //           if($nextDay == 6 || $nextDay == 0 || $dateHoliday=='01-01' || $dateHoliday=='15-08' || $dateHoliday=='12-10' || $dateHoliday=='01-11' || $dateHoliday=='06-12' || $dateHoliday=='09-12' || $dateHoliday=='25-12') {
  //               $i--;
  //           }

  //           // modify timestamp, add 1 day
  //           $t = $t+$addDay;
  //       }

  //       $d->setTimestamp($t);

  //       $sc = $d->format( 'd-m-Y h:i A' );
  //       $scc = $d->format( 'Y-m-d H:i' );
  //       $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //   }

  //   if($t2=="meses" || $t2=="mes" || $t2==" meses" || $t2 ==" mes"){
  //       $fecha = date('d-m-Y h:i A');
  //       $sc = date("d-m-Y h:i A", strtotime("+$t1 months"));
  //       $scc = date("Y-m-d H:i", strtotime("+$t1 months"));

  //       if((date('H') >= 0 && date('H')<9) && (date('w')!=0 || date('w')!=6)){
  //           $c = strtotime("now 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //           $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
  //           $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
  //           $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //       }

  //       if(date('H') >= 17 || date('H')<24 || date('w')==0){
  //           $c=strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //           $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
  //           $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
  //           $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //       }

  //       if(date('w')==6){
  //           $c=strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //           $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
  //           $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
  //           $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //       }
  //   }

  // } else { //euros

  //   date_default_timezone_set('America/Lima');
  //   setlocale(LC_ALL, 'es_PE');
  //   $fech = date("Y-m-d H:i");


  //   if($t2=='horas' || $t2==" horas" || $t2==" hora" || $t2=="hora"){


  //     if($t1==1 || $t1==3 || $t1==6 || $t1==12){
  //         function addWorkingHours($timestamp, $hoursToAdd, $skipWeekends = false)
  //         {
  //             // Set constants
  //             $dayStart = 9;
  //             $dayEnd = 17;

  //             // For every hour to add
  //             for($i = 0; $i < $hoursToAdd; $i++)
  //             {
  //                 // Add the hour
  //                 $timestamp += 3600;

  //                 // If the time is between 1800 and 0800
  //                 if ((date('G', $timestamp) >= $dayEnd && date('i', $timestamp) >= 0 && date('s', $timestamp) > 0) || (date('G', $timestamp) < $dayStart))
  //                 {
  //                     // If on an evening
  //                     if (date('G', $timestamp) >= $dayEnd)
  //                     {
  //                         // Skip to following morning at 08XX
  //                         $timestamp += 3600 * ((24 - date('G', $timestamp)) + $dayStart);
  //                     }
  //                     // If on a morning
  //                     else
  //                     {
  //                         // Skip forward to 08XX
  //                         $timestamp += 3600 * ($dayStart - date('G', $timestamp));
  //                     }
  //                 }

  //                 // If the time is on a weekend
  //                 //if ($skipWeekends && (date('N', $timestamp) == 6 || date('N', $timestamp) == 7))
  //                 if ($skipWeekends && (date('N', $timestamp) == 7))
  //                 {
  //                     // Skip to Monday
  //                     $timestamp += 3600 * (24 * (8 - date('N', $timestamp)));
  //                 }
  //             }


  //             // Return
  //             return $timestamp;
  //         }

  //         // Usage
  //         $timestamp = time();
  //         $tt = addWorkingHours($timestamp, $t1); // timestamp
  //         //echo $tt;

  //         while(date("m-d",$tt)=='01-01' || date("m-d",$tt)=='04-18' || date("m-d",$tt)=='04-19' || date("m-d",$tt)=='05-01' || date("m-d",$tt)=='06-29' || date("m-d",$tt)=='07-28' || date("m-d",$tt)=='07-29' || date("m-d",$tt)=='07-30' || date("m-d",$tt)=='08-30' || date("m-d",$tt)=='10-08' || date("m-d",$tt)=='11-01' || date("m-d",$tt)=='12-08' || date("m-d",$tt)=='12-25'){
  //             $tt = $tt + 86400;

  //         }

  //         $sc = date("d-m-Y h:i A", $tt);
  //         $scc = date("Y-m-d H:i", $tt);
  //         $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));

  //     } else {

  //       $fecha = date('Y-m-d h:i A');

  //       if((date('H') >= 0 && date('H')<9) && (date('w')!=0 || date('w')!=6)){
  //         $c = strtotime("now 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       if((date('H') >= 17 && date('H')<24) && (date('w')!=0 || date('w')!=6)){
  //         $c = strtotime("tomorrow 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       if((date('H') >= 17 && date('H')<24) && (date('w')==5)){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //       /*if (date('H') >= 18 && date('H')<24 && (date('w')==6)){
  //           $c=strtotime("+1 weekdays 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }*/

  //       if(date('w')==6){
  //           $c=strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       if(date('w')==0){
  //           $c=strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //       }

  //       //Jueves Santo
  //           if(date("d-m")=='18-04'){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //Viernes Santo
  //           if(date("d-m")=='19-04'){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //            //Día del Trabajo
  //           if(date("d-m")=='01-05' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='01-05' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //29-Junio

  //           if(date("d-m")=='29-06' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='29-06' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //28-Julio

  //           if(date("d-m")=='28-07' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='28-07' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //29-Julio

  //           if(date("d-m")=='29-07' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='29-07' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //30-Julio

  //           if(date("d-m")=='30-07' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='30-07' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //30-Agosto

  //           if(date("d-m")=='30-08' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='30-08' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //08-Octubre

  //           if(date("d-m")=='08-10' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='08-10' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //01-Noviembre

  //           if(date("d-m")=='01-11' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='01-11' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //08-Diciembre

  //           if(date("d-m")=='08-12' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='08-12' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //Navidad

  //           if(date("d-m")=='25-12' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='25-12' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //Año Nuevo

  //           if(date("d-m")=='01-01' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='01-01' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }


  //           //////

  //       $d = new DateTime( $fecha );

  //       $t = $d->getTimestamp();

  //       // loop for X days
  //       for($i=0; $i<$t1; $i++){

  //           // add 1 day to timestamp
  //           $addDay = 3600;

  //           // get what day it is next day
  //           $nextDay = date('w', ($t+$addDay));

  //           //get holidays date
  //           $dateHoliday = date('d-m',($t+$addDay));

  //           // if it's Saturday or Sunday get $i-1
  //           if($nextDay == 6 || $nextDay == 0 || $dateHoliday=='01-01' || $dateHoliday=='18-04' || $dateHoliday=='19-04' || $dateHoliday=='01-05' || $dateHoliday=='29-06' || $dateHoliday=='28-07' || $dateHoliday=='29-07' || $dateHoliday=='30-07' || $dateHoliday=='30-08' || $dateHoliday=='08-10' || $dateHoliday=='01-11' || $dateHoliday=='08-12' || $dateHoliday=='25-12') {
  //               $i--;
  //           }

  //           // modify timestamp, add 1 day
  //           $t = $t+$addDay;
  //       }

  //       $d->setTimestamp($t);

  //       $sc = $d->format( 'd-m-Y h:i A' );
  //       $scc = $d->format( 'Y-m-d H:i' );
  //       $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //     }
  //   }


  //   if($t2=='dias' || $t2=='días' || $t2==' dias' || $t2==' días' || $t2==' día' || $t2=='día'){

  //     $fecha = date('Y-m-d h:i A');

  //     if((date('H') >= 0 && date('H')<9) && (date('w')!=0 || date('w')!=6)){
  //       $c = strtotime("now 09:00");
  //       $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     if((date('H') >= 17 && date('H')<24) && (date('w')!=0 || date('w')!=6)){
  //       $c = strtotime("tomorrow 09:00");
  //       $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     if((date('H') >= 17 && date('H')<24) && (date('w')==5)){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //     if(date('w')==6){
  //         $c=strtotime("monday 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     if(date('w')==0){
  //         $c=strtotime("tomorrow 09:00");
  //         $fecha = date("Y-m-d h:i A", $c);
  //     }

  //     //Jueves Santo
  //           if(date("d-m")=='18-04'){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //Viernes Santo
  //           if(date("d-m")=='19-04'){
  //             $c = strtotime("monday 09:00");
  //             $fecha = date("Y-m-d h:i A", $c);
  //           }

  //            //Día del Trabajo
  //           if(date("d-m")=='01-05' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='01-05' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //29-Junio

  //           if(date("d-m")=='29-06' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='29-06' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //28-Julio

  //           if(date("d-m")=='28-07' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='28-07' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //29-Julio

  //           if(date("d-m")=='29-07' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='29-07' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //30-Julio

  //           if(date("d-m")=='30-07' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='30-07' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //30-Agosto

  //           if(date("d-m")=='30-08' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='30-08' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //08-Octubre

  //           if(date("d-m")=='08-10' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='08-10' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //01-Noviembre

  //           if(date("d-m")=='01-11' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='01-11' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //08-Diciembre

  //           if(date("d-m")=='08-12' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='08-12' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //Navidad

  //           if(date("d-m")=='25-12' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='25-12' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }

  //           //Año Nuevo

  //           if(date("d-m")=='01-01' && (date('w')==5 || date('w')==6 || date('w')==0)){
  //               $c = strtotime("monday 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           } else if(date("d-m")=='01-01' && (date('w')!=5 || date('w')!=6 || date('w')!=0)){
  //               $c = strtotime("tomorrow 09:00");
  //               $fecha = date("Y-m-d h:i A", $c);
  //           }


  //           //////

  //     $d = new DateTime( $fecha );

  //       $t = $d->getTimestamp();

  //       // loop for X days
  //       for($i=0; $i<$t1; $i++){

  //           // add 1 day to timestamp
  //           $addDay = 86400;

  //           // get what day it is next day
  //           $nextDay = date('w', ($t+$addDay));

  //           //get holidays date
  //           $dateHoliday = date('d-m',($t+$addDay));

  //           // if it's Saturday or Sunday get $i-1
  //           if($nextDay == 6 || $nextDay == 0 || $dateHoliday=='01-01' || $dateHoliday=='18-04' || $dateHoliday=='19-04' || $dateHoliday=='01-05' || $dateHoliday=='29-06' || $dateHoliday=='28-07' || $dateHoliday=='29-07' || $dateHoliday=='30-07' || $dateHoliday=='30-08' || $dateHoliday=='08-10' || $dateHoliday=='01-11' || $dateHoliday=='08-12' || $dateHoliday=='25-12') {
  //               $i--;
  //           }

  //           // modify timestamp, add 1 day
  //           $t = $t+$addDay;
  //       }

  //       $d->setTimestamp($t);

  //       $sc = $d->format( 'd-m-Y h:i A' );
  //       $scc = $d->format( 'Y-m-d H:i' );
  //       $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //   }

  //   if($t2=="meses" || $t2=="mes" || $t2==" meses" || $t2 ==" mes"){
  //       $fecha = date('d-m-Y h:i A');
  //       $sc = date("d-m-Y h:i A", strtotime("+$t1 months"));
  //       $scc = date("Y-m-d H:i", strtotime("+$t1 months"));

  //       if((date('H') >= 0 && date('H')<9) && (date('w')!=0 || date('w')!=6)){
  //           $c = strtotime("now 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //           $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
  //           $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
  //           $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //       }

  //       if(date('H') >= 17 || date('H')<24 || date('w')==0){
  //           $c=strtotime("tomorrow 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //           $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
  //           $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
  //           $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //       }

  //       if(date('w')==6){
  //           $c=strtotime("monday 09:00");
  //           $fecha = date("Y-m-d h:i A", $c);
  //           $sc = date("d-m-Y h:i A", strtotime("+$t1 months", strtotime($fecha)));
  //           $scc = date("Y-m-d H:i", strtotime("+$t1 months", strtotime($fecha)));
  //           $NewDate = date('Y-m-d H:i', strtotime($scc . " +15 days"));
  //       }
  //   }

  // } //soles


  if($archivos==''){
      $ast = array();
      foreach($astr as $llave => $b) {
          $rr = "INSERT INTO proyecto_asignado(codigo,tipo_proyecto,id_traductor,archivos) values('$id','$tipo','$b','$link[$llave]')";
          $ss = mysqli_query($connect,$rr);

          $sq = "SELECT * FROM cuenta_personal where id_personal='$b'";
          $re = mysqli_query($connect,$sq);
          $regg = mysqli_fetch_array($re,MYSQLI_ASSOC);
          $uss = $regg['user_personal'];

          $sqq = "SELECT * FROM personal_limac where id_pl='$b'";
          $resq = mysqli_query($connect,$sqq);
          $regq = mysqli_fetch_array($resq,MYSQLI_ASSOC);
          $nombretraductor = $regq['personal_nombres'].' '.$regq['personal_apellido'];

          $sqlh = "INSERT INTO historial(cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,qa_asignado,fecha) values('$id','$elid','$ttipo','ASIGNAR','$link[$llave]','$b','$revisor[$llave]','$fech')";
          $resh = mysqli_query($connect,$sqlh);

          if($b=='4014'){
            $ctp = ' - CTP Nº 0667';
          } else if($b=='4044'){
            $ctp = ' - CTP Nº 0790';
          } else {
            $ctp = '';
          }

          $ast[] = $nombretraductor.$ctp;

          $sql4 = "Select * from onesignal where usuario='$uss'";
          $reso = mysqli_query($connect,$sql4);

          $ids = array(); 
          while ($rohw = mysqli_fetch_array($reso,MYSQLI_ASSOC))  
          {
              $ids[] = $rohw["onesignalID"]; 
          } 

          $mensj = 'Se te ha asignado el proyecto Nº '.$id;
          $titulo = 'NEXUS - PROYECTO ASIGNADO';

          $content = array(
            "en" => $mensj
            );

          $heading = array(
            "en" => $titulo
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
          
          //return $response;
      }
  }

  if($archivos!=''){
    $ast = array();
    foreach($astr as $llave => $b) {
      $rr = "INSERT INTO proyecto_asignado(codigo,tipo_proyecto,id_traductor,archivos) values('$id','$tipo','$b','$archivos')";
      $ss = mysqli_query($connect,$rr);

        $sq = "SELECT * FROM cuenta_personal where id_personal='$b'";
        $re = mysqli_query($connect,$sq);
        $regg = mysqli_fetch_array($re,MYSQLI_ASSOC);
        $uss = $regg['user_personal'];

        $sqq = "SELECT * FROM personal_limac where id_pl='$b'";
        $resq = mysqli_query($connect,$sqq);
        $regq = mysqli_fetch_array($resq,MYSQLI_ASSOC);
        $nombretraductor = $regq['personal_nombres'].' '.$regq['personal_apellido'];

        if($b=='4014'){
          $ctp = ' - CTP Nº 0667';
        } else if($b=='4044'){
          $ctp = ' - CTP Nº 0790';
        } else {
          $ctp = '';
        }

        $sqlh = "INSERT INTO historial(cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,qa_asignado,fecha) values('$id','$elid','$ttipo','ASIGNAR','$archivos','$b','$revisor[$llave]','$fech')";
        $resh = mysqli_query($connect,$sqlh);

        $ast[] = $nombretraductor.$ctp;

        $sql4 = "Select * from onesignal where usuario='$uss'";
        $reso = mysqli_query($connect,$sql4);

        $ids = array(); 
        while ($rohw = mysqli_fetch_array($reso,MYSQLI_ASSOC))  
        {
            $ids[] = $rohw["onesignalID"]; 
        } 

        $mensj = 'Se te ha asignado el proyecto Nº '.$idpedido;
        $titulo = 'NEXUS - PROYECTO ASIGNADO';

        $content = array(
          "en" => $mensj
          );

        $heading = array(
          "en" => $titulo
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
        
        //return $response;

    }
  }


  if($revisor!=''){

    foreach($revisor as $llave => $b){
      $sqlr = "INSERT INTO proyecto_revisado (codigo,tipo_proyecto,id_traductor) values('$id','$tipo','$b')";
      $resr = mysqli_query($connect,$sqlr);
    }
  }


  $trads = array();

  foreach($astr as $key => $q) {

    $us = "SELECT * FROM personal_limac where id_pl='$q'";
    $rus = mysqli_query($connect,$us);
    $gus = mysqli_fetch_array($rus,MYSQLI_ASSOC);
    $em = $gus['personal_email'];

    $trads[] = $em;
  }

  foreach($revisor as $key => $b){

    $us = "SELECT * FROM personal_limac where id_pl='$b'";
    $rus = mysqli_query($connect,$us);
    $gus = mysqli_fetch_array($rus,MYSQLI_ASSOC);
    $em = $gus['personal_email'];

    $trads[] = $em;
  }

  // $addrq = explode(',',$correocot);

  // foreach ($addrq as $eml) {
  //     $rtrads = array_push($trads, $eml);
  // }



  //////////////////////GLOSARIO///////////////////////////

  require_once '../../../sheets/vendor/autoload.php';
  if (!file_exists("../../../sheets/new_client.json")) exit("Client secret file not found");
  $client = new Google_Client();
  $client->setAuthConfig('../../../sheets/new_client.json');
  $client->addScope("https://www.googleapis.com/auth/drive");
  $client->addScope("https://www.googleapis.com/auth/spreadsheets");
  // $client->addScope(Google_Service_Sheets::SPREADSHEETS);

  if (file_exists("../../../sheets/token.json")) {
    $access_token = (file_get_contents("../../../sheets/token.json"));
    $client->setAccessToken($access_token);
    //Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
       $refreshTokenSaved = $client->getRefreshToken(); 
       $client->fetchAccessTokenWithRefreshToken($refreshTokenSaved);
       $accessTokenUpdated = $client->getAccessToken();
       $accessTokenUpdated['refresh_token'] = $refreshTokenSaved;
       file_put_contents("../../../sheets/token.json", json_encode($accessTokenUpdated));
    }

    $service = new Google_Service_Sheets($client);
    $drive_service = new Google_Service_Drive($client);
    $idfolder = "1M8mEa-4jS3G8aqcGiF-fLgqZzNW4b25R"; //CARPETA GLOSARIOS


    $sqlg = "SELECT * FROM glosario where usuario_cliente='$correocot'";
    $resg = mysqli_query($connect,$sqlg);

    if(mysqli_num_rows($resg)>0){

          $regg = mysqli_fetch_array($resg,MYSQLI_ASSOC);
          $id_file = $regg['hoja_id'];
          $log = $regg['tipo'];

          if($log=="PRIVADO"){

            foreach ($trads as $kkey => $d) {

              $trd = get_mx($d);

              if($trd=="google"){

                $userPermission = new Google_Service_Drive_Permission(array(
                        'type' => 'user',
                        'role' => 'writer',
                        'emailAddress' => $w
                ));

                $request = $drive_service->permissions->create($id_file, $userPermission, array('fields' => 'id','sendNotificationEmail' => false));

              } else {

                    $userPermission = new Google_Service_Drive_Permission(array(
                        'type' => 'anyone',
                        'role' => 'writer'
                    ));

                    $request = $drive_service->permissions->create($id_file, $userPermission, array('fields' => 'id','sendNotificationEmail' => false));

                    $log = "PUBLICO";

                    $gsql = "UPDATE glosario SET tipo='$log' WHERE usuario_cliente='$correocot'";
                    $gres = mysqli_query($connect,$gsql);
              }
            }

          } else {

            $userPermission = new Google_Service_Drive_Permission(array(
                'type' => 'anyone',
                'role' => 'writer'
            ));

            $request = $drive_service->permissions->create($id_file, $userPermission, array('fields' => 'id','sendNotificationEmail' => false));

            $log = "PUBLICO";

            $gsql = "UPDATE glosario SET tipo='$log' WHERE usuario_cliente='$correocot'";
            $gres = mysqli_query($connect,$gsql);

          }

    } else {

      $fMetadata = new Google_Service_Drive_DriveFile(array('name' => $clientecot,'mimeType' => 'application/vnd.google-apps.spreadsheet',"parents"=>array($idfolder)));
      $file2 = $drive_service->files->create($fMetadata, array('fields' => 'id'));
      $id_file = $file2->id;// archivo_glosario

      $range = "A2:E2";
      $range1 = "A1:E1";
      $values = [["INGLÉS","ESPAÑOL","DEFINICIÓN","FUENTE","COMENTARIOS"]];
      $values1 = [["GLOSARIO"]];
      $data = [];
      $data1 = [];

      $data[] = new Google_Service_Sheets_ValueRange([
          'range' => $range,
          'majorDimension' => 'ROWS',
          'values' => $values
      ]);

      $requestBody = new Google_Service_Sheets_BatchUpdateValuesRequest([
        "valueInputOption" => "USER_ENTERED",
        "data" => $data

      ]);

      $response = $service->spreadsheets_values->batchUpdate($id_file, $requestBody);

      $data1[] = new Google_Service_Sheets_ValueRange([
          'range' => $range1,
          'majorDimension' => 'ROWS',
          'values' => $values1
      ]);

      $requestBody1 = new Google_Service_Sheets_BatchUpdateValuesRequest([
        "valueInputOption" => "USER_ENTERED",
        "data" => $data1

      ]);

      $response1 = $service->spreadsheets_values->batchUpdate($id_file, $requestBody1);

      // Range
      $rangel = new Google_Service_Sheets_GridRange();
      $rangel->setStartRowIndex(0);
      $rangel->setEndRowIndex(1);
      $rangel->setStartColumnIndex(0);
      $rangel->setEndColumnIndex(5);
      $rangel->setSheetId(0);

      // Merge rows of "A1:E1".
      $request1 = new Google_Service_Sheets_MergeCellsRequest();
      $request1->setMergeType('MERGE_ROWS');
      $request1->setRange($rangel);
      $body1 = new Google_Service_Sheets_Request();
      $body1->setMergeCells($request1);

      $bgColor = new Google_Service_Sheets_Color();
      $bgColor->setRed(138/255);
      $bgColor->setGreen(210/255);
      $bgColor->setBlue(165/255);

      $fontSize = new Google_Service_Sheets_TextFormat();
      $fontSize->setFontSize(14);
      $fontSize->setBold(true);

      // Change horizontalAlignment to "CENTER".
      $cellFormat = new Google_Service_Sheets_CellFormat();
      $cellFormat->setHorizontalAlignment('CENTER');
      $cellFormat->setBackgroundColor($bgColor);
      $cellFormat->setTextFormat($fontSize);
      $cellData = new Google_Service_Sheets_CellData();
      $cellData->setUserEnteredFormat($cellFormat);
      $rowData = new Google_Service_Sheets_RowData();
      $rowData->setValues([$cellData]);
      $rows[] = $rowData;
      $request2 = new Google_Service_Sheets_UpdateCellsRequest();
      $request2->setRows($rows);
      $request2->setFields('userEnteredFormat.horizontalAlignment,userEnteredFormat.backgroundColor,userEnteredFormat.textFormat');
      $request2->setRange($rangel);
      $body2 = new Google_Service_Sheets_Request();
      $body2->setUpdateCells($request2);

      $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest();
      $batchUpdateRequest->setRequests([$body1, $body2]);

      $response3 = $service->spreadsheets->batchUpdate($id_file, $batchUpdateRequest);

      foreach ($trads as $kkey => $w) {

        $trd = get_mx($w);

        if($trd=="google"){

          $userPermission = new Google_Service_Drive_Permission(array(
                  'type' => 'user',
                  'role' => 'writer',
                  'emailAddress' => $w
          ));

          $request = $drive_service->permissions->create($id_file, $userPermission, array('fields' => 'id','sendNotificationEmail' => false));

          $log = "PRIVADO";

        } else {

              $userPermission = new Google_Service_Drive_Permission(array(
                  'type' => 'anyone',
                  'role' => 'writer'
              ));

              $request = $drive_service->permissions->create($id_file, $userPermission, array('fields' => 'id','sendNotificationEmail' => false));

              $log = "PUBLICO";

        }

      }

      $link = 'https://docs.google.com/spreadsheets/d/'.$id_file.'/edit';
      $gsql = "INSERT INTO glosario (usuario_cliente,folder_id,hoja_id,link,tipo) values('$correocot','$idfolder','$id_file','$link','$log')";
      $gres = mysqli_query($connect,$gsql);

    }//glosario

  } else {
    $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/sheets/resp.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }

  ///////////////////////////////////////////////


  if($tradfree!=''){
      $sqlt = "INSERT INTO proyecto_asignado (codigo,tipo_proyecto,id_traductor) values('$id','$tipo','$nomtradfree')";
      $rest = mysqli_query($connect,$sqlt);
      $traductor= $nomtradfree;

      $sqlh = "INSERT INTO historial(cod_proyecto,cod_usuario,tipo_usuario,accion,archivos,traductor_asignado,fecha) values('$id','$elid','$ttipo','ASIGNAR','$files','$nomtradfree','$fech')";
      $resh = mysqli_query($connect,$sqlh);
  }


    /*$sql = "UPDATE cotizacion_limac set status='PENDIENTE DE TRADUCCIÓN', fecha_entrega = '$tiempo_entrega [$sc]', tiempo_entrega='[$sc]', archivos_cliente='$files', trad01='$idtrad' where concat(id_cotizacion,date_code)='$id'";
    $res = mysql_query($sql);*/

    $sql = "UPDATE cotizacion_limac set status='PENDIENTE DE TRADUCCIÓN', fecha_entrega = '$tiempo_entrega [$sc]', tiempo_entrega='[$sc]', delivered='$scc', archivos_cliente='' where concat(`id_cotizacion`,`date_code`)='$id'";
    $res = mysqli_query($connect,$sql);

    $fechaemision = date("Y-m-d H:i:s");

    

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

    $cons = "SELECT * from usuarios_limac where usuario='$correocot'";
    $rescons = mysqli_query($connect,$cons);

    if(mysqli_num_rows($rescons)>0){
      $regcons = mysqli_fetch_array($rescons,MYSQLI_ASSOC);
      $idul = $regcons['id_ul'];
    } else {
      $consu = "INSERT INTO usuarios_limac (nom_apellidos,sexo,email,usuario,pass,created) values('$clientecot','$sexcliente','$correocot','$correocot','0000','$fech')";
      $resconsu = mysqli_query($connect,$cons);

      $ss = "SELECT * from usuarios_limac where usuario='$correocot'";
      $sss = mysqli_query($connect,$ss);
      $ssss = mysqli_fetch_array($sss,MYSQLI_ASSOC);
      $idul = $ssss['id_ul'];
    }   

    $regauto = "INSERT INTO autologin(id_user,token,cotizacion,created) values('$idul','$uid','$id','$NewDate')";
    $resregauto = mysqli_query($connect,$regauto);

    $sql2 = "INSERT INTO confirmaciones_pago (codigo,tipo,cliente,correo_cliente,fecha,moneda,monto_noigv,monto_igv,emisor) values('$id','$tipo','$clientecot','$correocot','$fechaemision','$monedacot','$subtotal','$total','$remitente')";
    $res2 = mysqli_query($connect,$sql2);

    $sql3 = "DELETE from asignados where codigo = '$id'";
    $res3 = mysqli_query($connect,$sql3);

    //INFO PAGO

    if($sexcliente=="Masculino"){
    	$est="Estimado Sr. ";
    }

    if($sexcliente=="Femenino"){
    	$est="Estimada Srta. ";
    }

    if($sexcliente=="empresa"){
    	$est="Estimados Sres. ";
    }


    $asunto ="【CONFIRMACIÓN DE ORDEN DE SERVICIO - COTIZACIÓN N° ".$id."】";

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
                      <b ><br>".$est.$nombre.":</b>
                      <p style='text-align: justify;'>Hemos recibido la orden de servicio conforme, estamos empezando con el proceso de traducción de su proyecto.<br><br></p>";

    $mensaje.="
    <div>
    <img border='0' src='https://www.limac.com.pe/mail/tracking_confo.php?id=".$randomletter."&to=".$correo."&numproy=".$id."&tipo=COTIZACION' style='display:none;' />
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon001.png'></div></td>
          <td><div style='display: inline-block;position: relative;top: -15px;margin-left: 15px;'><b>Tiempo de Entrega Estimado:</b><br>".$tiempo_entrega." [".$sc."]</div></td>
        </tr>
      </table>
    </div>
    <hr>
    <div style='padding-top: 8px;padding-bottom: 8px;'>
      <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
        <tr>
          <td style='width:60px;'><div style='display: inline-block;position: relative;top: 0px;'><img src='https://www.limac.com.pe/assets/images/mail/icon002.png'></div></td>
          <td><div style='display: inline-block;top: 0px;    margin-left: 15px;position: relative;'><b>Forma de Entrega:</b><br>".$forma_entrega."</div></td>
        </tr>
      </table>
    </div>
    <hr>";

    if($tradfree=='Si'){
      $mensaje.="
      <div style='padding-top: 8px;padding-bottom: 8px;'>
          <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
            <tr>
              <td style='width:60px;'><div style='display: inline-block;top: 0px;position: relative;'><img src='https://www.limac.com.pe/assets/images/mail/icon003.png'></div></td>
              <td><div style='display: inline-block;top: -8px;    margin-left: 15px;position: relative;'><b>Traductor(es) Asignado(s):</b><br>".$nomtradfree."</div></td>
            </tr>
          </table>
      </div><hr>";
    } else {
      $mensaje.="
      <div style='padding-top: 8px;padding-bottom: 8px;'>
          <table width='100%' style='border:0;border-collapse:collapse;border-spacing:0;'>
            <tr>
              <td style='width:60px;'><div style='display: inline-block;top: 0px;position: relative;'><img src='https://www.limac.com.pe/assets/images/mail/icon003.png'></div></td>
              <td><div style='display: inline-block;top: -8px;    margin-left: 15px;position: relative;'><b>Traductor(es) Asignado(s):</b><br>".implode(', ',$ast)."</div></td>
            </tr>
          </table>
      </div><hr>";
    }

    if($forma_entrega!="MS Word - Correo electronico" || $forma_entrega!="MS Excel - Correo electronico" || $forma_entrega!="MS Power Point - Correo electronico"){
      $mensaje.="<br><div style='margin-bottom:12px;'>Sírvase ingresar en el siguiente enlace y completar un formulario con la finalidad de programar el envío de sus documentos en caso haya solicitado la entrega impresa o requiera una boleta/factura electrónica.</div>
              <table width='100%' height='auto'>
              <tbody>
              <tr>
                <td style='text-align:center;'><a href='https://".$site."/autologin/?I=".$idul."&t=".$uid."'><img src='https://www.limac.com.pe/assets/images/mail/button.png'></a></td>
              </tr>
            </tbody></table>";

    }

    $mensaje.="</td></tr>";

    $mensaje.='<tr style="background:#FFF;">
                <td align="left" style="background:#FFF;">
                  <p style="margin-left:10px; margin-right:10px;font-size:16px;">Cordialmente,<br><br>
                  Departamento de Ventas.</p></td>
              </tr><tr>
                <td align="left">
                  <div style="margin-left:10px !important;margin-right:10px !important;">
                       
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
                  <tr style='background-color:#0093DF;color:#FFF;'><td align='center' style='font-size: 12px;color:#FFF;text-decoration:none;'>".$pie."</td></tr>
                </table>
              </td>
            </tr>
          </table>
          </body></html>";


    //$adjunto = $_FILES["archivo"];
    
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

          if($mail->Send()){
          	echo "Confirmación de orden de servicio enviada";
          }



////////////////////////
//// admin
$sadm = "SELECT * FROM admin_limac where id_al='$elid'";
$radm = mysqli_query($connect,$sadm);
$gadm = mysqli_fetch_array($radm,MYSQLI_ASSOC);
$nomadm = $gadm['nombre']." ".$gadm['apellidos'];

$sqln = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','CONFIRMACION_ORDEN','$fech','$nomadm ha enviado una confirmación de orden de servicio al cliente $nombre','$id','COTIZACION')";
$resn = mysqli_query($connect,$sqln);

$sqlne = "INSERT INTO historial_nexus (tipo_registro,cod_usuario,tipo_usuario,accion,fecha,detalle,cod_proyecto,tipo_proyecto) values ('PROYECTOS','$elid','$ttipo','EN_TRADUCCION','$fech','$nomadm ha asignado el proyecto de $nombre EN TRADUCCIÓN','$id','COTIZACION')";
$resne = mysqli_query($connect,$sqlne);




          
?>