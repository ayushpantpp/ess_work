<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="clearfix"></div>
        <div id="alerts"></div>
        <div id="user_profile" data-uk-grid-match="" data-uk-grid-margin="" class="uk-grid">
            <div class="uk-width-large-7-10 uk-row-first" style="min-height: 1623px;">                    
                <div class="md-card">
                    <div class="user_heading">
                        <div data-uk-dropdown="{pos:'left-top'}" class="user_heading_menu">
                            <i class="md-icon material-icons md-icon-light"></i>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a href="<?php echo $this->webroot; ?>users/changepass">Change Password</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="user_heading_avatar">
                            <div class="thumbnail">
                                <?php if (!empty($profile['MyProfile']['image'])) { ?>
                                    <img style="vertical-align: middle;" src="<?php echo $this->webroot . 'uploads/profile/' . $profile['MyProfile']['image']; ?>" alt="User Image" />
                                    <?php } else { $genderName = $this->Common->findGenderName($profile['MyProfile']['gender']);
                                    if ($genderName == "MALE") { $genderImage = "male_82X82.jpg";} else { $genderImage = "female_82X82.jpg";} ?>
                                    <img src="<?php echo $this->webroot . "images/$genderImage"; ?>"  alt="User Imagess" /> <?php } ?>
                            </div>
                        </div>
                        <div class="user_heading_content">
                            <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?php echo $profile['MyProfile']['emp_name']; ?></span><span class="sub-heading"><?php echo ucfirst(strtolower($this->Common->findDesignationName($profile['MyProfile']['desg_code'], $profile['MyProfile']['comp_code']))); ?></span></h2>
                            <ul class="user_stats">
                                <li>
                                    <span class="sub-heading">Employee ID</span><h4 class="heading_c"><?php echo $profile['MyProfile']['emp_id']; ?> </h4>
                                </li>
                                <li>
                                    <span class="sub-heading">Email ID</span><h4 class="heading_c"><?php echo $detail['UserDetail']['email']; ?></h4>
                                </li>
                            </ul>
                        </div>                            
                        <a data-uk-modal="{target:'#modal_overflow'}" class="md-fab md-fab-small md-fab-accent" alt="Update Profile Picture" title="Update Profile Picture">
                            <i class="material-icons">camera_alt</i>
                        </a>                            
                    </div>
                    <div class="user_content">
                        <div class="uk-sticky-placeholder" style="height: 46px;">
                            <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
<?php 

