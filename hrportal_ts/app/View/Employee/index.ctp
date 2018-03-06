<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script language="javascript" type="text/javascript">


            jQuery(document).ready(function () {
                jQuery("#startdate").datepicker();
                jQuery("#enddate").datepicker();
               
       
            });

            function showDepartment(comp)
            {
                //alert("hello"+comp);
                var e = document.getElementById("comp");
                var strUser = e.options[e.selectedIndex].value;
                var d = parseInt(strUser) + 1;
                $.ajax({
                    type: 'GET',
                    url: "<?php echo $this->webroot; ?>Employees/getDepartment/" + comp,
                    success: function (data)
                    {
                        data = jQuery.parseJSON(data);
                        var list = '';
                        //alert(data);
                        //jQuery("#dept").html();
                        list += "<option value=''>Select Department</option>";
                        $.each(data, function (index, value) {
                            list += "<option value='" + index + "'>" + value + "</option>";

                        });
                        jQuery("#dept").html(list);
                    }
                });


            }
            function showDesignation(dept)
            {
                //alert("hello"+dept);
                var e = document.getElementById("dept");
                var strUser = e.options[e.selectedIndex].value;
                var d = parseInt(strUser) + 1;
                $.ajax({
                    type: 'GET',
                    url: "<?php echo $this->webroot; ?>Employees/getDesignation/" + dept,
                    success: function (data)
                    {
                        data = jQuery.parseJSON(data);
                        var list = '';
                        //alert(data);
                        //jQuery("#dept").html();
                        list += "<option value=''>Select Designation</option>";
                        $.each(data, function (index, value) {
                            list += "<option value='" + index + "'>" + value + "</option>";

                        });
                        jQuery("#desg").html(list);
                    }
                });


            }
            function showState(country)
            {
                //alert("hello"+country);
                var e = document.getElementById("country");
                var strUser = e.options[e.selectedIndex].value;
                var d = parseInt(strUser) + 1;
                $.ajax({
                    type: 'GET',
                    url: "<?php echo $this->webroot; ?>Employees/getState/" + country,
                    success: function (data)
                    {
                        data = jQuery.parseJSON(data);
                        var list = '';
                        //alert(data);
                        //jQuery("#dept").html();
                        list += "<option value=''>Select State</option>";
                        $.each(data, function (index, value) {
                            list += "<option value='" + index + "'>" + value + "</option>";

                        });
                        jQuery("#state").html(list);
                    }
                });


            }

            function showCity(state)
            {
                //alert("hello"+country);
                var e = document.getElementById("state");
                var strUser = e.options[e.selectedIndex].value;
                var d = parseInt(strUser) + 1;
                $.ajax({
                    type: 'GET',
                    url: "<?php echo $this->webroot; ?>Employees/getCity/" + state,
                    success: function (data)
                    {
                        data = jQuery.parseJSON(data);
                        var list = '';
                        //alert(data);
                        //jQuery("#dept").html();
                        list += "<option value=''>Select City</option>";
                        $.each(data, function (index, value) {
                            list += "<option value='" + index + "'>" + value + "</option>";

                        });
                        jQuery("#city").html(list);
                    }
                });


            }

        </script>
    </head>
    <div class="breadCrumbHolder module">
        <div id="breadCrumb0" class="breadCrumb module">
            <ul>
                <li><a href="#" class="vtip" title="Home">Home</a></li>
                <li>User</li>
                <li>Add New User</li>   
               <li> <select name='lang' class='language-select'>
    <option value='en'>English</option>
    <option value='fr'>French</option>
    <option value='sp'>Spanish</option>
</select></li>                  
            </ul>
        </div>
    </div>

    <br>

    <div id="add_msg_div" >
        <h2 class="demoheaders">USER PROFILE<a href="#" id="create"></a>  </h2>

        <?php
        echo $this->Form->create('Employee', array('url' => 'add', 'name' => 'msgForm', 'id' => 'Employee', 'onsubmit' => 'return doChk()', 'enctype' => 'multipart/form-data', 'inputDefaults' => array('label' => false, 'div' => false)));
        ?>
        <div class="travel-voucher" style="height:700px;">
            <div class="input-boxs">
                <table width="100%" border="0"  cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                    <tr>
                        <?php
                        $Company = array();
                        $Company[] = $this->Common->findCompanyName();
                        ?>
                        <script type='text/html-template' lang='fr'>
    <strong>compagnie</strong>
