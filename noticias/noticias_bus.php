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
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "noticias.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar:</legend>
<table align="center" width="100%">
<tr>
<td width="180">
<div class="ctrlHolder">
<label for="texto11">Fecha desde<br>
<input  name="texto11" type="text" class="fecha_corta validate[custom[date],required]" id="texto11" value="<?php if (!empty($_POST["texto11"])){echo $_POST["texto11"];} else {$fecha=date("d-m-Y"); echo $fecha;}?>"  maxlength="10"/>
<!--<a name='texto11' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Formato dd-mm-yyyy</p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#texto11").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
}); 
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div>
</td>
<td width="200">
  <div class="ctrlHolder">
  <label for="txt_fin">Fecha hasta<br>
  <input  name="texto12" type="text" class="fecha_corta validate[custom[date],required]" id="texto12" value="<?php if (!empty($_POST["texto12"])){echo $_POST["texto12"];} else {$fecha=date("d-m-Y"); echo $fecha;}?>"  maxlength="10"/>
  <!--<a name='texto11' style="cursor:pointer;">
</a>-->
  </label>
  <p class="formHint"> (*) Formato dd-mm-yyyy </p>
  <!-- SCRIPT PARA EL CALENDARIO-->
  <script type="text/javascript">
$("#texto12").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
}); 
</script>  
    
  <!--FIN DEL CALENDARIO DESDE-->																		
  </div>
</td>
<td rowspan="2">  
  <button formaction="<?php echo "noticias.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
  </button>
 
</td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder">
    <label for="txt_buscar">Titulo / descripci&oacute;n breve de la noticia</label>
    <br>
    <input name="txt_buscar" type="text" class="text-input lf"  id="txt_buscar" tabindex="0" value="" maxlength="15"  autofocus/>
    <p class="formHint"> (*) Ejm: entrega de notas</p>
    
    </div></td>
  </tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["texto11"]) && isset($_POST["texto12"]) && isset($_GET['id_func'])){
		 include_once("../funciones/aplica_config_global.php");
		$id_personal=$_SESSION["id_usuario"];
		$desde=date("Y-m-d",strtotime($_POST['texto11']));
		$hasta=date("Y-m-d",strtotime($_POST["texto12"]));
		if (!empty($_POST["txt_buscar"])){
			$texto_bus=$_POST["txt_buscar"];
			$filtro_detalle=" AND (titulo LIKE '%$texto_bus%' OR  contenido LIKE '%$texto_bus%') ";
		} else {
				$filtro_detalle="";
		}
		$consulta=ejecuta_sql("select noticias.*,datos_per.nombres,datos_per.apellidos from (noticias INNER JOIN datos_per on datos_per.id_personal=noticias.id_usuario_not) where date(fecha_publicacion) BETWEEN '$desde' AND '$hasta' $filtro_detalle ORDER BY fecha_publicacion DESC",true); 
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="noticias.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['id_noticia'];
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
            <th width="130px">FECHA</th>
            <th width="...">TITULO</th>
            <th width="...">ESTATUS</th>
            <th width="..." title="Usuario que efectu&oacute; la actuaci&oacute;n">U.</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="DETALLES" width="80px">DETALLE</th>
            <th width="80px">ELIM</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        
        <?php

				while ($fila=mysql_fetch_array($consulta))
				{
					//$hora=date("h:m a",strtotime($fila["fecha_act"]));
					$fecha_pub=formato_fecha("MH",$fila["fecha_publicacion"]);
					$titulo=$fila["titulo"];
	
					$noticia=$fila["contenido"];
					$id_noticia=$fila["id_noticia"];
				?>
          <tr>
            <td align="center"><?php echo $fecha_pub;?></td>
            <td align="left"><?PHP echo $titulo; ?></td>
            <td align="center"><?php 
							if ($fila["visible"]==true){
								echo "Publicada";
							} else {
							echo "Oculta";}
						?></td>
            <td align="center">
            
							<a href="#" class="tooltip" title="<?php echo $fila["nombres"]." ".$fila["apellidos"]."<br>".formato_fecha("LH",$fila["fecha_publicacion"]);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>
            </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
 							<a id="resize" href="noticias.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['id_noticia']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar / editar" >&nbsp;
                  <img src='../images/sistema/noticia_mostrar.png' width='20' heigth='16px' align='absmiddle'></img>&nbsp;Mostrar&nbsp;
              </a>            
              </td>
              <?php
									$url_elim="noticias.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_noticia;
							?>
            <td align="center"> 							<a id="resize" href="<?php echo $url_elim;?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar" onClick="return confirmElim()" >&nbsp;
                  <img src='../images/icons_menu/x32/elim_papelera_x32.png' width='20' heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;</td>
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