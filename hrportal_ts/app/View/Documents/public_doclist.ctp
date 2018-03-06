<script>
    function remarkDisable(fileid) {
        var remark = jQuery("#remark_" + fileid).val();
        if (remark == "") {
            remark = 'NA';
        }
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/fileremark/' + remark + '/' + fileid,
            success: function (data) {
                location.reload();
            }
        });

    }

    function fileDownload(fileid) {

        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/download/' + fileid,
            success: function (data) {
            }
        });

    }
</script>   
<script type="text/javascript">
    $(function () {
	
       
        $(".btnShow").click(function () {
		 var fileName = $(this).data("file");
    
        $("#dialog").dialog({
                modal: true,
                title: fileName,
                width: 800,
                height: 550,
                buttons: {
                    Close: function () {
                        $(this).dialog('close');
                    }
                },
				
                open: function () {
                    var object = "<object data=\"{FileName}\"  width=\"800px\" height=\"400px\">";
                    object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                    
                    object += "</object>";
                    object = object.replace(/{FileName}/g, "" + fileName);
                    
                    $("#dialog").html(object);
                }
            });
        });
    });
     function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>Documents/doc_upload/"+val; 

 }
</script>

<div id="dialog" style="display: none">
</div>

<div id="page_content">
    <div id="page_content_inner">
        <?php echo $this->Session->flash();?>
        <div class="md-card">
            <div class="md-card-toolbar">
                <div class="md-card-toolbar-actions">
                </div>
                <h3 class="md-card-toolbar-heading-text">
                    <b> Public Documents</b>
                </h3>
            </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">So. No.</th>
                                <th>File Name</th>
                                <th>Date of Release</th>
                                <th>Access the file</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php $i='1';
                              foreach($doclist as $rec){ ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i ;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['Documentlist']['document_name'];?></span></td>
                                <td>
                                <?php echo date("d/m/Y", strtotime($rec['Documentlist']['created_date']));?>
                                </td>
                                <?php 
                                if($rec['Documentlist']['restricted_access']=='0') { ?>
                                <?php 
                $filename=$rec['Documentlist']['file'];
                $extension=explode(".",$filename);
                $ext=$extension[1];
                if(!( $ext == 'doc' || $ext == 'docx' || $ext=='xls')) {
                ?>
                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"> <input data-file="<?php echo $this->Html->url('/uploads/document/'.$rec['Documentlist']['file']);?>" class="btnShow" type="button" value="View" /></a> 
                </span></td>
            <?php } else { ?>
                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">  <a class="uk-badge uk-Primary-Primary" href="<?php echo $this->webroot.'uploads/document/'.$rec['Documentlist']['file']; ?>" target="_blank">Download</a> 
                </span></td>
            <?php } ?>
                                <?php } else { ?>
                <td>Restricted (Available on Request)</td>   
                                <?php } ?>
            </tr>
            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="uk-width-large-1-1">
    <div id="modal_overflow_response" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-small">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>




