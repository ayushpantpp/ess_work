
<div id="invoice_preview">
    <div class="md-card-toolbar">
             <?php echo $flash = $this->Session->flash();?>
        <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
            Ticket Number : Ticket-<?php echo $comment_dtl['HelpDesk']['ticket_id'];?>
        </h3>
    </div>
</div>       
<hr class="uk-grid-divider">

<div data-uk-grid-margin="" class="uk-grid">
    <div class="uk-width-medium-2-3 uk-row-first">
        <div class="md-card-content">
            <div class="uk-margin-medium-bottom">
                <span class="uk-text-muted uk-text-small uk-text-italic">Ticket Type:</span> <?php echo ucfirst($comment_dtl['HelpDesk']['ticket_type']);?>
                <br>
                <span class="uk-text-muted uk-text-small uk-text-italic">Created Date:</span> <?php echo date("d-m-Y",  strtotime($comment_dtl['HelpDesk']['complaint_date']));?>
                <br>
            </div>
            <div class="">
                <div data-uk-grid-margin="" class="uk-grid">
                    <div class="uk-width-medium-1-1 uk-row-first">
                        <div class="margin-bottom-none">
                            <h2 class="heading_a">Remark</h2>
                            <p><input type="text" class = "md-input" value = "<?php echo $comment_dtl['HelpDesk']['remark'];?> " readonly="readonly"</p>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-1 uk-row-first">
                        <div class="margin-bottom-none">                        
                            <h2 class="heading_a">Responsibility</h2>
                            <p><?php echo ucfirst($this->Common->findEmpName($comment_dtl['HelpDesk']['assign_to']));?></p>
                        </div>
                    </div> 

                </div>
            </div>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <h2 class="uk-text-warning heading_a">Previous Comments: </h2>
        <ul class="md-list md-list-addon md-list-left">
            <li ><textarea class = "md-input" id="comment_box" name ="comment_box" style="display:block" placeholder="Add Comment "></textarea> </li>
            <li><button type="button" class="md-btn md-btn-success uk-modal-close" id ="add_comment" onClick="return add_c(this.value);" value="<?php echo $comment_dtl['HelpDesk']['id']; ?>" >Add Comment</button></li>
    <?php 
        foreach($comments as $emp){
                ?>
            <li>
                <div class="md-list-addon-element">
                            <?php if($this->Common->findEmpImage($emp['HelpDeskDtl']['commenter_id']) != NULL){
                                $userImage = "uploads/profile/".$this->Common->findEmpImage($emp['HelpDeskDtl']['commenter_id']);
                            }else{
                                $userImage = "images/no_image.png";
                            }?>
                    <img alt="" src="<?php echo $this->webroot;?><?php echo $userImage; ?>" class="md-user-image md-list-addon-avatar">

                </div>
                <div class="md-list-content">
                    <span class="md-list-heading"><?php echo $emp['HelpDeskDtl']['comment'];?></span>
                    <span class="uk-text-small uk-text-muted"><?php  echo "By - ".$this->Common->findEmpName($emp['HelpDeskDtl']['commenter_id']);?></span>
                </div>
            </li>        
                <?php } ?> 
        </ul>
    </div>

</div>


<script type="text/javascript">

    function add_c(val) {
        var comment = $('#comment_box').val();
        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>HelpDesks/add_comment/' + val + '/' + comment,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);

            }
        });
    }
</script>  


