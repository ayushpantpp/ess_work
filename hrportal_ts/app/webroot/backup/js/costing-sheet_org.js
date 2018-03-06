/**************************************************** Function to add events*********************************/





/**************************************************** Function to distinguish browser types*********************************/
//var NumOfRow=2;
var isIE = false;
 var isFF = false;
 var isOP = false;
 var isSafari = false; 

 function DetectBrowser()
 {
     var val = navigator.userAgent.toLowerCase();     
     if(val.indexOf("firefox") > -1)
     {
         isFF = true;
     } 
     else if(val.indexOf("opera") > -1)
     {
         isOP = true;
     }
     else if(val.indexOf("msie") > -1)
     {
         isIE = true;
     } 
     else if(val.indexOf("safari") > -1)
     {
         isIE = true;
     } 
 }


/**************************************************** Function to distinguish browser types*********************************/

/**************************************************** Function to add dynamic rows*********************************/



function Display(obj){
++NumOfRow;
DetectBrowser();
//alert(NumOfRow);
document.getElementById('hidcount').value=NumOfRow;
// get the refference of the main Div

if(isIE)
{
	var Max_Control=150;
var tot_ctrl = NumOfRow;
		if(tot_ctrl < Max_Control){
		//alert(NumOfRow);
		// get the refference of the main Div
		var mainDiv=document.getElementById("MainDiv");
             
		var i=parseInt(tot_ctrl);
		var j=(i+1);

var str="<table id=\"TABLE"+NumOfRow+"\"><tbody><tr id=\"TR"+NumOfRow+"\"><td id=\"actTD"+NumOfRow+"\" class=\"tableText\" align=\"center\"><input class=\"textBox\" type=\"text\" id=\"Activity"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][Activity]\" width=\"80px\" value=\"\" /></td><td id=\"plTD"+NumOfRow+"\"			class=\"tableText\" style=\"width:118px;\"><input class=\"textBox1\" id=\"plStDate"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][plStDate]\"  size=\"10\" value=\"\" maxlength=\"10\" type=\"text\"  readonly /><span id=postdatetag style=\"visibility:visible;\"><a><img class='PopcalTrigger' align='absmiddle' src='js/datepicker/calbtn.gif' width='25' height='20'  border='0' onclick='if(self.gfPop)gfPop.fPopCalendar(document.frmcosting.plStDate"+NumOfRow+");return false;' alt='' /></a></span></td><td id=\"elTD"+NumOfRow+"\"			class=\"tableText\" style=\"width:118px;\"><input class=\"textBox1\" id=\"plEdDate"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][plEdDate]\"  size=\"10\" value=\"\" maxlength=\"10\" type=\"text\"  readonly /><span id=postdatetag style=\"visibility:visible;\"><a ><img class='PopcalTrigger' align='absmiddle' src='js/datepicker/calbtn.gif' width='25' height='20'  border='0' onclick='if(self.gfPop)gfPop.fPopCalendar(document.frmcosting.plEdDate"+NumOfRow+");return false;' alt='' /></a></span></td><td style=\"width:117px;\" id=\"acStTD"+NumOfRow+"\"		class=\"tableText\" ><input class=\"textBox1\" id=\"acStDate"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acStDate]\"  size=\"10\" value=\"\" maxlength=\"10\" type=\"text\"  readonly /><span id=postdatetag style=\"visibility:visible;width:18px\"><a ><img class='PopcalTrigger' align='absmiddle' src='js/datepicker/calbtn.gif' width='25' height='20'  border='0' onclick='if(self.gfPop)gfPop.fPopCalendar(document.frmcosting.acStDate"+NumOfRow+");return false;' alt='' /></a></span></td><td  id=\"acEdTD"+NumOfRow+"\"	style=\"width:117px;\"	class=\"tableText\" ><input class=\"textBox1\" id=\"acEdDate"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acEdDate]\"  size=\"10\" value=\"\" maxlength=\"10\" type=\"text\"  readonly /><span id=postdatetag style=\"visibility:visible;\"><a ><img class='PopcalTrigger' align='absmiddle' src='js/datepicker/calbtn.gif' width='25' height='20'  border='0' onclick='if(self.gfPop)gfPop.fPopCalendar(document.frmcosting.acEdDate"+NumOfRow+");return false;' alt='' /></a></span></td><td  id=\"dlyTD"+NumOfRow+"\"			class=\"tableText\"><input type=\"text\" class=\"textBox1 textBoxCenter\" id=\"dlyNoDays"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][dlyNoDays]\" width=\"80px\" maxlength=\"5\" value=\"0\" onfocus=\"javascript:Caldlydate('"+NumOfRow+"');\" readonly/></td><td id=\"percenTD"+NumOfRow+"\"		class=\"tableText\"><input type=\"text\"  class=\"textBox textBoxCenter\" id=\"workPercentage"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][workPercentage]\" width=\"80px\" value=\"0.00\" readonly/></td><td id=\"tskTD"+NumOfRow+"\"		style=\"width:78px;\"	class=\"tableText\"><select id=\"taskCompleted"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][taskCompleted]\" maxlength=\"1\"  onchange=\"totworkpercentage()\">	<option value=\"N\" >No</option><option value=\"Y\">Yes</option></select></td><td id=\"bdMnTD"+NumOfRow+"\"		class=\"tableTextPink\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"bdManDays"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][bdManDays]\" width=\"80px\" value=\"0\" onblur=\"onblur_bdmandays('"+NumOfRow+"')\"/></td><td  id=\"bdPerMnTD"+NumOfRow+"\" class=\"tableTextPink\" align=\"center\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"bdCostPerManDays"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][bdCostPerManDays]\"  value=\"0\" onblur=\"calculateDA('"+NumOfRow+"')\" readonly=\"readonly\"/></td><td  id=\"acManDaysTD"+NumOfRow+"\"	class=\"tableTextPink\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"acManDays"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acManDays]\" value=\"0\" onblur=\"onblur_acmandays('"+NumOfRow+"')\" readonly/></td><td  id=\"acCostTD"+NumOfRow+"\"		class=\"tableTextPink\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"acCost"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acCost]\" value=\"0\" onblur=\"calculateDA('"+NumOfRow+"')\" readonly/></td><td  id=\"exMthRealTD"+NumOfRow+"\"		class=\"tableText tableTextYellow\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"exMthReal"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][exMthReal]\"  maxlength=\"10\" value=\"0\" onblur=\"onblurdue21()\"/></td><td  id=\"exMthRealDueTD"+NumOfRow+"\"	style=\"width:77px;\" class=\"tableTextWhite\"><select  id=\"exMthRealDue"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][exMthRealDue]\"  maxlength=\"1\"  onchange=\"onblur_due2('"+NumOfRow+"')\"><option value=\"N\">No</option><option value=\"Y\">yes</option></select></td><td  id=\"exMthRealAgDlvTD"+NumOfRow+"\"	class=\"tableText tableTextYellow\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"exMthRealAgDlv"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][exMthRealAgDlv]\" width=\"80px\" maxlength=\"10\" value=\"0\" onblur=\"calculateDA('"+NumOfRow+"')\"/></td><td  id=\"exMthRealAgDlvDueTD"+NumOfRow+"\"	style=\"width:85px;\" class=\"tableTextWhite\" ><select id=\"exMthRealAgDlvDue"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][exMthRealAgDlvDue]\"   maxlength=\"1\" onchange=\"onblur_due2('"+NumOfRow+"')\">	<option value=\"N\"  >No</option><option value=\"Y\"  >Yes</option></select></td><td  id=\"totExRealTD"+NumOfRow+"\"		class=\"tableTextBlue\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"totExReal"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][totExReal]\" onblur=\"onblurB"+NumOfRow+"()\" value=\"0\"  readonly/></td><td  id=\"acRealTD"+NumOfRow+"\"		class=\"tableTextBlue\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"acReal"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acReal]\" maxlength=\"10\" value=\"0\" onblur=\"onblur_C('"+NumOfRow+"')\" onfocus=\"onblur_C('"+NumOfRow+"')\"/></td><td  id=\"acVSexRealTD"+NumOfRow+"\"		class=\"tableTextAqua\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"acVSexReal"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acVSexReal]\"  value=\"0.00\" readonly/></td><td  id=\"acRealVSbdCostTD"+NumOfRow+"\"	class=\"tableTextAqua\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"acRealVSbdCost"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acRealVSbdCost]\" width=\"80px\"  value=\"0.00\" readonly/></td><td  id=\"bdVSacCostTD"+NumOfRow+"\"		class=\"tableTextPink\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"bdVSacCost"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][bdVSacCost]\" value=\"0.00\" readonly/></td><td  id=\"acRealVSacCostTD"+NumOfRow+"\"	class=\"tableTextPink\"><input type=\"text\" class=\"textBox textBoxRight\" id=\"acRealVSacCost"+NumOfRow+"\" name=\"arrCosting["+NumOfRow+"][acRealVSacCost]\"  value=\"0.00\" readonly/></td></tr></tbody></table>"

					
			document.getElementById('MainDiv').innerHTML = document.getElementById('MainDiv').innerHTML+str;
			document.getElementById("Button12").disabled=false;
					
		}

}
else
{


var mainDiv=document.getElementById("MainDiv");
var tbody = document.createElement("tbody");
var TABLE = document.createElement("table");
TABLE.setAttribute("id","TABLE"+NumOfRow);

// create new div that will work as a container
var TR=document.createElement("tr");
TR.setAttribute("id","TR"+NumOfRow);
//alert("hello");

//create span to contain the text
//var newSpan=document.createElement("span");
//newSpan.innerHTML="&nbsp;";
//===============================================================================
var plTD=document.createElement("td");

//var plspan=document.createElement("span");
plTD.setAttribute("id","plTD"+NumOfRow);
plTD.className="tableText";
plTD.style.width="118px";
//plTD.width="500";

var plStDate=document.createElement("input"); // Planned Start Date
plStDate.name="arrCosting["+ NumOfRow +"][plStDate]";
plStDate.setAttribute("id","plStDate"+NumOfRow);
plStDate.setAttribute("maxlength","10");
plStDate.className="textBox1";
plStDate.setAttribute("readonly","true");
plStDate.type="text";
plStDate.value="";
plStDate.style.width="80px"; 
//plStDate.setAttribute("onblur","Validate_plSt("+NumOfRow+")");

var StImg=document.createElement("img");
StImg.className="PopcalTrigger";
StImg.setAttribute("id","StImg"+NumOfRow);
StImg.align="absmiddle";
StImg.src="js/datepicker/calbtn.gif";
StImg.width="25";
StImg.height="20";
StImg.border="0";
StImg.setAttribute("onclick","CreateCal1("+NumOfRow+")"); 
//StImg.onclick=;
//======================================================================

var elTD=document.createElement("td");
elTD.setAttribute("id","elTD"+NumOfRow);
elTD.className="tableText";
elTD.style.width="118px";

var plEdDate=document.createElement("input");// Planned End Date
plEdDate.name="arrCosting["+ NumOfRow +"][plEdDate]";
plEdDate.setAttribute("id","plEdDate"+NumOfRow);
plEdDate.setAttribute("maxlength","10");
plEdDate.className="textBox1";
plEdDate.setAttribute("readonly","true");
plEdDate.value="";
plEdDate.type="text";
plEdDate.style.width="80px"; 
//plEdDate.setAttribute("onblur","Validate_plEd("+NumOfRow+")");

var EdImg=document.createElement("img");
EdImg.className="PopcalTrigger";
EdImg.align="absmiddle";
EdImg.src="js/datepicker/calbtn.gif";
EdImg.width="25";
EdImg.height="20";
EdImg.border="0";
EdImg.setAttribute("onclick","CreateCal2("+NumOfRow+")");
//EdImg.onclick=;
//=====================================================================

var acStTD=document.createElement("td");
acStTD.setAttribute("id","acStTD"+NumOfRow);
acStTD.className="tableText";
acStTD.style.width="117px";


var acStDate=document.createElement("input"); // Actual Start Date
acStDate.name="arrCosting["+ NumOfRow +"][acStDate]";
acStDate.setAttribute("id","acStDate"+NumOfRow);
acStDate.setAttribute("maxlength","10");
acStDate.className="textBox1";
acStDate.setAttribute("readonly","true");
acStDate.value="";
acStDate.type="text";
acStDate.style.width="80px"; 
//acStDate.setAttribute("onblur","Validate_acSt("+NumOfRow+")");

var acStImg=document.createElement("img");
acStImg.className="PopcalTrigger";
acStImg.align="absmiddle";
acStImg.src="js/datepicker/calbtn.gif";
acStImg.width="25";
acStImg.height="20";
acStImg.border="0";
acStImg.setAttribute("onclick","CreateCal3("+NumOfRow+")");
//acStImg.onclick=;
//=======================================================================


var acEdTD=document.createElement("td");
acEdTD.setAttribute("id","acEdTD"+NumOfRow);
acEdTD.className="tableText";
acEdTD.style.width="118px";


var acEdDate=document.createElement("input");//Actual End Date
acEdDate.name="arrCosting["+ NumOfRow +"][acEdDate]";
acEdDate.setAttribute("id","acEdDate"+NumOfRow);
acEdDate.setAttribute("maxlength","10");
acEdDate.className="textBox1";
acEdDate.setAttribute("readonly","true");
acEdDate.value="";
acEdDate.type="text";
acEdDate.style.width="80px"; 

//acEdDate.setAttribute("onblur","Validate_acEd("+NumOfRow+")");


var acEdImg=document.createElement("img");
acEdImg.className="PopcalTrigger";
acEdImg.align="absmiddle";
acEdImg.src="js/datepicker/calbtn.gif";
acEdImg.width="25";
acEdImg.height="20";
acEdImg.border="0";
acEdImg.setAttribute("onclick","CreateCal4("+NumOfRow+")");
//acEdImg.onclick=;

// Delay (No. of Days) ==============================================================================
var dlyTD=document.createElement("td");
dlyTD.setAttribute("id","dlyTD"+NumOfRow);
dlyTD.className="tableText";
dlyTD.style.width="80px";

var dlyNoDays=document.createElement("input"); //Delay No of days
dlyNoDays.name="arrCosting["+ NumOfRow +"][dlyNoDays]";
dlyNoDays.setAttribute("id","dlyNoDays"+NumOfRow);
dlyNoDays.setAttribute("maxlength","5");
dlyNoDays.className="textBox1 textBoxCenter";
dlyNoDays.setAttribute("readonly","true");
dlyNoDays.type="text";
dlyNoDays.value="0";
dlyNoDays.style.width="80px"; 
dlyNoDays.setAttribute("onfocus","Caldlydate("+NumOfRow+")");
//===================================================================================================

// Activities =======================================================================================
var actTD=document.createElement("td");
actTD.setAttribute("id","actTD"+NumOfRow);
actTD.className="tableText";
actTD.style.width="100px";


var Activity=document.createElement("input"); //Activity
Activity.name="arrCosting["+ NumOfRow +"][Activity]";
Activity.setAttribute("id","Activity"+NumOfRow);
Activity.className="textBox";
Activity.type="text";
Activity.size="10"; 
Activity.style.width="100px"; 
//==================================================================================================

//Percentage of total Work =========================================================================
var percenTD=document.createElement("td");
percenTD.setAttribute("id","percenTD"+NumOfRow);
percenTD.className="tableText";
percenTD.style.width="100px";

var workPercentage=document.createElement("input"); //Percentage of total Work
workPercentage.name="arrCosting["+ NumOfRow +"][workPercentage]";
workPercentage.setAttribute("id","workPercentage"+NumOfRow);
workPercentage.setAttribute("readonly","true");
workPercentage.className="textBox textBoxCenter";
workPercentage.type="text";
workPercentage.style.width="100px"; 
workPercentage.value="0.00";
// ===================================================================================================

// Task Completed ====================================================================================
var tskTD=document.createElement("td");
tskTD.setAttribute("id","tskTD"+NumOfRow);
tskTD.className="tableText";
tskTD.style.width="70px";

var taskCompleted=document.createElement("select"); //Task Completed
var taskCompletedOpt1 = document.createElement('option');
var taskCompletedOpt2 = document.createElement('option');

taskCompletedOpt1.text = 'Yes';
taskCompletedOpt1.value = 'Y';

taskCompletedOpt2.text = 'No';
taskCompletedOpt2.value = 'N'; 

if(isIE)
{
	taskCompleted.add(taskCompletedOpt2);
	taskCompleted.add(taskCompletedOpt1);	
}
else{
	taskCompleted.add(taskCompletedOpt2, null);
	taskCompleted.add(taskCompletedOpt1, null);
}

taskCompleted.name="arrCosting["+ NumOfRow +"][taskCompleted]";
taskCompleted.setAttribute("id","taskCompleted"+NumOfRow);



taskCompleted.setAttribute("onChange","onblur_due2("+NumOfRow+")"); 




//=====================================================================================================

//Budgeted Man Days =================================================================================== 
var bdMnTD=document.createElement("td");
bdMnTD.setAttribute("id","bdMnTD"+NumOfRow);
bdMnTD.className="tableTextPink";
bdMnTD.style.width="100px";

var bdManDays=document.createElement("input"); //Budgeted Man Days
bdManDays.name="arrCosting["+ NumOfRow +"][bdManDays]";
bdManDays.setAttribute("id","bdManDays"+NumOfRow);
bdManDays.setAttribute("maxlength","5");

//bdManDays.className="textBox textBoxRight"
bdManDays.className="textBox textBoxRight";
bdManDays.type="text";
bdManDays.style.width="100px"; 
bdManDays.value="0";
bdManDays.setAttribute("onblur","onblur_bdmandays("+NumOfRow+")");

//=====================================================================================================

//Budgeted Cost As per Man Days ===================================================================
var bdPerMnTD=document.createElement("td");
bdPerMnTD.setAttribute("id","bdPerMnTD"+NumOfRow);
bdPerMnTD.className="tableTextPink";
bdPerMnTD.style.width="100px";

var bdCostPerManDays=document.createElement("input"); //Budgeted Cost As per Man Days
bdCostPerManDays.name="arrCosting["+ NumOfRow +"][bdCostPerManDays]";
bdCostPerManDays.setAttribute("id","bdCostPerManDays"+NumOfRow);
bdCostPerManDays.setAttribute("readonly","true");

bdCostPerManDays.className="textBox textBoxRight";
bdCostPerManDays.type="text";
bdCostPerManDays.style.width="100px";
bdCostPerManDays.value="0";
bdCostPerManDays.setAttribute("onblur","calculateDA("+NumOfRow+")");
//=================================================================================================

//Actual Man Days =================================================================================
var acManDaysTD=document.createElement("td");
acManDaysTD.setAttribute("id","acManDaysTD"+NumOfRow);
acManDaysTD.className="tableTextPink";
acManDaysTD.style.width="100px";

var acManDays=document.createElement("input"); //Actual Man Days
acManDays.name="arrCosting["+ NumOfRow +"][acManDays]";
acManDays.setAttribute("id","acManDays"+NumOfRow);
acManDays.setAttribute("maxlength","5");
acManDays.setAttribute("readonly","true");
acManDays.className="textBox textBoxRight";
acManDays.type="text";
acManDays.style.width="100px"; 
acManDays.value="0";
acManDays.setAttribute("onblur","onblur_acmandays("+NumOfRow+")"); 

//=================================================================================================

// Actual Cost ===================================================================================
var acCostTD=document.createElement("td");
acCostTD.setAttribute("id","acCostTD"+NumOfRow);
acCostTD.className="tableTextPink";
acCostTD.style.width="100px";

var acCost=document.createElement("input"); //Actual  Cost
acCost.name="arrCosting["+ NumOfRow +"][acCost]";
acCost.setAttribute("id","acCost"+NumOfRow);
acCost.setAttribute("readonly","true");
acCost.className="textBox textBoxRight";
acCost.type="text";
acCost.style.width="100px"; 
acCost.value="0";
acCost.setAttribute("onblur","calculateDA("+NumOfRow+")"); 

//=================================================================================================

//Expected Monthly Realisation ====================================================================
var exMthRealTD=document.createElement("td");
exMthRealTD.setAttribute("id","exMthRealTD"+NumOfRow);
exMthRealTD.className="tableText tableTextYellow";
exMthRealTD.style.width="100px";

var exMthReal=document.createElement("input"); //Expected Monthly Realisation 
exMthReal.name="arrCosting["+ NumOfRow +"][exMthReal]";
exMthReal.setAttribute("id","exMthReal"+NumOfRow);
exMthReal.setAttribute("maxlength","10");
exMthReal.className="textBox textBoxRight";
exMthReal.type="text";
exMthReal.style.width="100px"; 
exMthReal.value="0";
exMthReal.setAttribute("onblur","calculateDA('"+NumOfRow+"')"); 
//=================================================================================================

// Due1 ===========================================================================================
var exMthRealDueTD=document.createElement("td");
exMthRealDueTD.setAttribute("id","exMthRealDueTD"+NumOfRow);
exMthRealDueTD.className="tableTextWhite";
exMthRealDueTD.style.width="70px";

var exMthRealDue=document.createElement("select"); //Expected Monthly Realisation  Due1

var exMthRealDueOpt1 = document.createElement('option');
var exMthRealDueOpt2 = document.createElement('option');

exMthRealDueOpt1.text = 'Yes';
exMthRealDueOpt1.value = 'Y';

exMthRealDueOpt2.text = 'No';
exMthRealDueOpt2.value = 'N'; 

if(isIE){
	exMthRealDue.add(exMthRealDueOpt2);
	exMthRealDue.add(exMthRealDueOpt1);	
}else{
	exMthRealDue.add(exMthRealDueOpt2, null);
	exMthRealDue.add(exMthRealDueOpt1, null);
}

exMthRealDue.name="arrCosting["+ NumOfRow +"][exMthRealDue]";
exMthRealDue.setAttribute("id","exMthRealDue"+NumOfRow);

exMthRealDue.setAttribute("onChange","onblur_due2("+NumOfRow+")"); 
//=================================================================================================

//Expected Realisaton Against Delivery ============================================================
var exMthRealAgDlvTD=document.createElement("td");
exMthRealAgDlvTD.setAttribute("id","exMthRealAgDlvTD"+NumOfRow);
exMthRealAgDlvTD.className="tableText tableTextYellow";
exMthRealAgDlvTD.style.width="100px";

var exMthRealAgDlv=document.createElement("input"); //Expected Monthly Realisation Aginst Delivery
exMthRealAgDlv.name="arrCosting["+ NumOfRow +"][exMthRealAgDlv]";
exMthRealAgDlv.setAttribute("id","exMthRealAgDlv"+NumOfRow);
exMthRealAgDlv.setAttribute("maxlength","10");
exMthRealAgDlv.className="textBox textBoxRight";
exMthRealAgDlv.type="text";
exMthRealAgDlv.style.width="100px";
exMthRealAgDlv.value="0";
exMthRealAgDlv.setAttribute("onblur","calculateDA("+NumOfRow+")"); 
//=================================================================================================

// Due2 ===========================================================================================
var exMthRealAgDlvDueTD=document.createElement("td");
exMthRealAgDlvDueTD.setAttribute("id","exMthRealAgDlvDueTD"+NumOfRow);
exMthRealAgDlvDueTD.className="tableTextWhite";
exMthRealAgDlvDueTD.style.width="75px";


var exMthRealAgDlvDue=document.createElement("select"); //Expected Monthly Realisation Aginst Delivery Due2


var exMthRealAgDlvDueOpt1 = document.createElement('option');
var exMthRealAgDlvDueOpt2 = document.createElement('option');

exMthRealAgDlvDueOpt1.text = 'Yes';
exMthRealAgDlvDueOpt1.value = 'Y';

exMthRealAgDlvDueOpt2.text = 'No';
exMthRealAgDlvDueOpt2.value = 'N'; 

if(isIE)
{
	exMthRealAgDlvDue.add(exMthRealAgDlvDueOpt2);
	exMthRealAgDlvDue.add(exMthRealAgDlvDueOpt1);
}
else
{
	exMthRealAgDlvDue.add(exMthRealAgDlvDueOpt2, null);
	exMthRealAgDlvDue.add(exMthRealAgDlvDueOpt1, null);
}



exMthRealAgDlvDue.name="arrCosting["+ NumOfRow +"][exMthRealAgDlvDue]";
exMthRealAgDlvDue.setAttribute("id","exMthRealAgDlvDue"+NumOfRow);
 
exMthRealAgDlvDue.setAttribute("onChange","onblur_due2("+NumOfRow+")"); 
exMthRealAgDlvDue.value="N";
//===================================================================================================

// Total Expected  Realisation ======================================================================
var totExRealTD=document.createElement("td");
totExRealTD.setAttribute("id","totExRealTD"+NumOfRow);
totExRealTD.className="tableTextBlue";
totExRealTD.style.width="100px";

var totExReal=document.createElement("input"); //Total Expected  Realisation
totExReal.name="arrCosting["+ NumOfRow +"][totExReal]";
totExReal.setAttribute("id","totExReal"+NumOfRow);
totExReal.setAttribute("readonly","true");
totExReal.className="textBox textBoxRight";
totExReal.type="text";
totExReal.style.width="100px"; 
totExReal.value="0";
//==========================================================================================================

// Actual Realisation ======================================================================================
var acRealTD=document.createElement("td");
acRealTD.setAttribute("id","acRealTD"+NumOfRow);
acRealTD.className="tableTextBlue";
acRealTD.style.width="100px";

var acReal=document.createElement("input"); //Actual   Realisation
acReal.name="arrCosting["+ NumOfRow +"][acReal]";
acReal.setAttribute("id","acReal"+NumOfRow);
acReal.setAttribute("maxlength","10");
acReal.className="textBox textBoxRight";
acReal.type="text";
acReal.size="22";
acReal.style.width="100px"; 
acReal.value="0";
acReal.setAttribute("onblur","onblur_C("+NumOfRow+")"); 
//==========================================================================================================

// Actual Realisation VS Expected Realisation ==============================================================
var acVSexRealTD=document.createElement("td");
acVSexRealTD.setAttribute("id","acVSexRealTD"+NumOfRow);
acVSexRealTD.className="tableTextAqua";
acVSexRealTD.style.width="100px";

var acVSexReal=document.createElement("input"); //Actual versus Expected Realisation
acVSexReal.name="arrCosting["+ NumOfRow +"][acVSexReal]";
acVSexReal.setAttribute("id","acVSexReal"+NumOfRow);
acVSexReal.setAttribute("readonly","true");
acVSexReal.className="textBox textBoxRight";
acVSexReal.type="text";
acVSexReal.style.width="100px"; 
acVSexReal.value="0.00";
//acVSexReal.setAttribute("onblur","acRealVSbdCost("+NumOfRow+")");
//============================================================================================================

// Actual Reslisation VS Budgeted cost (Activity wise) =======================================================
var acRealVSbdCostTD=document.createElement("td");
acRealVSbdCostTD.setAttribute("id","acRealVSbdCostTD"+NumOfRow);
acRealVSbdCostTD.className="tableTextAqua";
acRealVSbdCostTD.style.width="100px";

var acRealVSbdCost=document.createElement("input"); //Actual Reslisation versus Budgeted cost (Activity wise)
acRealVSbdCost.name="arrCosting["+ NumOfRow +"][acRealVSbdCost]";
acRealVSbdCost.setAttribute("id","acRealVSbdCost"+NumOfRow);
acRealVSbdCost.setAttribute("readonly","true");
acRealVSbdCost.className="textBox textBoxRight";
acRealVSbdCost.type="text";
acRealVSbdCost.style.width="100px";
acRealVSbdCost.value="0.00";
//acRealVSbdCost.setAttribute("onblur","bdVSacCost("+NumOfRow+")"); 
//=============================================================================================================

// Budgeted Cost VS Actual cost (Activity wise) ===============================================================
var bdVSacCostTD=document.createElement("td");
bdVSacCostTD.setAttribute("id","bdVSacCostTD"+NumOfRow);
bdVSacCostTD.className="tableTextPink";
bdVSacCostTD.style.width="100px";


var bdVSacCost=document.createElement("input"); //Budgeted Cost versus Actual cost Activity
bdVSacCost.name="arrCosting["+ NumOfRow +"][bdVSacCost]";
bdVSacCost.setAttribute("id","bdVSacCost"+NumOfRow);
bdVSacCost.setAttribute("readonly","true");
bdVSacCost.className="textBox textBoxRight";
bdVSacCost.type="text";
bdVSacCost.style.width="100px"; 
bdVSacCost.value="0.00";
//bdVSacCost.setAttribute("onblur","acRealVSacCost("+NumOfRow+")"); 
//=============================================================================================================

// Actual Realisation VS Actual cost (Activity wise) ==========================================================
var acRealVSacCostTD=document.createElement("td");
acRealVSacCostTD.setAttribute("id","acRealVSacCostTD"+NumOfRow);
acRealVSacCostTD.className="tableTextPink";
acRealVSacCostTD.style.width="100px";

var acRealVSacCost=document.createElement("input"); //Actual Realisation versus Actual cost Activity
acRealVSacCost.name="arrCosting["+ NumOfRow +"][acRealVSacCost]";
acRealVSacCost.setAttribute("id","acRealVSacCost"+NumOfRow);
acRealVSacCost.setAttribute("readonly","true");
acRealVSacCost.className="textBox textBoxRight";
acRealVSacCost.type="text";
acRealVSacCost.style.width="100px"; 
acRealVSacCost.value="0.00";

actTD.appendChild(Activity);
TR.appendChild(actTD);


TR.appendChild(plTD);
plTD.appendChild(plStDate);
plTD.appendChild(StImg);


TR.appendChild(elTD);
elTD.appendChild(plEdDate);
elTD.appendChild(EdImg);


TR.appendChild(acStTD);
acStTD.appendChild(acStDate);
acStTD.appendChild(acStImg);

TR.appendChild(acEdTD);
acEdTD.appendChild(acEdDate);
acEdTD.appendChild(acEdImg);

TR.appendChild(dlyTD);
dlyTD.appendChild(dlyNoDays);

TR.appendChild(percenTD);
percenTD.appendChild(workPercentage);

TR.appendChild(tskTD);
tskTD.appendChild(taskCompleted);

TR.appendChild(bdMnTD);
bdMnTD.appendChild(bdManDays);

TR.appendChild(bdPerMnTD);
bdPerMnTD.appendChild(bdCostPerManDays);

TR.appendChild(acManDaysTD);
acManDaysTD.appendChild(acManDays);

TR.appendChild(acCostTD);
acCostTD.appendChild(acCost);

TR.appendChild(exMthRealTD);
exMthRealTD.appendChild(exMthReal);

TR.appendChild(exMthRealDueTD);
exMthRealDueTD.appendChild(exMthRealDue);

TR.appendChild(exMthRealAgDlvTD);
exMthRealAgDlvTD.appendChild(exMthRealAgDlv);

TR.appendChild(exMthRealAgDlvDueTD);
exMthRealAgDlvDueTD.appendChild(exMthRealAgDlvDue);

TR.appendChild(totExRealTD);
totExRealTD.appendChild(totExReal);

TR.appendChild(acRealTD);
acRealTD.appendChild(acReal);

TR.appendChild(acVSexRealTD);
acVSexRealTD.appendChild(acVSexReal);

TR.appendChild(acRealVSbdCostTD);
acRealVSbdCostTD.appendChild(acRealVSbdCost);

TR.appendChild(bdVSacCostTD);
bdVSacCostTD.appendChild(bdVSacCost);

TR.appendChild(acRealVSacCostTD);
acRealVSacCostTD.appendChild(acRealVSacCost);

/*TR.appendChild(RemoveBtTD);
TR.appendChild(RemoveBt);*/
document.getElementById("Button12").disabled=false;

// finally append the new div to the main div

tbody.appendChild(TR);
TABLE.appendChild(tbody);
mainDiv.appendChild(TABLE);

}

