<!-- page content -->
<div id="page_content" role="main">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <?php $status = $this->Common->attendance_status(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-toolbar">
                <div class="md-card-toolbar-actions">


                </div>
                <h3 class="md-card-toolbar-heading-text">
                    Add Attendance
                </h3>
                <div style="float:right;">
                    <label for="prev_out_time">In Time : </label><span id="prev_in_time"></span><br>
                    <label for="prev_out_time">Out Time :</label><span id="prev_out_time"></span>
                </div>
            </div>
            
            <div class="md-card-content large-padding">
                <form id="demo-form4" data-parsley-validate  class="form-horizontal form-label-left" method="POST" action="save_attendance" >
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Attendance Date<span class="required">*</span></label>
                                <?php echo $this->form->input('atten_dt', array('label' => false, 'class' => "md-input", 'type' => 'text', 'id' => 'atten_dt', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="middle-name" class="uk-autocomplete uk-open">In Time<span class="required">*</span><br/><small>(in 24 hrs format. for eg 15:32)</small></label>
                                <?php echo $this->form->input('in_time', array('label' => false, 'class' => "md-input", "data-uk-timepicker" => "", 'id' => 'in_time')); ?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Out Time<span class="required">*</span><br/><small>(in 24 hrs format. for eg 15:32)</small></label>
                                <?php echo $this->form->input('out_time', array('label' => false, 'class' => "md-input", "data-uk-timepicker" => "", 'id' => 'out_time')); ?>
                            </div>
                        </div>  
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="first-name">Reason</label>
                                <?php echo $this->form->input('description', array('label' => false, 'class' => "md-input", 'type' => 'textarea', 'maxlength' => '100')); ?>
                            </div>
                        </div>

                        <div class="uk-input-group" style="display: inherit;">
                            <label>Is on Personal Gate Pass (PGP)</label>
                            <?php echo $this->form->checkbox('is_pgp', array('label' => false, 'value' => "1")); ?> 
                            <?php echo $this->form->input('pgp_minutes', array('label' => false, "data-uk-timepicker" => "", 'id' => 'pgp_minutes','style' => 'width:50px;display: none;')); ?>

                        </div>

                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                                <?php echo $this->form->input('latitude', array('label' => false, 'class' => "md-input", 'type' => 'hidden', 'id' => 'latitude')); ?>
                                <?php echo $this->form->input('longitude', array('label' => false, 'class' => "md-input", 'type' => 'hidden', 'id' => 'longitude')); ?>
                                <?php echo $this->form->input('address', array('label' => false, 'class' => "md-input", 'type' => 'hidden', 'id' => 'address')); ?>
                            </div>
                        </div>
                        
                        <div class="uk-input-group" style="display: inherit;">
                            <label>Is on Outstation Duty (OD)</label>
                            <?php echo $this->form->checkbox('is_od', array('label' => false, 'value' => "1")); ?> 
                            <?php echo $this->form->input('od_minutes', array('label' => false,"data-uk-timepicker" => "", 'id' => 'od_minutes','style' => 'width:50px;display: none;')); ?>
                        </div>
                        

                    </div>
                    <div id="dvMap" style="width: 400px; height: 300px">
                    </div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-1-2 uk-margin-top">
                            <div class="parsley-row">
                                <button type="submit" id="sub" onclick="return checkSubmit();" class="md-btn md-btn-primary">Submit</button>

                                <?php if ($status['AttendanceStatus']['status'] == 1) { ?><button type="button" id="loc" onclick="return location_attendance();" class="md-btn md-btn-primary">Get Location</button><?php } ?>
                                <a class="md-btn md-btn-danger" id="can" href="<?php echo $this->webroot; ?>users/dashboard/" title="Click to Cancel.">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAeLpHWR4P4q5mZcO6SiXUVWYjATQQey6k&sensor=true"></script>
<script>
               document.getElementById("dvMap").style.display = "none";
               var status = "<?php echo $status['AttendanceStatus']['status']; ?>";
               function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
                   var R = 6371; // Radius of the earth in km
                   var dLat = deg2rad(lat2 - lat1);  // deg2rad below
                   var dLon = deg2rad(lon2 - lon1);
                   var a =
                           Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                           Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                           Math.sin(dLon / 2) * Math.sin(dLon / 2)
                           ;
                   var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                   var d = R * c; // Distance in km
                   return d;
               }

               function deg2rad(deg) {
                   return deg * (Math.PI / 180)
               }
               if (status == 1) {
                   function location_attendance() {

                       navigator.geolocation.getCurrentPosition(function (p) {
                           var locmap = jQuery("#dvMap").show();
                           var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
                           var geocoder = geocoder = new google.maps.Geocoder();
                           geocoder.geocode({'latLng': LatLng}, function (results, status) {
                               var lat2 = "<?php echo $status['AttendanceStatus']['latitude']; ?>";
                               var lon2 = "<?php echo $status['AttendanceStatus']['longitude']; ?>";
                               var lat1 = p.coords.latitude;
                               var lon1 = p.coords.longitude;
                               var distance = getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2).toFixed(1);
                               var distance_in_meters = distance * 1000;
                               var distance_range = "<?php echo $status['AttendanceStatus']['in_radius']; ?>";
                               if (status == google.maps.GeocoderStatus.OK) {
                                   if (results[0]) {
                                       if (distance_in_meters < distance_range) {
                                           var lat = jQuery("#latitude").val(p.coords.latitude);
                                           var lang = jQuery("#longitude").val(p.coords.longitude);
                                           var address = jQuery("#address").val(results[0].formatted_address);
                                           alert("You are in Office range to apply attendance");
                                       }
                                       else {
                                           alert("You are not in Office range to apply attendance");
                                           document.getElementById("loc").style.display = "none";
                                           document.getElementById("sub").style.display = "none";
                                           document.getElementById("can").style.display = "none";
                                       }
                                   }
                               }
                           });
                           var mapOptions = {
                               center: LatLng,
                               zoom: 13,
                               mapTypeId: google.maps.MapTypeId.ROADMAP
                           };
                           var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);

                           var circle = new google.maps.Circle({
                               center: LatLng,
                               map: map,
                               radius: 500, // IN METERS.
                               fillColor: 'red',
                               fillOpacity: 0.3,
                               strokeColor: "red",
                               strokeWeight: 0         // DON'T SHOW CIRCLE BORDER.
                           });

                           var marker = new google.maps.Marker({
                               position: LatLng,
                               map: map,
                               title: "<div style = 'height:60px;width:200px'><b>Your location:</b><br/>Latitude: " + p.coords.latitude + "<br />Longitude: " + p.coords.longitude

                           });
                           google.maps.event.addListener(marker, "click", function (e) {
                               var infoWindow = new google.maps.InfoWindow();
                               infoWindow.setContent(marker.title);
                               infoWindow.open(map, marker);

                           });
                       });

                   }
               }

