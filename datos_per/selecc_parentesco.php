<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<?php
if (isset($_GET["id_per"])){
	$consulta_edit=ejecuta_sql("select id_personal,num_identificacion,fecha_nac,nombres,apellidos,foto_perfil,sexo,fecha_nac,tip_doc_per.tipo_doc_abr,terr_nacionalidad.nacionalidad from (datos_per
	INNER JOIN tip_doc_per on tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN terr_nacionalidad on terr_nacionalidad.cod_nac=datos_per.cod_nac
	) where id_personal='".$_GET["id_rep"]."'",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$id_personal=$registro["id_personal"];
	$tipo_doc_abr=$registro["tipo_doc_abr"];
	$num_identificacion=$registro["num_identificacion"];
	$nombres=strtoupper($registro["nombres"]);
	$apellidos=strtoupper($registro["apellidos"]);
	$nombre_foto=$registro["foto_perfil"];
	if ($registro["sexo"]=="F")
		$sexo="FEMENINO";
	else
		$sexo="MASCULINO";
	$fecha_nac_l=formato_fecha("L",$registro["fecha_nac"]);
	$fecha_nac=date("d-m-Y",strtotime($registro["fecha_nac"]));
	$nacionalidad=$registro["nacionalidad"];
?>  
<form id="form" name="form"  action="repre_agregar_frm.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&accion=guardar_repre&id_per=<?php echo $_GET["id_per"];?>"  method="post" enctype="multipart/form-data" class="uniForm">

	<table width="100%" border="0">
  <tr>
    <td rowspan="2">
<div id="foto" name="foto" style="height:110px; width:90px; border:#666666; border-radius:5px; border-style:solid">

<?php 
  $ruta_foto=$_SESSION["carp_per_fotos"].$id_personal."/".$nombre_foto;
	if (file_exists($ruta_foto) && $nombre_foto!=''){
		echo "<img src='$ruta_foto' width='90px' height='110px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='90px' height='110px'>";}
?></div>    </td>
    <td>
<div class="ctrlHolder">
    		<p class="formHint">N&deg; de identificaci&oacute;n:</p>
        <label><b><?php echo $tipo_doc_abr."-".number_format($num_identificacion, 0, ",", ".");?></b></label> 
     <input type="hidden" name="txt_id_rep" value="<?php echo $id_personal; ?>">   
        
      </div>    </td>
    <td><div class="ctrlHolder">
    		<p class="formHint">Nombres y apellidos:</p>
        <label><b><?php echo $nombres." ".$apellidos;?></b></label> 
        
        
      </div></td>
    <td colspan="2"><div class="ctrlHolder">
    		<p class="formHint">Sexo:</p>
        <label><b><?php echo $sexo;?></b></label> 
        
        
      </div></td>
  </tr>
  <tr>
    <td>
    
    <div class="ctrlHolder">
    		<p class="formHint">Nacionalidad:</p>
        <label><b><?php echo strtoupper($nacionalidad);?></b></label> 
        
        
      </div>
    </td>
    <td><div class="ctrlHolder">
    		<p class="formHint">Fecha de nacimiento:</p>
        <label><b><?php echo strtoupper($fecha_nac_l);?></b></label> 
        
        
      </div></td>
      
    <td><div class="ctrlHolder">
    		<p class="formHint">Edad:</p>
        <label><b><?php echo calcular_edad($fecha_nac);?></b></label> 
        
        
      </div></td>
    <td><a id="resize" href="file:///C|/wamp/www/datos_per/datos_per.php?<?php echo "id_func=00051&accion=mostrar&id_per=$id_personal";?>" target="_blank" title="Mostrar mas informaci&oacute;n del estudiante"><img src="../images/sistema/icon_cumple.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2"><div class="ctrlHolder">
    <label for="cmb_par">Parentesco</label>
<br>
    <SELECT NAME="cmb_par" SIZE=1 class="sf validate[required]" id="cmb_par"> 
            <option value="">SELECCIONE...</option>
<?php
	$consulta_par=ejecuta_sql("select id_parentesco,parentesco from parentescos where visible=true order by parentesco ASC",true);
	//si hay registros para mostrar
  if ($consulta_par){
	while ($fila_par=mysql_fetch_array($consulta_par)){
		echo "<OPTION VALUE='".$fila_par['id_parentesco']."'>".$fila_par["parentesco"]."</OPTION>";
	}
	}
?>
</SELECT>
<input type="checkbox" name="chk_rep" id="chk_rep">
      <label for="chk_rep" title="Seleccionar si es representante del alumno dentro de la instituci&oacute;n">Representante</label>
<p class="formHint"> (*) Seleccione el parentesco del familiar</p>
</div></td>
    <td colspan="2"></td>
    </tr>
  <tr>
    <td colspan="5">
<div class="ctrlHolder">
<label for="txt_obs">Observaciones</label>
<br>
<textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"></textarea>
<p class="formHint"> Cualquier otra informaci&oacute;n importante</p>

</div>    </td>
    </tr>
  <tr>
  <td></td>
  <td colspan="4" align="right">
					<button formaction="repre_agregar_frm.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&accion=guardar_repre&id_per=<?php echo $_GET["id_per"];?>"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit" >
<span class="ui-button-text"><img src="../images/icons_menu/x32/diskette_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>



<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form').validationEngine('hide');javascript:history.go(-1);">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Regresar</span>
</button>

</td>
        </tr>

 </table>
 </form>
 <?php
	} // fin de si consulta edit
  } // se envio url del representante
 ?>
</html>