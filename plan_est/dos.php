 <?PHP
  if(!isset($_REQUEST['ckb_sel'])){
    echo 'Ninguna casilla marcada';
  }else{
 
    $ckb_sel = $_REQUEST['ckb_sel'];
    $txt_can = $_REQUEST['txt_can'];
    $textfield = $_REQUEST['textfield'];
  
  
 for($dor=0; $dor < sizeof($ckb_sel); $dor++) 
           { 
                  if(!isset($ckb_sel[$dor])){ $ckb_sel[$dor]='off';}
                  
                  if($ckb_sel[$dor]=='on'){
                  echo $ckb_sel[$dor]."-".$textfield[$dor]."-".$txt_can[$dor]."<br />";
                  } 
                    
           }
           
   }        
?>