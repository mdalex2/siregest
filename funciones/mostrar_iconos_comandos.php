<?php
header('Content-type: text/html; charset=utf-8');
include_once("funcionesPHP.php");
//include_once("../class/class.kpaginate.php");
mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");
function mostrar_iconos_comandos(){
	//for ($i=1;$i<10;$i++){
							$link=conectarse();
							$id_grupo_del_usuario=$_SESSION['id_grupo_usuario'];
							$usu_actual=$_SESSION['id_usuario'];

							//si es administrador muestro todas las funciones
							if ($id_grupo_del_usuario=="G0001"){
								$limite=100;
								if (isset($_REQUEST['filtro'])){
								$filtro=eliminar_comillas($_REQUEST['filtro']);} else {$filtro="";}
								$consulta=mysql_query("SELECT id_func,texto_icono,icono48,url,descrip_func from sis_funciones  where sis_funciones.activa=true and sis_funciones.url<>'#' and sis_funciones.texto_icono like '%".$filtro."%' order by id_padre,texto_icono asc",$link);								
							} else {
								$limite=30;
							if ($id_grupo_del_usuario!='G0001'){
								$filtro_grupo=" and sis_priv_grup.id_grupo='".$id_grupo_del_usuario."' ";
							}
							else
							{$filtro_grupo='';
								}
							//si hay filtro ejecuto la consulta para mostrar elementos depende de lo que el usuario pidió
							if (isset($_REQUEST['filtro'])){
								$filtro=eliminar_comillas($_REQUEST['filtro']);
								$consulta=mysql_query("SELECT distinct sis_funciones.id_func,texto_icono,icono48,url,sis_funciones.descrip_func,sis_priv_grup.mostrar from (sis_funciones right join sis_priv_grup on sis_funciones.id_func=sis_priv_grup.id_func) where sis_funciones.activa=true and sis_priv_grup.mostrar=true".$filtro_grupo." and sis_funciones.url<>'#' and sis_funciones.texto_icono like '%".$filtro."%' order by id_padre,texto_icono asc",$link);
								}
							else // si no hubo filtro en los items o comandos a mostrar muestro 20
							{
								$consulta=mysql_query("SELECT distinct sis_funciones.id_func,texto_icono,icono48,url,sis_funciones.descrip_func,sis_priv_grup.mostrar from (sis_funciones right join sis_priv_grup on sis_funciones.id_func=sis_priv_grup.id_func) where sis_funciones.activa=true and sis_priv_grup.mostrar=true ".$filtro_grupo." and sis_funciones.url<>'#' order by id_padre,texto_icono asc limit $limite",$link);
								//$consulta=mysql_query("SELECT sis_funciones.*,sis_priv_grup.mostrar, sis_func_recientes.* from ((sis_func_recientes right join sis_priv_grup on sis_func_recientes.id_func_rec=sis_priv_grup.id_func) left join sis_funciones on sis_func_recientes.id_func_rec=sis_funciones.id_func) where sis_funciones.activa=true and sis_priv_grup.mostrar=true and sis_priv_grup.id_grupo='$id_grupo_del_usuario' and sis_funciones.url<>'#' and sis_func_recientes.id_usuario_rec='$usu_actual' order by sis_func_recientes.fecha_uso desc limit 15 ",$link);}
							   //$consulta=mysql_query("select * from sis_funciones where id_padre<>-1 order by texto_icono asc",$link);
							   } // fin else
} //fin de si es administrador ----------------
							//si hubo error en la consulta
							if (!$consulta){
								mostrar_box("err",false,"Ayuda del sistema","Se produjo un error al efectuar la consulta: ".mysql_error());
								}
							//si no hubo error en la consulta muestro os elemntos
							else {
								if (mysql_num_rows($consulta)>0){
								  while($fila=mysql_fetch_array($consulta)){
								    if (strlen($fila['texto_icono'])>31){								                                      $texto_icono=substr($fila['texto_icono'],0,27).'...';}
									else {
									  $texto_icono=$fila['texto_icono'];}
									  if ($fila['icono48']!=''){
									    $icono_48='../images/icons_menu/x48/'.$fila['icono48'];
										if (!file_exists($icono_48)){
										  $icono_48='../images/icons_menu/x48/error_imagen_48.png';
											}
										}
										if ($fila['descrip_func']!=''){
											 $descripcion=$fila['descrip_func'];} 
										else 
											 {$descripcion= $fila['texto_icono'];}
								    echo "<li><a href='".$fila['url']."?id_func=".$fila['id_func']."' title='".$descripcion."' class='tooltip'><img src='".$icono_48."' title='' ><span>".trans_texto($texto_icono,"TI")."</span></a></li>";
									} //FIN DE WHILE

									} //FIN DE IF NUM ROW >0
									else
									{
									  mostrar_box("inf",true,"Resultado de la consulta","No se encontraron funciones disponibles para ejecutar");
										}
							}
}
//}
?>
