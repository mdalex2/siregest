<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php
include_once("../funciones/funcionesPHP.php");
$sql_grup_usu="SELECT id_grupo,nombre_grupo_usuario FROM sis_grupos ORDER BY nombre_grupo_usuario ASC";
$cons_grup=ejecuta_sql($sql_grup_usu,true);
if ($cons_grup){
	while ($fil_grupos=mysql_fetch_array($cons_grup)){
		$id_grup_usu=$fil_grupos["id_grupo"];
		$nombre_grupo_usuario=$fil_grupos["nombre_grupo_usuario"];
		echo "PRIVILEGIOS PARA GRUPO DE USUARIO: ".$nombre_grupo_usuario."<br>";
		$sql_accesos="SELECT  sis_funciones.texto_icono,sis_priv_grup.* FROM (sis_priv_grup 
		INNER JOIN sis_funciones ON sis_funciones.id_func=sis_priv_grup.id_func
		) WHERE sis_priv_grup.id_grupo='$id_grup_usu' ORDER BY sis_funciones.texto_icono ASC
	";
		$cons_privilegios=ejecuta_sql($sql_accesos,true);
		if ($cons_privilegios){
?>
 <table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal;">
 <tr>
   <td rowspan="2">Funci&oacute;n</td>
   <td colspan="7" align="center">Privilegios de acceso</td>
   </tr>
 <tr>
 	<td style="text-align: center">Mostrar</td>
  <td style="text-align: center">Crear</td>
  <td style="text-align: center">Editar</td>
  <td style="text-align: center">Eliminar</td>
  <td style="text-align: center">Imprimir</td>
  <td style="text-align: center">Exportar</td>
  <td style="text-align: center">Otro</td>
 </tr>
 <?php
			while ($fil_privilegios=mysql_fetch_array($cons_privilegios)){
				$funcion=trans_texto($fil_privilegios["texto_icono"],"TI");
				$id_grupo=$fil_privilegios["id_grupo"];
				?>
        <tr>
        <td><?php echo $funcion; ?></td>
        <td align="center"><?PHP if ($fil_privilegios["mostrar"]){echo "SI";} else {echo "NO";}?></td>
        <td align="center"><?PHP if ($fil_privilegios["crear"]){echo "SI";} else {echo "NO";}?></td>
        <td align="center"><?PHP if ($fil_privilegios["editar"]){echo "SI";} else {echo "NO";}?></td>
        <td align="center"><?PHP if ($fil_privilegios["eliminar"]){echo "SI";} else {echo "NO";}?></td>
        <td align="center"><?PHP if ($fil_privilegios["imprimir"]){echo "SI";} else {echo "NO";}?></td>
        <td align="center"><?PHP if ($fil_privilegios["exportar"]){echo "SI";} else {echo "NO";}?></td>
        <td align="center"><?PHP if ($fil_privilegios["otro"]){echo "SI";} else {echo "NO";}?></td>
       </tr>
        <?php
			} // fin while priilegios
			?>
</table><br />
<?php
		}
	} // fin while grupos usuario

} else {
	echo "No se pudo efectuar la consulta de grupos";
}

?>
</body>
</html>