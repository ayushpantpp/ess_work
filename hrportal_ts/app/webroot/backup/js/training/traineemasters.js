function set_training_attendance(cur_val, index_val) {

    if (cur_val != 'P') {

        $("#sesion_row_" + index_val).css('display', 'none');

        $("#remark_" + index_val).css('display', '');

    } else {
        $("#sesion_row_" + index_val).css('display', '');

        $("#remark_" + index_val).css('display', 'none');
    }
}


function validate_attendee_form() {

    var $err_chk_box = 1;

    var $err_slt_box = 1;

    var $vld_errs = '';

    var noOfRows = $("#countRow").val();
	
	var minTrainees = $('#minTrainees').val();
    
	var presentees = 0;
    for (var i = 1; i <= noOfRows; i++) {

        var att_sts = $("#attendance_row_" + i).val();

        if (att_sts != 'P') {

            var new_txt_area = $("#remark_" + i);

            if (new_txt_area.val() == '') {
                new_txt_area.css("background-color", "#FAFAD2");
                $err_chk_box = 0;
            } else {
                new_txt_area.css("background-color", "#FFFFFF");
                $err_chk_box = 1;
            }
        }else{
		  presentees++;
		}
    }

    if ($err_chk_box == 0) {
        $vld_errs = "Please state reason !.\n";
    }
	
	//if (parseInt(minTrainees) >  parseInt(presentees)) {
        //$vld_errs += "Minimum "+minTrainees+" trainees are required for this training.";
   // }
		
    if ($vld_errs == '') {
	    return true;
    } else {
        alert($vld_errs);
        return false;
    }
    return false;
}