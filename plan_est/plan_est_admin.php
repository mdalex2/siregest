            
<form id="form_plan_est_adm" name="form_plan_est_adm" action="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=administrar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>ADMINISTRAR PLAN DE ESTUDIO:</legend>

<table  width="100%" border="0">
<tr>
<td width="100px">
<div class="ctrlHolder">
<label for="cmb_pla_est">Plan de estudio / Vigencia</label>
<br>
<SELECT name="cmb_pla_est" id="cmb_pla_est" SIZE=1 class="lf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select  	id_plan_nivel_est,cod_plan_nivel_me,nivel_plan_est,fecha_pub from plan_est_tip where visible=true order by nivel_plan_est ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_pla_est"]) && $_POST["cmb_pla_est"]==$fila["id_plan_nivel_est"]){echo $selected=" selected ";} else {$selected="";}
		//pongo fecha mes en letra año
		$fecha_pub=strtoupper(formato_fecha("MA",$fila["fecha_pub"]));
		echo "<OPTION VALUE='".$fila['id_plan_nivel_est']."' {$selected}>".$fila["cod_plan_nivel_me"]." - ".$fila["nivel_plan_est"]."&nbsp;&nbsp;&nbsp;| &rarr; $fecha_pub</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>
</td>
<td width="100px">
<div class="ctrlHolder">
<label for="cmb_sec_pla_est">Sector</label>
<br>
<SELECT name="cmb_sec_pla_est" id="cmb_sec_pla_est" SIZE=1 class="sf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select id_sector_educ,sector_educ from sectores_educ order by sector_educ ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		$selected="";
		if (isset($_POST["cmb_sec_pla_est"])){
			if ($_POST["cmb_sec_pla_est"]==0 or $_POST["cmb_sec_pla_est"]==$fila["id_sector_educ"]){
			echo $selected=" selected ";} else {$selected="";}}
		echo "<OPTION VALUE='".$fila['id_sector_educ']."' {$selected}>".$fila["sector_educ"]."</OPTION></BR>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>    

</td>
<td>
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
    <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
    </button>
  
</td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
<label for="cmb_men">Menci&oacute;n</label>
<br>
<SELECT name="cmb_men" id="cmb_men" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select  	cod_mencion_educ,mencion from menc_edu where visible=true order by mencion ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_men"]) && $_POST["cmb_men"]==$fila["cod_mencion_educ"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_mencion_educ']."' {$selected}>".$fila["mencion"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>
<div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="sf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_grado,grado_letras from grados_esc order by orden ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_gra"]) && $_POST["cmb_gra"]==$fila["cod_grado"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_grado']."' {$selected}>".$fila["grado_letras"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>    

</td>
<td>
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=administrar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" title="Ver asignaturas del plan de estudio consultado">
    <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Ver asignaturas</span>
    </button>
  <?php } // cierro si permite crear=guardar ?>
  <br /><input name="chk_mos_prog" type="checkbox" id="chk_mos_prog" <?php if (!empty($_POST["chk_mos_prog"]) )echo " checked ";?>/>
  <label for="chk_mos_prog">Incluir programas</label>
</td>
</tr>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 


