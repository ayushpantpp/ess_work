
function QuarterType(quarterValue,quarterType)
{
    if(quarterType=='quarter-1')
    {critical_q1
        $("#quarter-1-MR-1").css('display','');
        $("#quarter-2-MR-2").css('display','none');
        $("#quarter-3-MR-3").css('display','none');
        $("#quarter-4-MR-4").css('display','none');
        
        $("#critical_q1").css('display','');
        $("#critical_q2").css('display','none');
        $("#critical_q3").css('display','none');
        $("#critical_q4").css('display','none');
        
        $("#focus_q1").css('display','');
        $("#focus_q2").css('display','none');
        $("#focus_q3").css('display','none');
        $("#focus_q4").css('display','none');
        
        $("#remark_q1").css('display','');
        $("#remark_q2").css('display','none');
        $("#remark_q3").css('display','none');
        $("#remark_q4").css('display','none');
    }
    else if(quarterType=='quarter-2')
    {
         $("#quarter-2-MR-2").css('display','');
         $("#quarter-1-MR-1").css('display','none');
         $("#quarter-3-MR-3").css('display','none');
         $("#quarter-4-MR-4").css('display','none');
         
        $("#critical_q1").css('display','none');
        $("#critical_q2").css('display','');
        $("#critical_q3").css('display','none');
        $("#critical_q4").css('display','none');
        
        $("#focus_q1").css('display','none');
        $("#focus_q2").css('display','');
        $("#focus_q3").css('display','none');
        $("#focus_q4").css('display','none');
        
        $("#remark_q1").css('display','none');
        $("#remark_q2").css('display','');
        $("#remark_q3").css('display','none');
        $("#remark_q4").css('display','none');
    }
    else if(quarterType=='quarter-3')
    {
         $("#quarter-3-MR-3").css('display','');
         $("#quarter-2-MR-2").css('display','none');
         $("#quarter-1-MR-1").css('display','none');
         $("#quarter-4-MR-4").css('display','none');
         
        $("#critical_q1").css('display','none');
        $("#critical_q2").css('display','none');
        $("#critical_q3").css('display','');
        $("#critical_q4").css('display','none');
        
        $("#focus_q1").css('display','none');
        $("#focus_q2").css('display','none');
        $("#focus_q3").css('display','');
        $("#focus_q4").css('display','none');
        
        $("#remark_q1").css('display','none');
        $("#remark_q2").css('display','none');
        $("#remark_q3").css('display','');
        $("#remark_q4").css('display','none');
    }
    else if(quarterType=='quarter-4')
    {
         $("#quarter-4-MR-4").css('display','');
         $("#quarter-2-MR-2").css('display','none');
         $("#quarter-1-MR-1").css('display','none');
         $("#quarter-3-MR-3").css('display','none');
         
        $("#critical_q1").css('display','none');
        $("#critical_q2").css('display','none');
        $("#critical_q3").css('display','');
        $("#critical_q4").css('display','none');
        
        $("#focus_q1").css('display','none');
        $("#focus_q2").css('display','none');
        $("#focus_q3").css('display','none');
        $("#focus_q4").css('display','');
        
        $("#remark_q1").css('display','none');
        $("#remark_q2").css('display','none');
        $("#remark_q3").css('display','none');
        $("#remark_q4").css('display','');
    }
	

}

