
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
	if ($registro["sexo"]=="F")
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

<!-- VERIFICO QUE NO ESTÉ INSCRITO --->

<form id="form_editar" name="form_editar" action="<?php echo "inscrip_est.php?id_func=".$_GET["id_func"]."&accion=inscribir&id_per=$id_personal#frm_asignaturas" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
<?php
if (empty($_POST["cmb_escolaridad"]) && empty($_POST["cmb_secc"]) && $represent_asig==true){
?><fieldset>
<legend>SELECCIONE A&Ntilde;O, GRADO Y SECCI&Oacute;N A INSCRIBIR:</legend>

<table  width="..." border="0">
<tr>
  <td colspan="3">
  <div class="ctrlHolder">
<?php
if (isset($_SESSION['id_grupo_usuario']) && ($_SESSION['id_grupo_usuario']=="G0001")){
$sql="select cod_plantel,den_plantel from instituciones where activa=true order by den_plantel,id_dis_esc asc";
} else {
$sql="select cod_plantel,den_plantel from instituciones where activa=true and cod_plantel='".$_SESSION["cod_plantel_ses"]."' order by den_plantel,id_dis_esc asc";
}
$consulta=ejecuta_sql($sql,false);
?>
<label for="cmb_pla">Plantel o instituci&oacute;n en el que el estudiante curs&oacute; o cursar&aacute;  las asignaturas</label> 

<br>
            <SELECT NAME="cmb_pla" id="cmb_pla" SIZE=1  class="lf validate[required]" style="width:98%" onchange="$('#txt_nom_pla_ocu').val($('#cmb_pla option:selected').html());$('#cmb_anno_esc option:selected').removeAttr('selected');$('#cmb_gra option:selected').removeAttr('selected');$('#cmb_secc option:selected').removeAttr('selected');"> 
                
                <?php 
								//if (!empty($_SESSION["id_grupo_usuario"])=="G0001"){echo "<option value=''>SELECCIONE...</option>";}
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>' <?php if (isset($_POST["cmb_pla"]) && $_POST["cmb_pla"]==$fila['cod_plantel']){echo " selected";} ?>><?php echo $fila["den_plantel"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> (*) Seleccione el plantel</p>
              <input type="hidden" name="txt_nom_pla_ocu" value="" />
</div>
  </td>
  </tr>
<tr>
  <td>
    <div class="ctrlHolder">
    <label for="cmb_anno_esc">A&ntilde;o escolar</label>
    <br>
    <SELECT NAME="cmb_anno_esc" id="cmb_anno_esc" SIZE=1 class="sf validate[required]" onchange="$('#cmb_secc option:selected').removeAttr('selected');"> 
    <option value="">SELECCIONE...</option>
    <?php
      //include_once("../funciones/funcionesPHP.php");
			if (isset($_SESSION['id_grupo_usuario']) && ($_SESSION['id_grupo_usuario']=="G0001" ||  $_SESSION['id_grupo_usuario']=="G0002" ||  $_SESSION['id_grupo_usuario']=="G0003")){
      $consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where visible=true order by cod_anno_esc DESC",true);} else {
				$consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where cerrado=false order by cod_anno_esc DESC",true);
				
			}      //si hay registros para mostrar
      if ($consulta){
			
      while ($fila=mysql_fetch_array($consulta)){
        //if (!empty($_POST["cmb_anno_esc"]) && $_POST["cmb_anno_esc"]==$fila['cod_anno_esc']){$seleccionado= " SELECTED=SELECTED ";} else {$seleccionado= "";};			
        echo "<OPTION VALUE='".$fila['cod_anno_esc']."' >".$fila["cod_anno_esc"]."</OPTION>";
      }
      }
    ?>
    </SELECT>
    <p class="formHint"> (*) a&ntilde;o escolar a inscribir</p>
    </div>
</td>
  <td>
 
<div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="mf validate[required]" onchange="$('#cmb_secc option:selected').removeAttr('selected');"> 
<option value="">SELECCIONE...</option>
</SELECT>
<p class="formHint"> (*) Grado a cursar</p>
</div>  </td>
  <td>
<div class="ctrlHolder">
<label for="cmb_secc">Secci&oacute;n</label>
<br>
<SELECT name="cmb_secc" id="cmb_secc" SIZE=1 class="sf validate[required]"> 
<option value="">SELECCIONE...</option>
</SELECT>
<p class="formHint"> (*) Secci&oacute;n a cursar</p>
</div>  </td>
</tr>
<tr>
  <td colspan="2">
    <div class="ctrlHolder">
  <label for="cmb_escolaridad">Escolaridad</label>
  <br>
  <SELECT NAME="cmb_escolaridad" id="cmb_escolaridad" SIZE=1 class="lf validate[required]" style="width:98%"> 
  <option value="">SELECCIONE...</option>
  <?php
	$consulta=ejecuta_sql("select id_escolaridad,escolaridad,escolaridad_abrev from escolaridad where visible=true order by escolaridad ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
if (!empty($_POST["cmb_escolaridad"]) && $_POST["cmb_escolaridad"]==$fila['id_escolaridad']){$seleccionado= " SELECTED=SELECTED ";} else {$seleccionado= "";};				
		echo "<OPTION VALUE='".$fila['id_escolaridad']."' $seleccionado>".$fila["escolaridad"]."</OPTION>";
	}
	}