if ($block['2']['LabelBlock']['block_status'] == 1) { ?>
                                    <li class="uk-active">
                                        <a href="#"><?php Configure::write('I18n.preferApp', true);
    echo __d('debug_kit', $block['2']['LabelBlock']['block_heading']);
    ?>
                                        </a>
                                    </li>
                                        <?php } if ($block['3']['LabelBlock']['block_status'] == 1) { ?>
                                    <li aria-expanded="false"><a href="#"><?php
                                        Configure::write('I18n.preferApp', true);
                                        echo __d('debug_kit', $block['3']['LabelBlock']['block_heading']);
                                            ?>    
                                        </a>
                                    </li>
                                        <?php } else { ?> 
                                    <li aria-expanded="false"><a href="#"><?php
                                        Configure::write('I18n.preferApp', true);
                                        echo __d('debug_kit', $block['3']['LabelBlock']['block_heading']);
                                        ?>    
                                        </a>
                                    </li>
<?php } if ($block['4']['LabelBlock']['block_status'] == 1) { ?>
                                    <li aria-expanded="false"><a href="#"><?php
                                    Configure::write('I18n.preferApp', true);
                                    echo __d('debug_kit', $block['4']['LabelBlock']['block_heading']);
                                    ?>    
                                        </a>
                                    </li>
                                <?php } if ($block['5']['LabelBlock']['block_status'] == 1) { ?>
                                    <li aria-expanded="false"><a href="#"><?php
                                    Configure::write('I18n.preferApp', true);
                                    echo __d('debug_kit', $block['5']['LabelBlock']['block_heading']);
                                    ?>    
                                        </a>
                                    </li>
<?php } ?>  
                                <li aria-expanded="false"><a href="#"><?php echo "Upload Document" ?></a></li>
                                <?php if ($block['6']['LabelBlock']['block_status'] == 1) { ?>
                                    <li aria-expanded="false"><a href="#"><?php
                                            Configure::write('I18n.preferApp', true);
                                            echo __d('debug_kit', $block['6']['LabelBlock']['block_heading']);
                                            ?>    
                                        </a>
                                    </li>
                                <?php } if ($block['7']['LabelBlock']['block_status'] == 1) { ?>
                                    <li aria-expanded="false"><a href="#"><?php
                                            Configure::write('I18n.preferApp', true);
                                            echo __d('debug_kit', $block['7']['LabelBlock']['block_heading']);
                                            ?>    
                                        </a>
                                    </li>
<?php } ?> 
<?php if ($block['8']['LabelBlock']['block_status'] == 1) { ?>
                                    <li aria-expanded="false"><a href="#"><?php
                                Configure::write('I18n.preferApp', true);
                                echo __d('debug_kit', $block['8']['LabelBlock']['block_heading']);
                                ?>    
                                        </a>
                                    </li>
<?php } ?>
                            </ul>                                
                        </div>
                        <ul class="uk-switcher uk-margin" id="user_profile_tabs_content">                                
                                                <?php
                                                if ($block['2']['LabelBlock']['block_status'] == 1) {
                                                    $personal_labels = $this->Common->block_labels($block['2']['LabelBlock']['id']);

                                                    ?>
                                <li aria-hidden="false" class="uk-active">
                                    <div class="md-card" data-uk-sticky="{ top: 48, media: 960 }">
                                        <div class="md-card-content large-padding">                                           
                                            <form id="form_validation" data-parsley-validate class="uk-form-stacked" method="POST" action="updatePersonalInfo" >
                                                <div class="uk-grid" data-uk-grid-margin>
                                                            <?php if ($personal_labels['0']['Labels']['label_status'] == 1) { ?>
                                                        <div class="uk-width-medium-1-2">                                                        
                                                            <div class="parsley-row">
                                                                <label for="fullname">
                                                                <?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit', $personal_labels['0']['Labels']['name']);
                                                                ?>
                                                                    <span class="req">*</span>
                                                                </label>
                                                                <?php if ($personal_labels['0']['Labels']['type'] == 'text') { ?>
                                                                    <?php
                                                                    $v = $this->Common->option_attribute_name($profile['MyProfile']['gender']);
                                                                    $options = $this->Common->option_name($profile['MyProfile']['emp_nm_ttl']);
                                                                    ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['0']['Labels']['css_name']; ?>" id="Title" required class="md-input" readonly="readonly" value="<?php echo $options[$profile['MyProfile']['emp_nm_ttl']] . $profile['MyProfile']['emp_name']; ?>">  
                                                                    <?php
                                                                } else if ($personal_labels['0']['Labels']['type'] == 'text') {
                                                                    $options = $this->Common->option_attribute($personal_labels['0']['Labels']['options_id']);
                                                                    $v = $this->Common->option_attribute_name($profile['MyProfile']['gender']);
                                                                    ?>                                                  

                                                                    <select class="md-input" name="<?php $personal_labels['0']['Labels']['css_name'] ?>">
            <?php foreach ($options as $key => $val) { ?> 
                                                                            <option <?php if ($v['gender'] == $val) echo 'selected'; ?> value="<?php echo $key ?>"><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                    <?php
                                                                } else if ($personal_labels['0']['Labels']['type'] == 'radio') {
                                                                    $options = $this->Common->option_attribute($personal_labels['0']['Labels']['options_id']);
                                                                    foreach ($options as $key => $val) {
                                                                        ?> 
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" value="<?php echo $key ?>" name="<?php $personal_labels['0']['Labels']['css_name'] ?>" id="val_radio_male" data-md-icheck required />
                                                                            <label for="val_radio_male" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
            <?php
            }
        } else {
            
        }
        ?>
                                                            </div>
                                                        </div>
                                                            <?php } ?>
                                                            <?php if ($personal_labels['1']['Labels']['label_status'] == 1) { ?>
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row">
                                                                <label for="email" class="uk-form-label"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit', $personal_labels['1']['Labels']['name']);
                                                                ?><span class="req">*</span>
                                                                </label>
                                                                    <?php
                                                                    $genderName = $this->Common->findGenderName($profile['MyProfile']['gender']);
                                                                    ?>
                                                                <input type="text" value="<?php echo $genderName; ?>" readonly="readonly" class="md-input" required="" id="gender" name="gender" data-parsley-id="4"><span class="md-input-bar"></span>
                                                                <?php if ($personal_labels['1']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['1']['Labels']['css_name'] ?>" id="Title" required class="md-input" readonly="readonly" value="" placeholder="<?php echo $personal_labels['1']['Labels']['name'] ?>">  
                                                                    <?php
                                                                } else if ($personal_labels['1']['Labels']['type'] == 'select') {
                                                                    $options = $this->Common->option_attribute($personal_labels['1']['Labels']['options_id']);
                                                                    ?>
                                                                    <select class="md-input" name="<?php echo $personal_labels['1']['Labels']['css_name'] ?>">
                                                                        <?php foreach ($options as $key => $val) { ?>   
                                                                            <option><?php echo $val; ?></option>
                                                                        <?php } ?>
                                                                    </select>
            <?php
        } else if ($personal_labels['1']['Labels']['type'] == 'radio') {
            $options = $this->Common->option_attribute($personal_labels['1']['Labels']['options_id']);

            foreach ($options as $key => $val) {
                ?> 
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" <?php
                                                                        if ($profile['MyProfile']['gender'] == $key) {
                                                                            echo 'checked';
                                                                        } else {
                                                                            echo "disabled";
                                                                        }
                                                                        ?> value="<?php echo $key ?>" name="<?php $personal_labels['0']['Labels']['css_name'] ?>" id="val_radio_male" data-md-icheck required />

                                                                            <label for="val_radio_male" class="inline-label"><?php echo $val ?></label>
                                                                        </span>                                                           

            <?php } ?>                                 

                                                                    <?php
                                                                    } else {
                                                                        
                                                                    }
                                                                }
                                                                ?>


                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="uk-grid" data-uk-grid-margin>
                                                                <?php if ($personal_labels['2']['Labels']['label_status'] == 1) { ?>
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row uk-margin-top">
                                                                <label for="val_birth"><?php
                                                                    Configure::write('I18n.preferApp', true);
                                                                    echo __d('debug_kit', $personal_labels['2']['Labels']['name']);
                                                                    ?><span class="req">*</span></label>




                                                                    <?php if ($personal_labels['2']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['2']['Labels']['css_name'] ?>" id="DoB" required class="md-input" readonly="readonly" value="<?php echo date("d-m-Y", strtotime($profile['MyProfile']['dob'])); ?>" placeholder="<?php echo $personal_labels['1']['Labels']['name'] ?>">  
                                                                        <?php
                                                                    } else if ($personal_labels['2']['Labels']['type'] == 'select') {
                                                                        $options = $this->Common->option_attribute($personal_labels['1']['Labels']['options_id']);
                                                                        ?>
                                                                    <select class="md-input" name="<?php $personal_labels['2']['Labels']['css_name'] ?>">
                                                                    <?php foreach ($options as $key => $val) { ?>   
                                                                            <option value="<?php echo $key ?>"><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                    <?php
                                                                } else if ($personal_labels['2']['Labels']['type'] == 'radio') {
                                                                    $options = $this->Common->option_attribute($personal_labels['2']['Labels']['options_id']);
                                                                    foreach ($options as $key => $val) {
                                                                        ?>                                                            
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" <?php
                                                if ($profile['MyProfile']['gender'] == $key) {
                                                    echo 'checked';
                                                } else {
                                                    echo "disabled";
                                                }
                                                ?> value="<?php echo $key ?>" name="<?php $personal_labels['0']['Labels']['css_name'] ?>" id="val_radio_male" data-md-icheck required />
                                                                            <label for="val_radio_male" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
                                                                    <?php } ?>     

                                                                <?php } else {
                                                                    
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                                <?php } ?>
                                                            <?php if ($personal_labels['3']['Labels']['label_status'] == 1) { ?>
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="uk-form-row parsley-row">
                                                                <label for="gender" class="uk-form-label"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit', $personal_labels['3']['Labels']['name']);
                                                                ?><span class="req">*</span>
                                                                </label>



        <?php if ($personal_labels['3']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['3']['Labels']['css_name'] ?>" id="Title" required class="md-input" placeholder="<?php echo $personal_labels['4']['Labels']['name'] ?>">  
                                                                    <?php
                                                                } else if ($personal_labels['1']['Labels']['type'] == 'select') {
                                                                    $options = $this->Common->option_attribute($personal_labels['3']['Labels']['options_id']);
                                                                    ?>
                                                                    <select class="md-input" name="<?php $personal_labels['3']['Labels']['css_name'] ?>">
            <?php foreach ($options as $key => $val) { ?>   
                                                                            <option value="<?php echo $key ?>"><?php echo $val; ?></option>
            <?php } ?>
                                                                    </select>
                                                            <?php
                                                        } else if ($personal_labels['3']['Labels']['type'] == 'radio') {
                                                            if ($profile['MyProfile']['marital_code'] == '80') {
                                                                $mStatus = "Single";
                                                            } else if ($profile['MyProfile']['marital_code'] == '81') {
                                                                $mStatus = "Married";
                                                            } else if ($profile['MyProfile']['marital_code'] == '82') {
                                                                $mStatus = "Divorced";
                                                            }
                                                            ?>
                                                                    <span class="icheck-inline">                                                          <input type="text" value="<?= $mStatus ?>" readonly="readonly" class="md-input" required="" id="status" name="status" data-parsley-id="4"><span class="md-input-bar"></span>      

                                                                    </span>
                                                                <?php } ?></div>
                                                        </div>
                                                            <?php } ?>                                                    
                                                </div>                                


                                                <div class="uk-grid" data-uk-grid-margin>

    <?php if ($personal_labels['4']['Labels']['label_status'] == 1) { ?> 
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row">
                                                                <label for="masked_date">

                                                                <?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit', $personal_labels['4']['Labels']['name']);
                                                                ?></label>


                                                                <?php
                                                                if ($personal_labels['4']['Labels']['type'] == 'text') {

                                                                    if ($profile['MyProfile']['wedding_date'] == "0000-00-00") {
                                                                        $weddingDate = "";
                                                                    } elseif ($profile['MyProfile']['wedding_date'] != "") {
                                                                        $weddingDate = "value='" . date("d-m-Y", strtotime($profile['MyProfile']['wedding_date'])) . "'";
                                                                    } else {
                                                                        $weddingDate = "";
                                                                    }
                                                                    ?>

                                                                    <input id="masked_date" class="md-input masked_input" <?php echo $weddingDate; ?> name = "<?php echo $personal_labels['4']['Labels']['css_name'] ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-inputmask-showmaskonhover="false"  />

                                                                    <?php
                                                                } else if ($personal_labels['4']['Labels']['type'] == 'select') {
                                                                    $options = $this->Common->option_attribute($personal_labels['4']['Labels']['options_id']);
                                                                    ?>
                                                                    <select class="md-input" name="<?php $personal_labels['4']['Labels']['css_name'] ?>" data-md-selectize>
            <?php foreach ($options as $key => $val) { ?>   
                                                                            <option value="<?php echo $key ?>"><?php echo $val; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                        <?php
                                                                    } else if ($personal_labels['4']['Labels']['type'] == 'radio') {
                                                                        $options = $this->Common->option_attribute($personal_labels['4']['Labels']['options_id']);
                                                                        foreach ($options as $key => $val) {
                                                                            ?>                                                            
                                                                        <span class="icheck-inline">
                                                                            <input type="radio"  name="<?php echo $personal_labels['4']['Labels']['css_name'] ?>" value="<?php echo $val ?>"> 
                                                                            <label for="val_radio_male" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
                                                                        <?php } ?>   

                                                                <?php } else {
                                                                    
                                                                }
                                                                ?>                                 
                                                            </div>
                                                        </div>                                                      
    <?php } ?>
    <?php if ($personal_labels['5']['Labels']['label_status'] == 1) { ?> 
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row">
                                                                <label for="val_select" class="uk-form-label"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit', $personal_labels['5']['Labels']['name']);
                                                                ?>*</label>

        <?php if ($personal_labels['5']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['5']['Labels']['css_name'] ?>" id="pan_no" class="md-input" readonly="readonly" value="<?php echo $profile['MyProfile']['pan_no']; ?>">  
        <?php
        } else if ($personal_labels['5']['Labels']['type'] == 'select') {
            $options = $this->Common->option_attribute($personal_labels['5']['Labels']['options_id']);
            ?>
                                                                    <select class="md-input" name="<?php $personal_labels['5']['Labels']['css_name'] ?>" data-md-selectize>
                                                            <?php foreach ($options as $key => $val) { ?>   
                                                                            <option value="<?php echo $key ?>"><?php echo $val; ?></option>
            <?php } ?>
                                                                    </select>
                                                                        <?php
                                                                    } else if ($personal_labels['5']['Labels']['type'] == 'radio') {
                                                                        $options = $this->Common->option_attribute($personal_labels['5']['Labels']['options_id']);
                                                                        foreach ($options as $key => $val) {
                                                                            ?>
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" name="<?php echo $personal_labels['5']['Labels']['css_name'] ?>" value="<?php echo $val ?>" id="checkbox_demo_inline_3" data-md-icheck />
                                                                            <label for="checkbox_demo_inline_3" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        
                                                                    }
                                                                    ?>                                
                                                            </div>                                       
                                                        </div> 
                                                        <div class="uk-width-medium-1-2"style="display:none" >
                                                            <input id="EmpCode" class="md-input" type="text" name="id" value="<?php echo $profile['MyProfile']['id'] ?>" name="Citizenship" placeholder="Pan no">
                                                        </div>
    <?php } ?>                                                
                                                </div>                                                

                                                <div class="uk-grid" data-uk-grid-margin>
                                                            <?php if ($personal_labels['6']['Labels']['label_status'] == 1) { ?>
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row">
                                                                <label for="message"><?php
                                                        Configure::write('I18n.preferApp', true);
                                                        echo __d('debug_kit', $personal_labels['6']['Labels']['name']);
                                                        ?></label>
                                                        <?php if ($personal_labels['6']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['6']['Labels']['css_name'] ?>" id="Title" class="md-input"  value="<?php echo $profile['MyProfile']['guardian_name']; ?>" placeholder="<?php echo $personal_labels['6']['Labels']['name'] ?>">  
            <?php
        } else if ($personal_labels['6']['Labels']['type'] == 'select') {
            $options = $this->Common->option_attribute($personal_labels['6']['Labels']['options_id']);
            ?>
                                                                    <select class="md-input" name="<?php $personal_labels['6']['Labels']['css_name'] ?>" data-md-selectize>
                                                                    <?php foreach ($options as $key => $val) { ?>   
                                                                            <option value="<?php echo $key ?>"><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                    <?php
                                                                } else if ($personal_labels['6']['Labels']['type'] == 'radio') {
                                                                    $options = $this->Common->option_attribute($personal_labels['6']['Labels']['options_id']);
                                                                    foreach ($options as $key => $val) {
                                                                        ?>
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" name="<?php echo $personal_labels['6']['Labels']['css_name'] ?>" value="<?php echo $val ?>" id="radio_demo_inline_3" data-md-icheck />
                                                                            <label for="radio_demo_inline_3" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    
                                                                }
                                                                ?> 
                                                            </div>
                                                        </div>
                                                            <?php } ?>

                                                            <?php if ($personal_labels['7']['Labels']['label_status'] == 1) { ?>      
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row">
                                                                <label for="fullname"><?php
                                                        Configure::write('I18n.preferApp', true);
                                                        echo __d('debug_kit', $personal_labels['7']['Labels']['name']);
                                                        ?><span class="req">*</span></label>

        <?php if ($personal_labels['7']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['7']['Labels']['css_name'] ?>" id="Title" class="md-input"  value="<?php echo $profile['MyProfile']['guardian_relation']; ?>" placeholder="<?php echo $personal_labels['7']['Labels']['name'] ?>">  
                                                                        <?php
                                                                    } else if ($personal_labels['7']['Labels']['type'] == 'select') {
                                                                        $options = $this->Common->option_attribute($personal_labels['7']['Labels']['options_id']);
                                                                        ?>
                                                                    <select class="md-input" name="<?php $personal_labels['7']['Labels']['css_name'] ?>" data-md-selectize>
                                                                    <?php foreach ($options as $key => $val) { ?>   
                                                                            <option value="<?php echo $key ?>"><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                    <?php
                                                                } else if ($personal_labels['7']['Labels']['type'] == 'radio') {
                                                                    $options = $this->Common->option_attribute($personal_labels['7']['Labels']['options_id']);
                                                                    foreach ($options as $key => $val) {
                                                                        ?>
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" name="<?php echo $personal_labels['7']['Labels']['css_name'] ?>" value="<?php echo $val ?>" data-md-icheck />
                                                                            <label for="radio_demo_inline_3" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    
                                                                }
                                                                ?> 
                                                            </div>
                                                        </div>
    <?php } ?>                                                   
                                                </div>

                                                <div class="uk-grid" data-uk-grid-margin>
                                                            <?php if ($personal_labels['8']['Labels']['label_status'] == 1) { ?>
                                                        <div class="uk-width-medium-1-2">
                                                            <div class="parsley-row">
                                                                <label for="fullname"><?php
                                                        Configure::write('I18n.preferApp', true);
                                                        echo __d('debug_kit', $personal_labels['8']['Labels']['name']);
                                                        ?> <span class="req">*</span></label>

                                                            <?php if ($personal_labels['8']['Labels']['type'] == 'text') { ?>
                                                                    <input type="text" name = "<?php echo $personal_labels['8']['Labels']['css_name'] ?>" id="Title" required class="md-input"  value="" placeholder="<?php echo $personal_labels['8']['Labels']['name'] ?>">  
            <?php
        } else if ($personal_labels['8']['Labels']['type'] == 'select') {
            $options = $this->Common->option_attribute($personal_labels['8']['Labels']['options_id']);
            ?>
                                                          <!--  <select class="md-input" name="<?php echo $personal_labels['8']['Labels']['css_name'] ?>" data-md-selectize>
            <?php foreach ($options as $key => $val) { ?>   
                                                                        <option value="<?php echo $key ?>" <?php if ($profile['MyProfile']['blood_group'] == $key) echo 'selected'; ?>><?php echo $val; ?></option>
            <?php } ?>
                                                          </select>-->
                                        <?php if ($profile['MyProfile']['blood_group']) { ?>                              
                                                                        <input type="text" value=" <?php echo $this->Common->bloodGroup($profile['MyProfile']['blood_group'], $profile['MyProfile']['comp_code']); ?>" readonly="readonly" class="md-input" data-parsley-id="14"> 
                                        <?php } else { ?>
                                                                        <input type="text" value="N/A" readonly="readonly" class="md-input" data-parsley-id="14"> 
            <?php } ?>
            <?php
        } else if ($personal_labels['8']['Labels']['type'] == 'radio') {
            $options = $this->Common->option_attribute($personal_labels['8']['Labels']['options_id']);
            foreach ($options as $key => $val) {
                ?>
                                                                        <span class="icheck-inline">
                                                                            <input type="radio" name="<?php echo $personal_labels['8']['Labels']['css_name'] ?>" value="<?php echo $val ?>" data-md-icheck />
                                                                            <label for="radio_demo_inline_3" class="inline-label"><?php echo $val ?></label>
                                                                        </span>
            <?php
            }
        } else {
            
        }
        ?> 
                                                            </div>
                                                        </div>
                                                    <?php } ?>                                                    
                                                </div>                                                
                                                <div class="uk-grid">
                                                    <div class="uk-width-1-1">
    <?php if ($hideEditButton == "") { ?>
                                                            <button type="submit" class="md-btn md-btn-success">Submit</button>
                                                            <button type="reset" class="md-btn md-btn-primary">Cancel</button>
    <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>                               
<?php } ?>
                            <!-- Start Dependant Details Tab --> 
                                                            <?php if ($block['3']['LabelBlock']['block_status'] == 1) { ?>   

                                <li>                                    
                                    <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                        <div class="uk-width-large-1-2">
                                            <h4 class="heading_c uk-margin-small-bottom">Contact Info</h4>
                                            <table class="table table-striped responsive-utilities jambo_table bulk_action" id = "myTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">Member Name</th>
                                                        <th width="28%">Relation</th>
                                                        <th>Occupation</th>
                                                        <th>DOB</th>
                                                        <th>Gender</th>
                                                    <?php if ($dependents) { ?>
                                                            <th>Action</th> 
                                                    <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
    <?php if ($dependents) { ?>
        <?php $i = 1;
        foreach ($dependents as $dep) {
            ?>
            <?php if ($dep['DependentDetails']['status'] == 5) { ?>
                                                                <tr class="even pointer" id="row_1">

                                                                            <?php echo $this->Form->input("id.$i", array('id' => "id_$i", 'label' => false, 'type' => 'hidden', 'class' => 'required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['id'])); ?>

                                                                    <td><?php echo $this->Form->input("member.$i", array('id' => "member_$i", 'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['member_name'], 'onkeypress' => "changetext($i)")); ?>
                                                                    </td>
                                                                    <td><?php echo $this->Form->input("relation.$i", array('id' => "relation_$i", 'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['relation'], 'onkeypress' => "changetext($i)")); ?></td>
                                                                    <td><?php echo $this->Form->input("occupation.$i", array('id' => "occupation_$i", 'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['occupation'], 'onkeypress' => "changetext($i)")); ?></td>
                                                                    <td><?php echo $this->Form->input("dob.$i", array('id' => "dob_$i", 'readonly' => true, 'label' => false, 'class' => 'required dob', 'value' => '', 'value' => date('m/d/Y', strtotime($dep['DependentDetails']['Dob'])))); ?></td>
                <?php echo $this->Form->input("status.$i", array('id' => "status_$i", 'label' => false, 'class' => 'required dob', 'type' => 'hidden', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['status'])); ?>
                                                                    <td>
                                                                        <select class="md-input" name='gender.<?php echo $i; ?>'>
                                                                            <option <?php
                                                                if ($dep['DependentDetails']['gender'] == 'PAR0000061') {
                                                                    echo selected;
                                                                }
                                                                ?> value="PAR0000061">Male</option>
                                                                            <option <?php
                                                                if ($dep['DependentDetails']['gender'] == 'PAR0000062') {
                                                                    echo selected;
                                                                }
                                                                ?> value="PAR0000062">Female</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><a class="btn btn-danger btn-xs" href="<?php echo $this->webroot; ?>users/deleteDependent/<?php echo $dep['DependentDetails']['id']; ?>/" title="Click to Delete.">Delete</a>    </td>
                                                                </tr>
            <?php
            } else {
                $i = $i - 1;
            }
            ?>

            <?php
            $i++;
        }
    } else {
        ?>
                                                            <?php if ($dep['DependentDetails']['status'] == 5) { ?>
                                                            <tr id="row_1">
                                                                <td><?php echo $this->Form->input('member.1', array('id' => 'member_1', 'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['member_name'], 'Keypress' => bigImg($i))); ?>
                                                                </td>
                                                                <td><?php echo $this->Form->input('relation.1', array('id' => 'relation_1', 'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['relation'])); ?></td>
                                                                <td><?php echo $this->Form->input('occupation.1', array('id' => 'occupation_1', 'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '20', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['occupation'])); ?></td>
                                                                <td><?php echo $this->Form->input('dob.1', array('id' => 'dob_1', 'label' => false, 'class' => 'required dob', 'value' => '', 'autocomplete' => 'off', 'value' => $dep['DependentDetails']['Dob'])); ?></td>
                                                                <td>
                                                                    <select name='gender.1'>
                                                                        <option <?php
                                                    if ($dep['DependentDetails']['gender'] == 'PAR0000061') {
                                                        echo selected;
                                                    }
                                                                ?> value="PAR0000061">Male</option>
                                                                        <option <?php
                                                                if ($dep['DependentDetails']['gender'] == 'PAR0000062') {
                                                                    echo selected;
                                                                }
                                                                ?> value="PAR0000062">Female</option>
                                                                    </select>
                                                                </td>

                                                            </tr>
        <?php
        }
    }
    ?>   
                                                </tbody>
                                            </table>
                                        </div>                                        
                                    </div>
                                </li>
<?php } else { ?>
                                <li>                                    
                                    <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                        <div class="uk-width-large-1-1">
                                            <div class="uk-overflow-container uk-margin-bottom">
                                                <table class="uk-table uk-table-striped uk-text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th scope="row">Member Name</th>
                                                            <th width="28%">Relation</th>
                                                            <th>Occupation</th>
                                                            <th>Date of Birth</th>
                                                            <th>Gender</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
    <?php
    if ($dependents) {
        $i = 1;
        foreach ($dependents as $dep) {
            ?>
                                                                <tr id="row_1">
                                                                    <td><?php echo $dep['DependentDetails']['member_name']; ?></td>
                                                                    <td><?php echo $dep['DependentDetails']['relation']; ?></td>
                                                                    <td><?php echo $dep['DependentDetails']['occupation']; ?></td>
                                                                    <td><?php echo date('d-m-Y', strtotime($dep['DependentDetails']['Dob'])); ?></td>
                                                                    <td><?php $v = $this->Common->option_attribute_name($dep['DependentDetails']['gender']);
                                                        echo $v[$dep['DependentDetails']['gender']];
                                                        ?></td>
                                                                </tr>
            <?php
            $i++;
        }
    } else {
        ?>
                                                            <tr  id="row_1">
                                                                <td style="text-align:center;font-style:italic" colspan="5"><p>--No Records Found-- </p></td>

                                                            </tr>
    <?php } ?>   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                        
                                    </div>
                                </li>
                                                        <?php } ?>
                            <!-- End Dependant Details Tab --> 
                            <!-- Address Tab Starts Here -->   
                                                        <?php if ($block['4']['LabelBlock']['block_status'] == 1) { ?>
                                <li aria-hidden="false" class="uk-active">
                                    <div class="md-card">
                                        <div class="md-card-content large-padding">                                           
                                            <form id="form_validation" enctype="multipart/form-data" data-parsley-validate class="uk-form-stacked" method="POST" action="updateAddress" >
                                                <h3 class="uk-text-primary">Current Address</h3>
                                                <div class="uk-grid" data-uk-grid-margin>                                                    
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">City </label>
                                                            <?php
                                                            if ($profile['MyProfile']['cur_city_id'] != " ") {
                                                                $city = "value='" . $profile['MyProfile']['cur_city_id'] . "'";
                                                            } else {
                                                                $city = "";
                                                            }
                                                            ?>
                                                            <input type="text" id="cur_city_id" name="cur_city_id"  <?php echo $city ?> class="md-input">
                                                        </div>
                                                    </div>                                                        

                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">State</label>
    <?php
    if ($profile['MyProfile']['cur_state_id'] != "") {
        $state = "value='" . $profile['MyProfile']['cur_state_id'] . "'";
    }
    ?>
                                                            <input type="text" id="cur_state_id"  name="cur_state_id" <?php echo $state; ?> class="md-input">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Country </label>
                                                            <?php
                                                            if ($profile['MyProfile']['cur_country_id'] != "") {
                                                                $cur_country_id = "value='" . $profile['MyProfile']['cur_country_id'] . "'";
                                                            }
                                                            ?>
                                                            <input id="cur_country_id" <?php echo $cur_country_id; ?> class="md-input" type="text" name="cur_country_id" >
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Pin Code</label>
                                                            <?php
                                                            if ($profile['MyProfile']['cur_pincode'] != "") {
                                                                $cur_pincode = "value='" . $profile['MyProfile']['cur_pincode'] . "'";
                                                            }
                                                            ?>
                                                            <input id="cur_pincode" maxlength="10" <?php echo $cur_pincode; ?> class="md-input" type="text" name="cur_pincode">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Phone</label>
                                                            <?php
                                                            if ($profile['MyProfile']['cur_phone'] != 0) {
                                                                $cur_phone = "value='" . $profile['MyProfile']['cur_phone'] . "'";
                                                            }
                                                            ?>
                                                            <input id="cur_phone" maxlength="10" <?php echo $cur_phone; ?> class="md-input" type="text" name="cur_phone">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-1">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Address</label>
                                                            <?php
                                                            if ($profile['MyProfile']['cur_address'] != "") {
                                                                $cur_address = "value='" . $profile['MyProfile']['cur_address'] . "'";
                                                            }
                                                            ?>
                                                            <input type="text" id="Title" class="md-input" name="cur_address" <?php echo $cur_address; ?>>
                                                        </div>
                                                    </div>
                                                </div>                                                

                                                <h3 class="uk-text-primary">Permanent Address</h3>
                                                <div class="uk-grid" data-uk-grid-margin>                                                    
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">City </label>
                                                            <?php
                                                            if ($profile['MyProfile']['per_city_id'] != " ") {
                                                                $per_city = "value='" . $profile['MyProfile']['per_city_id'] . "'";
                                                            } else {
                                                                $city = "";
                                                            }
                                                            ?>
                                                            <input type="text" id="per_city_id" name="per_city_id"  <?php echo $per_city ?> class="md-input">
                                                        </div>
                                                    </div>                                                        

                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">State </label>
    <?php
    if ($profile['MyProfile']['per_state_id'] != "") {
        $per_state = "value='" . $profile['MyProfile']['per_state_id'] . "'";
    }
    ?>
                                                            <input type="text" id="per_state_id"  name="per_state_id" <?php echo $per_state; ?> class="md-input">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Country</label>
    <?php
    if ($profile['MyProfile']['per_country_id'] != "") {
        $per_country_id = "value='" . $profile['MyProfile']['per_country_id'] . "'";
    }
    ?>
                                                            <input id="per_country_id" <?php echo $per_country_id; ?> class="md-input" type="text" name="per_country_id" >
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Pin Code</label>
    <?php
    if ($profile['MyProfile']['per_pincode'] != "") {
        $per_pincode = "value='" . $profile['MyProfile']['per_pincode'] . "'";
    }
    ?>
                                                            <input id="per_pincode" maxlength="10" <?php echo $per_pincode; ?> class="md-input" type="text" name="per_pincode">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Phone </label>
                                                        <?php
                                                        if ($profile['MyProfile']['per_phone'] != 0) {
                                                            $per_phone = "value='" . $profile['MyProfile']['per_phone'] . "'";
                                                        }
                                                        ?>
                                                            <input id="per_phone" maxlength="10" <?php echo $per_phone; ?> class="md-input" type="text" name="per_phone">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-1">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Address </label>
    <?php
    if ($profile['MyProfile']['per_address'] != "") {
        $per_address = "value='" . $profile['MyProfile']['per_address'] . "'";
    }
    ?>
                                                            <input type="text" id="Title" class="md-input" name="per_address" <?php echo $per_address; ?>>
                                                        </div>
                                                    </div>
                                                </div>                                                

                                                <div class="uk-grid" data-uk-grid-margin>                                                    
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Upload Document <span class="req">*</span></label>
                                                            <div class="uk-form-file md-btn md-btn-primary">
                                                                Browse
                                                                <input  id="form-file" required="" name="doc_file" type="file">
                                                            </div>



                                                        </div>
                                                        Please upload documents having extension :- .pdf, .jpg, .png, .txt, .doc, .docx 
                                                    </div>

                                <?php
                                $auth = $this->Session->read('Auth');
                                //$fwemplist = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                $fwemplist = $this->Common->getHrList('13098');
                                ?>

                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="val_select" class="uk-form-label">Select HR <span class="req">*</span></label>
    <?php echo $this->Form->input('forwardlvl', array('type' => 'select', 'label' => false, 'options' => $fwemplist, 'class' => 'id="val_select"', 'id' => 'fwlvempcode', 'required' => TRUE, 'data-md-selectize')); ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-1-2">  
                                                            <?php if ($hideEditButton == "") { ?>
                                                            <button type="submit"onclick='return checkSubmitAddress();' class="md-btn md-btn-success" name="submit">Submit</button>
                                                            <button type="reset" class="md-btn md-btn-primary" name="submit">Cancel</button>
                                                            <input id="EmpCode" class="md-input" type="hidden" name="id" value="<?php echo $profile['MyProfile']['id'] ?>">
        <?php
    }
//echo $changeAddRemark;die;
    ?>
                                                    </div>	
                                                </div>

                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width">  
                                                            <?php if (trim($changeAddRemark) != "") { ?>
                                                            <ul id="notes_list" class="md-list md-list-outside notes_list">

                                                                <li class="heading_list uk-text-danger">Below is the last remark on your address details from HR - </li>
                                                                <li>
                                                                    <a data-note-id="1" class="md-list-content note_link" href="#">
                                                                        <span class="md-list-heading uk-text-truncate"><?php
                                                        if (trim($changeAddRemark) != "") {
                                                            echo $changeAddRemark;
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                                ?></span>

                                                                    </a>
                                                                </li>

                                                            </ul>

    <?php } ?>
                                                    </div>	
                                                </div>
                                            </form>
                                        </div>                                   
                                </li>                                         
                                                        <?php } ?>
                            <!-- Address Tab Ends Here  Information -->
                                                        <?php if ($block['5']['LabelBlock']['block_status'] == 1) { ?>                                
                                <li aria-hidden="false" class="uk-active">
                                    <div class="md-card">
                                        <div class="md-card-content large-padding">                                           
                                            <form id="form_validation" data-parsley-validate class="uk-form-stacked" method="POST" action="update_myprofile" >
                                                <h3 class="uk-text-primary">Contact Information</h3>
                                                <div class="uk-grid" data-uk-grid-margin>                                                    
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Official Phone No </label>
    <?php
    if ($profile['MyProfile']['contact'] != "") {
        $officialContact = "value='" . $profile['MyProfile']['contact'] . "'";
    } else {
        $officialContact = "";
    }
    ?>
                                                            <input type="text" id="contact" required class="md-input" name="contact" <?php echo $officialContact; ?> maxlength = "10">

                                                        </div>
                                                    </div>                                                        

                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Personal Phone No <span class="req">*</span></label>
    <?php
    if ($profile['MyProfile']['personal_phone'] != "") {
        $personal_phone = "value='" . $profile['MyProfile']['personal_phone'] . "'";
    }
    ?>
                                                            <input type="text" id="personal_phone"  name="personal_phone" <?php echo $personal_phone; ?> class="md-input" maxlength = "15">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-2">                                                        
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Official Email <span class="req">*</span></label>
    <?php
    if ($detail['UserDetail']['email'] != "") {
        $email = "value='" . $detail['UserDetail']['email'] . "'";
    }
    ?>
                                                            <input id="EthnicGroup" <?php echo $email; ?> class="md-input" type="email" name="email" maxlength = "35">
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-medium-1-2">
                                                        <div class="parsley-row">                                                            
                                                            <label for="fullname">Personal Email <span class="req">*</span></label>
    <?php
//print_r($profile['MyProfile']);
    if ($profile['MyProfile']['per_email'] != "") {
        $per_email = "value='" . $profile['MyProfile']['per_email'] . "'";
    }
    ?>
                                                            <input id="EthnicGroup" <?php echo $per_email; ?> class="md-input" type="email" name="per_email" maxlength = "35">
                                                        </div>                                                        

                                                    </div>                                                  
                                                </div>

                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-1-2">
                                                    <?php if ($hideEditButton == "") { ?>
                                                            <button type="submit" class="md-btn md-btn-success" name="submit">Submit</button>
                                                            <button type="reset" class="md-btn md-btn-primary" name="submit">Cancel</button>
                                                            <input id="EmpCode" class="md-input" type="hidden" name="id" value="<?php echo $profile['MyProfile']['id'] ?>">
    <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>                                   
                                </li>                                          
<?php } ?>
                            <!-- Upload Documents-->                                                               
                            <li aria-hidden="false" class="uk-active">
                                <div class="md-card">
                                    <div class="md-card-content large-padding">                                           
                                        <form id="form_validation" data-parsley-validate class="uk-form-stacked" enctype="multipart/form-data" method="POST" action="uploadDocument" >
                                            <h3 class="uk-text-primary">Upload Document</h3>
                                            <div class="uk-grid" data-uk-grid-margin>                                                    
                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">                                                            
                                                        <label for="fullname">Title <span class="req">*</span> </label>                                                            
                                                        <input type="text" id="title" required class="md-input" name="title" maxlength = "45">                                                        
                                                        <div id="errmsg2"></div>    
                                                    </div>
                                                </div>                                                        

                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">

                                                        <div class="uk-form-file md-btn md-btn-primary">
                                                            Browse
                                                            <input  id="form-file" required="" name="doc_file" type="file">
                                                        </div>
                                                        Upload Document <span class="req">*</span>                                                           
                                                    </div>
                                                </div>                                                  
                                            </div>
                                            Please upload documents having extension :- .pdf, .jpg, .png, .txt, .doc, .docx 

                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-1-2">
<?php if ($hideEditButton == "") { ?>
                                                        <button type="submit" class="md-btn md-btn-success" name="submit">Submit</button>
                                                        <button type="reset" class="md-btn md-btn-primary" name="submit">Cancel</button>
                                                        <input id="EmpCode" class="md-input" type="hidden" name="id" value="<?php echo $profile['MyProfile']['id'] ?>">
<?php } ?>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="uk-width-large-1-1">
                                            <div class="uk-overflow-container uk-margin-bottom">
<?php
$approveLists = $this->Common->getApprovedDocuments();
if (!empty($approveLists)) {
    ?>
                                                    <h4 class="uk-text-primary">Approved Document List</h4>
                                                    <table class="uk-table uk-table-striped uk-text-nowrap">
                                                        <thead>
                                                        <th>Sr. No</th>
                                                        <th>Title</th>
                                                        <th>Action</th>
                                                        </thead>
                                                    <?php foreach ($approveLists as $ke => $approveList) { ?>
                                                            <tr>
                                                                <td><?php echo $ke + 1; ?></td>
                                                                <td><a href="<?php echo $this->webroot . 'uploads/document/' . $approveLists[$ke]['EmpDocuments']['documents']; ?>" target="_blank"><?php echo $approveLists[$ke]['EmpDocuments']['title']; ?></a></td>
                                                                <td><span class ="md-btn md-btn-flat md-btn-flat-danger md-btn-wave waves-effect waves-button" title="Click to Delete." onClick="docDelete('<?php echo base64_encode($approveLists[$ke]['EmpDocuments']['id']); ?>')">Delete</span></td>
                                                            </tr>
                                                    <?php } ?>                                                
                                                    </table>
                                                <?php } ?>
                                                <hr class="md-card-content">
<?php
$nonApproveLists = $this->Common->getNonApprovedDocuments();
if (!empty($nonApproveLists)) {
    ?>
                                                    <h4 class="uk-text-primary">Non Approved Document List</h4>
                                                    <table class="uk-table uk-table-striped uk-text-nowrap">
                                                        <thead>
                                                        <th>S No.</th>
                                                        <th>Title</th>
                                                        <th>Action</th>
                                                        </thead>
                                                            <?php foreach ($nonApproveLists as $ke => $nonApproveList) { ?>
                                                            <tr>
                                                                <td><?php echo $ke + 1; ?></td>
                                                                <td><?php echo $nonApproveLists[$ke]['EmpDocuments']['title']; ?></td>
                                                                <td><a class ="md-btn md-btn-flat md-btn-flat-danger md-btn-wave waves-effect waves-button" title="Click to Delete." onClick="docDelete('<?php echo base64_encode($nonApproveLists[$ke]['EmpDocuments']['id']); ?>')">Delete</a></td>
                                                            </tr>
                                                            <?php } ?>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                   
                            </li>
                            <!-- End Upload Documents -->

                            <!-- Qualification-->
                            <?php if ($block['6']['LabelBlock']['block_status'] == 1) { ?>                                
                                <li aria-hidden="false" class="uk-active">
                                    <div class="md-card">
                                        <div class="md-card-content large-padding">                                           
                                            <form id="form_validation" data-parsley-validate class="uk-form-stacked" method="POST" action="update_myprofile1" >
                                                <h3 class="uk-text-primary">Qualification Information</h3>
                                                <table class="uk-table uk-table-striped uk-text-nowrap">
                                                    <thead>
                                                    <th>Course</th>
                                                    <th>Type</th>
                                                    <th>Mark Obtain</th> 
                                                    <th>Year of Passing</th>                            
                                                    </thead>
    <?php
    $i = 1;
    if (empty($qualification)) {
        ?>
                                                        <tr  id="row_1">
                                                            <td style="text-align:center;font-style:italic" colspan="5"><p>--No Records Found-- </p></td>

                                                        </tr>
        <?php
    }
    foreach ($qualification as $qual) {
        ?>
                                                        <tr>
                                                            <td><?php echo $this->Common->findGenderName($qual['EmpEdu']['course_id']) ?></td>
                                                            <td><?php echo $this->Common->bloodGroup($qual['EmpEdu']['qual_type_id']) ?></td>
                                                            <td><?php
                                                                if ($qual['EmpEdu']['mark_obtain']) {
                                                                    echo $qual['EmpEdu']['mark_obtain'];
                                                                } else {
                                                                    echo 'N/A';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php
                                                                if ($qual['EmpEdu']['yop']) {
                                                                    echo $qual['EmpEdu']['yop'];
                                                                } else {
                                                                    echo 'N/A';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                                <?php $i++;
                                                            }
                                                            ?>
                                                </table>
                                            </form>
                                        </div>                                   
                                </li>                                          
<?php } ?>
                            <!-- End Qualification -->
                            <!-- Previous Employee -->
                                                <?php if ($block['7']['LabelBlock']['block_status'] == 1) { ?>                                
                                <li aria-hidden="false" class="uk-active">
                                    <div class="md-card">
                                        <div class="md-card-content large-padding">                                           
                                            <form id="form_validation" data-parsley-validate class="uk-form-stacked" method="POST" action="update_myprofile22" >
                                                <h3 class="uk-text-primary"></h3>
                                                <table class="uk-table uk-table-striped uk-text-wrap">
                                                    <thead>
                                                    <th class="headings">Organisation</th>
                                                    <th class="headings">Organisation Location</th>
                                                    <th class="headings">Previous Designation</th>
                                                    <th class="headings">Date of joining</th>
                                                    <th class="headings">Date of Release</th>
                                                    <th class="headings">Salary</th>
                                                    </thead> 
    <?php if ($exp) { ?>

        <?php
        $i = 1;
        foreach ($exp as $qual) {//print_r($qual); 
            ?>
                                                            <tr>
                                                                <td><?php echo $qual['EmpExp']['emp_org_nm'] ?></td>
                                                                <td><?php echo $qual['EmpExp']['emp_org_loc'] ?></td>
                                                                <td><?php echo $qual['EmpExp']['emp_org_desig'] ?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($qual['EmpExp']['emp_org_doj']) {
                                                                        echo $qual['EmpExp']['emp_org_doj'];
                                                                    } else {
                                                                        echo 'N/A';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($qual['EmpExp']['emp_org_dol']) {
                                                                        echo $qual['EmpExp']['emp_org_dol'];
                                                                    } else {
                                                                        echo 'N/A';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
            <?php
            if ($qual['EmpExp']['emp_org_sal']) {
                echo $qual['EmpExp']['emp_org_sal'];
            } else {
                echo 'N/A';
            }
            ?>
                                                                </td>

                                                            </tr>
            <?php $i++;
        }
        ?>

    <?php } else { ?> 
                                                        <tr  id="row_1">
                                                            <td style="text-align:center;font-style:italic" colspan="6"><p>--No previous employer found-- </p></td>

                                                        </tr>
    <?php } ?>  </table>
                                                </table>
                                            </form>
                                        </div>                                   
                                </li>                                          
<?php } ?>
                            <!-- End Previous Employee -->

                            <!-- Bank Details-->                                                               
                            <li aria-hidden="false" class="uk-active">
                                <div class="md-card">
                                    <div class="md-card-content large-padding">                                           
                                        <form id="form_validation" data-parsley-validate class="uk-form-stacked" method="POST" action="uploadBankdetails" >
                                            <div class="uk-grid" data-uk-grid-margin>  
                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">  
<?php
$bank_id = $profile['MyProfile']['bank_code'];
//die;
?>
                                                        <label for="fullname">Select Bank<span class="req">*</span> </label>                                                            
<?php
$values = $this->Common->bankList(); //echo '<pre>';print_r($values);die;
?>
                                                        <select class="md-input data-md-selectize" name="data[eo_id]" data-md-selectize onChange="getBranch(this.value)">
<?php foreach ($values as $key => $val) { ?>   
                                                                <option value="<?php echo $key ?>" <?php if ($bank_id == $key) echo 'selected'; ?>><?php echo $val; ?></option>
                                                    <?php } ?>
                                                        </select>
<?php //echo $this->form->input('eo_id', array('class' => "data-md-selectize", 'label'=>false,'type' => 'select' ,'options' => $values,'onChange'=>'getIFSC(this.value)','default'=>$bank_id));  ?>
                                                    </div>
                                                </div>
<?php
$branch_list = $this->Common->bankList_branch($profile['MyProfile']['bank_code']);
$branch_id = $profile['MyProfile']['branch_code'];
//die;
?>
                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">  
                                                        <label for="fullname">Select Bank Branch<span class="req">*</span> </label>
                                                        <div id="bank_branch"> <select class="md-input data-md-selectize" name="data[eo_id]" data-md-selectize onChange="getBranch(this.value)">
            <?php foreach ($branch_list as $key => $val) { ?>   
                                                                    <option value="<?php echo $key ?>" <?php if ($branch_id == $key) echo 'selected'; ?>><?php echo $val; ?></option>
            <?php } ?>
                                                            </select>
                                                        </div>
<?php //echo $this->form->input('eo_id', array('class' => "data-md-selectize", 'label'=>false,'type' => 'select' ,'options' => $values,'onChange'=>'getIFSC(this.value)','default'=>$bank_id));   ?>
                                                    </div>
                                                </div> 
                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">                                                            
                                                        <label for="fullname">Account Holder Name <span class="req">*</span> </label>                                                            
                                                        <input type="text" id="account_holder" required class="md-input" name="account_holder" maxlength = "45" value = <?php echo $profile['MyProfile']['emp_full_name']; ?> readonly="readonly">                                                           
                                                    </div>
                                                </div>                                                        
                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">

                                                        <label for="fullname"><span class="req">*</span> </label>                                                            
                                                    </div>
                                                </div>
                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">

                                                        <label for="fullname">Account Number <span class="req">*</span> </label>                                                            
                                                        <input type="text" id="account_number" required class="md-input" name="account_number" maxlength = "20" value = <?php echo $profile['MyProfile']['account_no']; ?>>                                                        
                                                    </div>
                                                </div>

                                                <div class="uk-width-medium-1-2">                                                        
                                                    <div class="parsley-row">                                                            
                                                        <label for="fullname">IFSC Code <span class="req">*</span> </label>                                                            
                                                        <input type="text" id="ifsc_code" required class="md-input" name="ifsc_code" maxlength = "10" value = <?php echo $profile['MyProfile']['ifsc_code']; ?>>                                                            
                                                    </div>
                                                </div> 
                                            </div>
                                            <br/>
                                            <div class="uk-grid">
                                                <div class="uk-width-1-1">
                                                    <input id="EmpCode" class="md-input" type="hidden" name="id" value="<?php echo $profile['MyProfile']['id'] ?>">
<?php if ($hideEditButton == "") { ?>
                                                        <button type="submit" class="md-btn md-btn-success">Submit</button>
                                                        <button type="reset" class="md-btn md-btn-primary">Cancel</button>
<?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>                                   
                            </li>
                            <!-- End Bank Details -->


                        </ul>
                    </div>
                </div>
            </div>
<?php
if ($block['0']['LabelBlock']['block_status'] == 1) {
    $labels = $this->Common->block_labels($block['0']['LabelBlock']['id']);
    ?> 
                <div class="uk-width-large-3-10" style="min-height: 1623px;">
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-margin-medium-bottom">
                                <h3 class="heading_c uk-margin-bottom">Personal Information</h3>
                                <ul class="md-list md-list-addon">
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon material-icons uk-text-warning">location_on</i>                                        
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Address</span>
                                            <span class="uk-text-small uk-text-muted"><?php echo $profile['MyProfile']['cur_address']; ?></span>
                                        </div>                                    
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">                                        
                                            <i class="md-list-addon-icon material-icons uk-text-info">location_city</i>                                        
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Location</span>
                                            <span class="uk-text-small uk-text-muted"><?php
    $listName = $this->Common->findInvestName($profile['MyProfile']['location_code']);

    echo $listName['OptionAttribute']['name'];
    ?></span>
                                        </div>                                    
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">                                        
                                            <i class="md-list-addon-icon material-icons uk-text-success">business_center</i>                                        
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Department</span>
                                            <span class="uk-text-small uk-text-muted"><?php echo $department; ?></span>
                                        </div>                                    
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">                                        
                                            <i class="md-list-addon-icon material-icons uk-text-danger">school</i>                                        
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Designation</span>
                                            <span class="uk-text-small uk-text-muted"><?php echo $this->Common->findDesignationName($profile['MyProfile']['desg_code'], $profile['MyProfile']['comp_code']); ?></span>
                                        </div>                                    
                                    </li>                                
    <?php
    if (!empty($labels)) {
        if ($labels['0']['Labels']['label_status'] == 1) {
            ?> 
                                            <li>
                                                <div class="md-list-addon-element">                                        
                                                    <i class="md-list-addon-icon material-icons uk-text-info">assignment_ind</i>                                        
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">
            <?php
            Configure::write('I18n.preferApp', true);
            echo __d('debug_kit', $labels['0']['Labels']['name']);
            ?>
                                                    </span>
                                                    <span class="uk-text-small uk-text-muted"><?php echo $manager_det['MyProfile']['emp_name']; ?></span>
                                                </div>                                    
                                            </li>
                    <?php } ?>                                

        <?php if ($labels['1']['Labels']['label_status'] == 1) { ?>
                                            <li> 
                                                <div class="md-list-addon-element">                                       
                                                    <i class="md-list-addon-icon material-icons">today</i>                                        
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">
            <?php
            Configure::write('I18n.preferApp', true);
            echo __d('debug_kit', $labels['1']['Labels']['name']);
            ?>
                                                    </span>
                                                    <span class="uk-text-small uk-text-muted"><?php echo date("d-m-Y", strtotime($profile['MyProfile']['join_date'])); ?></span>
                                                </div>
                                            </li>
        <?php } ?>
        <?php if ($labels['2']['Labels']['label_status'] == 1) { ?>
                                            <li> 
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons uk-text-primary">insert_invitation</i>                                        
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">
            <?php
            Configure::write('I18n.preferApp', true);
            echo __d('debug_kit', $labels['2']['Labels']['name']);
            ?>
                                                    </span>
                                                    <span class="uk-text-small uk-text-muted"><?php echo date("d-m-Y", strtotime($profile['MyProfile']['dob'])); ?></span>
                                                </div>
                                            </li>
        <?php } ?>
        <?php if ($labels['3']['Labels']['label_status'] == 1) { ?>
                                            <li> 
                                                <div class="md-list-addon-element">
                                                    <i class="md md-water"></i>
                                                    <i class="md-list-addon-icon material-icons uk-text-danger">invert_colors</i>                                       
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">
            <?php
            Configure::write('I18n.preferApp', true);
            echo __d('debug_kit', $labels['3']['Labels']['name']);
            ?>
                                                    </span>
                                                    <span class="uk-text-small uk-text-muted"><?php echo $this->Common->bloodGroup($profile['MyProfile']['blood_group'], $profile['MyProfile']['comp_code']); ?></span>
                                                </div>
                                            </li>
        <?php } ?>                    
    <?php } ?> 
                                </ul>                                
                            </div>                            
                        </div>
                    </div>
                </div>
<?php } ?>
        </div>
    </div>
</div>

<script>
    function checkSubmitAddress() {
        var cur_city_id = document.getElementById("cur_city_id").value;
        var cur_state_id = document.getElementById("cur_state_id").value;
        var cur_country_id = document.getElementById("cur_country_id").value;
        var cur_pincode = document.getElementById("cur_pincode").value;
        var cur_phone = document.getElementById("cur_phone").value;
        var per_city_id = document.getElementById("per_city_id").value;
        var per_state_id = document.getElementById("per_state_id").value;
        var per_country_id = document.getElementById("per_country_id").value;
        var per_pincode = document.getElementById("per_pincode").value;
        var per_phone = document.getElementById("per_phone").value;

        var pattern = /^\d+$/;
        var pat1 = /^[a-zA-Z ]*$/;


        if (!pat1.test(cur_city_id)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid current city</div>").show();
            cur_city_id.focus();
            return false;
        } else if (!pat1.test(cur_state_id)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid current state</div>").show();
            cur_state_id.focus();
            return false;
        } else if (!pat1.test(cur_country_id)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid current country</div>").show();
            cur_country_id.focus();
            return false;
        } else if (cur_pincode.val() != '' && !pattern.test(cur_pincode)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid current pin code</div>").show();
            cur_pincode.focus();
            return false;
        } else if (cur_phone.val() != '' && !pattern.test(cur_phone)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid current phone number</div>").show();
            cur_phone.focus();
            return false;
        } else if (!pat1.test(per_city_id)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid permanent city</div>").show();
            per_city_id.focus();
            return false;
        } else if (!pat1.test(per_state_id)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid permanent state</div>").show();
            per_state_id.focus();
            return false;
        } else if (!pat1.test(per_country_id)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid permanent country</div>").show();
            per_country_id.focus();
            return false;
        } else if (per_pincode.val() != '' && !pattern.test(per_pincode)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid permanent pincode</div>").show();
            per_pincode.focus();
            return false;
        } else if (per_phone.val() != '' && !pattern.test(per_phone)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid permanent phone number</div>").show();
            per_phone.focus();
            return false;
        }


    }
    function docDelete(id)
    {
        var txt;
        var r = confirm("Are you sure want to delete this record");
        if (r == true) {
            jQuery.ajax({
                url: '<?php echo $this->webroot ?>users/docDelete/' + id,
                success: function (data) {
                    if (data == 'success') {
                        alert('Data Remove Suceesfully.');
                        window.location.reload();
                    } else {
                        alert('Data Not Remove Suceesfully.');
                    }
                }
            });
        } else {

        }
    }

    function depDelete(id)
    {
        var txt;

        var r = confirm("Are you sure want to delete this record");
        if (r == true) {
            jQuery.ajax({
                url: '<?php echo $this->webroot ?>users/deleteDependent/' + id,
                success: function (data) {
                    if (data == 'success') {
                        alert('Data Remove Suceesfully.');
                        window.location.reload();
                    } else {
                        alert('Data Not Remove.');
                    }
                }
            });
        } else {

        }

    }
    //jQuery("#removeButton").hide();
    //    $('#').change(function () {

    //   });


    /*====function to add a row====*/

    function addmore() {
        $("#removeButton").prop('disabled', false);
        var oldRowCount = document.getElementById("myTable").rows.length;

        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot ?>users/addnew/",
            data: {"rowCount": oldRowCount},
            success: function (data_var)
            {
                if ($('#myTable tbody tr').length == 0)
                {
                    $('#myTable tbody').html(data_var);

                } else {
                    $('#myTable tr:last').after(data_var);
                }

                jQuery(".dob").datepicker({
                    inline: false,
                    changeMonth: true,
                    autoclose: true,
                    orientation: "right bottom",
                    endDate: 'today',
                    dateFormat: 'dd-mm-yy'

                });


            }
        });
    }
    /*====function to remove a row====*/
    function removeRow()
    {
        var id = $('#myTable tr:last').attr('id');

        var oldRowCount = document.getElementById("myTable").rows.length;
        var newRowCount = parseInt(oldRowCount) - 1;
        if (newRowCount == 0)
        {
            //$("#removeButton").hide();
            $("#removeButton").prop('disabled', true);
        } else
        {
            $('#myTable tr:last').remove();

        }
    }
    function getIFSC(id) {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>users/getIFSC/' + id,
            success: function (data) {
                if (data) {
                    jQuery('#ifsc_code').val(data);
                    jQuery('#account_number').val('');

                } else {
                    jQuery('#ifsc_code').val('');
                    jQuery('#account_number').val('');

                }
            }
        });



    }


    function getBranch(id) {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>users/getBranch/' + id,
            success: function (data) {
                if (data) {
                    jQuery('#bank_branch').html(data);
                    jQuery('#account_number').val('');

                } else {
                    jQuery('#bank_branch').html('');
                    jQuery('#account_number').val('');

                }
            }
        });



    }

    function changetext() {

        $("#contact").on("keydown", function (e) {
            //console.log(e.which);
            if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg1").html("Digits Only").show();
                return false;
            } else {
                $("#errmsg1").html("").show();
            }
        });

        $("#personal_phone").on("keydown", function (e) {
            //console.log(e.which);
            if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg3").html("Digits Only").show();
                return false;
            } else {
                $("#errmsg3").html("").show();
            }
        });
    }



</script>
<div class="uk-grid" data-uk-grid-margin>
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <h2 class="heading_a">Change Profile Picture</h2>
            <form class="avatar-form" action="uploader" enctype="multipart/form-data" method="post">
                <h5 class="uk-text-danger"> Image size : 512 X 512  </h5>
                <div class="md-card-content margin-bottom">                        
                    <input type="file" id="input-file-b" name="avatar_file" required="" class="dropify" data-default-file="<?php echo $this->webroot; ?>images/admin_profile.jpg"/>
                </div>
                <hr>
                <div class="clearfix"></div>
                <div class="uk-grid margin">
                    <div class="uk-width-1-1">
<?php if ($hideEditButton == "") { ?>
                            <button name="submit" class="md-btn md-btn-success" type="submit">Upload</button>
<?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
