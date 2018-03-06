$('document').ready(function(){

      $("#save-sheet").click(function() {                  
             $("#project-value").submit();
        });
function delaynoofdayscalculate(Rowid)
 {
     if($("#planned-end-date-tab2-"+Rowid).val()!='' && $("#actual-end-date"+Rowid).val() !='')
       {
            var dt2 = ($("#planned-end-date-tab2-"+Rowid).val()).split("-");
            var dt1 = ($("#actual-end-date"+Rowid).val()).split("-");
             //Total time for one day

                var one_day = 1000 * 60 * 60 * 24;

                var date1 = new Date(dt1[2], (dt1[1] - 1), dt1[0]);
               
                var date2 = new Date(dt2[2], (dt2[1] - 1), dt2[0])

                var month1 = dt1[1];
                var month2 = dt2[1];

                var diff1 = Math.ceil((date2.getTime() - date1.getTime()) / (one_day));
               
                diff1 = (isNaN(diff1)) ? '0' : diff1;
                $("#delay_row_input_"+Rowid).val(diff1);
              } else {
                $("#delay_row_input_"+Rowid).val(0);
            }
            
            totaldelaypersondays();
    }

/*======== Start Here First Row ==========================*/

function firstrowdatepicker()
{
   $('input').filter('.datepicker').datepicker({
    dateFormat: 'dd-mm-yy', 
    changeMonth: true,
    changeYear: true,
   "onSelect":function(selected){
                                   /*====== Start Here Plan Start Date Tab 1 Milestone Definition=============*/
                                    var plannedstartdatepatt = new RegExp("planned-start-date");
                                    var res1 = plannedstartdatepatt.test($(this).attr('id'));
                                   
                                    if(res1==true)
                                    {
                                         var Rowid = parseInt($(this).attr('id').split("planned-start-date")[1], 10); 
                                         var startdate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                         $('#planned-start-date-tab2-'+Rowid).val(startdate);
                                         $("#planned-end-date"+Rowid).datepicker("option", "minDate", selected);
                                         $("#planned-end-date-tab2-"+Rowid).datepicker("option", "minDate", selected);
                                    
                                    }
                                   /*====== End Here Plan Start Date Tab 1 Milestone Definition=============*/
                                   
                                   
                                   
                                   
                                   
                                   
                                    /*====== Start Here Plan End Date Tab 1 Milestone Definition=============*/
                                    var plannedenddatepatt = new RegExp('planned-end-date');
                                    var res2 = plannedenddatepatt.test($(this).attr('id'));
                                    
                                    /*====== Start Here Plan Start Date Tab2 Plan VS Actual=============*/
                                    var plannedenddatetab2 = new RegExp('planned-end-date-tab2-');
                                    var res4 = plannedenddatetab2.test($(this).attr('id'));
                                    
                                    /*====== End Here Plan Start Date Tab2 Plan VS Actual=============*/
                                    if(res4==true)
                                    {
                                        var Rowid = parseInt($(this).attr('id').split("planned-end-date-tab2-")[1], 10); 
                                        var enddate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                        $('#planned-end-date'+Rowid).val(enddate);
                                        $("#planned-start-date"+Rowid).datepicker("option", "maxDate", selected);
                                        $("#planned-start-date-tab2-"+Rowid).datepicker("option", "maxDate", selected);
                                        delaynoofdayscalculate(Rowid);
                                    }else  if(res2==true)
                                    {
                                        var Rowid = parseInt($(this).attr('id').split("planned-end-date")[1], 10); 
                                        var enddate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                        $('#planned-end-date-tab2-'+Rowid).val(enddate);
                                        $("#planned-start-date"+Rowid).datepicker("option", "maxDate", selected);
                                        $("#planned-start-date-tab2-"+Rowid).datepicker("option", "maxDate", selected);
                                        delaynoofdayscalculate(Rowid);
                                    }
                                   /*====== End Here Plan end Date Tab 1 Milestone Definition=============*/
                                     
                                     
                                    /*====== Start Here Plan Start Date Tab2 Plan VS Actual=============*/
                                    var plannedstartdatetab2 = new RegExp('planned-start-date-tab2-');
                                    var res3 = plannedstartdatetab2.test($(this).attr('id'));
                                    if(res3==true)
                                    {
                                         var Rowid = parseInt($(this).attr('id').split("planned-start-date-tab2-")[1], 10); 
                                         var startdate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                         $('#planned-start-date'+Rowid).val(startdate);
                                         $("#planned-end-date"+Rowid).datepicker("option", "minDate", selected);
                                         $("#planned-end-date-tab2-"+Rowid).datepicker("option", "minDate", selected)
                                    }
                                    /*====== End Here Plan Start Date Tab2 Plan VS Actual=============*/
                                    
                                    
                                    
                                    
                                    
                                    /*====== Start Here Actual Start Date Tab3 Plan VS Actual=============*/
                                    var actualstartdate = new RegExp('actual-start-date');
                                    var res5 = actualstartdate.test($(this).attr('id'));
                                    if(res5==true)
                                    {
                                        var Rowid = parseInt($(this).attr('id').split("actual-start-date")[1], 10); 
                                        $("#actual-end-date"+Rowid).datepicker("option", "minDate", selected);
                                    }
                                    /*====== End Here Actual Start Date Tab3 Plan VS Actual=============*/
                                    
                                    
                                    /*====== Start Here Actual End Date Tab3 Plan VS Actual=============*/
                                     var actualenddate = new RegExp('actual-end-date');
                                     var res6 = actualenddate.test($(this).attr('id'));
                                    if(res6==true)
                                    {
                                        var Rowid = parseInt($(this).attr('id').split("actual-end-date")[1], 10); 
                                        $("#actual-start-date"+Rowid).datepicker("option", "maxDate", selected);
                                        delaynoofdayscalculate(Rowid);
                                    }
                                    /*====== End Here Actual End Date Tab3 Plan VS Actual=============*/
                                    
                                   
   }
   });
}

/* ======= first time loading datepicker =================*/
    firstrowdatepicker();
    
   

/*======== Strat here milestone name==================*/

function milestonecopythevalue()
    {
        $("input[class^='milestone-name-row-']").keyup(function() {  
                var getclassname = $(this).attr('class');
                var getvalue = $(this).val();
                $("."+getclassname).val(getvalue);
        });
    }
    
    milestonecopythevalue();
 /*======== End here milestone name==================*/   
 
 
 
 
 /*======== Strat here milestone name==================*/

function budgetmandaycopythevalue()
    { 
       // var SumbudgetMancostA=0;
        $("input[class^='budgeted-man-days-']").keyup(function() {  
                var getclassname = $(this).attr('class');
                var getvalue = $(this).val();
                $("."+getclassname).val(getvalue);
                
                 var Rowid = parseInt($(this).attr('class').split("budgeted-man-days-")[1], 10);
                 var perchnageval= parseFloat((parseFloat(getvalue) / parseFloat($("#effort").val())) *100);
                 
                 perchnageval=(!isFinite(perchnageval))?0:perchnageval;   
                 
                 $("#percentage-of-work-"+Rowid).val(perchnageval.toFixed(2));
                 var budgetedcostaspermanday =  $("#mcost").val()*getvalue;
                 $("#budgeted_cost_as_per_mandays_"+Rowid).val(budgetedcostaspermanday.toFixed(2));
                 total_percentage_work();
                 //SumbudgetMancostA =parseFloat(SumbudgetMancostA)+ parseFloat(budgetedcostaspermanday);
                //  alert(SumbudgetMancostA);
                initCost();
        });
       
       //  $('#totA').val(SumbudgetMancostA.toFixed(2));
       //  $('#gdTotal_A').val(SumbudgetMancostA.toFixed(2));
    }
    
    budgetmandaycopythevalue();
 /*======== End here milestone name==================*/   
    
/*======== End Here First Row ==========================*/
var i= $("#countrownum").val();
 //   var i=1;
 
 $('#addmore').click(function(){
     
 $( "#milestone fieldset > ul > li:even").css( "background-color", "#dce5ed");
 $( "#milestone fieldset > ul > li:odd").css( "background-color", "#ecf1f5");

     /* Start Here add function for row */  
     
     $('.milestoneulclass').each(function(){
         /* clone for used then datepicker destroy */
         $('.datepicker').datepicker('destroy');
         var att=$(this).find('li').first().clone(true).addClass('lidelete'+i);
         
         att.find('input').val('');
         
         /*========== Start here Name Index define =========================*/
          att.find('input, select').each(function(){
                var name;
                name = $(this).attr('name');
                name = name.replace(/\[[0-9]+\]/g, '['+i+']');
                $(this).attr('name',name);
              });
         /*========== End here Name Index define =========================*/
         $(this).append(att);
     });
   /* End Here add function for row */  
     
    /* Start Here delete function for row */  
    
    $(".actions").unbind('click');
    $(".actions").bind('click',function(){        
         $('.'+$(this).closest('ul').parent('li').attr('class')).remove();
         calculate_budgeted_man_days();
         //total_percentage_work();
         //initCost();
         totaldelaypersondays();
         calculatesumrelizationtab4();

     });
     
    /* End Here delete function for row */  
     
     createtheIDandClass(i)
     
     
     /* Start Here datepicker function */
     
     datepicker(i);
        
     /* End Here datepicker function */
     i++;
 });

 $(".actions").bind('click','a',function(){
     alert('Not able to remove');
 });
 

 /*==== End here add class for muliple row =============================*/
 
 function createtheIDandClass(i)
 {
      /*====== Tab 1 ================================================*/
      $( ".lidelete"+i +" > ul > li.limilestone input").attr('class', 'milestone-name-row-'+i);
      $( ".lidelete"+i +" > ul > li.PercentageOfWorkli input").attr('id', 'percentage-of-work-'+i);
      $( ".lidelete"+i +" > ul > li.ExpectedMonthlyRealisationli input").attr('id', 'expe-month-relisation-'+i);
      $( ".lidelete"+i +" > ul > li.TaskCompletedli select").attr('id', 'task-completed-'+i);
      /*====== Tab 1 ================================================*/
       
      /*====== Tab 2 ================================================*/
       $( ".lidelete"+i +" > ul > li.delayli input").attr('id', 'delay_row_input_'+i);
      /*====== Tab 2 ================================================*/
      
      /*====== Tab 3 ================================================*/
      $( ".lidelete"+i +" > ul > li.BudgetedMandaysli input").attr('class', 'budgeted-man-days-'+i);
      $( ".lidelete"+i +" > ul > li.budgetedcostaspermandaysli input").attr('id', 'budgeted_cost_as_per_mandays_'+i);
      $( ".lidelete"+i +" > ul > li.ActualMandaysli input").attr('id', 'actual_man_days_'+i);
      $( ".lidelete"+i +" > ul > li.ActualCostli input").attr('id', 'actual_cost_'+i);
      /*====== Tab 3 ================================================*/
      
      
      /*====== Tab 4 ================================================*/
      $( ".lidelete"+i +" > ul > li.Due1li select[id^='due1-']").attr('id', 'due1-'+i);
      $( ".lidelete"+i +" > ul > li.ExpectedRealisationAgainstDeliveryli input").attr('id', 'expected-realisation-against-delivery-'+i);
      $( ".lidelete"+i +" > ul > li.Due2li select[id^='due2-']").attr('id', 'due2-'+i);
      $( ".lidelete"+i +" > ul > li.BillableAmountli input").attr('id', 'billable-ammount-'+i);
      $( ".lidelete"+i +" > ul > li.PaidAmountli input").attr('id', 'paid-amount-'+i);
      /*====== Tab 4 ================================================*/
       
      /*====== Tab 5 ================================================*/
      $( ".lidelete"+i +" > ul > li.BudgetCostvsActualCostli input").attr('id', 'budget-cost-vs-actual-cost-'+i);
      $( ".lidelete"+i +" > ul > li.OutstandingAmountli input").attr('id', 'outstanding-amount-'+i);
      $( ".lidelete"+i +" > ul > li.EstimationAccuracyli input").attr('id', 'estimation-accuracy-'+i);
      $( ".lidelete"+i +" > ul > li.PaidAmountVsActualCostli input").attr('id', 'paid-amt-vs-act-cost-'+i);
      /*====== Tab 5 ================================================*/
	 
	  //remove
	  
	  $(".lidelete"+i +"> ul > li.actions a").removeAttr( "onclick", '');
	  $(".lidelete"+i +"> ul > li.actions a").css( "display", '');
	  
      
 }
 
 
 /*==== End here add class class for muliple row =============================*/
 
 
 
 /*==== Strat here add id for datepicker case =============================*/
 function datepicker(i)
 {
      $( ".lidelete"+i +" > ul > li.planned-start-date input").attr('id', 'planned-start-date'+i).datepicker({ 
            dateFormat: 'dd-mm-yy', 
            changeMonth: true,
            changeYear: true, 
            "onSelect":function(selected){
                                    var Rowid = parseInt($(this).attr('id').split("planned-start-date")[1], 10); 
                                    var startdate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                    $('#planned-start-date-tab2-'+Rowid).val(startdate);
                                    $("#planned-end-date"+Rowid).datepicker("option", "minDate", selected);
                                    $("#planned-end-date-tab2-"+Rowid).datepicker("option", "minDate", selected)
                                 } 
     });
     
     $( ".lidelete"+i +" > ul > li.planned-end-date input").attr('id', 'planned-end-date'+i).datepicker({ 
             dateFormat: 'dd-mm-yy', 
            changeMonth: true,
            changeYear: true, 
            "onSelect":function(selected){
                                    var Rowid = parseInt($(this).attr('id').split("planned-end-date")[1], 10); 
                                    var enddate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                   $('#planned-end-date-tab2-'+Rowid).val(enddate);
                                    $("#planned-start-date"+Rowid).datepicker("option", "maxDate", selected);
                                    $("#planned-start-date-tab2-"+Rowid).datepicker("option", "maxDate", selected)
                                    delaynoofdayscalculate(Rowid);
                                 } 
      });
      
      $( ".lidelete"+i +" > ul > li.planned-start-date-tab2 input").attr('id', 'planned-start-date-tab2-'+i).datepicker({ 
             dateFormat: 'dd-mm-yy', 
            changeMonth: true,
            changeYear: true,
            "onSelect":function(selected){
                                    var Rowid = parseInt($(this).attr('id').split("planned-start-date-tab2-")[1], 10); 
                                    var startdate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                    $('#planned-start-date'+Rowid).val(startdate);
                                     $("#planned-end-date"+Rowid).datepicker("option", "minDate", selected);
                                    $("#planned-end-date-tab2-"+Rowid).datepicker("option", "minDate", selected)
                                 } 
      });
      
      $( ".lidelete"+i +" > ul > li.planned-end-date-tab2 input").attr('id', 'planned-end-date-tab2-'+i).datepicker({ 
             dateFormat: 'dd-mm-yy', 
            changeMonth: true,
            changeYear: true,
            "onSelect":function(selected){
                                    var Rowid = parseInt($(this).attr('id').split("planned-end-date-tab2-")[1], 10); 
                                     var enddate= $.datepicker.formatDate('dd-mm-yy', $(this).datepicker('getDate'));
                                    $('#planned-end-date'+Rowid).val(enddate);
                                     $("#planned-start-date"+Rowid).datepicker("option", "maxDate", selected);
                                    $("#planned-start-date-tab2-"+Rowid).datepicker("option", "maxDate", selected)
                                     delaynoofdayscalculate(Rowid);
                                 } 
      });
      
      $( ".lidelete"+i +" > ul > li.actual-start-date input").attr('id', 'actual-start-date'+i).datepicker({
        dateFormat: 'dd-mm-yy', 
        changeMonth: true,
        changeYear: true,
                "onSelect":function(selected){
                                    var Rowid = parseInt($(this).attr('id').split("actual-start-date")[1], 10); 
                                    $("#actual-end-date"+Rowid).datepicker("option", "minDate", selected);
                                 } 
      });
      
      $( ".lidelete"+i +" > ul > li.actual-end-date input").attr('id', 'actual-end-date'+i).datepicker({
        dateFormat: 'dd-mm-yy', 
        changeMonth: true,
        changeYear: true,
                  "onSelect":function(selected){
                                    var Rowid = parseInt($(this).attr('id').split("actual-end-date")[1], 10); 
                                    $("#actual-start-date"+Rowid).datepicker("option", "maxDate", selected);
                                     delaynoofdayscalculate(Rowid);
                                 } 
      });
      
      $( ".lidelete"+i +" > ul > li.revised-due-date input").attr('id', 'revised-due-date'+i).datepicker({ 
        dateFormat: 'dd-mm-yy', 
        changeMonth: true,
        changeYear: true,
       });
       
       $( ".lidelete"+i +" > ul > li.collection-due-date input").attr('id', 'collection-due-date'+i).datepicker({ 
        dateFormat: 'dd-mm-yy', 
        changeMonth: true,
        changeYear: true,
       });
       
       /* ======= destory datepicker after user loading datepicker =================*/
         firstrowdatepicker();
 }
/*==== End here add id for datepicker case =============================*/

$("input[id^='expe-month-relisation-'],input[id^='expected-realisation-against-delivery-']").on('keyup', function(event) {

    var Rowid = parseInt($(this).attr('id').split("expe-month-relisation-")[1], 10);
   if(!isNaN(Rowid))
     {
        Rowid=Rowid ;
     }else{
          var Rowid = parseInt($(this).attr('id').split("expected-realisation-against-delivery-")[1], 10);
     }  
     
    calculatebillamount(Rowid);
});
    
  $("select[id^='due1-'],select[id^='due2-']").on('change', function(event) {

    var Rowid = parseInt($(this).attr('id').split("due1-")[1], 10);
   if(!isNaN(Rowid))
     {
        Rowid=Rowid ;
     }else{
          var Rowid = parseInt($(this).attr('id').split("due2-")[1], 10);
     }  
     
    calculatebillamount(Rowid);
});  
    
function calculatebillamount(Rowid)
{
    var expmonrel =$("#expe-month-relisation-"+Rowid).val();
    if(!isNaN(expmonrel) && expmonrel !='')
     {
         expmonrel=expmonrel;
     } else{
         expmonrel=0;
     }  
     
     var expmonrelagdelv =$("#expected-realisation-against-delivery-"+Rowid).val();
     if(!isNaN(expmonrelagdelv) && expmonrelagdelv !='')
     {
         expmonrelagdelv=expmonrelagdelv;
     } else{
         expmonrelagdelv=0;
     }  
     
     if($("#due1-"+Rowid).val()=='Y')
      {
            expmonrel=expmonrel;
      }else{
          expmonrel=0;
      } 
      
      if($("#due2-"+Rowid).val()=='Y')
      {
             expmonrelagdelv=expmonrelagdelv;
      }else{
              expmonrelagdelv=0;
      } 
     var billamtrel = parseFloat(expmonrel)+parseFloat(expmonrelagdelv);
      $("#billable-ammount-"+Rowid).val(billamtrel.toFixed(2));
      
    calculatesumrelizationtab4();
      
}
       
function calculatesumrelizationtab4()
{
    var sumexrel =0; var sumexrelAgDil =0;
    var sumofB =0; var sumofC =0;
    var sumoutstandingCB=0;
       $("input[id^='expe-month-relisation-']").each(function() {
             var Rowid = parseInt($(this).attr('id').split("expe-month-relisation-")[1], 10);
             
            var emr = $("#expe-month-relisation-"+Rowid).val();
            if(!isNaN(emr) && emr !='')
            {
                emr=emr;
            } else{
                emr=0;
            } 
            var erad= $("#expected-realisation-against-delivery-"+Rowid).val();
             if(!isNaN(erad) && erad !='')
            {
                erad=erad;
            } else{
                erad=0;
            } 
            
            var billablamt = $("#billable-ammount-"+Rowid).val();
            if(!isNaN(billablamt) && billablamt !='')
            {
                billablamt=billablamt;
            } else{
                billablamt=0;
            } 
            var paidamt= $("#paid-amount-"+Rowid).val();
             if(!isNaN(paidamt) && paidamt !='')
            {
                paidamt=paidamt;
            } else{
                paidamt=0;
            } 
             sumexrel= parseFloat(sumexrel)+parseFloat(emr);
             
             sumexrelAgDil= parseFloat(sumexrelAgDil)+parseFloat(erad);
               
             sumofB= parseFloat(sumofB)+parseFloat(billablamt);
             
             sumofC= parseFloat(sumofC)+parseFloat(paidamt);
             
             var outstandingCB = parseFloat(paidamt)-parseFloat(billablamt);
             $("#outstanding-amount-"+Rowid).val(outstandingCB.toFixed(2));
             
             sumoutstandingCB=parseFloat(sumoutstandingCB)+parseFloat(outstandingCB);
       });
       
       $("#gdTotal_expmonRel").val(sumexrel.toFixed(2));
       $("#gdTotal_AgDil").val(sumexrelAgDil.toFixed(2));
       $("#gdTotal_totexpReal").val(sumofB.toFixed(2));
       $("#gdTotal_C").val(sumofC.toFixed(2));
       
       $("#gdTotal_CB").val(sumoutstandingCB.toFixed(2));
       
       $("#bamt").val(sumofB.toFixed(2));
       $("#ramt").val(sumofC.toFixed(2));
       $("#damt").val(sumoutstandingCB.toFixed(2));
       
       finalgrantcalculateCD();
}
  
  $("input[id^='paid-amount-']").on('keyup', function(event) {
      
      var Rowid = parseInt($(this).attr('id').split("paid-amount-")[1], 10);
      paidamtvsactualcostCD(Rowid);
      calculatesumrelizationtab4();
      

  });
  
  function finalgrantcalculateCD()
  {
           var totalCD =  parseFloat($("#gdTotal_C").val())-parseFloat($("#gdTotal_D").val());
          $("#gdTotal_CD").val(totalCD.toFixed(2));
  }
  
  
  $("select[id^='task-completed-']").on('change', function(event) {
    calculateperchnagecompletedtask();
    calculatecostoverrun();
    projectprofit();
    BalanceMM();
});


/* page on ,load call function */

 calculate_budgeted_man_days();
 //initCost();
 
  $("input[id^='paid-amount-']").each(function() {
      
      var Rowid = parseInt($(this).attr('id').split("paid-amount-")[1], 10);
      paidamtvsactualcostCD(Rowid);
      calculatesumrelizationtab4();
      totaldelaypersondays();
  });
  
});