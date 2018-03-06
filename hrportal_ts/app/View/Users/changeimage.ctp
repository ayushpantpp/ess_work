<?php
echo $this->Html->script('fileuploader.js');
?>
<style>
  #fileuploader{
    background: url("../img/upload-file.png") no-repeat scroll 0 0 transparent;
    color: #E9ECEB;
    direction: ltr;
    display: block;
    font-size: 0;
    height: 26px;
    padding: 0;
    text-indent: -19px;
    width: 119px;
	float:left;
}

#status_message{
    font-family:Arial; padding:5px;
    color:#b00000;
    font-size:12px;
  }
ul#files_list{ list-style:none; padding:0; margin:0; }
ul#files_list li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px; text-align:center;color:#ffffff;}
ul#files_list li img{ max-width:180px; max-height:150px; }
.success{ background:#000000; border:1px solid #cccccc; }
.error{ background:#f0c6c3; border:1px solid #cc6622; }
</style>
<div class="uploder" id="fileuploader">Upload File</div><span id="status_message" ></span>
<?php
echo $this->form->input('folderid', array('label'=>false,'type'=>'hidden','id'=>'folderid','value'=>'10')); ?>
  <script type="text/javascript">
  jQuery(document).ready(function(){
  var btnUpload=jQuery('#fileuploader');
        var status=jQuery('#status_message');
	           var tArr;

        new AjaxUpload(btnUpload, {
            action: 'uploader',
            name: 'uploadfile',
	    data: {
			ov_r	:(jQuery('#ovrtv').attr('checked'))?1:0,
			ov_d	:(jQuery('#ovrtd').attr('checked'))?1:0
		},
            onSubmit: function(file, ext){
                 if (! (ext && /^(doc|txt|docx|fmv|xls|dmp|xlx|pdf|zip|rar|jpg|png|jpeg|gif)$/.test(ext))){
                    // extension is not allowed
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');//alert(response);
            },
            onComplete: function(file, response){
		 //On completion clear the status
                status.text('');
                //Add uploaded file to list
                if(response==="success"){
		status.text('Wait few second..');
		window.location=window.location;
                } else if(response==="error"){
				alert('dd');
                    //$('<li></li>').appendTo('#files_list').text(file).addClass('error');
                }
		
            }
        });
              });
</script>