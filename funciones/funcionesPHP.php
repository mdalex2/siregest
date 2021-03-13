<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", 1); 
function corrige_sql($campo){
	$campo=addslashes($campo);
	return $campo;
}
function arregla_pa_mostrar($campo){
	$campo=htmlspecialchars($campo);
	return $campo;
}
function promedio ($array_notas)
{
if(is_array($array_notas))
 {
  $notas=0;
  $contador=0;
  $promedio;
     foreach($array_notas as $nota)
      {
         $notas = $nota + $notas;
         $contador++;
      }
   $promedio = $notas/$contador;
   return round($promedio);
} else {
 //echo 'El parametro introducido no es un array';
return "-";
}
} 
// ------------ FIN PROMEDIO NOTAS
function pon_cero_izq($entero, $largo){
    // Limpiamos por si se encontraran errores de tipo en las variables
    $entero = (int)$entero;
    $largo = (int)$largo;
	
    $relleno = '';
	
    /**
     * Determinamos la cantidad de caracteres utilizados por $entero
     * Si este valor es mayor o igual que $largo, devolvemos el $entero
     * De lo contrario, rellenamos con ceros a la izquierda del número
     **/
    if (strlen($entero) < $largo) {
        $relleno = str_repeat('0', $largo - strlen($entero));
    }
    return $relleno . $entero;
}
//------ FIN FUNCION CERO IZQUEIRDA 
function formatear_id_personal($num_id_personal,$abr,$poner_num,$separador,$num_con_punto){
	$num_id_personal=$num_id_personal;
	if ($num_con_punto==true){$num_id_personal=number_format($num_id_personal, 0, ",", ".");}
	if ($poner_num==true){
		$num_id_personal=$abr.$separador.$num_id_personal;
	}  else {
		$num_id_personal=$abr;
	}
	return $num_id_personal;
}
//---------------------------------------------------------
function calcular_edad($fechanacimiento){
list($d, $m, $y) = explode("-", $fechanacimiento);
    $y_dif = date("Y") - $y;
    $m_dif = date("m") - $m;
    $d_dif = date("d") - $d;
    if ((($d_dif < 0) && ($m_dif == 0)) || ($m_dif < 0))
        $y_dif--;
    return $y_dif;
}
//------------FIN CALCULAR EDAD----------------

