<div id="invoice_preview">
        <div class="md-card-toolbar">
            <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
                Meeting Number : PSC-MOM-<?php echo $ar[0]['MomAssign']['mid'];?>
            </h3>
        </div>
 </div>       
    <hr class="uk-grid-divider">
    
    <div data-uk-grid-margin="" class="uk-grid">
        <div class="uk-width-medium-2-3 uk-row-first">
            <div class="md-card-content">
            <div class="uk-margin-medium-bottom">
                <span class="uk-text-muted uk-text-small uk-text-italic">Subject:</span> <?php echo ucfirst($ar[0]['MomAssign']['subject']);?>
                <br>
                <span class="uk-text-muted uk-text-small uk-text-italic">Created Date:</span> <?php echo date("d-m-Y",  strtotime($ar[0]['MomAssign']['post_on']));?>
                <br>
                <span class="uk-text-muted uk-text-small uk-text-italic">Meeting Date and Time:</span> <?php echo date("d-m-Y",  strtotime($ar[0]['MomAssign']['meeting_date']))." ". $ar[0]['MomAssign']['meeting_time'];?>
            </div>
            <div class="">
            <div data-uk-grid-margin="" class="uk-grid">
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="margin-bottom-none">
                        <h2 class="heading_a">Remark</h2>
                        <p><?php echo $ar[0]['MomAssign']['remark'];?></p>
                    </div>
                </div>
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="margin-bottom-none">                        
                        <h2 class="heading_a">Description</h2>
                        <blockquote><p class="uk-text-primary"><?php echo ucfirst($ar[0]['MomAssign']['description']);?></p></blockquote>
                    </div>
                </div>
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="margin-bottom-none">                        
                        <h2 class="heading_a">Responsibility</h2>
                        <p><?php echo ucfirst($ar[0]['MomAssign']['responsibility']);?></p>
                    </div>
                </div> 
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="margin-bottom-none">                        
                        <h2 class="heading_a margin-bottom-none">Minutes Remarks</h2>
                        <p><?php echo ucfirst($ar[0]['MomAssign']['mremark']);?></p>
                    </div>
                </div>                
            </div>
            </div>
        </div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <h2 class="uk-text-warning heading_a">Member List: </h2>
                            <ul class="md-list md-list-addon md-list-left">
                                <?php 
//                echo "<pre>";
//                print_r($emp); 
                //die;
                for($i=0;$i<count($emp);$i++)
                      {
                ?>
                <li>
                        <div class="md-list-addon-element">
                            <?php if($emp[$i]['Name']['image'] != NULL){
                                $userImage = "uploads/profile/".$emp[$i]['Name']['image'];
                            }else{
                                $userImage = "images/no_image.png";
                            }?>
                            <img alt="" src="<?php echo $this->webroot;?><?php echo $userImage;?>" class="md-user-image md-list-addon-avatar">
                        </div>
                        <div class="md-list-content">
                            <span class="md-list-heading"><?php echo $emp[$i]['Name']['emp_firstname']." ".$emp[$i]['Name']['emp_lastname'];?></span>
                            <span class="uk-text-small uk-text-muted"><?php echo $this->Common->findDesignationName($emp[$i]['Name']['desg_code'],$emp[$i]['Name']['comp_code']); ?></span>
                        </div>
                    </li>        
                <?php } ?> 
                            </ul>
                        </div>
                    </div>


            