</script>
<script type='text/html-template' lang='sp'>
    <strong>
empresa</strong>
</script>
<script type='text/html-template' lang='en'>
    <strong>Company</strong>
</script>

          <div class='article' data-current-language='en'><th width="220" scope="row" ><strong>Company  :</strong>  </th></div>
                        <td><?php echo $this->Form->input('comp_code', array('type' => 'select', 'class' => 'round_select', 'id' => 'comp', 'empty' => 'Select Company', 'options' => $Company, 'onChange' => 'showDepartment(this.value)')); ?>
                            <div id="compErr" style="color:red"></div>
                        </td>
                        <th width="120" scope="row"><strong> Department  :</strong>  </th>
                        <td><?php echo $this->Form->input('dept_code', array('type' => 'select', 'class' => 'round_select', 'empty' => 'Select Department', 'id' => 'dept', 'options' => '', 'onChange' => 'showDesignation(this.value)')); ?>
                            <div id="deptErr" style="color:red"></div>
                        </td>
                    </tr>           				
                    
                    <tr>                        
                        <th scope="row"><strong> Designation  :</strong>  </th>
                        <td><?php echo $this->Form->input('desg_code', array('type' => 'select', 'class' => 'round_select', 'empty' => 'Select Designation', 'id' => 'desg', 'options' => '')); ?>
                            <div id="desgErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Employee Code :</strong>  </th>
                        <td><?php echo $this->Form->input('emp_code', array('class' => 'round_select', 'id' => 'emp', 'maxLength' => 30)); ?>
                            <div id="empErr" style="color:red"></div>
                        </td>
                    </tr>
                              
                    <tr>
                        <th scope="row"><strong>  First Name :</strong>  </th>
                        <td><?php echo $this->Form->input('emp_firstname', array('class' => 'round_select', 'id' => 'fname', 'maxLength' => 90)); ?>
                            <div id="fnameErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>  Last Name :</strong>  </th>
                        <td><?php echo $this->Form->input('emp_lastname', array('class' => 'round_select', 'id' => 'lname', 'maxLength' => 90)); ?>
                            <div id="lnameErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>                   
                        <th scope="row"><strong>Date Of Birth :</strong>  </th>
                        <td><?php echo $this->Form->input('dob', array('type' => 'text', 'class' => 'round_select', 'id' => 'dob')); ?>
                            <div id="dobErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Date Of Joining :</strong>  </th>
                        <td><?php echo $this->Form->input('join_date', array('type' => 'text', 'class' => 'round_select', 'id' => 'doj')); ?>
                            <div id="dojErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><strong>E-mail :</strong>  </th>
                        <td><?php echo $this->Form->input('email', array('type' => 'email', 'class' => 'round_select', 'id' => 'email', 'maxLength' => 90)); ?>
                            <div id="emailErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Username :</strong>  </th>
                        <td><?php echo $this->Form->input('username', array('class' => 'round_select', 'id' => 'uname', 'maxLength' => 90)); ?>
                            <div id="unameErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><strong> Password :</strong>  </th>
                        <td><?php echo $this->Form->input('password', array('minlength' => 6, 'type' => 'password', 'class' => 'round_select', 'id' => 'pass', 'maxLength' => 90, 'minlength' => 8)); ?>
                            <div id="passErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Retype Password :</strong>  </th>
                        <td><?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'round_select', 'id' => 'repass', 'maxLength' => 90, 'minlength' => 8)); ?>
                            <div id="repassErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>

                        <th scope="row"> Gender :  </th>
                        <td class="gender"><?php
                            $options = array('M' => 'Male  ', 'F' => 'Female');
                            $attributes = array('legend' => false);
                            echo $this->Form->radio('gender', $options, $attributes, array('class' => '.radio-inline', 'id' => 'gender'));
                            ?></td>
                    <div id="genderErr" style="color:red"></div>
            <!--<td>
