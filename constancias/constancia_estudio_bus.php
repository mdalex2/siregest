<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "constancia_estudio.php?id_func=".$_GET["id_func"]."&accion=mostrar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar secciones:</legend>
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
  <td colspan="2"><div class="ctrlHolder">

<label for="cmb_director">Director(a)</label>
<br>
   <SELECT NAME="cmb_director" id="cmb_director" SIZE=1  class="lf validate[required]" style="width:98%"> 
     <option value="">SELECCIONE...</option>
   </SELECT>
              <p class="formHint"> (*) Seleccione qui&eacute;n firmar&aacute; la constancia</p>
</div></td>
  <td colspan="2"><div class="ctrlHolder">
    <label for="cmb_valid">Valido por</label><br>
    <select name="cmb_valid" id="cmb_valid" size=1 class="csf validate[required]">
      <option value="" selected>...</option>
      <option value="0">SIN VENCIMIENTO</option>
      <?php 
				for ($i=1;$i<12;$i++){
        echo "<OPTION VALUE='".$i."' >".$i."</OPTION>";
      }
    ?>
      </select> <label>meses</label>
    <p class="formHint"> (*) Tiempo de valides de la constancia</p>
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
  <input type="text" name="txt_buscar" id="txt_buscar" value="" class="validate[required]">
  <p class="formHint"> (*) Requerido</p>
</div></td>
<td>    <button formaction="<?php echo "constancia_estudio.php?id_func=".$_GET["id_func"]."&accion=mostrar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit"> <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span> </button></td>
  
</tr>
</table>   
</fieldset>            
</form>
</legend>

</html>