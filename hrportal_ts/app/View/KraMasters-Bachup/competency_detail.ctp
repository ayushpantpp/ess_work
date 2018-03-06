<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>

<?php
echo $this->Form->create('Kpi', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'KraMasters', 'action' => 'competencyDetail'), 'id' => 'kpi', 'name' => 'kpi'));
?>

<div role="main" class="right_col">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Competency Detail</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div></div>
                    <div class="x_content"> <br />
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Competency Detail :</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('kpiName', array('class'=>'form-control col-md-7 col-xs-12','type' => 'textarea','value'=>$kpiList['KpiMasters']['kpi_name'])); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Priority :</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('priority', array('class'=>'form-control col-md-7 col-xs-12','type' => 'select','value'=>$kpiList['KpiMasters']['priority'],'options'=>$this->common->getPriorityList(), 'maxlength'=>'100')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12" id="Park-Button">
                            <?php echo $this->Form->input('id', array('class'=>'form-control col-md-7 col-xs-12','type' => 'hidden','value'=>$kpiList['KpiMasters']['id'], 'maxlength'=>'100')); ?>
                            <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                        </div>
                  <?php $this->Form->end(); ?>

                    </div>
                </div>
            </div>
        </div>