var div_status1 =document.getElementById('div_Status1').value;
var div_status2 =document.getElementById('div_Status2').value;
var div_status3 =document.getElementById('div_Status3').value;
var div_status4 =document.getElementById('div_Status4').value;
var div_status5 =document.getElementById('div_Status5').value;



			/*Expand Collapse without toggle function with different conditions*/
			
			if(div_status5=="" && div_status1=="1" && div_status2=="" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
			} 
			else if (div_status5=="" && div_status1=="1" && div_status2=="" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="1" && div_status2=="" && div_status3=="3" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
			}
			else if (div_status5=="" && div_status1=="1" && div_status2=="" && div_status3=="3" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="1" && div_status2=="2" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
			}
			else if (div_status5=="" && div_status1=="1" && div_status2=="2" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="1" && div_status2=="2" && div_status3=="3" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
			}
			else if (div_status5=="" && div_status1=="1" && div_status2=="2" && div_status3=="3" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="" && div_status3=="3" && div_status4=="")
			{	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="" && div_status3=="3" && div_status4=="4")
			{	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="2" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="2" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="2" && div_status3=="3" && div_status4=="")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
			}
			else if (div_status5=="" && div_status1=="" && div_status2=="2" && div_status3=="3" && div_status4=="4")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
			}
			else if(div_status5=="" && div_status1=="" && div_status2=="" && div_status3=="" && div_status4=="")
			{
				//ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
			} 
			/**************************adding 5th div************************************/
			else if(div_status5=="5" && div_status1=="1" && div_status2=="" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			} 
			else if (div_status5=="5" && div_status1=="1" && div_status2=="" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="1" && div_status2=="" && div_status3=="3" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="1" && div_status2=="" && div_status3=="3" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="1" && div_status2=="2" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');

				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="1" && div_status2=="2" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="1" && div_status2=="2" && div_status3=="3" && div_status4=="")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="1" && div_status2=="2" && div_status3=="3" && div_status4=="4")
			{
				ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="" && div_status3=="3" && div_status4=="")
			{	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="" && div_status3=="3" && div_status4=="4")
			{	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="2" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="2" && div_status3=="" && div_status4=="4")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="2" && div_status3=="3" && div_status4=="")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if (div_status5=="5" && div_status1=="" && div_status2=="2" && div_status3=="3" && div_status4=="4")
			{
				ExpandCollapseWT('2','actTD','plTD','elTD','acStTD','acEdTD','dlyTD');	
				ExpandCollapseWT('3','actTD','exMthRealTD','exMthRealDueTD','exMthRealAgDlvTD','exMthRealAgDlvDueTD','totExRealTD','acRealTD');
				ExpandCollapseWT('4','actTD','acVSexRealTD','acRealVSbdCostTD','bdVSacCostTD','acRealVSacCostTD');
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
			}
			else if(div_status5=="5" && div_status1=="" && div_status2=="" && div_status3=="" && div_status4=="")
			{
				ExpandCollapseWT('5','actTD','bdMnTD','bdPerMnTD','acManDaysTD','acCostTD');
				//ExpandCollapseWT('1','actTD','plTD','elTD','bdMnTD','percenTD','tskTD');
			} 



}

