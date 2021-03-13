
<?php
error_reporting(0);
include_once("../funciones/funcionesPHP.php");
session_destroy();
session_id("siregest");
session_start();
session_cache_limiter('nocache,private'); //evita mensaje de sesion expirada al presionar atras en el navegador
//declaro la variable que ayuda a bloquear el usuario si ingresa 5 veces incorrecta la clave (IA=intentos de acceso)
if (!isset($_SESSION["IR"])){$_SESSION["IR"]=5;}
if (empty($_POST["log"])) {
	echo '<script language="JavaScript" type="text/javascript">
	alert("Debe escribir el nombre de usuario para acceder al sistema");
javascript:history.go(-1);
</script>';
} else {
		$login=eliminar_comillas($_POST["log"]);
if (empty($_POST["pwd"])) {
	echo '<script language="JavaScript" type="text/javascript">
	alert("Debe escribir la clave de acceso al sistema");
javascript:history.go(-1);
</script>';
} else {
		$pwd=eliminar_comillas($_POST["pwd"]);

		//$pwd_encript=AES_ENCRYPT(string,key_string);
	  //$pwd_decript=AES_DECRYPT(string,key_string)
	$sql_acceso="select id_usuario,id_grupo_cuenta,login,bloqueado,datos_per.nombres,datos_per.apellidos,sis_grupos.nombre_grupo_usuario from (usuarios
	INNER JOIN datos_per on usuarios.id_usuario=datos_per.id_personal
	INNER JOIN sis_grupos ON sis_grupos.id_grupo=usuarios.id_grupo_cuenta
	) where login='$login' and AES_DECRYPT(clave,'$pwd')='$pwd'";
	$registros=ejecuta_sql($sql_acceso,false);
	if ($registros && mysql_num_rows($registros)==1){
	while ($fila=mysql_fetch_array($registros)){
		if ($fila["bloqueado"]==true) {
			$_SESSION["err"]="UB";
			header("location:../acceso_sis/clave_acceso.php");
			exit();
			}
	include_once("../funciones/aplica_config_global.php");
	$_SESSION["app_version"]="Vers. 2014.1";
	$_SESSION["app_nombre"]="SIREGEST";
	$_SESSION['var_menu']="";
	$_SESSION["ultimo_acceso"]=date("Y-n-j H:i:s");
	$_SESSION['logueado_siregest']=true; // si se cambia este nombre de sesion se debe cambiar los demas que existen en el sistio web tambien en el archivo funcinones y adicionales
	$_SESSION['id_grupo_usuario']=$fila['id_grupo_cuenta'];
	$_SESSION['login']=$login;
	$_SESSION['id_usuario']=$fila["id_usuario"];
	$_SESSION['grupo_usu']=$fila["nombre_grupo_usuario"];
	$_SESSION['nombre_usuario']=$fila["nombres"]." ".$fila["apellidos"];
	$_SESSION["sep_ced_per"]="-";
	$_SESSION["E1"]="REPÚBLICA BOLIVARIANA DE VENEZUELA";
	$_SESSION["E2"]="MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN";
	 //si la cookie del tema es vacio pongo el tema predeterminado de lo contrario pongo el tema almacenado en la cookie
	if (empty($_COOKIE["tema"])){
	$_SESSION["tema"]="siregest"; //variable que controla el color del tema 
	}
	else
	{$_SESSION["tema"]=$_COOKIE["tema"];}
	//$_SESSION['juego_caracteres']="ISO-8859-9";	
	$_SESSION['juego_caracteres']="utf-8";	
	//variable de la caprtea personal donde se almacenan los archivos fotos documentos etc
	$_SESSION["carp_per_fotos"]="../images/perfiles/fotos/";
  $_SESSION['ruta_iconos32']="../images/icons_menu/x32/";	 // ruta de la carpeta de los iconos de 32 pixeles
  $_SESSION['ruta_iconos48']="../images/icons_menu/x48/";	 // ruta de la carpeta de los iconos de 32 pixeles	
	unset($_SESSION['err']);//libero la variable error para que no muestre otro error
	include_once("../acceso_sis/verifica_plantel_login.php");
	if ((verifica_plantel()==true) or ($_SESSION['id_grupo_usuario']=="G0001")){
		header("location:../acceso_sis/menu_principal.php?".$_SESSION['id_grupo_usuario']);
		enviar_email_inicio();
	exit();
	} else {
		header("location:../acceso_sis/selecciona_plantel.php?".$_SESSION['id_grupo_usuario']);
		exit();
	}
	} // fin del while
	}// fin de si hay registros o si se hizo ingresó usuario y clave correctos
	 else { 
		 verifica_bloq_login($login);
	 // si no se enocntraron registros
		$_SESSION["err"]="1";
		
		header("location:../acceso_sis/clave_acceso.php?login=$login");
		exit();
	}
}
	} // fin de si no es vacio
//--------------------------------------------------	
	function verifica_bloq_login($login){
		$sql_str="select id_usuario from usuarios where login='$login'";
		unset($_SESSION["mos_int_acc"]);
		$registros=ejecuta_sql($sql_str,true);
		if ($registros){
			//variable de mostrar o no mensaje de intentos de acceso restantes
			$_SESSION["mos_int_acc"]=true;
			//IR=intentos restantes
			$_SESSION["IR"]--;
			if ($_SESSION["IR"]==0){
					unset($_SESSION["IR"]);
					$_SESSION["err"]="UB";
					bloquear_usuario($login);
					header("location:../acceso_sis/clave_acceso.php?login=$login");
					exit();
				} 
			
	} // fin si hay registros
	else echo mysql_error();
	} // fin de la funcion
//----------------------------------------------------
	function bloquear_usuario($login){
		$sql_str="update usuarios set bloqueado=true where login='$login' and login<>'admin'";
		$bloqueado=ejecuta_sql($sql_str,false);
		if ($bloqueado){return true;} else {return false;}
	}
?>