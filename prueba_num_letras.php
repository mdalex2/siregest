<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
	include_once("/funciones/num_letras.php");
	
	$var=num2letras(18);
	$var1='a';
	$var2=12;
	$var3=17;
	echo "$var<br/>";
	echo num2letras($var1)."<br/>";
	echo num2letras($var2)."<br/>";
	echo num2letras($var3)."<br/>";
?>
</body>
</html>