function removeElement() {
	var cd=document.getElementById('hidcount').value;
  var d = document.getElementById('MainDiv');
  var oldtr = document.getElementById("TABLE"+cd);
 // alert("TR"+cd);
  //alert(oldtr);
  d.removeChild(oldtr);
  --NumOfRow;
 // alert(NumOfRow);
  document.getElementById('hidcount').value=NumOfRow;
if(NumOfRow<=document.getElementById("hidcountorig").value)
document.getElementById("Button12").disabled=true;
}

function ExpandCollapseWT(){
	var status=ExpandCollapseWT.arguments[0];	
	var items = ExpandCollapseWT.arguments.length;
	var subItems=document.getElementById('hidcount').value;
	
	if(status=="1"){
	//alert("Items"+items);
	//alert("Rows"+subItems);
	
				for (i = 2;i < items; i++){
					var val =ExpandCollapseWT.arguments[i];
					//alert(val);
					if(document.getElementById('H'+val).style.display==""){
						//alert(document.getElementById('H'+val).style.display);
						document.getElementById('H'+val).style.display="";
						document.getElementById('H1'+val).style.display="";
						document.getElementById('F1'+val).style.display="";
						document.getElementById('F2'+val).style.display="";
						document.getElementById('F3'+val).style.display="";
						document.getElementById('F4'+val).style.display="";
						
						for(j=1;j <= subItems;j++){
						var k=val+j;
						//alert(k);
							document.getElementById(k).style.display="";
							//document.getElementById(k).readOnly=true;
						}
						document.getElementById('div_Status'+status).value="";
					}else{
						document.getElementById('H'+val).style.display="none";
						document.getElementById('H1'+val).style.display="none";
						document.getElementById('F1'+val).style.display="none";
						document.getElementById('F2'+val).style.display="none";
						document.getElementById('F3'+val).style.display="none";
						document.getElementById('F4'+val).style.display="none";
					
						for(j=1;j <= subItems;j++){
						var k=val+j;
						//alert(k);
						document.getElementById(k).style.display="none";
						//document.getElementById(k).readOnly=false;
						}
						document.getElementById('div_Status'+status).value=status;
					}
				}
  } else {

	
				for (i = 2;i < items; i++){
					var val =ExpandCollapseWT.arguments[i];
					//alert(val);
					if(document.getElementById('H'+val).style.display==""){
						//alert(document.getElementById('H'+val).style.display);
						document.getElementById('H'+val).style.display="";
						document.getElementById('H1'+val).style.display="";
						document.getElementById('F1'+val).style.display="";
						document.getElementById('F2'+val).style.display="";
						document.getElementById('F3'+val).style.display="";
						document.getElementById('F4'+val).style.display="";
						
						for(j=1;j <= subItems;j++){
						var k=val+j;
						//alert(k);							
							document.getElementById(k).style.display="";
						}
						document.getElementById('div_Status'+status).value="";
					}else{
						document.getElementById('H'+val).style.display="none";
						document.getElementById('H1'+val).style.display="none";
						document.getElementById('F1'+val).style.display="none";
						document.getElementById('F2'+val).style.display="none";
						document.getElementById('F3'+val).style.display="none";
						document.getElementById('F4'+val).style.display="none";
					
						for(j=1;j <= subItems;j++){
						var k=val+j;
						//alert(k);
							document.getElementById(k).style.display="none";
						}
						document.getElementById('div_Status'+status).value=status;
					}
				}
  }
  
}



