    
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Upload Data</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php  echo $this->Form->create('Uploadcoordinates',array('url' =>array('controller' => 'Uploadcoordinates', 'action' =>'add'),'type'=>'file','enctype'=>'multipart/form-data','method'=>'post','class' => 'uk-form-stacked')));
                 
                
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Upload <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('file', array('label'=>false, 'type' => 'file', 'class' => "md-input",'required'=>true,'id'=>'first_name'));
                               
                               echo $this->form->input('Mda_code', array('label'=>false, 'type' => 'hidden', 'value' =>$auth['MyProfile']['comp_code'],'class' => "md-input",'readonly'=>true,'required'=>true,'id'=>''));
                               ?>
                        </div>
                    </div>
                   



                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-2uk-margin-top">                            
                        <button type="submit" name="upload" id="add" class="md-btn md-btn-danger" >Upload</button>

                    </div>
                    
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Users/dashboard') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>


                <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                    <div class="uk-width-large-1-1">
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table class="uk-table uk-table-striped uk-text-nowrap">



                                <thead>
                                    <tr class="headings">

                                        <th class="column-title">SR.No</th>
                                        <th class="column-title">KRA ID</th>
                                        <th class="column-title">Personal Number</th>
                                        <th class="column-title">MDA </th>
                                        <th class="column-title">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>



<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> 
            <div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>
        </div>    
    </div>
</div>

<!-- <script type="text/javascript">
     jQuery("#add").click(function () {

        doChk();
    });

    jQuery("form[name='msgForm']").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            doChk();
            return false;
        } else {

        }
    });

function doChk() {
        var err = 0;
        
        
         if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>MdaManagement/add/', fdata, function (data) {
                if (data) {
                    //alert("vivek");alert(data.msg);alert(data.type);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                      
                        return false;
                    }
                }
            }, 'json').error(function (e) {
                alert("Error : " + e.statusText);
                jQuery("#overlay").hide();
            });

        } else {
            return false;
        }
    
    }
</script>
 -->