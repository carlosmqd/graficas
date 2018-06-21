<?php 
 include("../conexion.php");
//acc2018 y acp2018 cambiar cada año acp2019..


$idarea=0;

    if(isset($_GET['id']))
    {
        $idarea=$_GET['id'];
        
    }
	
    if(isset($_GET['pos']))
    {
         $location=$_GET['pos'];
       
	}




// Querys  

$lpsv[]=0;
$lps[]=0;
$lpsc[]=0;
$lpsp[]=0;
$lpst[]=0;
 $sqlacc ="SELECT count(*) as accidente from accidente where year(now())=year(fecha) and comprobado=1";
//en evaluadas fecha vencida ";

$resultlacc= mysqli_query($con,$sqlacc)or die(mysqli_error());
  
  
  
 
  while($rowacc=mysqli_fetch_array($resultlacc)) {
	  
	  echo "ac".$ac=$rowacc['accidente'];
  }


  $sql ="select count(*) as t from linea WHERE idarea='$idarea' and sam=1 ";
//en evaluadas fecha vencida ";

$resultl= mysqli_query($con,$sql)or die(mysqli_error());
  
 
  while($row=mysqli_fetch_array($resultl)) {
   $t = $row['t'];
  }

  
  // mse-lps
  
  
 $sql ="select * from linea WHERE idarea='$idarea' and sam=1  ";
//en evaluadas fecha vencida ";

$resultl= mysqli_query($con,$sql)or die(mysqli_error());
  
 $lpsi=0;
  while($row=mysqli_fetch_array($resultl)) {
      
  echo"lps";
  echo $lps[$lpsi] = $row['linea'];
  echo"lpsc";
    echo $lpsc[$lpsi] = (int)$row['acc2018'];
 echo"lpsp";
  echo $lpsp[$lpsi] = (int)$row['acp2018'];

 // echo "<br><br>";
  
 
  
 

 
 //----------------------------------------------resolver ----------------------------------------------
   echo "prod1".$lpst[$lpsi]= (int)$ac-$lpsc[$lpsi] - $lpsp[$lpsi];
  echo "total1".$lpst[$lpsi];
  
  $lpsi=$lpsi+1;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HSE</title>

    <!-- Bootstrap -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/isotope.css" media="screen" />	
	<link rel="stylesheet" href="../../css/animate.css">
	<link rel="stylesheet" href="../../js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
	<link href="../../css/style.css" rel="stylesheet">	
     <link rel="stylesheet" href="dist/datepicker.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
          .thumb {
            height: 200;
			width: 200;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
        </style>
  </head>
  <body>
	<header>
		<nav div style="height:17px"  role="navigation">
        
        <IMG style="width:100%" SRC="../../Img/header.png" align="left">
    </nav>
		
		<nav class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="navigation">
				<div class="container">					
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse.collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="navbar-brand">
							
						</div>
					</div>
					
					<div class="navbar-collapse collapse">							
						<div class="menu">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation"><a href="../../Administrador.html" >Inicio</a></li>
								<li role="presentation"><a href="../../registro.html">Registro de Accidentes</a></li>
								<li role="presentation"><a href="vistasam.php">SAM</a></li>		
                                <li role="presentation"><a href="reporte.php"class="active">Reporte</a></li>	
								<li><a href="../../Cerrar">Cerrar Sesión</a></li>	</ul>
						</div>
					</div>						
				</div>
			</div>	
		</nav>		
	</header>










<script src="https://code.highcharts.com/highcharts.js"></script>


<script src="https://code.highcharts.com/modules/exporting.js"></script>
<br></br>

<br>
<div class="form-group">
<center><select  style="width:70%" class="form-control"  id="myselect" name="area" onchange="window.location='reporte_prueba.php?id='+this.value+'&pos='+this.selectedIndex;" required> 
			<option value="">Area</option>
		   <?php $i=0;
                       
			$result = mysqli_query($con,"SELECT DISTINCT area.idarea,area FROM linea,area where linea.sam=1 and linea.idarea=area.idarea  ") or die("Error: ".mysqli_error($con));
		
		   while($row = mysqli_fetch_array($result)){?>

      
				  <?php if($i+1 ==  $location){  ?>  
			  
                                 <option value="<?php echo $row['idarea'];?>" selected="selected"><?php echo $row['area'];?></option>
				 <?php } else {  ?>
                             <option value="<?php echo $row['idarea'];?>"><?php echo $row['area'];?></option>     
           <?php } $i=$i+1; }  ?>
            
            
			 </select></center>
			 </div>
			 <br>
<center><div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div></center>




  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/wow.min.js"></script>
	<script src="../../js/fancybox/jquery.fancybox.pack.js"></script>
	<script src="../../js/jquery.isotope.min.js"></script>
	<script src="../../js/jquery.bxslider.min.js"></script>
	<script src="../../js/functions.js"></script>
	<script src="../dist/datepicker.js"></script>

<script>
Highcharts.chart('container2', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Porcentaje de accidentes evaluados en Lineas '
  },
  xAxis: {
    categories: ["<?php echo join($lps, '","') ?>"]
  },
  yAxis: {
    min: 0,
    title: {
      text: 'porcentaje de accidentes'
    }
  },
  tooltip: {
    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
    shared: true
  },
  plotOptions: {
    column: {
      stacking: 'percent'
    }
  },
  series: [{
     name: 'Cerradas',
	color:'green',
    data: [<?php  echo join($lpsc, ",") ?>]
  }, {
     name: 'En proceso',
	color:'blue',
    data: [<?php  echo join($lpsp, ",") ?>]
	 
	 }, {
     name: 'Fecha vencida',
	color:'red',
    data: [<?php  echo join($lpsv, ",") ?>]
   },
   {
     name: 'Sin revisar',
	color:'gray',
    data: [<?php  echo join($lpst, ",") ?>]
   }]
});
</script>
