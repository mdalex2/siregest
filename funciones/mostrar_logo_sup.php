<?php
function mostrar_logo_sup(){
require_once("../funciones/detectar_resolucion.php");	
list($ancho,$alto)=detectar_resolucion();
				switch ($ancho) {
					case $ancho<=0:
						$logo_sup= '<img src="../wideadmin_files/logo_login.png" alt="Wide Admin" width="300" height="130">';
						break;
					case $ancho>0 and $ancho<=800:
						$logo_sup= '<img src="../wideadmin_files/logo_login.png" alt="Wide Admin" width="500" height="130">';
					case $ancho>800 and $ancho<=1024:
						$logo_sup= '<img src="../wideadmin_files/logo_login.png" alt="Wide Admin" width="650" height="130">';
						break;
					case $ancho>1024:
						$logo_sup= '<img  src="../wideadmin_files/logo_login.png" alt="Wide Admin" width="750" height="130">';
						break;
				}
				return $logo_sup;
				list($ancho,$alto)='';
				
}
?>