function mostrar_btn_imp_reg(){
	$botones= '<hr><div align="right">
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="window.print();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" width="20" height="20" align="absmiddle"> Imprimir</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Ir atrás</span>
</button>
</div>';
return $botones;
}
function mostrar_btn_imp_reg_cerr(){
	$botones= '<hr><div align="right">
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="window.print();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" width="20" height="20" align="absmiddle"> Imprimir</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Ir atrás</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="parent.$.fancybox.close();" title="Cerrar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/stop_32.png" width="20" height="20" align="absmiddle"> Cerrar</span>
</button>
</div>';
return $botones;
}
function fecha_actual($formato){
	include_once("aplica_config_global.php");
	switch ($formato){
		case "normal":
			$fecha_g=date("d-m-Y h:i");
			break;
		case "mysql":
			$fecha_g=date("Y-m-d H:i:s");
			break;
	}
	return $fecha_g;
}
function formato_fecha($formato,$fecha){
	include_once("aplica_config_global.php");
	$fecha_g=strtotime($fecha);
	switch (strtoupper($formato)) {
				case "H12":
		//21/12/2012 11:00 pm
			$fecha_g=strftime("%I:%M %p",strtotime($fecha)); 
			break;

		case "C":
		//21/12/2012
			$fecha_g=strftime("%d/%m/%Y", strtotime($fecha));
			break;
		case "CH":
		//21/12/2012 11:00 pm
			$fecha_g=strftime("%d/%m/%Y-%I:%M %p",strtotime($fecha)); 
			break;
		case "M":
			$fecha_g=strftime("%d/%b/%Y",strtotime($fecha));
			break;
		case "MH":
			$fecha_g=strftime("%d/%b/%Y-%I:%M %p",strtotime($fecha)); 
			break;
		case "L":
			$fecha_g=strftime("%A, %d de %B de %Y",strtotime($fecha)); 
			break;
		case "LH":
		  //$fecha_g=date('l jS \of F Y h:i:s A',strtotime($fecha));
			$fecha_g=strftime("%A, %d de %B de %Y - %I:%M %p",strtotime($fecha)); 
			break;
		case "MA":
		  //mes y año letra
			$fecha_g=strftime("%B-%Y",strtotime($fecha)); 
			break;
		case "MES":
		  //mes y año letra
			$fecha_g=strftime("%B",strtotime($fecha)); 
			break;
			

	} //fin switch
	return utf8_encode($fecha_g);
} //fin de la funcion
include_once("conexion.php");
//esta funcion ejecuta consultas sql y devuelve los registro si los hay si no se sale
function ejecuta_sql($consulta,$mostrar_msg){
		$conex=conectarse();
		mysql_query("SET NAMES 'utf8'");
		$registros=mysql_query($consulta,$conex);
		if(!$registros){
			mostrar_box("err",true,"INFORMACIÓN","No se pudo ejecutar la consulta SQL: ".mysql_error());
				return false;}
		else
			if (mysql_num_rows($registros)==0 ){
				if ($mostrar_msg==true){
				//echo $mostrar_msg;
				echo mostrar_box("inf",true,"RESULTADO DE LA CONSULTA","No se han encontrado registros");}
				else
				return false;
			} else {
				return $registros;
				}
}
//----------------------------------------------------------
function mostrar_cajaizq_sup($tituloH2,$tituloBox){
	$box_agenda='<!-- INICIO DEL BOX ............................................ -->';
	if ($tituloBox!=''){
		$box_agenda.='<h2>'.$tituloH2.'</h2>';
		}
		$box_agenda.=
		'<div class="box ui-widget ui-widget-content ui-corner-all portlet ui-helper-clearfix">
	  	<div class="portlet-header ui-widget-header ui-corner-all">
       	<!--<span class="ui-icon ui-icon-circle-arrow-s"></span>-->
      	'.$tituloBox.':
      </div> <!--fin de portlet header-->
			<div class="portlet-content">';
		return $box_agenda;
	}
	//----------------------------------------------------------------
	//muestro la parte de abajo del box izquierdo
	function mostrar_cajaizq_inf(){
	$box_agenda='<!-- FIN DEL BOX............................................ -->
			</div> <!-- Fin de portlet content-->
			</div> <!-- FIN BOX1............................................................. -->';
		return $box_agenda;

	}
