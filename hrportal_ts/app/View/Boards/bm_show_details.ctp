<?php
$termServ = array('Term1', 'Term2', 'Term3', 'Term4');
$promotions = array('Promotion 1', 'Promotion 2', 'Promotion 3', 'Promotion 4');
$secnodments = array('Second1', 'Second2', 'Second3', 'Second4');
$retGround = array('RetGround1', 'RetGround2', 'RetGround3', 'RetGround4');
$gender = array('Male', 'Female');
if ($val == '2') {
    //For Appointment
    ?>
    <hr>
    <h3 class="heading_a" style="text-align: center">Appointment</h3>
    <hr>
    <?php foreach ($showDet as $rec)
        ;
    ?>             
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Serial Number :</b> <?php echo $rec['BMDataTypeDetails']['serial_num']; ?></label>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>ID No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['id_no']; ?></span>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">

            </div>
        </div>


    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>P No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['p_no']; ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Officer Name :</b></label>
                <span><?php echo $this->common->getTitle($rec['BMDataTypeDetails']['title']) . " " . $rec['BMDataTypeDetails']['firstname'] . " " . $rec['BMDataTypeDetails']['surname']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Date of Birth :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['dob'])); ?></span>

            </div>
        </div>
    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Gender  :</b></label>
                <span><?php
                    if ($rec['BMDataTypeDetails']['gender'] == "0") {
                        echo "Male";
                    } else {
                        echo "Female";
                    }
                    ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Qualification :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['qualification']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Physical Disability :</b></label>
                <span>
    <?php
    if ($rec['BMDataTypeDetails']['physical_disability'] == "0") {
        echo "Yes";
        ?>
                        <br><label for="subject"><b>Disability Details :</b></label>
                        <span>
                            <?php
                            $str = $rec['BMDataTypeDetails']['disable_details'];
                            echo wordwrap($str, 29, "<br>\n");
                            ?>
                            <?php
                        } else {
                            echo "No";
                        }
                        ?></span>

            </div>
        </div>




    </div>
    <?php if ($rec['BMDataTypeDetails']['data_entry_type'] == "1") { ?>
        <div  class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-3">
                <div class="parsley-row">
                    <label for="subject"><b>Academic :</b></label>
                    <span>
        <?php
        $str = $rec['BMDataTypeDetails']['academic'];
        echo wordwrap($str, 29, "<br>\n");
        ?>
                    </span>

                </div>
            </div>

            <div class="uk-width-medium-1-3">
                <div class="parsley-row">
                    <label for="subject"><b>Professional  :</b></label>
                    <span>
        <?php
        $str = $rec['BMDataTypeDetails']['professional'];
        echo wordwrap($str, 29, "<br>\n");
        ?>
                    </span>

                </div>
            </div>

            <div class="uk-width-medium-1-3">
                <div class="parsley-row">
                    <label for="subject"><b>Experience :</b></label>
                    <span>
        <?php
        $str = $rec['BMDataTypeDetails']['experience'];
        echo wordwrap($str, 29, "<br>\n");
        ?>
                    </span>

                </div>
            </div>

        </div>
    <?php } ?>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Ministry :</b></label>
                <span>
    <?php echo $this->common->getMinistryByID($rec['BMDataTypeDetails']['ministry_id']); ?>

                </span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Department :</b></label>
                <span>
    <?php echo $this->common->getdepartmentbyid($rec['BMDataTypeDetails']['department_code']); ?>
                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Data of First Appointment :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['d_o_appointment'])); ?></span>

            </div>
        </div>


    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Data of Current Appointment :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['d_o_c_appointment'])); ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Current Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['currenct_designation']); ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['recommended_designation']); ?></span>

            </div>
        </div>





    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Term of Services :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['recomm_term_services'];
                    echo in_array($str, $termServ);
                    if (array_key_exists($str, $termServ)) {
                        echo $termServ[$str];
                    }
                    //echo wordwrap($str,29,"<br>\n");
                    ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Justification :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['justification'];
                    echo wordwrap($str, 29, "<br>\n");
                    ?>
                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Notes :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['notes'];
                    echo wordwrap($str, 29, "<br>\n");
                    ?>
                </span>
            </div>
        </div>
    </div>




    <?php
} elseif ($val == '3') {
    //For Promotion...
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Promotion</h3>
    <hr>
    <?php foreach ($showDet as $rec)
        ;
    ?>             
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Serial Number :</b> <?php echo $rec['BMDataTypeDetails']['serial_num']; ?></label>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>ID No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['id_no']; ?></span>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">

            </div>
        </div>


    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>P No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['p_no']; ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Officer Name :</b></label>
                <span><?php echo $this->common->getTitle($rec['BMDataTypeDetails']['title']) . " " . $rec['BMDataTypeDetails']['firstname'] . " " . $rec['BMDataTypeDetails']['surname']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Date of Birth :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['dob'])); ?></span>

            </div>
        </div>
    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Gender  :</b></label>
                <span><?php
    if ($rec['BMDataTypeDetails']['gender'] == "0") {
        echo "Male";
    } else {
        echo "Female";
    }
    ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Promotion Type :</b></label>
                <span><?php
    $strr = $rec['BMDataTypeDetails']['promotion_type'];
    if (array_key_exists($strr, $promotions)) {
        echo $promotions[$strr];
    }
    ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Physical Disability :</b></label>
                <span>
                        <?php
                        if ($rec['BMDataTypeDetails']['physical_disability'] == "0") {
                            echo "Yes";
                            ?>
                        <br><label for="subject"><b>Disability Details :</b></label>
                        <span>
                            <?php
                            $str = $rec['BMDataTypeDetails']['disable_details'];
                            echo wordwrap($str, 29, "<br>\n");
                            ?>
        <?php
    } else {
        echo "No";
    }
    ?></span>

            </div>
        </div>




    </div>

    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Academic :</b></label>
                <span>
    <?php
    $str = $rec['BMDataTypeDetails']['academic'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Professional  :</b></label>
                <span>
    <?php
    $str = $rec['BMDataTypeDetails']['professional'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Experience :</b></label>
                <span>
    <?php
    $str = $rec['BMDataTypeDetails']['experience'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>

            </div>
        </div>

    </div>

    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Ministry :</b></label>
                <span>
    <?php echo $this->common->getMinistryByID($rec['BMDataTypeDetails']['ministry_id']); ?>

                </span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Department :</b></label>
                <span>
    <?php echo $this->common->getdepartmentbyid($rec['BMDataTypeDetails']['department_code']); ?>
                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Data of First Appointment :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['d_o_appointment'])); ?></span>

            </div>
        </div>


    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Data of Current Appointment :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['d_o_c_appointment'])); ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Current Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['currenct_designation']); ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['recommended_designation']); ?></span>

            </div>
        </div>





    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Term of Services :</b></label>
                <span><?php
    $str = $rec['BMDataTypeDetails']['recomm_term_services'];
    echo in_array($str, $termServ);
    if (array_key_exists($str, $termServ)) {
        echo $termServ[$str];
    }
    //echo wordwrap($str,29,"<br>\n");
    ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Justification :</b></label>
                <span><?php
    $str = $rec['BMDataTypeDetails']['justification'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Notes :</b></label>
                <span><?php
    $str = $rec['BMDataTypeDetails']['notes'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>
            </div>
        </div>
    </div>
    <?php
} elseif ($val == '5') {
    //For Redesignation ....
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Re-Designation</h3>
    <hr>
    <?php foreach ($showDet as $rec)
        ;
    ?>             
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Serial Number :</b> <?php echo $rec['BMDataTypeDetails']['serial_num']; ?></label>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>ID No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['id_no']; ?></span>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>P No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['p_no']; ?></span>
            </div>
        </div>


    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Gender  :</b></label>
                <span><?php
    if ($rec['BMDataTypeDetails']['gender'] == "0") {
        echo "Male";
    } else {
        echo "Female";
    }
    ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Officer Name :</b></label>
                <span><?php echo $this->common->getTitle($rec['BMDataTypeDetails']['title']) . " " . $rec['BMDataTypeDetails']['firstname'] . " " . $rec['BMDataTypeDetails']['surname']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Date of Birth :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['dob'])); ?></span>

            </div>
        </div>
    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Academic :</b></label>
                <span>
    <?php
    $str = $rec['BMDataTypeDetails']['academic'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Professional  :</b></label>
                <span>
    <?php
    $str = $rec['BMDataTypeDetails']['professional'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Experience :</b></label>
                <span>
    <?php
    $str = $rec['BMDataTypeDetails']['experience'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>

            </div>
        </div>

    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Ministry :</b></label>
                <span>
    <?php echo $this->common->getMinistryByID($rec['BMDataTypeDetails']['ministry_id']); ?>

                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Department :</b></label>
                <span>
    <?php echo $this->common->getdepartmentbyid($rec['BMDataTypeDetails']['department_code']); ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Current Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['currenct_designation']); ?></span>


            </div>
        </div>

    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['recommended_designation']); ?></span>



            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Justification :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['justification'];
                    echo wordwrap($str, 29, "<br>\n");
                    ?>
                </span>  

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Notes :</b></label>
                <span><?php
    $str = $rec['BMDataTypeDetails']['notes'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>
            </div>
        </div>

    </div>


    <?php
} elseif ($val == '6') {
    //For Secondment / Transfer of Service ....
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Secondment / Transfer of Service</h3>
    <hr>
    <?php foreach ($showDet as $rec)
        ;
    ?>             
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Serial Number :</b> <?php echo $rec['BMDataTypeDetails']['serial_num']; ?></label>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>ID No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['id_no']; ?></span>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>P No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['p_no']; ?></span>
            </div>
        </div>


    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Gender  :</b></label>
                <span><?php
    if ($rec['BMDataTypeDetails']['gender'] == "0") {
        echo "Male";
    } else {
        echo "Female";
    }
    ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Officer Name :</b></label>
                <span><?php echo $this->common->getTitle($rec['BMDataTypeDetails']['title']) . " " . $rec['BMDataTypeDetails']['firstname'] . " " . $rec['BMDataTypeDetails']['surname']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Date of Birth :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['dob'])); ?></span>

            </div>
        </div>
    </div>



    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Ministry :</b></label>
                <span>
    <?php echo $this->common->getMinistryByID($rec['BMDataTypeDetails']['ministry_id']); ?>

                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Department :</b></label>
                <span>
    <?php echo $this->common->getdepartmentbyid($rec['BMDataTypeDetails']['department_code']); ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Current Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['currenct_designation']); ?></span>


            </div>
        </div>

    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Term of Services :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['recomm_term_services'];
                    if (array_key_exists($str, $termServ)) {
                        echo $termServ[$str];
                    }
                    ?>
                </span>


            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Secondment \ Services Transfer :</b></label>
                <span><?php
                    $sse = $rec['BMDataTypeDetails']['secondment_transfer_id'];
                    if (array_key_exists($sse, $secnodments)) {
                        echo $secnodments[$sse];
                    }
                    ?>
                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Justification :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['justification'];
                    echo wordwrap($str, 29, "<br>\n");
                    ?>
                </span>  

            </div>
        </div>


    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Notes :</b></label>
                <span><?php
    $str = $rec['BMDataTypeDetails']['notes'];
    echo wordwrap($str, 29, "<br>\n");
    ?>
                </span>
            </div>
        </div>
    </div>
    <?php
} elseif ($val == '4' || $val == '7' || $val == '8' || $val == '9' || $val == '10' || $val == '11') {
    if ($val == '4') {
        $lable = "Retirement";
    } elseif ($val == '7') {
        $lable = "Authority to Recruit";
    } elseif ($val == '8') {
        $lable = "Guidance / Adivsory";
    } elseif ($val == '9') {
        $lable = "Establishment / Abolition of offices";
    } elseif ($val == '10') {
        $lable = "Noting of Decisions / Concerns";
    } elseif ($val == '11') {
        $lable = "Approval of Schemes of Services";
    }
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center"><?php echo $lable; ?></h3>
    <hr>
    <?php foreach ($showDet as $rec)
        ;
    ?>             
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Serial Number :</b> <?php echo $rec['BMDataTypeDetails']['serial_num']; ?></label>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>ID No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['id_no']; ?></span>
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>P No. :</b></label>
                <span><?php echo $rec['BMDataTypeDetails']['p_no']; ?></span>
            </div>
        </div>


    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Gender  :</b></label>
                <span><?php
                if ($rec['BMDataTypeDetails']['gender'] == "0") {
                    echo "Male";
                } else {
                    echo "Female";
                }
                ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Officer Name :</b></label>
                <span><?php echo $this->common->getTitle($rec['BMDataTypeDetails']['title']) . " " . $rec['BMDataTypeDetails']['firstname'] . " " . $rec['BMDataTypeDetails']['surname']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Date of Birth :</b></label>
                <span><?php echo date("d/m/Y", strtotime($rec['BMDataTypeDetails']['dob'])); ?></span>

            </div>
        </div>
    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Ministry :</b></label>
                <span>
    <?php echo $this->common->getMinistryByID($rec['BMDataTypeDetails']['ministry_id']); ?>

                </span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Department :</b></label>
                <span>
    <?php echo $this->common->getdepartmentbyid($rec['BMDataTypeDetails']['department_code']); ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Current Designation :</b></label>
                <span><?php echo $this->Common->getDesignationNameByID($rec['BMDataTypeDetails']['currenct_designation']); ?></span>


            </div>
        </div>

    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Retirement Grounds :</b></label>
                <span><?php
                    $Rgrnd = $rec['BMDataTypeDetails']['retirement_ground_id'];
                    if (array_key_exists($Rgrnd, $retGround)) {
                        echo $retGround[$Rgrnd];
                    }
                    ?></span>


            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommended Term of Services :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['recomm_term_services'];
                    echo in_array($str, $termServ);
                    if (array_key_exists($str, $termServ)) {
                        echo $termServ[$str];
                    }
                    ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Justification :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['justification'];
                    echo wordwrap($str, 29, "<br>\n");
                    ?>
                </span>
            </div>
        </div>

    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Notes :</b></label>
                <span><?php
                    $str = $rec['BMDataTypeDetails']['notes'];
                    echo wordwrap($str, 29, "<br>\n");
                    ?>
                </span>
            </div>
        </div>
    </div>

<?php } ?>

