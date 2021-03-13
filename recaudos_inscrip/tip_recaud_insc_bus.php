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
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "tip_recaud_insc.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar recaudos de inscripci&oacute;n:</legend>
<table align="center" width="100%">
<tr>
<td width="180PX">
<div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="mf"> 
<option value="T">TODOS...</option>
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
</div></td>
<td width="200">
<div class="ctrlHolder">

  <label for="txt_buscar" id="lbl_text_busc">Escriba recaudo a buscar</label><br>
  <input name="txt_buscar" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_buscar" tabindex="0" value="<?php if (isset($_POST['txt_buscar'])){ echo $_POST['txt_buscar'];}?>" maxlength="20" autofocus/>
  <p class="formHint"> (*) Requerido </p>
</div>
</td>
<td>  
<button formaction="<?php echo "tip_recaud_insc.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> 
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_buscar"]) &&  isset($_GET['id_func'])){
		$cod_grado=$_POST['cmb_gra'];
		if ($cod_grado=="T") {
			$filt_gra="";
		} else {
			$filt_gra=" and tip_recaudos.cod_grado='$cod_grado' OR todos=true ";
		}
		$texto_buscar=$_POST["txt_buscar"];
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
		$consulta=ejecuta_sql("select id_tip_recaudo ,descrip_recaudo,tip_recaudos.todos, tip_recaudos.visible,tip_recaudos.fecha_g,datos_per.nombres,datos_per.apellidos,grados_esc.grado_letras from (tip_recaudos 
		INNER JOIN datos_per on datos_per.id_personal=tip_recaudos.guardado_por
 		INNER JOIN grados_esc ON grados_esc.cod_grado=tip_recaudos.cod_grado) ORDER BY grados_esc.grado_letras,descrip_recaudo ASC",true);} else {
		$consulta=ejecuta_sql("select id_tip_recaudo ,descrip_recaudo,tip_recaudos.todos,tip_recaudos.visible,tip_recaudos.fecha_g,datos_per.nombres,datos_per.apellidos,grados_esc.grado_letras from (tip_recaudos 
 INNER JOIN datos_per on datos_per.id_personal=tip_recaudos.guardado_por
 INNER JOIN grados_esc ON grados_esc.cod_grado=tip_recaudos.cod_grado) where descrip_recaudo like '%$texto_buscar%' $filt_gra ORDER BY grados_esc.grado_letras,descrip_recaudo ASC",true);} 
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="tip_recaud_insc.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['id_tip_recaudo'];
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
<table id="tablasinbtn" class="letra_16 mouse_hover" width="100%"> 
        <thead> 
          <tr>
            <th width="85px">GRADO    </th>
            <th width="...">RECAUDO             </th>
            <th width="100">ESTATUS           </th>
            <th width="..." title="Usuario que efectu&oacute; la actuaci&oacute;n">U.</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="DETALLES" width="80px">DETALLE</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
					
					if ($fila["todos"]==true){
						$grado_letra="TODOS";
					} else {
						$grado_letra=$fila["grado_letras"];
					}
				?>
          <tr>
            <td><?php echo $grado_letra;?></td>
            <td><?php echo $fila["descrip_recaudo"]?></td>
            <td align="center"><?php 
							if ($fila["visible"]==true){
								echo "ACTIVO";
							} else {
							echo "DESHABILITADO";}
						?></td>
            <td align="center">
            
							<a href="#" class="tooltip" title="<?php echo $fila["nombres"]." ".$fila["apellidos"]."<br>".formato_fecha("LH",$fila["fecha_g"]);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>
            </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="tip_recaud_insc.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['id_tip_recaudo']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar" >&nbsp;
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