<div id="invoice_preview">
    <div class="md-card-toolbar">
        <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
            Member Response
        </h3>
    </div>
</div>       
<hr class="uk-grid-divider">
<div data-uk-grid-margin="" class="uk-grid">
    <div class="uk-width-medium-1-2 uk-row-first">
        <div class="md-card-content">        
            <div data-uk-grid-margin="" class="uk-grid">
                <?php echo $this->form->create('mom', array('url' => '', 'method' => 'post', 'action' => 'responseSave','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked')))); ?>
                <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row">                                
                                <?php   echo $this->form->input('response', array('class' => "md-input",'label' => 'Please give your Remarks Response:', 'type' => 'textarea', 'id' => 'mremark',"cols"=> 60, "rows" => 8, "data-parsley-trigger"=>"keyup", "data-parsley-minlength" => "20", "data-parsley-maxlength" => "100", "data-parsley-validation-threshold" => "10", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment.." ,'required' => TRUE)); ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <?php echo $this->form->input('mid', array('class' => "md-input",'label' => false, 'value' => $meetingID, 'type' => 'hidden', 'id' => 'tid'));?>
                            <?php echo $this->form->input('empMeeting', array('class' => "md-input",'label' => false, 'value' => $empMeeting, 'type' => 'hidden', 'id' => 'empMeeting'));?>
                            <input type="submit" name="sendResponse" id="sendResponse" value="Send" class="md-btn md-btn-primary" />
                            <input type="reset" name="reset" id="reset" value="Clear" class="md-btn md-btn-danger" />
                        </div>
                    </div>
                </form>                             
            </div>
        </div>
    </div>
    
    <div class="uk-width-medium-1-2">
        <h2 class="uk-text-success heading_a">Previous Member Response List: </h2>
        <div class="uk-overflow-container">
        <ul class="md-list md-list-addon md-list-left">
            <?php
            //echo "<pre>";
            //print_r($empResponse); 
            //die;
            for ($i = 0; $i < count($empResponse); $i++) {
                ?>
                <li>
                    <div class="md-list-addon-element">
                        <?php
                        if ($empResponse[$i]['Name']['image'] != NULL) {
                            $userImage = "uploads/profile/" . $empResponse[$i]['Name']['image'];
                        } else {
                            $userImage = "images/no_image.png";
                        }
                        $resDateTime = explode(" ",$empResponse[$i]['MomEmpResponse']['response_datetime']);
                        $resDate = date("d-m-Y",strtotime($resDateTime[0]));
                        $resTime = date("h-i-s",strtotime($resDateTime[1]));
                        
                        ?>
                        <img alt="" src="<?php echo $this->webroot; ?><?php echo $userImage; ?>" class="md-user-image md-list-addon-avatar">
                    </div>
                    <div class="md-list-content">
                        <span class="md-list-heading"><?php echo $empResponse[$i]['Name']['emp_firstname']. " " . $empResponse[$i]['Name']['emp_lastname']; ?></span>
                        <span class="uk-text-small uk-text-muted"><i class="md-list-addon-icon material-icons">school</i> <?php echo $this->Common->findDesignationName($empResponse[$i]['Name']['desg_code'], $empResponse[$i]['Name']['comp_code']); ?> | <span class="uk-text-small uk-text-danger"><i class="md-list-addon-icon material-icons">access_time</i> <?php echo $resDate." ".$resTime;?></span></span>
                        <span class="uk-text-small uk-text-muted"><?php echo ucfirst($empResponse[$i]['MomEmpResponse']['response']);?></span>
                    </div>
                </li>       
            <?php } ?> 
        </ul>
        </div>
    </div>
</div>




