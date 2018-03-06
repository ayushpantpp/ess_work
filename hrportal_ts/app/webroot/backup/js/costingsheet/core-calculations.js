
  /*======== Start Here Outstanding Amount Calculate ================*/
  function calculateOutstandingAmount() {
        var outstanding_amt = $("#bamt").val() - $("#ramt").val();
        $("#damt").val(outstanding_amt);
    }
  /*======== End Here Outstanding Amount Calculate ================*/
  
   /*======== Start Here % Completed Task  Calculate ================*/
  function calculateperchnagecompletedtask() {
      
      var sumpercentageofwork=0;
       $("select[id^='task-completed-']").each(function() {
                
         if (this.value=='Y' && this.value.length != 0) {
             
             var Rowid = parseInt($(this).attr('id').split("task-completed-")[1], 10);
             var percentageofwork = $("#percentage-of-work-"+Rowid).val();
             if(isNaN(percentageofwork) || percentageofwork=='')
                 {
                     percentageofwork=0;
                 }else{
                     percentageofwork=percentageofwork;
                 }
            sumpercentageofwork =parseFloat(sumpercentageofwork)+parseFloat(percentageofwork);
         }
        
    });
 
       /* ======= Start here  % Completed Task calculation */
        $("#percomp").val(sumpercentageofwork.toFixed(2));
        
        $("#signoff").val(sumpercentageofwork.toFixed(2));
      /* ======= Start here  % Completed Task calculation */
      
       var projvalP         = $("#projval").val(); 
       var projectValPQ     = $("#pval").val();
       
       /* ======= Start here Balance Work (%) calculation */
       var balanceWork      = (1- (parseFloat(sumpercentageofwork)/100));
       var balwrk= parseFloat(balanceWork *100);
       $("#balwrk").val(balwrk.toFixed(2));
       /* ======= End here  Balance Work (%) calculation */
            
       
       /* ======= Start here Balance Project Value calculation */
        var cstVSac = parseFloat(projvalP * balanceWork);
        $("#cstVSac").val(cstVSac.toFixed(2));
       /* ======= End here  Balance Project Value calculation */
       
       
       /* ======= Start here Project Value (Completed Task) calculation */
        var prjvalcomp = parseFloat(projectValPQ * sumpercentageofwork)/parseFloat(100);
        $("#prjvalcomp").val(prjvalcomp.toFixed(2));
       /* ======= End here  Project Value (Completed Task) Value calculation */
             
    }
    
  /*======== End Here % Completed Task  Calculate ================*/
  
  function calculateProjValue() {
        var project_value = $("#projval").val() - $("#icost").val();
        $("#pval").val(project_value);
       
    }
    
 function calculate_budgeted_man_days() {
    
    // CALCULATE & SET VALUES FOR FIRST TAB
     
    var total_bdg_man_days_tb1 = 0;
    
      $("[alt|='BUDGETD MANDAYS TAB1']").each(function() {
                 
         if (!isNaN(this.value) && this.value.length != 0) {
             
            total_bdg_man_days_tb1 = parseFloat(total_bdg_man_days_tb1 + parseFloat(this.value));
            
         }
        
    });
    
   var budgeted_efforts = $('#effort').val();
   if(budgeted_efforts=='')
       {
           budgeted_efforts=0;
       }
   
   var yet_to_be_allocate_tb1 = 0;
   
   if (!isNaN(budgeted_efforts)){
       
        yet_to_be_allocate_tb1 = parseFloat(budgeted_efforts) - parseFloat(total_bdg_man_days_tb1);
        
        $('#total_yet_allocated_bdg_mandays_tb1').val(yet_to_be_allocate_tb1);
    }
     
    $('#total_allocated_mandays_tb1').val(total_bdg_man_days_tb1);
    
    if(!isNaN(budgeted_efforts) && !isNaN(total_bdg_man_days_tb1) && !isNaN(yet_to_be_allocate_tb1)){
        
      $('#grand_total_budgetd_mandays_tb1').val(parseFloat(total_bdg_man_days_tb1) + parseFloat(yet_to_be_allocate_tb1));
      
    }
    
    // CALCULATE & SET VALUES FOR THIRD TAB
     
    var total_bdg_man_days_tb3 = 0;
    
      $("[alt|='BUDGETD MANDAYS TAB3']").each(function() {
                 
         if (!isNaN(this.value) && this.value.length != 0) {
             
            total_bdg_man_days_tb3 = parseFloat(total_bdg_man_days_tb3 + parseFloat(this.value));
            
         }
        
    });
   
   var yet_to_be_allocate_tb3 = 0;
   
   if (!isNaN(budgeted_efforts)){
       
        yet_to_be_allocate_tb3 = parseFloat(budgeted_efforts) - parseFloat(total_bdg_man_days_tb3);
    
        $('#total_yet_allocated_bdg_mandays_tb3').val(yet_to_be_allocate_tb3);
    }
     
    $('#total_allocated_mandays_tb3').val(total_bdg_man_days_tb3);
    
    if(!isNaN(budgeted_efforts) && !isNaN(total_bdg_man_days_tb3) && !isNaN(yet_to_be_allocate_tb3)){
        
      $('#grand_total_budgetd_mandays_tb3').val(parseFloat(total_bdg_man_days_tb3) + parseFloat(yet_to_be_allocate_tb3));
      
    }
     calculationcompletetask();
     //initCost();
     calculateperchnagecompletedtask();
    // BalanceMM();
  
}


 function total_percentage_work() {
     
    var per_work_sum = 0;
    
      $("[alt|='PERCENTAGEOFWORK']").each(function() {
                 
         if (!isNaN(this.value) && this.value.length != 0) {
     
            per_work_sum = parseFloat(per_work_sum + parseFloat(this.value));
            
            $('#totalpercentwork').val(per_work_sum.toFixed(2));
            
         }
        
    });   
   
   var yet_to_be_per_work = 0;
   
   if (!isNaN(per_work_sum)){
       
        yet_to_be_per_work = 100 - parseFloat(per_work_sum);
    
        $('#yetPercentwrk').val(yet_to_be_per_work.toFixed(2));
    }
     
   var gdtotal = parseFloat(parseFloat(per_work_sum + yet_to_be_per_work));
   
   $('#gdtotpercentwork').val(gdtotal.toFixed(2));
        
}

