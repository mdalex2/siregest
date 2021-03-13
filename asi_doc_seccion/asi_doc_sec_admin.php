<form id="form_mostrar_datos" action="asi_doc_sec.php?<?php echo "id_func=".$_GET['id_func']."&accion=administrar&id_mos=".$_GET["id_mos"];?>" name="form_mostrar_datos" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
<fieldset>
<legend>DATOS DE LA SECCI&Oacute;N</legend> 
<?php
		if (!empty($_GET["id_mos"])){
			$id_seccion=$_GET["id_mos"];
		}
		$consulta_secc=ejecuta_sql("select  inst_secciones.cod_plantel,inst_secciones.id_plan_nivel_est,inst_secciones.cod_mencion_educ,inst_secciones.cod_grado,inst_secciones.id_sector_educ,id_seccion,seccion_largo,seccion_corto,inst_secciones.fecha_g,grados_esc.grado_letras,inst_secciones.visible,menc_edu.mencion,plan_est_tip.nivel_plan_est,sectores_educ.sector_educ,instituciones.den_plantel from (inst_secciones 
		INNER JOIN grados_esc on grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
				INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ
		INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel

		) where inst_secciones.id_seccion='$id_seccion'",true);
		if ($consulta_secc){
			$filas_secc=mysql_fetch_array($consulta_secc)
			
?>

<table width="100%" border="0">
  <tr>
    <td colspan="4"><div class="ctrlHolder">
     <p class="formHint">Plantel:<input type="hidden" name="txt_cod_pla" value="<?php echo $filas_secc["cod_plantel"]; ?>" /><input type="hidden" name="txt_sec_edu" value="<?php echo $filas_secc["id_sector_educ"]; ?>" /></p>
    <label><b><?php echo $filas_secc["den_plantel"]." (".$filas_secc["sector_educ"].")";?></b></label>
    <br>
   
  </div>
  </td>
  </tr>
  <tr>
    <td><div class="ctrlHolder">
     <p class="formHint">A&ntilde;o o grado:<input type="hidden" name="txt_ano_gra" value="<?php echo $filas_secc["cod_grado"]; ?>" /></p>
    <label><b><?php echo $filas_secc["grado_letras"];?></b></label>
    <br></div>
    </td>
    <td><div class="ctrlHolder">
     <p class="formHint">Secci&oacute;n:</p>
    <label><b><?php echo $filas_secc["seccion_largo"];?></b></label>
    <br></div></td>
    <td>
<div class="ctrlHolder">
     <p class="formHint">Plan de estudio:<input type="hidden" name="txt_plan_est" value="<?php echo $filas_secc["id_plan_nivel_est"]; ?>" /></p>
    <label><b><?php echo $filas_secc["nivel_plan_est"];?></b></label>
    <br>
   
  </div>    
    </td>
    <td><div class="ctrlHolder">
     <p class="formHint">Menci&oacute;n:<input type="hidden" name="txt_men" value="<?php echo $filas_secc["cod_mencion_educ"]; ?>" /></p>
    <label><b><?php echo $filas_secc["mencion"];?></b></label>
    <br></div></td>
  </tr>
  <tr>
  <td colspan="3">
  <div class="ctrlHolder">
<label for="cmb_year_esc">Seleccione el a&ntilde;o escolar</label>
<br>
<SELECT name="cmb_year_esc" id="cmb_year_esc" SIZE=1 class="mf validate[required]"> 
<!--<option value="">SELECCIONE...</option>-->
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_anno_esc from anno_esc_me WHERE visible=true and cerrado=false order by cod_anno_esc DESC",false);
	//si hay registros para mostrar
  if ($consulta){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_year_esc"]) && $_POST["cmb_year_esc"]==$fila["cod_anno_esc"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_anno_esc']."' {$selected}>".$fila["cod_anno_esc"]."</OPTION>";
	}
	} else //si no hubo consulta se grados o años
		{
			echo "<OPTION VALUE='' SELECTED>SIN ASIGNACI&Oacute;N</OPTION>";
		}
?>
</SELECT>
<button formaction="asi_doc_sec.php?<?php echo "id_func=".$_GET['id_func']."&accion=administrar&id_mos=$id_seccion";?>"class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="18" height="18" align="absmiddle">&nbsp;Mostrar asignaturas</span>
  </button> 
<p class="formHint"> (*) Requerido</p>
</div>
  </td>
  <td>
</td>

  </tr>
</table>

</fieldset>
<!-- End of fieldset -->
</form> 


