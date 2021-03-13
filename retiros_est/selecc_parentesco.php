<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                      <h1 align="left" class="titulo_form_blue">
                      <img src="file:///C|/wamp/www/images/icons_menu/x32/config.png" width="32" height="32" align="absmiddle">ASIGNAR REPRESENTANTE</h1>
                      <hr>

<?php
if (isset($_GET["id_per"])){
	$consulta_edit=ejecuta_sql("select id_personal,num_identificacion,fecha_nac,nombres,apellidos,foto_perfil,sexo,fecha_nac,tip_doc_per.tipo_doc_abr,terr_nacionalidad.nacionalidad from (datos_per
	INNER JOIN tip_doc_per on tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN terr_nacionalidad on terr_nacionalidad.cod_nac=datos_per.cod_nac
	) where id_personal='".$_GET["id_per"]."'",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$id_personal=$registro["id_personal"];
	$tipo_doc_abr=$registro["tipo_doc_abr"];
	$num_identificacion=$registro["num_identificacion"];
	$nombres=strtoupper($registro["nombres"]);
	$apellidos=strtoupper($registro["apellidos"]);
	$nombre_foto=$registro["foto_perfil"];
	if ($registro["foto_perfil"]=="F")
		$sexo="FEMENINO";
	else
		$sexo="MASCULINO";
	$fecha_nac_l=formato_fecha("L",$registro["fecha_nac"]);
	$fecha_nac=date("d-m-Y",strtotime($registro["fecha_nac"]));
	$nacionalidad=$registro["nacionalidad"];
?>  
	<table width="100%" border="0">
  <tr>
    <td rowspan="2">
<div id="foto" name="foto" style="height:110px; width:90px; border:#666666; border-radius:5px; border-style:solid">

<?php 
  $ruta_foto=$_SESSION["carp_per_fotos"].$id_personal."/".$nombre_foto;
	if (file_exists($ruta_foto) && $nombre_foto!=''){
		echo "<img src='$ruta_foto' width='90px' height='110px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='90px' height='110px'>";}
?></div>    </td>
    <td>
<div class="ctrlHolder">
    		<p class="formHint">N&deg; de identificaci&oacute;n:</p>
        <label><b><?php echo $tipo_doc_abr."-".number_format($num_identificacion, 0, ",", ".");?></b></label> 
        
        
      </div>    </td>
    <td><div class="ctrlHolder">
    		<p class="formHint">Nombres y apellidos:</p>
        <label><b><?php echo $nombres." ".$apellidos;?></b></label> 
        
        
      </div></td>
    <td colspan="2"><div class="ctrlHolder">
    		<p class="formHint">Sexo:</p>
        <label><b><?php echo $sexo;?></b></label> 
        
        
      </div></td>
  </tr>
  <tr>
    <td>
    
    <div class="ctrlHolder">
    		<p class="formHint">Nacionalidad:</p>
        <label><b><?php echo strtoupper($nacionalidad);?></b></label> 
        
        
      </div>
    </td>
    <td><div class="ctrlHolder">
    		<p class="formHint">Fecha de nacimiento:</p>
        <label><b><?php echo strtoupper($fecha_nac_l);?></b></label> 
        
        
      </div></td>
      
    <td><div class="ctrlHolder">
    		<p class="formHint">Edad:</p>
        <label><b><?php echo calcular_edad($fecha_nac);?></b></label> 
        
        
      </div></td>
    <td><a id="resize" href="file:///C|/wamp/www/datos_per/datos_per.php?<?php echo "id_func=00051&accion=mostrar&id_per=$id_personal";?>" target="_blank" title="Mostrar mas informaci&oacute;n del estudiante"><img src="file:///C|/wamp/www/images/sistema/vcard-icon.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td><SELECT NAME="cmb_par" SIZE=1 class="sf validate[required]" id="cmb_par"> 
            <option value="">SELECCIONE...</option>
<?php
	$consulta_par=ejecuta_sql("select id_parentesco,parentesco from parentescos where visible=true order by parentesco ASC",true);
	//si hay registros para mostrar
  if ($consulta_par){
	while ($fila_par=mysql_fetch_array($consulta_par)){
		echo "<OPTION VALUE='".$fila_par['id_parentesco']."'>".$fila_par["parentesco"]."</OPTION>";
	}
	}
?>
</SELECT></td>
    <td><select name="cmb_rep" id="cmb_rep">
              	<option value="">SELECCIONE...</option>
                <option value="1">SI</option>
                <option value="0">NO</option                
              ></select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table>
 <?php
	} // fin de si consulta edit
  } // se envio url del representante
 ?>
</html>