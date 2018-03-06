var org_width='120';
var mod_width='250';

function coj_f_pop_up_width(obj){
    obj.style.position='absolute';
    obj.style.width=mod_width;
    obj.style.zIndex=100;
    obj.style.height = 200;
}


function coj_f_original_width(obj,i_width){
    obj.style.position='relative';
    obj.style.width=org_width;
    obj.style.zIndex=0;
    obj.style.height = 40;
}

function coj_f_dyn_changecolor(form,textobj,flag){   
    checktype=form.elements[textobj.name].type;

    if (checktype == 'text' &&checktype !='checkbox'&& checktype!='radio'&&  checktype !='button' && checktype !='reset'&&  checktype !='submit'&& checktype !='image'&&  checktype !='hidden')
    {
        if(typeof s_focus_color != 'undefined')
            form.elements[textobj.name].style.background= s_focus_color.value;
    }

    if (checktype != 'text' && checktype !='checkbox'&& checktype!='radio'&&  checktype !='button' && checktype !='reset'&&  checktype !='submit'&& checktype !='image'&&  checktype !='hidden')
    {
        if(form.elements[textobj.name].disabled == false)
        {
            if(typeof form.s_focus_color != 'undefined')
                form.elements[textobj.name].style.background= form.s_focus_color.value;
        }
    }

    if(checktype == 'text' ){
        var s_lang = '';
        if(typeof textobj.alt == 'undefined')
        {
        }
        else
        {
            s_lang=textobj.alt;

        }

        if(s_lang.search('###') != '-1'){
            CArray=s_lang.split('###');
            var s_hash=CArray[0].substring(0,5);
            var s_field_name = CArray[1];
            var s_value=CArray[0].substring(5,s_lang.length);
        }else{
            var s_hash=s_lang.substring(0,5);
            var s_field_name = '';
            var s_value=s_lang.substring(5,s_lang.length);
        }

        s_title = textobj.title;
        if(s_hash=='?????'){
            textobj.title = 'Data Exists in Another Language. Please Double Click to See and Modify';
        }
        if(textobj.readOnly && window.event.type=='focus')
        {
            alert('Can not modify readonly field Warning');
            coj_f_dyn_original(form,textobj);
		  
        }
    }

}
//Function to retain the original colors
function coj_f_dyn_original(form,textobj){
    checktype=form.elements[textobj.name].type;
    if (checktype !='checkbox'&& checktype!='radio' && checktype !='button'&&  checktype !='reset'&&  checktype !='submit'&& checktype !='image'&&  checktype !='hidden')
    {
        form.elements[textobj.name].style.background="#ffffff";      //changing background color to white
    }
    if(checktype =='hidden' || checktype =='text' || checktype =='textarea'){
        var txt_value=textobj.value;
        if(txt_value.search('\'') != '-1')
        {
            cnt=txt_value.length;
            for(var i=0;i < txt_value.length;i++)
                txt_value = txt_value.replace('\'','`');
            textobj.value=txt_value;
        }
        if(txt_value.search('"') != '-1')
        {
            cnt=txt_value.length;
            for(var i=0;i < txt_value.length;i++)
                txt_value = txt_value.replace('"','``');
            textobj.value=txt_value;
        }
    }

}
function RejectTS(){
    DisableButton();
    window.open('reject.php?sno='+s_no+'&empid='+emp_id,'','height=300,width=400');
}
function DisableButton(){
    (document.getElementById('add_button'))?document.getElementById('add_button').disabled=true:'';
    (document.getElementById('remove_button'))?document.getElementById('remove_button').disabled=true:'';
    (document.getElementById('manager'))?document.getElementById('manager').disabled=true:'';
    (document.getElementById('Approved'))?document.getElementById('Approved').disabled=true:'';
    (document.getElementById('reject'))?document.getElementById('reject').disabled=true:'';
    document.getElementById('back_button').disabled=true;
}
var tothrs=0,tothrs0=0,tothrs1=0,tothrs2=0,tothrs3=0,tothrs4=0,tothrs5=0,tothrs6=0
var totmins=0,totmins0=0,totmins1=0,totmins2=0,totmins3=0,totmins4=0,totmins5=0,totmins6=0
var tottime0=0,tottime1=0,tottime2=0,tottime3=0,tottime4=0,tottime5=0,tottime6=0,tottime=0


