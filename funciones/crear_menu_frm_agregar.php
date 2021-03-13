<!--<script type="text/javascript" src="../wideadmin_files/superfish.js"></script>-->
<?php
require_once("../funciones/funcionesPHP.php");
require_once("valida_sesion.php");
verifica_caducidad_sesion();
/**
  ------ CREA MENU PARA USUARIOS
*/
					function cerrar_ul(&$menu){
					$cant_ul=substr_count($menu, '<ul'); //cuanto cuantos ul hay en el menu
					$cant_f_ul=substr_count($menu, '</ul'); //cuento cuantos /ul hay en el menu
					// agrego los /ul que faltan para cerrar el menu bien -1 porque debo dejar uno para el final de la ayuda
					for ($i=$cant_f_ul;$i<$cant_ul-1;$i++){
						$cant_ul=substr_count($menu, '<ul'); //cuanto cuantos ul hay en el menu
						$menu.="</ul>";
						} 
					return $menu;
				}

    function crear_menu_usuario_add(){
    require_once("conexion.php");
    require_once("../funciones/funcionesPHP.php");
    
    $link = conectarse();
    
     $menu = "<div id='navbar'>
<ul class='nav sf-js-enabled sf-shadow'>
	 ";

    
    function getHijos($id,$id_grupo_del_usuario){
		
				$sql = "SELECT id_func from sis_funciones where id_padre='$id' and activa=true  ORDER BY ORDEN asc,TRIM(texto_icono) ASC";
				
        $res = mysql_query($sql);
		
        $hijos = mysql_affected_rows();
        return($hijos);
    }
    
    function menu($id, &$menu, $profundidad = 0) { 
         //echo "[ $id, $profundidad ]";
		 $id_grupo_del_usuario=$_SESSION['id_grupo_usuario'];
		// ini_set('display_errors', 0); //ignora errores
			$sql = "SELECT id_func,id_padre,texto_icono,orden,icono32,icono48,url from sis_funciones where id_padre='$id' and activa=true ORDER BY ORDEN ASC,TRIM(texto_icono) ASC";
         
         $res = mysql_query($sql); 
			//echo "total registros: ".mysql_affected_rows();
		 if (!$res){echo '<div class="message error">
							<h2>ERROR EN LA BASE DE DATOS!</h2>
							<p>El archivo de conexión no está debidamente configurado, es posible que se halla configurado una base de datos distinta a la usada por el sistema SIREGEST, verifique los datos del archivo de configuración al servidor de base de datos e intente de nuevo, para acceder a la opción de configuración,<b> <a href="../instalacion/archivo_conexion_form.php">haga clic aquí</a></p>
							<p><br>Información técnica: </b>'.mysql_error().'. Error Nº: '.mysql_errno().'						</div>	';
						exit();}
         $j = 1;
		 /*echo "<table>";
	while ($row=mysql_fetch_array($res))
{
echo '<tr><td>'.$row["id_func"].'</td>';
echo '<td>'.$row["texto_icono"].'</td></tr>';
}*/
         while ($row = mysql_fetch_array($res)){ 
                 //pregunto la cantidad de hijos que tiene el item que entra al primero le agrego <ul> y al ultimo hijo le agrego </ul>
				 $id=$row["id_func"];
                $hijos = getHijos($id,$id_grupo_del_usuario);
								$texto_icono=trans_texto($row["texto_icono"],"TI");
								//$texto_icono=trans_texto($texto_icono,"TI");

				//echo $row["id_func"]."-(hijos:".$hijos.")";
                /* muestro mensaje con el nombre del icono o funcion*/
				  
				  /*verifico si el item tiene imagen para mostrar si tiene la muestro*/
			      $directorio_img_x32="../images/icons_menu/x32/";
				  $ruta_icons_menu=$directorio_img_x32.$row['icono32'];
				  if (file_exists("$ruta_icons_menu") and $row['icono32']!=''){ 
   					$icono="<img src=$ruta_icons_menu align='top' width='18px' height='18px'/></img> ";
				  }else{ 
   					$ruta_icons_menu=$directorio_img_x32."image-warn.png";
					$icono="<img src=$ruta_icons_menu align='top' Alt='error en la imagen' width='16px' height='16px'/></img> ";
				  }
          if($hijos > 0) //si tiene mas submenu agrego la clase que da forma de submenu de lo contrario solo agrego un <li> mas 
					{
						$menu .= "<li class=''><a class='sf-with-ul' 
						onclick='if ({$row['orden']}!=0) {
						//$(\"#txt_texto_enlace\").removeAttr(\"disabled\");
						//$(\"#txt_texto_enlace\").val(\"\");
						$(\"#menu_seleccionado\").text(\" |  MEN&Uacute; SELECCIONADO: {$row['texto_icono']}\");
						$(\"#chk_raiz\").removeAttr(\"checked\",\"checked\")
						$(\"#txt_padre\").val(\"{$row['id_func']}\");
						$(\"#txt_texto_enlace\").focus();
						}						
						else
							alert(\"ATENCI&Oacute;N: Una funci&oacute;n no puede colocarse dentro del men&uacute; inicio. Seleccione otro menu\");
						' title=\"Id. funci&oacute;n: {$row['id_func']}\">
						$icono $texto_icono</a>
						";
						//$(\"#chk_raiz\").removeAttr(\"checked\",\"checked\")
					}
					else
					{
						$menu .= "<li><a  
						onclick='if ({$row['orden']}!=0) {
						//$(\"#txt_texto_enlace\").removeAttr(\"disabled\");
						//$(\"#txt_texto_enlace\").val(\"\");
						$(\"#menu_seleccionado\").text(\"  |   MEN&Uacute; SELECCIONADO: {$row['texto_icono']}\");
						$(\"#chk_raiz\").removeAttr(\"checked\",\"checked\")
						$(\"#txt_padre\").val(\"{$row['id_func']}\");
						$(\"#txt_texto_enlace\").focus();
						} 
						else
							alert(\"ATENCI&Oacute;N: Una funci&oacute;n no puede colocarse dentro del men&uacute; inicio. Seleccione otro menu\");
						' title=\"Id. funci&oacute;n: {$row['id_func']}\">
						$icono $texto_icono</a></li>
						 ";
					}					
				

                if($hijos > 0)
					{
						/*$menu .= "<ul>";   original*/
						$menu.= "<ul style='display: none; visibility: hidden;'>
						";
						
					}

                if( ($row['id_padre'] != "0") && (getHijos($row['id_padre'],$id_grupo_del_usuario) == $j) && (getHijos($row['id_func'],$id_grupo_del_usuario) == 0)){
									$menu.="</ul>";
                }
				
                 $j++;
                  menu($row['id_func'], $menu, $profundidad + 1); 
									//caso especial cierro todo los ul si es raiz y tiene 
									if ((getHijos($row['id_func'],$id_grupo_del_usuario) ==1 && $row["id_padre"]=="-1") || (getHijos($row['id_func'],$id_grupo_del_usuario) ==$hijos && $row["id_padre"]=="-1")){
										$menu=cerrar_ul($menu);
										//nota: ||= or
										}

         }
         
    }

    menu('-1', $menu);
	
    /*echo"<br><br>";*/
	//'<li><a href="../ayuda/ayuda.php"><img src="../images/icons_menu/x32/help.png" align="absmiddle" width="18" height="18"> Ayuda</a></li>'.
	
		$cant_ul=substr_count($menu, '<ul'); //cuanto cuantos ul hay en el menu
		$cant_f_ul=substr_count($menu, '</ul'); //cuento cuantos /ul hay en el menu
		// agrego los /ul que faltan para cerrar el menu bien -1 porque debo dejar uno para el final de la ayuda
		for ($i=$cant_f_ul;$i<$cant_ul-1;$i++){
			$menu.="</ul>";
			} 
		// agrego la opcion de ayuda
   		//$menu .= '<li><a href="../ayuda/ayuda.php"><img src="../images/icons_menu/x32/help.png" align="absmiddle" width="18" height="18"> Ayuda</a></li></ul>';
		
   $_SESSION['var_menu_add']=$menu; //asigno a la variable de sesion var_menu lo genereado en la consulta sql asi seria mas rapido de cargar en las demas paginas
    print_r($menu);
		return $menu;
		
}
?>