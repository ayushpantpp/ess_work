
/*
 author : Diwakar Upadhyay
 date  : 17/06/2011
 type : you want use condition.
 name : text box OR select box name
 value : Select box value in array format. like array('<option value='rr'></option>','<option value='rr'></option>'...)
 class : use class name in array like array('drop','text');
 disposition : Display position `div id` ;
 limit : Use limit you want add more button.
 hideaddbutton : alter limit hide more button  like add more
 hidemaxN : alter limit hide max 5  like Add More [Max 5]
*/

function add_more(type,name,value,class,disposition,limit,hideaddbutton,hidemaxN)
{


var  html="";

var current_addmore=$('input[id$="'+name+'"]').length;
	if(class.length==0)
	 {
		  class1='drop';
		  class2='input-txt';
			} else {
					 class1=class[0];
					 class2=class[1];
						}
						
	
	if(value!="")
	{
	  var selvalue=value;	
	 }
	  else 
	  {
		  selvalue="<option value=''>Select</option><option value='91'>+91</option>";
	  	 	}

 switch(type)
 {
    
	//////////////////////  Use Fax No , Mobile No and Phone No Script   
	
	case'phone':
			
	if(current_addmore < limit )
	{
 html+='<br><select style="width: 45px;" class="'+class1+'" name="sel'+name+'[]">'+selvalue+'</select>&nbsp;<input type="text" onblur="setcode()" class="'+class2+'" name="'+name+'[]" id="'+name+'">';
} 

 else {  
        document.getElementById(hideaddbutton).style.display='none';
		if(hidemaxN!="")
		{
			document.getElementById(hidemaxN).style.display='none';
			}
 		}
    break;
	
/////////////////////////////////////////////  End Fax No , Mobile No and Phone No Script ////////////////////////////////////////	
	
	
/////////////   Use Email  

  case 'email':
  
  if(current_addmore < limit )
	{
html+='<br><input type="text" class="'+class1+'" name="'+name+'[]" id="'+name+'">';
	}

else {  
        document.getElementById(hideaddbutton).style.display='none';
		if(hidemaxN!="")
		{
			document.getElementById(hidemaxN).style.display='none';
			}
 		}
	break;
	
/////////////////////////////////  End Email 	


/////////////   Use select Box  

  case 'dropdown':
  var current_addmoresel=$('select[id$="'+name+'"]').length;

  if(current_addmoresel < limit )
	{
html+='<br><select class="'+class1+'" name="'+name+'[]" id="'+name+'" >'+selvalue+'></select>';		
	}

else {  
        document.getElementById(hideaddbutton).style.display='none';
		if(hidemaxN!="")
		{
			document.getElementById(hidemaxN).style.display='none';
			}
 		}
	break;
	
/////////////////////////////////  End Select Box



   }    ///// End Switch case
   
   
    $("#"+disposition).append(html);
	
 }    //// End Function 