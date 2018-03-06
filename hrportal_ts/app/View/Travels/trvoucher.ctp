<script>
    function GetPreviousVoucher()
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>travels/previousVoucher/',
            success: function (data) {
                jQuery('#empResponse').html(data);
            }
        });
    }
    function getCityPrice(id)
    {
        var department = jQuery('#VoucherEmpDepartmentCode').val();
        var desg = jQuery('#VoucherEmpDesg').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>TravelMasters/getCityPrice/' + id + '/' + department + '/' + desg,
            success: function (data) {
                var mObj = JSON.parse(data);
                jQuery('#daily_amt').val(mObj.amount);
                jQuery('#hotel_amt').val(mObj.hotel_amount);
                jQuery('#name_city').hide();
                jQuery('#list_city').show();
                jQuery('#list_city').html(data);
            }
        });
    }

    function checkothers(id) {
        if (id == 0) {
            jQuery('#name_city').show();
            jQuery('#list_city').hide();

        }
    }

</script>
<div class="uk-width-medium-1-1">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        $('#alerts').hide();
        $('#VoucherGoingBy').change(function () {

            var b = $("#VoucherGoingBy option:selected").text();
            if (b === 'Others')
            {
                var div = $('#others');

                var b = $('<div id="goingby" class="uk-width-medium-1-1">');
                var position = $('<input type="text" class="md-input" required="true" name="others_goingby" >');
                b.append(position);
            } else
            {
                $('#goingby').remove();
            }
            div.append(b);
        });

        $('#VoucherComingBy').change(function () {

            var b = $("#VoucherComingBy option:selected").text();

            if (b === 'Others') {
                var div = $('#otherscoming');
                var year = $('<div id="comingby" class="uk-width-medium-1-1">');
                var position = $('<input type="text" class="md-input" required="true" name="others_comingby" ><br>');
                year.append(position);
            } else
            {
                $('#comingby').remove();
            }
            div.append(year);

        });
        jQuery("#VoucherTourStartDate").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            maxDate: 'today',
            //changeYear: true,
            format: 'dd-mm-yyyy',
            


        });
        jQuery("#VoucherTourEndDate").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            maxDate: 'today',
            //changeYear: true,
            format: 'dd-mm-yyyy',
            

        });
        
    });
    

    function parseDate(str) {

        var mdy = str.split(' ')[0].split('-');
        return new Date(mdy[2], mdy[1] - 1, mdy[0]);
    }

    function daydiff(first, second) {
        var a = (second - first) / (1000 * 60 * 60 * 24);
        var ed_date = $("input[name='ch_edtravel_daylength']:checked").val();
        var st_date = $("input[name='ch_sttravel_daylength']:checked").val();


        if (ed_date === 'H' && st_date !== 'H') {
            a = a - 0.5;
        }
        if (st_date === 'H' && ed_date !== 'H') {
            a = a - 0.5;
        }
        if (st_date === 'H' && ed_date === 'H') {
            a = a - 1.0;
        }

        return a;
        alert(a);
    }
    jQuery(document).ready(function () {
        $('#VoucherTourEndDate').change(function () {
            var startdate = $("#VoucherTourStartDate").datepicker('getDate');
            var enddate = $("#VoucherTourEndDate");
            if (startdate !== '' && enddate !== '') {
                oDiff = daydiff($('#VoucherTourStartDate').datepicker('getDate'), $('#VoucherTourEndDate').datepicker('getDate'));
                oDiff = oDiff + parseInt(1);
                var sel_val = $('#daily_days').val();
                var sel_val = $('#daily_dayss').val();
                $('#daily_dayss').html('');
                $('#daily_days').html('');
                for (i = 0; i <= oDiff; i++) {
                    if (i === oDiff)
                    {
                        $('#daily_days').append($('<option></option>').val(i).html(i));
                        $('#daily_dayss').append($('<option></option>').val(i).html(i));
                    } else
                    {
                        $('#daily_days').append($('<option></option>').val(i).html(i));
                        $('#daily_dayss').append($('<option></option>').val(i).html(i));
                    }
                }
                $('#daily_days').attr('value', sel_val);
                $('#daily_dayss').attr('value', sel_val);

                tot_allow();
                tot_allows();
            }

        });

        $('#VoucherTourStartDate').change(function () {
            var startdate = $("#VoucherTourStartDate").datepicker('getDate');
            var enddate = $("#VoucherTourEndDate");
            if (startdate !== '' && enddate !== '') {

                oDiff = daydiff($('#VoucherTourStartDate').datepicker('getDate'), $('#VoucherTourEndDate').datepicker('getDate'));

                oDiff = oDiff + parseInt(1);
                var sel_val = $('#daily_days').val();
                var sel_val = $('#daily_dayss').val();
                $('#daily_dayss').html('');

                $('#daily_days').html('');
                for (i = 0; i <= oDiff; i++) {
                    if (i === oDiff)
                    {
                        $('#daily_days').append($('<option></option>').val(i).html(i));
                        $('#daily_dayss').append($('<option></option>').val(i).html(i));

                    } else
                    {
                        $('#daily_days').append($('<option></option>').val(i).html(i));
                        $('#daily_dayss').append($('<option></option>').val(i).html(i));
                    }
                }
                $('#daily_days').attr('value', sel_val);
                $('#daily_dayss').attr('value', sel_val);
                tot_allow();
                tot_allows();
            }

        });


    });

    function calcDate()
    {
        var tourstart_date = jQuery('#VoucherTourStartDate').val();
        var starthour = jQuery('#VoucherTourStartDate').val();//jQuery('#VoucherStartHour').val();
        var start_min = jQuery('#VoucherTourStartDate').val();//jQuery('#VoucherStartMinute').val();
        var tourend_date = jQuery('#VoucherTourEndDate').val();
        var endhour = jQuery('#VoucherTourEndDate').val();//jQuery('#VoucherEndHour').val();
        var end_min = jQuery('#VoucherTourEndDate').val();//jQuery('#VoucherEndMinute').val();
        var one_day = 1000 * 60 * 60 * 24;
        //Here we need to split the inputed dates to convert them into standard format
        var x = tourstart_date.split("-");
        var y = tourend_date.split("-");
        var date1 = new Date(x[2], parseInt(x[1]) - 1, x[0]);
        var date2 = new Date(y[2], parseInt(y[1]) - 1, y[0]);
        //Calculate difference between the two dates, and convert to days

        _Diff = ((date2.getTime() - date1.getTime()) / (one_day));
        _Diff++
        if (_Diff <= 0) {
            var msg = 'Enter Proper Dates';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Proper Dates").show();
            return false;

        }

        var allowdate = jQuery('#daily_days').val();
        if (Math.ceil(_Diff) < allowdate) {
            // alert("Allowence days greater then tour start date and tour end date");
            jQuery('#daily_days').val('');
            jQuery('#daily_amt').val('');
            jQuery('#VoucherDailyAllowDays').val('');
            jQuery('#daily_days').focus();
            return false;

        }
    }
    function tot_allow()
    {
        var per_day_amt = jQuery('#daily_amt').val();
        var tot_days = jQuery('#daily_days').val();
        var total_daily_allow = tot_days * per_day_amt;
        jQuery('#VoucherDailyAllowDays').val(total_daily_allow);
        calTotal();
    }
    function tot_allows()
    {
        var per_day_amt = jQuery('#hotel_amt').val();
        var tot_days = jQuery('#daily_dayss').val();
        var total_hotel_amount = tot_days * per_day_amt;
        jQuery('#VoucherHotelStayExpense').val(total_hotel_amount);
        calTotal();
    }



    /* Total Amount In Travel */
    function calTotal()
    {
        var ticket_book = jQuery('#VoucherBookedAmt').val();
        var convayence_amt = jQuery('#VoucherConveyenceAmt').val();
        var hotel_exp_amt = jQuery('#VoucherHotelStayExpense').val();
        var voucher_mesicelleneous_amt = jQuery('#VoucherMiscellaneousExpDuringTravil').val();
        var voucher_telephone_exp_amt = jQuery('#VoucherTelephoneExpense').val();
        var voucher_bp_exp_amt = jQuery('#VoucherExpenseIncurredTravel').val();
        var voucher_another_exp_amt = jQuery('#VoucherAnotherExpense').val();
        var voucher_daily_allows_amt = jQuery('#VoucherDailyAllowDays').val();
        var total = ticket_book * 1 + convayence_amt * 1 + hotel_exp_amt * 1 + voucher_mesicelleneous_amt * 1 + voucher_telephone_exp_amt * 1 + voucher_bp_exp_amt * 1 + voucher_another_exp_amt * 1 + voucher_daily_allows_amt * 1;
        var total_exp = jQuery('#VoucherTotalExpenseIncurred').val(total);
        var advance_taken_antother_mem = jQuery("#VoucherAdvanceTakenEmployee").val();
        calNet();
    }


    /* Support only . and digits only  */
    function checkIt(evt) {


        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode != 46)) {
            return false
        }

        return true
    }

    /* Total Amount */
    function calNet()
    {
        var advance_taken_antother_mem = jQuery("#VoucherAdvanceTakenEmployee").val();
        var tot_expense = jQuery("#VoucherTotalExpenseIncurred").val();
        net = tot_expense * 1 - (advance_taken_antother_mem * 1);
        if (net > 0)
        {
            jQuery("#VoucherBalanceAmtPaid").val(net);
            jQuery("#VoucherAmountReturnHeadOffice").val(0);
        } else
        {
            jQuery("#VoucherAmountReturnHeadOffice").val(Math.abs(net));
            jQuery("#VoucherBalanceAmtPaid").val(0);
        }
    }

    //***** main function for validation on all field ************/
    function checkSubmit()
    {
        var placevisit = jQuery('#VoucherPlaceVisit');
        var department = jQuery('#VoucherEmpDepartment');
        var tourstart_date = jQuery('#VoucherTourStartDate');
        var going_by = jQuery('#VoucherGoingBy');
        var starthour = jQuery('#VoucherStartHour');
        var start_min = jQuery('#VoucherStartMinute');
        var tourend_date = jQuery('#VoucherTourEndDate');
        var coming_by = jQuery('#VoucherComingBy');
        var endhour = jQuery('#VoucherEndHour');
        var end_min = jQuery('#VoucherEndMinute');
        var booked_amt = jQuery('#VoucherBookedAmt');

        var local_convayence = jQuery('#VoucherConveyenceAmt');
        var voucher_daily_alws_amt = jQuery('#VoucherDailyAllowDays');
        var detail_local_convayence = jQuery('#VoucherDetailLocalConceyence');
        var meselleanous_exp = jQuery('#VoucherMiscellaneousExpDuringTravil');
        var detail_meselleanous_rmrk = jQuery('#VoucherDetailMiscellaneousExp');
        var booked_amt = jQuery('#VoucherBookedAmt');
        var voucher_telephone_exp_amt = jQuery('#VoucherTelephoneExpense');
        var miscelevous_exp = jQuery('#VoucherDetailLocalConceyence');
        var incured_client = jQuery('#VoucherExpenseIncurredTravel');
        var any_other_exp = jQuery('#VoucherAnotherExpense');

        var advance_taken_dureing_trvl = jQuery('#VoucherAdvanceTakenEmployee');

        var advance_emp_name = jQuery('#VoucherOtherEmployeeName');
        var daily_days = jQuery('#daily_days');

        var hotel_exp_amt = jQuery('#VoucherHotelStayExpense');

        if (empty(placevisit) || blank(placevisit))
        {
            var msg = 'Please enter Place to visit';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter place to visit").show();
            return false;
        } else if (department.val() === "")
        {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter Department").show();

            return false;

        } else if (tourstart_date.val() === "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Start Date Required").show();
            return false;

        } else if (going_by.val() === "")
        {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Starting Travel Mode Required").show();
            return false;

        } else if (starthour.val() === "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Starting hours Required").show();
            return false;

        } else if (start_min.val() === "")
        {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Starting Minutes Required").show();
            return false;

        } else if (tourend_date.val() === "")
        {
            var msg = 'Ending Date Required';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Dates Required").show();
            return false;

        } else if (coming_by.val() === "")
        {
            var msg = 'Ending Travel Mode Required';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Travel Mode Required").show();
            return false;

        } else if (endhour.val() === "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Hours Required").show();
            return false;

        } else if (end_min.val() === "")
        {
            var msg = 'Ending Minutes Required';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Minutes Required").show();
            return false;
        } else if (blank(booked_amt) || empty(booked_amt) || negative(booked_amt) || numeric(booked_amt))
        {
            var msg = 'Enter a proper ticket Amount';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a proper ticket Amount").show();
            return false;
        } else if (format(booked_amt))
        {
            var msg = 'Amount after decimal only two digit ! ';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Amount after decimal only two digit").show();
            return false;
        } else if (blank(local_convayence) || empty(local_convayence) || negative(local_convayence) || numeric(local_convayence))
        {
            var msg = 'Enter a proper Conveyance amount! ';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a proper Conveyance Amount").show();
            return false;
        } else if (format(local_convayence))
        {
            var msg = 'Amount after decimal only two digit ! ';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Amount after decimal only two digit").show();
            return false;
        } else if (local_convayence.val() > 0 && empty(detail_local_convayence))
        {
            if (empty(detail_local_convayence))
            {
                var msg = 'Details of Conveyance amount during travel period not entered.!  ';
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Details of Conveyance amount during travel period not entered.!").show();
                return false;
            }
        } else if (blank(daily_days) || empty(daily_days) || negative(daily_days) || numeric(daily_days))
        {
            var msg = 'Enter the number of days of stay !';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter the number of days of stay !").show();
            return false;
        } else if (blank(voucher_daily_alws_amt) || empty(voucher_daily_alws_amt) || negative(voucher_daily_alws_amt) || numeric(voucher_daily_alws_amt))
        {
            var msg = 'Enter a proper daily expense amount!';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a proper daily expense amount !").show();
            return false;
        } else if (blank(hotel_exp_amt) || empty(hotel_exp_amt) || negative(hotel_exp_amt) || numeric(hotel_exp_amt))
        {
            var msg = 'Enter a proper hotel expense amount!';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a proper hotel expense amount!").show();
            return false;
        } else if (format(hotel_exp_amt))
        {
            var msg = 'Amount after decimal only two digit !';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Amount after decimal only two digit !").show();
            return false;
        } else if (blank(meselleanous_exp) || empty(meselleanous_exp) || negative(meselleanous_exp) || numeric(meselleanous_exp))
        {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a proper miscellaneous expense amount!").show();
            return false;
        } else if (format(meselleanous_exp))
        {
            var msg = 'Amount after decimal only two digit !';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Amount after two decimal digit only!").show();
            return false;
        } else if (meselleanous_exp.val() > 0 && empty(detail_meselleanous_rmrk))
        {
            if (empty(detail_meselleanous_rmrk))
            {

                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Details of Miscellaneous expenses during travel period not entered.!").show();
                return false;
            }
        } else if (blank(voucher_telephone_exp_amt) || empty(voucher_telephone_exp_amt) || negative(voucher_telephone_exp_amt) || numeric(voucher_telephone_exp_amt))
        {
            var msg = 'Enter a proper telephone expense amount';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a proper telephone expense amount!").show();
            return false;
        } else if (format(voucher_telephone_exp_amt))
        {
            var msg = 'Amount after decimal only two digit !';
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Amount after decimal only two digit.!").show();
            return false;
        } else if (negative(advance_taken_dureing_trvl) || numeric(advance_taken_dureing_trvl))
        {
            var msg = 'Enter a proper advance amount';
            $('#alerts').html(msg);
            $('#alerts').show();
            alert("Enter a proper advance amount");
            advance_taken_dureing_trvl.focus();
            advance_taken_dureing_trvl.select();
            return false;
        } else if (format(advance_taken_dureing_trvl))
        {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Amount after decimal only two digit ! ").show();
            return false;

            return false;
        } else if (advance_taken_dureing_trvl.val() > 0)
        {
            if (empty(advance_emp_name))
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter employee name ! !").show();
                return false;
            }
        }

    }

    /*******************************************/
    /****** function for null amount check  *******/
    function empty(dist_value)
    {
        ret_var = false;
        dist = dist_value.val();
        if (dist == "")
        {
            ret_var = true;
        }
        return ret_var;
    }

    /***** function for blank check ****/
    function blank(dist_value)
    {
        ret_var = false;
        dist = dist_value.val();
        dist_len = dist.length;
        for (i = 0; i < dist_len; i++)
        {
            if (dist.charAt(i) == " ")
            {
                ret_var = true;
            }

        }
        return ret_var;
    }
    /****** function for number format that value after . only 2   *******/
    function format(dist_value)
    {
        ret_var = false;
        dist1 = dist_value.val();
        no = dist1.indexOf(".");
        if (dist1 != "" && no != -1)
        {
            dist2 = dist1.split(".");
            if (dist2[1].length > 2)
            {
                ret_var = true;
            }

        }

        return ret_var;
    }

    /***** function for negative  check ****/
    function negative(dist_value)
    {
        ret_var = false;
        dist = dist_value.val();
        if (dist < 0)
        {
            ret_var = true;
        }
        return ret_var;
    }

    /****** function for numeric amount check  *******/
    function numeric(dist_value)
    {
        ret_var = false;
        dist1 = dist_value.val();
        if (isNaN(dist1))
        {
            ret_var = true;
        }
        return ret_var;
    }