function initCost()
{
    var sumactualcost=0; var sumtotalactmandays=0; var SumbudgetMancostA=0;
    var sumgdTotalDA=0;
    $("[alt|='Actual Mandays TAB3']").each(function() {
             
          var Rowid = parseInt($(this).attr('id').split("actual_man_days_")[1], 10);
          if(this.value =='')
              {
                  this.value=0;
                  $("#actual_man_days_"+Rowid).val(0);
              }
         if (!isNaN(this.value)) {
            
           
           sumtotalactmandays = parseFloat(sumtotalactmandays) + parseFloat(this.value);
            var actualcost = parseFloat($("#mcost").val() *this.value) ;
            sumactualcost=parseFloat(sumactualcost) + parseFloat(actualcost);
            $('#actual_cost_'+Rowid).val(actualcost.toFixed(2));
            
            /*======== Start here Budgeted Cost Vs Actual Cost (Activity Wise)================*/
            
            var BudgetedCostVsActualCost= parseFloat($('#budgeted_cost_as_per_mandays_'+Rowid).val())-parseFloat($('#actual_cost_'+Rowid).val());
            
            sumgdTotalDA=parseFloat(sumgdTotalDA)+parseFloat(BudgetedCostVsActualCost);
            
            $('#budget-cost-vs-actual-cost-'+Rowid).val(BudgetedCostVsActualCost.toFixed(2));
            /*======== End here Budgeted Cost Vs Actual Cost (Activity Wise)================*/
           }
         
            var budgetedcostaspermanday =  $("#mcost").val() * $(".budgeted-man-days-"+Rowid).val();
           $("#budgeted_cost_as_per_mandays_"+Rowid).val(budgetedcostaspermanday.toFixed(2));
            
           SumbudgetMancostA=parseFloat(SumbudgetMancostA)+parseFloat(budgetedcostaspermanday);
           
           paidamtvsactualcostCD(Rowid);
        
    });

    $('#gdTotal_acmandays').val(sumtotalactmandays.toFixed(2));
    $('#gdTotal_D').val(sumactualcost.toFixed(2));
    
     $('#totA').val(SumbudgetMancostA.toFixed(2));
     $('#gdTotal_A').val(SumbudgetMancostA.toFixed(2));
     
      $('#gdTotal_DA').val(sumgdTotalDA.toFixed(2));
      
      BalanceMM();
      projectprofit();
      calculatecostoverrun();
}


function totaldelaypersondays()
{
     var sumdelaypersonday=0;
       $("input[id^='delay_row_input_']").each(function() {
                
         if ((!isNaN(this.value) && this.value.length != 0) || this.value != '') {
             
            sumdelaypersonday =parseFloat(sumdelaypersonday)+parseFloat(this.value);
         }else{
             sumdelaypersonday=sumdelaypersonday+0;
         }
        
    });
    
     $('#ddays').val(sumdelaypersonday.toFixed(2));
}


function BalanceMM()
{
  var totalactmanday =   $("#gdTotal_acmandays").val();
    if(!isNaN(totalactmanday) && totalactmanday !='' )
    {
        totalactmanday=totalactmanday;
    }else{
        totalactmanday=0;
    } 
    
    var totbudgetmanday =   $("#total_yet_allocated_bdg_mandays_tb3").val();
    if(!isNaN(totbudgetmanday) && totbudgetmanday !='' )
    {
        totbudgetmanday= totbudgetmanday;
    }else{
        totbudgetmanday=0;
    } 
    
    var balancemm= parseFloat(totalactmanday)/ parseFloat(totbudgetmanday)
     balancemm=(!isFinite(balancemm))?0:balancemm.toFixed(2);   
     
    var finalbalMM =  parseFloat(100)-parseFloat(balancemm);
    
    $("#balMM").val(finalbalMM.toFixed(2));
    
}


