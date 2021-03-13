<script type="text/javascript" src="../wideadmin_files/superfish.js"></script>
<?php
session_cache_limiter('nocache,private'); //evita mensaje de sesion expirada al presionar atras en el navegador
require_once("../funciones/funcionesPHP.php");
require_once("valida_sesion.php");
verifica_caducidad_sesion();

			echo '<div id="header" class="fondo_superior">';

				//<!-- Top -->
				echo '<div id="top">';
					//<!-- Logo -->
					
					echo '<div class="logo"> ';
						echo '<a href="../acceso_sis/menu_principal.php" title="Ir a menú principal" class="tooltip"><img src="../wideadmin_files/logo.png" alt="Menú principal" width="600" height="89px"></a></div>';
					//<!-- End of Logo -->
					if (isset($_SESSION["nom_plantel_corta_ses"])){
						$plantel=trans_texto($_SESSION["nom_plantel_corta_ses"],"MA");
					} else {$plantel="ACCESO A TODOS LOS PLANTELES";}
					//<!-- Meta information -->
					echo '<div class="meta">
					<p><b><a href="../acceso_sis/selecciona_plantel.php"> PLANTEL:</b> '.$plantel.'</a><br><b>USUARIO:</b> '.strtoupper($_SESSION['nombre_usuario']).'</p>
						<ul>
                        	
							<li><a href="../funciones/salir_sistema.php" title="Salir del sistema" ><span
 class="ui-icon ui-icon-power"></span>Salir</a></li>
							
							<li><a href="../usuarios/informacion_cuenta.php" title="Información de la cuenta" class="resize fancybox.iframe"><span 
class="ui-icon ui-icon-person"></span>Mi cuenta</a></li>

						</ul>
						
					</div>';
					//<li><a href="mensajes.php" title="Revisar mensajes" ><span class="ui-icon ui-icon-mail-closed"></span>Mensajes (0)</a></li>
					//<!-- End of Meta information -->

				echo "</div>";
				//<!-- End of Top-->
                
