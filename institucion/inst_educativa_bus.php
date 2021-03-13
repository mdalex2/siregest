<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "inst_educativa.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar:</legend>
<table align="center" width="100%">
<tr>
<td width="180PX">
<div class="ctrlHolder">
<label for="cmb_tip_doc_b">Tipo de busqueda</label>
<br>
<SELECT NAME="cmb_tip_doc_b" id="cmb_tip_doc_b" SIZE=1 class="sf validate[required]" onChange='
var valor = $("#cmb_tip_doc_b option:selected").html().toLowerCase();
$("#lbl_text_busc").text("Escriba "+valor+" a buscar");
$("#lbl_text_busc1").val("Escriba "+valor+" a buscar");
$("#txt_cedula").focus();'> 
<OPTION VALUE="cod" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="cod") echo " selected " ?>>C&Oacute;DIGO DEA</OPTION>
<OPTION VALUE="den" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="den") echo " selected " ?>>DENOMINACION</OPTION>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de b&uacute;squeda</p>
</div></td>
<td width="200">
<div class="ctrlHolder">

  <label for="txt_cedula" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el c&oacute;digo a buscar"; ?></label><br>
  <input name="txt_cedula" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_cedula" tabindex="0" value="<?php if (isset($_POST['txt_cedula'])){ echo $_POST['txt_cedula'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el c&oacute;digo a buscar"; ?>">
  
  <p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>  
<button formaction="<?php echo "inst_educativa.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> 
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_cedula"]) && isset($_POST["cmb_tip_doc_b"]) && isset($_GET['id_func'])){
		$sel_combo=strtoupper($_POST['cmb_tip_doc_b']);
		$texto_buscar=$_POST["txt_cedula"];
		switch ($sel_combo){
			case "COD":
				$campo_buscar="cod_plantel";
				break;
			case "DEN":
				$campo_buscar="den_plantel";
				break;
				$campo_buscar="cod_plantel";
				break;
		}
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
			
		$consulta=ejecuta_sql("select cod_plantel,den_plantel,terr_estados.cod_estado_ter ,terr_estados.estado_ter,terr_poblados.poblado,instituciones.fecha_g,datos_per.nombres,datos_per.apellidos from (instituciones
INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado 
INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
INNER JOIN datos_per ON datos_per.id_personal=instituciones.guardado_por
 ) ",true);}  else {
			
		$consulta=ejecuta_sql("select cod_plantel,den_plantel,terr_estados.cod_estado_ter ,terr_estados.estado_ter,terr_poblados.poblado,instituciones.fecha_g,datos_per.nombres,datos_per.apellidos from (instituciones
INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado 
INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
INNER JOIN datos_per ON datos_per.id_personal=instituciones.guardado_por
 ) where $campo_buscar like '%".$texto_buscar."%'",true);} 
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="inst_educativa.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['cod_plantel'];
					echo '
					<script type="text/javascript">
						window.location="'.$url.'";
					</script>';
					//header("location:$url");
					exit();
					} 
					//cierro si solo se encontro un registro
				else
				{
?>
<table id="tablaPDF" class="letra_16 mouse_hover" width="..."> 
        <thead> 
          <tr>
            <th width="85px">C&Oacute;DIGO DEA</th>
            <th width="500px">PLANTEL / INSTITUCI&Oacute;N</th>
            <th width="190">UBICACI&Oacute;N</th>
             <th width="40px">USU.</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="MOSTRAR DATOS" width="80px">Edit./Most.</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <td><?php echo $fila["cod_plantel"]?></td>
            <td><?php echo $fila["den_plantel"]?></td>
            <td><?php echo $fila["estado_ter"]." / ".$fila["poblado"]?></td>
            <td align="center"><?php $fecha=formato_fecha("LH",$fila["fecha_g"]);echo "<img src='../images/sistema/user_comment.png' width='20' height='20' class='tooltip' title='".$fila["nombres"]." ".$fila["apellidos"]."<br/>".$fecha."'/>";?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="inst_educativa.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['cod_plantel']}&id_edo_ter={$fila['cod_estado_ter']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar / editar datos" >&nbsp;
                  <img src='../images/sistema/computer_edit.png' width='20' height="20" heigth='16px' align='absmiddle'></img>&nbsp;Mostrar&nbsp;
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
  <?php
			}
			}// fin de si hubo consulta
			$_SESSION["msg"]="";
	} //cierro el si se envio el form  
	
	?>
<!-- FIN DE BUSCAR-->		
</html>