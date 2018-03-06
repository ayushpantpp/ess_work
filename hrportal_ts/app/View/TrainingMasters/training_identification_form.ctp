<?php

if ($desig_code == 'PAR0000035') {
    $date = '0';
} else {
    $date = '16';
}
$dateStr = '';

if (date('Y')) {
    for ($i = date('m'); $i <= 12; $i++) {
        if ($i < 10) {
            $i = '0' . $i;
        }
        $year = date('Y');
        $monthName = date("F", mktime(0, 0, 0, $i, 10));

        $dateStr .= date('d-m-Y', strtotime('second sat of ' . $monthName . ' ' . $year)) . ',';

        $dateStr .= date('d-m-Y', strtotime('fourth sat of ' . $monthName . ' ' . $year)) . ',';
    }
}

for ($i = 1; $i <= 12; $i++) {

    if ($i < 10) {
        $i = '0' . $i;
    }

    $nextyear = date('Y') + 1;

    $monthName = date("F", mktime(0, 0, 0, $i, 10));

    $dateStr .= date('d-m-Y', strtotime('second sat of ' . $monthName . ' ' . $nextyear)) . ',';

    $dateStr .= date('d-m-Y', strtotime('fourth sat of ' . $monthName . ' ' . $nextyear)) . ',';
}
?>

    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Training Identification Form</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Training Identification Form</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                
                <?php echo $this->Form->create('TrainingMaster', array('url' => array('controller' => 'trainingmasters', 'action' => 'training_identification_form'), 'onsubmit' => 'return formValidate();')); ?>
                <?php $auth=$this->Session->read('Auth');?>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Training Name:<span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <input name="data[TrainingMaster][vc_training_topic_type]" id="topic_E" class="flat" value="E" type="radio" checked="checked" onClick="show_dd(this.value);"> Existing
                    <input name="data[TrainingMaster][vc_training_topic_type]" id="topic_N" class="flat" value="N" type="radio" onClick="show_dd(this.value);"> New
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Training Required : <span class="required">*</span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                       <?php
                            echo $this->Form->input('vc_training_topic_id', array('type' => 'select',
                                'class' => 'form-control',
                                'label' => false,
                                
                                'options' => $courselist
                            ));
                            ?>						
                            <?php
                            echo $this->Form->input('vc_training_name', array('type' => 'text',
                                'class' => 'form-control',
                                'style' => 'display:none;width:172px;',
                                'label' => false,
                                'placeholder' => 'Training Topic Name'));
                            ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Desired Training Date:<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                     <?php
                     echo $this->Form->input('vc_training_date', array('type' => 'text',
                        'class' => 'form-control', 'readonly' => true,
                        'label' => false));
                      ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Training Duration:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class='col-md-3'>
                             <?php
                            echo $this->Form->input('nu_duration_hh', array('type' => 'text',
                                'class' => 'form-control',
                                'label' => false,
                                'placeholder' => 'Hours',
                                'maxlength' => '2',
                                'style'=> 'width:70px;',
                                'onkeypress' => 'return isNumberKey(event)'
                                ));
                            ?>
                       
                            
                        </div>
                        <div class='col-md-3'>
                            <?php
                            echo $this->Form->input('nu_duration_mm', array('type' => 'text',
                                'class' => 'form-control',
                                'label' => false,
                                'placeholder' => 'Minutes',
                                'maxlength' => '2',
                                'onkeypress' => 'return isNumberKey(event)',
                                'style'=> 'width:80px;'
                                ));
                            ?> 
                        </div>
                           

                    </div>

                    
                  </div>
                <?php if (count($reported_emp) != 0 || $desig_code == 'PAR0000035') { ?>
                <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Self Include:<span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <input name="data[TrainingMaster][vc_self_include]" class='flat' id="ch_st_daylengthf" value="Y" type="radio" checked="checked">&nbsp; Yes
                      <input name="data[TrainingMaster][vc_self_include]" class='flat' id="ch_st_daylengthh" value="N" type="radio">&nbsp; No
                    </div>
                </div>
                  
                    <div class="form-group col-md-6 col-sm-8 col-xs-12">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12"> List of Employees:<span class="required">*</span></label>
                    <div class="col-md-3">
                        <?php
                        echo $this->Form->input('TrainingMasterDetail.vc_trainee_code', array('type' => 'select',
                            'class' => 'form-control',
                            'multiple' => true,
                            'label' => false,
                            'options' => $reported_emp,
                            'id' => 'lstBox1',
                            'style' => 'height:140px;'));
                         ?>
                    </div> 
                    <div class="col-md-1 col-sm-4">
                        <input type="button" id="btnRight" value =" => "/>
                    </div>   
                    
                    <div class="col-sm-4">
                        <input type="button" id="btnLeft" value =" <= "/> 
                    </div>    
                         
                    </div>
                    
                    
                <div class="form-group col-md-6 col-sm-8 col-xs-12">
                    <div id="trainees_list_div"></div>
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">List of Trainees:<span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-16">
                    
                    <?php
                     $checllvl = $this->Common->findcheckLevel(6,'DEPT00006',01);
                     $fwemplist = $this->Common->findLevel($checllvl,'Apply');
                     //print_r($fwemplist);die;
                    echo $this->Form->input('TrainingMasterDetail.vc_trainee_code', array('type' => 'select',
                        'class' => 'form-control',
                        'multiple' => true,
                        'label' => false,
                        'id' => 'lstBox2',
                        'style' => 'height:140px;'));
                     ?>
                        
                        <input name="data[TrainingMasterDetail][vc_type]" id="type_manager" value="M" type="hidden">
                        <?php foreach($fwemplist as $key=>$val){ ?>
                         <input name="data[TrainingMasterDetail][manager][]" id="type_manager" value="<?php echo $key ?>" type="hidden">
                        <?php }?>
                       
                    </div>
                  </div>
               </div>
                <?php } else { ?>
                    <input name="data[TrainingMaster][vc_self_include]" type="hidden" value="Y"/>
                 <?php } ?>
                
               
              </div>
                
                  <div class="ln_solid"></div>
                  
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                   <input type="submit" class="btn btn-success" value="Save"  >  
                     
                    </div>
                  </div>
                 
              <div id="hidden_values"></div>
               <?php echo $this->Form->end(); ?>
        
              </div>
            </div>
          </div>
        </div>
      </div>


    



