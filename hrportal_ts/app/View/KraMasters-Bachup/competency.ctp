<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>

<?php
echo $this->Form->create('Kra', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'KraMasters', 'action' => 'competency'), 'id' => 'kra', 'name' => 'kra'));
?>

<div role="main" class="right_col">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Competency Name</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div></div>
                    <div class="x_content"> <br />
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Competency Name :</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('kraName', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value'=>$kralist['KraMasters']['kra_name'], 'maxlength'=>'100')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12" id="Park-Button">
                            <?php echo $this->Form->input('id', array('class'=>'form-control col-md-7 col-xs-12','type' => 'hidden','value'=>$kralist['KraMasters']['id'], 'maxlength'=>'100')); ?>
                            <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                        </div>
                  <?php $this->Form->end(); ?>

                    </div>
                </div>
            </div>
        </div>