?>
  </SELECT>
  <p class="formHint"> (*) Seleccione el tipo escolaridad</p>
  </div>
  </td>
  <td>&nbsp;</td>
<tr><td colspan="3">
  <?php if ($array_permisos["editar"]==true) { ?>  
  <button type="submit" formaction="<?php echo "inscrip_est.php?id_func=".$_GET["id_func"]."&accion=inscribir&id_per=$id_personal#frm_asignaturas" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" title="Validar y seleccionar asignaturas a inscribir">
  <span class="ui-button-text"><img src="../images/sistema/computer_go.png" width="20" height="20" align="absmiddle">&nbsp;Buscar asignaturas</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>

  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
  </button>
  </td>
</tr>
</table>
</fieldset>
<?php
	} //fin de si se envio la escolaridad y la seccion en form de selecion de grado y seccion y plantel
?>
<!-- End of fieldset -->
</form>
<!-- fin form buscar asignaturas -->

<!-- VERIFICIO SI EL ESTUDIANTE YA SE INSCRIBIÓ SI YA SE INSCRIBIÓ MUESTRO MSG QUE YA ESTA INSCRITO Y DOY OPCION DE ELIKMINAR -->
<?php
if (!empty($_POST["cmb_anno_esc"]))
{
$anno_esc_me=$_POST["cmb_anno_esc"];
$sql_verif_inscrito="SELECT COUNT(*) as total_reg,inst_secciones.cod_grado FROM (alum_insc_notas INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion)WHERE id_personal='$id_personal' AND cod_anno_esc='$anno_esc_me' AND  	inst_secciones.cod_grado='".$_POST["cmb_gra"]."'";
$consul_inscrito=ejecuta_sql($sql_verif_inscrito,true);
if ($consul_inscrito){
	$fila_num_inscrito=mysql_fetch_array($consul_inscrito);
	//echo "TOTAL INSCRITO: ".$fila_num_inscrito["total_reg"];
	if ($fila_num_inscrito["total_reg"]>0){
		mostrar_box("exc",false,"Informaci&oacute;n","El estudiante ya se encuentra inscrito en el a&ntilde;o,  y grado seleccionados, se puede volver a efectuar el registro de inscripci&oacute;n para corregir algún fallo en la selecci&oacute;n de asignaturas; sin embargo esto traer&iacute;a como consecuencia que la inscripci&oacute;n anterior se elimine, así como tambien los registros de calificaciones en caso que existieren para el a&ntilde;o escolar y grado seleccionado.");
		//exit();
	}
}
}
?>

