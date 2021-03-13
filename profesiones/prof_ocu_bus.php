<!DOCTYPE HTML>
<html>
<head>
<?php 			
	unset($_SESSION["msg"]);
?>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "prof_ocu.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar:</legend>
<table align="center" width="100%">
<tr>
<td width="180PX">
<div class="ctrlHolder">
<label for="cmb_tip_bus">Tipo de busqueda</label>
<br>
<SELECT NAME="cmb_tip_bus" id="cmb_tip_bus" SIZE=1 class="mf validate[required]" onChange='
var valor = $("#cmb_tip_bus option:selected").html().toLowerCase();
$("#lbl_text_busc").text("Escriba "+valor+" a buscar");
$("#lbl_text_busc1").val("Escriba "+valor+" a buscar");
$("#txt_buscar").focus();'> 
<OPTION VALUE="ocup_profesion" <?php if (isset($_POST["cmb_tip_bus"]) && $_POST["cmb_tip_bus"]=="ocup_profesion") echo " selected " ?>>OCUPACI&Oacute;N / PROFESI&Oacute;N</OPTION>
<OPTION VALUE="cod_tip_ocup" <?php if (isset($_POST["cmb_tip_bus"]) && $_POST["cmb_tip_bus"]=="cod_tip_ocup") echo " selected " ?>>COD. PROFESI&Oacute;N / OCUPACI&Oacute;N</OPTION>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de b&uacute;squeda</p>
</div></td>
<td width="200">
<div class="ctrlHolder">

  <label for="txt_buscar" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba la profesi&oacute;n / ocupaci&oacute;n a buscar"; ?></label><br>
  <input name="txt_buscar" type="text" class="validate[required,minSize[1]] text-input mf"  id="txt_buscar" tabindex="0" value="<?php if (isset($_POST['txt_buscar'])){ echo $_POST['txt_buscar'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el texto a buscar"; ?>">
  <p class="formHint"> (*) Requerido </p>
</div>
</td>
<td>  
<button formaction="<?php echo "prof_ocu.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> 
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_buscar"]) && isset($_POST["cmb_tip_bus"]) && isset($_GET['id_func'])){
		$sel_combo=strtoupper($_POST['cmb_tip_bus']);
		$texto_buscar=$_POST["txt_buscar"];
		$campo_buscar=$_POST["cmb_tip_bus"];
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
		$consulta=ejecuta_sql("select cod_tip_ocup,ocup_profesion,visible from tip_ocup ORDER BY ocup_profesion ASC",true);} else {
		$consulta=ejecuta_sql("select cod_tip_ocup,ocup_profesion,visible FROM tip_ocup 
		where $campo_buscar LIKE '%$texto_buscar%' ORDER BY ocup_profesion ASC",true);} 
		
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="prof_ocu.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['cod_tip_ocup'];
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
<table id="tablasinbtn" class="letra_16 mouse_hover" width="..."> 
        <thead> 
          <tr>
            <th width="85px">C&Oacute;DIGO</th>
            <th width="...">PROFESI&Oacute;N</th>
            <th width="100">ESTATUS           </th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="DETALLES" width="80px">DETALLE</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <td><?php echo $fila["cod_tip_ocup"]?></td>
            <td><?php echo $fila["ocup_profesion"]?></td>
            <td align="center"><?php 
							if ($fila["visible"]==true){
								echo "ACTIVO";
							} else {
							echo "DESHABILITADO";}
						?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="prof_ocu.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['cod_tip_ocup']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar" >&nbsp;
                  <img src='../images/icons_menu/x32/consul_nota.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Mostrar&nbsp;
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
	} //cierro el si se envio el form  
	?>
<!-- FIN DE BUSCAR-->		
</html>