<script>
    function remarkDisable(fileid){
        var remark=jQuery("#remark_"+fileid).val();
        if(remark==""){
            remark='NA';
        }
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/fileremark/' + remark +'/'+ fileid,
            //data:'project_id='+val,
            success: function (data) {
                location.reload(); 
            }
        });
      
 }
  
  function fileDownload(fileid){
        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/download/' + fileid,
            //data:'project_id='+val,
            success: function (data) {
                //location.reload(); 
            }
        });
      
 }
</script>   

<div id="page_content">
    <div id="page_heading" >

        <h1>Public Documents</h1>
        <span class="uk-text-upper uk-text-small">
            <?php /* foreach($bredcrum as $breC ){?>
            <a href="<?php echo $this->Html->url('currentfolder/'.$breC['Category']['id']); ?>"> <?php echo $breC ['Category']['name'];?></a>/  
            <?php } */?>
        </span>
    </div>

    <div id="page_content_inner">
        <?php echo $this->Session->flash();?>
        <div class="md-card">
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
                             <?php 

                             $i='1';
                              foreach($publicFile as $rec){
                                  ?>
                                  <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i ;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['Category']['file_alias_name'];?></span></td>
                                <td>
                                <?php echo date("d/m/Y", strtotime($rec['Category']['created_date']));?>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a href="<?php echo $this->Html->url('download/'.$rec['Category']['id']);?>" target="_blank">Download</a>  
                                    </span>
                                </td>
                             </tr>
                              <?php    
                                $i++;
                              }
                            ?>

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
    
    
    
   