<?php foreach($showDet as $rec);?>             
<h3 class="heading_a uk-margin-small-bottom"><u>Request Details</u> </h3>
<div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Serial Number :</b> <?php echo $rec['BMRequestDetails']['serial_num'];?></label>

                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Request Reference Number :</b></label>
                            <span><?php echo $this->common->getReqRefNumByReqID($rec['BMRequestDetails']['request_id']);?></span>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>ID No. :</b></label>
                            <span><?php echo $rec['BMRequestDetails']['id_no'];?></span>
                        </div>
                    </div>
                    
    
                </div>
            
            
            <div  class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>P No. :</b></label>
                            <span><?php echo $rec['BMRequestDetails']['p_no'];?></span>
                        </div>
                    </div>
                <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Officer Name :</b></label>
                            <span><?php echo $this->common->getTitle($rec['BMRequestDetails']['title'])." ".$rec['BMRequestDetails']['firstname']." ".$rec['BMRequestDetails']['surname'];?></span>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Date of Birth :</b></label>
                            <span><?php echo date("d/m/Y", strtotime($rec['BMRequestDetails']['dob']));?></span>

                        </div>
                    </div>
                </div>
                

                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Gender  :</b></label>
                            <span><?php if($rec['BMRequestDetails']['gender'] == "0"){ echo "Male"; }else{ echo "Female";} ?></span>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Data Entry Type :</b></label>
                            <span><?php echo $this->common->getDataEntryTypebyID($rec['BMRequestDetails']['data_entry_type']);?></span>
                              
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Physical Disability :</b></label>
                            <span>
                                <?php if($rec['BMRequestDetails']['physical_disability'] == "0"){
                                        echo "Yes"; ?>
                                <br><label for="subject"><b>Disability Details :</b></label>
                                        <span>
                                            <?php  $str = $rec['BMRequestDetails']['disable_details'];
                                                   echo wordwrap($str,29,"<br>\n");
                                            ?>
                               <?php }else{ 
                                    echo "No";
                                }
                                ?></span>

                        </div>
                    </div>

                    
                    
    
                </div>
                <?php if($rec['BMRequestDetails']['data_entry_type'] == "1"){?>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Academic :</b></label>
                            <span>
                                <?php  $str = $rec['BMRequestDetails']['academic'];
                                        echo wordwrap($str,29,"<br>\n");
                                    ?>
                            </span>
                            
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Professional  :</b></label>
                            <span>
                                    <?php  $str = $rec['BMRequestDetails']['professional'];
                                        echo wordwrap($str,29,"<br>\n");
                                    ?>
                            </span>

                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Experience :</b></label>
                            <span>
                                     <?php  $str = $rec['BMRequestDetails']['experience'];
                                        echo wordwrap($str,29,"<br>\n");
                                    ?>
                            </span>
                              
                        </div>
                    </div>
    
                </div>
                <?php } ?>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Ministry :</b></label>
                            <span>
                                <?php echo $this->common->getMinistryByID($rec['BMRequestDetails']['ministry_id']);?>
                                
                            </span>

                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Department :</b></label>
                            <span>
                                <?php echo $this->common->getdepartmentbyid($rec['BMRequestDetails']['department_code']);?>
                            </span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Data of First Appointment :</b></label>
                            <span><?php echo date("d/m/Y", strtotime($rec['BMRequestDetails']['d_o_appointment']));?></span>

                        </div>
                    </div>

                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Data of Current Appointment :</b></label>
                            <span><?php echo date("d/m/Y", strtotime($rec['BMRequestDetails']['d_o_c_appointment']));?></span>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Current Designation :</b></label>
                            <span><?php echo $this->Common->getDesignationNameByID($rec['BMRequestDetails']['currenct_designation']);?></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Recommended Designation :</b></label>
                            <span><?php echo $this->Common->getDesignationNameByID($rec['BMRequestDetails']['recommended_designation']);?></span>

                        </div>
                    </div>

                   

                    
    
                </div>
<div  class="uk-grid" data-uk-grid-margin>
 <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Recommended Term of Services :</b></label>
                            <span><?php  $str = $rec['BMRequestDetails']['recomm_term_services'];
                                        echo wordwrap($str,29,"<br>\n");
                                    ?>
                            </span>

                        </div>
                    </div>
<div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Justification :</b></label>
                             <span><?php  $str = $rec['BMRequestDetails']['justification'];
                                        echo wordwrap($str,29,"<br>\n");
                                    ?>
                            </span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject"><b>Notes :</b></label>
                            <span><?php  $str = $rec['BMRequestDetails']['notes'];
                                        echo wordwrap($str,29,"<br>\n");
                                    ?>
                            </span>
                        </div>
                    </div>
</div>
                
                
            
            