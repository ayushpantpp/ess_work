<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add KRA Competency Group</h2>
                        <div class="clearfix"></div>
                    </div>
                    <?php   echo $this->Form->create('Kra', array('inputDefaults' => array('label' => false,'div' => false,'error' => array('wrap' => 'span','class' => 'my-error-class')), 'url' => array('controller' => 'KraMasters', 'action' => 'addKraGroup'), 'id' => 'addkra', 'name' => 'addkra'));?>
                    <div class="x_content">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">KRA Name</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->Form->input('kraName', array('class'=>'form-control','type' => 'text')); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">KRA Detail</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->Form->input('kpiName', array('class'=>'form-control','type' => 'textarea')); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Weightage</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->Form->input('weightage', array('class'=>'form-control','type' => 'text')); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Priority</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php $priority=$this->common->getPriorityList();?>
                                <?php echo $this->Form->input('priority', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $priority, 'class' => 'form-control col-md-4 col-xs-12')); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Position/Designation</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->Form->input('desgName', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $designation, 'class' => 'form-control col-md-4 col-xs-12')); ?>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group col-md-1 col-sm-6 col-xs-6">
                                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                                    <input type="submit" class="btn btn-success" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>