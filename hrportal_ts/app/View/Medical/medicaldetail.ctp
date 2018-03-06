<?php

$auth = $this->Session->read('Auth'); ?>
<table class="uk-table uk-table-no-border">
    <?php $filesUploads=explode(",",$ldetails['MedicalBillAmount']['uploaded_file']);
        foreach ($filesUploads as $key=>$filesUpload) {?>
    <tr><td style="text-align: center"><?php echo $key+1;?></td><td style="text-align: center"><a href="<?php echo $this->webroot . 'uploads/Medical/' . $filesUpload; ?>" target="_blank" class="uk-badge uk-badge-primary">View Bill</a></td></tr>
<?php    
}
    ?>
</table>
