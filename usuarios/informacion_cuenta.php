<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO9959-1" />
<title>Constancia de estudio</title>
<style type="text/css">
.margenes td{
padding-left: 3px;
padding-right: 3px;
}
.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
	text-transform: uppercase;
	font-weight: bold;
	margin-bottom: 2px;
	text-align: left;
}
.SaltoDePagina {
PAGE-BREAK-AFTER: always
}
.cursiva {
	font-style: italic;
	font-weight: bold;
}
.cursiva {
	font-style: italic;
}
</style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
<table id="tb" width="100%" border="0" align="center">
  <tr>
    <td width="30%" ></td>
    <td width="40%" align="center">
<script type="text/javascript">
function imprimir()
	{
		//var Obj = document.getElementById("imprimir");
		//var Obj1 = document.getElementById("cerrar");
		var Obj2 = document.getElementById("tb");
		Obj2.style.display='none';
		 window.print();
		Obj2.style.display = 'table';
	}
</script>
<button type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="imprimir();"><img src="../images/icons_menu/x32/printer2_x32.png" width="24" height="24" align="absmiddle" />&nbsp;Imprimir</button>
&nbsp;
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="parent.$.fancybox.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle" />&nbsp;Cerrar</button>
</td>
    <td width="30%" align="center"></td>
  </tr>
  
</table>
<?php
function esPar($numero){
   $resto = $numero%2;
   if (($resto==0) && ($numero!=0)) {
        return true;
   }else{
        return false;
   } 
} // fin de la funcion
session_start();
if (!empty($_SESSION["id_usuario"])){
	include_once("../funciones/funcionesPHP.php");
	$id_personal=$_SESSION["id_usuario"];
?>
<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
</table>
<br />
<table width="100%" border="0">
  <tr>
    <th colspan="3" scope="col" style="border-top:1px solid rgb(42,0,0)">INFORMACI&Oacute;N DE MI CUENTA</th>
  </tr>
  <tr>
    <th scope="col">SISTEMA</th>
    <th scope="col">VERSION</th>
    <th scope="col">ESQUEMA DE COLORES</th>
  </tr>
  <tr>
    <td scope="col" align="center"><?php echo $_SESSION["app_nombre"];?></td>
    <td scope="col" align="center"><?php echo $_SESSION["app_version"];?></td>
    <td scope="col" align="center"><?php if (!empty($_SESSION["tema"])){echo $_SESSION["tema"];} else { echo "NO SELECCIONADO";}?></td>
  </tr>
  <tr>
    <td scope="col" align="center">&nbsp;</td>
    <td scope="col" align="center">&nbsp;</td>
    <td scope="col" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" scope="col" style="border-top:1px solid rgb(42,0,0)"><strong>DATOS DEL USUARIO</strong></td>
  </tr>
  <tr>
    <td align="center" scope="col"><strong>ID EN EL SISTEMA</strong></td>
    <td align="center" scope="col"><strong>NOMBRES Y APELLIDOS</strong></td>
    <td align="center" scope="col"><strong>PERTENECE A GRUPO</strong></td>
  </tr>
  <tr>
    <td align="center" scope="col"><?php echo $_SESSION["id_usuario"];?></td>
    <td align="center" scope="col"><?php echo $_SESSION["nombre_usuario"];?></td>
    <td align="center" scope="col"><?php echo $_SESSION["grupo_usu"];?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" scope="col">&nbsp;</td>
    <td align="center" scope="col">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" scope="col" style="border-top:1px solid rgb(42,0,0)"><strong>PLANTEL(ES) A LOS QUE TIENE ACCESO</strong></td>
  </tr>
  <?php 
if ($_SESSION["id_grupo_usuario"]=="G0001"){
	?>
    <tr>
    <td colspan="3" align="center" scope="col">TODOS LOS PLANTELES</td>
  </tr>
<?php
} else {
	$sql_plantel="select usuario_plantel.cod_plantel,instituciones.den_plantel,instituciones.den_plantel_corta,instituciones.id_sector_educ from (usuario_plantel
	INNER JOIN instituciones ON usuario_plantel.cod_plantel=instituciones.cod_plantel) 
	 where id_personal='$id_personal'";
	$registros=ejecuta_sql($sql_plantel,false);
?>
  <tr>
    <td colspan="2" align="left" scope="col"><strong>PLANTEL:</strong></td>
    <td align="left" scope="col"><strong>CODIGO:</strong></td>
  </tr>
 <?PHP
 	if ($registros) {
		while ($fila_plan=mysql_fetch_array($registros)){
?>
  <tr>
    <td colspan="2" align="left" scope="col"><?php echo $fila_plan["den_plantel"];?></td>
    <td align="left" scope="col"><?php echo $fila_plan["cod_plantel"];?></td>
  </tr>
 <?PHP
		} // FIN WHILE
	} // FIN ELSE
 ?>
  </table>
  <br />
<table width="100%">
  <tr>
    <td colspan="2" align="CENTER" scope="col" style="border-top:1px solid rgb(42,0,0)"><strong>EL USUARIO TIENE ACCESO A LOS SIGUIENTES M&Oacute;DULOS</strong></td>
  </tr>
  <?php 
if ($_SESSION["id_grupo_usuario"]=="G0001"){
	?>
    <tr>
    <td colspan="2" align="center" scope="col" width="50%">TODOS LOS MODULOS DEL SISTEMA</td>
  </tr>
<?php
} else {
	$sql_mod="select sis_funciones.texto_icono,sis_funciones.descrip_func,sis_funciones.icono32 from (sis_priv_grup
	INNER JOIN sis_funciones ON sis_funciones. 	id_func=sis_priv_grup.id_func) 
	 where id_grupo='".$_SESSION["id_grupo_usuario"]."'";
	 $con_fun=0;
	$registros=ejecuta_sql($sql_mod,false);
	if ($registros) {
		while ($fila_mod=mysql_fetch_array($registros)){
			$con_fun++;
			if (!esPar($con_fun)){
?>
  
  <tr>
    <td align="left" scope="col"><img src="<?php echo $_SESSION['ruta_iconos32']."/".$fila_mod["icono32"]?>"  align="absmiddle" width="24px"/>&nbsp;&nbsp;<?php echo $fila_mod["texto_icono"];?></td>

  
 <?PHP
			} // find e si no es par
			else {
				?>
    <td align="left" scope="col"><img src="<?php echo $_SESSION['ruta_iconos32']."/".$fila_mod["icono32"]?>"  align="absmiddle" width="24px"/>&nbsp;&nbsp;<?php echo $fila_mod["texto_icono"];?></td>
  </tr>
<?php
			}
		} // FIN WHILE
	} // FIN IF REGISTRO
} // FIN DE SI ES ADMINISTRADOR
 ?>
  <?php
	} // fin si hay registros
	?>	
</table>


<?php
} // fin se si hay acceso en el sistema 
else {
	echo "<h1 align=\"center\">No se ha iniciado sesi&oacute;n en el sistema</h1>";
}
?>
</body>
</html>