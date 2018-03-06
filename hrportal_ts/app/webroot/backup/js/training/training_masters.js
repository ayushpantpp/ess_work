$(function() {
  
    $('#TrainingcalenderVcTrainingFrom').datepicker({
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		minDate :0,
		 onClose: function( selectedDate ) {
			
			$( "#TrainingcalenderVcTrainingTo" ).datepicker( "option", "minDate", selectedDate );
		
		}
    });
	
    $('#TrainingcalenderVcTrainingTo').datepicker({
	
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
		onClose: function( selectedDate ) {
		
			$( "#TrainingcalenderVcTrainingFrom" ).datepicker( "option", selectedDate );
		}   
    });
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
/**
**
**
*Validations for update_training_calender
**
**
*/ 
 function calendarValidate() {
 
        $durationH = $('#TrainingcalenderNuDurationHh').val();

        $durationM = $('#TrainingcalenderNuDurationMm').val();

        $minTrainee = $('#TrainingcalenderNuMinTrainees').val();

        $maxTrainee = $('#TrainingcalenderNuMaxTrainees').val();

        $PET = $('#TrainingcalenderNuPteAfter').val();

        $PET1 = $('#TrainingcalenderVcPteDaysMonths').val();

        $trainStart = $('#TrainingcalenderVcTrainingFrom').val();
		
        $trainEnd = $('#TrainingcalenderVcTrainingTo').val();
		
        var $error = '';
		
		if ($('#TrainingcalenderVcTrainingRegion').val() == '') {

            $error += "Please select training region.\n";
			
			//$('#TrainingcalenderVcTrainingRegion').css('background-color','#545678');
        }
        if ($('#TrainingcalenderVcTopicId').val() == '') {

            $error += "Please select training required.\n";
        }
		if ($('#TrainingcalenderVcTrainingType').val() == '') {

            $error += "Please select training type.\n";
        }
		if ($trainStart == '') {

            $error += "Please select training start date.\n";
        }
        if ($trainEnd == '') {

            $error += "Please select training end date.\n";

        }

		if($('#TrainingcalenderNuStartHh').val()=='' && $('#TrainingcalenderNuStartMm').val() ==''){
		
		 $error += "Please fill training start time.\n";
		}
		
		if($('#TrainingcalenderNuEndHh').val()=='' && $('#TrainingcalenderNuEndMm').val() ==''){
		
		 $error += "Please fill training end time.\n";
		}
        
        if ($durationH == '' && $durationM == '') {

            $error += "Please fill duration.\n"

        }
		
		
		if($durationH=='0' && $durationM=='' || $durationH=='' && $durationM=='0' || $durationH=='00' && $durationM=='' || $durationH=='' && $durationM=='00'){

		   $error+="Training duration should be greater than zero.\n";

		}

		if($durationH=='0' && $durationM=='0' || $durationH=='00' && $durationM=='00' || $durationH=='00' && $durationM=='0' || $durationH=='0' && $durationM=='00'){

		   $error+="Training duration shall be greater than zero.\n";

		}

		if($durationM >= 60){

		   $error+="Training duration minutes shall not be greater than 59.\n";

		}
		

        if ($minTrainee == '') {

            $error += "Please fill the minimum number of required trainees .\n";

        }
        if ($maxTrainee == '') {

            $error += "Please fill the maximum number of required trainees shall be greater than zero.\n"

        }
        
		if($minTrainee=='0' && $maxTrainee=='' || $minTrainee=='' && $maxTrainee=='0' || $minTrainee=='00' && $maxTrainee=='' || $minTrainee=='' && $maxTrainee=='00' || $minTrainee=='00' && $maxTrainee=='00'){

		   $error+="The minimum & maximum number of required trainees .\n";

		}
		
		if (parseInt($minTrainee) > parseInt($maxTrainee)) {

            $error += "Maximum number of trainees cannot be less than minimum number of trainees !!.\n";

        }
        
		if ($('#training_mode').val() == '') {

            $error += "Please select training mode.\n";

        }
        if ($('#post_trainingY').is(':checked')) {

            if ($('#post_trainingY').val() == 'Y' && $PET == '') {

                $error += "Please fill time period of PET.\n";

            }
            if ($('#post_trainingY').val() == 'Y' && $PET1 == '') {

                $error += "Please select time period of PET .\n";

            }

        }
        if ($error == '') {
            return (true);
        } else {
            alert($error);
            return (false);
        }
    }

    function disable_mode() {
	
        if ($('#post_trainingN').is(':checked')) {
		
		     $('#TrainingcalenderNuPteAfter').val('');
			 
			 $('#TrainingcalenderVcPteDaysMonths option').filter(function() { 
                 return ($(this).text() == 'Select');
            }).attr('selected', true); 
			 
             $('#TrainingcalenderNuPteAfter').attr('disabled', true);
			 
			 $('#TrainingcalenderVcPteDaysMonths').attr('disabled', true);
			 
        } else {
		
		    $('#TrainingcalenderNuPteAfter').attr('disabled', false);
			$('#TrainingcalenderVcPteDaysMonths').attr('disabled', false);	
			$('#TrainingcalenderNuPteAfter').val('03');
			$('#TrainingcalenderVcPteDaysMonths option').filter(function() { 
                 return ($(this).text() == 'Month ( s )');
            }).attr('selected', true); 
        }
    }

  function show_dd(val){
	if(val=='E'){	
	      $('#TrainingcalenderVcTopicId').css('display','');
		  $('#TrainingcalenderVcTrainingName').css('display','none');
	     }else{
		   $('#TrainingcalenderVcTrainingName').css('display','');
		  $('#TrainingcalenderVcTopicId').css('display','none');
	}
  }