//----------------------------------------------------------------
//esta funciones verifica si la funcion es válida
// si el usuario tiene permiso se acceder a una funciones que se está abriendo.
function verificar_acceso_pagina($id_func){
	$permitido=false;
	$id_grupo_usuario=$_SESSION['id_grupo_usuario'];
	if ($id_grupo_usuario!="G0001"){
	$link=conectarse();
	if (!isset($id_func)){
		$id_func='';
	}
	$consulta=mysql_query("select sis_priv_grup.*, sis_funciones.id_func,sis_funciones.texto_icono,sis_funciones.activa,sis_funciones.url from (sis_priv_grup inner join sis_funciones on sis_priv_grup.id_func=sis_funciones.id_func) where sis_priv_grup.id_func='".$id_func."' and sis_priv_grup.id_grupo='".$id_grupo_usuario."'",$link);
	if (!$consulta or $id_func=='' or $id_grupo_usuario==''){
	  mostrar_box("exc",true,"Acceso erroneo","Error al verificar el acceso a la página o función: ".$id_func." mysql error: ".mysql_error());
	} 
	  else // si no hubo error en la consulta mysql
	{
	  if (mysql_num_rows($consulta)>0){
	    while ($fila=mysql_fetch_array($consulta)){
				if ($fila["mostrar"]==true){
					$url=$fila['url'];
					$array_permisos=array("id_func"=>$fila["id_func"],
					"mostrar"=>$fila["mostrar"],
					"crear"=>$fila["crear"],
					"editar"=>$fila["editar"],
					"eliminar"=>$fila["eliminar"],
					"imprimir"=>$fila["imprimir"],
					"exportar"=>$fila["exportar"],
					"otro"=>$fila["otro"]);
					$_SESSION["array_permisos"]=$array_permisos;
					$permitido= true;
					break;
				} //fin de si mostrar ==true
			} //fin while
	  } //fin de si numero de filas >0
		else //contrario de si no se encontro registro
			{$permitido=false;
			$array_permisos=array("id_func"=>$id_func,
			"mostrar"=>false);
			$_SESSION["array_permisos"]=$array_permisos;
			}
			
	} //fin else si no hubo error en consulta mysql
//si la url no es la que esta en la base de datos 

if ($permitido==false){
	$_SESSION["titulo_msg"]="Acceso denegado";
	$_SESSION["error"]=("Usted no tiene permiso para acceder a la página solicitada ".$_SERVER['REQUEST_URI']) ;
	header("location:../controlador/msgs_menu.php");
	}
else
if (substr_count($_SERVER['REQUEST_URI'],substr($url,5,20))==0){
	$permitido=false;
	$_SESSION["titulo_msg"]="Acceso denegado";
	$_SESSION["error"]="La url escrita ({$_SERVER['REQUEST_URI']}) no es la que corresponde a la almacenada en la base de datos ({$url}) para el id de funcion ({$id_func})";
	header("location:../controlador/msgs_menu.php");
	}

return $array_permisos;
	}
	else  //si es administrador doy todos los privilegios
	{
		$array_permisos=array("id_func"=>$id_func,
					"mostrar"=>true,
					"crear"=>true,
					"editar"=>true,
					"eliminar"=>true,
					"imprimir"=>true,
					"exportar"=>true,
					"otro"=>true);
					$_SESSION["array_permisos"]=$array_permisos;
					return $array_permisos;
			}
} //fin funcion
//----------------------------------------------------------------
//esta funcion obtiene ciertos caracteres a la derecha de un texto
function str_right($string,$chars)
{
    $vright = substr($string, strlen($string)-$chars,$chars);
    return $vright;
   
}

//--------------------------------------------------------------------------------
//----------------------------------------------------------
//esta funcion creal el pie de pagina excepto para la paginas de noticias y paginas que no han iniciado sesion
function crear_pie_pagina(){
	$pie_pagina= '<p class="mid"><br><br><b>
		    <a href="#" title="Ir al principio de la página" class="tooltip">Arriba</a>·<a href="../acceso_sis/menu_principal.php" 
title="Menú principal" class="tooltip">P&aacute;gina de Inicio</a>·<a href="../usuarios/informacion_cuenta.php" title="Mi cuenta" class="tooltip resize fancybox.iframe">Mi cuenta</a>·<a href="../funciones/salir_sistema.php" title="Salir del sistema" class="tooltip">Cerrar sesi&oacute;n</a>
			</p><br>
				<!-- Change this to your own once purchased -->
				<h3 align="center">Programador: Jairo  Alexi Mendoza ©. Todos los derechos reservados.
				<!-- -->
			</h3>';
			return ($pie_pagina);
			}

//--------------------FUNCION REDIRECCIONAR --------------------
// ESTA FUNCION REDIRECCIONA LAS PÁGINAS Y SI NO EXISTE LA PÁGINA MUESTRA UN MSG DE ERROR
function redireccionar($url){
	if (file_exists($url)){
	  header("location:$url");} else {
	  mostrar_box("err",false,"Página no encontrada","La página solicitada $url no existe, es prosible que la misma halla sido eliminada o cambiada de directorio, se debe verificar el enlace a través de la opcion <b>administrar funciones</b>");
		}
	
	}
//----------------------------------------------------------------------

function redireccionar_js($pag,$tiempoMS){
echo '<script type="text/javascript">  
function redireccionar(){  
  window.location="'.$pag.'";  
}   
setTimeout ("redireccionar()", '.$tiempoMS.'); //tiempo expresado en milisegundos  
</script>';

	}
