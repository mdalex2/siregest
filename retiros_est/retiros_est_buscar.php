<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
<?php 
if (empty($_POST["txt_cedula"])){
?>                  
<form id="form_buscar" name="form_buscar" action="<?php echo "retiros_est.php?id_func=".$_GET["id_func"]."&accion=consultar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar estudiante retirado:</legend>
<table align="center" width="100%">
<tr>
  <td colspan="3">
<div class="ctrlHolder">
<?php
if (isset($_SESSION['id_grupo_usuario']) && $_SESSION['id_grupo_usuario']=="G0001"){
$sql="select cod_plantel,den_plantel from instituciones where activa=true order by den_plantel,id_dis_esc asc";
} else {
$sql="select cod_plantel,den_plantel from instituciones where activa=true and cod_plantel='".$_SESSION["cod_plantel_ses"]."' order by den_plantel,id_dis_esc asc";
}
$consulta=ejecuta_sql($sql,0);
?>
<label for="cmb_plan">Plantel o instituci&oacute;n</label><br>
            <SELECT NAME="cmb_plan" id="cmb_plan" SIZE=1  class="lf validate[required]" style="width:98%" onChange="$('#cmb_director').html('');"> 
            <option value="">SELECCIONE...</option>
                
                <?php 
								 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>'><?php echo $fila["den_plantel"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> (*) Seleccione el plantel</p>
</div>  </td>
  </tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      
  <label for="cmb_director">Director(a)</label>
  <br>
      <SELECT NAME="cmb_director" id="cmb_director" SIZE=1  class="lf validate[required]"> 
        <option value="">SELECCIONE...</option>
        </SELECT>
      <input type="checkbox" name="chk_enc" id="chk_enc" />
      <label for="chk_enc">Encargado(a)</label>
      <p class="formHint"> (*) Seleccione qui&eacute;n firmar&aacute; la constancia</p>
  </div>
  </td>
  </tr>
<tr>
<td width="180">
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

  <label for="txt_cedula" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba N&deg; de c&eacute;dula del estudiante retirado"; ?></label><br>
  <input name="txt_cedula" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_cedula" tabindex="0" value="<?php if (isset($_POST['txt_cedula'])){ echo $_POST['txt_cedula'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba N&deg; de c&eacute;dula a buscar"; ?>">
  
  <p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>  
<button formaction="<?php echo "retiros_est.php?id_func=".$_GET["id_func"]."&accion=consultar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> 
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php
} // fin de si se envio la busqueda
?>
<?php 
	if (isset($_POST["txt_cedula"]) && isset($_POST["cmb_tip_doc_b"]) && isset($_GET['id_func'])){
		$sel_combo=strtoupper($_POST['cmb_tip_doc_b']);
		$texto_buscar=$_POST["txt_cedula"];
		$cod_plant_post=$_POST["cmb_plan"];
		switch ($sel_combo){
			case "NCP":
				$campo_buscar="datos_per.num_identificacion";
				break;
			case "NOM":
				$campo_buscar="datos_per.nombres";
				break;	
			case "APE":
				$campo_buscar="datos_per.apellidos";
				break;							
			default:
				$campo_buscar="alumn_retiros.id_personal";
				break;
		}
		$consulta=ejecuta_sql("select 
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	datos_per.nombres,
	datos_per.apellidos,
	alumn_retiros.id_personal,
	alumn_retiros.cod_anno_esc,
	alumn_retiros.cod_plantel,
	alumn_retiros.id_seccion,
	alumn_retiros.fecha_ret,
	alumn_retiros.guardado_por,
	alumn_retiros.fecha_g from (alumn_retiros
	INNER JOIN datos_per ON datos_per.id_personal=alumn_retiros.id_personal 
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
			) where $campo_buscar like '%".$texto_buscar."%' AND datos_per.id_personal<>'CIS_ADMIN' AND alumn_retiros.cod_plantel='$cod_plant_post'",false);
		if ($consulta)
			{
?>
<h2>Resultado de la b&uacute;squeda</h2>
<table id="tablasinbtn" class="letra_16 mouse_hover" width="100%"> 
        <thead> 
          <tr>
            <th width="100px" title="N&deg; de identificaci&oacute;n">N&deg; IDENT.</th>
            <th width="150">NOMBRES             </th>
            <th width="150">APELLIDOS           </th>
            <th width="90px">FECHA RETIRO</th>
            <th width="60px" title="Constancias">CONST.</th>
            <th width="70px" title="Eliminar">ELIM.</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila_alum=mysql_fetch_array($consulta))
				{
				$id_per=$fila_alum["id_personal"];
		$num_id_per=$fila_alum["num_identificacion"];
				$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
				$poner_num=$fila_alum["poner_num"];
				$separador=$fila_alum["separador"];
				$num_con_punto=$fila_alum["num_con_punto"];
		
				$nombre_alumno=ucwords(strtolower($fila_alum["nombres"]));
				$apellido_alumno=ucwords(strtolower($fila_alum["apellidos"]));
					
				$cedula_formato=formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto);
				$cod_anno_esc=$fila_alum["cod_anno_esc"];
				$cod_plantel=$fila_alum["cod_plantel"];
				$id_seccion=$fila_alum["id_seccion"];
				$fecha_ret=date("d-m-Y",strtotime($fila_alum["fecha_ret"]));
				$id_director=$_POST["cmb_director"];
				if (!empty($_REQUEST["chk_enc"])){
				$dir_encarg="(E)";
			} else {
				$dir_encarg="";
			}			

				?>
          <tr>
            <td><?php echo $cedula_formato;?></td>
            <td><?php echo $nombre_alumno;?></td>
            <td><?php echo $apellido_alumno;?></td>
            <td align="center"><?php echo $fecha_ret;?></td>
            <?php 
						$url="constancia_retiro_planilla.php?id_per=$id_per&cod_plan=$cod_plantel&cod_anno_esc=$cod_anno_esc&id_dir=$id_director&dir_enc=$dir_encarg&id_secc=$id_seccion";

						?>
            <td align="center"><a id="resize" href="<?php echo $url;?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Ver constancia de retiro" >&nbsp; <img src='../images/sistema/lupa_hoja.png' title="Ver constancia de retiro" width='20' heigth='20px' align='absmiddle'></img>&nbsp;Ver</a></td>
            <td align="center"><a id="resize" href="../datos_per/datos_per.php?<?php echo "id_func=00051&accion=eliminar&id_per={$id_per}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar retiro del alumno">&nbsp; <img src='../images/sistema/computer_delete.png' width='20'  heigth='20px' align='absmiddle'></img>&nbsp;Elim </a></td>
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
			}// fin de si hubo consulta
			else {
				echo mostrar_box("exc",false,"NOTIFICACI&Oacute;N","El estudiante no se encuentra retirado, verif&iacute;que los datos e intente de nuevo");
				echo mostrar_btn_imp_reg();
				
				
			} //fin esle si no hay registros que mostrar
	} //cierro el si se envio el form  
	?>
<!-- FIN DE BUSCAR-->		
</html>