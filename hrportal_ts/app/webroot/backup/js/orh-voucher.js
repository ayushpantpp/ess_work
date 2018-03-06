function toggle_visibility(tbid, lnkid, idxx)
{
    var obj = document.getElementById("expand_collapse" + idxx).getElementsByTagName("table");
    for (i = 0; i < obj.length; i++)
    {
        if (obj[i].id && obj[i].id != tbid)
        {
            document.getElementById(obj[i].id).style.display = "none";
            x = obj[i].id.substring(3);
            document.getElementById("lnk" + x).value = "[+]";
        }
    }
    if (document.all) {
        document.getElementById(tbid).style.display = document.getElementById(tbid).style.display == "block" ? "none" : "block";
    }
    else {
        document.getElementById(tbid).style.display = document.getElementById(tbid).style.display == "table" ? "none" : "table";
    }
    document.getElementById(lnkid).value = document.getElementById(lnkid).value == "[-]" ? "[+]" : "[-]";
}

jQuery(document).ready(function() {
    jQuery('#Voucherexpdate, #Voucherpaydate').datepicker({'dateFormat': 'dd-mm-yy'});
    $("#VoucherStartdate").datepicker({
        'dateFormat': 'dd-mm-yy',
        numberOfMonths: 1,
        onSelect: function(selected) {

            $("#VoucherEnddate").datepicker("option", "minDate", selected)

        }

    });

    $("#VoucherEnddate").datepicker({
        'dateFormat': 'dd-mm-yy',
        numberOfMonths: 1,
        onSelect: function(selected) {
            $("#VoucherStartdate").datepicker("option", "maxDate", selected)

        }

    });
   

});




/* START HERE=========CHECKED THE CHECKBOX DISPLAY SANCTION, PENDING AMOUNT  AND TOTAL AMOUNT AND CALCULATE  ========================= */  
function cbChanged(checkboxElem,chkval) {
    
  if (checkboxElem.checked) {
       $("#billstatusdroplist-"+chkval).css('display','');
       $("#billstatus-"+chkval).css('display','none');
       
       $("#inputsanctionamount-"+chkval).css('display','');
       $("#sanctionamount-"+chkval).css('display','none');
    // Do something special
  } else {
      $("#billstatusdroplist-"+chkval).css('display','none');
       $("#billstatus-"+chkval).css('display','');
       
       $("#inputsanctionamount-"+chkval).css('display','none');
       $("#sanctionamount-"+chkval).css('display','');
       
       $("#inputsanctionamount-"+chkval).val('0');
       var pendhiddval=$("#pendingamount-hidd-"+chkval).val();
       $("#pendingamount-"+chkval).text(pendhiddval);
       
        $("#pendingamount-hidd-final-"+chkval).val(pendhiddval);
    // Do something else
  }
  
          var sum=0;
          
          $('input:checked[name=checkdelname[]]').each(function(){
              
              inputchkval =$(this).val();
              var penamt= $("#inputsanctionamount-"+inputchkval).val()
             
                sum=parseFloat(sum)+parseFloat(penamt);
            })
       
        $("#total-amount").text(sum);
        $("#total-amount-hidd").val(sum);
         calculateTransctionValue();
}
/* END HERE=========CHECKED THE CHECKBOX DISPLAY SANCTION, PENDING AMOUNT  AND TOTAL AMOUNT AND CALCULATE  ========================= */  



/* START HERE=========VALDATION ONLY POSTIVE NUMBER ========================= */  
checkDecimalValue = function(evt) {
        evt = (evt) ? evt : window.event;

        var charCode = (evt.which) ? evt.which : evt.keyCode;
       //alert(charCode);
        if (charCode > 31 && (charCode < 46 || charCode > 57))
        {
            return false;
        }

        status = "";
        return true;
    }
  /* END HERE==========VALDATION ONLY POSTIVE NUMBER ========================= */    
    
    
    
  /* START HERE=========CHECKED THE CHECKBOX SANCTION, PENDING AMOUNT  AND TOTAL AMOUNT CALCULATE ========================= */  
     function calculateSanctionValue(chkval){
         var sactid     ="inputsanctionamount-"+chkval;
         var pendingid  ="pendingamount-"+chkval;
         var pendinghiddid  ="pendingamount-hidd-"+chkval;
         
         var sactval    =$("#"+sactid).val();
         var pendinghiddval = $("#"+pendinghiddid).val();
      
      
      if(parseFloat(pendinghiddval)>=parseFloat(sactval))
       {
           var remaindingpendingval=parseFloat(pendinghiddval)-parseFloat(sactval);
           $("#"+pendingid).html(remaindingpendingval);
           
           $("#pendingamount-hidd-final-"+chkval).val(remaindingpendingval);
          
       }else{
           alert("less than the amount.");
           $("#"+sactid).val('0');
           $("#"+pendingid).html(pendinghiddval);
           $("#pendingamount-hidd-final-"+chkval).val(pendinghiddval);
       }   
         
          var sum=0;
          var inputchkval;
          $('input:checked[name=checkdelname[]]').each(function(){
              
              inputchkval =$(this).val();
              var penamt= $("#inputsanctionamount-"+inputchkval).val();
             
                sum=parseFloat(sum)+parseFloat(penamt);
            });
       
        $("#total-amount").text(sum);
        $("#total-amount-hidd").val(sum);
        
         calculateTransctionValue();
         if(parseFloat(pendinghiddval)>=parseFloat(sactval))
          {
              
          }  else{
              
           return false;
          } 
}
/* END HERE=========CHECKED THE CHECKBOX SANCTION, PENDING AMOUNT  AND TOTAL AMOUNT CALCULATE========================= */


      
/* START HERE=========CURRENCY RATE CALCUTATE ========================= */
function calculateTransctionValue()
{
    if($('#booking_rate').val()=='')
        {
            var str =1;
        }else{
            var str = $('#booking_rate').val();
        }

        var str1 = $('#total-amount-hidd').val();
        var str3 = (str * str1).toFixed(2);
        $('#payment_in_inr').val(str3);

}
 /* END HERE=========CURRENCY RATE CALCUTATE ========================= */



