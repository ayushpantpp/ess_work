<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Settings </h3>
        <?php echo $flash = $this->Session->flash();
          $totalLeave=$this->Common->travelVoucherApplied();         
         ?>
        <div class="md-card">            
            <div class="md-card-content large-padding">

                <?php echo $this->Form->create('setting', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'uk-form-stacked' )),
           'url' => array('controller' => 'Users', 'action' => 'saveSetting'), 'id' => 'form_validation', 'name' => 'setting'));
        ?>
                <h3 class="heading_a">Please checked out the check box to change your settings.</h3>               

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-8-10">
                        <label class="margin-bottom uk-form-label" for="fullname">Change Ticker <span class="req">*</span></label>
                        <div class="clearfix"></div><br>
                            <?php foreach($ticker as $k=>$val){ ?>
                                <span class="icheck-inline">
                                    <input type="checkbox" name="ticker[]" id="ticker" value="<?php echo $k ?>" <?php foreach($tickeremp as $t=>$value){if($value == $k ) echo 'checked';} ?> data-md-icheck />
                                    <label for="checkbox_demo_1" class="inline-label"><?php echo $val ?></label>
                                </span>
                            <?php } ?>
                    </div>
                </div>                
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-8-10">
                        <div class="parsley-row">
                            <label class="uk-form-label margin-bottom" for="email">Change Important Shortcut <span class="req">*</span></label>
                            <div class="clearfix"></div><br>
                                <?php                                    
                                foreach($icon as $k=>$val){?>
                                    <span class="icheck-inline">
                                        <input type="checkbox" name="icon[]" id="icon" value="<?php echo $k ?>" <?php foreach($iconemp as $icon=>$iconvalue){ if($iconvalue == $k) echo 'checked';}?> data-md-icheck />
                                        <label for="checkbox_demo_1" class="inline-label"><?php echo $val ?></label>
                                    </span>
                                <?php }?>                                
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <input name="settingsave" class="md-btn md-btn-success" type="submit" value="SAVE"/>
                        <input name="settingsave" class="md-btn md-btn-primary" type="reset" value="Cancel"/>
                    </div>
                </div>               
                
                <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#ticker").checked(function () {
            if ($("#ticker option:selected").length > 4) {
                $("#ticker option:selected:nth-child(5)").removeAttr('selected');
                $(this).parent().find('.select2').find('ul li:nth-child(5)').remove();
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>you cannot enter more than four tickers").show();
                return false;
            }

        });
    });
</script>