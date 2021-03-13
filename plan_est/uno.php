<form id="form1" name="form1" method="post" action="dos.php"> 
  <table width="200" border="1" align="center"> 
    <tr> 
      <td>Ver</td> 
      <td>Nombre</td> 
      <td>Cantidad</td> 
    </tr> 
 <?php 

 for($i=0; $i<=2; $i++) { 
 ?> 
    <tr> 
      <td><input type="checkbox" name="ckb_sel[<?php echo $i?>]" id="ckb_sel[<?php echo $i?>]"/></td> 
      <td> 
      <input type="text" name="textfield[<?php echo $i?>]" id="textfield[<?php echo $i?>]" /></td> 
      <td> 
      <input type="text" name="txt_can[<?php echo $i?>]" id="txt_can[<?php echo $i?>]"  /></td> 
    </tr> 
 <?php 
 } 
 ?> 
  </table><br /> 
  <div align="center"> 
    <input type="submit" name="btn_guardar" id="btn_guardar" value="Guardar" /> 
  </div> 
</form>