<form id="form_asig_insc" name="form_asig_insc" action="<?php echo "inscrip_est.php?id_func=".$_GET["id_func"]."&accion=genera_inscripcion" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
<?php
if (!empty($_POST["cmb_escolaridad"]) && !empty($_POST["cmb_secc"])){
	$cod_escolaridad=$_POST["cmb_escolaridad"];
	$cod_secc=$_POST["cmb_secc"];
	$sql_resumen="SELECT instituciones.den_plantel,grados_esc.grado_letras,seccion_corto,escolaridad.escolaridad FROM (inst_secciones
	 INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel
	 INNER JOIN grados_esc ON grados_esc.cod_grado= inst_secciones.cod_grado
	 INNER JOIN escolaridad ON escolaridad. 	id_escolaridad='$cod_escolaridad'
	 ) WHERE inst_secciones.id_seccion='$cod_secc'
	";
	$consulta_resumen=ejecuta_sql($sql_resumen,true);
	if ($consulta_resumen){
	$fila_resumen=mysql_fetch_array($consulta_resumen);
?>
<fieldset>
<legend>DATOS DE LA INSCRIPCI&Oacute;N:</legend>

<table width="100%" border="0">
  <tr>
    <td colspan="5"><div class="ctrlHolder" ><input type="hidden" name="txt_cod_plant_ocu" id="txt_cod_plant_ocu" value="<?php echo $_POST["cmb_pla"];?>" /><label><b>PLANTEL:</b> <?php echo $fila_resumen["den_plantel"]; ?></label><input type="hidden" name="txt_id_per_ocu" id=txt_id_per_ocu"" value="<?php echo $id_personal?>" /></div></td>
    </</tr>
  <tr>
    <td><div class="ctrlHolder" style="width:98%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:10px"><input type="hidden" name="txt_anno_esc_ocu" id="txt_anno_esc_ocu" value="<?php echo $_POST["cmb_anno_esc"];?>" /><label><strong>A&Ntilde;O ESCOLAR: </strong><?php echo $_POST["cmb_anno_esc"]; ?></label></div></td>
    <td><div class="ctrlHolder" style="width:98%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:10px"><input type="hidden" name="txt_gra_ocu" id="txt_gra_ocu" value="<?php echo $_POST["cmb_gra"];?>" /><label><strong>GRADO:</strong> <?php echo $fila_resumen["grado_letras"]; ?></label></div></td></td>
    <td><div class="ctrlHolder"  style="width:98%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:10px"><input type="hidden" name="txt_secc_ocu" id="txt_secc_ocu" value="<?php echo $_POST["cmb_secc"];?>" /><label><strong>SECCI&Oacute;N: </strong><?php echo $fila_resumen["seccion_corto"]; ?></label></div></td>
    <td><div class="ctrlHolder"  style="width:98%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:10px"><input type="hidden" name="txt_esc_ocu" id="txt_esc_ocu" value="<?php echo $_POST["cmb_escolaridad"];?>" /><label><strong>ESCOLARIDAD: </strong><?php echo $fila_resumen["escolaridad"]; ?></label></div></td>
  </tr>
</table>
</fieldset>
<fieldset>
<legend>SELECCIONE LAS ASIGNATURAS A INSCRIBIR:</legend>

<?php
$id_secc_post=$_POST["cmb_secc"];
$sql_obten_config_plan_estud="select 
 id_plan_nivel_est,cod_mencion_educ,id_sector_educ,cod_grado
 FROM inst_secciones
 WHERE id_seccion='$id_secc_post' LIMIT 1
";

if ($consulta=ejecuta_sql($sql_obten_config_plan_estud,true)){
	$reg_plan_est=mysql_fetch_array($consulta);
	$id_plan_nivel_es=$reg_plan_est["id_plan_nivel_est"];
	$cod_mencion_educ=$reg_plan_est["cod_mencion_educ"];
	$id_sector_educ=$reg_plan_est["id_sector_educ"];
	$cod_grado=$reg_plan_est["cod_grado"];
	/*
	echo $id_secc_post."<br>";
	echo $id_plan_nivel_es."<br>";
	echo $cod_mencion_educ."<br>";
	echo $id_sector_educ."<br>";
	echo $cod_grado."<br>";
	*/
	//----------------------------------
	$sql_asignaturas="SELECT plan_est_conf.cod_asig_prog,asig_prog.des_mat_prog,asig_prog.mat_prog_cor
  FROM (plan_est_conf
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog
	)
	WHERE id_plan_nivel_est='$id_plan_nivel_es' AND cod_grado='$cod_grado' AND cod_mencion_educ='$cod_mencion_educ' AND id_sector_educ='$id_sector_educ'
	ORDER BY asig_prog.orden ASC";
 $consul_asig=ejecuta_sql($sql_asignaturas,true);
 if ($consul_asig){

?>

<table border="0" id="tabla_asig" class="letra_16 mouse_hover" style="font-size:12px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
<thead> 
<tr>
<th title="Abreviatura de la asignatura"><input name="checkAll" type="checkbox" id="checkAll"  title="Seleccionar todos / quitar selecci&oacute;n" onclick="checkTodos(this.id,'tabla_asig');" checked="checked"   />
ABREV.</th>
<th width="300px">ASIGNATURA</th>
<th>C&Oacute;DIGO</th>
</tr>
</thead>
<?php
$i=0;
	while ($fila=mysql_fetch_array($consul_asig)){
		$i++
?>
<tr>
  <td>
    <input name="chk_cod_asig[<?php echo $i;?>]" type="checkbox" id="chk_cod_asig[<?php echo $i;?>]" checked="checked" />
    <label for="chk_cod_asig[<?php echo $i;?>]"><input type="hidden" id="txt_cod_asig[<?PHP echo $i?>]"  name="txt_cod_asig[<?PHP echo $i?>]" value="<?php echo $fila["cod_asig_prog"];?>"/><?php echo $fila["mat_prog_cor"]; ?></label></td>
  <td><?php echo $fila["des_mat_prog"];?></td>
  <td><?php echo $fila["cod_asig_prog"];?></td>
</tr>
<?php
	} // fin while
?>
</table>
<?php
} // fin si hay consulta de asig
} // fin de si se encontro la configuracion del plan de estudio a traves de la seccion
?>

</fieldset>

<fieldset>
<legend>SELECCIONE LOS PROGRAMAS DE EDUC. PARA EL TRABAJO A INSCRIBIR:</legend>

<?php
	$id_secc_post=$_POST["cmb_secc"];
	$sql_programa="SELECT asi_doc_sec.cod_asig_prog ,asig_prog.des_mat_prog,asig_prog.mat_prog_cor
  FROM (asi_doc_sec
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog
	)
	WHERE asi_doc_sec.cod_anno_esc='$anno_esc_me' AND id_seccion='$id_secc_post' AND asig_prog.tip_asig='PR'
	ORDER BY asig_prog.orden ASC";
 $consul_prog=ejecuta_sql($sql_programa,false);
 if ($consul_prog){

?>

<table border="0" id="tabla_prog" class="letra_16 mouse_hover" style="font-size:12px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
<thead> 
<tr>
<th title="Abreviatura del programa"><input name="checkAll" type="checkbox" id="checkAll"  title="Seleccionar todos / quitar selecci&oacute;n" onclick="checkTodos(this.id,'tabla_prog');" checked="checked"   />
ABREV.</th>
<th width="300px">PROGRAMA DE EDUC. PARA EL TRABAJO</th>
<th>C&Oacute;DIGO</th>
</tr>
</thead>
<?php
$i=0;
	while ($fila=mysql_fetch_array($consul_prog)){
		$i++
?>
<tr>
  <td>
    <input name="chk_cod_prog[<?php echo $i;?>]" type="checkbox" id="chk_cod_prog[<?php echo $i;?>]" checked="checked" />
    <label for="chk_cod_prog[<?php echo $i;?>]"><input type="hidden" id="txt_cod_prog[<?PHP echo $i?>]"  name="txt_cod_prog[<?PHP echo $i?>]" value="<?php echo $fila["cod_asig_prog"];?>"/><?php echo $fila["mat_prog_cor"]; ?></label></td>
  <td><?php echo $fila["des_mat_prog"];?></td>
  <td><?php echo $fila["cod_asig_prog"];?></td>
</tr>
<?php
	} // fin while
?>
</table>
<?php
} // fin si hay consulta de asig
else {
	mostrar_box("exc",false,"","No se han asignado Programas de Educación para el Trabajo en la sección seleccionada, en caso de que para el grado y sección seleccionados existan programas a cursar; éstos deben asignarse antes de efectuar inscripciones, de lo contrario no se podrán registrar calificaciones a los mismos, los programas se pueden asignar usando la función <b>asignación de secciones</b>");
}
?>

</fieldset>
<?php
	} //fin de si se envio la escolarida y la seccion
