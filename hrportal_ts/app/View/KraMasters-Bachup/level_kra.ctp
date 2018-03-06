<div class="form-group col-md-6 col-sm-6 col-xs-12">
    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">KRA Name<span class="required">*</span></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <select multiple  class="form-control col-md-4 col-xs-12" name="kraName[]" id="kralist" style="height: 40%;">
                                    <?php foreach($kraNameLists as $val){ ?>
            <option value='<?php echo $val['AssignDesignationKras']['kra_id']?>'><?php echo $val['KraMaster']['kra_name']." (".$val['KpiMasters']['weightage'].")"; ?></option>
                                    <?php } ?>
        </select>
    </div>
</div>

<div class="form-group col-md-6 col-sm-6 col-xs-12">
    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Competency Name<span class="required">*</span></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <select multiple  class="form-control col-md-4 col-xs-12" name="compName[]" id="complist">
                                    <?php foreach($competencyNameLists as $k=>$val){ ?>
            <option value='<?php echo $k?>'><?php echo $val ?></option>
                                    <?php } ?>
        </select>
    </div>
</div>