/*Form Validation*/
function timecalculation(p){
	
    var start_time=Convert(document.getElementById('stTime'+p).value , false);
	
    var end_time=Convert(document.getElementById('edTime'+p).value , false);
	
    var diff=parseFloat(end_time-start_time);
	
    if(diff <0){
        alert("Start time should be less then end time.\n So please enter valid time.");
        return false;
    }
	
    totHour =Convert(diff , true);
    document.getElementById('hrs'+p).value=totHour;
    TotalTimeCalulate();
}
function Convert(val , ReverseTime){
    if( ReverseTime==false){
        sp=val.split(':');
        var totSec=parseFloat(sp[0]*3600)+parseFloat(sp[1]*60);
        return totSec;
    }else{
        var TotHr=parseInt(val/3600);
        TotHr =(TotHr < 10)?'0'+TotHr:TotHr;
				
        var TotMin=parseInt((val%3600)/60);
        TotMin =(TotMin <10)?'0'+TotMin:TotMin;
        return (TotHr+':'+TotMin);
    }
}

function TotalTimeCalulate(){
    var TotSec=0;
    var tottime='';
    var ControlVal= parseInt(document.lveForm.tot_ctrl.value);
    for(j=0;j<ControlVal;j++){
        TotSec = parseFloat(TotSec + Convert(document.getElementById('hrs'+j).value , false));
     
}
    tottime=Convert(TotSec , true);

    document.lveForm.tothr.value=tottime;
}



function SetYearDate(url){
    var ajaxIndex = ajaxObjects.length;
    ajaxObjects[ajaxIndex] = new sack();
    ajaxObjects[ajaxIndex].requestFile = 'functions.php';
    ajaxObjects[ajaxIndex].URLString=url;
    ajaxObjects[ajaxIndex].onCompletion = function() {
        YearWeekCombo(ajaxIndex);
    };
    ajaxObjects[ajaxIndex].runAJAX();
}
function YearWeekCombo(index){
    var DateSetter=ajaxObjects[index].response.split(';;');
	
    document.getElementById('YearWeeks').innerHTML=DateSetter[0];
    document.getElementById('wstDate').value=DateSetter[1];
    document.getElementById('wedDate').value=DateSetter[2];
    for(i=1;i<=document.lveForm.tot_ctrl.value;i++){
        document.getElementById('weekCombo'+i).innerHTML=DateSetter[3];
    }
	
}

function save(index){
    var Control_Number = document.lveForm.tot_ctrl.value;
    document.getElementById('weekCombo'+Control_Number).innerHTML=ajaxObjects[index].response;
}

function saveCust(index,row_id){
	
    var Control_Number = document.lveForm.tot_ctrl.value;
    document.getElementById('M'+row_id).innerHTML=ajaxObjects[index].response;
}


function RemoveControl(obj){
   
        var str='';
        var i= parseInt(obj.tot_ctrl.value);
        if(i > 1){
                i= i-1;
                var divid=document.getElementById('add_ctrl');
                var totalrow=jQuery("#addtimesheetrow").val();
                var row=parseInt(totalrow)-1;
                ;
                jQuery("#addtimesheetrow").val(row);
                jQuery('#redRow'+i).remove();
                if(obj.tot_ctrl.value==ts_rec){
                        document.getElementById("add_button").disabled=false;
                        document.getElementById("remove_button").disabled=true;
                }else{
                        document.getElementById("add_button").disabled=false;
                }
                obj.tot_ctrl.value = jQuery('select[name^=milestone]').length ;
                //alert(obj.tot_ctrl.value);
                TotalTimeCalulate();
        }else{
                alert('You can not remove beyond this limit');
        }
}
function MoveNext(id , p){
    //document.getElementById('stHrs'+p).focus();
    if(id=='stHrs'+p)
        document.getElementById('stMin'+p).focus();
    else if(id=='stMin'+p)
        document.getElementById('edHrs'+p).focus();
    else if(id=='edHrs'+p)
        document.getElementById('edMin'+p).focus();
}
function IsValidTime(timeStr , id) {
    var timePat = /^(\d{1,2}):(\d{2})(:(\d{2}))?(\s?(AM|am|PM|pm))?$/;

    var matchArray = timeStr.match(timePat);
    if (matchArray == null) {
        alert("Time is not in a valid format.");
        document.getElementById(id).focus();
        return false;
    }
    hour = matchArray[1];
    minute = matchArray[2];
    second = matchArray[4];
    ampm = matchArray[6];

    if (second=="") {
        second = null;
    }
    if (ampm=="") {
        ampm = null
        }
	
    if (hour < 0  || hour > 23) {
        alert("Hour must be between 0 and 23 for military time)");
        document.getElementById(id).focus();
        return false;
    }
    if  (hour > 12 && ampm != null) {
        alert("You can't specify AM or PM for military time.");
        document.getElementById(id).focus();
        return false;
    }
    if (minute<0 || minute > 59) {
        alert ("Minute must be between 0 and 59.");
        document.getElementById(id).focus();
        return false;
    }
    if (second != null && (second < 0 || second > 59)) {
        alert ("Second must be between 0 and 59.");
        document.getElementById(id).focus();
        return false;
    }
    return true;
}
function CheckTime(val , counter , id){
	
    if(IsValidTime(val , id)){
        timecalculation(counter);
        return true;
    }
}
function Show(id){
    var options = {
        script:"test.php?json=true&",
        varname:"input",
        json:true,
        cache:true,
        timeout:100000,
        callback: function (obj) {
            document.getElementById('cust_id'+id).value = obj.id;
        }
    };
    var as_json = new AutoSuggest('cust_name'+id, options);
	
}
function InvlidCustomer(id){
    if(document.getElementById("cust_id"+id).value!="" && document.getElementById("cust_name"+id).value==""){
        document.getElementById("cust_id"+id).value="";
        document.getElementById("cust_name"+id).focus();
    }else if(document.getElementById("cust_name"+id).value!="" && document.getElementById("cust_id"+id).value==""){
        alert("Invalid Customer Name  "+document.getElementById("cust_name"+id).value);
        document.getElementById("cust_name"+id).focus();
        return false;
    }
}


