<?php
include_once("../funciones/funcionesPHP.php");
if (!isset($_POST["cmb_secc"]) && empty($_POST["cmb_secc"])){
?>
<form id="form_buscar" name="form_buscar" action="<?php echo "boletines.php?id_func=".$_GET["id_func"]."&accion=por_seccion#form_estud" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar secciones - asignatura:</legend>
<table align="center" width="100%">
<tr>
  <td colspan="4"><div class="ctrlHolder">
<?php
if (isset($_SESSION['id_grupo_usuario']) && $_SESSION['id_grupo_usuario']=="G0001"){
$sql="select cod_plantel,den_plantel from instituciones where activa=true order by den_plantel,id_dis_esc asc";
} else {
$sql="select cod_plantel,den_plantel from instituciones where activa=true and cod_plantel='".$_SESSION["cod_plantel_ses"]."' order by den_plantel,id_dis_esc asc";
}
$consulta=ejecuta_sql($sql,0);
?>
<label for="cmb_plan">Plantel o instituci&oacute;n</label><br>
            <SELECT NAME="cmb_plan" id="cmb_plan" SIZE=1  class="lf validate[required]" style="width:98%" onChange="$('#cmb_anno_esc option:selected').removeAttr('selected');$('#cmb_gra').html('');$('#cmb_secc').html('');$('#cmb_asig').html('');"> 
            
                
                <?php 
								//si esta vacio el codigo de sesion del plantel es porq es administrador entonces pido que seleccione el plantel si no lo coloco directamente para buscar las secciones por grado para el codigo sesion del plantel
								if (empty($_SESSION["cod_plantel_ses"])){
									echo '<option value="">SELECCIONE...</option>';
								} 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>' <?php if (isset($_POST["cmb_plan"]) && $_POST["cmb_plan"]==$fila['cod_plantel']){echo " selected";} ?>><?php echo $fila["den_plantel"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> (*) Seleccione el plantel</p>
</div></td>
  </tr>
<tr>
  <td><div class="ctrlHolder">
    <label for="cmb_anno_esc">A&ntilde;o escolar</label>
    <br>
    <SELECT NAME="cmb_anno_esc" id="cmb_anno_esc" SIZE=1 class="sf validate[required]" onchange="$('#cmb_gra').html('');$('#cmb_secc').html('');$('#cmb_asig').html('');"> 
    <option value="">SELECCIONE...</option>
    <?php
      //include_once("../funciones/funcionesPHP.php");
			if (isset($_SESSION['id_grupo_usuario']) && ($_SESSION['id_grupo_usuario']=="G0001" ||  $_SESSION['id_grupo_usuario']=="G0002" ||  $_SESSION['id_grupo_usuario']=="G0003")){
      $consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where visible=true order by cod_anno_esc DESC",true);} else {
				$consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where cerrado=false order by cod_anno_esc DESC",true);
				
			}
      //si hay registros para mostrar
      if ($consulta){
			
      while ($fila=mysql_fetch_array($consulta)){
        //if (!empty($_POST["cmb_anno_esc"]) && $_POST["cmb_anno_esc"]==$fila['cod_anno_esc']){$seleccionado= " SELECTED=SELECTED ";} else {$seleccionado= "";};			
        echo "<OPTION VALUE='".$fila['cod_anno_esc']."' >".$fila["cod_anno_esc"]."</OPTION>";
      }
      }
    ?>
    </SELECT>
    <p class="formHint"> (*) a&ntilde;o escolar a inscribir</p>
    </div></td>
<td>
<div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="sf validate[required]" onChange="$('#cmb_secc').html('');$('#cmb_asig').html('');"> 
<option value="" style="width:100%">SELECCIONE...</option>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>
</td>
<td><div class="ctrlHolder">
  <label for="cmb_secc">Secci&oacute;n</label>
  <br>
  <SELECT name="cmb_secc" id="cmb_secc" SIZE=1 class="sf validate[required]" onChange="$('#cmb_asig').html('');"> 
  <option value="">SELECCIONE...</option>

  </SELECT>
  <p class="formHint"> (*) secci&oacute;n disponible</p>
</div></td>
<td><button formaction="<?php echo "boletines.php?id_func=".$_GET["id_func"]."&accion=por_seccion#form_estud" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit"> <span class="ui-button-text"><img src="../images/sistema/users_search.png" width="28" height="28" align="absmiddle">&nbsp;Buscar estudiantes</span> </button></td>
  
</tr>
</table>   
</fieldset>   
</legend>         
</form>
<?php
} // fin de si se envio la seccion
?>
<?php
if (isset($_POST["cmb_secc"]) && !empty($_POST["cmb_secc"])){
$cod_plantel=$_POST["cmb_plan"];
$cod_anno_esc=$_POST["cmb_anno_esc"];
$cod_grado=$_POST["cmb_gra"];
$cod_seccion=$_POST["cmb_secc"];
$sql_alumnos="SELECT 
DISTINCT alum_insc_notas.id_personal,
datos_per.num_identificacion,
datos_per.nombres,
datos_per.apellidos,
tip_doc_per.tipo_doc,
tip_doc_per.tipo_doc_abr,
tip_doc_per.poner_num,
tip_doc_per.separador,
tip_doc_per.num_con_punto
 FROM 
(alum_insc_notas 
 INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
 INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
)
WHERE 
cod_anno_esc='$cod_anno_esc' AND 
cod_grado='$cod_grado' AND 
id_seccion='$cod_seccion'
 ORDER BY datos_per.nombres,datos_per.apellidos ASC";
$cons_alumn=ejecuta_sql($sql_alumnos,true);
if ($cons_alumn){
?>
<form id="form_estud" name="form_estud" action="<?php echo "planilla_boleta.php?id_func=".$_GET["id_func"]."&accion=genera_boleta&tipo=seccion";?>" method="post" enctype="multipart/form-data" class="uniForm" target="_blank">
<fieldset>
<legend>Estudiantes inscritos:</legend>
<input type="hidden" name="txt_cod_dea_ocu" value="<?php echo $cod_plantel;?>" />
<input type="hidden" name="txt_anno_esc_ocu" value="<?php echo $cod_anno_esc;?>" />
<input type="hidden" name="txt_gra_ocu" value="<?php echo $cod_grado;?>" />
<div align="right">
<button type="submit" formaction="<?php echo "planilla_boleta.php?id_func=".$_GET["id_func"]."&accion=genera_boleta&tipo=seccion";?>"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" formtarget="_blank"> <span class="ui-button-text"><img src="../images/sistema/select_show.png" width="24" height="24" align="absmiddle">&nbsp;Generar boleta a estudiantes seleccionados</span> </button>
</div><br />
<table id="tabla_alumnos" width="100%" border="0" class="letra_16 mouse_hover" style="text-transform:uppercase;font-size:12px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
<thead>
  <tr>
    <th scope="col" width="5px"><input name="checkAll" type="checkbox" id="checkAll"  title="Seleccionar todos / quitar selecci&oacute;n" onclick="checkTodos(this.id,'tabla_alumnos');" checked="checked"   /></th>
    <th width="85px">N&deg; C&Eacute;DULA</th>
    <th>NOMBRES</th>
    <th>APELLIDOS</th>
    <th width="110px">GENERAR</th>
  </tr>
 </thead>
  <?php
		$i=0;
		while ($fila_alum=mysql_fetch_array($cons_alumn)){
		$i++;
		$id_alumno=$fila_alum["id_personal"];
		$num_id_per=$fila_alum["num_identificacion"];
		$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
		$poner_num=$fila_alum["poner_num"];
		$separador=$fila_alum["separador"];
		$num_con_punto=$fila_alum["num_con_punto"];
		$nombres=$fila_alum["nombres"];
		$apellidos=$fila_alum["apellidos"];
			
	?>
  <tr>
    <td><input type="hidden" name="txt_id_alum[<?php echo $i;?>]" id="txt_id_alum[<?php echo $i;?>]" value="<?php echo $id_alumno;?>" />
    <input name="chk_id_alum[<?php echo $i;?>]" id="chk_id_alum[<?php echo $i;?>]" type="checkbox" checked="checked" /></td>
    <td><?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto);?></td>
    <td><?php echo $nombres;?></td>
    <td><?php echo $apellidos;?></td>
    <td align="center"><a href="<?php 
		$txt_cod_dea_ocu=$_POST["cmb_plan"];
		
		echo "planilla_boleta.php?id_func=".$_GET["id_func"]."&accion=genera_boleta&tipo=individual&id_alum=$id_alumno&txt_anno_esc_ocu=$cod_anno_esc&txt_cod_dea_ocu=$cod_plantel&txt_gra_ocu=$cod_grado";?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize" ><span class="ui-button-text"><img src="../images/sistema/preferences-contact-list.png" width="20" height="20" align="absmiddle">&nbsp;Ver</span></a></td>
  </tr>
  <?php
		} // fin while
	?>
</table>
<br /><button type="submit" formaction="<?php echo "planilla_boleta.php?id_func=".$_GET["id_func"]."&accion=genera_boleta&tipo=seccion";?>"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" formtarget="_blank"> <span class="ui-button-text"><img src="../images/sistema/select_show.png" width="24" height="24" align="absmiddle">&nbsp;Generar boleta a estudiantes seleccionados</span> </button>
</fieldset>
</form>
<?php
} // fin de si hubo consulta de alumnos
} // fin de si se envio la seccion al buscar estudiantes
?>