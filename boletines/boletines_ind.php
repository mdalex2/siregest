<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "boletines.php?id_func=".$_GET["id_func"]."&accion=nueva" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar estudiante a inscribir:</legend>
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
<td width="270">
<div class="ctrlHolder">

  <label for="txt_cedula" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba N&deg; de c&eacute;dula del estudiante a inscribir"; ?></label><br>
  <input name="txt_cedula" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_cedula" tabindex="0" value="<?php if (isset($_POST['txt_cedula'])){ echo $_POST['txt_cedula'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba N&deg; de c&eacute;dula a buscar"; ?>">
  
  <p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>  
<button formaction="<?php echo "boletines.php?id_func=".$_GET["id_func"]."&accion=nueva" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
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
		$consulta=ejecuta_sql("select id_personal,num_identificacion,nombres,apellidos,tip_doc_per.tipo_doc_abr from (datos_per
			INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
			) where $campo_buscar like '%".$texto_buscar."%' AND id_personal<>'CIS_ADMIN'",false);
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="boletines.php?id_func=".$_GET['id_func']."&accion=inscribir&id_per=".$fila['id_personal'];
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
<table id="tablasinbtn" class="letra_16 mouse_hover" width="648"> 
        <thead> 
          <tr>
            <th width="150px">N&deg; IDENTIFICACI&Oacute;N</th>
            <th width="190">NOMBRES             </th>
            <th width="190">APELLIDOS           </th>
            <th width="90px" title="Inscribir alumno">INSC.</th>
            <th width="80px" title="Ver expediente personal">VER</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <td><?php echo $fila["tipo_doc_abr"]."-".$fila["num_identificacion"]?></td>
            <td><?php echo $fila["nombres"]?></td>
            <td><?php echo $fila["apellidos"]?></td>
            <td align="center"><a id="resize" href="boletines.php?<?php echo "id_func=".$_GET['id_func']."&accion=inscribir&id_per={$fila['id_personal']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Inscribir &eacute;ste alumno" >&nbsp; <img src='../images/sistema/computer_go.png' title="Inscribir estudiante" width='20' heigth='20px' align='absmiddle'></img>&nbsp;Inscribir </a></td>
            <td align="center"><a id="resize" href="../datos_per/datos_per.php?<?php echo "id_func=00051&accion=mostrar&id_per={$fila['id_personal']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Ver datos del estudiante"  target="_blank">&nbsp; <img src='../images/sistema/lupa_hoja.png' width='20'  heigth='20px' align='absmiddle'></img>&nbsp;Ver </a></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
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
			else {
				$link_regis_alum="<b><a href=\"../datos_per/datos_per.php?id_func=00051&accion=nuevo\" target=\"_blank\"> haga click aqui</a></b>";
				echo mostrar_box("exc",false,"NOTIFICACI&Oacute;N","No se encontr&oacute; el estudiante, si desea registrar un estudiante nuevo  $link_regis_alum aqui o verif&iacute;que la informaci&oacute;n");
				
				
			} //fin esle si no hay registros que mostrar
	} //cierro el si se envio el form  
	?>
<!-- FIN DE BUSCAR-->		
</html>