function check(formname, submitbutton , siteurl , empid) {
        
    var errors_stdate = '',steddate='',errors_eddate='',errors_stime='',errors_etime='',errors_md='',errors_rem='',errors_pname='',errors_frm='',fname='';
    fname=formname.name;
    var tot_ctrl = formname.tot_ctrl.value;
    var k=0;
    var i=parseInt(tot_ctrl);
       
    /*Week Start Date and end date*/
    steddate= checkText(fname, 'wstDate', 'Week StartDate');
    steddate +=checkText(fname, 'wedDate', 'Week EndDate');
    checkThisForm(fname, submitbutton, steddate);
    var m=0;
    for(;k<i;k++){
        m=k+1;
          if(document.getElementById('remarks'+k).disabled==false){
               errors_rem += checkText(fname, 'remarks'+k, 'Remarks'+m);
//               if(document.getElementById('stTime'+k).value=='00:00' || document.getElementById('stTime'+k).value=='' && document.getElementById('edTime'+k).value=='' || document.getElementById('edTime'+k).value=='00:00' || document.getElementById('hrs'+k).value=='00:00' || document.getElementById('hrs'+k).value==''){
//                           var row=k+1;
//                           alert("Enter valid Start Time and End time in row"+row);
//                           return false;
//                       }
          }
    }

    checkThisForm(fname, submitbutton, errors_stdate);
    checkThisForm(fname, submitbutton, errors_md);
    checkThisForm(fname, submitbutton, errors_rem);
    checkThisForm(fname, submitbutton, errors_pname);
    checkThisForm(fname, submitbutton, errors_frm);

    var errorfinal=steddate+errors_stdate+errors_md+errors_rem+errors_pname+errors_frm
        
    checkFinal(fname, submitbutton, errorfinal, siteurl, empid);
}

var ts_rec=1;

function checkFinal(formname, submitbutton, errors, siteurl, empid) {
    if (errors == '') {
        CheckTimesheetValidity(siteurl, empid);
    }
}
function CheckTimesheetValidity(siteurl, empid){
   
    var url='task=CheckTimesheet&start_date='+document.getElementById('wstDate').value+'&end_date='+document.getElementById('wedDate').value+'&empID='+empid;
    jQuery.ajax({
        url: siteurl+'Timesheet/functions',
        data: url,
        success: function(data){
              var data1=data;
           
            if(data1==1){
                document.getElementById('add_button').disabled=true;
                document.getElementById('remove_button').disabled=true;
                document.getElementById('SaveTS').disabled=true;
                document.lveForm.method="POST";
                document.lveForm.action=siteurl+'Timesheet/saveinfo';
                document.lveForm.submit();
            }else{
                alert(data);
                document.getElementById('error_div').style.color = 'red';
                document.getElementById('error_div').innerHTML=data;
                return false;
            }

        }
    });


    function SetCustomer(cust_id , row_id, url){
       if(cust_id !='' ){
            var Control_Number = document.lveForm.tot_ctrl.value;
            var ajaxIndex = ajaxObjects.length;
            ajaxObjects[ajaxIndex] = new sack();
            ajaxObjects[ajaxIndex].requestFile = 'functions.php';
            ajaxObjects[ajaxIndex].URLString='task=SetCust&cust_id='+cust_id+'&Control_Number='+row_id;
            ajaxObjects[ajaxIndex].onCompletion = function() {
                saveCust(ajaxIndex , row_id);
            }//alert('M'+Control_Number);document.getElementById('M'+Control_Number).innerHTML=ajaxObjects[ajaxIndex].response; };
            ajaxObjects[ajaxIndex].runAJAX();
        }
    }


}