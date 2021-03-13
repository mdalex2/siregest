<html> 
  <head> 
		<style type="text/css" media="all">
		@import url("../js/DataTables-1.9.0/media/css/demo_page.css");
    @import url("../js/DataTables-1.9.0/media/css/demo_table_jui.css");
    @import url("../js/DataTables-1.9.0/media/themes/smoothness/jquery-ui-1.8.4.custom.css");
    @import url("../js/DataTables-1.9.0/media/css/TableTools_JUI.css");
    </style>
		<script type="text/javascript" charset="utf-8" src="../js/jquery-1.7.1.min.js"></script>

		<script charset="utf-8" src="../js/DataTables-1.9.0/media/js/jquery.dataTables.js"></script>
		<script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ZeroClipboard.js"></script>
		<script charset="utf-8" src="../js/DataTables-1.9.0/media/js/TableTools.js"></script>
    <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ColReorderWithResize.js"></script>
        <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ColVis.min.js"></script>

		<script type="text/javascript" charset="utf-8">
			$(document).ready( function () {
				$('#the_table').dataTable( {
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"sDom": '<"H"RTfrC>t<"F"pli>',
					
					"oTableTools": {
						"sSwfPath": "../js/DataTables-1.9.0/media/swf/copy_cvs_xls_pdf.swf",
						"aButtons": [
							"copy", "csv", "xls", "pdf","print",
							{
								"sExtends":    "collection",
								"sButtonText": "Guardar",
								"aButtons":    [ "csv", "xls", "pdf" ]
							}
						]
					}
				} );
			} );
		</script>  
  </head> 
<body> 
    <div style="width:100%"> 
      <table id="the_table" > 
        <thead> 
          <tr>
            <th>Artist / Band</th><th>Album</th><th>Song</th>
          </tr> 
        </thead> 
        <tbody> 
          <tr><td>Muse</td>
              <td>Absolution</td>
              <td>Sing for Absolution</td>
          </tr> 
          <tr><td>Primus</td>
            <td>Sailing The Seas Of Cheeseeeeeeeeeeeeeeeee</td>
            <td>Tommy the Cat</td>
          </tr> 
          <tr><td>Nine Inch Nails</td>
              <td>Pretty Hate Machine</td>
              <td>Something I Can Never Have</td>
          </tr> 
          <tr><td>Horslips</td>
            <td>The Táin</td>
            <td>Dearg Doom</td>
          </tr> 
          <tr><td>Muse</td>
              <td>Absolution</td>
              <td>Hysteria</td>
          </tr>
          <tr>
            <td>Primus</td>
            <td>Sailing The Seas Of Cheese</td>
            <td>Tommy the Cat</td>
          </tr>
          <tr>
            <td>Nine Inch Nails</td>
            <td>Pretty Hate Machine</td>
            <td>Something I Can Never Have</td>
          </tr>
          <tr>
            <td>Horslips</td>
            <td>The Táin</td>
            <td>Dearg Doom</td>
          </tr>
          <tr>
            <td>Muse</td>
            <td>Absolution</td>
            <td>Hysteria</td>
          </tr>
          <tr>
            <td>Primus</td>
            <td>Sailing The Seas Of Cheese</td>
            <td>Tommy the Cat</td>
          </tr>
          <tr>
            <td>Nine Inch Nails</td>
            <td>Pretty Hate Machine</td>
            <td>Something I Can Never Have</td>
          </tr>
          <tr>
            <td>Horslips</td>
            <td>The Táin</td>
            <td>Dearg Doom</td>
          </tr>
          <tr>
            <td>Muse</td>
            <td>Absolution</td>
            <td>Hysteria</td>
          </tr>
          <tr>
            <td>Alice In Chains</td>
            <td>Dirt</td>
            <td>Rain When I Die</td>
          </tr>
          <tr>
            <td>Primus</td>
            <td>Sailing The Seas Of Cheese</td>
            <td>Tommy the Cat</td>
          </tr>
          <tr>
            <td>Nine Inch Nails</td>
            <td>Pretty Hate Machine</td>
            <td>Something I Can Never Have</td>
          </tr>
          <tr>
            <td>Horslips</td>
            <td>The Táin</td>
            <td>Dearg Doom</td>
          </tr>
          <tr>
            <td>Muse</td>
            <td>Absolution</td>
            <td>Hysteria</td>
          </tr>
          <tr>
            <td>Alice In Chains</td>
            <td>Dirt</td>
            <td>Rain When I Die</td>
          </tr>
          <tr>
            <td>Alice In Chains</td>
            <td>Dirt</td>
            <td>Rain When I Die</td>
          </tr> 
          <tr><td>Alice In Chains</td>
            <td>Dirt</td>
            <td>Rain When I Die</td>
          </tr> 
          <!-- PLACE MORE SONGS HERE -->
        </tbody> 
      </table> 
    </div>
</body> 
</html> 