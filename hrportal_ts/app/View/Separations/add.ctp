<!-- page content -->
<div id="page_content" role="main">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               Separation Form
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                <?php
                echo $this->form->create('Separation', array('url' => '','action'=>'add','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked'))));
                ?>

                <?php $auth=$this->Session->read('Auth');?>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <?php
//echo $auth['MyProfile']['comp_code']; 
                     //echo $auth['MyProfile']['emp_name'];
                     echo $this->form->input('user_name', array('label'=>false, 'type' => 'hidden', 'value' => $auth['MyProfile']['emp_name'],'class' => "md-input",'required'=>true,'id'=>'first_name'));
                     echo $this->form->input('emp_code', array('label'=>false, 'type' => 'hidden', 'value' => $auth['MyProfile']['emp_code'],'class' => "md-input",'required'=>true,'id'=>'first_name'));
                     echo $this->form->input('org_id', array('label'=>false, 'type' => 'hidden', 'value' => $auth['MyProfile']['comp_code'],'class' => "md-input",'required'=>true,'id'=>'org_id')); ?>
                     
                        </div>
                    </div>                    

                    <div class="uk-width-medium-1-2">
                        <label>Joining Date</label>
                        <div class="parsley-row">
                            <input type="text" class="md-input label-fixed" value="<?=date('d-M-Y', strtotime($emp_details['MyProfile']['join_date']));?>" />
                           <?php
                        echo $this->Form->input('Separation.join_date',array('type'=>'hidden','value'=>date('Y-m-d', strtotime($emp_details['MyProfile']['join_date']))));
                       ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Resignation Date </label>
                        <div class="parsley-row">
                            <?php echo $this->form->input('dt_resign_date', array('label'=>false,'class'=>"md-input",'type' => 'text', 'id' => 'resigndate','readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Department</label>
                        <div class="parsley-row">
                            <input type="text" class="md-input label-fixed" value="<?=$dept_code;?>" />
                           <?php
				echo $this->Form->input('Separation.dept_code',array('type'=>'hidden','value'=>$dept_code));
				?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label for="message">Notice Period Needed to be Served</label>
                        <div class="parsley-row">
                            <?php $notice_period = $emp_details['MyProfile']['notice_period'].' Days' ?>
                            <input type="text" class="md-input label-fixed" value="<?=$notice_period;?>" readonly="readonly" />
                        <?php
                            echo $this->Form->input('Separation.notice_period',array('type'=>'hidden','value'=>$emp_details['MyProfile']['notice_period']));
                        ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <label for="message">Designation</label>
                        <div class="parsley-row">
                           <input type="text" class="md-input label-fixed" value="<?=$desg_code;?>" /> 
                            <?php
                            echo $this->Form->input('Separation.desg_code',array('type'=>'hidden','value'=>$desg_code));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label for="message">Reason Of Resignation</label>
                        <div class="parsley-row">                            
                            <?php $resg_list=$this->common->findAllResignationName();?>
                            <?php echo $this->form->input('reason', array('type' => 'select', 'class'=>"md-input data-md-selectize label-fixed",'label' => false, 'empty' => 'Select', 'options' => $resg_list,)); ?>
                            <?php //echo $this->form->textarea('reason', array('label'=>false,'class'=>"md-input", 'maxlength' => "145",'style'=>"width: 274px; height: 63px;")); ?>
                        </div>
                    </div>
                </div>

                    <div class="uk-grid">
                        <div class="uk-width-1-2">
                            <div class="parsley-row">
                                <input type="submit" class="md-btn md-btn-success" value="Save to Manager" onclick="return checkSubmit();
                                       ">  
                                <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery("#resigndate").datepicker({
            //inline: true,
            startDate: '-90d',
            changeMonth: true,
            autoclose: true,
            //changeYear: true,
            minDate: 'today',
            maxDate: 'today',
            dateFormat: 'dd-M-yy'
        });
    });
</script>
<script>
    function checkSubmit()
    {
        if ($('#resigndate').val() === '') {
            $("html, body").animate({scrollTop: 0}, "slow");
            // $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Resignation Date").show();    
            $("#alerts").html('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Enter Resignation Date !!!!</div>');

            return false;
        }

        if ($('#SeparationReason').val() === '') {
            $("html, body").animate({scrollTop: 0}, "slow");
            //$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Resignation Reason").show();  
            $("#alerts").html('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Enter Resignation Reason !!!!</div>');
            return false;
        }
    }
</script>































