function chkCharacter(obj,maxlimit,objMessage) {
	var objMessage,field,num;
	objMessage=document.getElementById(objMessage);
	field=obj;
	num=(maxlimit-field.value.length);
	if(num<=0) {
		num=0;
		objMessage.style.color='red';
	} else {
		objMessage.style.color='green';
	}
    objMessage.innerHTML=num+" Character Remaining.";
    if (field.value.length > maxlimit) 
		field.value = field.value.substring(0, maxlimit);
}

function isnotemail(email) {
		var regEx = /^[\w\.\+-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]{2,6}$/;
		if(!regEx.test(email)) 
  		{
    		return true;
  		}
  		return false;
}
////////////////////////////////////////////////////////////////////
var charSetName="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
function isName(myst) {
	var i;
	for (i = 0; i < myst.length; i++) {
		var c = myst.charAt(i);
		if (charSetName.indexOf(c) < 0) {
			return false;
		}
	}
	return true;
}


var charSetNameOther=" abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
function isNameOther(myst) {
	var i;
	for (i = 0; i < myst.length; i++) {
		var c = myst.charAt(i);
		if (charSetNameOther.indexOf(c) < 0) {
			return false;
		}
	}
	return true;
}

var numSet="1234567890";
function isNumber(myst) {
	var i;
	for (i = 0; i < myst.length; i++) {
		var c = myst.charAt(i);
		if (numSet.indexOf(c) < 0) {
			return false;
		}
	}
	return true;
}
var numSetDec="1234567890.";
function isNumberDec(myst) {
	var i,noOfDec=0,decPos=0;
	var splitArr;
	for (i = 0; i < myst.length; i++) {
		var c = myst.charAt(i);
		if(c=='.') {
			noOfDec++;
			decPos=i;
		}
		if (numSetDec.indexOf(c) < 0) {
			return false;
		}
	}
	
	if(noOfDec>=1) {
		splitArr=myst.split("."); 
		//alert("splitArr.length="+splitArr.length);
		if(splitArr.length>2) {
			//alert("Invalid Number");	
			return false;
		} else {
			var firstVal=splitArr[0];
			var secondValue=splitArr[1];
			//alert(secondValue.length);
			if(secondValue.length==0 || secondValue.length>2) {
				//alert("Invalid format");
				return false ;
			}
			
		}
	}
	
	
	return true;
}
///////////////////////////////////////////////////////////////////////////
function checkRoomSearchDate(input) {
	var validformat=/^\d{2}\/\d{2}\/\d{4}$/;
	var returnval=false;
	if (!validformat.test(input))
		returnval=false;
	else { 
		var monthfield=input.split("/")[0];
		var dayfield=input.split("/")[1];
		var yearfield=input.split("/")[2];
		var returnval = new Date(yearfield, monthfield-1, dayfield);
		/*if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
		returnval=false; else returnval=t*/
	}
	return returnval;
}
function jShow(obj) {	
	$("#"+obj).show();		
}
function jHide(obj) {
	$("#"+obj).hide();		
}
function objShow(obj) {
	var ct=document.getElementById(obj);
	ct.style.display='';	
}
function objHide(obj) {
	var ct=document.getElementById(obj);
	ct.style.display='none';	
}
function showErr(msg) {
	var matter="<div class='notification error'>";
	matter=matter+"<div class='text'>";
	matter=matter+"	<p><strong></strong>"+msg +"</p></div></div>";
	return matter;			  		
}
/*function showErr(msg) {
	var matter="<div class='notification error'>";
	matter=matter+"<div class='text'>";
	matter=matter+"	<p><strong>Error!</strong>"+msg +"</p></div></div>";
	return matter;			  		
}*/
function showSucc(msg) {
	var matter="<div class='notification success'>";
	matter=matter+"<div class='text'>";
	matter=matter+"	<p><strong>Success!</strong>"+msg +"</p></div></div>";
	return matter;			  		
}
function nextFocus(nextID) {
	$("#"+nextID).focus();				  		
}
function setFocusSubmit(e){
 var cd=0;
 if(window.event) { 
  cd = e.keyCode;
 } else if(e.which) { 
  cd = e.which;
 }
 if(cd==13) {
  return true;
 } else {
  return false;
 }
}


