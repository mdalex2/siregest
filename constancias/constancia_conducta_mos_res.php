<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_buscar"]) && isset($_POST["cmb_tip_doc_b"]) && isset($_GET['id_func'])){
		$campo_buscar=$_POST['cmb_tip_doc_b'];
		$texto_buscar=$_POST["txt_buscar"];
		$cod_anno_esc_bus=$_POST["cmb_anno_esc"];
		$valides=$_POST["cmb_valid"];
		$id_director=$_POST["cmb_director"];
		$cod_plantel=$_POST["cmb_plan"];
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
			
	$consulta=ejecuta_sql("select 
	DISTINCT 
	alum_insc_notas.id_personal,
	grados_esc.grado_letras,
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	datos_per.nombres,
	datos_per.apellidos,
	inst_secciones.seccion_largo ,
	alum_insc_notas.id_seccion 
	FROM (
	alum_insc_notas 
	INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN grados_esc ON grados_esc.cod_grado=alum_insc_notas.cod_grado
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion
	) WHERE alum_insc_notas.id_personal<>'CIS_ADMIN' AND cod_anno_esc='$cod_anno_esc_bus' and mat_pend=false",false);}  else {
	$consulta=ejecuta_sql("select 
	DISTINCT 
	alum_insc_notas.id_personal,
	grados_esc.grado_letras,
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	datos_per.nombres,
	datos_per.apellidos,
	inst_secciones.seccion_largo,
	alum_insc_notas.id_seccion 
	FROM (
	alum_insc_notas 
	INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN grados_esc ON grados_esc.cod_grado=alum_insc_notas.cod_grado
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion
	) WHERE $campo_buscar like '%".$texto_buscar."%' AND alum_insc_notas.id_personal<>'CIS_ADMIN' AND cod_anno_esc='$cod_anno_esc_bus' and mat_pend=false",false);	
		//$consulta=ejecuta_sql("select id_personal,num_identificacion,nombres,apellidos from datos_per where $campo_buscar like '%".$texto_buscar."%' AND id_personal<>'CIS_ADMIN'",true);
		} 
		if ($consulta)
			{
?>
<H2>RESULTADO DE LA B&Uacute;SQUEDA</H2>
<table id="tablasinbtn_ordf0" class="letra_16 mouse_hover" width="100%"> 
        <thead> 
          <tr>
            <th width="12%">N&deg; CEDULA    </th>
            <th width="25%">NOMBRES             </th>
            <th width="25%">APELLIDOS           </th>
            <th title="" width="15%">GRADO / A&Ntilde;O</th>
            <th title="" width="10%">SECCI&Oacute;N</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="" width="...">ABRIR.</th>
            <?php }?>
          </tr> 
  </thead> 
        <tbody> 
        <?php
				while ($fila_alum=mysql_fetch_array($consulta))
				{
		$id_alumno=$fila_alum["id_personal"];
		$num_id_per=$fila_alum["num_identificacion"];
		$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
		$poner_num=$fila_alum["poner_num"];
		$separador=$fila_alum["separador"];
		$num_con_punto=$fila_alum["num_con_punto"];
		$seccion_largo=$fila_alum["seccion_largo"];
		$id_seccion=$fila_alum["id_seccion"];
				?>
          <tr>
            <td><?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto); ?></td>
            <td><?php echo $fila_alum["nombres"]?></td>
            <td><?php echo $fila_alum["apellidos"]?></td>
            <td align="center"><?php echo $fila_alum["grado_letras"]?></td>
            <td align="center"><?php echo $seccion_largo;?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="constancia_conducta_planilla.php?<?php echo "id_func=".$_GET['id_func']."&id_per={$fila_alum['id_personal']}&cod_anno_esc=$cod_anno_esc_bus&vl=$valides&cod_plan=$cod_plantel&id_dir=$id_director&id_secc=$id_seccion";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar constancia" >&nbsp;
                  <img src='../images/icons_menu/x32/lapiz_hoja.png' width='20' heigth='16px' align='absmiddle'></img>&nbsp;Mostrar&nbsp;
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
<hr><div align="right">
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" align="absmiddle" height="20" width="20"> Ir atr&aacute;s</span>
</button>
</div>
  <?php
			}// fin de si hubo consulta
			else {
				mostrar_box("inf",false,"Notificaci&oacute;n","No se encontraron estudiantes en el periodo escolar seleccionado, verifique los datos suministrados e intente de nuevo");
				echo mostrar_btn_imp_reg();
			}
	} //cierro el si se envio el form  
	$_SESSION["msg"]="";
	?>
<!-- FIN DE BUSCAR-->		

</html>