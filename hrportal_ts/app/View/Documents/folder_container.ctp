<?php 
if($folderID != '0' && $folderID != '5'){
    echo $this->form->input('folderName'.$folderID, array('label'=>false,'type' => "select",'id'=>'lable_'.$folderID,'required'=>true,'options'=>$child_Folder,'onchange'=>'getfolder(this.value,"'.$folderID.'")', 'class' => "md-input selectized",'data-md-selectize')); 
}
if($folderID == '0'){
    echo $this->form->input('folderName'.$folderID, array('label'=>false,'type' => "select",'id'=>'lable_'.$folderID, 'multiselect'=>true,'required'=>true,'options'=>$child_Folder, 'class' => "md-input",'data-md-selectize')); 
}
if($folderID == '5'){
    //echo $this->form->input('filereff', array('label'=>false,'type' => "select",'id'=>'lable_'.$folderID, 'multiple'=>'multiple','options'=>$child_Folder, 'class' => "md-input",'data-md-selectize')); 
   $k=1;
    foreach($child_Folder as $key=>$mails){
        if($key != ''){
        echo $k.'. '.$mails.'<br>';
        $k++;
        }
        
    }
}

?>