/* START HERE=========QUERY DISPLAY THE POPUP AND DEFINE CODE========================= */
function queryAccountBillDetails(voucherId, regionalId, billid, url)
{
    $("#loading_div3").empty();
    $("#getdetail3").empty().html('<img src="'+url+'img/ajax-loader1.gif" />');
    $('#getdetail3').load(url+'orhquery/showaccountbillquery/'+voucherId+'/'+regionalId+'/'+billid);
    jQuery('#dialog3sw').dialog('open');
}
$(function(){
     $('#dialog3sw').dialog({
                                autoOpen: false,
                                title: "Query",
                                width: 540,
                                maxHeight:500,
                                position:'top',
                                modal:true,
                                buttons: {
//                                "Submit": function() {
//                                    if($("#QueryVcQueries").val()=="")
//                                    {
//                                        alert("Please enter query");
//                                        $("#QueryVcQueries").focus();
//                                        return false;
//                                    }
//                                        $("#loading_div3").empty().html('<img src="../img/ajax-loader1.gif" />');
//                                        $.post('accountbilldetails', $("#VoucherShowaccountbillqueryForm").serialize(), function(data){
//                            jQuery('#dialog3sw').dialog('close');
//                             window.location.reload();
//                            
//                        });
//                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
    });




/* START HERE=========QUERY DISPLAY THE POPUP AND DEFINE CODE========================= */
function queryAccountDetails(voucherId, regionalId, url)
{
    $("#loading_div2").empty();
    $("#getdetail2").empty().html('<img src="'+url+'img/ajax-loader1.gif" />');
    $('#getdetail2').load(url+'orhquery/showaccountquery/'+voucherId+'/'+regionalId);
    jQuery('#dialog2sw').dialog('open');
}

 $(function(){


            $('#dialog2sw').dialog({
                                autoOpen: false,
                                title: "Query",
                                width: 540,
                                maxHeight:500,
                                position:'top',
                                modal:true,
                                buttons: {
//                                "Submit": function() {
//                                    if($("#QueryVcQueries").val()=="")
//                                    {
//                                        alert("Please enter query");
//                                        $("#QueryVcQueries").focus();
//                                        return false;
//                                    }
//                                        $("#loading_div2").empty().html('<img src="../img/ajax-loader1.gif" />');
//                                        $.post('accountdetails', $("#VoucherShowaccountqueryForm").serialize(), function(data){
//                            jQuery('#dialog2sw').dialog('close');
//                             window.location.reload();
//                            
//                        });
//                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
    });
    
 /* END HERE=========QUERY DISPLAY THE POPUP AND DEFINE CODE========================= */
 
 function checksubmit1()
 {
      var chkboxleng = $('[name="checkdelname[]"]:checked').length;
      
      if(chkboxleng > 0)
       {
//           if($("#expense_voucher_no").val()=='')
//            {
//                alert("Please enter expense voucher number.");
//             return false;
//            }else if($("#Voucherexpdate").val()=='')
//            {
//                alert("Please enter voucher expense date.");
//             return false;
//            }else if($("#payment_voucher_no").val()=='')
//            {
//                alert("Please enter payment voucher number.");
//             return false;
//            }else if($("#Voucherpaydate").val()=='')
//            {
//                alert("Please enter payment voucher date.");
//             return false;
//            }else if($("#booking_rate").val()=='')
//            {
//                alert("Please enter booking rate.");
//             return false;
//            }
             $("#overlay").show();
             
           $('#VoucherVoucherAccountForm').submit();
            return true;
          
            
       }else{
           alert("Please check atleast one bill.");
             return false;
       }   
     
 }
 
 
  $(function(){

        // Dialog
        $('#dialog4sw').dialog({
            autoOpen: false,
            title: "Bill Details",
            width: 800,
            maxHeight:500,
            position:'top',
            modal:true,
            buttons: {


                "Cancel": function() { $(this).dialog("close"); }
            }
        });
   });
   
   function accountBillDownload(billid,url)
    {
        $("#loading_div4").empty();
        $("#getdetail4").empty().html('<img src="'+url+'img/ajax-loader1.gif" />');
        $('#getdetail4').load(url+'voucher/showaccountbillinfo/'+billid);
        jQuery('#dialog4sw').dialog('open');
    }