<label class=".radio-inline"><input type="radio" name="gender" value="M">Male</label>
     <label class=".radio-inline"><input type="radio" name="gender" value="F">Female</label>
     <div id="dnameErr8" style="color:red"></div>
</td>
<label class="checkbox-inline"><input type="checkbox" value="">Option 1</label>-->
                    <th scope="row"><strong>Blood-Group :</strong>  </th>
                        <td><?php echo $this->Form->input('blood_group', array('type' => 'text', 'class' => 'round_select', 'id' => 'blood_group')); ?>
                            <div id="bgErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>

                        <th scope="row"><strong>Permanent Address :</strong>  </th>
                        <td colspan="3"><?php echo $this->Form->input('address', array('type' => 'textarea', 'class' => 'round_select_textarea', 'id' => 'address', 'rows' => '25', 'cols' => '25', 'maxLength' => 90)); ?>
                            <div id="addressErr" style="color:red"></div>
                        </td>                    
                    </tr>
                    <tr>
                        <th scope="row"><strong>Country :</strong>  </th>
                        <td><?php echo $this->Form->input('country', array('type' => 'select', 'class' => 'round_select', 'empty' => 'Select Country', 'id' => 'country', 'options' => $country, 'onChange' => 'showState(this.value)')); ?>
                            <div id="countryErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>State :</strong>  </th>
                        <td><?php echo $this->Form->input('state', array('type' => 'select', 'class' => 'round_select', 'id' => 'state', 'empty' => 'Select State', 'options' => '', 'onChange' => 'showCity(this.value)')); ?>
                            <div id="stateErr" style="color:red"></div>
                        </td>					
                    </tr>
                    <tr>
                        <th scope="row"><strong>City :</strong>  </th>
                        <td><?php echo $this->Form->input('city', array('type' => 'select', 'class' => 'round_select', 'id' => 'city', 'empty' => 'Select City', 'options' => '')); ?>
                            <div id="cityErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Pin-Code :</strong>  </th>
                        <td><?php echo $this->Form->input('cur_pincode_id', array('type' => 'text', 'class' => 'round_select', 'id' => 'cpin')); ?>
                            <div id="cpinErr" style="color:red"></div>
                        </td>					
                    </tr>
                    <tr>
                        <th scope="row"><strong>Current Address :</strong>  </th>
                        <td><?php echo $this->Form->input('caddress', array('type' => 'textarea', 'class' => 'round_select_textarea', 'id' => 'caddress', 'rows' => '5', 'cols' => '5', 'maxLength' => 90)); ?>
                            <div id="caddressErr" style="color:red"></div>
                        </td>					
                    </tr>
                    <tr>
                        <th scope="row"><strong>Country :</strong>  </th>
                        <td><?php echo $this->Form->input('country', array('type' => 'select', 'class' => 'round_select', 'id' => 'country', 'empty' => 'Select Country', 'options' => $country, 'onChange' => 'showState(this.value)')); ?>
                            <div id="countryErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>State :</strong>  </th>
                        <td><?php echo $this->Form->input('state', array('type' => 'select', 'class' => 'round_select', 'id' => 'state', 'empty' => 'Select State', 'options' => '')); ?>
                            <div id="stateErr" style="color:red"></div>
                        </td>					
                    </tr>
                    <tr>
                        <th scope="row"><strong>City :</strong>  </th>
                        <td><?php echo $this->Form->input('city', array('type' => 'select', 'class' => 'round_select', 'id' => 'city')); ?>
                            <div id="cityErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Pin-Code :</strong>  </th>
                        <td><?php echo $this->Form->input('cur_pincode_id', array('type' => 'text', 'class' => 'round_select', 'id' => 'cpin')); ?>
                            <div id="cpinErr" style="color:red"></div>
                        </td>					
                    </tr>
                    <tr>
                        <th scope="row"><strong>Region :</strong>  </th>
                        <td><?php echo $this->Form->input('region_id', array('type' => 'text', 'class' => 'round_select', 'id' => 'region')); ?>
                            <div id="regionErr" style="color:red"></div>
                        </td>
                        <th scope="row"> Marital Status :  </th>
                        <td class="marital"><?php
                            $options = array('01' => 'Married  ', '02' => 'Unmarried');
                            $attributes = array('legend' => false);
                            echo $this->Form->radio('marital', $options, $attributes, array('class' => '.radio-inline', 'id' => 'marital'));
                            ?></td>
                    <div id="maritalErr" style="color:red"></div>
                    </tr>
                    <tr>                   
                        <th scope="row"><strong>Wedding Date :</strong>  </th>
                        <td><?php echo $this->Form->input('weddate', array('type' => 'text', 'class' => 'round_select', 'id' => 'weddate')); ?>
                            <div id="wdErr" style="color:red"></div>
                        </td>
                        <th scope="row"><strong>Status  :</strong>  </th>
                        <td><?php echo $this->Form->input('status', array('type' => 'select', 'class' => 'round_select', 'id' => 'status', 'empty' => 'Select Status', 'options' => $st)); ?>
                            <div id="statusErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><strong> Contact :</strong>  </th>
                        <td><?php echo $this->Form->input('contact', array('class' => 'round_select', 'id' => 'contact', 'maxLength' => 30)); ?>
                            <div id="contactErr" style="color:red"></div>
                        </td>
                        <th scope="row">Image :</th><td><label id="div_user_img"><?php
                                if (!empty($img_val['Employee']['img_path'])) {
                                    echo '<img src="' . $img_val['Employee']['img_path'] . '">';
                                }
                                ?>
                            </label><input type="file" name="user_img" id="image" class="displaynone"><div id="imageErr" style="color:red"></div></td></tr>

                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3">
                            <div>
                                <?php echo $this->Form->button('Submit', array('type' => 'submit', 'id' => 'add', 'class' => 'successButton', 'value' => 'Submit'));?>
                                <?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'infoButton')); ?>
                            </div>
                        </td>                        
                    </tr>
                </table>
            </div>
        </div>
        <?php
        echo $this->Form->end();
        ?>

    </div>



    <script>

        /*Add record script*/



        jQuery("form[name='msgForm']").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                doChk();
                return false;
            } else {

            }
        });





        function lists() {
            var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            jQuery("#result").html(data);
            var fdata = jQuery("#searchForm").serialize();
            jQuery.post('<?php echo $this->webroot; ?>Employees/lists',
                    fdata,
                    function (data) {

                        jQuery("#result").html(data);

                    }, 'html'
                    ).error(function (e) {
                alert("Error : " + e.statusText);
            });
        }

    </script>
    <script>


        function doChk() {
            var err = 0;
            var emp = jQuery.trim(jQuery("#emp").val());
            var comp = jQuery.trim(jQuery("#comp").val());
            var fname = jQuery.trim(jQuery("#fname").val());
            var lname = jQuery.trim(jQuery("#lname").val());
            var dept = jQuery.trim(jQuery("#dept").val());
            var desg = jQuery.trim(jQuery("#desg").val());
            var uname = jQuery.trim(jQuery("#uname").val());
            var pass = jQuery.trim(jQuery("#pass").val());
            var repass = jQuery.trim(jQuery("#repass").val());
            var address = jQuery.trim(jQuery("#address").val());
            var contact = jQuery.trim(jQuery("#contact").val());
            var email = jQuery.trim(jQuery("#email").val());
            var image = jQuery.trim(jQuery("#image").val());
            var gender = jQuery.trim(jQuery("#gender").val());
            var dob = jQuery.trim(jQuery("#dob").val());
            var doj = jQuery.trim(jQuery("#doj").val());

            if (comp == '') {
                jQuery("#compErr").html("<?php echo "Please Enter Company "; ?>");
                jQuery("#comp").focus();
                err++;
                return false;
            } else {
                jQuery("#compErr").html("");
            }
            if (dept == '') {
                jQuery("#deptErr").html("<?php echo "Please Enter Departmant "; ?>");
                jQuery("#dept").focus();
                err++;
                return false;
            } else {
                jQuery("#deptErr").html("");
            }
            if (desg == '') {
                jQuery("#desgErr").html("<?php echo "Please Enter Designation "; ?>");
                jQuery("#desg").focus();
                err++;
                return false;
            } else {
                jQuery("#desgErr").html("");
            }
            if (emp == '') {
                jQuery("#empErr").html("<?php echo "Please Enter Employee Code."; ?>");
                jQuery("#emp").focus();
                err++;
                return false;
            } else {
                jQuery("#empErr").html("");
            }
            if (fname == '') {
                jQuery("#fnameErr").html("<?php echo "Please Enter Employee Firstname."; ?>");
                jQuery("#fname").focus();
                err++;
                return false;
            } else {
                jQuery("#fnameErr").html("");
            }
            if (lname == '') {
                jQuery("#lnameErr").html("<?php echo "Please Enter Employee Lastname."; ?>");
                jQuery("#lname").focus();
                err++;
                return false;
            } else {
                jQuery("#lnameErr").html("");
            }
            if (dob == '') {
                jQuery("#dobErr").html("<?php echo "Please Enter Date Of Birth."; ?>");
                jQuery("#dob").focus();
                err++;
                return false;
            } else {
                jQuery("#dobErr").html("");
            }
            if (doj == '') {
                jQuery("#dojErr").html("<?php echo "Please Mention Your Date Of Joining."; ?>");
                jQuery("#doj").focus();
                err++;
                return false;
            } else {
                jQuery("#dojErr").html("");
            }
            if (email == '') {
                jQuery("#emailErr").html("<?php echo "Please Enter Valid E-mail."; ?>");
                jQuery("#email").focus();
                err++;
                return false;
            } else {
                jQuery("#emailErr").html("");
            }
            if (uname == '') {
                jQuery("#unameErr").html("<?php echo "Please Enter Username."; ?>");
                jQuery("#uname").focus();
                err++;
                return false;
            } else {
                jQuery("#unameErr").html("");
            }
            if (pass == '') {
                jQuery("#passErr").html("<?php echo "Please Enter Password."; ?>");
                jQuery("#pass").focus();
                err++;
                return false;
            } else {
                jQuery("#passErr").html("");
            }
            if (repass == '') {
                jQuery("#repassErr").html("<?php echo "Please Retype Password."; ?>");
                jQuery("#repass").focus();
                err++;
                return false;
            } else {
                jQuery("#repassErr").html("");
            }
            if (repass != pass) {
                jQuery("#repassErr").html("<?php echo "Please Enter Correct Password."; ?>");
                jQuery("#repass").focus();
                err++;
                return false;
            } else {
                jQuery("#repassErr").html("");
            }
            /* if(gender=='') {
             jQuery("#genderErr").html("<?php echo "Please Mention Your Gender."; ?>");
             jQuery("#gender").focus();
             err++;
             return false;	
             } else {
             jQuery("#genderErr").html("");
             } */
            if (address == '') {
                jQuery("#addressErr").html("<?php echo "Please Enter Address."; ?>");
                jQuery("#address").focus();
                err++;
                return false;
            } else {
                jQuery("#addressErr").html("");
            }
            if (contact == '') {
                jQuery("#contactErr").html("<?php echo "Please Enter Contact No."; ?>");
                jQuery("#contact").focus();
                err++;
                return false;
            } else {
                jQuery("#contactErr").html("");
            }
            if (image == '') {
                jQuery("#imageErr").html("<?php echo "Please Select Your File"; ?>");
                jQuery("#image").focus();
                err++;
                return false;
            } else {
                jQuery("#imageErr").html("");
            }
        }

    </script>	

    <style>
        .exp-voucher .round_select{width:90%;}
        .gender label{padding:0 10px 0 0;}
        .marital label{padding:0 10px 0 0;}

    </style>