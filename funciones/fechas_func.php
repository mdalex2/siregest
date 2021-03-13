<?php
//esta funcion devuelve los 

function obtener_mes_num($mes_letra){
	$mes_mayuscula=strtoupper($mes_letra);
	$arr = array(1 => "ENERO", 2 => "FEBRERO", 3 => "MARZO",4 => "ABRIL",
	5=>"MAYO",6=>"JUNIO",7=>"JULIO",8=>"AGOSTO",9=>"SEPTIEMBRE",10=>"OCTUBRE",
	11=>"NOVIEMBRE", 12 => "DICIEMBRE");
	foreach($arr as $num=>$valor){
     //echo "<p>El vector con indice $num tiene el valor $valor </p>";
	 if ($valor==$mes_mayuscula){
	  	return $num;
		exit();}
	  }
	 }
	function obtener_mes_letras($mes_num){
	$arr = array(1 => "ENERO", 2 => "FEBRERO", 3 => "MARZO",4 => "ABRIL",
	5=>"MAYO",6=>"JUNIO",7=>"JULIO",8=>"AGOSTO",9=>"SEPTIEMBRE",10=>"OCTUBRE",
	11=>"NOVIEMBRE", 12 => "DICIEMBRE");
	foreach($arr as $num=>$valor){
    //echo "<p>El vector con indice $num tiene el valor $valor </p>";
	 if ($num==$mes_num){
	  	return $valor;
		}
	  } 
	  }
?>