<script language="javascript" type="text/javascript">
    $(document).ready(function() {
        $('#btnRight').click(function(e) {
            var selectedOpts = $('#lstBox1 option:selected');
            var selectedOptsVals = $('#lstBox1').val().toString();
            if (selectedOpts.length == 0) {
                alert("Nothing to move.");
                e.preventDefault();
            }
            $('#lstBox2').append($(selectedOpts).clone());
            $(selectedOpts).remove();
            e.preventDefault();

            var myArray = selectedOptsVals.split(',');

            for (var i = 0; i < myArray.length; i++) {

                $('#trainees_list_div').append('<input type="hidden" name="data[TrainingMasterDetail][traineecode][]" value="' + myArray[i] + '"/>');
            }
        });
        $('#btnLeft').click(function(e) {
            var selectedOpts = $('#lstBox2 option:selected');
            var selectedOptsVals = $('#lstBox2').val().toString();
            if (selectedOpts.length == 0) {
                alert("Nothing to move.");
                e.preventDefault();
            }

            $('#lstBox1').append($(selectedOpts).clone());
            $(selectedOpts).remove();
            e.preventDefault();

            var myArray = selectedOptsVals.split(',');

            for (var i = 0; i < myArray.length; i++) {
                $('input[value="' + myArray[i] + '"]').remove();
            }
        });

        $("#TrainingMasterVcTrainingDate").datepicker({
            numberOfMonths: 1,
            minDate: '+<?php echo $date; ?>D',
            beforeShowDay: function(dt) {

                var day = dt.getDay();

                var month = dt.getMonth();

                var year = dt.getFullYear();

                var date_str = "<?php echo $dateStr; ?>";

                var datelist = date_str.split(",");

                var dmy = "";
                dmy += ("00" + dt.getDate()).slice(-2) + "-";
                dmy += ("00" + (dt.getMonth() + 1)).slice(-2) + "-";
                dmy += dt.getFullYear();

                $workingdays_count = 0;
                if (day == 6) {
                    if ($.inArray(dmy, datelist) >= 0) {
                        return [false, ""]
                    } else {
                        return [true, ""]
                    }
                } else if (day == 0) {

                    return [false, ""]

                } else {
                    return [true, ""]
                }
            }
        });
    });

    function GetMonthName(monthNumber) {
        var months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
        return months[monthNumber];
    }


    function show_training(val) {
      
        if (val == 'E') {
            $('#TrainingMasterVcTrainingTopicId').css('display', '');

            $('#TrainingMasterVcTrainingName').css('display', 'none');
        } else {
            $('#TrainingMasterVcTrainingName').css('display', '');

            $('#TrainingMasterVcTrainingTopicId').css('display', 'none');

        }
    }
    /**
     **
     *Function to check that users fill  number only
     **
     **/

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

 <
<style type="text/css">
    .error-message{
        color: red;
    }
</style>
<script type="text/javascript">
    function formValidate() {
        $existing = $('#TrainingMasterVcTrainingTopicId').val();

        $New = $('#TrainingMasterVcTrainingName').val();

        $trainDate = $('#TrainingMasterVcTrainingDate').val();

        $durationH = $('#TrainingMasterNuDurationHh').val();

        $durationM = $('#TrainingMasterNuDurationMm').val();

        $expression = /^\d+$/;

        var $error = '';

        if ($existing == '' && $New == '') {

            $error += "Training required shall not be empty.\n"

        }
        if ($trainDate == '') {

            $error += "Please Fill training date.\n";
            $('#TrainingMasterVcTrainingDate').focus();
        }

        if ($durationH == '' && $durationM == '') {

            $error += "Please fill duration.\n"
            $('#TrainingMasterNuDurationMm').focus();

        }

        if ($durationH == '0' && $durationM == '' || $durationH == '' && $durationM == '0' || $durationH == '00' && $durationM == '' || $durationH == '' && $durationM == '00') {

            $error += "Training duration should be greater than zero.\n"
            $('#TrainingMasterNuDurationMm').focus();

        }

        if ($durationH == '0' && $durationM == '0' || $durationH == '00' && $durationM == '00' || $durationH == '00' && $durationM == '0' || $durationH == '0' && $durationM == '00') {

            $error += "Training duration shall be greater than zero.\n"
            $('#TrainingMasterNuDurationMm').focus();

        }

        if ($durationM >= 60) {

            $error += "Training duration minutes shall not be greater than 59.\n"

            $('#TrainingMasterNuDurationMm').focus();

        }


        if ($error == '') {

        } else {
            alert($error);
            return(false);
        }

    }
</script>