<?php 
	if (isset($_GET["id_mos"]) && !empty($_GET["id_mos"]) && !empty($_POST["txt_ano_gra"]) && !empty($_POST["txt_plan_est"]) && !empty($_POST["txt_sec_edu"]) && !empty($_POST["txt_men"])){
		$id_seccion=$_GET["id_mos"];
		$anno_escolar=$_POST["cmb_year_esc"];
		$id_plan_est=$_POST["txt_plan_est"];
		$cod_grado=$_POST["txt_ano_gra"];
		$cod_mencion_educ=$_POST["txt_men"];
		$id_sector_educ=$_POST["txt_sec_edu"];
		$consulta_asig=ejecuta_sql("select
		plan_est_conf.cod_asig_prog,
		asig_prog.des_mat_prog,
		asig_prog.mat_prog_cor,
		plan_est_conf.orden
		from (plan_est_conf   
		INNER JOIN asig_prog on asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog 
		) WHERE id_plan_nivel_est='$id_plan_est'
		AND cod_grado='$cod_grado' 
		AND cod_mencion_educ='$cod_mencion_educ' 
		AND id_sector_educ='$id_sector_educ' 
		ORDER BY plan_est_conf.orden ASC",false);
		if ($consulta_asig)
			{
	//si se envio el año escolar muestro la asignacion
	//de profesores dependiendo del plan de estudio
	if (!empty($_POST["cmb_year_esc"])){
?>
<form id="frm_asig_mat" name="frm_asig_mat" action="<?php echo "asi_doc_sec.php?id_func=".$_GET["id_func"]."&accion=guardar_asig" ?>" method="post" enctype="multipart/form-data">
<fieldset>
<legend>SELECCIONE EL DOCENTE GU&Iacute;A Y EL DOCENTE PARA CADA ASIGNATURA</legend>

<input type="hidden" name="txt_id_sec_ocu" id="txt_id_sec_ocu" value="<?php echo $id_seccion;?>" />
<input type="hidden" name="txt_cod_anno_esc_ocu" id="txt_cod_anno_esc_ocu" value="<?php echo $_POST["cmb_year_esc"];?>" />

<div class="ctrlHolder"> 
<?php
				function buscar_prof_guia($cod_ann_esc,$id_sec){
				$consulta="select id_docente_guia from asi_doc_sec where ".
				" cod_anno_esc='$cod_ann_esc' and ".
				" id_seccion='$id_sec' LIMIT 1";
				
				$resultado=mysql_query($consulta) or die (mysql_error());
				if (mysql_num_rows($resultado)==1)
				{
					$fila=mysql_fetch_array($resultado);
					return $fila;
				} else {
					return false;
				}
				} // fin funcion

	include_once("../funciones/funcionesPHP.php");
	$cod_plantel_session="";
	if (!isset($_SESSION["cod_plantel_ses"]) && !empty($_SESSION["cod_plantel_ses"])){
		$cod_plantel_session=$_SESSION["cod_plantel_ses"];
		} else {
			if (!empty($_POST["txt_cod_pla"])){
				$cod_plantel_session=$_POST["txt_cod_pla"];
				}
			} // fin else
	$sql_cmb_doc=ejecuta_sql("select DISTINCT usuario_plantel.id_personal,datos_per.nombres,datos_per.apellidos,usuarios.id_grupo_cuenta from (usuario_plantel
	INNER JOIN datos_per ON datos_per.id_personal=usuario_plantel.id_personal
	INNER JOIN usuarios ON usuarios.id_usuario=usuario_plantel.id_personal
	) WHERE (usuarios.id_grupo_cuenta='G0002' OR usuarios.id_grupo_cuenta='G0004') AND usuario_plantel.cod_plantel='$cod_plantel_session'
	 order by nombres,apellidos ASC",false);
	//si hay registros para mostrar
?>
<h2>PROFESOR GU&Iacute;A:
<SELECT name="cmb_prof_guia" id="cmb_prof_guia" SIZE=1 class="mf validate[required]"> 
<option value="">SIN ASIGNAR...</option>
<?php
  if ($sql_cmb_doc){
	while ($fila=mysql_fetch_array($sql_cmb_doc)){
		//consulto si es guia para seleccionarlo automaticamente
		$con_doc_guia=buscar_prof_guia($anno_escolar,$id_seccion);
					if ($con_doc_guia){
						$id_docente_guia_BD=$con_doc_guia["id_docente_guia"];
						} else {
							$id_docente_guia_BD="";
						}

		if ($id_docente_guia_BD==$fila["id_personal"]){$selected=" selected=selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['id_personal']."' {$selected}>".$fila["nombres"]." ".$fila["apellidos"]."</OPTION>";
	}
	} 
?>
</SELECT>
</h2>
</div>

<table id="tablasinbtn_ordf0" class="letra_16 mouse_hover" width="100%"> 
        <thead> 
          <tr>
          	<th width="350px">ASIGNATURA</th>
          	<th>DOCENTE</th>
            <th>OBSERVACIONES</th>
            <th title="USUARIO QUE REALIZ&Oacute; LA ASIGNACI&Oacute;N">USU.</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				$i=0;
				function verif_existe($cod_ann_esc,$id_sec,$id_asi_pro){
				$consulta="select id_profesor,datos_per.nombres,datos_per.apellidos,asi_doc_sec.observaciones,asi_doc_sec.fecha_g from (asi_doc_sec 
				INNER JOIN datos_per ON datos_per.id_personal=asi_doc_sec.guardado_por
				)where ".
				" cod_anno_esc='$cod_ann_esc' and ".
				" id_seccion='$id_sec' and".
				" cod_asig_prog='$id_asi_pro'";
				$resultado=mysql_query($consulta) or die (mysql_error());
				if (mysql_num_rows($resultado)==1)
				{
					$fila=mysql_fetch_array($resultado);
					return $fila;
				} else {
					return false;
				}
				} // fin funcion
				
				while ($fila=mysql_fetch_array($consulta_asig))
				
				{
					$i++;
					$con_pla_gua=verif_existe($anno_escolar,$id_seccion,$fila["cod_asig_prog"]);
					if ($con_pla_gua){
							$id_docente_bd=$con_pla_gua["id_profesor"];
							$observ_bd=$con_pla_gua["observaciones"];
							$gua_por_bd=$con_pla_gua["nombres"]." ".$con_pla_gua["apellidos"];
							$fecha_g_bd=$con_pla_gua["fecha_g"];
							
						} else {
							$id_docente_bd="";
							$observ_bd="";
							$gua_por_bd="";
							$fecha_g_bd="";
						}
				?>
          

          <tr height="20px">
            <td><?php echo $fila["des_mat_prog"]." - (".$fila["mat_prog_cor"].")";?><input type="hidden" name="txt_cod_asig_ocu[<?PHP echo $i?>]" id="txt_cod_asig_ocu[<?PHP echo $i?>]" value="<?php echo $fila["cod_asig_prog"];?>" /></td>
            
            
            <td align="center">
<div class="ctrlHolder">
<?php
	include_once("../funciones/funcionesPHP.php");
	$cod_plantel_session="";
	if (!isset($_SESSION["cod_plantel_ses"]) && !empty($_SESSION["cod_plantel_ses"])){
		$cod_plantel_session=$_SESSION["cod_plantel_ses"];
		} else {
			if (!empty($_POST["txt_cod_pla"])){
				$cod_plantel_session=$_POST["txt_cod_pla"];
				}
			} // fin else
	$sql_cmb_doc=ejecuta_sql("select DISTINCT usuario_plantel.id_personal,datos_per.nombres,datos_per.apellidos,usuarios.id_grupo_cuenta from (usuario_plantel
	INNER JOIN datos_per ON datos_per.id_personal=usuario_plantel.id_personal
	INNER JOIN usuarios ON usuarios.id_usuario=usuario_plantel.id_personal
	) WHERE (usuarios.id_grupo_cuenta='G0002' OR usuarios.id_grupo_cuenta='G0004') AND usuario_plantel.cod_plantel='$cod_plantel_session'
	 order by nombres,apellidos ASC",false);
	//si hay registros para mostrar
?>
<SELECT name="cmb_doc_ocu[<?PHP echo $i?>]" id="cmb_doc_ocu[<?PHP echo $i?>]" SIZE=1 class="mf validate[optional]"> 
<option value="">SIN ASIGNAR...</option>
<?php
  if ($sql_cmb_doc){
	while ($fila=mysql_fetch_array($sql_cmb_doc)){
		if ($id_docente_bd==$fila["id_personal"]){ $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['id_personal']."' {$selected}>".$fila["nombres"]." ".$fila["apellidos"]."</OPTION>";
	}
	} 
?>
</SELECT>
</div>            
            </td>
            <td align="center">
            <input name="txt_obs_ocu[<?PHP echo $i?>]" type="text" class="sf" id="txt_obs_ocu[<?PHP echo $i?>]" value="<?php echo $observ_bd;?>" maxlength="250" /></td>
            <td align="center">
            <?php 
            if (!empty($fecha_g_bd)){
            ?>
            <a href="#" class="tooltip" title="<?php echo $gua_por_bd."<br>".formato_fecha("LH",$fecha_g_bd);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>
            <?php
						}
						?>
            </td>
          </tr> 
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
          
         <?php 
         } //fin de ciclo while
         ?>
      </tbody> 
  </table>

     </br> 
     <table width="100%" border="0">
  <tr>
    <td><button type="submit" formaction="<?php echo "asi_doc_sec.php?id_func=".$_GET["id_func"]."&accion=guardar_asig" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" title="Aplicar asignaci&oacute;n de docentes" onclick="return confirmSubmit()">
    <span class="ui-button-text"><img src="../images/icons_menu/x32/diskette_x32.png" width="24" height="24" align="absmiddle">&nbsp;Aplicar cambios</span>
    </button>
</td>
    <td><button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="24" height="24" align="absmiddle"> Deshacer</span>
</button></td>
    <td><?php if ($array_permisos["imprimir"]==true) { 
?>    
      <a href="asi_doc_sec_rep.php?id_secc=<?php echo $id_seccion;?>&cod_anno_esc=<?php echo $anno_escolar;?>" type="button" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" target="_blank" onclick="submit()" style="font-size:10px;color:#0080C0;">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" align="absmiddle" height="24" width="24"> Generar reporte</span>
  </a>
      <?php } // cierro si permite crear=guardar ?>  </td>
    <td width="20%">
       </td>
  </tr>
</table>

    <br />


  
  </fieldset>
</form>

<form id="frm_prog" enctype="multipart/form-data">
<h2>PROGRAMAS DE EDUCACI&Oacute;N PARA EL TRABAJO:</h2><?php
				$sql_prog="SELECT cod_asig_prog,des_mat_prog FROM asig_prog WHERE tip_asig='PR'";
				$cons_prog=ejecuta_sql($sql_prog,false);
				
				?>
  <table width="100%" border="0" id="tablaprograma_ordf">
    <thead>
      <tr>
        <th align="left" width="...">PROGRAMA</th>
        <th align="left" width="...">DOCENTE</th>
        <th align="left" width="...">OBSERVACIONES</th>
        <th></th>
      </tr>
      </thead>
      <tr>
        <td align="left">
        
        <select name="cmb_prog" id="cmb_prog" class="mf">
        <option value="">SELECCIONE...</option>
        <?php
				if ($cons_prog){
					while ($fila_prog=mysql_fetch_array($cons_prog)){
						$cod_prog=$fila_prog["cod_asig_prog"];
						$nombre_prog=$fila_prog["des_mat_prog"];
						echo "<option value='$cod_prog'>$nombre_prog</option>";
					} // fin while
				} // fin si consulta
				?>
        
        </select>
        </td>
        <td><div class="ctrlHolder">
<?php
	include_once("../funciones/funcionesPHP.php");
	$cod_plantel_session="";
	if (!isset($_SESSION["cod_plantel_ses"]) && !empty($_SESSION["cod_plantel_ses"])){
		$cod_plantel_session=$_SESSION["cod_plantel_ses"];
		} else {
			if (!empty($_POST["txt_cod_pla"])){
				$cod_plantel_session=$_POST["txt_cod_pla"];
				}
			} // fin else
	$sql_cmb_doc_prog=ejecuta_sql("select DISTINCT usuario_plantel.id_personal,datos_per.nombres,datos_per.apellidos,usuarios.id_grupo_cuenta from (usuario_plantel
	INNER JOIN datos_per ON datos_per.id_personal=usuario_plantel.id_personal
	INNER JOIN usuarios ON usuarios.id_usuario=usuario_plantel.id_personal
	) WHERE (usuarios.id_grupo_cuenta='G0002' OR usuarios.id_grupo_cuenta='G0004') AND usuario_plantel.cod_plantel='$cod_plantel_session'
	 order by nombres,apellidos ASC",false);
	//si hay registros para mostrar
?>
<SELECT name="cmb_doc_prog" id="cmb_doc_prog" SIZE=1 class="mf validate[optional]"> 
<option value="">SIN ASIGNAR...</option>
<?php
  if ($sql_cmb_doc_prog){
	while ($fila_doc_prog=mysql_fetch_array($sql_cmb_doc_prog)){
		echo "<OPTION VALUE='".$fila_doc_prog['id_personal']."' {$selected}>".$fila_doc_prog["nombres"]." ".$fila_doc_prog["apellidos"]."</OPTION>";
	}
	} 
?>
</SELECT>
</div>  </td>
        <td><input name="txt_obs_prog" type="text" class="sf" id="txt_obs_prog" value="" maxlength="250" /></th>
        <td> <?php if ($array_permisos["imprimir"]==true) { 
?>    
      <button id="btn_inc_prog"t type="button" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;color:#0080C0;" title="Incluir programa para la secci&oacute;n y periodo escolar seleccionado">
  <span class="ui-button-text"><img src="../images/sistema/add.png" align="absmiddle" height="20" width="20"> Incluir</span>
  </button>
      <?php 
			}
			?></td>
      </tr>
  </table>
<div id="div_prog_ept">
<?php
	include_once("mostrar_tabla_prog.php");
	mostrar_tabla_prog($_REQUEST["id_func"],$anno_escolar,$id_seccion,false);
?>
</div>
</form>
<?php
	} 	
// cierro el si !empty year-esc si se envio el año escolar con post
	} else
	mostrar_box("inf",false,"INFORMACI&Oacute;N","No se han encontrado asignaturas para el plan de estudio seleccionado");
	}
	} 

		
	?>