</script>
<!--<form id="demo-form4" name='voucher'data-parsley-validate enctype="multipart/form-data" class="uk-form-stacked"   method="POST" action="trvoucher" >-->
<?php echo $this->Form->create('Voucher', array('url' => array('controller' => 'Travels', 'action' => 'trvoucher'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked',id=>"voucher",name => "voucher")); ?>
<div id="page_content" role="main">
    <div id="page_content_inner">  
        <?php
        $auth = $this->Session->read('Auth');
        echo $flash = $this->Session->flash();
        ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <a onclick="GetPreviousVoucher()" class="uk-badge uk-badge-success" data-uk-modal="{target:'#modal_overflow'}" title="Click to View.">Copy previously applied travel voucher</a>
                <br><br>

                <div class="uk-grid" data-uk-grid-margin>                            
                    <div class="uk-width-medium-1-2 ">
                        <div class="parsley-row">
                            <label for="req_ref">Visited City<span class="req">*</span></label>
                            <?php 
                            echo $this->form->input('Voucher.city_group', array('type'=>'select','label'=>false,'onChange' => "getCityPrice(this.value)",'required'=>true,'class'=>"data-md-selectize",'options'=>$city_grp_list));
                            ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">                                
                        <div class="parsley-row">
                            <label for="req_ref">Department <span class="req">*</span></label>
                            <?php echo $this->Form->input('Voucher.EmpDepartment', array('label' => false, 'type' => 'text', 'class' => 'md-input', 'value' => $dept_code, "readonly" => "readonly")); ?>
                            <?php echo $this->Form->input('Voucher.Emp_department', array('type' => 'hidden', 'value' => $dept_code)); ?>
                            <?php echo $this->Form->input('Voucher.Emp_desg', array('type' => 'hidden', 'value' => $designation_code)); ?>
                            <?php echo $this->Form->input('Voucher.Emp_department_code', array('type' => 'hidden', 'value' => $dept_code_oly)); ?>

                        </div>
                    </div>

                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">                                
                        <div class="parsley-row">
                            <label for="Tour_start_date">Tour Start Date <span class="req">*</span></label>
                            <?php echo $this->Form->input('Tour_start_date', array('label' => false, 'type' => 'text', 'required'=>true ,'class' => 'md-input', 'readonly' => true)); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="req_ref">By <span class="req">*</span></label>
                            <?php 
                            echo $this->form->input('Voucher.Going_by', array('label'=>false,'type' => "select",'empty' => '-- Select --','required'=>true, 'options' => $Going_by, 'class' => "md-input",'data-md-selectize')); 
                            ?>
                        </div>                                
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row parsley-row">
                            <label for="gender" class="uk-form-label">Start Duration <span class="req">* </span></label>
                            <span class="icheck-inline">
                                <input type="radio" name="ch_sttravel_daylength" value="F" id="ch_sttravel_daylength" checked="checked" />
                                <label for="val_radio_male" class="inline-label">Full Day</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="ch_sttravel_daylength" value="H" id="ch_sttravel_daylength" />
                                <label for="val_radio_female" class="inline-label">Half Day</label>
                            </span>
                        </div>
                    </div>
                    <span id ='others'></span>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="Tour_End_date">Tour End Date <span class="req">*</span></label>
                            <?php echo $this->Form->input('Voucher.Tour_end_date', array('label' => false, 'type' => 'text', "data-uk-datepicker" => "{format:'DD-MM-YYYY'}", 'class' => 'md-input', 'readonly' => true, 'onChange' => 'return calcDate()')); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">                                
                        <div class="parsley-row">
                            <label for="req_ref">By <span class="req">*</span></label>
                            <?php echo $this->Form->input('Voucher.Coming_by', array('type' => 'select', 'label' => false, 'empty' => 'Select', 'options' => $Coming_by, 'class' => 'md-input', "data-md-selectize")); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row parsley-row">
                            <label for="gender" class="uk-form-label">End Duration <span class="req">* </span></label>
                            <span class="icheck-inline">
                                <input type="radio" name="ch_edtravel_daylength" value="F" id="ch_edtravel_daylength" checked="checked" />
                                <label for="val_radio_male" class="inline-label">Full Day</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="ch_edtravel_daylength" value="H" id="ch_edtravel_daylength" />
                                <label for="val_radio_female" class="inline-label">Half Day</label>
                            </span>
                        </div>
                    </div>                            

                    <span id ='otherscoming'></span>
                </div>
                <div >
                    <h3 class="uk-accordion-title">Expense Details *</h3>
                    <div class="uk-accordion-content">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-3">
                                <label>Ticket Booked By self :</label>
                                <div class="parsley-row">
                                    <?php echo $this->Form->input('Voucher.Booked_amt', array('label' => false, 'type' => 'text', 'class' => 'md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">    
                                <label>Local Conveyance During Travel Period* :</label>
                                <div class="parsley-row">                                  
                                    <?php echo $this->Form->input('Voucher.Conveyence_amt', array('label' => false, 'type' => 'text', 'class' => 'md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <div class="uk-accordion" data-uk-accordion>
                                    <h3 class="uk-accordion-title">Local Conveyance Detail</h3>
                                    <div class="uk-accordion-content">
                                        <label>Detail of Local Conveyance:</label>

                                        <div class="parsley-row">
                                            <div class="uk-overflow-container">
                                                <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup">
                                                    <input type='button' class="uk-badge uk-badge-primary plusbtn"  value='Add More' id='addButton'>
                                                     <input type='button' class="uk-badge uk-badge-danger minusbtn" value='Remove' id='removeButton'>
                                                    <tr>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-text-small">Claim Date </th>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-text-small">Mode</th>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-text-small">Amount</th>
                                                    </tr>

                                                    <tr>
                                                        <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount", array("type" => "hidden","id"=>"rowCount","value"=>"1")); ?></td>                            
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_date.', array('class' => 'md-input LocalClaimDate','id'=>'ayush1',"data-uk-datepicker"=>"{format:'DD-MM-YYYY',maxDate:'".date('d-m-Y')."'}")); ?></td>
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_mode.', array('class' => 'md-input','type'=>'select','options'=>$Going_by)); ?></td>
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_amount.', array('class' => 'md-input amt_local','onBlur'=>'calTotal()')); ?></td>
                                                 </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-xlarge-1-6" data-uk-grid-margin>

                            <?php if ($designation_code == 'G108' || $designation_code == "G109") { ?>

                            <div class="parsley-row">
                                <label>Total Allowance For</label>
                                    <?php echo $this->Form->input('Voucher.Daily_allow_days', array('label' => false, 'class' => 'required control-label col-md-4 col-sm-4 col-xs-12', 'type' => 'text', 'value' => '0', 'size' => '6')); ?>
                            </div>

                            <?php } else { ?>

                            <label>Daily Allowance For</label>

                            <div class="parsley-row">
                                <select id="daily_days" name="data[Voucher][days]" class="md-input" required="required"  value="0" onKeyup="tot_allow()"  onChange="tot_allow()"  onBlur="return calcDate()"></select>
                            </div>
                            <div class="parsley-row">
                                Days @   
                            </div>
                            <div class="parsley-row float-left">
                                <input type="text" id="daily_amt" class="md-input" onkeyup="tot_allow()" name="data[Voucher][daily_amt]" readonly="readonly"/>
                            </div>
                            <div class="parsley-row">
                                per Day :   
                            </div>
                            <div class="uk-width-medium-1-6 float-left">
                                    <?php echo $this->Form->input('Voucher.Daily_allow_days', array('label' => false, 'class' => 'md-input', 'readonly' => 'readonly', 'type' => 'text', 'value' => '0', 'size' => '6', 'onKeyup' => 'calTotal()')); ?>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-xlarge-1-6" data-uk-grid-margin>
                            <label>Daily Hotel Expense for </label>

                            <div class="parsley-row">
                                <select id="daily_dayss" name="data[Voucher][hotel_days]" class="md-input" required="required"  value="0" onKeyup="tot_allows()"  onChange="tot_allows()"  onBlur="return calcDate()"></select>
                            </div>
                            <div class="parsley-row">
                                Days @   
                            </div>
                            <div class="parsley-row float-left">
                                <input type="text" id="hotel_amt" class ="md-input" onkeyup="tot_allow()" readonly="readonly"/>
                            </div>
                            <div class="parsley-row">
                                per Day :   
                            </div>

                            <div class="uk-width-medium-1-6">  
                                <div class="parsley-row">
                                    <?php echo $this->Form->input('Voucher.Hotel_stay_expense', array('label' => false, 'type' => 'text', 'class' => 'round md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0','readonly')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-3"> 
                                <label>Telephone Expense *</label>
                                <div class="parsley-row">
                                    <?php echo $this->Form->input('Voucher.Telephone_expense', array('label' => false, 'type' => 'text', 'class' => 'round md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <label>Miscellaneous Expense</label>
                                <div class="parsley-row">                                
                                    <?php echo $this->Form->input('Voucher.Miscellaneous_exp_during_travil', array('label' => false, 'type' => 'text', 'class' => 'md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3"> 
                                <label>Detail of Miscellaneous Expense</label>
                                <div class="parsley-row">
                                    <?php echo $this->Form->textarea('Voucher.detail_miscellaneous_exp', array('label' => false, 'class' => 'md-input')); ?>
                                </div>
                            </div>

                        </div>

                        <div class="uk-grid" data-uk-grid-margin>

                            <div class="uk-width-medium-1-3">
                                <label>Expense Incurred For Client/B.P. *</label>
                                <div class="parsley-row">
                                    <?php echo $this->Form->input('Voucher.Expense_incurred_travel', array('label' => "", 'type' => 'text', 'class' => 'md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">   
                                <label>Any Other Expense </label>
                                <div class="parsley-row">
                                    <?php echo $this->Form->input('Voucher.Another_expense', array('label' => false, 'type' => 'text', 'class' => 'md-input', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9', 'value' => '0')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">                            
                                <div class="parsley-row">
                                    <label>Total Travel Expense Incurred *</label>
                                    <?php echo $this->Form->input('Voucher.Total_expense_incurred', array('label' =>false, 'type' => 'text', 'class' => 'md-input','required'=>true, 'readonly' => 'readonly', 'onKeyup' => 'calTotal()', 'MAXLENGTH' => '9')); ?>
                                </div>
                            </div>

                        </div>

                        <div class="uk-grid" data-uk-grid-margin>


                            <div class="uk-width-medium-1-3">                            
                                <div class="parsley-row">
                                    <label>Advance Taken From Another Employee</label>
                                    <?php echo $this->Form->input('Voucher.Advance_taken_employee', array('label' => "", 'onKeyup' => 'calNet()', 'type' => 'text', 'class' => 'md-input', 'value' => '0', 'MAXLENGTH' => '9')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">                            
                                <div class="parsley-row">
                                    <label>Name of the Employee</label>
                                    <?php echo $this->Form->input('Voucher.Other_employee_name', array('label' => "", 'type' => 'text', 'class' => 'md-input')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">                                
                                <div class="parsley-row">  
                                    <label>Balance Amount to be Paid to Employee</label>
                                    <?php echo $this->Form->input('Voucher.Balance_amt_paid', array('label' => "", 'type' => 'text', 'class' => 'md-input')); ?>
                                </div>
                            </div>
                        </div>


                        <div class="uk-grid" >

                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label>Amount To Be Returned To Head Office</label>
                                    <?php echo $this->Form->input('Voucher.Amount_return_head_office', array('label' => "", 'type' => 'text', 'class' => 'md-input')); ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-2-3">
                                <div class="parsley-row">  
                                    <div class="uk-form-file md-btn md-btn-primary">
                                        Select
                                        <?php echo $this->Form->input('doc_file', array('type' => 'file', 'label' => false, 'id' => 'docInput')); ?>
                                    </div>
                                    Upload Document <span class="req"></span>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid">

                        </div>
                    </div>
                </div>
                <div class="uk-grid margin-bottom">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id="Park-Button">
                            <input  type="submit" class="md-btn md-btn-success"  value="Save As Draft"  onclick ="return checkSubmit();">
                            <input type="submit" class="md-btn md-btn-primary" value="Apply" name='post_travel' onclick=" return post();">
                        </div>

                    </div>
                </div>
                <?php $this->form->end(); ?>
            </div>

        </div>
    </div>
</div>

<script>
    function post()
    {
        document.voucher.action = "posttravel";
        return checkSubmit();
    }

    $('#VoucherPlaceVisit').keypress(function (e) {
        if (e.which === 32 && $('#VoucherPlaceVisit').val() == " ") {
            return false;
        }

    });
    $('#VoucherConveyenceAmt').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Local Conveyance must be a digit ").show();
            return false;
        }

    });
    $('#VoucherMiscellaneousExpDuringTravil').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Miscellaneous Expense must be a digit ").show();
            return false;
        }

    });

    $('#VoucherHotelStayExpense').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Hotel Expense must be a digit ").show();
            return false;
        }

    });

    $('#VoucherTelephoneExpense').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Telephone Expense must be a digit ").show();
            return false;
        }

    });

    $('#VoucherAnotherExpense').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Other Expense must be a digit ").show();
            return false;
        }

    });

    $('#VoucherExpenseIncurredTravel').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>  Expense Incurred For Client/B.P. During Travel must be a digit ").show();
            return false;
        }

    });
    $('#VoucherAdvanceTakenEmployee').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a> Advance Taken from other employee must be a digit ").show();
            return false;
        }

    });
    $('#VoucherBookedAmt').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a> Ticket booked for self must be a digit ").show();
            return false;
        }

    });
    $('#VoucherBalanceAmtPaid').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a> Balance to be paid must be a digit ").show();
            return false;
        }

    });
    $('#VoucherAmountReturnHeadOffice').keypress(function (e) {
        if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a> Amount Returned to head office must be a digit ").show();
            return false;
        }

    });
    function changetext() {

        $("#VoucherPlaceVisit").on("keydown", function (e) {
            console.log(e.which);
            if (e.which !== 8 && e.which !== 9 && e.which !== 16 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg_" + id).html("Digits Only").show();
                return false;
            }
        });
    }