// FUNCTION FOR DATE VALIDATION ===============================================================================
function Validate_plSt(id){
	var dt=document.getElementById('plStDate'+id).value;
	//alert(dt);
	if (isDate(dt)==false){
		//dt.focus()
		document.getElementById('plStDate'+id).value="";
		return false;
	}
    return true
 }
function Validate_plEd(id){
	var dt=document.getElementById('plEdDate'+id).value;
	//alert(dt);
	if (isDate(dt)==false){
		//dt.focus()
		document.getElementById('plEdDate'+id).value="";
		
		return false;
	}
    return true
	
	//Caldelay1();
 }
function Validate_acSt(id){
 	var dt=document.getElementById('acStDate'+id).value;
	//alert(dt);
	if (isDate(dt)==false){
		//dt.focus()
		document.getElementById('acStDate'+id).value="";
		return false;
	}
    return true
 } 
function Validate_acEd(id){
	var dt=document.getElementById('acEdDate'+id).value;
	//alert(dt);
	if (isDate(dt)==false){
		//dt.focus()
		document.getElementById('acEdDate'+id).value="";
		
		return false;
	}
    return true
	
	//Caldelay1();
 } 
//=============================================================================================================

function CreateCal1(id) { 
	if(self.gfPop)gfPop.fPopCalendar(document.getElementById("plStDate"+id));return false;
}
function CreateCal2(id) { 
	if(self.gfPop)gfPop.fPopCalendar(document.getElementById("plEdDate"+id));return false;
}
function CreateCal3(id) { 
	if(self.gfPop)gfPop.fPopCalendar(document.getElementById("acStDate"+id));return false;
}
function CreateCal4(id) { 
	if(self.gfPop)gfPop.fPopCalendar(document.getElementById("acEdDate"+id));return false;
}