//---------------------------------------------------------------
//muestra el calendario en el menu principal
function ver_calendario(){
	$calendario='<!-- Datepicker -->
      <h2>Calendario</h2>
		  <div id="datepicker" onClick="//alert(\'esta es la fecha: \'+document.getElementById(\'datepicker\').value)" align="center"></div>
		  <!-- End of Datepicker -->
			<script type="text/javascript"> 
				$("#datepicker").datepicker(); 
			</script>

';
		 return $calendario;
	}
//----------------------------------------------------------------------
//esta funcion muestra un box en el menu principal para consultar agenda

function mostrar_box_consulta_agenda($id_caja,$id_boton){
	$txt_desde=$id_caja."1";
	$txt_hasta=$id_caja."2";
	$id_btn_cal1=$id_boton."1";
	$id_btn_cal2=$id_boton."2";
	$box_agenda='<!----BOX1............................................ -->
	<h2>Agenda personal</h2>
		<div class="box ui-widget ui-widget-content ui-corner-all portlet ui-helper-clearfix">
	  	<div class="portlet-header ui-widget-header ui-corner-all">
       	<!--<span class="ui-icon ui-icon-circle-arrow-s"></span>-->
      	Consulta de Agenda:
      </div> <!--fin de portlet header-->
			<div class="portlet-content">
      	<p>
        <form action="../agenda/agenda.php?id_func=00063&accion=buscar" method="post" name="frm_con_agenda" class="">
				<label for="{$txt_desde}">Desde<br>
					<input type="text" name="'.$txt_desde.'" id="'.$txt_desde.'" class="fecha_corta"  maxlength="10"/>
						<a name='.$txt_desde.' style="cursor:pointer;">
						</a>
				</label>
				<!-- SCRIPT PARA EL CALENDARIO-->
          <script type="text/javascript">
					$("#'.$txt_desde.'").datepicker({
   					showOn: "both",
						regional:"es",
						dateFormat: "dd-mm-yy",
						minDate: new Date(2012, 1 - 1, 1), 
   					buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
						showButtonPanel: true,
   					buttonImageOnly: true,
   					changeYear: true,
   					numberOfMonths: 1,
						onClose: function(dateText, inst) {
						var endDateTextBox = $("#'.$txt_hasta.'");
								if (endDateTextBox.val() != "") {
										var testStartDate = new Date(dateText);
										var testEndDate = new Date(endDateTextBox.val());
										if (testStartDate > testEndDate)
												endDateTextBox.val(dateText);
								}
								else {
										endDateTextBox.val(dateText);
								}
						},
						onSelect: function (selectedDateTime){
								var start = $(this).datetimepicker("getDate");
								$("#'.$txt_hasta.'").datetimepicker("option", "minDate", new Date(start.getTime()));
						}
									}); 
        </script>  
				<!--FIN DEL CALENDARIO DESDE-->																		
				<input name="mostrar" type="submit" value="Mostrar"  class="ui-button ui-widget ui-state-default ui-corner-all" title="Consultar registros para el rango de fecha seleccionado">
																		
		<label for="{$txt_hasta}">Hasta<br>
			<input type="text" name="'.$txt_hasta.'" id="'.$txt_hasta.'" class="fecha_corta"  maxlength="10"/>
			<a name='.$txt_hasta.' style="cursor:pointer;"></a>
		</label>
						<!-- SCRIPT PARA EL CALENDARIO-->
          <script type="text/javascript">
					$("#'.$txt_hasta.'").datepicker({						
   					showOn: "both",
						regional:"es",
						dateFormat: "dd-mm-yy",
						minDate: new Date(2012, 1 - 1, 1), 
   					buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
   					buttonImageOnly: true,
						showButtonPanel: true,
   					changeYear: true,
   					numberOfMonths: 1,
						
 onClose: function(dateText, inst) {
        var startDateTextBox = $("#'.$txt_desde.'");
        if (startDateTextBox.val() != "") {
            var testStartDate = new Date(startDateTextBox.val());
            var testEndDate = new Date(dateText);
            if (testStartDate > testEndDate)
                startDateTextBox.val(dateText);
        }
        else {
            startDateTextBox.val(dateText);
        }
    },
    onSelect: function (selectedDateTime){
        var end = $(this).datetimepicker("getDate");
        $("#'.$txt_desde.'").datetimepicker("option", "maxDate", new Date(end.getTime()) );
    }
							}); 
				</script><!--FIN DEL CALENDARIO-->

			<input name="limpiar" type="reset"  value="Limpiar"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" title="Limpiar campos de fecha">
		</form>   
		<br><a  href="../agenda/agenda.php?id_func=00063&accion=nuevo"><img src="../images/icons_menu/x32/calendario_add_x32.png" align="absmiddle"  width="16px" height="16px">&nbsp;Crear nueva tarea</img></a>
		</p>
</div> <!--fin de portlet content-->
</div> <!--FIN BOX1............................................................. -->';
		return $box_agenda;

	}
