<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<?php
	if (empty($_POST["cmb_tema"])){
		$tema="siregest";
		setcookie("tema",$tema,time()+365);
		//$_SESSION["tema"]="siregest";
		} else {
			$tema=$_POST["cmb_tema"];
			$_SESSION["tema"]=$_POST["cmb_tema"];
			setcookie("tema",$tema,time()+3600,"/");
			$url="tema.php?id_func=".$_GET["id_func"]."&accion=cambiar&tema=".$_SESSION["tema"];
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 0);
</script>';
			//header("location:$url");
exit();			

		}
		  //include_once("../funciones/funcionesPHP.php");
	//mostrar_box("inf",true,"CONFIGURACI&Oacute;N ACTUAL","El tema aplicado actualmente es: ".$_SESSION["tema"]);

?>             
<form id="form_crear" name="form_crear" action="<?php echo "tema.php?id_func=".$_GET["id_func"]."&accion=cambiar&tema=".$_SESSION["tema"] ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->

<fieldset>
<legend>ESQUEMA DE COLORES::</legend>

<table border="0">
<tr>
  <td width="-1">
  <div class="ctrlHolder">

<label for="cmb_color">Seleccione la combinaci&oacute;n</label>
            de colores <br>
              <SELECT NAME="cmb_tema" id="cmb_tema" SIZE=1  class="mf validate[required]" onchange = "submit();"> 
<option value="">SELECCIONE...</option>
<?php
		$arr_temas=listar_directorios_ruta("../js/DataTables-1.9.0/media/themes/");	
$cont = 0;
for ($i=0;$i<count($arr_temas);$i++){
	if (!empty($_GET["tema"]) && $arr_temas[$i]==$_GET["tema"]){
		$selected=" selected ";
	} else {
			$selected="";
	}
	if ($arr_temas[$i]=="siregest"){
		$predet=" (predeterminado)";
	} else $predet="";
?>
	<option value="<?php echo $arr_temas[$i];?>" name="cmb_tema" <?php echo $selected;?>><?php echo $arr_temas[$i].$predet;?></option>
 <?php
 }
 ?>
</SELECT>
<?php
function listar_directorios_ruta($ruta){
	$arr_temas = array(); 
   // abrir un directorio y listarlo recursivo
   if (is_dir($ruta)) {
      if ($dh = opendir($ruta)) {
         while (($file = readdir($dh)) !== false) {
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
            //mostraría tanto archivos como directorios
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
            if (is_dir($ruta . $file) && $file!="." && $file!=".."){
               //solo si el archivo es un directorio, distinto que "." y ".."
							 $arr_temas[]=$file;
               //echo "<br>Directorio: $file";

							 
							 //si quiero listar subdirevtorios activo lo sigueinte
               //listar_directorios_ruta($ruta . $file . "/");
            } 
         }
      closedir($dh);
      }			
   }else
      {echo "<br>No es ruta valida";}
	return $arr_temas;
}
 
?>
              </SELECT>
              <p class="formHint">Requerido
              
              </p>
              
</div>
  </td>
</tr>


<tr><td colspan="2">
  <?php if ($array_permisos["mostrar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "tema.php?id_func=".$_GET["id_func"]."&accion=cambiar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_form_x32.png" width="20" height="20" align="absmiddle">&nbsp;Aplicar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle">Reestablecer</span>
  </button>
  </td>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<H2>MUESTRA:</H2>
			  <table id="tabla1" class="letra_16 mouse_hover"> 
        <thead> 
          <tr>
            <th width="17%">ID. FUNCI&Oacute;N</th>
            <th>FUNCI&Oacute;N</th>
            <th>ESTATUS</th>
            <?php if ($array_permisos["editar"]==true) {?>
            <th title="EDITAR REGISTROS">EDIT.</th>
            <?php }?>
            <?php if ($array_permisos["eliminar"]==true) {?>
            <th title="ELIMINAR REGISTROS">ELIM.</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
          <tr>
          
            <td><input type='checkbox' name='' id='' class="check" style="vertical-align:middle;"><label for=""></label></td>
            <td></td>
            <td>
             </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <?php if ($array_permisos["editar"]==true) {?>
            <td width="70" align="center">

                  <a id="resize" href="#" class="resize fancybox.iframe ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" title="Editar el registro">&nbsp;
                  <img src='../images/icons_menu/x32/editar_x32.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Edit.
                  </a>
             </td>
             <?php 
						}
						 ?>
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="" href="#" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/elim_papelera_x32.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
                  </a>            </td>
            <?php }?>
            
          </tr> 
         
        </tbody> 
      </table> 

<!-- FIN DEL FORM DATOS PERSONALES -->
</html>