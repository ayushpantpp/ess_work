/**
**
*Function to check that users fill  number only
**
**/
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}


function trainer_name_auto(row) 
  {   
          var searchItm = jQuery("#trainer_name_"+row).val();
	      if(searchItm.length==2){
                jQuery( "#trainer_name_"+row).autocomplete({
                source: '/liveportal/sessionmasters/autosuggestion',
                minLength: 2,
                select: function( event, ui ) {
                    jQuery('#trainer_name_'+row).attr('value', ui.item.value);
                    jQuery('#trainer_code_'+row).attr('value', ui.item.id);
                }
            });
       }
   }
     
     
function add_new_row() {

  var rowNo = $('#countRows').val();
    rowNo = parseInt(rowNo) + 1;    
    $("#addmorerow").before('<tr class="cont" id="session_row_' + rowNo + '">\n\
    <td height="30"><input type="text" onkeydown="trainer_name_auto(' + rowNo + ')" id="trainer_name_' + rowNo + '" class="round_select" name="data[TrainingSession][trainer_name_' + rowNo + ']"/><input type="hidden" id="trainer_code_' + rowNo + '" name="data[TrainingSession][trainer_code_' + rowNo + ']"/></td>\n\
    <td height="30"><input type="text" id="session_' + rowNo + '" class="round_select" name="data[TrainingSession][session_' + rowNo + ']"/></td>\n\
    <td height="30"><input type="text" placeholder="Hours" id="duration_hh_' + rowNo + '" style="width:90px;" class="round_select" name="data[TrainingSession][duration_hh_' + rowNo + ']"/> &nbsp;<input type="text" placeholder="Minutes" id="duration_mm_' + rowNo + '" style="width:90px;" class="round_select" name="data[TrainingSession][duration_mm_' + rowNo + ']"/></td>\n\
    <td><center><input type="text" style="width:155px;" id="startdate_' + rowNo + '" class="round_select" name="data[TrainingSession][date_' + rowNo + ']"></center></td><td height="30"><input type="button" value="REMOVE" onclick="remove_row(' + rowNo + ')" name="remove_btn_' + rowNo + '"/></td></tr>');
    $('#countRows').val(rowNo);
    $("#startdate_"+rowNo).datepicker();
}

function remove_row(row_id) {

    if (confirm("Are you sure ?")) {
        $('table#session_master_tbl tr#session_row_' + row_id).remove();
    } else {
        return false;
    }
}

function getDetails(topicID) {
    $.post('session_trainers', {
        topic_id: topicID
    }, function(data) {
        $("#sessiontrainer").html(data);
    });
}

function formValidate() {
    $training = $('#SessionMasterVcCourseId').val();
    $session = $('#SessionMasterVcSession').val();

    var $error = '';

    if ($training == '') {
        $error += "Please Select Training.\n";
    }
    if ($session == '') {
        $error += "Please Fill session.\n";
    }
    if ($error == '') {

    } else {
        alert($error);
        return (false);
    }
}

function training_schedule() {

	var rowNo = $('#session_master_tbl tr').length;

	var $error = '';

	var totalDuration = 0;
	
    var total_hrs = 0;
	
	var total_mnts = 0;
	
	$("[alt|='HOURS']").each(function() {
		 
	   if (!isNaN(this.value) && this.value.length != 0) {
	 
		  total_hrs = parseInt(total_hrs) + parseInt(this.value);
	
	   }
	  });	  
	  
	 $('#duration_hh').val(total_hrs);			  
	  
	 $("[alt|='MINUTES']").each(function() {
		 
	   if (!isNaN(this.value) && this.value.length != 0) {
	 
		  total_mnts = parseInt(total_mnts) + parseInt(this.value);
	
	   }
	  });  
    $('#duration_mm').val(total_mnts);	
	  
    //totalDuration = parseFloat(hh * 60); + parseFloat(mm);
   
   alert(total_hrs);alert();return false;
	
    if ($error == '') {
		
		var train_id = $('#TrainingSessionNuTrainingId').val();
		$.post('/liveportal/sessionmasters/validate_session_data',{trainingID:train_id, duration:totalDuration},function(data) {
			if(data !='FINE'){
			   alert("Attention ! "+data);
			   return false;
			}else{
			   $('#TrainingSessionScheduledTrainingSessionsForm').submit();
			   $('#submit_btn').attr('disabled','disabled');
			}
		});	
    } else {
        alert($error);
        return false;
    }
}