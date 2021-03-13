<?php
function detectar_resolucion(){

if(!isset($_GET['r']))
{
	$PHP_SELF=$_SERVER['PHP_SELF'];
echo "<script language=\"JavaScript\">
<!-- 
document.location=\"$PHP_SELF?r=1&Ancho=\"+screen.width+\"&Alto=\"+screen.height;
//-->
</script>";
}
else {  

// Código a mostrar en caso que se detecte la resolución de la pantalla
     if(isset($_GET['Ancho']) && isset($_GET['Alto'])) {
               // Resolución detectada
			   $ancho=$_GET['Ancho'];
			   $alto=$_GET['Alto'];
			   return array($ancho,$alto);
			   
     }
     else {
		 	return array(0,0);
               // Resolución no detectada
     }
}
}
?>