/**
  ------ CREA MENU PARA USUARIOS
*/
	
    function crear_menu_usuario(){
    require_once("conexion.php");
    require_once("../funciones/funcionesPHP.php");
    
    $link = conectarse();
    
     $menu = "<div id='navbar'>
<ul class='nav sf-js-enabled sf-shadow'>
	 ";

    function getHijos($id,$id_grupo_del_usuario){
		if ($id_grupo_del_usuario=='G0001'){
			$sql = "SELECT id_func from sis_funciones where id_padre='$id' and activa=true  ORDER BY ORDEN asc,TRIM(texto_icono) ASC";
			//$sql = "SELECT distinct sis_funciones.*,sis_priv_grup.mostrar from (sis_funciones right join sis_priv_grup on sis_funciones.id_func=sis_priv_grup.id_func) where sis_funciones.activa=true and sis_funciones.id_padre='".$id."' and sis_priv_grup.mostrar=true order by orden asc";
			} else
		{
			$sql = "SELECT distinct sis_funciones.*,sis_priv_grup.mostrar from (sis_funciones right join sis_priv_grup on sis_funciones.id_func=sis_priv_grup.id_func) where sis_funciones.activa=true and sis_funciones.id_padre='$id' and sis_priv_grup.mostrar=true and sis_priv_grup.id_grupo='$id_grupo_del_usuario' order by sis_funciones.orden,sis_funciones.texto_icono asc";
			}
		
        $res = mysql_query($sql);
        $hijos = mysql_affected_rows();
        return($hijos);
    }
    
    function menu($id,&$menu, $profundidad = 0) { 
         //echo "[ $id, $profundidad ]";
		 $id_grupo_del_usuario=$_SESSION['id_grupo_usuario'];
		// ini_set('display_errors', 0); //ignora errores
		if ($id_grupo_del_usuario=='G0001'){
			$sql = "SELECT id_func,id_padre,texto_icono,orden,icono32,icono48,url from sis_funciones where id_padre='$id' and activa=true ORDER BY ORDEN ASC,TRIM(texto_icono) ASC";
			//$sql = "SELECT distinct sis_funciones.*,sis_priv_grup.mostrar from (sis_funciones right join sis_priv_grup on sis_funciones.id_func=sis_priv_grup.id_func) where sis_funciones.activa=true and sis_funciones.id_padre='".$id."' and sis_priv_grup.mostrar=true   ORDER BY CONCAT(ORDEN,TRIM(texto_icono)) ASC";
			}
		else
		{
			$sql = "SELECT distinct sis_funciones.*,sis_priv_grup.mostrar from (sis_funciones right join sis_priv_grup on sis_funciones.id_func=sis_priv_grup.id_func) where sis_funciones.activa=true and sis_funciones.id_padre='$id' and sis_priv_grup.mostrar=true and sis_priv_grup.id_grupo='$id_grupo_del_usuario'  ORDER BY ORDEN asc,TRIM(texto_icono) asc";
			}
         
         $res = mysql_query($sql); 
			//echo "total registros: ".mysql_affected_rows();
		 if (!$res){echo '<div class="message error">
							<h2>ERROR EN LA BASE DE DATOS!</h2>
							<p>El archivo de conexión no está debidamente configurado, es posible que se halla configurado una base de datos distinta a la usada por el sistema SIREGEST, verifique los datos del archivo de configuración al servidor de base de datos e intente de nuevo, para acceder a la opción de configuración,<b> <a href="../instalacion/archivo_conexion_form.php">haga clic aquí</a></p>
							<p><br>Información técnica: </b>'.mysql_error().'. Error Nº: '.mysql_errno().'						</div>	';
						exit();}
         $j = 1;
         while ($row = mysql_fetch_array($res)){ 
                 //pregunto la cantidad de hijos que tiene el item que entra al primero le agrego <ul> y al ultimo hijo le agrego </ul>
				 				$id=$row["id_func"];
								$texto_icono=$row["texto_icono"];
								$texto_icono=my_ucfirst($texto_icono);
                $hijos = getHijos($id,$id_grupo_del_usuario);
 								
				//echo $row["id_func"]."-(hijos:".$hijos.")";
                /* muestro mensaje con el nombre del icono o funcion*/
				  
				  /*verifico si el item tiene imagen para mostrar si tiene la muestro*/
			      $directorio_img_x32="../images/icons_menu/x32/";
				  $ruta_icons_menu=$directorio_img_x32.$row['icono32'];
				  if (file_exists("$ruta_icons_menu") and $row['icono32']!=''){ 
   					$icono="<img src=$ruta_icons_menu align='top' width='20px' height='20px'/></img> ";
				  }else{ 
   					$ruta_icons_menu=$directorio_img_x32."image-warn.png";
					$icono="<img src=$ruta_icons_menu align='top' Alt='error en la imagen' width='20px' height='20px'/></img> ";
				  }
          if($hijos > 0) //si tiene mas submenu agrego la clase que da forma de submenu de lo contrario solo agrego un <li> mas 
					{
						$menu .= "<li class=''><a class='sf-with-ul' href={$row['url']}>$icono $texto_icono</a>
						<ul style='display: none; visibility: hidden;'>
						";
					}
					else
					{
						$menu .= "<li><a href='{$row['url']}?id_func=".$row["id_func"]."'>$icono $texto_icono</a></li>
						 ";
					}					
                if(($row["id_padre"]!="0") && (getHijos($row['id_padre'],$id_grupo_del_usuario) == $j) && (getHijos($row['id_func'],$id_grupo_del_usuario) == 0)){
									$menu.="</ul>";
									//if ($hijos>0) {
										//$menu=cerrar_ul($menu);
									//}
									 
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
	//unset($_SESSION['var_menu']);
	//si ya ha sido iniciada la sesion solo se muestra el menu creado para rapidez del sistema
	if (isset($_SESSION['var_menu']) and strlen($_SESSION['var_menu'])>0){
			//echo "imprimio la variable!!!!!!!!!!!!!:".strlen($_SESSION["var_menu"]);
			print_r($_SESSION["var_menu"]);}
			//echo "<font color='white'>IMPRIMIO LA VARIABLE";
	else //si no se ha creado anteriormente al iniciar la sesion el menu se crea y se muesta;
	{
    menu('-1', $menu);

			$menu=cerrar_ul($menu);
		// agrego la opcion de ayuda
   		$menu .= '<li class=""><a class="sf-with-ul" href="#"><img src="../images/icons_menu/x32/help.png" align="top" height="20px" width="20px">  Ayuda<span class="sf-sub-indicator"></span></a>
						<ul style="visibility: hidden; display: none;">

						 <li><a href="../usuarios/informacion_cuenta.php" class="resize fancybox.iframe"><img src="../images/sistema/information.png" align="top" height="20px" width="20px">  A cerca de...</a></li>
						 						 <li><a href="../ayuda/proyecto.pdf"><img src="../images/sistema/book.png" align="top" height="20px" width="20px">  El proyecto...</a></li>

						
						 <li><a href="../ayuda/manual_usu.htm"  target="_blank"><img src="../images/sistema/manual.png" align="top" height="20px" width="20px">  Manual de usuario</a></li>
             
</ul>                
</li>
</ul>';
		
   $_SESSION['var_menu']=$menu; //asigno a la variable de sesion var_menu lo genereado en la consulta sql asi seria mas rapido de cargar en las demas paginas
    print_r($menu);
	
	//echo "<font color='white'>IMPRIMIO EL MENU WHILE";
	} //fin del else de si no se habia creado aanteriormente el menu
	
	//inicio la sesion y guardo el menu de arriba en una variable de sesion para que luego en las demás paginas sea más rapido cargar los items del menú
}
//!-- Search bar -->
				if (isset($_POST['q'])){
					$filtro=$_POST['q'];
					header('location:../acceso_sis/menu_principal.php?filtro='.$filtro);
					}
					else
					{$filtro='';}
					
				echo '<div id="search">
					<form action="../acceso_sis/menu_principal.php?filtro='.$filtro.'" method="POST">
						<p>
							<input value="" class="but" type="submit">
							<input name="q" title="Buscar en el panel de funciones" value="';
							if (isset($_REQUEST['filtro'])){
								echo $_REQUEST['filtro'];} else echo "Buscar en el panel de funciones";
							echo '" 
onfocus="if(this.value==this.defaultValue)this.value=\'\';" 
onblur="if(this.value==\'\')this.value=this.defaultValue;" type="text">
						</p>
					</form>
				</div>';
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
				function cerrar_li(&$menu){
					$cant_li=substr_count($menu, '<li'); //cuanto cuantos ul hay en el menu
					$cant_f_li=substr_count($menu, '</li'); //cuento cuantos /ul hay en el menu
					// agrego los /ul que faltan para cerrar el menu bien -1 porque debo dejar uno para el final de la ayuda
					for ($i=$cant_f_li;$i<$cant_li-1;$i++){
						$cant_li=substr_count($menu, '<li'); //cuanto cuantos ul hay en el menu
						$menu.="</li>";
						} 
					return $menu;
				}
				
?>