if($("#client_id").val() !=''&& ($("#open-tab-21_1").val() =='')&& ($("#open-tab-31_1").val() ==''))
{
   $( "#registration" ).tabs({disabled: [2,3]});
}else if($("#open-tab-21_1").val() !=''&& ($("#open-tab-31_1").val() =='')){
    $( "#registration" ).tabs({disabled: [3]});
}else if(($("#open-tab-31_1").val() !='')){
    $( "#registration" ).tabs();
}else{
    $( "#registration" ).tabs({disabled: [1,2,3]});
}

 
 $(function() {
        $('.datepicker').on('click', function() {
           $(this).datepicker({showOn: 'focus'}).focus();
        });
    });


function auto_suggest(newurl) {
    $("#client_nm").on('keyup.autocomplete', function() {
        $(this).autocomplete({
            source: newurl+'ebizlicenses/autoClientName',
            minLength: 2,
            select: function(event, ui) {
                $('#client_id').attr('value', ui.item.id);
                customeraddress(newurl);
            }
        });
    });
}

function checkDecimalValue(item, evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function checkcharValue(evt){
  evt = (evt) ? evt : (window.event) ? event : null;
if (evt)
{
  var charCode = (evt.charCode) ? evt.charCode :((evt.keyCode) ? evt.keyCode :((evt.which) ? evt.which : 0));
  var charStr = String.fromCharCode(charCode);
    if (/\d/.test(charStr)) {
        return false;
    }
} return true;
}

function customeraddress(newurl)
{
    var custid = $("#client_id").val();
    $.ajax({
        type: 'POST',
        data: {custid: custid},
        url: newurl+"ebizlicenses/customeraddress",
        success: function(data) {
            $("#client_addy").html(data);

        }
    });
}

 

function addMoretab32(newurl) {
                var total = $("#totalrowtab32").val();
                var total = parseInt(total) + parseInt(1);
                $("#totalrowtab32").val(total);
                var url = newurl+'ebizlicenses/addrowmodulewiselicdtinfo/' + total;
                $.get(url, function(data) {
                    $("#tab32").append(data);
                  });

            }
            
function removedivtab32(ele)
{
    $(ele).closest('td').parent('tr').remove();
}

 

function addMoretab51(newurl) {
                var total = $("#totalrowtab51").val();
                var total = parseInt(total) + parseInt(1);
                $("#totalrowtab51").val(total);
                var url = newurl+'ebizlicenses/addrowmobappconfginfo/' + total;
                $.get(url, function(data) {
                    $("#tab51").append(data);
                  });

            }
            
function removedivtab51(ele)
{
    $(ele).closest('td').parent('tr').remove();
}





function duplicateValidationTab7()
{
    var newdval=0;
     $("input[id^='wls_eff_date_']").each(function() {
        var Rowid = parseInt($(this).attr('id').split("wls_eff_date_")[1], 10);
        var valueOfChangedInput = $("#wls_eff_date_" + Rowid).val();
        var timeRepeated = 0;
        $("input[id^='wls_eff_date_']").each(function() {
            //alert(parseFloat($(this).val())+"terss"+ parseFloat(valueOfChangedInput));
            //Inside each() check the 'valueOfChangedInput' with all other existing input
            if( (new Date($(this).val()).getTime() == new Date(valueOfChangedInput).getTime()))
                {
            //if (parseFloat($(this).val()) == parseFloat(valueOfChangedInput)) {
                timeRepeated++; //this will be executed at least 1 time because of the input, which is changed just now
            }
            
             if (timeRepeated > 1) {
                  newdval = 2;
                 return false;
             }
        });
        
        
    });
    
    if (newdval > 1) {
            alert("Duplicate value found of Effected Date!");
            return false;
        }
        else {
            alert("No Duplicates !");
            return true;
        }
    // return false;
}

$(".readonly").keydown(function(e){
        e.preventDefault();
    });
    
  