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


<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
</table>
<br /><br />
<span class="titulo">LISTADO DE RECAUDOS PARA INSCRIPCI&Oacute;N</span>
<?php
include_once("../funciones/funcionesPHP.php");
$sql="select id_tip_recaudo ,descrip_recaudo,tip_recaudos.todos, tip_recaudos.visible,tip_recaudos.observaciones,tip_recaudos.fecha_g,datos_per.nombres,datos_per.apellidos,grados_esc.grado_letras from (tip_recaudos 
		INNER JOIN datos_per on datos_per.id_personal=tip_recaudos.guardado_por
 		INNER JOIN grados_esc ON grados_esc.cod_grado=tip_recaudos.cod_grado) ORDER BY grados_esc.grado_letras,descrip_recaudo ASC";
$cons_reca=ejecuta_sql($sql,true);
if ($cons_reca){
?>
<table class="margenes mouse_hover" width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal; text-transform:uppercase;">
<thead>
  <tr>
    <th align="left">GRADO</th>
    <th align="left">RECAUDO</th>
    <th align="left">OBSERVACIONES</th>
    <th align="left">ESTATUS</th>
  </tr>
  </thead>
  <?php
	while ($fila_reca=mysql_fetch_array($cons_reca)){
		if ($fila_reca["todos"]==true){
			$grado="TODOS";
		} else {
			$grado=$fila_reca["grado_letras"];
		}
		$recaudo=$fila_reca["descrip_recaudo"];
		$obs=$fila_reca["observaciones"];
		
	?>
  <tr>
    <td><?php echo $grado;?></td>
    <td><?php echo $recaudo;?></td>
    <td><?php echo $obs;?></td>
    <td><?php 
			if ($fila_reca["visible"]==true){
				echo "ACTIVO";
			} else {
			echo "DESHABILITADO";}
		?></td>
  </tr>
  <?php
	}
	?>
</table>
<?php
}
?>
</body>
</html>