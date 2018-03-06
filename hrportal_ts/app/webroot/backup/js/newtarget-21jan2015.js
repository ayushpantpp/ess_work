var rowcount = 0;
var reveneIncre = 0;
var collectionIncre = 0;
var expenseIncre = 0;


function CheckPreviousAddRow1(obj, divid)
{
    rowcount++;
    // rowcount=parseInt(rowcount)+parseInt(1);
    var id = (obj.tot_ctrl.value - 1);
    var totalrow = jQuery("#addtargetrow").val();
    AddControl1(obj, divid, totalrow, id);
}

function AddControl1(obj, divid, totalrow, id)
{
    var str = '';
    var Max_Control = 150;
    var tot_ctrl = obj.tot_ctrl.value;
    $("#loaderbtn").empty().html("<img src='../img/ajax-loader.gif' style='height:24px;'/>");
    if (tot_ctrl < Max_Control)
    {
        var i = parseInt(tot_ctrl);
        var j = (i + 1);
        var totalrowfound = parseInt(totalrow) + parseInt(1);
        document.getElementById("addtargetrow").value = totalrowfound;
        var region_id = $("#region_id").val();
          var year = $("#year").val();
        var url = 'newtargetrow/' + totalrowfound + '/' + region_id+ '/' + year;
        document.getElementById("add_button").disabled = true;

        jQuery.get(url, function(data)
        {
            jQuery("#" + divid).append(data);
            obj.tot_ctrl.value = parseInt(obj.tot_ctrl.value) + 1;
            if (obj.tot_ctrl.value == Max_Control)
            {
                document.getElementById("add_button").disabled = true;
                document.getElementById("remove_button").disabled = false;
            } else {
                document.getElementById("remove_button").disabled = false;
            }
            var add = parseInt(id + 1);
            document.getElementById("add_button").disabled = false;
            $("#loaderbtn").empty().html();
        });

    }
}
function RemoveRow1(obj)
{
    var str = '';
    var i = parseInt(obj.tot_ctrl.value);
    if (i > 1)
    {
        rowcount--;
        i = i - 1;
        var divid = document.getElementById('add_ctrl');
        var totalrow = jQuery("#addtargetrow").val();
        var row = parseInt(totalrow) - 1;
        jQuery("#addtargetrow").val(row);
        jQuery('#redRow' + i).remove();
        jQuery("#tot_ctrl").val(i);
        document.getElementById("add_button").disabled = false;

    } else {
        alert('You can not remove beyond this limit !');
    }
}


function OrignalAnnualProjection1(obj, fieldid,vstatus)
{
    var region_id = jQuery("#region_id").val();
    var transaction_no = jQuery("#transaction_no").val();
    var manday = jQuery("#man_day").val();
    var year = jQuery("#year").val();
    var currencyId = jQuery("#currency_id").val();
    var pID = document.getElementsByName("data[vc_project_status][" + fieldid + "]");

if(vstatus=='addroll')
    {
    for (var i = 0; i < pID.length; i++) {
        if (pID[i].checked == true) {
            project_type = pID[i].value;
        }
    }
}else{
    var project_type=jQuery("#vc_project_status_"+fieldid).val();
}
    // var project_type =jQuery(".vc_project_status_"+fieldid).val();
    /*
     =====When Project/customer  name is  Dropdown List========   
     
     var project_code =jQuery("#project_code_"+fieldid).val();
     var project_name = jQuery("#project_code_"+fieldid+" option:selected").text();*/

    var project_code = jQuery("#project_code_" + fieldid).val();
    var project_name = jQuery("#vc_project_name_" + fieldid).val();

    error = '';
    if (region_id == '')
    {
        error += "Please select region !\n";
    }
    if (currencyId == '')
    {
        error += "Please select currency !\n";
    }
    if (year == '')
    {
        error += "Please select year !\n";
    }
    var regexp = /(^[1-9][0-9]*$)/;

    if (!regexp.test(manday))
    {
        error += "Please enter man days(Positive Integer Number) !\n";

    }
    else if (parseInt(manday) > 100000) {

        error += "Man days integer value must be greater than zero and less than 100000 !\n";

    }
    if ((project_code == '') || (project_name == 'No customer found.'))
    {
        error += "Please select customer/project !\n";
    }
    if (error == '')
    {
    } else {
        alert(error);
        return(false);
    }

    var totalrowfound = '1';

    $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
    $.ajax({
        type: 'POST',
        data: {region_id: region_id, transaction_no: transaction_no, manday: manday,
            year: year, project_type: project_type, project_code: project_code,
            project_name: project_name, currencyId: currencyId},
        url: "per_orginal_target_add",
        success: function(data) {
            jQuery("#rts").html(data);
        }
    });

}


