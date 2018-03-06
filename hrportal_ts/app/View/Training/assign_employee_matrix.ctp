<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Evolution Matrix Assign to Employee</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'savesassignemployeematrix'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked'));
                $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
                $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
                ?>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee List*</label>
                            <?php echo $this->Form->input('employee_code', array('type' => 'select', 'label' => "", 'options' => $employeelist, 'multiple' => true, 'id' => 'selec_adv_12')); ?>
                        </div>
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#" onClick = "return checkSubmit()">APPLY</button>
                        <a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/viewAssignedEmployeeMatrix">Cancel</a>

                    </div>
                </div>
                <?php $this->Form->end(); ?>
            </div>            
        </div>
    </div>
</div>
<script>
    function checkSubmit() {
        if (jQuery("#selec_adv_12").val() == null) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select At least one Employee.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    }

    jQuery(document).ready(function () {
        $("#selec_adv_12").selectize({
            plugins: {
                remove_button: {
                    label: ""
                }
            },
            options: [],
            maxItems: null,
            valueField: "id",
            labelField: "title",
            searchField: "title",
            create: !1,
            render: {
                option: function (t, e) {
                    return '<div class="option"><span class="title">' + e(t.title) + "</span></div>"
                },
                item: function (t, e) {
                    return '<div class="item"><a href="' + e(t.url) + '" target="_blank">' + e(t.title) + "</a></div>"
                }
            },
            onDropdownOpen: function (t) {
                t.hide().velocity("slideDown", {
                    begin: function () {
                        t.css({
                            "margin-top": "0"
                        })
                    },
                    duration: 200,
                    easing: easing_swiftOut
                })
            },
            onDropdownClose: function (t) {
                t.show().velocity("slideUp", {
                    complete: function () {
                        t.css({
                            "margin-top": ""
                        })
                    },
                    duration: 200,
                    easing: easing_swiftOut
                })
            }
        });
    });
</script>