//-----------------------------------------------------------------
//esta funcion verifica si no se ha usado la pagina en cierto tiempo y destruye la sesion en caso que caduque
function verifica_caducidad_sesion(){
include_once("../logs/guarda_log.php");
guardar_log();

if (!isset($_SESSION["ultimo_acceso"])){
	$_SESSION["ultimo_acceso"]=date("Y-n-j H:i:s");}

if(isset($_SESSION['logueado_siregest'])){
//VERIFICO SI EXISTE LA SESION DEL PLANTEL
if (!isset($_SESSION["cod_plantel_ses"]) && ($_SESSION['id_grupo_usuario']!="G0001")){
	header("Location:../acceso_sis/selecciona_plantel.php");
}

$fechaGuardada = $_SESSION["ultimo_acceso"]; 
$ahora = date("Y-n-j H:i:s");
if($_SESSION['logueado_siregest']!=true){
	$_SESSION['err']="sesse";
	header("Location:../acceso_sis/clave_acceso.php?err=sesse");
	return false;
}else{
$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 
if($tiempo_transcurrido >= 800){//300 milisegundos = 300/60 = 5 Minutos...
session_destroy();
$_SESSION['var_menu']="";
session_start();
$_SESSION['err']="sesse";
header("Location:../acceso_sis/clave_acceso.php");
//return true;
}else{$_SESSION["ultimo_acceso"] = $ahora;} 
}
}else{
$_SESSION['err']="sesse";	
header("Location:../acceso_sis/clave_acceso.php");
//return true;
}
	}
	
	//---------------------------------------------------------------
	//esta funcion muetra mensajes tipo BOX o de caja en la pagina web 
	function mostrar_box($tipo,$permite_ocultar,$titulo,$mensaje) {
		switch (strtoupper($tipo)){
			case "ERR":
			  if ($permite_ocultar==true){
			    echo '<div class="message error_msg close">';}
			  else{
			    echo '<div class="message error_msg">';}
			    echo '<h2><b>'.$titulo.'</b></h2>
					<p>'.$mensaje.'</p>
				  </div>';
				  break;			

			case "INF":
			  if ($permite_ocultar==true){
			    echo '<div class="message information close">';}
			  else{
			    echo '<div class="message information">';}
			    echo '<h2><b>'.$titulo.'</b></h2>
					<p>'.$mensaje.'</p>
				  </div>';
				  break;			
			case "EXC":
			 if ($permite_ocultar==true){
		       echo '<div class="message warning close">';}
			 else{
			   echo '<div class="message warning">';}
			   echo '<h2><b>'.$titulo.'</b></h2>
					<p>'.$mensaje.'</p>
				  </div>';
				  break;			
			case "SUC":
			 if ($permite_ocultar==true){
		       echo '<div class="message success close">';}
			 else{
			   echo '<div class="message success">';}
			   echo '<h2><b>'.$titulo.'</b></h2>
					<p>'.$mensaje.'</p>
				  </div>';
				  break;			
			
			} //fin fuction box
		} //fin switch