//Total :: % of work ========================================================
function totworkpercentage(){
	var totalctrl=document.getElementById('hidcount').value;
	//alert("hello"+totalctrl);
	//alert("2".id);
	var sum=0;
	for(var i=1; i<=totalctrl; i++){	
	//alert(document.getElementById('workPercentage'+i).value);
		sum=parseFloat(sum+parseFloat(document.getElementById('workPercentage'+i).value));
		//alert(sum);
		document.getElementById('totalpercentwork').value=sum.toFixed(2);
		
		
		
	}
	var yet=100-document.getElementById('totalpercentwork').value;
	document.getElementById('yetPercentwrk').value=yet.toFixed(2);
	
	var gdtotal=parseFloat(parseFloat(document.getElementById('totalpercentwork').value)+parseFloat(document.getElementById('yetPercentwrk').value));
	document.getElementById('gdtotpercentwork').value=gdtotal.toFixed(2);
	
	total_bdmandays();	
}

function onblur_bdmandays(id){
	
	var wrk=(document.getElementById('bdManDays'+id).value*100)/document.getElementById('effort').value; 
	wrk=(!isFinite(wrk))?0:wrk;
	document.getElementById('workPercentage'+id).value=wrk.toFixed(2);
	
	var Aval=document.getElementById('bdManDays'+id).value*document.getElementById('mcost').value;
	document.getElementById('bdCostPerManDays'+id).value=Aval.toFixed(2);
	
	var CAval=((document.getElementById('bdManDays'+id).value-document.getElementById('acManDays'+id).value)/(document.getElementById('bdManDays'+id).value))*100;
	//alert("123:::"+CAval);
	if(!isFinite(CAval))
	{
		CAval = 0;
	}
	if(CAval>=0){
		document.getElementById('acRealVSbdCostTD'+id).style.color="green";
		document.getElementById('acRealVSbdCost'+id).style.color="green";
	document.getElementById('acRealVSbdCost'+id).value=Math.abs(Math.round(100-CAval)); 
	} else{
		document.getElementById('acRealVSbdCostTD'+id).style.color="red";
		document.getElementById('acRealVSbdCost'+id).style.color="red";
		document.getElementById('acRealVSbdCost'+id).value=Math.abs(Math.round(100-CAval));
	}
	
	
	
	totworkpercentage();
	total_bdmandays();
}
function onblur_acmandays(id){
	
	var Dval=document.getElementById('acManDays'+id).value*document.getElementById('mcost').value;
	document.getElementById('acCost'+id).value=Dval.toFixed(2);
	
	onblur_C(id);
	onblur_bdmandays(id)
}

function onblur_due2(id){
	var sum=0;
	//alert(document.getElementById('exMthRealDue'+id).value+"TTTT"+document.getElementById('exMthRealAgDlvDue'+id).value);
	if( (document.getElementById('exMthRealDue'+id).value=='Y' || document.getElementById('exMthRealDue'+id).value=='y') && (document.getElementById('exMthRealAgDlvDue'+id).value=='Y' || document.getElementById('exMthRealAgDlvDue'+id).value=='y') ){ 
	
	var sum=parseFloat(parseFloat(document.getElementById('exMthReal'+id).value) + parseFloat(document.getElementById('exMthRealAgDlv'+id).value));
		document.getElementById('totExReal'+id).value=sum;
		//totExReal.value=sum;
	}
//else if((document.getElementById('exMthRealDue'+id).value=='N') || (document.getElementById('exMthRealDue'+id).value=='n'))
else if( (document.getElementById('exMthRealDue'+id).value=='Y' || document.getElementById('exMthRealDue'+id).value=='y') && (document.getElementById('exMthRealAgDlvDue'+id).value=='N' || document.getElementById('exMthRealAgDlvDue'+id).value=='n') ){
	var sum=document.getElementById('exMthReal'+id).value;
	document.getElementById('totExReal'+id).value=sum;
	//totExReal.value=sum;
	}
else if( (document.getElementById('exMthRealDue'+id).value=='N' || document.getElementById('exMthRealDue'+id).value=='n') && (document.getElementById('exMthRealAgDlvDue'+id).value=='Y' || document.getElementById('exMthRealAgDlvDue'+id).value=='y') ){
	var sum=document.getElementById('exMthRealAgDlv'+id).value;
	document.getElementById('totExReal'+id).value=sum;
	//totExReal.value=sum;
	}
else if( (document.getElementById('exMthRealDue'+id).value=='N' || document.getElementById('exMthRealDue'+id).value=='n') && (document.getElementById('exMthRealAgDlvDue'+id).value=='N' || document.getElementById('exMthRealAgDlvDue'+id).value=='n') ){
	//var sum=document.getElementById('exMthRealAgDlv'+id).value;
	document.getElementById('totExReal'+id).value=0;
	//totExReal.value=sum;
	}	
	
	totworkpercentage();
	total_bdmandays();
}

function onblur_C(id){
	var CBval=document.getElementById('acReal'+id).value-document.getElementById('totExReal'+id).value;
	document.getElementById('acVSexReal'+id).value=CBval.toFixed(2);
	
		var CAval=((document.getElementById('bdManDays'+id).value-document.getElementById('acManDays'+id).value)/(document.getElementById('bdManDays'+id).value))*100;
	//alert("123:::"+CAval);
	if(!isFinite(CAval))
	{
		CAval = 0;
	}
	if(CAval>=0){
		document.getElementById('acRealVSbdCostTD'+id).style.color="green";
		document.getElementById('acRealVSbdCost'+id).style.color="green";
	document.getElementById('acRealVSbdCost'+id).value=Math.abs(Math.round(100-CAval)); 
	} else{
		document.getElementById('acRealVSbdCostTD'+id).style.color="red";
		document.getElementById('acRealVSbdCost'+id).style.color="red";
		document.getElementById('acRealVSbdCost'+id).value=Math.abs(Math.round(100-CAval));
	}

	
	var CDval=document.getElementById('acReal'+id).value-document.getElementById('acCost'+id).value;
	document.getElementById('acRealVSacCost'+id).value=CDval.toFixed(2);
	
	totworkpercentage();
	total_bdmandays();
}

function calculateDA(id){
	var DAval=document.getElementById('bdCostPerManDays'+id).value-document.getElementById('acCost'+id).value;
	document.getElementById('bdVSacCost'+id).value=DAval.toFixed(2);
	//alert("1".id);
	onblur_due2(id);
}



