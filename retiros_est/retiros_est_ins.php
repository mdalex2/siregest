
 <?php
if (isset($_GET["id_per"])){
	$consulta_edit=ejecuta_sql("select id_personal,num_identificacion,fecha_nac,nombres,apellidos,foto_perfil,sexo,fecha_nac,tip_doc_per.tipo_doc_abr,terr_nacionalidad.nacionalidad from (datos_per
	INNER JOIN tip_doc_per on tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN terr_nacionalidad on terr_nacionalidad.cod_nac=datos_per.cod_nac
	) where id_personal='".$_GET["id_per"]."'",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$id_personal=$registro["id_personal"];
	$tipo_doc_abr=$registro["tipo_doc_abr"];
	$num_identificacion=$registro["num_identificacion"];
	$nombres=strtoupper($registro["nombres"]);
	$apellidos=strtoupper($registro["apellidos"]);
	$nombre_foto=$registro["foto_perfil"];
	if ($registro["foto_perfil"]=="F")
		$sexo="FEMENINO";
	else
		$sexo="MASCULINO";
	$fecha_nac_l=formato_fecha("L",$registro["fecha_nac"]);
	$fecha_nac=date("d-m-Y",strtotime($registro["fecha_nac"]));
	$nacionalidad=$registro["nacionalidad"];
?>  
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
    <td><a id="resize" href="../datos_per/datos_per.php?<?php echo "id_func=00051&accion=mostrar&id_per=$id_personal";?>" target="_blank" title="Mostrar mas informaci&oacute;n del estudiante"><img src="../images/sistema/vcard-icon.png" width="32" height="32" /></a></td>
  </tr>
 </table>
 <!------ GRUPO DE REPRESENTANTES --->
 <fieldset>
 <legend>DATOS DEL REPRESENTANTE Y GRUPO FAMILIAR</legend>
   <?php
	  $represent_asig=false;
		$sql_repres="SELECT datos_per.nombres,datos_per.apellidos,datos_per.num_identificacion,tip_doc_per.tipo_doc_abr,parentescos.parentesco,representante FROM (alum_repr 
		INNER JOIN datos_per ON datos_per.id_personal=alum_repr.id_representante
		INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
		INNER JOIN parentescos ON parentescos.id_parentesco=alum_repr.id_parentesco
		)
		WHERE alum_repr.id_alumno='$id_personal'
		ORDER BY datos_per.nombres,datos_per.apellidos asc
		";
		$consulta_repres=ejecuta_sql($sql_repres,false);
		if ($consulta_repres){
	?>
 <table id="tabla_repre" border="0" class="letra_16 mouse_hover" style="font-size:12px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
 <thead>
 	<tr>
  	<th>N&deg; C&Eacute;DULA</th>
    <th width="220px">NOMBRES Y APELLIDOS</th>
    <th>PARENTESCO</th>
    <th>TIPO</th>
  </tr>
 </thead>
 <?php 
 while ($fila_repre=mysql_fetch_array($consulta_repres)){
	 		if ($fila_repre["representante"]==true){
			$represent_asig="REPRESENTANTE";
		} else {
			$represent_asig="OTRO";
		}	 

 ?>
  <tr>

    <td><?php echo $fila_repre["tipo_doc_abr"]."-".$fila_repre["num_identificacion"];?></td>
    <td><?php echo $fila_repre["nombres"]." ".$fila_repre["apellidos"];?></td>
    <td><?php echo $fila_repre["parentesco"];?></td>
    <td><?php echo $represent_asig;?></td>
  </tr>
  <?php
 } // fin while
	?>
</table>
<?php
		}// fin de si se ejecuto y hay registros consulta representnate
		 else {
			 $url_refrescar='<a href="javascript:location.reload()"><b>haga clic aqui para continuar</b></a>';
			 $url_datos_per='<a id="resize" href="../datos_per/datos_per.php?id_func=00051&accion=mostrar&id_per='.$id_personal.'#frm_repre" target="_blank" title="Haga clic para asignar representante"><img src="../images/sistema/vcard-icon.png" width="32" height="32" align="absmiddle" /><b>datos personales</b></a>';
			 mostrar_box("exc",false,"","El estudiante no tiene representante, madre o padre asignado, debe asignar al menos un representante usando la funci&oacute;n $url_datos_per.</br>Una ves asignado el representante $url_refrescar.");
		}
?>
</fieldset>
<!------ FIN GRUPO REPRESENTANTES -->
<!-- End of fieldset -->
<fieldset>
<legend>RETIRO DE ESTUDIANTES:</legend>
<?php
$sql_bus_secc="SELECT cod_plantel_proc,instituciones.den_plantel,grados_esc.grado_letras,alum_insc_notas.id_seccion,inst_secciones. 	seccion_corto,alum_insc_notas.cod_anno_esc FROM (alum_insc_notas 
 INNER JOIN instituciones ON instituciones. 	cod_plantel=alum_insc_notas.cod_plantel_proc
 INNER JOIN grados_esc ON grados_esc.cod_grado=alum_insc_notas.cod_grado
 INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion)
 WHERE id_personal='$id_personal'
  ORDER BY grados_esc.orden DESC LIMIT 1
