<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar plan de estudio:</legend>
<table align="center" width="100%">
<tr>
<td width="180PX">
<div class="ctrlHolder">
<label for="cmb_tip_bus">Tipo de busqueda</label>
<br>
<SELECT NAME="cmb_tip_bus" id="cmb_tip_bus" SIZE=1 class="mf validate[required]" onChange='
var valor = $("#cmb_tip_bus option:selected").html().toLowerCase();
$("#lbl_text_busc").text("Escriba "+valor);
$("#lbl_text_busc1").val("Escriba "+valor);
$("#txt_buscar").focus();'> 
<OPTION VALUE="CP" <?php if (isset($_POST["cmb_tip_bus"]) && $_POST["cmb_tip_bus"]=="CP") echo " selected " ?>>C&Oacute;DIGO DEL PLAN DE ESTUDIO</OPTION>
<OPTION VALUE="PE" <?php if (isset($_POST["cmb_tip_bus"]) && $_POST["cmb_tip_bus"]=="PE") echo " selected " ?>>PLAN DE ESTUDIO</OPTION>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de b&uacute;squeda</p>
</div></td>
<td width="220px">
<div class="ctrlHolder">

  <label for="txt_buscar" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el c&oacute;digo del plan de estudio"; ?></label><br>
  <input name="txt_buscar" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_buscar" tabindex="0" value="<?php if (isset($_POST['txt_buscar'])){ echo $_POST['txt_buscar'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el texto a buscar"; ?>">
  <p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>  
<button formaction="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> 
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (!empty($_POST["txt_buscar"]) && !empty($_POST["cmb_tip_bus"]) && !empty($_GET['id_func'])){
		$sel_combo=strtoupper($_POST['cmb_tip_bus']);
		$texto_buscar=$_POST["txt_buscar"];
		switch ($sel_combo){
			case "CP":
				$campo_buscar="cod_plan_nivel_me";
				break;
			case "PE":
				$campo_buscar="nivel_plan_est";
				break;	
			default:
				$campo_buscar="cod_plan_nivel_me";
				break;
		}
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
		$consulta=ejecuta_sql("select
		id_plan_nivel_est,
		cod_plan_nivel_me,
		nivel_plan_est,
		visible,
		datos_per.nombres,
		datos_per.apellidos,
		plan_est_tip.fecha_g ,
		fecha_pub 
		from (plan_est_tip  
		INNER JOIN datos_per on plan_est_tip.guardado_por=datos_per.id_personal 
		) ORDER BY nivel_plan_est ASC",true);} else {
		$consulta=ejecuta_sql("select
		id_plan_nivel_est,
		cod_plan_nivel_me,
		nivel_plan_est,
		visible,
		datos_per.nombres,
		datos_per.apellidos,
		plan_est_tip.fecha_g,
		fecha_pub   
		from (plan_est_tip  
		INNER JOIN datos_per on plan_est_tip.guardado_por=datos_per.id_personal 
		) where $campo_buscar like '%".$texto_buscar."%' ORDER BY nivel_plan_est ASC",true);}
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="plan_est.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['id_plan_nivel_est'];
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
            <th width="85px">COD. PLAN ESTUDIO    </th>
            <th width="...">PLAN ESTUDIO             </th>
            <th width="100">VIGENCIA</th>
            <th width="100">ESTATUS</th>
            <th width="..." title="Usuario que realiz&oacute; la actuaci&oacute;n">U.</th>
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
            <td><?php echo $fila["cod_plan_nivel_me"]?></td>
            <td><?php echo $fila["nivel_plan_est"]?></td>
            <td align="center"><?php echo strtoupper(formato_fecha("MA",$fila["fecha_pub"]))?></td>
            <td align="center"><?php 
							if ($fila["visible"]==true){
								echo "ACTIVA";
							} else {
							echo "DESHABILITADA";}
						?></td>
            <td align="center">
							<a href="#" class="tooltip" title="<?php 
							echo $fila["nombres"]." ".$fila["apellidos"]."<br>".formato_fecha("LH",$fila["fecha_g"]);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>
            </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="plan_est.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['id_plan_nivel_est']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar" >&nbsp;
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
	$_SESSION["msg"]=""; 
	?>
<!-- FIN DE BUSCAR-->		
</html>