</script>
<?php
        foreach($Going_by as $k => $val){
		
            $listing .= '<option value='.$k.'>'.$val.'</option>';
    } 
        ?>

<script type="text/javascript">
    
         
    var counter = 2;
    var valu = '<?php echo $listing;?>';
    <?php $count = 2;?>
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr><?php echo $this->Form->create("ConveyenceExpenses"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td><?php echo $this->Form->input('Voucher.local_claim_date.', array('class' => 'md-input LocalClaimDate',"data-uk-datepicker"=>"{format:'DD-MM-YYYY',maxDate:'".date('d-m-Y')."'}")); ?></td>'+
                '<td><select name="data[Voucher][local_claim_mode][]" class="md-input" onchange="calculate('+<?php echo $count; ?>+')" id="travelmode_'+<?php echo $count; ?>+'" required="true"><option value="">--select--</option>'+valu+'</select></td>'+
                '<td><?php echo $this->Form->input('Voucher.local_claim_amount.', array('class' => 'md-input amt_local','onKeyup' => 'calTotallocal()','onBlur'=>'calTotal()')); ?></td>' +
                '</tr>');
     <?php $count++;?>   
         $('#rowCount').val(counter);
         
    counter++;
       
    });

    $('.minusbtn').click(function () {
        if ($("#TextBoxesGroup tr").length != 2) {
            $("#TextBoxesGroup tr:last-child").remove();
            counter--;
        }
        else {
            alert("You cannot delete first row");
        }
    });
</script>
<script> 
 $(document).on("change", ".amt_local", function() {
    var sum = 0;
    $(".amt_local").each(function(){
        sum += +$(this).val();
    });
    $("#VoucherConveyenceAmt").val(sum);
});
</script>
