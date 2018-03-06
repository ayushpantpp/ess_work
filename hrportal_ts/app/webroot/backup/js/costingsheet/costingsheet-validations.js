function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        alert("Please enter digits only.");
        return false;
    }
    return true;
}

function checkDecimalValue(item, evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46)
    {
        var regex = new RegExp(/\./g)
        var count = $(item).val().match(regex).length;
        if (count > 1)
        {
            return false;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter digits only.");
        return false;
    }
    return true;
}

var isWhole_re = /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
var status = false;
function isWhole(s) {
    if (String(s).search(isWhole_re) != -1) {
        status = true
        return true;
    } else {
        alert("Please enter digits only");
        status = false
        return false;
    }
}


function Validate() {
    $return =  "";
    var flag = 0;
    if ($('#projval').val() == 0 || $('#projval').val() == '') {
        alert("Project value can not be left blank");
        $return =  "false";
    } else {
        var val = $('#projval').val();
        isWhole(val);
        if (status == false) {
            $('#projval').val("");
            $return =  "false";
        }
    }

    if ($('#mcost').val()==0 || $('#mcost').val() == '') {
        alert("ManDays Cost can not be left blank");
        $return =  "false";
    } else {
        var val = $('#mcost').val();
        isWhole(val);
        if (status == false) {
            $('#mcost').val("");
            $return =  "false";
        }

    }

    if ($('#effort').val() == 0 || $('#effort').val() == '') {
        alert("Budgeted Effort(MD) can not be left blank");
        $return =  "false";
    } else {
        var val = $('#effort').val();
        isWhole(val);
        if (status == false) {
            $('#effort').val("");
            $return =  "false";
        }
    }

    

        $("fieldset#tab1 input[class^='milestone-name-row-']").each(function() {
            if ($(this).val() == 0 || $(this).val() == '') {
                alert("Activity Field can not be left blank");
                $return =  "false";
            }
        }); // End of for loop
  
  return $return;
}

$(document).ready(function() {

    $('#btnsave').click(function() {
        var chk = Validate();
       if(chk=='false')
         { 
             return false;
         }else{ 
             $("#insert-sheet").submit();
             $("#btnsave").css('disabled', true);
         }
    });
    
    
    $('#btnsaveedit').click(function(){
      var chk = Validate();
       if(chk=='false')
         { 
             return false;
         }else{ 
             $("#save-sheet").submit();
             $("#btnsaveedit").css('disabled', true);
         }
       
    });
    
    
    $('#btnsavecopy').click(function(){
      var chk = Validate();
       if(chk=='false')
         { 
             return false;
         }else{ 
             $("#copy-sheet").submit();
             $("#btnsavecopy").css('disabled', true);
         }
       
    });
	
	
	$('#update_info').click(function() {        
            var projectid = $('#projid').val();
            var projectemail = $('#projemail').val();
            var cust_code = $('#cust_code').val();
	if((validateEmail(projectemail)) && (validateProjectId(projectid))) {
              jQuery.ajax({
                    type: "POST",
                    url: "saveprojectdata",
                    data: {
                        projectid: projectid,
                        projectemail: projectemail,
                        cust_code: cust_code
                    }
                })
                .done(function(msg) {            
                  $('#projid').val(projectid);
                  $('#projemail').val(projectemail);                  
				  alert(msg);
                  
                });
				
		 }else{
		  
		   return false;
		 
		 }
		 
       });
	
	
});

function saveprojectinfo(baseUrl, cust_code, id, email)
{
    var projectid = jQuery("#" + id).val();
    var projectemail = jQuery("#" + email).val();
    var cust_code = jQuery("#" + cust_code).val();
    if (projectid == '')
    {
        alert("Please enter Project Id.");
        return false;
    }

    else if (projectemail == '')
    {
        alert("Please enter Project Specific Email.");
        return false;
    }
    else {
        if ((validateEmail(projectemail)) && (validateProjectId(projectid))) {
            $("#Button1").hide();
            $("#load_img").show();
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "costing/saveprojectdata",
                data: {projectid: projectid, projectemail: projectemail, cust_code: cust_code}
            })
                    .done(function(msg) {
                $("#load_img").hide();
                $("#error_msg_div").show();
                $("#error_msg_div").fadeOut(9000);
                $("#Button1").show();
            });
        }
    }
}
function validateEmail(emailText) {
    var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
    if (pattern.test(emailText)) {
        return true;
    } else {
        alert('Invalid format for Email address : ' + emailText);
        return false;
    }
}
function validateProjectId(project_id)
{
    var z = project_id;
    if (!z.match(/^\d+/))
    {
        alert("Please enter only numeric value for Project Id.")
        return false;
    }
    else {
        return true;
    }
}

function remove_me(sno,dsno){      
       jQuery.ajax({
            type: "POST",
            url: "deleteMilestone",
            data: {
                sno: sno,
                dsno: dsno
            }
        })
        .done(function(msg) {            
          alert(msg);
          window.setTimeout('location.reload()',true);
        });
 }