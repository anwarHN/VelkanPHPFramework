<?php
return array(
		"form"=>array(
				"alertSavingOk"=>"Registro guardado correctamente",
				"alertSavingNotOk"=>"Ocurri&oacute; un error al guardar los datos",
				"defaultInputValidationsMessages"=>array(
						"required"=>"Este campo es requerido",
						"email"=>"Ingrese un correo v&aacute;lido",
						"url"=>"Ingrese una dirección web v&aacute;lida",
						"number"=>"Ingrese un n&uacute;mero v&aacute;lido",
						"min"=>"El n&uacute;mero m&iacute;nimo permitido es {0}",
						"max"=>"El n&uacute;mero m&aacute;ximo permitido es {0}",
						"minlength"=>"El largo m&iacute;nimo permitido es {0}",
						"maxlength"=>"El largo m&aacute;ximo permitido es {0}"
						)
				),
		"err_msg"=>array(
				"noController"=>"No se pudo encontrar el control especificado",
				"noLayout"=>"No se pudo encontrar el layout especificado",
				"noModel"=>"No se pudo encontrar el modelo especificado"
				),
		"grid_msg"=>array(
				"noDataFound"=>"No se encontraron datos",
				"filterTip"=>"Mostrar/esconder opciones de filtrado",
				"addNewTip"=>"Agregar un nuevo registro",
				"updateTip"=>"Actualiza el registro seleccionado",
				"refreshTip"=>"Refrescar",
				"invalidFilterCaracter"=>"",
				/*El grid utiliza el caracter ':' para separa el indice del filtro con el valor. Si el usuario lo ingresa, le dara error*/
				"invalidSeparatorCaracterMsj"=>"No es permitido ingresar el caracter ':'",
				/*Este mensaje aparecerá cuando se ingrese un caracter en los filtros
				 * y que esten definidos en la propiedad datagrid->filters->invalidCaracter
				 * en el archivo config.php*/
				"invalidCaracterMsj"=>"No es permitido ingresar el caracter '%'",
				"orderAsc"=>"Orden ascendente",
				"orderDesc"=>"Orden descendente",
				"first"=>"|<",
				"prev"=>"<<",
				"next"=>">>",
				"last"=>">|"
				),
		"file"=>array(
				"notAllowedFileExtension"=>"Tipo de archivo no permitido",
				"label"=>"Cargar archivo...",
				"uploadButton"=>"Subir",
				"deleteButton"=>"Eliminar",
				"maxFileSizeExceeded"=>"El tama&ntilde;o del archivo supera el m&aacute;ximo permitido"
				),
		"lookup"=>array(
				"closeButton"=>"Cancelar",
				"noDataFound"=>"No se encontraron datos"
				),
		"htmlHelper"=>array(
				"breadcrumbs"=>array(
						"homeCaption"=>"Inicio"
						),
				"confirmAction"=>array("yes"=>"Si","no"=>"No")
				)
);
?>