?>

 <?php
if (!empty($_POST["cmb_escolaridad"]) && ( $_POST["cmb_escolaridad"]=="ESCRGP")){
?>
<fieldset>
<legend>MATERIA(S) PENDIENTE(S)</legend>

<table  border="0">
  <tr>
    <td width="..."><div class="ctrlHolder">
<label for="cmb_asi_pen">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra_pen" id="cmb_gra_pen" SIZE=1 class="sf validate[required]" onchange="$('#cmb_secc_pend').html('');$('#div_asig_pend').html('');"> 
<option value="">SELECCIONE...</option>
<?php
  if (!empty($_POST["cmb_anno_esc"])) {
		$año_esc_post=$_POST["cmb_anno_esc"];
		$cod_plant_post=$_POST["cmb_pla"]; //plantel procedencia
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select DISTINCT  inst_secciones.cod_grado,grados_esc.grado_letras from (asi_doc_sec
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=asi_doc_sec.id_seccion
	INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
	) WHERE asi_doc_sec.cod_anno_esc='$año_esc_post' AND  	cod_plantel='$cod_plant_post' order by grados_esc.orden ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_gra_pen"]) && $_POST["cmb_gra_pen"]==$fila["cod_grado"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_grado']."' {$selected}>".$fila["grado_letras"]."</OPTION>";
	}
	}
	} // fin de si se envio el año escolar
