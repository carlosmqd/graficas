
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
//funcion contar accidentes vencidos 

function verifica($id,$linea,$con,$d){
	$n[1]=0;
	if($d==1){
	$sqln =  "SELECT count(*)as t FROM `registro_sam` where idaccidente='$id' and idlinea='$linea' and year(fecha_compromiso)= year(now()) ";
	$result= mysqli_query($con,$sqln)or die(mysqli_error());
	while($row=mysqli_fetch_array($result)) {
	  
	   $n[0]=(int)$row['t'];
	   if($n[0] > 0){
	   $n[1]=$n[1]+1;}
	}
	}else if($d==2){

$sqln =  "SELECT count(*)as t FROM `registro_sam` where idaccidente='$id' and idlinea='$linea' and year(fecha_compromiso)= year(now()) and estado='$d'";
	$result= mysqli_query($con,$sqln)or die(mysqli_error());
	while($row=mysqli_fetch_array($result)) {
	  
	   $n[0]=$row['t'];
	   if($n[0] > 0){
	   $n[1]=$n[1]+1;}
		}
  }
	return $n;
}

//Querys Fechas vencidas
//+ de 17 dias
$vacio1 = mysqli_num_rows(mysqli_query($con,"SELECT idaccidente FROM `accidente` where year(fecha)=year(now()) and fecha < DATE_SUB(CURDATE(), INTERVAL 17 DAY) and fecha >= DATE_SUB(CURDATE(), INTERVAL 47 DAY)"));
$vacio2 = mysqli_num_rows(mysqli_query($con,"SELECT idaccidente FROM `accidente` where year(fecha)=year(now()) and  fecha < DATE_SUB(CURDATE(), INTERVAL 47 DAY)"));

$sql ="SELECT idaccidente FROM `accidente` where year(fecha)=year(now()) and fecha < DATE_SUB(CURDATE(), INTERVAL 17 DAY) and fecha >= DATE_SUB(CURDATE(), INTERVAL 47 DAY) ";
$result= mysqli_query($con,$sql)or die(mysqli_error());

  $idacci[]=null;
  $idacci2[]=null;
  while($row=mysqli_fetch_array($result)) {
	  
	 $idacci[]=$row['idaccidente']; 
  }
  //+ de 47 dias
  $sql ="SELECT idaccidente FROM `accidente` where year(fecha)=year(now()) and  fecha < DATE_SUB(CURDATE(), INTERVAL 47 DAY)";
$result= mysqli_query($con,$sql)or die(mysqli_error());

 
  while($row=mysqli_fetch_array($result)) {
	  
	  $idacci2[]=$row['idaccidente']; 
  }

// Querys  


 $sqlacc ="SELECT count(*) as accidente from accidente where year(now())=year(fecha) and comprobado=1";
//en evaluadas fecha vencida ";

$resultlacc= mysqli_query($con,$sqlacc)or die(mysqli_error());
  
  
  
 
  while($rowacc=mysqli_fetch_array($resultlacc)) {
	  
	   $ac=$rowacc['accidente'];
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
  echo $lps[] = $row['linea'];
  echo"lpsc";
    echo $lpsc[] = (int)$row['acc2018'];
 echo"lpsp";
  echo $lpsp[] = (int)$row['acp2018'];
 
 // echo "<br><br>";
  
 
  
  //accidentes vencidos
  
$cont=0;
$zt=0;
$z1=0;
$z2=0;
//contador fechas venidas 17 dias
 //echo "cont17: ";
  foreach($idacci as $a){
	   $a;	 
	  
	  $v= verifica($a,$row['idlinea'],$con,1);//verifica si 
	   
	  
	
	    $cont= $cont + (int)$v[0];
	
	if($vacio1== 0){
		
	}else {
	$z1=$vacio1;}
  }
 
//echo "<br>cont47: ";
 foreach($idacci2 as $a){
	   $a;	 
	 
	 $v2=verifica($a,$row['idlinea'],$con,2);
	 
	
	      $cont= $cont +  (int)$v2[0];
	if($vacio2== 0){
		
	}else {
	$z2=$vacio2;}
  }
 $zt=$z1+$z2;
 
 
 $tfv=$zt - $cont;

 $lpsv[$lpsi]=$tfv;
 
 //----------------------------------------------resolver ----------------------------------------------
   echo "prod1".$lpst[$lpsi]= (int)$ac-$lpsc[$lpsi] - $lpsp[$lpsi]-$lpsv[$lpsi];
  echo "total1".$lpst[$lpsi];
  if ($lpst[$lpsi] <0 ){
	  echo "prod2".$lpsp[$lpsi]= (int)$lpsp[$lpsi]-$lpsv[$lpsi];
	 echo "total".$lpst[$lpsi]= (int)$ac-$lpsc[$lpsi] - $lpsp[$lpsi]-$lpsv[$lpsi];
  }
  if ($lpsp[$lpsi] <0 ){
	 echo "prod2".$lpsp[$lpsi]= 0;
	 echo "total2".$lpst[$lpsi]= (int)$ac-$lpsc[$lpsi] - $lpsp[$lpsi]-$lpsv[$lpsi];
  }
  //-------------------------------------------/resolver-------------------------------------------------
  $lpsi=$lpsi+1;
  }
 
  //insertar fecha vencida
   
   function insertarv($area,$valor,$con){
	   
	   $sql ="Update area set fechav2018='$valor' where idarea = '$area'";
	    mysqli_query($con,$sql)or die(mysqli_error());
   }

  //fechas vencidas por Area
  
  function vencidas($area,$acc,$acc2,$vacio,$con ){
	  $tfv=0;
	  //$linea[]=null;
	  $sql= "Select * from linea where idarea = $area and sam=1";
	  $result=mysqli_query($con,$sql)or die(mysqli_error());
	  while($row=mysqli_fetch_array($result)){
		  $linea[]=$row['idlinea'];
	  }
	  foreach($linea as $lin){
		  $cont=0;
		  $z1=0;$z2=0;$zt=0;
		  
		foreach($acc as $ac1){
			  $v=verifica($ac1,$lin,$con,1);
			  $cont=$cont+$v[0];
			  if($vacio[0]==0){}else{
				  $z1=$vacio[0];
			  }
		 }
		foreach($acc2 as $ac2){
			  $v=verifica($ac2,$lin,$con,2);
			  $cont=$cont+$v[0];
			  if($vacio[1]==0){}else{
				  $z2=$vacio[1];
		} 
			  }
		$zt=$z1+$z2;
		
		$tfv=$zt-$cont+$tfv;
	
		
	}  
	
	return $tfv;
  }
  $vac[0]=$vacio1;
  $vac[1]=$vacio2;
  $accident=  $idacci ;
  $accident2= $idacci2 ;
  
   $sqlare ="SELECT idarea,area from area ";

