<?php 
	function mostrar_tabla_prog($id_func,$cod_anno_esc,$cod_secc,$utf8){
		/*if (isset($id_func)){
$array_permisos=verificar_acceso_pagina($id_func);} else{
$array_permisos=verificar_acceso_pagina("-000");}
*/
?>

  <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
  <script type="text/javascript" src="../js/jquery-1.7.1.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js" charset="utf-8"></script>
  
  <!-- para las validaciones del formulario es -->  
	<link rel="stylesheet" href="../js/validaciones/jQuery-Validation/css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../js/validaciones/jQuery-Validation/css/template.css" type="text/css"/>
	<script src="../js/validaciones/jQuery-Validation/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/validaciones/jQuery-Validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
 <script type="text/javascript" charset="utf-8">
function confirm_elim()
{
	<?php
		$msg="¿Está seguro de eliminar esta asignacion de docente a programa de Educación para el Trabajo?";
		if ($utf8==true){
		$msg=($msg);}
	?>
var agree=confirm("<?php echo ($msg);?>");
if (agree)
return true ;
else
return false ;
}
</script>
	<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery("#form_mostrar_datos").validationEngine({autoHidePrompt:true,autoHideDelay: 3500}); 
			jQuery("#form_buscar").validationEngine({autoHidePrompt:true,autoHideDelay: 3500});
			jQuery("#form_asi_doc_sec_adm").validationEngine({autoHidePrompt:true,autoHideDelay: 3500});									
			jQuery("#frm_asig_mat").validationEngine({autoHidePrompt:true,autoHideDelay: 3500}); //cambiar #form por el nombre del formulario a validar
			
			//$('#txt_id_func').focus(); //coloco el cursor en el primer text
		});
	</script>
	<!-- fin de las validaciones -->

  <!-- tema wide -->
  <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="all" rel="stylesheet"/>
  <link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
  <!--fin del validacion uniform-->

 <!-- para el datatables ================================================== -->
  <style type="text/css" media="all">
  @import url("../js/DataTables-1.9.0/media/css/TableTools_JUI.css");
  @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
  </style>
 
 
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/jquery.dataTables.min.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ZeroClipboard.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/TableTools.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ColReorderWithResize.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ColVis.min.js"></script>

 
<!-- para los box encima de las paginas -->
<!-- Add mousewheel plugin (this is optional) -->
<!--<script type="text/javascript" src="/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>-->

<!-- Add fancyBox -->
<link rel="stylesheet" href="../js/fancybox/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/jquery.fancybox.pack.js?v=2.0.5"></script>
<script type="text/javascript">
$(document).ready(function() {
	//-------------- congiguro el datatables
			
				$('#tablaprograma_ordf0').dataTable( {
					"oLanguage": {
			"sUrl": "../js/DataTables-1.9.0/media/lang/es_es.txt"
		},	
					"aaSorting": [[ 0, "asc" ]],
						/*"aoColumns": [
							null,
							null,
							null,
							null
						],
						*/
					"bPaginate": false,
					"bJQueryUI": true,
					"aLengthMenu": [[10, 25, 50, 100,500, -1], [10, 25, 50, 100,500, "Mostrar todos"]],
					"sPaginationType": "full_numbers",
					"sDom": '<"H"Rflip>t<"F"flip>',
					"oTableTools": {
						"sSwfPath": "../js/DataTables-1.9.0/media/swf/copy_cvs_xls_pdf.swf",
						"aButtons": [
							"copy", "csv", "xls", "pdf",//"print",
							{
								"sExtends":    "collection",
								"sButtonText": "Guardar",
								"aButtons":    [ "csv", "xls", "pdf" ]
							}
						]
					}										
					})
					

});	


</script>
  <!-- fin fancy box -->
  <!-- este debe ir siempre al final para que me pueda mostrar el menu -->

<?php
		$sql_mostrar="SELECT dat_docente.nombres, dat_docente.apellidos,dat_usu.nombres as nom_usu, dat_usu.apellidos as ape_usu,asi_doc_sec.cod_asig_prog,asig_prog.des_mat_prog,asi_doc_sec.observaciones,asi_doc_sec.fecha_g FROM (asi_doc_sec
		INNER JOIN datos_per AS dat_docente ON dat_docente.id_personal=asi_doc_sec.id_profesor
		INNER JOIN datos_per AS dat_usu ON dat_usu.id_personal=asi_doc_sec.guardado_por
		INNER JOIN asig_prog ON asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog
		) where cod_anno_esc='$cod_anno_esc' AND id_seccion='$cod_secc' AND asig_prog.tip_asig='PR'";
		$cons_prog=ejecuta_sql($sql_mostrar,false);
		if ($cons_prog){
			?>
     <table id="tablaprograma_ordf0" width="100%"class="mouse_hover" style="font-size:12px;" >
      <thead>
      <tr>
        <th>OPC.</th>
        <th>PROGRAMA</th>
        <th>DOCENTE</th>
        <th>OBSERVACIONES</th>
        <th>USU.</th>
      </tr>
      </thead>
      <?PHP
			while ($fila_prog=mysql_fetch_array($cons_prog)){
				$cod_prog=$fila_prog["cod_asig_prog"];
				$fecha_g=$fila_prog["fecha_g"];
				$gua_por_bd=$fila_prog["nom_usu"]." ".$fila_prog["ape_usu"];
				$nom_ape_docente=$fila_prog["nombres"]." ".$fila_prog["apellidos"];
				if ($utf8==true){
					$nom_ape_docente=($fila_prog["nombres"]." ".$fila_prog["apellidos"]);}
					
					$nom_programa=$fila_prog["des_mat_prog"];
					if ($utf8==true){
						$nom_programa=($fila_prog["des_mat_prog"]);}
					$observaciones=$fila_prog["observaciones"];
					if ($utf8==true){
						$observaciones=($fila_prog["observaciones"]);}					
					
			?>
      <tr><td width="70" align="center">
         <?php //if ($array_permisos["eliminar"]==true) {?>
            
            
 							<a href="asi_doc_sec.php?id_func=<?php echo $id_func;?>&accion=quitar_asociacion&cod_anno_esc=<?php echo $cod_anno_esc;?>&cod_prog=<?php echo $cod_prog?>&id_seccion=<?php echo $cod_secc?>" id="resize" onClick="return confirm_elim()" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all " style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar asignaci&oacute;n" value="<?php ?>" >&nbsp;
                  <img src='../images/icons_menu/x32/elim_papelera_x32.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
                  </a>            
            <?php //}?>
            </td>
        <td><?php echo $nom_programa;?></td>
        <td><?php echo $nom_ape_docente;?></td>
        <td><?php echo $observaciones;?></td>
        <td>
				<?php 
            if (!empty($fecha_g)){
            ?>
          <a href="#" class="tooltip" title="<?php echo $gua_por_bd."\n".formato_fecha("LH",$fecha_g);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>
            <?php
						}
						?>
</td>
      </tr>
      <?PHP
			} // fin while
			?>
    </table>      
		<?php	
		} else {
			mostrar_box("exc",true,"","No se encontraron Programas de Educaci&oacute;n para el Trabajo asignados para la el periodo y secci&oacute;n seleccionados");
		}
	} // fin funcion 
?>