function AddTempRollingAnnualProjection(obj, fieldid)
{
    var regionId = jQuery("#region_id").val();
    var transaction_no = jQuery("#transaction_no").val();
    var nu_man_day_rate = jQuery("#man_day").val();
    var yearId = jQuery("#year").val();
    var currencyId = jQuery("#currency_id").val();
    var pID = document.getElementsByName("data[vc_project_status][" + fieldid + "]");

    for (var i = 0; i < pID.length; i++) {
        if (pID[i].checked == true) {
            project_type = pID[i].value;
        }
    }


    var project_code = jQuery("#project_code_" + fieldid).val();
    var project_name = jQuery("#vc_project_name_" + fieldid).val();

    var error = '';

    if ((project_code == '') || (project_name == 'No customer found.'))
    {
        error += "Please select customer/project !\n";
    }
    if (error == '')
    {
    } else {
        alert(error);
        return(false);
    }

    var totalrowfound = '1';

    var newurl = "rolling_target_add";

    var status = 'add';
    $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
    $.ajax({
        type: 'POST',
        data: {transaction_no: transaction_no, project_code: project_code,
            project_name: project_name, nu_man_day_rate: nu_man_day_rate,
            regionId: regionId, yearId: yearId, status: status},
        url: newurl,
        success: function(data) {
            jQuery("#rts").html(data);
        }
    });

}


function OrignalAnnualProjectionEdit(obj, fieldid,vstatus)
{
    var region_id = jQuery("#region_id").val();
    var transaction_no = jQuery("#transaction_no").val();
    var manday = jQuery("#man_day").val();
    var year = jQuery("#year").val();
    var currencyId = jQuery("#currency_id").val();
    var pID = document.getElementsByName("data[vc_project_status][" + fieldid + "]");

if(vstatus=='addroll')
    {
    for (var i = 0; i < pID.length; i++) {
        if (pID[i].checked == true) {
            project_type = pID[i].value;
        }
    }
}else{
    var project_type=jQuery("#vc_project_status_"+fieldid).val();
}
    
    var project_code = jQuery("#project_code_" + fieldid).val();
    var project_name = jQuery("#vc_project_name_" + fieldid).val();

    error = '';
    if (region_id == '')
    {
        error += "Please select region !\n";
    }
    if (currencyId == '')
    {
        error += "Please select currency !\n";
    }
    if (year == '')
    {
        error += "Please select year !\n";
    }
    var regexp = /(^[1-9][0-9]*$)/;

    if (!regexp.test(manday))
    {
        error += "Please enter man days(Positive Integer Number) !\n";

    }
    else if (parseInt(manday) > 100000) {

        error += "Man days integer value must be greater than zero and less than 100000 !\n";

    }
    if ((project_code == '') || (project_name == 'No customer found.'))
    {
        error += "Please select customer/project !\n";
    }
    if (error == '')
    {
    } else {
        alert(error);
        return(false);
    }

    var totalrowfound = '1';

    $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
    $.ajax({
        type: 'POST',
        data: {region_id: region_id, transaction_no: transaction_no, manday: manday,
            year: year, project_type: project_type, project_code: project_code,
            project_name: project_name, currencyId: currencyId},
        url: "per_orginal_target_edit",
        success: function(data) {
            jQuery("#rts").html(data);
        }
    });

}