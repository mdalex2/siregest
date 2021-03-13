<?php
//error_reporting(0);
	   require "../funciones/encriptado.php";
  	   $llave_encriptar='!%&$SisTemas2012#!?';
       # el /n es para agregar una nueva linea al final asi el archivo se leeria linea a linea
	   $servidor=encriptar($_POST['txt_servidor'],  $llave_encriptar)."\n";
	   $base_datos=encriptar($_POST['txt_bd'],  $llave_encriptar)."\n";
	   $id_usuario=encriptar($_POST['txt_id_usu'],  $llave_encriptar)."\n";
	   $clave_servidor=encriptar($_POST['txt_clave'],  $llave_encriptar)."\n";
	   /*
	   $valorOrig_servidor = desencriptar($servidor, $llave_encriptar);
        echo "Encriptado server: <code style='color:#ff0000;'>{$servidor}<br></code>";
		echo "Encriptado base datos: <code style='color:#ff0000;'>{$base_datos}<br></code>";
		echo "Encriptado id usuario: <code style='color:#ff0000;'>{$id_usuario}<br></code>";
		echo "Encriptado clave: <code style='color:#ff0000;'>{$clave_servidor}<br></code>";
		
        #echo "<br/>";
        echo "Original server: <code style='color:#009922;'>{$valorOrig_servidor}</code><br>";
*/		
		
#Abrimos el fichero en modo de escritura 
$DescriptorFichero = fopen("../configuraciones/config.server","w+"); 

#Escribimos la primera línea dentro de él 
#$string1 = $servidor; 
fputs($DescriptorFichero,$servidor); 
fputs($DescriptorFichero,$base_datos); 
fputs($DescriptorFichero,$id_usuario); 
fputs($DescriptorFichero,$clave_servidor); 

#Cerramos el fichero 
fclose($DescriptorFichero); 

#leer el archivo
/*
$archivo = file("../configuraciones/config.txt"); //creamos el array con las lineas del archivo
$lineas = count($archivo); //contamos los elementos del array, es decir el total de lineas
for($i=0; $i < $lineas; $i++){
	$datos=desencriptar($archivo[$i],$llave_encriptar);
echo "ARCHIVO LEIDO linea $i:".$datos."<br>";}
*/
$link = mysql_connect($_POST['txt_servidor'], $_POST['txt_id_usu'],$_POST['txt_clave'], $_POST['txt_bd']);
   if (!$link){
	   /*
	   echo '<script>alert("Error al conectar al servidor los datos son incorrectos, verifíquelos e intente de nuevo");</script>';
	   echo '<script>setTimeout("history.back(1)",-0);</script>';
	   exit();*/
	   header("location:archivo_conexion_form.php?error=NCS&servidor=".$_POST['txt_servidor']."&id_usu=".$_POST["txt_id_usu"]."&bd=".$_POST['txt_bd']);
	   exit();

   }
   if (!mysql_select_db($_POST['txt_bd'],$link)){
	   	   header("location:archivo_conexion_form.php?error=ESBD&servidor=".$_POST['txt_servidor']."&id_usu=".$_POST["txt_id_usu"]."&bd=".$_POST['txt_bd']);
	       exit();
		}
else
			{
	   	   header("location:archivo_conexion_form.php?error=E0");
	       exit();
			}
?>
