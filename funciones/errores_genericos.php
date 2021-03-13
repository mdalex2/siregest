	
<?php
function obtener_error($num_error){
	switch ($num_error){
		case 1062:
			$error="El registro que intenta almacenar ya existe en la base de datos, verifíque los datos e intente de nuevo ";
			break;
		case 1451:
			$error="No se puede eliminar el registro porque existen datos relacionados, por medida de seguridad el sistema evita eliminar datos relacionados";
			break;
		case 1452:
			$error="Se requiere un campo relacionado, este error por lo general sucede cuando falta un dato que esta relacionado con otro campo, verifique que se halla seleccionado todos los registros en la pagina donde estaba ingresando la informaci&oacute;n ";
			break;
		default:
			$error="Error no definido: ".$num_error.". Posible causa: ".mysql_error();
			break;
	}
	return $error;
	}
?>