//---------------------------------------------------------------------
//  ESTA FUNCION QUITA CARACTERES ESPECIALES DE LAS CONSULTAS SQL
function eliminar_acentos_car_esp($str){
    $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','�»','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','�»','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','�»','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǻ','�»','Ǽ','ǽ','Ǿ','ǿ');
    $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','A','a','AE','ae','O','o');
    return str_replace($a, $b, $str);
}
function eliminar_comillas($str){
    $a = array("'",'´','*','"');
    return str_replace($a, '', $str);
}
function corregir_comillas($str){
    $a = array("'",'"');
	$b= array("\'",'\"');
    return str_replace($a, $b,$str);
}
//--------------------------------------
   /**
     * ucfirst UTF-8 aware function
     *
     * @param string $string
     * @return string
     * @see http://ca.php.net/ucfirst
     */
    function my_ucfirst($string, $e ='utf-8') {
        if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) {
            $string = mb_strtolower($string, $e);
            $upper = mb_strtoupper($string, $e);
            preg_match('#(.)#us', $upper, $matches);
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e);
        } else {
            $string = ucfirst($string);
        }
        return $string;
    }
	
//convertir textos  mayusculoas minusculas etc------------------------------------------------
function trans_texto($str,$tipo){
	switch ($tipo) {
	case "TI":
		$str=mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
		break;
	case "MA":
		$str = mb_convert_case($str, MB_CASE_UPPER, "UTF-8");
		break;
	case "MI";
		$str = mb_strtolower($str);
		break;
	}
	return $str;
}

function enviar_email_inicio(){
			require_once('../class/PHPMailer/class.smtp.php');
		require_once('../class/PHPMailer/class.phpmailer.php');
		require_once('../class/PHPMailer/language/phpmailer.lang-es.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();
//acentos pongo el juego de caracteres
$mail->CharSet = "UTF-8";
$mail->Encoding = "quoted-printable";

//$body             = file_get_contents('contents.html');
//$body             = eregi_replace("[\]",'',$body);
	$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$servidor=$_SERVER['REMOTE_ADDR']." (".$nombre_host.")";
	$fecha=date("d-m-Y H:i:s");
	$destinatario = "mdalex2@hotmail.com"; 
$body = ' 
<html> 
<head> 
   <title>Inicio de sesión en SIREGEST</title> 
</head> 
<body> 
<h1>Hola Jairo Alexi!</h1> 
<p> 
<b>El usuario "'.trans_texto($_SESSION['nombre_usuario'],"TI").' (Login: '.$_SESSION['login'].'") pertenciente al grupo "'.trans_texto($_SESSION['grupo_usu'],"TI").'" a iniciado sesión en tu sistema desde la dirección '.$servidor.' </b> el día '.trans_texto(formato_fecha("LH",$fecha),"TI").'. Éste es un correo monitoreado si desea ver mas información sobre quien inició sesión ingresa como administrador.
</p> 
</body> 
</html> 
'; 

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mx1.hostinger.es"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "mx1.hostinger.es"; // sets the SMTP server
$mail->Port       = 2525;                    // set the SMTP port for the GMAIL server
$mail->Username   = "siregest@siregest.hol.es"; // SMTP account username
$mail->Password   = "jm8086506";        // SMTP account password
//$mail->SMTPSecure = 'tls'; //encryptado


$mail->SetFrom('siregest@siregest.hol.es','SIREGEST (Sistema)');

$mail->AddReplyTo("siregest@siregest.hol.es","SIREGEST (Sistema)");

$mail->Subject    = "Inicio de sesión en SIREGEST el ". formato_fecha("LH",$fecha);

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "mdalex2@yahoo.es"; //a quien encvio
$mail->AddAddress($address, "Alexi Mendoza");
//$mail->addCC("mdalex2@hotmail.com"); //copia
//$mail->addBCC("mdalex2@gmail.com"); // copia oculta

$mail=$mail;
//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Error al enviar el email: " . $mail->ErrorInfo;
} else {
  echo "Mensaje Enviado!";
}
}
?> 