";
$cons_secc=ejecuta_sql($sql_bus_secc,true);
if ($cons_secc){
	$fila_secc=mysql_fetch_array($cons_secc);
	$plantel=$fila_secc["den_plantel"];
	$cod_plantel=$fila_secc["cod_plantel_proc"];
	$anno_esc=$fila_secc["cod_anno_esc"];
	$grado=$fila_secc["grado_letras"];
	$id_seccion=$fila_secc["id_seccion"];
	$seccion=$fila_secc["seccion_corto"];
?>
<form action="<?php echo "retiros_est.php?id_func=".$_GET["id_func"]."&accion=genera_retiro";?>" method="post" name="frm_retiro" id="frm_retiro" enctype="multipart/form-data">
  <table width="100%" border="0">
    <tr><td colspan="3">
      <div class="ctrlHolder">
    		<p class="formHint">Plantel:</p><input type="hidden" name="txt_id_per" value="<?php echo $id_personal;?>" /><input type="hidden" name="txt_cod_plan" value="<?php echo $cod_plantel;?>" />
        <label><b><?php echo $plantel;?></b></label> 
      </div>
    </td></tr>
    <tr>
      <td colspan="3"><div class="ctrlHolder">
<?php
	echo "<OPTION VALUE=''>SELECCIONE...</OPTION>";
  include_once("../funciones/funcionesPHP.php");

	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select DISTINCT  
	usuario_plantel.id_personal,
	datos_per.nombres,datos_per.apellidos,
	usuarios.id_grupo_cuenta
	 from (usuario_plantel
	 INNER JOIN datos_per ON datos_per.id_personal=usuario_plantel.id_personal
	 INNER JOIN usuarios ON usuarios.id_usuario=usuario_plantel.id_personal
	) WHERE usuario_plantel.cod_plantel='$cod_plantel' AND  	usuarios.bloqueado=false AND usuarios.id_grupo_cuenta='G0002' order by datos_per.nombres,datos_per.apellidos ASC",false);

?>
<label for="cmb_director">Director(a)</label>
<br>
   <SELECT NAME="cmb_director" id="cmb_director" SIZE=1  class="lf validate[required]"> 
     <option value="">SELECCIONE...</option>
     <?php
  if ($consulta){
	while ($fila=mysql_fetch_array($consulta)){
		echo utf8_encode("<OPTION VALUE='".$fila['id_personal']."'>".$fila["nombres"]." ".$fila["apellidos"]."</OPTION>");
	}
	}  
	?>   
   </SELECT>
   <input type="checkbox" name="chk_enc" id="chk_enc" />
   <label for="chk_enc">Encargado(a)</label>
              <p class="formHint"> (*) Seleccione qui&eacute;n firmar&aacute; la constancia</p>
</div></td>
    </tr>
    <tr>
      <td><div class="ctrlHolder">
    		<p class="formHint">A&ntilde;o escolar:</p>
        <label><b><?php echo $anno_esc;?></b></label> <input type="hidden" name="txt_cod_anno_esc" value="<?php echo $anno_esc; ?>" />
      </div></td>
      <td><div class="ctrlHolder">
    		<p class="formHint">Grado:</p>
        <label><b><?php echo $grado;?></b></label> 
      </div></td>
      <td><div class="ctrlHolder">
    		<p class="formHint">Secci&oacute;n:</p>
        <label><b><?php echo $seccion;?></b><input type="hidden" name="txt_cod_sec" value="<?php echo $id_seccion;?>"  /></label> 
      </div></td>
    </tr>
    <tr>
      <td><div class="ctrlHolder">
<label for="txt_fecha1">Fecha de retiro<br>
<input  name="txt_fecha1" type="text" class="fecha_corta validate[custom[date],required]" id="txt_fecha1" value="<?php $fecha=strftime( "%d-%m-%Y", time() ); echo $fecha;?>"  maxlength="10"/>
<!--<a name='txt_fec_nac' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Seleccione la fecha de retiro</p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#txt_fecha1").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
}); 
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div class="ctrlHolder">
<label for="txt_mot">Motivo del retiro</label>
<br>
<textarea name="txt_mot" id="txt_mot" rows="4" class='validate[required,maxSize[5000]] textarea_small'  style="width:98%">cambio de residencia</textarea>
<p class="formHint"> Ejm: cambio de residencia</p>

</div></td>
      </tr>
    <tr>
      <td colspan="3"><div class="ctrlHolder">
<label for="txt_obs">Observaciones</label>
<br>
<textarea name="txt_obs" id="txt_obs" rows="4" class='validate[maxSize[5000]] textarea_small'  style="width:98%"></textarea>
<p class="formHint"> Ejm: Se entregaron sus documentos personales tales como: notas, copia de cédula, boletines, carta de buena conducta...</p>

</div></td>
    </tr>
    <tr>
      <td colspan="3">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "retiros_est.php?id_func=".$_GET["id_func"]."&accion=genera_retiro" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar" onclick="return confirmEgreso();">
<span class="ui-button-text"><img src="../images/sistema/retiro.png" width="24" height="24" align="absmiddle">&nbsp;Retirar estudiante</span>
</button>
<?php } // cierro si permite crear=guardar ?>

<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#frm_retiro').validationEngine('hide');$('#txt_mot').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
</button>      </td>
    </tr>
  </table>

</form>
</fieldset>
<?php
	} //cierro si hubo sonculta de seccion resumen
  } // cierro el if consulta de resumen
	}  //cierro si se envio por url el id a mostrar
?>
 