//Total :: Budgeted Man days ================================================
function total_bdmandays(){
	var totalctrl=document.getElementById('hidcount').value;
	//alert('Hi');
	
	
	
	var sum=0, sumprof1=0; sumactmncost=0; sumbdgmncost=0; sumacmnday=0;sumbdmandays=0;
	//alert("Before loop:"+sumprof1);
	for(var i=1; i<=totalctrl; i++){
		sum=parseFloat(sum+parseFloat(document.getElementById('bdManDays'+i).value));
		document.getElementById('totbdmandays').value=sum.toFixed(2);
		
		//alert("Task Completed"+i+"::::"+document.getElementById('taskCompleted'+i).value);
		// Actual Profit (Project Value Vs Actual Cost)
		if(document.getElementById('taskCompleted'+i).value=='Y')
		{
			sumprof1=parseFloat(sumprof1+parseFloat(document.getElementById('workPercentage'+i).value));
			document.getElementById('hidprof1').value=sumprof1.toFixed(2);
			sumacmnday=parseFloat(sumacmnday+parseFloat(document.getElementById('acManDays'+i).value));
			
			sumbdmandays=parseFloat(sumbdmandays+parseFloat(document.getElementById('bdManDays'+i).value));
			
			sumbdgmncost=parseFloat(sumbdgmncost+parseFloat(document.getElementById('bdCostPerManDays'+i).value));
			sumactmncost=parseFloat(sumactmncost+parseFloat(document.getElementById('acCost'+i).value));
			
			
		}
		/*alert("After loop:"+sumprof1);
		alert("Hidden Field::"+document.getElementById('hidprof1').value);*/
		// Actual Profit (Project Value Vs Realized Amount)
		/*if(document.getElementById('taskCompleted'+i).value=='Y')
		{
			sumprof1=parseFloat(sumprof1+parseFloat(document.getElementById('workPercentage'+i).value));
			document.getElementById('hidprof1').value=sumprof1.toFixed(2);
			
			
		} */
	}
			// Billed Summary :: Actual Profit 1 & 2
			var val1=((document.getElementById('pval').value*document.getElementById('hidprof1').value)/100)-document.getElementById('gdTotal_D').value;
			document.getElementById('prof1_pvVsac').value=val1.toFixed(2);
			
			
			if(val1>0){
				document.getElementById('prof1_pvVsac').style.color="green";
				
				document.getElementById('ap').style.color="green";
			}else
			{
				document.getElementById('prof1_pvVsac').style.color="red";				
				document.getElementById('ap').style.color="red";
			}
			
			var val2=((document.getElementById('gdTotal_C').value*document.getElementById('hidprof1').value)/100)-document.getElementById('gdTotal_D').value;
			
			var val3=document.getElementById('hidprof1').value;
			
			if(val3>100)
			{
				alert("Either increase Budgeted effort(MD) or decrease budgeted Man Days")
			} else
			{
			var val4=(document.getElementById('pval').value*document.getElementById('hidprof1').value)/100;
			
			
			document.getElementById('prof2_pvVsra').value=(sumactmncost-sumbdgmncost).toFixed(2);
			
			var val2=((sumactmncost-sumbdgmncost)/sumbdgmncost);
			val2=(!isFinite(val2))?"0":val2;
			document.getElementById('prof2_pvVsra2_percen').value=Math.round(val2*100);
			if(val2>0)
			{
				document.getElementById('prof2_pvVsra').style.color="green";
				document.getElementById('co').style.color="green";
				document.getElementById('prof2_pvVsra2_percen').style.color="green";
				
			} else
			{
				document.getElementById('prof2_pvVsra').style.color="red";
				document.getElementById('co').style.color="red";
				document.getElementById('prof2_pvVsra2_percen').style.color="red";
			}
			
			
			
			// Value of Balance work (%)
			document.getElementById('balwrk').value=(100-val3).toFixed(2);
			// Value of Balance project value
			document.getElementById('cstVSac').value=((document.getElementById('pval').value*(100-val3))/100).toFixed(2);
			// Value of Percent Completed Work
			document.getElementById('percomp').value=val3;
			document.getElementById('signoff').value=val3;
			document.getElementById('prjvalcomp').value=val4.toFixed(2);
			}
			
			//alert(document.getElementById('prof1_pvVsac').value);
			
	var yet=document.getElementById('effort').value-document.getElementById('totbdmandays').value;
	document.getElementById('yetbdmandays').value=yet.toFixed(2);
	
	var gdtotal=parseFloat(parseFloat(document.getElementById('totbdmandays').value)+parseFloat(document.getElementById('yetbdmandays').value));
	
	document.getElementById('gdBdmandays').value=gdtotal.toFixed(2);
	
	// for calculating 'yet to be allocated' field of A
	var yetBdcostaspermandays=document.getElementById('yetbdmandays').value*document.getElementById('mcost').value;
	//document.getElementById('yetA').value=yetBdcostaspermandays.toFixed(2);
	// for calculating 'Total' field of A
	//alert("hi"+gdtotal);
	var sumA=0;
	for(var i=1; i<=totalctrl; i++){
		//alert(document.getElementById('bdCostPerManDays'+i).value);
		//sum=parseFloat(sum+parseFloat(document.getElementById('bdManDays'+i).value));
		
		sumA=parseFloat(sumA+parseFloat(document.getElementById('bdCostPerManDays'+i).value));
		document.getElementById('totA').value=sumA.toFixed(2);
	}
	//alert("hello"+gdtotal);
	// for calculating 'Grand Total' field of A
	var gdA=parseFloat(document.getElementById('totA').value) ;
	document.getElementById('gdTotal_A').value=gdA.toFixed(2);
		//Projected Profit ====================================================
		var proj=document.getElementById('pval').value-document.getElementById('gdTotal_A').value;
		document.getElementById('pprofit').value=proj.toFixed(2);
		if(proj.toFixed(2)>0){
		document.getElementById('pprofit').style.color="green";
		document.getElementById('pp').style.color="green";
		} else
		{
			document.getElementById('pprofit').style.color="red";
			document.getElementById('pp').style.color="red";
		}
		//Total Expected Cost ================================================
		var cost=parseFloat( parseFloat(document.getElementById('pprofit').value)+parseFloat(document.getElementById('gdTotal_A').value) );
		document.getElementById('texpcost').value=cost.toFixed(2);																											
																													
	
	
	// calculating Actual ManDays :: Grand Total
	var sumacmdays=0, sumexp=0, sumAg=0, sumTotal=0, sumAcR=0, sumCB=0, sumCA=0, sumDA=0, sumCD=0;
	for(var i=1; i<=totalctrl; i++){
		sumacmdays=parseFloat(sumacmdays+parseFloat(document.getElementById('acManDays'+i).value));
		var sumACd=parseFloat(sumacmdays+parseFloat(document.getElementById('yetmndays').value) );
		//alert(sumACd);
		document.getElementById('gdTotal_acmandays').value=sumACd.toFixed(2);
		
		//Grand Total of Expected Monthly Realisation
		sumexp=parseFloat(sumexp+parseFloat(document.getElementById('exMthReal'+i).value));
		var sumexp1=parseFloat(sumexp+parseFloat(document.getElementById('yetExp').value) );
		document.getElementById('gdTotal_expmonRel').value=sumexp1.toFixed(2);
		
		//Grand Total of Expected Realisation Against delivery
		sumAg=parseFloat(sumAg+parseFloat(document.getElementById('exMthRealAgDlv'+i).value));
		var sumAg1=parseFloat(sumAg+parseFloat(document.getElementById('yetexpAgdil').value) );
		document.getElementById('gdTotal_AgDil').value=sumAg1.toFixed(2);
		
		//Grand Total of Total Expected Realisation
		sumTotal=parseFloat(sumTotal+parseFloat(document.getElementById('totExReal'+i).value));
		var sumTotal1=parseFloat(sumTotal+parseFloat(document.getElementById('yettotexRel').value) );
		document.getElementById('gdTotal_totexpReal').value=sumTotal1.toFixed(2);
				// Billed Amount
				document.getElementById('bamt').value=sumTotal1.toFixed(2);
		
		//Grand Total of Actual Realisation
		sumAcR=parseFloat(sumAcR+parseFloat(document.getElementById('acReal'+i).value));
		var sumAcR1=parseFloat(sumAcR+parseFloat(document.getElementById('yetC').value) );
		document.getElementById('gdTotal_C').value=sumAcR1.toFixed(2);
				// Realized Amount
				document.getElementById('ramt').value=sumAcR1.toFixed(2);
				// Due Amount
				var due=document.getElementById('bamt').value-document.getElementById('ramt').value;
				//alert(due);
				//document.getElementById('damt').value=due.toFixed(2);
		
		//Grand Total of C-B
		sumCB=parseFloat(sumCB+parseFloat(document.getElementById('acVSexReal'+i).value));
		var sumCB1=parseFloat(sumCB+parseFloat(document.getElementById('yetCB').value) );
		document.getElementById('gdTotal_CB').value=sumCB1.toFixed(2);		
		document.getElementById('damt').value=sumCB1.toFixed(2);
		
		if(sumCB1.toFixed(2)>100)
		{
			document.getElementById('damt').style.color="green";
			document.getElementById('OA').style.color="green";
		} else
		{
			document.getElementById('damt').style.color="red";
			document.getElementById('OA').style.color="red";
		}
		
		//Grand Total of C-A
		sumCA=parseFloat(sumCA+parseFloat(document.getElementById('acRealVSbdCost'+i).value));
		var sumCA1=parseFloat(sumCA+parseFloat(document.getElementById('yetCA').value) );
		sumCA1=(!isFinite(sumCA1))?0:sumCA1;
		document.getElementById('gdTotal_CA').value=sumCA1.toFixed(2);
		
		//Grand Total of D-A
		sumDA=parseFloat(sumDA+parseFloat(document.getElementById('bdVSacCost'+i).value));
		var sumDA1=parseFloat(sumDA+parseFloat(document.getElementById('yetDA').value) );
		document.getElementById('gdTotal_DA').value=sumDA1.toFixed(2);
		
		//Grand Total of C-D
		sumCD=parseFloat(sumCD+parseFloat(document.getElementById('acRealVSacCost'+i).value));
		var sumCD1=parseFloat(sumCD+parseFloat(document.getElementById('yetCD').value) );
		document.getElementById('gdTotal_CD').value=sumCD1.toFixed(2);
	}
	
	
	
	
	
	
	// Actual Cost (D):: Yet calculation
	var yetacCost=document.getElementById('yetmndays').value*document.getElementById('mcost').value;
	document.getElementById('yetD').value=yetacCost.toFixed(2);
	// Actual Cost (D):: Grand Total
	var sumAccost=0;
	
	for(var i=1; i<=totalctrl; i++){
		//alert(document.getElementById('acCost'+i).value);
		sumAccost=parseFloat( sumAccost+parseFloat(document.getElementById('acCost'+i).value) );
		var sum1=parseFloat(sumAccost+parseFloat(document.getElementById('yetD').value) );
		document.getElementById('gdTotal_D').value=sum1.toFixed(2);
	}
	
	// Calculation of balance MM %
	//var mid=if(document.getElementById('hidprof1').value=="")?"0.00":document.getElementById('hidprof1').value;
	var cde= 100-((sumacmnday/sumbdmandays)*100)
	cde=(!isFinite(cde))?"0":cde;
	
	document.getElementById('balMM').value=Math.round(cde);
	
	document.getElementById('hidprof1').value="0.00"
}