$resultare= mysqli_query($con,$sqlare)or die(mysqli_error());
  
 
  while($roware=mysqli_fetch_array($resultare)) {
   $areas[] = $roware['area'];
   $idareas[] = $roware['idarea'];
   
  }
 // echo "----------------------------------------Vencidas------------------------------------------";
  
   foreach($idareas as $ar){
       insertarv($ar,vencidas($ar, $accident ,$accident2, $vac,$con) ,$con);
	   
   }
  //echo "<br>";
 // echo "------------------------------------------------------------------------------------------";
  
   // Consulta por Area 
  
  function consultav($area,$con){
	  
	  $sql="SELECT fechav2018 FROM `area` where idarea ='$area' ";
      $result= mysqli_query($con,$sql) or die (mysqli_error());
	  while($row=mysqli_fetch_array($result)) {
	   $total=$row[0];
	  }
	  return (int)$total;
  }
  
  // echo "----------------------------------------Fechas Vencidas-----------------------------------";
   
   //Consultar vencidos
   $k=0;
   foreach($idareas as $ar){
    $acv[$k]=consultav($ar,$con);
   //echo "||";
  $k=$k+1;
   }
  // echo "------------------------------------------------------------------------------------------";
 //echo "------------------------------------------------------Areas`
 
  $j=0;
   $i=0;
 foreach($idareas as $ar){
 //MSE-FS-LPS\
 $areas[$j];
// echo "(";
  $ar ;
 //echo ")";

$sql ="SELECT count(idlinea)as total,sum(acc2018) as cerrados,sum(acp2018) as evaluados FROM `linea` where idarea='$ar' and sam=1";
//SELECT sum(acc2018)as cerrados,sum(acp2018)as evaluados FROM `linea` where idarea=$idarea and acc2018 = 10

$resultl= mysqli_query($con,$sql)or die(mysqli_error());
  

  while($row=mysqli_fetch_array($resultl)) {
    $accc[$i] = $row['cerrados'];
  // echo"|";
    $acp[$i] = $row['evaluados'];
   //echo "|";
  $total[$i] = $row['total']*$ac;
  
 $ane[$i]  =  $ac- $accc[$i] - $acp[$i] ;
 $acvf[$i]=$total[$i]-($accc[$i]+$acp[$i]+$acv[$i]);
  if($acvf[$i]<0){ 
   
     $acp[$i]=0;
    $acvf[$i]=$total[$i]-($accc[$i]+$acp[$i]+$acv[$i]) ;
  }
 //echo "|";
  $acvf[$i];
   //echo "/";
  // echo "==";
   $sr[$i]=$total[$i] -$accc[$i]-$acp[$i]-$acvf[$i];
 $i=$i+1; 
  }
  //--------------totalMSE-LPS---------------------
  //echo "<br>";
  $j=$j+1;
 //--------------/totalMSE-LPS----------------------
 }
    // echo "------------------------------------------------------------------------------------------";
 foreach($lpsc as $ce){
 echo $ce;
 }
 echo "<br>";
  foreach($lpsp as $pr){
 echo $pr;
 }
 echo "<br>";
  foreach($lpsv as $ve){
 echo $ve;
 }
 echo "<br>";
  foreach($lpst as $to){
 echo $to;
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
<center><div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div></center>
<br>
<div class="form-group">
<center><select  style="width:70%" class="form-control"  id="myselect" name="area" onchange="window.location='reporte.php?id='+this.value+'&pos='+this.selectedIndex;" required> 
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
Highcharts.chart('container1', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Porcentaje de accidentes evaluados en TIP '
  },
  xAxis: {
   categories: ["<?php echo join($areas, '","') ?>"]
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
  series:  [{
    name: 'Cerradas',
	color:'green',
    data: [<?php  echo join($accc, ",") ?>]
  }, {
    name: 'En proceso',
	color:'blue',
    data: [<?php  echo join($acp, ",") ?>]
  },{
    name: 'Fecha vencida',
	color:'red',
    data: [<?php  echo join($acv, ",") ?>]
  },  {
    name: 'Sin revisar',
	color:'gray',
   data: [<?php  echo join($acvf, ",") ?>]
  }]
});
</script>
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
