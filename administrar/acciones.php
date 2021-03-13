<?php
function procesa_eliminar($id_func){
//transformo a arreglo lo emitido por el id separado por comas
$array_id_func =  explode(",", $id_func);
$index=0;
$sql="";
foreach ($array_id_func as $index => $valor) {
	if ($valor!=''){
		//echo "$index vale $valor <br>";
		$sql.="delete from sis_funciones where id_func=\"{$valor}\";";
	}
} //fin for each
//echo "$sql"; 
$link=conectarse();

} //fin funcion
function verificar_accion(){
//si el ususario presionó elminar elimino el  o los id marcados
if (isset($_GET["id"]) and isset($_GET["accion"])){
	$accion=$_GET["accion"];
	$id=$_GET["id"];
	switch  ($accion){
		case "elim":
			procesa_eliminar($id);
			break;
		case "edit":
			
	} //fin switch
} //fin si se han declarado varaibles get (isset)
} //fin funcion
?>