// This functioin is used to prepare the id string based on different actions.
function prepare_string(obj , act , id1)
{	
	
	var MaxChks = parseInt(obj.chk_id.length);
	var ret = "" ;
	
	if ( isNaN(MaxChks) )
	{
		MaxChks = 0;
	}
	
	var count_chks = 0;
	
	if(act == "all")
	{	
		if ( MaxChks == 0 )			// if MaxChks is 0 then chk_id is not an array
		{
			if (obj.chk_id.checked )
			{
				ret = obj.chk_id.value;
				
				count_chks++;
			}
		}
		else
		{
			for ( i = 0; i < MaxChks; i++)
			{
				if (obj.chk_id[i].checked )
				{
					if(ret == "")
					{
						
						ret = obj.chk_id[i].value;
					}
					else
					{
						ret += "," + obj.chk_id[i].value;
					}
					
					count_chks++;
				}
			}
		}
	}
	else if(act == "rem")
	{
		// Remove the id unchecked.				
		if(obj.chk_ids.value == "")
		{
			ret = "";
		}
		else
		{
			// Exploding the chk ids string to obtain the individual ids
			var chk_ids_arr = obj.chk_ids.value.split(",");
			
			var arr_count = chk_ids_arr.length;
			
			for(var i=0; i<arr_count; i++)
			{
				if(chk_ids_arr[i] != id1)
				{
					if(ret == "")
					{
						ret = chk_ids_arr[i];
					}
					else
					{
						ret += "," + chk_ids_arr[i];
					}
				}
			}
		}
	}
	else if(act == "inc")
	{
		// Include the id unchecked.				
		if(obj.chk_ids.value == "")
		{
			ret = id1;
		}
		else
		{
			ret = obj.chk_ids.value + "," + id1;
		}
	}
	
	return ret;
}

// This function is used the select or deselect the multiple checkboxes and preparing the chk ids string.
function sel_inc_r_des_rem_all_ids(obj)
{
    	
	var MaxChks = parseInt(obj.chk_id.length);

	if ( isNaN(MaxChks) )		// if there is only one record in a page, then chk_id doesn't become a array so returns NaN.
	{
		MaxChks = 0;			// then put zero in it
	}
	if ( obj.chk_top.checked )
	{
		for ( i = 0; i < MaxChks; i++)				// make all the check boxes checked
		{
			obj.chk_id[i].checked = true;
		}
		
		if ( MaxChks == 0 )							// if MaxChks is 0 then chk_id is not an array
			obj.chk_id.checked = true;
			
		obj.chk_ids.value = prepare_string(obj , 'all');
		//alert(obj.chk_ids.value);

	}
	else
	{
		
		for ( i = 0; i < MaxChks; i++)				// make all the check boxes unchecked
		{
			obj.chk_id[i].checked = false;
		}
		
		if ( MaxChks == 0 )							// if MaxChks is 0 then chk_id is not an array
			obj.chk_id.checked = false;
			
		obj.chk_ids.value = "";		
	}
}

// This function is used for deselecting the top checkbox and include the record id associated with checkbox if checked 
// or remove the record id associated with checkbox if unchecked, on clicking of a particular checkbox.
function des_top_n_inc_r_rem_id(myself , id1)
{
	myself.form.chk_top.checked = false;

	if(myself.checked == false)
	{
		var flag = true;
		
		var MaxChks = parseInt(myself.form.chk_id.length);
		
		if ( isNaN(MaxChks) )		// if there is only one record in a page, then chk_id doesn't become a array so returns NaN.
		{
			MaxChks = 0;			// then put zero in it
		}

		if ( MaxChks == 0 )
		{
			if(myself.form.chk_id.checked == false)
			{
				flag = false;
			}
		}
		else
		{
			for ( i = 0; i < MaxChks; i++)				// check all the check boxes for checkedness
			{
				if(myself.form.chk_id[i].checked == false)
				{
					flag = false;
				}
			}
		}

		if(flag)
		{
			myself.form.chk_top.checked = true;
		}
		
		var id_arr = id1.split("_");
		
		myself.form.chk_ids.value = prepare_string(myself.form , 'rem' , id_arr[1]);
	}
	else if(myself.checked == true)
	{
		var id_arr = id1.split("_");
		
		myself.form.chk_ids.value = prepare_string(myself.form , 'inc' , id_arr[1]);	
	}
}
//pankaj testinggg
// This function is used the select or deselect the multiple checkboxes and preparing the chk ids string.
function sel_inc_r_des_rem_all_ids1(obj)
{
    alert(obj);
	var MaxChks = parseInt(obj.chk_id.length);

	
	if ( isNaN(MaxChks) )		// if there is only one record in a page, then chk_id doesn't become a array so returns NaN.
	{
		MaxChks = 0;			// then put zero in it
	}

	if ( obj.chk_top.checked )
	{
		for ( i = 0; i < MaxChks; i++)				// make all the check boxes checked
		{
			obj.chk_id[i].checked = true;
						
			var id_str = obj.chk_id[i].id;
			var id_arr = id_str.split("_");
			var tr_id = "tr_" + id_arr[1];
			
			var tr_id1 = tr_id + "_0";
			var tr_id2 = tr_id + "_1";
			
			if(document.getElementById(tr_id1))
			{
				document.getElementById(tr_id1).className = "tr-click";
			}
			else
			{
				document.getElementById(tr_id2).className = "tr-click";
			}			
		}
		
		if ( MaxChks == 0 )							// if MaxChks is 0 then chk_id is not an array
			obj.chk_id.checked = true;
			
		obj.chk_ids.value = prepare_string(obj , 'all');	
	}
	else
	{
		for ( i = 0; i < MaxChks; i++)				// make all the check boxes unchecked
		{
			obj.chk_id[i].checked = false;
			
			var id_str = obj.chk_id[i].id;
			var id_arr = id_str.split("_");
			var tr_id = "tr_" + id_arr[1];
			
			var tr_id1 = tr_id + "_0";
			var tr_id2 = tr_id + "_1";
			
			if(document.getElementById(tr_id1))
			{
				document.getElementById(tr_id1).className = "";
			}
			else
			{
				document.getElementById(tr_id2).className = "tr-alternate";
			}
		}
		
		if ( MaxChks == 0 )							// if MaxChks is 0 then chk_id is not an array
			obj.chk_id.checked = false;
			
		obj.chk_ids.value = "";		
	}
}
