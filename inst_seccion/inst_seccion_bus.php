<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "inst_seccion.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar secciones:</legend>
<table align="center" width="100%">
<tr>
  <td colspan="2"><div class="ctrlHolder">
<?php
if (isset($_SESSION['id_grupo_usuario']) && $_SESSION['id_grupo_usuario']=="G0001"){
$sql="select cod_plantel,den_plantel from instituciones where activa=true order by den_plantel,id_dis_esc asc";
} else {
$sql="select cod_plantel,den_plantel from instituciones where activa=true and cod_plantel='".$_SESSION["cod_plantel_ses"]."' order by den_plantel,id_dis_esc asc";
}
$consulta=ejecuta_sql($sql,0);
?>
<label for="cmb_plan">Plantel o instituci&oacute;n</label><br>
            <SELECT NAME="cmb_plan" id="cmb_plan" SIZE=1  class="lf validate[required]" style="width:90%"> 
                
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>' <?php if (isset($_POST["cmb_plan"]) && $_POST["cmb_plan"]==$fila['cod_plantel']){echo " selected";} ?>><?php echo $fila["den_plantel"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> (*) Seleccione el plantel</p>
</div></td>
  </tr>
<tr>
<td>
  <div class="ctrlHolder">
    
    <label for="txt_bus" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba la secci&oacute;n a buscar"; ?></label><br>
    <input name="txt_bus" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_bus" tabindex="0" value="<?php if (isset($_POST['txt_bus'])){ echo $_POST['txt_bus'];}?>" maxlength="10" autofocus/>
    <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba la secci&oacute;n a buscar"; ?>">
     <button formaction="<?php echo "inst_seccion.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
  </button> 
    <p class="formHint"> (*) Ejm: A</p>
  </div>
</td>
<td>  
  
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_bus"]) && isset($_POST["cmb_plan"]) && isset($_GET['id_func'])){
		$cod_plantel=strtoupper($_POST['cmb_plan']);
		$texto_buscar=$_POST["txt_bus"];
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){		
		$consulta=ejecuta_sql("select id_seccion,seccion_largo,seccion_corto,inst_secciones.fecha_g,grados_esc.grado_letras,inst_secciones.visible,datos_per.nombres,datos_per.apellidos,menc_edu.mencion,plan_est_tip.nivel_plan_est,sectores_educ.sector_educ from (inst_secciones 
		INNER JOIN datos_per on inst_secciones.guardado_por=datos_per.id_personal 
		INNER JOIN grados_esc on grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
				INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ
		) where inst_secciones.cod_plantel='$cod_plantel'",true);}
		else
		{
		$consulta=ejecuta_sql("select id_seccion,seccion_largo,seccion_corto,inst_secciones.fecha_g,grados_esc.grado_letras,inst_secciones.visible,datos_per.nombres,datos_per.apellidos,menc_edu.mencion,plan_est_tip.nivel_plan_est,sectores_educ.sector_educ from (inst_secciones 
		INNER JOIN datos_per on inst_secciones.guardado_por=datos_per.id_personal 
		INNER JOIN grados_esc on grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
		INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ
		) where inst_secciones.cod_plantel='$cod_plantel' and seccion_corto like '%".$texto_buscar."%'",true);
		}
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="inst_seccion.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['id_seccion'];
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
<table id="tablasinbtn" class="letra_16 mouse_hover" > 
        <thead> 
          <tr>
            <th>A&Ntilde;O O GRADO </th>
            <th>MENCI&Oacute;N</th>
            <th width="85px">SECCI&Oacute;N</th>
            <th>PLAN DE ESTUDIO</th>
            <th>SECTOR</th>
            <th width="100px">ESTATUS</th>
            <th width="5px">U.</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="Ver" width="80px">Ver</th>
            <?php }?>
           <?php if ($array_permisos["eliminar"]==true) {?>
            <th width="80px" title="ELIMINAR SECCI&Oacute;N">ELIM.</th>
            <?php }?>
            
          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <td><?php echo $fila["grado_letras"]?></td>
            <td><?php echo $fila["mencion"]?></td>
            <td align="center"><?php echo $fila["seccion_corto"]?></td>
            <td align="center"><?php echo $fila["nivel_plan_est"]?></td>
            <td align="center"><?php echo $fila["sector_educ"]?></td>

                        <td align="center"><?php 
							if ($fila["visible"]==true){
								echo "ACTIVO";
							} else {
							echo "DESHABILITADO";}
						?></td>

            <td>
                        
							<a href="#" class="tooltip" title="<?php echo $fila["nombres"]." ".$fila["apellidos"]."<br>".formato_fecha("LH",$fila["fecha_g"]);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>

            </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="inst_seccion.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['id_seccion']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Editar los datos de la secci&oacute;n" >&nbsp;
                  <img src='../images/sistema/computer_edit.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Abrir
              </a>            </td>
            <?php 
              } // fin del boton mostrar
            ?>

            <?php if ($array_permisos["eliminar"]==true) {?>
            <td align="center">
            
 							<a id="resize" href="inst_seccion.php?<?php echo "id_func=".$_GET['id_func']."&accion=eliminar&id_elim={$fila['id_seccion']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar la secci&oacute;n" onClick="return confirm_elim1()" >&nbsp;
                  <img src='../images/sistema/computer_edit.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Elim.
              </a>            </td>
            <?php 
              } // fin del boton mostrar
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