<?php $auth = $this->Session->read('Auth'); ?>

  
    
<?php

foreach($result as $skills) {



 $data[]=$skills["id"].'-'.$skills["name"];
}
echo json_encode($data);
?>