</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#atten_dt").datepicker({
            startDate: '-30d',
            maxDate: 0,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            yearRange: "-2:+0",
            //changeYear: true,
            todayHighlight: true,
            endDate: 'today',
            minDate: '01-01-2018',
            dateFormat: 'dd-mm-yy',
            onSelect: function (selected, evnt) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->webroot ?>Users/getInOutTime/",
                    dataType: "json",
                    data: {"date": $(this).val()},
                    success: function (resp) {
                        if(resp.length == 0){
                            $('#prev_in_time,#prev_out_time').text('').text('--NA--');
                            
                        }
                        else{
                            $('#prev_in_time').text('').text(resp.AttendanceDetail.in_time);
                            $('#prev_out_time').text('').text(resp.AttendanceDetail.out_time);
                        }
                    },error: function(err){
                        console.log(err)
                    }
                });
             }
        });

    });
    function checktime(same)
    {

        var regexp = /([01]\d|2[0-3]):[0-5]\d/;

        var res = regexp.test(same);
        return res;
    }

    function comparetime(startTime, endTime)
    {

        var sts = startTime.split(":");
        var ets = endTime.split(":");

        var stMin = (parseInt(sts[0]) * 60 + parseInt(sts[1]));
        var etMin = (parseInt(ets[0]) * 60 + parseInt(ets[1]));
        if (etMin < stMin) {
            return false;
        } else {
            return true;
        }


    }
    function checkSubmit()
    {

        var attend_date = jQuery('#atten_dt').val();

        var intime = jQuery('#in_time');

        var outtime = jQuery('#out_time');
        var val = checktime(jQuery('#in_time').val());

        var out = checktime(jQuery('#out_time').val());
        if (attend_date === "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Attendance Date").show();
            return false;
        }

        if (val === false) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter proper In time").show();
            return false;
        }
        if (out === false)  //not found any : ///start prediction
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter proper Out time").show();
            return false;
        }

        var res = comparetime(jQuery('#in_time').val(), jQuery('#out_time').val());
        if (res === false)  //not found any : ///start prediction
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Out time cannot be less than In time").show();
            return false;
        }
        if(($('#is_od').is(':checked')) &&  ($('#od_minutes').val() == '')){
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter valid Time").show();
            return false;
        }
        if(($('#is_pgp').is(':checked')) &&  ($('#pgp_minutes').val() == '')){
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter valid Time").show();
            return false;
        }
    }

    $('#in_time').keypress(function (e) {
        if (e.which === 32)
            return false;
    });
    $('#out_time').keypress(function (e) {
        if (e.which === 32)
            return false;
    });
    $("#in_time ").on("keydown", function (e) {

        if (e.which !== 8 && e.which > 57 && e.which !== 186 && e.which !== 16 && e.which !== 59) {
            //display error message
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Enter Digit Only").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    });
    $("#out_time ").on("keydown", function (e) {

        if (e.which !== 8 && e.which > 57 && e.which !== 186 && e.which !== 16) {
            //display error message
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Enter Digit Only").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    });
    
    $('#is_od').on('change', function(){
        if($(this).is(':checked')){
            $('#od_minutes').show();
        }
        else{
            $('#od_minutes').val('').hide();
        }
    });
    $('#is_pgp').on('change', function(){
        if($(this).is(':checked')){
            $('#pgp_minutes').show();
        }
        else{
            $('#pgp_minutes').val('').hide();
        }
    });
    if($('#is_od').is(':checked')){
            $('#od_minutes').show();
    }
    if($('#is_pgp').is(':checked')){
            $('#pgp_minutes').show();
    }
    
    
</script>



