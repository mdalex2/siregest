<?php
include_once("../funciones/conexion.php");
include_once("../funciones/funcionesPHP.php");
//header('Cache-Control: no-cache, must-revalidate');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');
// Connect to MySQL database
//mysql_connect($_SESSION["host"], $_SESSION["usuario_bd"], $_SESSION["password"]);
//mysql_select_db($_SESSION["bd"]);
$link_cnn=conectarse();
$page = 1; // The current page
$sortname = 'texto_icono'; // Sort column
$sortorder = 'asc'; // Sort order
$qtype = ''; // Search column
$query = ''; // Search string
// Get posted data
if (isset($_POST['page'])) {
        $page = mysql_real_escape_string($_POST['page']);
}
if (isset($_POST['sortname'])) {
        $sortname = mysql_real_escape_string($_POST['sortname']);
}
if (isset($_POST['sortorder'])) {
        $sortorder = mysql_real_escape_string($_POST['sortorder']);
}
if (isset($_POST['qtype'])) {
        $qtype = mysql_real_escape_string($_POST['qtype']);
}
if (isset($_POST['query'])) {
        $query = mysql_real_escape_string($_POST['query']);
}
if (isset($_POST['rp'])) {
        $rp = mysql_real_escape_string($_POST['rp']);
} else {$rp=10;}
// Setup sort and search SQL using posted data
$sortSql = "order by $sortname $sortorder";
$searchSql = ($qtype != '' && $query != '') ? "where $qtype = '$query'" : '';
// Get total count of records
$sql = "select count(*)
from sis_funciones
$searchSql";
$result = mysql_query($sql,$link_cnn);
$row = mysql_fetch_array($result);
$total = $row[0];
// Setup paging SQL
$pageStart = ($page-1)*$rp;
$limitSql = "limit $pageStart, $rp";
// Return JSON data
$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();
$sql = "select id_func, texto_icono
from sis_funciones
$searchSql
$sortSql
$limitSql";

if (isset($_SERVER['HTTP_REFERER'])){
	$urlProcedencia=$_SERVER['HTTP_REFERER'];
	$pos_final_url_orig=strpos($urlProcedencia,'&');
	if ($pos_final_url_orig>0){
	$url_origen=substr($urlProcedencia,0,$pos_final_url_orig);} //fin si pos final>0
	else
	{$url_origen=$urlProcedencia;}
//echo $urlProcedencia;
} //fin http refer
else //si no tiene pagina de refrencia asigno la url que tiene
{
	$url_origen=$_SERVER['REQUEST_URI'];
	//echo $url_origen;
	}
	//$inivar=strpos($url_origen,'=')+1; //posicion inicial de la variable id_func en la url
	//$finvar=strlen($url_origen); //posision final de la variable id-func
	//$id_funcio=substr($url_origen,$inivar,$finvar);//obtengo el id func de la url origen
	

$results = mysql_query($sql,$link_cnn);
while ($row = mysql_fetch_assoc($results)) {
//$url_origen=$_SERVER['HTTP_REFERER'];
//codigo para boton eliminar:
$imagen_elim="<img src=\"../images/icons_menu/x32/elim_papelera_x32.png\" width=\"18px\" height=\"18px\" align=\"absmiddle\">";
$eliminar= "<a href=\"{$url_origen}&accion=elim&id={$row['id_func']}\" title=\"Eliminar la funci&oacute;n seleccionada\" class='link_dbl_over_black'
onClick=\"return test('ELIMINAR SELECCIONADOS','documents.flexme')
\"
>{$imagen_elim} Eliminar</a>";
//config para boton editar:
$imagen_edit="<img src=\"../images/icons_menu/x32/editar_x32.png\" width=\"18px\" height=\"18px\" align=\"absmiddle\">";
//esta variable es para el boton editar
$editar= "<a href=\"{$url_origen}&accion=edit&id={$row['id_func']}\" title=\"Modificar la funci&oacute;n seleccionada\" class='link_dbl_over_black'>{$imagen_edit} Editar</a>";
//esta variable es para que en la columna de la funcion permita editar al hacer click
$texto_icono_editar="<a href=\"{$url_origen}&accion=edit&id={$row['id_func']}\" title=\"Modificar la funci&oacute;n seleccionada\" class='link_dbl_over_black'
onClick=\"return test('EDITAR','documents.flexme')
\">{$row['texto_icono']}</a>";
//asigno el arreglo para enviarlo al grid
$data['rows'][] = array(
'id' => $row['id_func'],
'cell' => array($row['id_func'],
 utf8_encode($texto_icono_editar),
 utf8_encode($eliminar),
 utf8_encode($editar))
);
}
echo json_encode($data);
?>