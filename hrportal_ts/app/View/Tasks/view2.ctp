<?php ?>
<div id="invoice_preview">
        <div class="md-card-toolbar">
            <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
               Task ID : PSC-Task-<?php echo $sr[0]['TaskAssign']['tid'];?>
            </h3>
        </div>
 </div>       
    <hr class="uk-grid-divider">
    
    <div data-uk-grid-margin="" class="uk-grid">
        <div class="uk-width-medium-2-3 uk-row-first">
            <div class="md-card-content">
            <div class="uk-margin-medium-bottom">
                <span class="uk-text-muted uk-text-small uk-text-italic">Task Name:</span> <?php echo ucfirst($sr[0]['TaskAssign']['tname']);?>
                <br>
                <span class="uk-text-muted uk-text-small uk-text-italic">Start Date:</span> <?php echo date("d-m-Y",  strtotime($sr[0]['TaskAssign']['starttime']));?>
                <br>
                <span class="uk-text-muted uk-text-small uk-text-italic">End Date:</span> <?php echo date("d-m-Y",  strtotime($sr[0]['TaskAssign']['endtime']))." ". $ar[0]['MomAssign']['meeting_time'];?>
            </div>
            <div class="">
            <div data-uk-grid-margin="" class="uk-grid">
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="margin-bottom-none">
                        <h2 class="heading_a">Remark</h2>
                        <p><?php echo $sr[0]['TaskAssign']['remark'];?></p>
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
                                        <?php
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '0') {
                                                        $per = 0;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '1') {
                                                        $per = 0;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '2') {
                                                        $per = 10;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '3') {
                                                        $per = 30;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '4') {
                                                        $per = 50;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '5') {
                                                        $per = 80;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '6') {
                                                        $per = 100;
                                                    }
                                                    if ($emp[$i]['Taskassignemp']['cstatus'] == '7') {
                                                        $per = 100;
                                                    }
                                                    
                                                    ?>
                            <span class="uk-text-small uk-text-muted"><div class="uk-progress">
                                            <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"><?php echo $per; ?>%</div>
                                        </div></span>
                                 
                        </div>
                    </li>        
                <?php } ?> 
                            </ul>
                        </div>
                    </div>


            
       
            