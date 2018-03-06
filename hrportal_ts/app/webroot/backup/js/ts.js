var NumOfRow=1;
 
function TS(obj , NextStartTime , NextEndTime , NextDate , Flag , RowTotTime){
NumOfRow++;
//document.getElementById('hidcount').value=NumOfRow;
document.lveForm.tot_ctrl.value=NumOfRow++;
var mainDiv=document.getElementById("TR1");
var weekNumber=document.lveForm.sDate.value.split('-');
//alert(weekNumber[1]);

// create new TR that will work as a container
var TR=document.createElement("tr");
TR.setAttribute("id","TR"+NumOfRow);


var weekComboTD=document.createElement("td"); // Week Days TD
weekComboTD.setAttribute("id","weekComboTD"+NumOfRow);
weekComboTD.setAttribute("class","textBox");


var stTimeTD=document.createElement("td");
stTimeTD.setAttribute("id","stTimeTD"+NumOfRow);
stTimeTD.setAttribute("class","textBox");
//stTimeTD.setAttribute("width","11%");

var stTime=document.createElement("input");// Start Time
stTime.name="arrCosting["+ NumOfRow +"][stTime]";
stTime.setAttribute("id","stTime"+NumOfRow);
stTime.setAttribute("maxlength","10");
stTime.type="text";
stTime.size="5";


var edTimeTD=document.createElement("td");
edTimeTD.setAttribute("id","edTimeTD"+NumOfRow);
edTimeTD.setAttribute("class","textBox");
//edTimeTD.setAttribute("width","8%");


var edTime=document.createElement("input"); // End Tine
edTime.setAttribute("name","arrCosting["+ NumOfRow +"][edTime]");

edTime.setAttribute("id","edTime"+NumOfRow);
edTime.setAttribute("maxlength","10");
edTime.type="text";
edTime.size="5";


var hrsTD=document.createElement("td");
hrsTD.setAttribute("id","hrsTD"+NumOfRow);
hrsTD.setAttribute("class","textBox");
//hrsTD.setAttribute("width","8%");


var totHrs=document.createElement("input");//Total Time
totHrs.name="arrCosting["+ NumOfRow +"][Hrs]";
totHrs.setAttribute("id","totHrs"+NumOfRow);
totHrs.setAttribute("maxlength","10");
totHrs.type="text";
totHrs.size="5";

totHrs.setAttribute("readonly","true");


// Modules ==============================================================================
var moduleTD=document.createElement("td");
moduleTD.setAttribute("id","moduleTD"+NumOfRow);
moduleTD.setAttribute("class","textBox");
//moduleTD.setAttribute("width","12%");

var Module=document.createElement("input"); //Module
Module.name="arrCosting["+ NumOfRow +"][Module]";
Module.setAttribute("id","Module"+NumOfRow);
Module.setAttribute("maxlength","5");
Module.type="text";
Module.size="8";
//===================================================================================================

// Remarks =======================================================================================
var remarksTD=document.createElement("td");
remarksTD.setAttribute("id","remarksTD"+NumOfRow);
remarksTD.setAttribute("class","textBox");
//remarksTD.setAttribute("width","16%");


var Remarks=document.createElement("textarea"); //
Remarks.name="arrCosting["+ NumOfRow +"][Remarks]";
Remarks.setAttribute("id","Remarks"+NumOfRow);
Remarks.rows="2";
Remarks.cols="10";
Remarks.setAttribute("onMouseOver","coj_f_pop_up_width(this),coj_f_dyn_changecolor(this.form,this);");
Remarks.setAttribute("onFocus","coj_f_pop_up_width(this),coj_f_dyn_changecolor(this.form,this);");
Remarks.setAttribute("onChange","coj_f_original_width(this),coj_f_dyn_original(this.form,this);");
Remarks.setAttribute("onmouseout","coj_f_original_width(this),coj_f_dyn_original(this.form,this);");
Remarks.setAttribute("onblur","coj_f_original_width(this),coj_f_dyn_original(this.form,this);");



//Program ==================================================================================================
var ProgramTD=document.createElement("td");
ProgramTD.setAttribute("id","ProgramTD"+NumOfRow);
ProgramTD.setAttribute("class","textBox");
//ProgramTD.setAttribute("width","16%");

var Program=document.createElement("textarea"); 
Program.name="arrCosting["+ NumOfRow +"][Program]";
Program.setAttribute("id","Program"+NumOfRow);
Program.rows="2";
Program.cols="10";
// ===================================================================================================

// Form-Report  ====================================================================================
var frmTD=document.createElement("td");
frmTD.setAttribute("id","frmTD"+NumOfRow);
frmTD.setAttribute("class","textBox");
//frmTD.setAttribute("width","12%");

var FrmRep=document.createElement("input");
FrmRep.name="arrCosting["+ NumOfRow +"][FrmRep]";
FrmRep.setAttribute("id","taskCompleted"+NumOfRow);
FrmRep.type="text";
FrmRep.size="10";

// REMOVE Button ==============================================================================================
var RemoveBtTD=document.createElement("td");
RemoveBtTD.setAttribute("id","RemoveBtTD"+NumOfRow);

var RemoveBt=document.createElement("input");
RemoveBt.type="button";
RemoveBt.value="Remove";
RemoveBt.id="btn"+NumOfRow;
RemoveBt.className="linkbtn";


// attach event for remove button click
RemoveBt.onclick=function RemoveEntry() { 
var mainDiv=document.getElementById("TR1");
mainDiv.removeChild(this.parentNode);
}

// Apprending Child to parent.
TR.appendChild(weekComboTD);

TR.appendChild(stTimeTD);
stTimeTD.appendChild(stTime);


TR.appendChild(edTimeTD);
edTimeTD.appendChild(edTime);

TR.appendChild(hrsTD);
hrsTD.appendChild(totHrs);

TR.appendChild(moduleTD);
moduleTD.appendChild(Module);

TR.appendChild(remarksTD);
remarksTD.appendChild(Remarks);

TR.appendChild(ProgramTD);
ProgramTD.appendChild(Program);

TR.appendChild(frmTD);
frmTD.appendChild(FrmRep);

TR.appendChild(RemoveBtTD);
RemoveBtTD.appendChild(RemoveBt);

// finally append the new div to the main div
mainDiv.appendChild(TR);

SetRowCombo(weekNumber[1] , NumOfRow , NextDate , Flag);
TotalTimeCalulate();
}



