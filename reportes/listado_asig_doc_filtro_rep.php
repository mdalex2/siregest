<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "listado_asig_doc_rep.php?id_func=".$_GET["id_func"]."&accion=ver_reporte" ?>" method="post" enctype="multipart/form-data" class="uniForm" target="_blank">
<fieldset>
<legend>Buscar asignaciones:</legend>
<table align="center" width="100%">
<tr>
  <td colspan="3"><div class="ctrlHolder">
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
    </div></td>
<td>
<div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="mf" onChange="$('#cmb_secc').html('');$('#cmb_asig').html('');"> 
<option value="">TODOS...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$cod_plantel_session="";
	if (isset($_SESSION["cod_plantel_ses"]) && !empty($_SESSION["cod_plantel_ses"])){
		$cod_plantel_session=$_SESSION["cod_plantel_ses"];
		} else {
			if (!empty($_POST["cmb_plan"])){
				$cod_plantel_session=$_POST["cmb_plan"];
				}
			} // fin else
	$consulta=ejecuta_sql("select DISTINCT  inst_secciones.cod_grado,grados_esc.grado_letras from (inst_secciones 
	INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
	) WHERE inst_secciones.cod_plantel='$cod_plantel_session' AND grados_esc.visible=true order by grados_esc.orden ASC",false);
	//si hay registros para mostrar
  if ($consulta){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_gra"]) && $_POST["cmb_gra"]==$fila["cod_grado"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_grado']."' {$selected}>".$fila["grado_letras"]."</OPTION>";
	}
	} else //si no hubo consulta se grados o años
		{
			echo "<OPTION VALUE='' SELECTED>SIN ASIGNACI&Oacute;N</OPTION>";
		}
?>
</SELECT>
<p class="formHint">Libre=buscar en todo</p>
</div>
</td>
<td><div class="ctrlHolder">
  <label for="cmb_secc">Secci&oacute;n</label>
  <br>
  <SELECT name="cmb_secc" id="cmb_secc" SIZE=1 class="sf" onChange="$('#cmb_asig').html('');"> 
  <option value="">TODOS...</option>

  </SELECT>
  <p class="formHint"> Libre=buscar en todo</p>
</div></td>
  
</tr>
<tr>
  <td colspan="3">
    <button formaction="<?php echo "listado_asig_doc_rep.php?id_func=".$_GET["id_func"]."&accion=ver_reporte" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit" formtarget="_blank"> <span class="ui-button-text"><img src="../images/sistema/mos_rep.png" width="20" height="20" align="absmiddle">&nbsp;Mostrar reporte</span> </button></td>
  </tr>
</table>   
</fieldset>            
</form>
</legend>

</html>