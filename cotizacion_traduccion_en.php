<?php include("../../limac_conexion/conexion.php"); ?>
<?php 
  session_start();
  
  if(isset($_COOKIE['admin']) && $_COOKIE['admin'] != ''){
   include("../../limac_conexion/conexion.php"); 
   $user_login = $_COOKIE['admin'];
   //$mess .= "Cookie activada";
   //get user data from mysql

  }else if(isset($_SESSION['admin']) && $_SESSION['admin'] !=''){
    include("../../limac_conexion/conexion.php"); 
   $user_login = $_SESSION['admin'];
   //get user data from mysql
  } else{
    header("Location: http://www.limac.com.pe/login/");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Limac | Dashboard</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link href="../build/css/style_custom.css" rel="stylesheet">
    <link href="../build/css/estilo.css" rel="stylesheet">
    <link href="../build/css/wsm.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../assets/css/jquery.datetimepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/bootstrap-multiselect.css" type="text/css"/>
    <!-- Smartsupp Live Chat script -->
    <script type="text/javascript">
    var _smartsupp = _smartsupp || {};
    _smartsupp.key = 'e53a682d588c6155d9201beea7cdef636949ae7f';
    window.smartsupp||(function(d) {
      var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
      s=d.getElementsByTagName('script')[0];c=d.createElement('script');
      c.type='text/javascript';c.charset='utf-8';c.async=true;
      c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
    })(document);
    </script>
  </head>

  <body class="nav-md">
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
    <div class="contenedor">
    <div class="container body">
      <div class="main_container">
        <?php 

                  $sqlad = "SELECT * FROM admin_limac where usuario='$user_login'";
                  $resad = mysql_query($sqlad);
                  $regad = mysql_fetch_array($resad);
                  $sexo = $regad['sexo'];
                  $imagen = $regad['imagen'];
                  $nomapellidos = $regad['nombre']." ".$regad['apellidos'];

            ?>
            <?php include("menu/menu_top.php"); ?>

        <!-- page content -->
        <div class="right_col cd-main-content" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Translation Quote</h3>
              </div>              
            </div>

            <div class="clearfix"></div>

            <div class="cboard">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel fff">                  
                    <div class="x_content">
                          <form action="scripts/enviar_cot_traduccion_en.php" id="trad" method="post" enctype="multipart/form-data">
                              <div class="col-xs-12 col-md-9 colnopad">
                                <!-- <div class="form-group">
                                  <label for="quote">Quote:</label>
                                  <label class="radio-inline"><input type="radio" name="quote" class="radio-button sexo" value="LIMAC" required> LIMAC</label>
                                  <label class="radio-inline"><input type="radio"  name="quote" class="radio-button sexo" value="LANGUAGEHIVE"> LANGUAGEHIVE</label>
                                </div> -->
                                <div class="form-group">
                                  <label for="nombre">Client Name:</label>
                                  <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                  <label for="correo">Client Email:</label>
                                  <input type="text" id="correo" name="correo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                  <label for="sexo">Gender:</label>
                                  <label class="radio-inline"><input type="radio" id="masc" name="sexo" class="radio-button sexo" value="Masculino" required> Male</label>
                                  <label class="radio-inline"><input type="radio" id="femen" name="sexo" class="radio-button sexo" value="Femenino"> Female</label>
                                </div>
                                <div class="form-group">
                                  <label for="empresa">A company?</label>
                                  <label class="checkbox-inline"><input type="checkbox" id="empresa" name="empresa" value="Yes">Yes</label>
                                  <label class="checkbox-inline"><input type="checkbox" id="atencion" name="atencion" value="Yes">Attention</label>
                                  <div id="aten" style="display:none;">
                                    <label for="at">Contact Name:</label>
                                    <input type="text" class="form-control" name="at" id="at">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="moneda">Currency:</label>
                                  <label class="radio-inline"><input type="radio" name="moneda" id="soles" class="radio-button" value="soles" required>Soles (S/)</label>
                                  <label class="radio-inline"><input type="radio" name="moneda" id="dolares" class="radio-button" value="dolares">Dollar ($)</label>
                                </div>
                                <div class="form-group">
                                  <label for="tipo_pago">Payment Method:</label>
                                  <label class="radio-inline radtp"><input type="radio" name="tipo_pago" class="radio-button" value="deposito" checked required>Deposit bank or Transfer bank</label>
                                  <label class="radio-inline radtp"><input type="radio" name="tipo_pago" class="radio-button" value="tarjeta">Credit card or Debit Card (PayU)</label>
                                </div>
                                <div class="form-group">
                                  <label for="firma">Signature:</label>       
                                  <label class="radio-inline"><input type="radio" name="firma" class="radio-button" value="RYE" checked>R&E</label>       
                                  <label class="radio-inline"><input type="radio" name="firma" class="radio-button" value="LIMACDELPERU">LIMAC DEL PERU</label>
                                </div>

                                <div id="trad001">
                                  <h3 class="text-center">Item #01</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc" id="desc" class="form-control" required>
                                      </div>

                                      <div class="form-group destino">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest" id="dest" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas" style="margin-left:0px !important;padding-bottom:0px !important;">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas" id="idiomas" class="form-control" required>
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad">Unit:</label>
                                      <select name="tipo_unidad" id="tipo_unidad" class="form-control" required>
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>

                                      <div class="form-group">
                                        <label for="detalles">Service</label>
                                        <select name="detalles" id="detalles" class="form-control" required>
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad" class="form-control" id="cantidad" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario" id="precio_unitario" class="form-control" onchange='fixit(this)' required>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe" id="importe" class="form-control" readonly="readonly" required>
                                      </div>
                                    </div>
                                  </div>
                                </div><!-- trad001 -->
                                <div id="traducciones2">
                                  <h3 class="text-center">Item #02</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc2" id="desc2" class="form-control">
                                      </div>

                                      <div class="form-group destino2">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest2" id="dest2" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas2">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas2" id="idiomas2" class="form-control">
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad2">Unit:</label>
                                      <select name="tipo_unidad2" id="tipo_unidad2" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>

                                      <div class="form-group">
                                        <label for="detalles2">Service</label>
                                        <select name="detalles2" id="detalles2" class="form-control">
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad2" class="form-control" id="cantidad2">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario2" id="precio_unitario2" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe2" id="importe2" readonly="readonly" class="form-control">
                                      </div>

                                      <button class="btn btn-info btn-sm delete2">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    </div>
                                  </div>
                                </div><!-- traducciones2 -->
                                <div id="traducciones3">
                                  <h3 class="text-center">Item #03</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc3" id="desc3" class="form-control">
                                      </div>

                                      <div class="form-group destino3">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest3" id="dest3" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas3">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas3" id="idiomas3" class="form-control">
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad3">Unit:</label>
                                      <select name="tipo_unidad3" id="tipo_unidad3" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>

                                      <div class="form-group">
                                        <label for="detalles3">Service</label>
                                        <select name="detalles3" id="detalles3" class="form-control">
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad3" class="form-control" id="cantidad3">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario3" id="precio_unitario3" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe3" id="importe3" readonly="readonly" class="form-control">
                                      </div>

                                      <button class="btn btn-info btn-sm delete3">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    </div>
                                  </div>
                                </div><!-- traducciones3 -->
                                <div id="traducciones4">
                                  <h3 class="text-center">Item #04</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc4" id="desc4" class="form-control">
                                      </div>

                                      <div class="form-group destino4">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest4" id="dest4" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas4">
                                      <label for="idiomas">Languages: </label>
                                      <select name="idiomas4" id="idiomas4" class="form-control" >
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad4">Unit:</label>
                                      <select name="tipo_unidad4" id="tipo_unidad4" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="detalles4">Service</label>
                                        <select name="detalles4" id="detalles4" class="form-control" >
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad4" class="form-control" id="cantidad4">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario4" id="precio_unitario4" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Precio:</label>
                                      <input type="text" name="importe4" id="importe4" readonly="readonly" class="form-control">
                                      </div>

                                      <button class="btn btn-info btn-sm delete4">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    </div>
                                  </div>
                                </div><!-- traducciones4 -->
                                <div id="traducciones5">
                                  <h3 class="text-center">Item #05</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc5" id="desc5" class="form-control">
                                      </div>

                                      <div class="form-group destino5">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest5" id="dest5" class="form-control" >
                                      </div>

                                      <div class="form-group idiomas5">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas5" id="idiomas5" class="form-control" >
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad5">Unit:</label>
                                      <select name="tipo_unidad5" id="tipo_unidad5" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="detalles5">Service</label>
                                        <select name="detalles5" id="detalles5" class="form-control" >
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad5" class="form-control" id="cantidad5">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario5" id="precio_unitario5" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe5" id="importe5" readonly="readonly" class="form-control">
                                      </div>

                                      <button class="btn btn-info btn-sm delete5">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    </div>
                                  </div>
                                </div><!-- traducciones5 -->
                                <div id="traducciones6">
                                  <h3 class="text-center">Item #06</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc6" id="desc6" class="form-control">
                                      </div>

                                      <div class="form-group destino6">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest6" id="dest6" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas6">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas6" id="idiomas6" class="form-control" >
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad6">Unit:</label>
                                      <select name="tipo_unidad6" id="tipo_unidad6" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="detalles6">Service</label>
                                        <select name="detalles6" id="detalles6" class="form-control" >
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad6" class="form-control" id="cantidad6">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario6" id="precio_unitario6" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe6" id="importe6" readonly="readonly" class="form-control">
                                      </div>

                                      <button class="btn btn-info btn-sm delete6">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    </div>
                                  </div>
                                </div><!-- traducciones6 -->
                                <div id="traducciones7">
                                  <h3 class="text-center">Item #07</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc7" id="desc7" class="form-control">
                                      </div>

                                      <div class="form-group destino7">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest7" id="dest7" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas7">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas7" id="idiomas7" class="form-control" >
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad7">Unit:</label>
                                      <select name="tipo_unidad7" id="tipo_unidad7" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="detalles7">Service</label>
                                        <select name="detalles7" id="detalles7" class="form-control" >
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad7" class="form-control" id="cantidad7">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario7" id="precio_unitario7" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe7" id="importe7" readonly="readonly" class="form-control">
                                      </div>

                                      <button class="btn btn-info btn-sm delete7">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                      </button>
                                    </div>
                                  </div>
                                </div><!-- traducciones7 -->
                                <div id="traducciones8">
                                  <h3 class="text-center">Item #08</h3>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="desc">Description:</label>
                                      <input type="text" name="desc8" id="desc8" class="form-control">
                                      </div>

                                      <div class="form-group destino8">
                                        <label for="dest">Target:</label>
                                        <input type="text" name="dest8" id="dest8" class="form-control" required>
                                      </div>

                                      <div class="form-group idiomas8">
                                      <label for="idiomas">Languages:</label>
                                      <select name="idiomas8" id="idiomas8" class="form-control" >
                                        <option value=""></option>
                                        <option value="SPA-ENG">SPA-ENG</option>
                                        <option value="SPA-FRE">SPA-FRE</option>
                                        <option value="SPA-POR">SPA-POR</option>
                                        <option value="SPA-GER">SPA-GER</option>
                                        <option value="SPA-ITA">SPA-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ENG-SPA">ENG-SPA</option>
                                        <option value="ENG-FRE">ENG-FRE</option>
                                        <option value="ENG-POR">ENG-POR</option>
                                        <option value="ENG-GER">ENG-GER</option>
                                        <option value="ENG-ITA">ENG-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="FRE-ENG">FRE-ENG</option>
                                        <option value="FRE-SPA">FRE-SPA</option>
                                        <option value="FRE-POR">FRE-POR</option>
                                        <option value="FRE-GER">FRE-GER</option>
                                        <option value="FRE-ITA">FRE-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="POR-SPA">POR-SPA</option>
                                        <option value="POR-ENG">POR-ENG</option>
                                        <option value="POR-FRE">POR-FRE</option>
                                        <option value="POR-GER">POR-GER</option>
                                        <option value="POR-ITA">POR-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="GER-SPA">GER-SPA</option>
                                        <option value="GER-ENG">GER-ENG</option>
                                        <option value="GER-FRE">GER-FRE</option>
                                        <option value="GER-POR">GER-POR</option>
                                        <option value="GER-ITA">GER-ITA</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="ITA-SPA">ITA-SPA</option>
                                        <option value="ITA-ENG">ITA-ENG</option>
                                        <option value="ITA-FRE">ITA-FRE</option>
                                        <option value="ITA-POR">ITA-POR</option>
                                        <option value="ITA-GER">ITA-GER</option>
                                        <option disabled="disabled">-------</option>
                                        <option value="SPA-QUE">SPA-QUE</option>
                                        <option value="QUE-SPA">QUE-SPA</option>
                                        <option value="QUECHUA">QUECHUA</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="tipo_unidad8">Unit:</label>
                                      <select name="tipo_unidad8" id="tipo_unidad8" class="form-control">
                                        <option value=""></option>
                                        <option value="word">word</option>
                                        <option value="page">page</option>
                                        <option value="document">document</option>
                                        <option value="service">service</option>
                                        <option value="minute">minute</option>
                                      </select>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="detalles8">Service</label>
                                        <select name="detalles8" id="detalles8" class="form-control" >
                                          <option value=""></option>
                                          <option value="Simple Translation of">Simple</option>
                                          <option value="Certified Translation of">Certified</option>
                                          <option value="Official Translation of ">Official</option>
                                          <option value="Transcreation of">Transcreation</option>
                                          <option value="Proofreading of">Proofreading</option>
                                          <option value="Copy Translation of">Copy</option>
                                          <option value="Delivery ">Delivery</option>
                                          <option value="Summary ">Summary</option>
                                          <option value="Transcription ">Transcription</option>
                                        </select>
                                      </div>

                                      <hr class="separadorhr"></hr>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label for="cantidad">Quantity:</label>
                                      <input type="text" name="cantidad8" class="form-control" id="cantidad8">
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Unit Price:</label>
                                      <input type="text" name="precio_unitario8" id="precio_unitario8" class="form-control" onchange='fixit(this)'>
                                      </div>

                                      <div class="form-group">
                                      <label for="precio_unitario">Price:</label>
                                      <input type="text" name="importe8" id="importe8" readonly="readonly" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                </div><!-- traducciones8 -->

                                <div class="form-group">
                                  <div style="float:left;">
                                  <button class="btn btn-success btn-add2" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  <button class="btn btn-success btn-add3" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  <button class="btn btn-success btn-add4" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  <button class="btn btn-success btn-add5" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  <button class="btn btn-success btn-add6" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  <button class="btn btn-success btn-add7" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  <button class="btn btn-success btn-add8" type="button"><span class="glyphicon glyphicon-plus"></span> ADD</button>
                                  </div>

                                  <div style="float:left; margin-left:10px;">
                                  <button class="btn btn-danger btn-remove2" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  <button class="btn btn-danger btn-remove3" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  <button class="btn btn-danger btn-remove4" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  <button class="btn btn-danger btn-remove5" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  <button class="btn btn-danger btn-remove6" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  <button class="btn btn-danger btn-remove7" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  <button class="btn btn-danger btn-remove8" type="button"><span class="glyphicon glyphicon-minus"></span> DELETE</button>
                                  </div>
                                </div>
                                <br><br>
                                <div class="col-xs-12 col-md-12">
                                  <div class="row">
                                    <div class="form-inline">
                                      <div class="checkbox">
                                        <label style="font-size: 16px;font-weight: 600;">
                                          <input type="checkbox" name="discount" id="discount" value="Si" style="margin-right: 5px;"> Promo discount: 
                                        </label>
                                      </div>
                                      <input type="text" name="dmonto" id="dmonto" class="form-control" style="display:none;width:100px;">
                                      <select name="cpr" id="cpr" class="form-control" style="display:none;">
                                        <option value="">Select code</option>
                                        <option value="TRUSTPILOT">TRUSTPILOT</option>
                                        <option value="GOOGLE">GOOGLE</option>
                                      </select>

                                      <select name="ctrust" id="ctrust" class="form-control" style="display:none;">
                                        <option value=""></option>
                                        <?php 
                                          $sql44 = "SELECT * from code_trustpilot where estado='REGISTRADO' order by idcode desc";
                                          $res44 = mysql_query($sql44);
                                          while($reg44=mysql_fetch_array($res44)){
                                            echo "<option value='".$reg44['code']."'>".$reg44['code']."</option>";
                                          }
                                        ?>
                                      </select>

                                      <select name="cgoogle" id="cgoogle" class="form-control" style="display:none;">
                                        <option value=""></option>
                                        <?php 
                                          $sql55 = "SELECT * from code_google where estado='REGISTRADO' order by idcode desc";
                                          $res55 = mysql_query($sql55);
                                          while($reg55=mysql_fetch_array($res55)){
                                            echo "<option value='".$reg55['code']."'>".$reg55['code']."</option>";
                                          }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>

                                <div style="clear: both;">
                                  <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <h3 class="text-center">Additional Details</h3>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="checkbox">
                                        <label><input type="checkbox" id="calendario" name="calendario" value="">Calendar</label>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group f1">
                                        <label>Delivery Time</label>
                                        <select class="form-control" name="fecha_entrega" id="fecha_entrega" required>
                                          <option value=""></option>
                                          <option value="1 hour">1 hour</option>
                                          <option value="3 hours">3 hours</option>
                                          <option value="6 hours">6 hours</option>
                                          <option value="12 hours">12 hours</option>
                                          <option value="24 hours">24 hours</option>
                                          <option value="48 hours">48 hours</option>
                                          <option value="3 business days">3 business days</option>
                                          <option value="4 business days">4 business days</option>
                                          <option value="5 business days">5 business days</option>
                                          <option value="6 business days">6 business days</option>
                                          <option value="7 business days">7 business days</option>
                                          <option value="8 business days">8 business days</option>
                                          <option value="9 business days">9 business days</option>
                                          <option value="10 business days">10 business days</option>
                                          <option value="11 business days">11 business days</option>
                                          <option value="12 business days">12 business days</option>
                                          <option value="13 business days">13 business days</option>
                                          <option value="14 business days">14 business days</option>
                                          <option value="15 business days">15 business days</option>
                                          <option value="16 business days">16 business days</option>
                                          <option value="17 business days">17 business days</option>
                                          <option value="18 business days">18 business days</option>
                                          <option value="19 business days">19 business days</option>
                                          <option value="20 business days">20 business days</option>
                                          <option value="21 business days">21 business days</option>
                                          <option value="22 business days">22 business days</option>
                                          <option value="23 business days">23 business days</option>
                                          <option value="24 business days">24 business days</option>
                                          <option value="25 business days">25 business days</option>
                                          <option value="26 business days">26 business days</option>
                                          <option value="27 business days">27 business days</option>
                                          <option value="28 business days">28 business days</option>
                                          <option value="29 business days">29 business days</option>
                                          <option value="30 business days">30 business days</option>
                                          <option value="40 business days">40 business days</option>
                                          <option value="60 business days">60 business days</option>
                                          <option value="1 month">1 month</option>
                                          <option value="2 months">2 months</option>
                                          <option value="3 months">3 months</option>
                                          <option value="4 months">4 months</option>
                                          <option value="5 months">5 months</option>
                                          <option value="6 months">6 months</option>
                                        </select>
                                      </div>

                                      <div class="form-group f2">
                                        <label>Delivery Date</label>
                                        <select class="form-control" name="fecha_entrega2" id="fecha_entrega2">
                                          <option value=""></option>
                                          <option value="1 hour">1 hour</option>
                                          <option value="3 hours">3 hours</option>
                                          <option value="6 hours">6 hours</option>
                                          <option value="12 hours">12 hours</option>
                                          <option value="24 hours">24 hours</option>
                                          <option value="48 hours">48 hours</option>
                                          <option value="3 calendar days">3 calendar days</option>
                                          <option value="4 calendar days">4 calendar days</option>
                                          <option value="5 calendar days">5 calendar days</option>
                                          <option value="6 calendar days">6 calendar days</option>
                                          <option value="7 calendar days">7 calendar days</option>
                                          <option value="8 calendar days">8 calendar days</option>
                                          <option value="9 calendar days">9 calendar days</option>
                                          <option value="10 calendar days">10 calendar days</option>
                                          <option value="11 calendar days">11 calendar days</option>
                                          <option value="12 calendar days">12 calendar days</option>
                                          <option value="13 calendar days">13 calendar days</option>
                                          <option value="14 calendar days">14 calendar days</option>
                                          <option value="15 calendar days">15 calendar days</option>
                                          <option value="16 calendar days">16 calendar days</option>
                                          <option value="17 calendar days">17 calendar days</option>
                                          <option value="18 calendar days">18 calendar days</option>
                                          <option value="19 calendar days">19 calendar days</option>
                                          <option value="20 calendar days">20 calendar days</option>
                                          <option value="21 calendar days">21 calendar days</option>
                                          <option value="22 calendar days">22 calendar days</option>
                                          <option value="23 calendar days">23 calendar days</option>
                                          <option value="24 calendar days">24 calendar days</option>
                                          <option value="25 calendar days">25 calendar days</option>
                                          <option value="26 calendar days">26 calendar days</option>
                                          <option value="27 calendar days">27 calendar days</option>
                                          <option value="28 calendar days">28 calendar days</option>
                                          <option value="29 calendar days">29 calendar days</option>
                                          <option value="30 calendar days">30 calendar days</option>
                                          <option value="40 calendar days">40 calendar days</option>
                                          <option value="60 calendar days">60 calendar days</option>
                                          <option value="1 month">1 month</option>
                                          <option value="2 months">2 months</option>
                                          <option value="3 months">3 months</option>
                                          <option value="4 months">4 months</option>
                                          <option value="5 months">5 months</option>
                                          <option value="6 months">6 months</option>
                                        </select>
                                      </div>


                                      <div class="form-group">
                                        <label>Payment Method</label><br>
                                        <!--
                                        <input type="text" class="form-control" name="metodo_pago">
                                        -->
                                        <select name="metodo_pago" id="metodo_pago" class="form-control" multiple="multiple" required>
                                          <option value="Full advance payment">Full advance payment</option>
                                          <option value="Full payment on delivery">Full payment on delivery</option>
                                          <option value="50% advance payment-50% payment on delivery">50% advance payment-50% payment on delivery</option>
                                          <option value="50% advance payment-50% progress payment">50% advance payment-50% progress payment</option>
                                          <option value="50% progress payment-50% payment on delivery">50% progress payment-50% payment on delivery</option>
                                          <option value="Net 7">Net 7</option>
                                          <option value="Net 15">Net 15</option>
                                          <option value="Net 30">Net 30</option>
                                        </select>
                                        <input type="hidden" id="mp2" name="mp2">
                                  
                                      </div>
                                      <div class="form-group">
                                        <label>Delivery Format</label><br>
                                        <!--
                                        <input type="text" class="form-control" name="formato_entrega">
                                        -->
                                        <select name="formato_entrega" id="formato_entrega" class="form-control" multiple="multiple" required>
                                          <option value="Word">Word</option>
                                          <option value="Excel">Excel</option>
                                          <option value="Power Point">Power Point</option>            
                                          <option value="PDF">PDF</option>
                                          <option value="Photoshop">Photoshop</option>
                                          <option value="Illustrator">Illustrator</option>
                                          <option value="InDesign">InDesign</option>
                                          <option value="Printed">Printed</option>
                                          <option value="CD/DVD">CD/DVD</option>
                                        </select>
                                        <input type="hidden" id="forment2" name="forment2">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Validity of the offer</label>
                                        <!--
                                        <input type="text" class="form-control" name="validez_oferta">
                                        -->
                                        <select name="validez_oferta" id="validez_oferta" class="form-control" required>
                                          <option value=""></option>
                                          <option value="3 days">3 days</option>
                                          <option value="15 days">15 days</option>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label>Delivery</label><br>
                                        <!--
                                        <input type="text" class="form-control" name="tipo_entrega">
                                        -->
                                        <select name="tipo_entrega" id="tipo_entrega" class="form-control" multiple="multiple" required>
                                          <option value="In Office">In Office</option>
                                          <option value="Email">Email</option>
                                          <option value="Delivery">&lt;span style="color:red"&gt;Delivery&lt;/span&gt;</option>
                                        </select>
                                        <input type="hidden" id="forma2" name="forma2">
                                      </div>
                                      <div class="form-group">
                                        <label>Notes</label>
                                        <input type="text" class="form-control" name="detalle_entrega" id="detalle_entrega">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div>
                                  <div class="row">
                                    <h3 class="text-center">Additional Documents</h3>
                                    <div class="col-md-6">            
                                      <div class="form-group">
                                        <div class="checkbox">
                                          <label><input type="checkbox" id="lady_files" name="lady_files" value="Si"><b>Attach CV and certificate - Lady Príncipe</b></label>
                                        </div>
                                        <!--
                                        <div class="checkbox">
                                          <label><input type="checkbox" id="nathaly_files" name="nathaly_files" value="Si"><b>Adjuntar CV y certificado de Nathaly Vásquez</b></label>
                                        </div>
                                        -->
                                        <div class="checkbox">
                                          <label><input type="checkbox" id="ruc_file" name="ruc_file" value="Si"><b>Attach Ficha RUC LIMAC</b></label>
                                        </div>
                                        <div class="checkbox">
                                          <label><input type="checkbox" id="rnp_file" name="rnp_file" value="Si"><b>Attach RNP R&E Traducciones</b></label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                  </div>
                                </div>
                                
                              </div><!-- col-md-9 -->
                              <div class="col-xs-12 col-md-3 colnopad">
                                <div class="total-price">
                                  <div class="form-group">
                                  <label for="subtotal">Subtotal:</label>
                                  <input type="text" readonly="readonly" class="form-control" name="subtotal" id="subtotal">
                                  </div>
                                  
                                  <div class="form-group">
                                  <label for="igv">Sales Tax 18%:</label>
                                  <input type="text" readonly="readonly" class="form-control" name="igv" id="igv"> 
                                  </div>
                                  
                                  <div class="form-group">
                                  <label for="total">Total:</label>
                                  <input type="text" readonly="readonly" class="form-control" name="total" id="total">
                                  </div>
                                </div>
                              </div><!-- col-md-3 -->
                              <div class="col-xs-12 col-md-12 colnopad">
                                <br>
                                <button class="btn btn-primary btn-md" type="submit" name="enviar">SEND</button>
                                </form>
                                <form action="scripts/preview_traduccion_en.php" method="post" target="_blank" style="display:inline-table;">

                                <input type="hidden" id="sex" name="sex">
                                <input type="hidden" id="mon" name="mon">
                                <input type="hidden" id="emp" name="emp">
                                <input type="hidden" id="ate2" name="ate2">
                                <input type="hidden" id="ate" name="ate">


                                <input type="hidden" id="name" name="name">
                                <input type="hidden" id="d1" name="d1">
                                <input type="hidden" id="c1" name="c1">
                                <input type="hidden" id="pu1" name="pu1" onchange='fixit(this)'>
                                <input type="hidden" id="i1" name="i1" readonly="readonly">
                                <input type="hidden" id="lang1" name="lang1">
                                <input type="hidden" id="serv1" name="serv1">
                                <input type="hidden" id="de1" name="de1">
                                <input type="hidden" id="tu" name="tu">

                                <input type="hidden" id="d2" name="d2">
                                <input type="hidden" id="c2" name="c2">
                                <input type="hidden" id="pu2" name="pu2" onchange='fixit(this)'>
                                <input type="hidden" id="i2" name="i2">
                                <input type="hidden" id="lang2" name="lang2">
                                <input type="hidden" id="serv2" name="serv2">
                                <input type="hidden" id="de2" name="de2">
                                <input type="hidden" id="tu2" name="tu2">

                                <input type="hidden" id="d3" name="d3">
                                <input type="hidden" id="c3" name="c3">
                                <input type="hidden" id="pu3" name="pu3" onchange='fixit(this)'>
                                <input type="hidden" id="i3" name="i3">
                                <input type="hidden" id="lang3" name="lang3">
                                <input type="hidden" id="serv3" name="serv3">
                                <input type="hidden" id="de3" name="de3">
                                <input type="hidden" id="tu3" name="tu3">

                                <input type="hidden" id="d4" name="d4">
                                <input type="hidden" id="c4" name="c4">
                                <input type="hidden" id="pu4" name="pu4" onchange='fixit(this)'>
                                <input type="hidden" id="i4" name="i4">
                                <input type="hidden" id="lang4" name="lang4">
                                <input type="hidden" id="serv4" name="serv4">
                                <input type="hidden" id="de4" name="de4">
                                <input type="hidden" id="tu4" name="tu4">

                                <input type="hidden" id="d5" name="d5">
                                <input type="hidden" id="c5" name="c5">
                                <input type="hidden" id="pu5" name="pu5" onchange='fixit(this)'>
                                <input type="hidden" id="i5" name="i5">
                                <input type="hidden" id="lang5" name="lang5">
                                <input type="hidden" id="serv5" name="serv5">
                                <input type="hidden" id="de5" name="de5">
                                <input type="hidden" id="tu5" name="tu5">

                                <input type="hidden" id="d6" name="d6">
                                <input type="hidden" id="c6" name="c6">
                                <input type="hidden" id="pu6" name="pu6" onchange='fixit(this)'>
                                <input type="hidden" id="i6" name="i6">
                                <input type="hidden" id="lang6" name="lang6">
                                <input type="hidden" id="serv6" name="serv6">
                                <input type="hidden" id="de6" name="de6">
                                <input type="hidden" id="tu6" name="tu6">

                                <input type="hidden" id="d7" name="d7">
                                <input type="hidden" id="c7" name="c7">
                                <input type="hidden" id="pu7" name="pu7" onchange='fixit(this)'>
                                <input type="hidden" id="i7" name="i7">
                                <input type="hidden" id="lang7" name="lang7">
                                <input type="hidden" id="serv7" name="serv7">
                                <input type="hidden" id="de7" name="de7">
                                <input type="hidden" id="tu7" name="tu7">

                                <input type="hidden" id="d8" name="d8">
                                <input type="hidden" id="c8" name="c8">
                                <input type="hidden" id="pu8" name="pu8" onchange='fixit(this)'>
                                <input type="hidden" id="i8" name="i8">
                                <input type="hidden" id="lang8" name="lang8">
                                <input type="hidden" id="serv8" name="serv8">
                                <input type="hidden" id="de8" name="de8">
                                <input type="hidden" id="tu8" name="tu8">

                                
                                <input type="hidden" id="sub" name="sub">
                                <input type="hidden" id="igv2" name="igv2">
                                <input type="hidden" id="tot" name="tot">

                                <input type="hidden" id="fent" name="fent">
                                <input type="hidden" id="fent2" name="fent2">
                                <input type="hidden" id="mp" name="mp">
                                <input type="hidden" id="forment" name="forment">
                                <input type="hidden" id="vo" name="vo">
                                <input type="hidden" id="forma" name="forma">
                                <input type="hidden" id="not" name="not">


                                <input type="hidden" id="de" name="de">
                                <input type="hidden" id="pay" name="pay">
                                <input type="hidden" id="tp" name="tp" value="deposito">

                                <input type="hidden" id="dc" name="dc">
                                <input type="hidden" id="dc2" name="dc2">

                                <input type="hidden" id="cpp" name="cpp">
                                <input type="hidden" id="cpt" name="cpt">
                                <input type="hidden" id="cpg" name="cpg">
                                <input type="hidden" id="fir" name="fir">
                                <input type="hidden" id="qt" name="qt" value="LIMAC">


                                <button type="submit" class="btn btn-md btn-warning">PREVIEW</button>
                                <br><br>
                                </form>
                              </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /page content -->

      </div>
    </div>
    </div>
    <?php include("../../menu_footer/footer3.php"); ?>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../../assets/js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="https://api.filepicker.io/v2/filepicker.js"></script>
    <script src="../../assets/js/bootstrap-multiselect.js"></script>
    <script src="../build/js/jsCotizacion-3.js"></script>
    <script src="../build/js/preview-2.js"></script>  
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script src="../build/js/navjs.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#formato_entrega').multiselect({
              buttonWidth: '100%',
              includeSelectAllOption: true,
                selectAllText: 'Seleccionar todo'
            });
            $('#metodo_pago').multiselect({
              buttonWidth: '100%',
              includeSelectAllOption: true,
                selectAllText: 'Seleccionar todo'
            });
            $('#tipo_entrega').multiselect({
              buttonWidth: '100%',
              enableHTML: true,
              includeSelectAllOption: true,
                selectAllText: 'Seleccionar todo'
            });
        });
    </script>


    <script type='text/javascript'>

      function fixit( obj ) {

        obj.value = parseFloat( obj.value ).toFixed( 3 )

      }

    </script>

    <script type='text/javascript'>
      $(".link-payu").hide();

      $('input[name=tipo_pago]').click(function() {
        var tp = $('input[name=tipo_pago]:checked').val();
        $('#tp').val(tp);

        if(this.value=='deposito'){
          $(".link-payu").hide();
          $("#payu").val('');
          $("#pay").val('');
        }else if(this.value=='tarjeta'){
          //$(".link-payu").val('https://www.limac.com.pe/pagos/');
          $("#payu").val('https://www.limac.com.pe/pagos/');
          $("#pay").val('https://www.limac.com.pe/pagos/');
        }
      });

      if($('input[name=firma]').is(":checked")){
        var fir = $('input[name=firma]:checked').val();
        $("#fir").val(fir);
      }

      $('input[name=firma]').click(function(){
        var fir = $('input[name=firma]:checked').val();
        $("#fir").val(fir);
      });
    </script>

    <script type="text/javascript">

      $("#empresa").click(function(event) {
        if(this.checked){
            $(".sexo").prop("disabled", true);
            $(".sexo").prop("checked", false);
            $(".sexo").removeAttr("required");
          }else{
            $(".sexo").prop("disabled", false);
            $(".sexo").attr("required", true);
            //$(".masc").prop("checked", true);
          }
      });

      $('#atencion').change(function(){
            if(this.checked)
               $('#aten').fadeIn('slow');
            else
               $('#aten').fadeOut('slow');
               $('#at').val('');
               $('#ate').val('');
        });


        $('#at').keyup(function() {
          $('#ate').val($(this).val());
      });

      $('#payu').keyup(function() {
          $('#pay').val($(this).val());
      });

      $("#tipo_unidad2").change(function() {
        var tipo_unidad = $('#tipo_unidad2').val();
          $('#tu2').val(tipo_unidad);
      });

      $("#tipo_unidad3").change(function() {
        var tipo_unidad = $('#tipo_unidad3').val();
          $('#tu3').val(tipo_unidad);
      });

      $("#tipo_unidad4").change(function() {
        var tipo_unidad = $('#tipo_unidad4').val();
          $('#tu4').val(tipo_unidad);
      });

      $("#tipo_unidad5").change(function() {
        var tipo_unidad = $('#tipo_unidad5').val();
          $('#tu5').val(tipo_unidad);
      });

      $("#tipo_unidad6").change(function() {
        var tipo_unidad = $('#tipo_unidad6').val();
          $('#tu6').val(tipo_unidad);
      });

      $("#tipo_unidad7").change(function() {
        var tipo_unidad = $('#tipo_unidad7').val();
          $('#tu7').val(tipo_unidad);
      });

      $("#tipo_unidad8").change(function() {
        var tipo_unidad = $('#tipo_unidad8').val();
          $('#tu8').val(tipo_unidad);
      });

    </script>

    <script type="text/javascript">
     var altura = $('.total-price').offset().top;
        //alert(altura);
        
        $(window).on('scroll',function(){
            if( $(window).scrollTop() > altura ){
            $('.total-price').addClass('total-price-fixed');
            } else{
            $('.total-price').removeClass('total-price-fixed');}
            });
    </script>


    <script>
      $('.f2').hide();

      $("#calendario").click(function(event) {
        if(this.checked){
            $('.f2').show();
            $('.f1').hide();
            $('#fecha_entrega').attr("required", false);
            document.getElementById('fecha_entrega').value="";
            $('#fecha_entrega2').attr("required", true);
            document.getElementById('fent').value="";
          }else{
            $('.f2').hide();
            $('.f1').show();
            $('#fecha_entrega2').attr("required", false);
            document.getElementById('fecha_entrega2').value="";
            $('#fecha_entrega').attr("required", true);
            document.getElementById('fent2').value="";
          }
      });
    </script>

    <script>
      /*$('input[name=detalles]').click(function() {

        if(this.value=='Traducción Oficial de ' && this.checked){
          $('.radio-button[value=soles]').prop('disabled', true);
          $('.radio-button[value=soles]').prop('checked', false);
          $('.radio-button[value=dolares]').prop('checked', true);
          $('#mon').val('dolares');
        } else{
          $('.radio-button[value=soles]').prop('disabled', false);
          $('.radio-button[value=dolares]').prop('checked', false);
          $('#mon').val('');
        }

      });*/

    </script>


    <script type="text/javascript"> 

    function stopRKey(evt) { 
      var evt = (evt) ? evt : ((event) ? event : null); 
      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
    } 

    document.onkeypress = stopRKey; 

    </script>


    <script>
      $("#discount").click(function(){
          var discount = $("#discount").val();
          if(this.checked){
            $("#dmonto").show();
            $("#dc").val(discount);
            $("#cpr").show();
            $("#cpr").prop("selectedIndex",0);
          } else{
            $("#dmonto").hide();
            $("#dmonto").val('');
            $("#dc").val('');
            $("#cpr").hide();
            $("#cpr").prop("selectedIndex",0);
            $("#ctrust").hide();
          $("#cgoogle").hide();
          $("#ctrust").prop("selectedIndex",0);
          $("#cgoogle").prop("selectedIndex",0);
          $("#cpp").val('');
          $("#cpt").val('');
          $("#cpg").val('');


               var cantidad = document.getElementById("cantidad").value;
             var cantidad2 = document.getElementById("cantidad2").value;
             var cantidad3 = document.getElementById("cantidad3").value;
             var cantidad4 = document.getElementById("cantidad4").value;
             var cantidad5 = document.getElementById("cantidad5").value;
             var cantidad6 = document.getElementById("cantidad6").value;
             var cantidad7 = document.getElementById("cantidad7").value;
             var cantidad8 = document.getElementById("cantidad8").value;

             var precio_unitario = document.getElementById("precio_unitario").value;
             var precio_unitario2 = document.getElementById("precio_unitario2").value;
             var precio_unitario3 = document.getElementById("precio_unitario3").value;
             var precio_unitario4 = document.getElementById("precio_unitario4").value;
             var precio_unitario5 = document.getElementById("precio_unitario5").value;
             var precio_unitario6 = document.getElementById("precio_unitario6").value;
             var precio_unitario7 = document.getElementById("precio_unitario7").value;
             var precio_unitario8 = document.getElementById("precio_unitario8").value;

             var importe = cantidad*precio_unitario;
             var importe2 = cantidad2*precio_unitario2;
             var importe3 = cantidad3*precio_unitario3;
             var importe4 = cantidad4*precio_unitario4;
             var importe5 = cantidad5*precio_unitario5;
             var importe6 = cantidad6*precio_unitario6;
             var importe7 = cantidad7*precio_unitario7;
             var importe8 = cantidad8*precio_unitario8;


             document.getElementById("importe").value=importe.toFixed(2);
             document.getElementById("i1").value=importe.toFixed(2);

             var suma =importe+importe2+importe3+importe4+importe5+importe6+importe7+importe8;
             var subtotal = suma / 1.180;
             document.getElementById("subtotal").value=subtotal.toFixed(2);
             document.getElementById("sub").value=subtotal.toFixed(2);

             var igv=subtotal*0.18;
             document.getElementById("igv").value=igv.toFixed(2);
             document.getElementById("igv2").value=igv.toFixed(2);

             var total=subtotal+igv;
             document.getElementById("total").value=total.toFixed(2);
             document.getElementById("tot").value=total.toFixed(2);

          }
        });

        //monto a descontar

        $("#dmonto").keyup(function(event){

          var dmonto = document.getElementById("dmonto").value;
          $("#dc2").val(dmonto);
          var dmonto2 = dmonto / 1.180;

         var cantidad = document.getElementById("cantidad").value;
         var cantidad2 = document.getElementById("cantidad2").value;
         var cantidad3 = document.getElementById("cantidad3").value;
         var cantidad4 = document.getElementById("cantidad4").value;
         var cantidad5 = document.getElementById("cantidad5").value;
         var cantidad6 = document.getElementById("cantidad6").value;
         var cantidad7 = document.getElementById("cantidad7").value;
         var cantidad8 = document.getElementById("cantidad8").value;

         var precio_unitario = document.getElementById("precio_unitario").value;
         var precio_unitario2 = document.getElementById("precio_unitario2").value;
         var precio_unitario3 = document.getElementById("precio_unitario3").value;
         var precio_unitario4 = document.getElementById("precio_unitario4").value;
         var precio_unitario5 = document.getElementById("precio_unitario5").value;
         var precio_unitario6 = document.getElementById("precio_unitario6").value;
         var precio_unitario7 = document.getElementById("precio_unitario7").value;
         var precio_unitario8 = document.getElementById("precio_unitario8").value;

         var importe = cantidad*precio_unitario;
         var importe2 = cantidad2*precio_unitario2;
         var importe3 = cantidad3*precio_unitario3;
         var importe4 = cantidad4*precio_unitario4;
         var importe5 = cantidad5*precio_unitario5;
         var importe6 = cantidad6*precio_unitario6;
         var importe7 = cantidad7*precio_unitario7;
         var importe8 = cantidad8*precio_unitario8;


         document.getElementById("importe").value=importe.toFixed(2);
         document.getElementById("i1").value=importe.toFixed(2);

         var suma =importe+importe2+importe3+importe4+importe5+importe6+importe7+importe8;
         var subtotal = suma / 1.180;
         var subtotal2 = subtotal - dmonto2;
         document.getElementById("subtotal").value=subtotal2.toFixed(2);
         document.getElementById("sub").value=subtotal2.toFixed(2);

         var igv=subtotal2*0.18;
         document.getElementById("igv").value=igv.toFixed(2);
         document.getElementById("igv2").value=igv.toFixed(2);

         var total=subtotal2+igv;
         document.getElementById("total").value=total.toFixed(2);
         document.getElementById("tot").value=total.toFixed(2);


        });

    </script>

    <script>
      $("#cpr").change(function(){
        var code_promo = $("#cpr").val();

        $("#cpp").val(code_promo);

        if(code_promo=='TRUSTPILOT'){
          $("#ctrust").show();
          $("#cgoogle").hide();
          $("#ctrust").prop("selectedIndex",0);
          $("#cgoogle").prop("selectedIndex",0);
        }

        if(code_promo=='GOOGLE'){
          $("#ctrust").hide();
          $("#cgoogle").show();
          $("#ctrust").prop("selectedIndex",0);
          $("#cgoogle").prop("selectedIndex",0);
        }

        if(code_promo==''){
          $("#ctrust").hide();
          $("#cgoogle").hide();
          $("#ctrust").prop("selectedIndex",0);
          $("#cgoogle").prop("selectedIndex",0);
          $("#cpp").val('');
        }

      });

      $("#ctrust").change(function(){
        var ctrust = $("#ctrust").val();
        $("#cpt").val(ctrust);
      });

      $("#cgoogle").change(function(){
        var cgoogle = $("#cgoogle").val();
        $("#cpg").val(cgoogle);
      });

      $("#trad").submit(function(){
        $(".overlay").show();
      });
    </script>
  </body>
</html>
