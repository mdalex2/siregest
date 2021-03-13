<!-- PARA BUSCAR-->    
<form id="form_buscar" name="form_buscar" action="<?php echo "repre_agregar_frm.php?id_func=".$_GET["id_func"]."&accion=buscar&id_per=".$_GET["id_per"];?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar representante:</legend>
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
<button formaction="<?php echo "repre_agregar_frm.php?id_func=".$_GET["id_func"]."&accion=buscar&id_per=".$_GET["id_per"];?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> 
</td>
</tr>
</table>   
</fieldset>  
</legend>          
</form>
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
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
			
		$consulta=ejecuta_sql("select id_personal,num_identificacion,nombres,apellidos,tip_doc_per.tipo_doc_abr from (datos_per 
		INNER JOIN tip_doc_per on tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
		) where id_personal<>'CIS_ADMIN' AND id_personal<>'".$_GET["id_per"]."'",true);}  else {
			
		$consulta=ejecuta_sql("select id_personal,num_identificacion,nombres,apellidos,tip_doc_per.tipo_doc_abr from (datos_per 
		INNER JOIN tip_doc_per on tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
		) where $campo_buscar like '%".$texto_buscar."%' AND id_personal<>'CIS_ADMIN' AND id_personal<>'".$_GET["id_per"]."'",true);} 
		if ($consulta)
				{
?>
<table id="tabla_busc" class="letra_16 mouse_hover"> 
        <thead> 
          <tr>
            <th width="85px">N&deg; CEDULA    </th>
            <th>NOMBRES             </th>
            <th>APELLIDOS           </th>
            <th title="ABRIR EXPEDIENTE" width="80px">REGISTRAR</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <form id="frm_par[]" name="frm_par[]" action="repre_agregar_frm.php?<?php echo "id_func=".$_GET['id_func']."&accion=guardar_repre&id_per=".$_GET['id_per'];?>" method="post" enctype="multipart/form-data" class="uniForm">

            <td><?php echo $fila["tipo_doc_abr"]."-".number_format($fila["num_identificacion"], 0, ",", ".");?></td>
            <td><?php echo $fila["nombres"]?></td>
            <td><?php echo $fila["apellidos"]?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <td align="center">
            
 							<a id="resize" href="repre_agregar_frm.php?<?php echo "id_func=".$_GET['id_func']."&accion=selecc_par&id_per=".$_GET['id_per'];?>&id_rep=<?php echo $fila["id_personal"]; ?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Asociar el representante seleccionado al alumno">&nbsp;
                  <img src='../images/sistema/asociation.png' width='22' heigth='16px' align='absmiddle'></img>&nbsp;Asignar&nbsp;
              </a>
            </td>
            </form>
          </tr> 
          
         <?php 
         } //fin de ciclo while
         ?>
        </tbody> 
  </table>
  <?php
			}// fin de si hubo consulta
	} //cierro el si se envio el form  
	$_SESSION["msg"]="";
	?>
<!-- FIN DE BUSCAR-->		                    