//Total :: A =================================================================
function total_A(){
	var totalctrl=document.getElementById('hidcount').value;
	var sum=0;
	for(var i=1; i<=totalctrl; i++){
		sum=parseFloat(sum+parseFloat(document.getElementById('bdCostPerManDays'+i).value));
		document.getElementById('totA').value=sum.toFixed(2);
	}
	
	totworkpercentage();
}

/************************************************Init function******************************************/

/*function initCost()
{
	var totalctrl=document.getElementById('hidcount').value;
	
	for(var i=1; i<=totalctrl; i++)
	{
		//onblur_bdmandays(i);
		onblur_acmandays(i);
		//onblur_due2(i);
		//onblur_C(i);
		Caldlydate(i);
		calculateDA(i);
	}
	total_A()
	
}*/


function initCost()
{
	var totalctrl=document.getElementById('hidcount').value;
		var sum=0, sumprof1=0; sumactmncost=0; sumbdgmncost=0; sumacmnday=0;sumbdmandays=0;
		var sumA=0;
	var sumacmdays=0, sumexp=0, sumAg=0, sumTotal=0, sumAcR=0, sumCB=0, sumCA=0, sumDA=0, sumCD=0;
		var sumAccost=0;
	var sum_A=0,sum2=0,sum1=0;



	
	for(var i=1; i<=totalctrl; i++)
	{
		//alert(document.getElementById('workPercentage'+i).value);
		sum1=parseFloat(sum1+parseFloat(document.getElementById('workPercentage'+i).value));
		document.getElementById('totalpercentwork').value=sum1.toFixed(2);
		var wrk=(document.getElementById('bdManDays'+i).value*100)/document.getElementById('effort').value; 
		wrk=(!isFinite(wrk))?0:wrk;
		document.getElementById('workPercentage'+i).value=wrk.toFixed(2);
	
		var Aval=document.getElementById('bdManDays'+i).value*document.getElementById('mcost').value;
		document.getElementById('bdCostPerManDays'+i).value=Aval.toFixed(2);
	
		var CAval=((document.getElementById('bdManDays'+i).value-document.getElementById('acManDays'+i).value)/(document.getElementById('bdManDays'+i).value))*100;
		if(!isFinite(CAval))
		{
			CAval = 0;
		}
		if(CAval>=0){
			document.getElementById('acRealVSbdCostTD'+i).style.color="green";
			document.getElementById('acRealVSbdCost'+i).style.color="green";
		document.getElementById('acRealVSbdCost'+i).value=Math.abs(Math.round(100-CAval)); 
		} else{
			document.getElementById('acRealVSbdCostTD'+i).style.color="red";
			document.getElementById('acRealVSbdCost'+i).style.color="red";
			document.getElementById('acRealVSbdCost'+i).value=Math.abs(Math.round(100-CAval));
		}

		var Dval=document.getElementById('acManDays'+i).value*document.getElementById('mcost').value;
		document.getElementById('acCost'+i).value=Dval.toFixed(2);

	
		var sum=0;
		if( (document.getElementById('exMthRealDue'+i).value=='Y' || document.getElementById('exMthRealDue'+i).value=='y') && (document.getElementById('exMthRealAgDlvDue'+i).value=='Y' || document.getElementById('exMthRealAgDlvDue'+i).value=='y') ){ 
		
		var sum=parseFloat(parseFloat(document.getElementById('exMthReal'+i).value) + parseFloat(document.getElementById('exMthRealAgDlv'+i).value));
			document.getElementById('totExReal'+i).value=sum;
		}
		else if( (document.getElementById('exMthRealDue'+i).value=='Y' || document.getElementById('exMthRealDue'+i).value=='y') && (document.getElementById('exMthRealAgDlvDue'+i).value=='N' || document.getElementById('exMthRealAgDlvDue'+i).value=='n') ){
			var sum=document.getElementById('exMthReal'+i).value;
			document.getElementById('totExReal'+i).value=sum;
		}
		else if( (document.getElementById('exMthRealDue'+i).value=='N' || document.getElementById('exMthRealDue'+i).value=='n') && (document.getElementById('exMthRealAgDlvDue'+i).value=='Y' || document.getElementById('exMthRealAgDlvDue'+i).value=='y') ){
			var sum=document.getElementById('exMthRealAgDlv'+i).value;
			document.getElementById('totExReal'+i).value=sum;
		}
		else if( (document.getElementById('exMthRealDue'+i).value=='N' || document.getElementById('exMthRealDue'+i).value=='n') && (document.getElementById('exMthRealAgDlvDue'+i).value=='N' || document.getElementById('exMthRealAgDlvDue'+i).value=='n') ){
			document.getElementById('totExReal'+i).value=0;
		}	

		var CBval=document.getElementById('acReal'+i).value-document.getElementById('totExReal'+i).value;
		document.getElementById('acVSexReal'+i).value=CBval.toFixed(2);
	
		var CAval=((document.getElementById('bdManDays'+i).value-document.getElementById('acManDays'+i).value)/(document.getElementById('bdManDays'+i).value))*100;
		if(!isFinite(CAval))
		{
			CAval = 0;
		}
		if(CAval>=0){
			document.getElementById('acRealVSbdCostTD'+i).style.color="green";
			document.getElementById('acRealVSbdCost'+i).style.color="green";
		document.getElementById('acRealVSbdCost'+i).value=Math.abs(Math.round(100-CAval)); 
		} else{
			document.getElementById('acRealVSbdCostTD'+i).style.color="red";
			document.getElementById('acRealVSbdCost'+i).style.color="red";
			document.getElementById('acRealVSbdCost'+i).value=Math.abs(Math.round(100-CAval));
		}

	
		var CDval=document.getElementById('acReal'+i).value-document.getElementById('acCost'+i).value;
		document.getElementById('acRealVSacCost'+i).value=CDval.toFixed(2);

		var DAval=document.getElementById('bdCostPerManDays'+i).value-document.getElementById('acCost'+i).value;
		document.getElementById('bdVSacCost'+i).value=DAval.toFixed(2);

				sum2=parseFloat(sum2+parseFloat(document.getElementById('bdManDays'+i).value));
		document.getElementById('totbdmandays').value=sum2.toFixed(2);
		
		if(document.getElementById('taskCompleted'+i).value=='Y')
		{
			sumprof1=parseFloat(sumprof1+parseFloat(document.getElementById('workPercentage'+i).value));
			document.getElementById('hidprof1').value=sumprof1.toFixed(2);
			sumacmnday=parseFloat(sumacmnday+parseFloat(document.getElementById('acManDays'+i).value));
			
			sumbdmandays=parseFloat(sumbdmandays+parseFloat(document.getElementById('bdManDays'+i).value));
			
			sumbdgmncost=parseFloat(sumbdgmncost+parseFloat(document.getElementById('bdCostPerManDays'+i).value));
			sumactmncost=parseFloat(sumactmncost+parseFloat(document.getElementById('acCost'+i).value));
		}


		sumA=parseFloat(sumA+parseFloat(document.getElementById('bdCostPerManDays'+i).value));
		document.getElementById('totA').value=sumA.toFixed(2);

		sumacmdays=parseFloat(sumacmdays+parseFloat(document.getElementById('acManDays'+i).value));
		var sumACd=parseFloat(sumacmdays+parseFloat(document.getElementById('yetmndays').value) );
		//alert(sumACd);
		document.getElementById('gdTotal_acmandays').value=sumACd.toFixed(2);
		
		//Grand Total of Expected Monthly Realisation
		sumexp=parseFloat(sumexp+parseFloat(document.getElementById('exMthReal'+i).value));
		var sumexp1=parseFloat(sumexp+parseFloat(document.getElementById('yetExp').value) );
		document.getElementById('gdTotal_expmonRel').value=sumexp1.toFixed(2);
		
		//Grand Total of Expected Realisation Against delivery
		sumAg=parseFloat(sumAg+parseFloat(document.getElementById('exMthRealAgDlv'+i).value));
		var sumAg1=parseFloat(sumAg+parseFloat(document.getElementById('yetexpAgdil').value) );
		document.getElementById('gdTotal_AgDil').value=sumAg1.toFixed(2);
		
		//Grand Total of Total Expected Realisation
		sumTotal=parseFloat(sumTotal+parseFloat(document.getElementById('totExReal'+i).value));
		var sumTotal1=parseFloat(sumTotal+parseFloat(document.getElementById('yettotexRel').value) );
		document.getElementById('gdTotal_totexpReal').value=sumTotal1.toFixed(2);
				// Billed Amount
				document.getElementById('bamt').value=sumTotal1.toFixed(2);
		
		//Grand Total of Actual Realisation
		sumAcR=parseFloat(sumAcR+parseFloat(document.getElementById('acReal'+i).value));
		var sumAcR1=parseFloat(sumAcR+parseFloat(document.getElementById('yetC').value) );
		document.getElementById('gdTotal_C').value=sumAcR1.toFixed(2);
				// Realized Amount
				document.getElementById('ramt').value=sumAcR1.toFixed(2);
				// Due Amount
				var due=document.getElementById('bamt').value-document.getElementById('ramt').value;
				//alert(due);
				//document.getElementById('damt').value=due.toFixed(2);
		
		//Grand Total of C-B
		sumCB=parseFloat(sumCB+parseFloat(document.getElementById('acVSexReal'+i).value));
		var sumCB1=parseFloat(sumCB+parseFloat(document.getElementById('yetCB').value) );
		document.getElementById('gdTotal_CB').value=sumCB1.toFixed(2);		
		document.getElementById('damt').value=sumCB1.toFixed(2);
		
		if(sumCB1.toFixed(2)>100)
		{
			document.getElementById('damt').style.color="green";
			document.getElementById('OA').style.color="green";
		} else
		{
			document.getElementById('damt').style.color="red";
			document.getElementById('OA').style.color="red";
		}
		
		//Grand Total of C-A
		sumCA=parseFloat(sumCA+parseFloat(document.getElementById('acRealVSbdCost'+i).value));
		var sumCA1=parseFloat(sumCA+parseFloat(document.getElementById('yetCA').value) );
		sumCA1=(!isFinite(sumCA1))?0:sumCA1;
		document.getElementById('gdTotal_CA').value=sumCA1.toFixed(2);
		
		//Grand Total of D-A
		sumDA=parseFloat(sumDA+parseFloat(document.getElementById('bdVSacCost'+i).value));
		var sumDA1=parseFloat(sumDA+parseFloat(document.getElementById('yetDA').value) );
		document.getElementById('gdTotal_DA').value=sumDA1.toFixed(2);
		
		//Grand Total of C-D
		sumCD=parseFloat(sumCD+parseFloat(document.getElementById('acRealVSacCost'+i).value));
		var sumCD1=parseFloat(sumCD+parseFloat(document.getElementById('yetCD').value) );
		document.getElementById('gdTotal_CD').value=sumCD1.toFixed(2);

		sumAccost=parseFloat( sumAccost+parseFloat(document.getElementById('acCost'+i).value) );

		var sum6=parseFloat(sumAccost+parseFloat(document.getElementById('yetD').value) );
		document.getElementById('gdTotal_D').value=sum6.toFixed(2);

		sum_A=parseFloat(sum_A+parseFloat(document.getElementById('bdCostPerManDays'+i).value));
		document.getElementById('totA').value=sum_A.toFixed(2);
				Caldlydate(i);

	}

	var yet=100-document.getElementById('totalpercentwork').value;
	document.getElementById('yetPercentwrk').value=yet.toFixed(2);
	
	var gdtotal=parseFloat(parseFloat(document.getElementById('totalpercentwork').value)+parseFloat(document.getElementById('yetPercentwrk').value));
	document.getElementById('gdtotpercentwork').value=gdtotal.toFixed(2);

	var val1=((document.getElementById('pval').value*sumprof1.toFixed(2))/100)-document.getElementById('gdTotal_D').value;
	document.getElementById('prof1_pvVsac').value=val1.toFixed(2);
			
			
			if(val1>0){
				document.getElementById('prof1_pvVsac').style.color="green";
				
				document.getElementById('ap').style.color="green";
			}else
			{
				document.getElementById('prof1_pvVsac').style.color="red";				
				document.getElementById('ap').style.color="red";
			}
			
			var val2=((document.getElementById('gdTotal_C').value*document.getElementById('hidprof1').value)/100)-document.getElementById('gdTotal_D').value;
			
			var val3=document.getElementById('hidprof1').value;
			
			if(val3>100)
			{
				alert("Either increase Budgeted effort(MD) or decrease budgeted Man Days")
			} else
			{
			var val4=(document.getElementById('pval').value*document.getElementById('hidprof1').value)/100;
			
			//alert("sumactmncost"+sumactmncost+"::::sumbdgmncost"+sumbdgmncost);
			document.getElementById('prof2_pvVsra').value=(sumactmncost-sumbdgmncost).toFixed(2);
			
			var val2=((sumactmncost-sumbdgmncost)/sumbdgmncost);
			val2=(!isFinite(val2))?"0":val2;
			document.getElementById('prof2_pvVsra2_percen').value=Math.round(val2*100);
			if(val2>0)
			{
				document.getElementById('prof2_pvVsra').style.color="green";
				document.getElementById('co').style.color="green";
				document.getElementById('prof2_pvVsra2_percen').style.color="green";
				
			} else
			{
				document.getElementById('prof2_pvVsra').style.color="red";
				document.getElementById('co').style.color="red";
				document.getElementById('prof2_pvVsra2_percen').style.color="red";
			}
			
			
			
			// Value of Balance work (%)
			document.getElementById('balwrk').value=(100-val3).toFixed(2);
			// Value of Balance project value
			document.getElementById('cstVSac').value=((document.getElementById('pval').value*(100-val3))/100).toFixed(2);
			// Value of Percent Completed Work
			document.getElementById('percomp').value=val3;
			document.getElementById('signoff').value=val3;
			document.getElementById('prjvalcomp').value=val4.toFixed(2);
			}
			
			
	var yet=document.getElementById('effort').value-document.getElementById('totbdmandays').value;
	document.getElementById('yetbdmandays').value=yet.toFixed(2);
	
	var gdtotal=parseFloat(parseFloat(document.getElementById('totbdmandays').value)+parseFloat(document.getElementById('yetbdmandays').value));
	
	document.getElementById('gdBdmandays').value=gdtotal.toFixed(2);
	
	// for calculating 'yet to be allocated' field of A
	var yetBdcostaspermandays=document.getElementById('yetbdmandays').value*document.getElementById('mcost').value;
	//document.getElementById('yetA').value=yetBdcostaspermandays.toFixed(2);
	// for calculating 'Total' field of A


		// for calculating 'Grand Total' field of A
	var gdA=parseFloat(document.getElementById('totA').value) ;
	document.getElementById('gdTotal_A').value=gdA.toFixed(2);
		//Projected Profit ====================================================
		var proj=document.getElementById('pval').value-document.getElementById('gdTotal_A').value;
		document.getElementById('pprofit').value=proj.toFixed(2);
		if(proj.toFixed(2)>0){
		document.getElementById('pprofit').style.color="green";
		document.getElementById('pp').style.color="green";
		} else
		{
			document.getElementById('pprofit').style.color="red";
			document.getElementById('pp').style.color="red";
		}
		//Total Expected Cost ================================================
		var cost=parseFloat( parseFloat(document.getElementById('pprofit').value)+parseFloat(document.getElementById('gdTotal_A').value) );
		document.getElementById('texpcost').value=cost.toFixed(2);																											
																													

	
	// Actual Cost (D):: Yet calculation
	var yetacCost=document.getElementById('yetmndays').value*document.getElementById('mcost').value;
	document.getElementById('yetD').value=yetacCost.toFixed(2);
	// Actual Cost (D):: Grand Total
	

		// Calculation of balance MM %
	//var mid=if(document.getElementById('hidprof1').value=="")?"0.00":document.getElementById('hidprof1').value;
	var cde= 100-((sumacmnday/sumbdmandays)*100)
	cde=(!isFinite(cde))?"0":cde;
	
	document.getElementById('balMM').value=Math.round(cde);
	
	document.getElementById('hidprof1').value="0.00"



	
}



