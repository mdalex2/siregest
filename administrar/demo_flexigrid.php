<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/flexigrid-1.1/js/flexigrid.pack.js"></script>
<style type="text/css" media="all">
@import url("../js/flexigrid-1.1/css/flexigrid.pack.css");
</style>
</head>

<body>
<table class="flexme" style="display: none"></table>

	<script type="text/javascript">
		$(".flexme").flexigrid({
			url : 'script.php',
			dataType : 'json',
			colModel : [ {
				display : 'id_func',
				name : 'id_func',
				width : 40,
				sortable : true,
				align : 'center'
			}, {
				display : 'texto_icono',
				name : 'texto_icono',
				width : 180,
				sortable : true,
				align : 'left'
			}],
			buttons : [ {
				name : 'Add',
				bclass : 'add',
				onpress : test
			}, {
				name : 'Delete',
				bclass : 'delete',
				onpress : test
			}, {
				separator : true
			} ],
			searchitems : [ {
				display : 'Codigo de funcion',
				name : 'id_func'
			}, {
				display : 'Funcion',
				name : 'texto_icono',
				isdefault : true
			} ],
			sortname : "texto_icono",
			sortorder : "asc",
			usepager : true,
			title : 'Funcion',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : 700,
			height : 200
		});

		function test(com, grid) {
			if (com == 'Delete') {
				confirm('Delete ' + $('.trSelected', grid).length + ' items?')
			} else if (com == 'Add') {
				alert('Add New Item');
			}
		}
	</script>
</body>
</html>