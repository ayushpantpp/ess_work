$(function() {
  
    $('#TrainingcalenderVcTrainingFrom').datepicker({
        changeMonth: true,		 
        changeYear: true,
		onClose: function( selectedDate ) {			
			$( "#TrainingcalenderVcTrainingTo" ).datepicker( "option", "minDate", selectedDate );
		
		}
    });
	
    $('#TrainingcalenderVcTrainingTo').datepicker({
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
        
		var $stHH = $('#TrainingcalenderNuStartHh').val();
		var $stMM = $('#TrainingcalenderNuStartMm').val();
		
		if($stHH=='' && $stMM ==''){
		
		 $error += "Please fill training start time.\n";
		}
		
		if($stHH=='0' && $stMM=='0' || $stHH=='00' && $stMM=='00' || $stHH=='00' && $stMM=='0' || $stHH=='0' && $stMM=='00'){

		   $error+="Training start time should be greater than zero.\n";

		}
		
		if($stHH > 12 ){

		   $error+="Training start time hours should not be greater than 12.\n";

		}
		
		if($stMM > 59 ){

		   $error+="Training start time minutes should not be greater than 59.\n";

		}
		
		var $endHH = $('#TrainingcalenderNuEndHh').val();
		var $endMM = $('#TrainingcalenderNuEndMm').val();
		
		if($endHH=='' && $endMM ==''){
		
		 $error += "Please fill training end time.\n";
		}
		
		if($endHH=='0' && $endMM=='0' || $endHH=='00' && $endMM=='00' || $endHH=='00' && $endMM=='0' || $endHH=='0' && $endMM=='00'){

		   $error+="Training end time should be greater than zero.\n";

		}
			
        if($endHH > 12 ){

		   $error+="Training end time hours should not be greater than 12.\n";

		}
		
		if($endMM > 59 ){

		   $error+="Training end time minutes should not be greater than 59.\n";

		}			
		
		if($durationH=='0' && $durationM=='' || $durationH=='' && $durationM=='0' || $durationH=='00' && $durationM=='' || $durationH=='' && $durationM=='00'){

		   $error+="Training duration should be greater than zero.\n";

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

            $error += "Maximum number of trainees cannot be less than minimum number of trainees !.\n";

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
		    $('#assigncal').attr('disabled','disabled');
            return (true);
        } else {
            alert($error);
            return (false);
        }
    }
	  
    function disable_mode() {
	
        if ($('#post_trainingN').is(':checked')) {		
			 $('#questnare_input').css('display','none');			
	
        } else {
			 $('#questnare_input').css('display','');	
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
  
  
  function getFiles(){
  
      var courseID = $('#TrainingcalenderVcTopicId').val();
	  
	  if ($('#post_trainingY').is(':checked')) {
				$.post('/portal/trainingcalenders/getQustnareFiles',{courseID:courseID},function(data) {
				if(data !='NOFILE'){;
				   $('#questnare_input').html(data);
				}else{
				   $('#questnare_input').css('display','none');	
				   alert('Please upload questionnaire before assigning training calendar.');
				}
			});	 
		}
  }