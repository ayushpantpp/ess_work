
<?php if($val=='1'){  ?>

                        <div class="parsley-row">
                                <label for="department">MDA <span class="req">*</span></label>
                                <select name="ministry" required="required" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php
                                    foreach($Ministry as $key => $rt){
                                    $value = $key;
                                    $option = $rt;
                                    
                                           echo "<option value='".$value."'>".$option."</option>";
                                    
                                }
                                    ?>
                                </select>
                                
                        </div>
                    

<?php }else{?>
<div class="uk-width-medium-1-3"  id="new_field">
    <div class="parsley-row">
                                <label for="t_o_org">Type of Organisation <span class="req">*</span></label>
                                <select name="t_o_org" required="required" onchange="return org_name(this.value)" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <option value="1">MDA</option>
                                    <option value="2">Commission</option>
                                    <option value="3">Independent office</option>
                                </select>
                                  
                             </div>
        </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                                <label for="department">MDA <span class="req">*</span></label>
                                <select name="ministry" required="required" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php
                                    foreach($Ministry as $key => $rt){
                                    $value = $key;
                                    $option = $rt;
                                    
                                           echo "<option value='".$value."'>".$option."</option>";
                                    
                                }
                                    ?>
                                </select>
                                
                        </div>
    <?php }?>