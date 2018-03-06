function hide_show(val){
	   var counter = $('#counter').val();
	   if(val=='Doc'){
		 $('#upload_material_1').show();
		 $('#static_link_1').hide();
		 for(var i = 2;i<=counter;i++){
		   $('table#master_table tr#static_link_'+i).remove();
		   $('#count_num').val('1');
		 }

		}else {
		   $('#static_link_1').show();
		   $('#upload_material_1').hide();
		 for(var i = 2;i<=counter;i++){
		   $('table#master_table tr#upload_material_'+i).remove();
		   $('#count_num').val('1');
		 }
		
		}
	}

 function add_new_row(){
	var counter = $('#counter').val();
	counter = parseInt(counter)+1;
	$( "#add_more" ).before('<tr id="upload_material_'+counter+'"><td height="30" style="width:10px;">&nbsp;</td><td height="30" style="width:100px;"><strong>&nbsp;</strong></td><td style="width:240px;"><input type="file" id="CoursemasterVcFileName" name="data[CourseMasterDetail][vc_file_name_'+counter+']"></td><td height="30" style="width:10px;">&nbsp;</td><td height="30" style="width:168px;"><input type="text" id="vc_file_version'+counter+'" class="round_select" name="data[CourseMasterDetail][vc_file_version_'+counter+']"></td><td height="30" style="width:100px;"><input type="button" value="REMOVE" onclick="remove_row('+counter+')" name="remove_btn_'+counter+'"/></td></tr>');
    $('#counter').val(counter);
  }
	
  function remove_row(row_id){
 
	if (confirm("Are you sure ?")) {
		   $('table#master_table tr#upload_material_'+row_id).remove();
	}else {    
		return false; // prevents default behavior
	}
  }
	
  function updateAdd(){
  
  var counter = $('#counter').val();
	counter = parseInt(counter)+1;
	$( "#add_more" ).before('<tr class="cont" id="upload_material_3"><td height="30" colspan="3"><input type="file" id="CoursemasterVcFileName" name="data[CourseMasterDetail][vc_file_name_'+counter+']"></td><td height="30"><input type="text" id="vc_file_version'+counter+'" class="round_select" name="data[CourseMasterDetail][vc_file_version_'+counter+']"></td><td height="30" colspan="2" style="width:100px;"><input type="button" value="REMOVE" onclick="remove_row('+counter+')" name="remove_btn_'+counter+'"/></td></tr>');
    $('#counter').val(counter);
	
  }
  
  function updateRemove(row_id,docID,filename){
 
    remove_row(row_id);
		$.post('',{docID:docID,filename:filename},function(data){
				alert('Document deleted successfully.');
		});
	}
	
function formValidate(){

$skill = $('#SkillMasterVcSkill').val();

 var $error='';

if($skill==''){

$error+="Please Fill skill.\n"
			
}
  if ($error== ''){

		 }else {
				 alert($error);
				 return(false);
	 }		

}