/*============================ ADD THE CONTRACT PAGE FOR LISTING THE EMPLOYEES FOR REGION HAED,GM,PM,SQA HEAD ============================*/		
        function ShowListingTypeEmployees(url,type) 
        {    
            var searchItm = jQuery("#"+type+'_name').val();
           
            if(searchItm.length>0)
             {		
                        var typeName = type+'_name';
                        var typeID = type+'_id';
                        jQuery('#'+typeID).val(''); 
                        $("#loader_"+type).empty().html("<img src='../img/ajax-loader.gif' style='height:20px;'/>");
                        jQuery( "#"+typeName).autocomplete({
                        source: 'autosuggestion',
                        minLength: 1,
                        select: function( event, ui ) {
                            jQuery('#'+typeID).attr('value', ui.item.id);
                            $("#loader_"+type).empty().html();
                        },
                        open: function() {
                                        jQuery(".ui-autocomplete").css('max-height','400px');
                                        jQuery(".ui-autocomplete").css('overflow','auto');
                        },
                        close: function() {
                            jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                        }
                    });
                    jQuery('#'+typeName).change(function(){
                        if(jQuery('#'+typeName).val().length == 0 )
                            jQuery('#'+typeName).attr('value','');
                    });
	   }
    }
    
    function auto_cust_name()
    {
        var region_id =$("#region_id").val();
	var year =$("#year").val();
	var msg='';
        if(region_id=='')
        {
           msg+="Please select the Region.\n"  ;
        }
        if(year=='')
        {
            msg+="Please select the Year.\n"  ;
        }  
	if (msg== '')
        {
                var url ='';
                jQuery(document).ready(function()
                {
                    $("#loader_cust").empty().html("<img src='../img/ajax-loader.gif' style='height:20px;'/>");
                    jQuery( "#vc_project_name").autocomplete({
                            source:'projectlisting?region_id='+region_id+'&year='+year,
                            minLength: 2,
                           select: function( event, ui ) {
                                            jQuery('#projectNameID').attr('value', ui.item.id);
                                            $("#loader_cust").empty().html();
                            },
                            open: function() {
                                            jQuery(".ui-autocomplete").css('max-height','400px');
                                            jQuery(".ui-autocomplete").css('overflow','auto');
                            },
                            close: function() {
                                            jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                            }
                         });
                });
	}else {
                 $("#vc_project_name").val('');
		 alert(msg);
		 return(false);
              }
	 
  }
  
    function addsubmitcategory(val)
    {
        var check = vaildationprojectcategoryFrom();
       
        if(check==false)
        {
              return false;
        }else{ 
        $("#status").val(val);
        $('#ProjectCategoryAddFormId').submit();
        return true;
        }
     }
     
     function editsubmitcategory(val)
    {
        var check = vaildationprojectcategoryFrom();
       
        if(check==false)
        {
              return false;
        }else{ 
        $("#status").val(val);    
        $('#ProjectCategoryEditFormId').submit();
        return true;
        }
     }
     
     
     
     function vaildationprojectcategoryFrom()
     {
           var regionId             = $("#region_id").val();
           var projectname          = $("#vc_project_name").val();
           var projectid            = $("#projectNameID").val();
           var categoryid           = $("#category_id").val();
           var regionheadname       = $("#reg_head_name").val();
           var regionheadid         = $("#reg_head_id").val();
           
           var regexp =/^[0-9]+$/;
           var error        ='';
           if(regionId == '')
            {
                error="Please select region !\n"  ;
                alert(error);
                return false;
            }else if(projectname =='' ||  projectid=='')
            {
                error="Please select project !\n"  ;
                alert(error);
                return false;
            }else if(categoryid == '')
            {
                error="Please select category !\n"  ;
                alert(error);
                return false;
            }else if(regionheadname =='' || regionheadid=='')
            {
                error="Please select region head !\n"  ;
                alert(error);
                return false;
            }   
            
            if($("#q1-jan-id").val()!='')
            {      
                if(!regexp.test($("#q1-jan-id").val()))
                  {
                      error="Please enter jan month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
           }
           if($("#q1-feb-id").val()!='')
               {
                   if(!regexp.test($("#q1-feb-id").val()))
                  {
                      error="Please enter feb month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
           if($("#q1-mar-id").val()!='')
               {
                   if(!regexp.test($("#q1-mar-id").val()))
                  {
                      error="Please enter mar month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
           if($("#q2-apr-id").val()!='')
               {
                   if(!regexp.test($("#q2-apr-id").val()))
                  {
                      error="Please enter apr month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
           if($("#q2-may-id").val()!='')
               {
                   if(!regexp.test($("#q2-may-id").val()))
                  {
                      error="Please enter may month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
            if($("#q2-jun-id").val()!='')
               {
                   if(!regexp.test($("#q2-jun-id").val()))
                  {
                      error="Please enter jun month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
             if($("#q3-jul-id").val()!='')
               {
                   if(!regexp.test($("#q3-jul-id").val()))
                  {
                      error="Please enter jul month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
             if($("#q3-aug-id").val()!='')
               {
                   if(!regexp.test($("#q3-aug-id").val()))
                  {
                      error="Please enter aug month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
             if($("#q3-sep-id").val()!='')
               {
                   if(!regexp.test($("#q3-sep-id").val()))
                  {
                      error="Please enter sep month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
               
            if($("#q4-oct-id").val()!='')
               {
                   if(!regexp.test($("#q4-oct-id").val()))
                  {
                      error="Please enter oct month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
             if($("#q4-nov-id").val()!='')
               {
                   if(!regexp.test($("#q4-nov-id").val()))
                  {
                      error="Please enter nov month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
             if($("#q4-dec-id").val()!='')
               {
                   if(!regexp.test($("#q4-dec-id").val()))
                  {
                      error="Please enter dec month(Positive Integer Number) !\n"  ;
                      alert(error);
                      return false;
                  }
               }
     }
	
 function searchinglisting(val)
    {
       
        var check = vaildationsearchFrom();
       
        if(check==false)
        {
              return false;
        }else{ 
        if(val=='editsearch')
        {
           var regionId             = $("#region").val();
           var year                 = $("#calendar_year").val();
           var projectid            = $("#nu_project_id").val();
            $.ajax({
                        type: 'POST',
                        data: {regionId:regionId,year:year,projectid:projectid},
                        url: "commentsearch",
                        success: function(data) {
                        data = $.parseJSON(data);
                        
                        if(data.vc_approval_status =='R')
                            {
                                $('#cmnt').val(data.vc_comment);
                                $('#editcomment').dialog('open');
                                 return false;
                            }else{
                                $('#ProjectCategoryEditSearchFormId').submit(); 
                                 return true;
                            }
                    }
        }); 
           
           
        }else if(val=='viewsearch')
        {
             $('#ProjectCategoryViewSearchFormId').submit();
             return true;
        }else if(val=='approvalsearch')
            {
                 $('#ProjectCategoryApprovalSearchFormId').submit();
                 return true;
            }
        else{
               return false; 
            }
        }
     }
     
    function vaildationsearchFrom()
    {
           var regionId             = $("#region").val();
           var year                 = $("#calendar_year").val();
           var projectid            = $("#nu_project_id").val();
           var error        ='';
           
           if(regionId ==0)
            {
               error+="Please select region !\n"  ;
            }
            if(year==0)
            {
               error+="Please select year !\n"  ;
            }
            if(projectid==0)
            {
               error+="Please select project !\n"  ;
            }
            if(error=='')
             {
                 return true;
             }else{
                 alert(error);
                 return false;
             }   
  }

function sanctionsubmitcategory(val)
    {
        var check = vaildationprojectcategoryFrom();
       
        if(check==false)
        {
              return false;
        }else{ 
                $("#status").val(val);   
                if(val=='R')
                {   
                    $('#dialog').dialog('open');
                    return false;
                }else{
                     $('#ProjectCategoryEditSanctionFormId').submit();
                }
        return true;
        }
     }


$(function(){

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal:true,
            buttons: {
                "Ok": function() {
                    var cmnt=$('#cmnt').val();
                    if(cmnt==' ')
                    {     $('#errdis').show('slow', function() {
                            // Animation complete.
                        });
                        return false;

                    }else{
                        $(this).dialog("close");
                        $('#ProjectCategoryEditSanctionFormId').submit();
                    }

                },
                "Cancel": function() {
                    $("#cmnt").val('');
                    $(this).dialog("close");
                }
            }
        });


    });
    
     function getcmtval()
    {
        var rejno=document.getElementById("cmnt").value;
        var rjres=document.getElementById("rejectres").value=rejno;

    }
    
    function LisingProjectPlan(regionId)
    {
        if(regionId == '')
        {
            error="Please select region !\n"  ;
            alert(error);
            return false;
        }
      var acturl = $("#typeurl").val();
        $.ajax({
            type: 'POST',
            data: {regionId:regionId},
            url: acturl,
            success: function(data) {
                $("#PTP").html(data);
                $("#typeurl").val(acturl);
            }
        });
    }


$(function(){

        // Dialog
        $('#editcomment').dialog({
            autoOpen: false,
            width: 600,
            modal:true,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                     $('#ProjectCategoryEditSearchFormId').submit(); 
                    
                 },
                "Cancel": function() {
                   
                    $(this).dialog("close");
                }
            }
        });


    });