?>
</SELECT>
<p class="formHint"> (*) Grado de la asignatura pendiente</p>
</div>
</td>
    <td><div class="ctrlHolder">
<label for="cmb_secc">Secci&oacute;n</label>
<br>
<SELECT name="cmb_secc_pend" id="cmb_secc_pend" SIZE=1 class="sf validate[required]"> 
<option value="">SELECCIONE...</option>
</SELECT>
<p class="formHint"> (*) Secci&oacute;n a cursar</p>
</div></td>


    </tr>
  <tr>
    <td colspan="2"><div id="div_asig_pend"></div></td>
    </tr>
</table>

</fieldset>
<?php
} //fin de si se selecciono regular con materia pendiente
?>
<!-- INICIO FIELDS DE RECAUDOS -->
<?php
$sql_recaud="SELECT id_tip_recaudo,descrip_recaudo FROM tip_recaudos WHERE (visible=true AND cod_grado='".$cod_grado."') OR todos=true";
$cons_reca=ejecuta_sql($sql_recaud,false);
if ($cons_reca){
?>
<fieldset>
<legend>SELECCI&Oacute;N DE RECAUDOS CONSIGNADOS</legend>

<table border="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px;">
<thead>
  <tr>
    <th>RECAUDOS</th>
    <th>OBSERVACIONES</th>
  </tr>
 </thead>
	<?php
	$r=0;
	while ($fila_reca=mysql_fetch_array($cons_reca)){
		$r++
	?>
  <tr>
    <td>
		<input type="hidden" name="txt_cod_reca[<?PHP echo $r?>]" value="<?php echo $fila_reca["id_tip_recaudo"];?>" />
    <input type="checkbox" id="chk_reca[<?PHP echo $r?>]"  name="chk_reca[<?PHP echo $r?>]"/>    
    <label for="chk_reca[<?PHP echo $r?>]"><?php echo $fila_reca["descrip_recaudo"];?></label></td>
    <td>
      <input name="txt_obs[<?PHP echo $r?>]" type="text" class="text-input mf" id="txt_obs[<?PHP echo $r?>]" maxlength="200"/></td>
  </tr>
  <?php
		} // fin while
	?>
</table>

</fieldset>
<?php
} // fin de si hubo consulta de recaudos
else
{
	mostrar_box("exc",true,"","No se encontraron recaudos disponibles para consignar para el grado seleccionado");
}
?>
<!-- FIN DE FIELDS RECAUDOS -->
<!-- End of fieldset -->
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "inscrip_est.php?id_func=".$_GET["id_func"]."&accion=genera_inscripcion" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all tooltip" id="btn_guardar" title="Inscribir el alumno y mostrar planilla de inscripci&oacute;n" onclick="
if ($('#txt_gra_ocu').val()==$('#cmb_gra_pen option:selected').val()){
  alert('Debe seleccionar un grado distinto e inferior al que desea inscribir para la materia pendiente');
  return false;
} else{
return confirm_insc();}">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Inscribir</span>
</button>
<?php } // cierro si permite crear=guardar ?>
<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form').validationEngine('hide');javascript:history.go(-1);">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Regresar</span>
</button>
</form>
<?php
  } // cierro el if consulta de resumen
  } //cierro si se encontro la consulta de asignaturas y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>
 