/*************************************Tab View Functions********************************************/


function tabview_aux(TabViewId, CurrentId)
{
  var TabView = document.getElementById(TabViewId);

  // ***** Tabs *****

  var Tabs = TabView.firstChild;
  while (Tabs.className != "Tabs") Tabs = Tabs.nextSibling;
  var Tab  = Tabs   .firstChild;
  var i    = 0;

  do
  {
    if (Tab.tagName == "A")
    {
      i++;
      Tab.href         = "javascript:tabview_switch('"+TabViewId+"', "+i+");";
      Tab.className    = (i == CurrentId) ? "Current" : "";
      Tab.blur();
    }
  }
  while (Tab = Tab.nextSibling);

  // ***** Pages *****

  var Pages = TabView.firstChild;
  while (Pages.className != 'Pages') Pages = Pages.nextSibling;
  var Page  = Pages  .firstChild;
  var i     = 0;

  do
  {
    if (Page.className == 'Page')
    {
      i++;
      if (Pages.offsetHeight) Page.style.height = (Pages.offsetHeight-2)+"px";
      Page.style.display  = (i == CurrentId) ? 'block' : 'none';
    }
  }
  while (Page = Page.nextSibling);
}


// ***** Tab View **************************************************************

function tabview_switch(TabViewId, id) { tabview_aux(TabViewId, id); }
function tabview_initialize(TabViewId) { tabview_aux(TabViewId,  1); }



