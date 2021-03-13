<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar usuarios:</legend>
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
<OPTION VALUE="ncp" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="ncp") echo " selected " ?>>N&deg; C&Eacute;DULA</OPTION>
<OPTION VALUE="nom" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="nom") echo " selected " ?>>NOMBRES</OPTION>
<OPTION VALUE="ape" <?php if (isset($_POST["cmb_tip_doc_b"]) && $_POST["cmb_tip_doc_b"]=="ape") echo " selected " ?>>APELLIDOS</OPTION>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de b&uacute;squeda</p>
</div></td>
<td width="200">
<div class="ctrlHolder">

  <label for="txt_cedula" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba N&deg; de c&eacute;dula a buscar"; ?></label><br>
  <input name="txt_cedula" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_cedula" tabindex="0" value="<?php if (isset($_POST['txt_cedula'])){ echo $_POST['txt_cedula'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba N&deg; de c&eacute;dula a buscar"; ?>">
  
  <p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>  
<button formaction="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
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
			case "NCP":
				$campo_buscar="num_identificacion";
				break;
			case "NOM":
				$campo_buscar="nombres";
				break;	
			case "APE":
				$campo_buscar="apellidos";
				break;							
			default:
				$campo_buscar="id_personal";
				break;
		}
		$consulta=ejecuta_sql("select id_usuario,datos_per.nombres,datos_per.apellidos from (usuarios INNER JOIN datos_per on usuarios.id_usuario=datos_per.id_personal) where $campo_buscar like '%".$texto_buscar."%' AND id_usuario<>'CIS_ADMIN'",true);
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="usuarios.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$fila['id_usuario'];
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
            <th width="85px">N&deg; CEDULA    </th>
            <th width="190">NOMBRES             </th>
            <th width="190">APELLIDOS           </th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="Ver" width="80px">Ver</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <td><?php echo $fila["id_usuario"]?></td>
            <td><?php echo $fila["nombres"]?></td>
            <td><?php echo $fila["apellidos"]?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="usuarios.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_per={$fila['id_usuario']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Administrar &eacute;ste usuario" >&nbsp;
                  <img src='../images/icons_menu/x32/folder_user.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Abrir
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