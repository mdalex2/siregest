<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<p>
<?php

	require "funciones/encriptado.php";
  	   $clave="#S¡R3G3ST_20||--";
       $valorEncriptado = encriptar('localhost', $clave);
       $valorOriginal = desencriptar($valorEncriptado, $clave);
        echo "Encriptado: <code style='color:#ff0000;'>{$valorEncriptado}</code>";
        echo "<br/>";
        echo "Original: <code style='color:#009922;'>{$valorOriginal}</code><br>";
		
		
#Abrimos el fichero en modo de escritura 
$DescriptorFichero = fopen("config.txt","w+"); 

#Escribimos la primera línea dentro de él 
$string1 = $valorEncriptado; 
fputs($DescriptorFichero,$string1); 

/*#Escribimos la segunda línea de texto 
$string2 = $valorOriginal; 
fputs($DescriptorFichero,$string2); */

#Cerramos el fichero 
fclose($DescriptorFichero); 

#leer el archivo
$archivo = file("config.txt"); //creamos el array con las lineas del archivo
$lineas = count($archivo); //contamos los elementos del array, es decir el total de lineas
for($i=0; $i < $lineas; $i++){
echo "ARCHIVO LEIDO: ".desencriptar($archivo[$i],$clave);}
?>
    
</p>
<p>&nbsp;</p>
</body>
</html>