<?php 
	if (isset($_POST["cmb_pla_est"]) && isset($_POST["cmb_sec_pla_est"]) && isset($_POST["cmb_men"]) && isset($_POST["cmb_sec_pla_est"]) && isset($_POST["cmb_gra"])){
		$cmb_pla_est=$_POST["cmb_pla_est"];
		$cmb_sec=$_POST["cmb_sec_pla_est"];
		$cmb_men=$_POST["cmb_men"];
		$cmb_gra=$_POST["cmb_gra"];
		if (!empty($_POST["chk_mos_prog"]) && $_POST["chk_mos_prog"]=="on" ){
			$mostrar_programas="";
		} else {
			$mostrar_programas=" and asig_prog.tip_asig='AS' ";
		}
		$consulta_asig=ejecuta_sql("select
		cod_asig_prog,
		des_mat_prog,
		mat_prog_cor,
		datos_per.nombres,
		datos_per.apellidos,
		orden,
		asig_prog.fecha_g 
		from (asig_prog   
		INNER JOIN datos_per on asig_prog.guardado_por=datos_per.id_personal 
		) where visible=true $mostrar_programas ORDER BY des_mat_prog ASC",true);
		if ($consulta_asig)
			{

?>
<form id="frm_asig_mat" name="frm_asig_mat" action="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=guardar_asig" ?>" method="post" enctype="multipart/form-data">
<fieldset>
<legend>SELECCIONE LAS ASIGNATURAS PARA EL PLAN DE ESTUDIOS</legend>


<input type="hidden" name="cod_pla_est" id=name="cod_pla_est" value="<?php echo $cmb_pla_est;?>" />

<input type="hidden" name="cod_sec" id=name="cod_sec" value="<?php echo $cmb_sec;?>" />

<input type="hidden" name="cod_men" id=name="cod_men" value="<?php echo $cmb_men;?>" />

<input type="hidden" name="cod_gra" id=name="cod_gra" value="<?php echo $cmb_gra;?>" />


<table id="tabla_asig" class="letra_16 mouse_hover" width="..."> 
        <thead> 
          <tr>
          	<th width="5"><input id="checkAll" onclick="checkTodos(this.id,'tabla_asig');" name="checkAll" type="checkbox" title="Seleccionar todos / quitar selecci&oacute;n" align="bottom" style="margin-right:-5px;
  vertical-align:middle;" /></th>
					  <th width="...">C&Oacute;DIGO</th>
            <th width="...">ASIGNATURA</th>
          	<th width="20px">HORAS ACADEMICAS</th>
          	<th width="20px">HORAS PRACTICAS</th>
            
            <th width="20px">ORDEN</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				$i=0;
				function verif_existe($id_plan_est,$id_sec,$id_men,$id_gra,$id_asi_pro){
				$consulta="select ha,hp,orden from plan_est_conf where ".
				" id_plan_nivel_est='$id_plan_est' and ".
				" cod_grado='$id_gra' and".
				" cod_mencion_educ='$id_men' and ".
				" id_sector_educ='$id_sec' and ".
				" cod_asig_prog='$id_asi_pro'";
				$resultado=mysql_query($consulta) or die (mysql_error());
				if (mysql_num_rows($resultado)==1)
				{
					$fila=mysql_fetch_array($resultado);
					return $fila;
				} else {
					return false;
				}
				}
				
				while ($fila=mysql_fetch_array($consulta_asig))
				
				{
					$i++;
					$con_pla_gua=verif_existe($cmb_pla_est,$cmb_sec,$cmb_men,$cmb_gra,$fila["cod_asig_prog"]);
					if ($con_pla_gua){
						$ha_bd=$con_pla_gua["ha"];
						$hp_bd=$con_pla_gua["hp"];
						$ord_bd=$con_pla_gua["orden"];
						} else {
							$ha_bd="";
							$hp_bd="";
							$ord_bd=$fila["orden"];
						}
						
				?>
          

          <tr height="20px">
            <td>
            <input type="hidden" id="txt_cod_mat[<?PHP echo $i?>]"  name="txt_cod_mat[<?PHP echo $i?>]" value="<?php echo $fila["cod_asig_prog"];?>"/>
            <input type="checkbox" id="chk_cod_mat[<?PHP echo $i?>]"  name="chk_cod_mat[<?PHP echo $i?>]" <?php if ($con_pla_gua) echo " checked"; ?> /></td>
            <td><?php echo $fila["cod_asig_prog"];?></td>
						<td width="..."><?php echo $fila["des_mat_prog"]." - (".$fila["mat_prog_cor"].")";?></td>
            
            <td align="center">
            
            <select name="txt_ha[<?PHP echo $i?>]" id="txt_ha[<?PHP echo $i?>]" class="cssf validate[required,custom[integer],min[0]]" size="1">
            <?php
						for ($ha=0;$ha<=12;$ha++){
						?>
            <option value="<?php echo $ha;?>" <?php if ($ha==$ha_bd) echo " selected ";?>><?php echo $ha;?></option>
            <?php
							}
						?>
            </select>
            </td>
            <td align="center">
            <select name="txt_hp[<?PHP echo $i?>]" id="txt_hp[<?PHP echo $i?>]" class="cssf validate[required,custom[integer],min[0]]" size="1">
            <?php
						for ($hp=0;$hp<=12;$hp++){
						?>
            <option value="<?php echo $hp;?>"  <?php if ($hp==$hp_bd) echo " selected ";?>><?php echo $hp;?></option>
            <?php
							}
						?>
            </select>
            </td>
            <td align="center">
            <select name="txt_ord[<?PHP echo $i?>]" id="txt_ord[<?PHP echo $i?>]" class="cssf validate[required,custom[integer],min[0]]" size="1">
            <?php
						for ($or=0;$or<=mysql_num_rows($consulta_asig);$or++){
						?>
            <option value="<?php echo $or?>"  <?php if ($or==$ord_bd) echo " selected ";?>><?php echo $or;?></option>
            <?php
							}
						?>
            </select>
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
    <button type="submit" formaction="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=guardar_asig" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" title="Aplicar asignaci&oacute;n al plan de estudios seleccionados" onclick="return confirmSubmit()">
    <span class="ui-button-text"><img src="../images/icons_menu/x32/diskette_x32.png" width="24" height="24" align="absmiddle">&nbsp;Aplicar cambios</span>
    </button>
<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="24" height="24" align="absmiddle"> Reestablecer</span>
</button>    
  </fieldset>
</form>
<?php
	} //cierro el si se envio el form  
	}
	if (!empty($_POST["frm_asig_mat"])){
		echo "<pre>";
		print_r($_POST["chk_cod_mat"]);
		echo "</pre>";
		}
	?>