function projectprofit()
{
   var GrantTotalA =  $('#gdTotal_A').val();
    if(!isNaN(GrantTotalA) && GrantTotalA !='' )
    {
        GrantTotalA=GrantTotalA;
    }else{
        GrantTotalA=0;
    } 
   
    var projectvaluePQ = $("#pval").val();
    
    if(!isNaN(projectvaluePQ) && projectvaluePQ !='' )
    {
        projectvaluePQ=projectvaluePQ;
    }else{
        projectvaluePQ=0;
    } 
    
    var projectprofit = parseFloat(projectvaluePQ)-parseFloat(GrantTotalA);
    
     $("#pprofit").val(projectprofit.toFixed(2));
     
     var texpcost = parseFloat(projectprofit) + parseFloat(GrantTotalA);
     $("#texpcost").val(texpcost.toFixed(2));
     
    var fprjvalcomp = $("#prjvalcomp").val();
    
    if(!isNaN(fprjvalcomp) && fprjvalcomp !='')
     {
         fprjvalcomp=fprjvalcomp;
     } else{
         fprjvalcomp=0;
     }  
     
    var gdTotalD = $("#gdTotal_D").val();
    
    if(!isNaN(gdTotalD) && gdTotalD !='')
     {
         gdTotalD=gdTotalD;
     } else{
         gdTotalD=0;
     } 
     var prof1pvVsac = parseFloat(fprjvalcomp)-parseFloat(gdTotalD);
     $("#prof1_pvVsac").val(prof1pvVsac.toFixed(2));
}

function calculatecostoverrun() {
      
      var sumYesbudgetcostDA=0; var budgetcostDA=0; var sumbudgetA=0;
       $("input[id^='budget-cost-vs-actual-cost-']").each(function() {
        var Rowid = parseInt($(this).attr('id').split("budget-cost-vs-actual-cost-")[1], 10);      
                
         if ($("#task-completed-"+Rowid).val()=='Y') {
             
             if(isNaN(this.value) || this.value=='')
                 {
                     budgetcostDA=0;
                 }else{
                     budgetcostDA=this.value;
                 }
            sumYesbudgetcostDA =parseFloat(sumYesbudgetcostDA)+parseFloat(budgetcostDA);
            
            var budgetA =$("#budgeted_cost_as_per_mandays_"+Rowid).val();
            if(isNaN(budgetA) || budgetA=='')
                 {
                     budgetA=0;
                 }else{
                     budgetA=budgetA;
                 }
             sumbudgetA= parseFloat(sumbudgetA)+parseFloat(budgetA);    
         }
        });
 
       $("#prof2_pvVsra").val(sumYesbudgetcostDA.toFixed(2));
       
       var prof2pvVsra2percen  = (parseFloat(sumYesbudgetcostDA)/parseFloat(sumbudgetA))* 100;
       
        prof2pvVsra2percen=(!isFinite(prof2pvVsra2percen))?0:prof2pvVsra2percen;   
       $("#prof2_pvVsra2_percen").val(prof2pvVsra2percen.toFixed(2));
             
    }
    
    
    function paidamtvsactualcostCD(Rowid)
  {
      var paidamt= $("#paid-amount-"+Rowid).val();
             if(!isNaN(paidamt) && paidamt !='')
            {
                paidamt=paidamt;
            } else{
                paidamt=0;
            } 
    var actualCostD = $("#actual_cost_"+Rowid).val();
             if(!isNaN(actualCostD) && actualCostD !='')
            {
                actualCostD=actualCostD;
            } else{
                actualCostD=0;
            }
            
       var paidamtactalcostCD = parseFloat(paidamt)-parseFloat(actualCostD);
       $("#paid-amt-vs-act-cost-"+Rowid).val(paidamtactalcostCD.toFixed(2));
  }
    
   
   function calculationcompletetask()
   {
       $("input[class^='budgeted-man-days-']").each(function() {  
                var getclassname = $(this).attr('class');
                var getvalue = $(this).val();
                if(getvalue=='')
                 {
                    var newgetvalue=0;
                 }else{
                     newgetvalue=getvalue;
                 }   
                $("."+getclassname).val(getvalue);
                
                 var Rowid = parseInt($(this).attr('class').split("budgeted-man-days-")[1], 10);
                 
                 if($("#effort").val()=='')
                  {
                     var effortvl=0;
                  } else{
                   var effortvl =$("#effort").val();
                  }  
                 var perchnageval= parseFloat((parseFloat(newgetvalue) / parseFloat(effortvl)) *100);
                 
                 perchnageval=(!isFinite(perchnageval))?0:perchnageval;   
                 
                 $("#percentage-of-work-"+Rowid).val(perchnageval.toFixed(2));
                 var budgetedcostaspermanday =  $("#mcost").val()*getvalue;
                 $("#budgeted_cost_as_per_mandays_"+Rowid).val(budgetedcostaspermanday.toFixed(2));
                 total_percentage_work();
                 //SumbudgetMancostA =parseFloat(SumbudgetMancostA)+ parseFloat(budgetedcostaspermanday);
                //  alert(SumbudgetMancostA);
                initCost();
        });
   }