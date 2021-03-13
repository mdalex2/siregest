<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "notas_cert.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar inscripciones para generar planilla de inscripci&oacute;n:</legend>
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
            <option value="">SELECCIONE...</option>
                
                <?php 
								 
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
    <SELECT NAME="cmb_anno_esc" id="cmb_anno_esc" SIZE=1 class="sf validate[required]"> 
      <option value="">SELECCIONE...</option>
      <?php
      //include_once("../funciones/funcionesPHP.php");
			if (isset($_SESSION['id_grupo_usuario']) && ($_SESSION['id_grupo_usuario']=="G0001" ||  $_SESSION['id_grupo_usuario']=="G0002" ||  $_SESSION['id_grupo_usuario']=="G0003")){
      $consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where visible=true order by cod_anno_esc DESC",true);} else {
				$consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where cerrado=false order by cod_anno_esc DESC",true);
				
			}      //si hay registros para mostrar
      if ($consulta){
			
      while ($fila=mysql_fetch_array($consulta)){
        if (!empty($_POST["cmb_anno_esc"]) && $_POST["cmb_anno_esc"]==$fila['cod_anno_esc']){$seleccionado= " SELECTED=SELECTED ";} else {$seleccionado= "";};			
        echo "<OPTION VALUE='".$fila['cod_anno_esc']."' $seleccionado>".$fila["cod_anno_esc"]."</OPTION>";
      }
      }
    ?>
      </SELECT>
    <p class="formHint"> (*) a&ntilde;o escolar a consultar</p>
    </div></td>
  <td><div class="ctrlHolder">
  <label for="cmb_tip_doc_b">Tipo de busqueda</label>
  <br>
  <SELECT NAME="cmb_tip_doc_b" id="cmb_tip_doc_b" SIZE=1 class="sf validate[required]" onChange='
var valor = $("#cmb_tip_doc_b option:selected").html().toLowerCase();
$("#lbl_text_busc").text("Escriba "+valor+" a buscar");
$("#lbl_text_busc1").val("Escriba "+valor+" a buscar");
$("#txt_buscar").focus();'> 
  <OPTION VALUE="datos_per.num_identificacion" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="ncp") echo " selected " ?>>N&deg; C&Eacute;DULA</OPTION>
  <OPTION VALUE="datos_per.nombres" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="nom") echo " selected " ?>>NOMBRES</OPTION>
  <OPTION VALUE="datos_per.apellidos" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="ape") echo " selected " ?>>APELLIDOS</OPTION>
  </SELECT>
  <p class="formHint"> (*) Seleccione el tipo de b&uacute;squeda</p>
  </div></td>
  <td><div class="ctrlHolder">
    <label id="lbl_text_busc">N&deg; c&eacute;dula</label>
    <br>
    <input type="text" name="txt_buscar" id="txt_buscar" value="<?php if (!empty($_POST["txt_buscar"])){echo $_POST["txt_buscar"];}?>" class="validate[required]">
    <p class="formHint"> (*) Requerido</p>
  </div></td>
  <td>    <button formaction="<?php echo "notas_cert.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit"> <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span> </button></td>
  
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_buscar"]) && isset($_POST["cmb_anno_esc"]) && isset($_GET['id_func'])){
		$campo_buscar=$_POST['cmb_tip_doc_b'];
		$texto_buscar=$_POST["txt_buscar"];
		$cod_anno_esc_bus=$_POST["cmb_anno_esc"];
		$valides=$_POST["cmb_valid"];
		$id_director=$_POST["cmb_director"];
		$cod_plantel=$_POST["cmb_plan"];
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
			
	$consulta=ejecuta_sql("select 
	DISTINCT 
	alum_insc_notas.id_personal,
	grados_esc.grado_letras,
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	datos_per.nombres,
	datos_per.apellidos,
	inst_secciones.seccion_largo ,
	alum_insc_notas.id_seccion 
	FROM (
	alum_insc_notas 
	INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN grados_esc ON grados_esc.cod_grado=alum_insc_notas.cod_grado
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion
	) WHERE alum_insc_notas.id_personal<>'CIS_ADMIN' AND cod_anno_esc='$cod_anno_esc_bus' and mat_pend=false",false);}  else {
	$consulta=ejecuta_sql("select 
	DISTINCT 
	alum_insc_notas.id_personal,
	grados_esc.grado_letras,
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	datos_per.nombres,
	datos_per.apellidos,
	inst_secciones.seccion_largo,
	alum_insc_notas.id_seccion 
	FROM (
	alum_insc_notas 
	INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN grados_esc ON grados_esc.cod_grado=alum_insc_notas.cod_grado
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion
	) WHERE $campo_buscar like '%".$texto_buscar."%' AND alum_insc_notas.id_personal<>'CIS_ADMIN' AND cod_anno_esc='$cod_anno_esc_bus' and mat_pend=false",false);	
		//$consulta=ejecuta_sql("select id_personal,num_identificacion,nombres,apellidos from datos_per where $campo_buscar like '%".$texto_buscar."%' AND id_personal<>'CIS_ADMIN'",true);
		} 
		if ($consulta)
			{
?>
<H2>RESULTADO DE LA B&Uacute;SQUEDA</H2>
<table id="tablasinbtn" class="letra_16 mouse_hover" width="100%"> 
        <thead> 
          <tr>
            <th width="15%">N&deg; CEDULA    </th>
            <th width="25%">NOMBRES             </th>
            <th width="25%">APELLIDOS           </th>
            <th title="" width="15%">GRADO / A&Ntilde;O</th>
            <th title="" width="10%">SECCI&Oacute;N</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="" width="15%">ABRIR.</th>
            <?php }?>
          </tr> 
  </thead> 
        <tbody> 
        <?php
				while ($fila_alum=mysql_fetch_array($consulta))
				{
		$id_alumno=$fila_alum["id_personal"];
		$num_id_per=$fila_alum["num_identificacion"];
		$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
		$poner_num=$fila_alum["poner_num"];
		$separador=$fila_alum["separador"];
		$num_con_punto=$fila_alum["num_con_punto"];
		$seccion_largo=$fila_alum["seccion_largo"];
		$id_seccion=$fila_alum["id_seccion"];
				?>
          <tr>
            <td><?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto); ?></td>
            <td><?php echo $fila_alum["nombres"]?></td>
            <td><?php echo $fila_alum["apellidos"]?></td>
            <td align="center"><?php echo $fila_alum["grado_letras"]?></td>
            <td align="center"><?php echo $seccion_largo;?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="planilla_inscrip.php?<?php echo "id_func=".$_GET['id_func']."&id_alum={$fila_alum['id_personal']}&cod_anno_esc=$cod_anno_esc_bus&cod_dea=$cod_plantel";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar constancia" >&nbsp;
                  <img src='../images/icons_menu/x32/lapiz_hoja.png' width='20' heigth='16px' align='absmiddle'></img>&nbsp;Mostrar&nbsp;
              </a>            </td>
            <?php 
              }
            ?>
            
          </tr> 
         <?php 
         } //fin de ciclo while
         ?>
        </tbody> 
</table>
<hr><div align="right">
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" align="absmiddle" height="20" width="20"> Ir atr&aacute;s</span>
</button>
</div>
  <?php
			}// fin de si hubo consulta
			else {
				mostrar_box("inf",false,"Notificaci&oacute;n","No se encontraron estudiantes en el periodo escolar seleccionado, verifique los datos suministrados e intente de nuevo");
				echo mostrar_btn_imp_reg();
			}
	} //cierro el si se envio el form  
	$_SESSION["msg"]="";
	?>
</html>