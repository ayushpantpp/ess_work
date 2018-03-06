<!-- page content -->
<script>
    function getmodule(val) {
            $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>tasks/module/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#mname").html(data);
            }
        });
    }
</script>
<script type="text/javascript">
    $('#fname').bind('keyup blur', function () {alert('alert');
        var node = $(this);
                node.val(node.val().replace(/[^\w ]/$, '')); }
    );
</script> 
<script type="text/javascript">
    $('.remark').bind('keyup blur', function () {
        var node = $(this);
                node.val(node.val().replace(/[^\w ]/$, '')); }
    );
</script> 

<script type="text/javascript" >

    function post1()
    {
        // alert ("in fuction");
//       if(document.getElementById("tname").value=='')
//       {
//          document.getElementById("tname").focus();
//          return false;
//       }
        var text = document.getElementById("fname").value;
        if (text.charAt(0) == " ") {

            alert("First Character never be blank space..");
            document.getElementById("fname").focus();
            return false;
        }
        if (document.getElementById("startdate").value == '')
        {
            document.getElementById("startdate").focus();
            return false;
        }
        if (document.getElementById("enddate").value == '')
        {
            document.getElementById("enddate").focus();
            return false;
        }


        document.forms["doc"].submit();

    }

    function post2()
    {
        alert("post2");
        document.forms.action = "tasks/cancel";
        document.forms["task"].submit();
    }
</script>
<script>
    function fieldsDisable(){
        var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>documents/fields/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#newfield").html(data);
            }
        });
    }
    function dateDiff(startDate, endDate) {
        var difdate = 0;
        //alert(startDate);
        //var difdate1 = 0;
        if (jQuery("#startdate").val() == '' && jQuery("#enddate").val() == '') {
            alert('Please select start date and end date');
            //jQuery('#total_leave').val('');
            return false;
        }
        //if (endDate && startDate) //make sure we don't call .getTime() on a null
        //difdate = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);

        difdate = (endDate.getTime() - startDate.getTime());
        //if (jQuery('#enddate').val() != ""){
        //difdate1 = difdate + 1;
        //}


        if (difdate < 0) {

            $("#alerts").html('Total Days cannot be less than 0').show().delay(5000).fadeOut('slow');
            //alert('Total Days cannot be less than 0');
            //jQuery('#total_leave').val('');
            jQuery('#enddate').val('');
            return false;
        }
//        else {
//            //jQuery('').val(difdate1);
// 
//        }

        //substract leaves on the basis of holidays

    }

</script>
<script>
    $('#startdate').kendoDatePicker({
        start: "year",
        depth: "year",
        format: "MMMM yyyy"
    });
    $('#kUI_multiselect_basic').kendoMultiSelect();
</script>
<div id="page_content">
    <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">
            <div class="heading_actions">
                <a title="Archive" data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                <a data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                
            </div>
            <h1>Advance Search</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Find files</a></span>
        </div></div>
    
    <div id="page_content_inner">
       <div class="md-card">            
            <div class="md-card-content large-padding">
                <?php echo $flash = $this->Session->flash(); ?> 
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'documents', 'action' =>'createFolder'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); ?>
                <h3 class="heading_a">Create New File & Folder</h3>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="folder">Folder <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('folder', array('type' => "select",'required'=>true,'empty' => ' -- Select Folder --', 'options' => $Folderlist, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="folder">Type <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('type', array('label'=>false, 'type' => 'select', 'value' => '',
                    'options' => array('' => 'Select Type', '0' => 'Folder','1' => 'File'),
                    'class' => "data-md-selectize",'required'=>true,'id'=>'type','onChange'=>'fieldsDisable(this.value);')); ?>
                        </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark">Remark </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input",'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'onkeyblur'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="newfield"></div>
                </div> 
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                       
                    </div>
                </div>
                
                <?php echo $this->Form->end();?>
            </div>
            <div class="md-card">
                        <div class="md-card-content">
                            <h3 class="heading_a uk-margin-small-bottom">Folder Structure</h3>
                            <div id="tree_a">
                                <?php
                                 $rootin=$this->webroot."documents/currentfolder/";
                                 $link=$this->Html->url('currentfolder');
                            function convertToMenu($arr, $elmkey) { 
                                    echo "<ul >";
                                    foreach ($arr as $val) {
                                        
                                        //echo $url=$this->Url->build(["controller" => "Posts","action" => "view","$val[$elmkey]['id']"]);

                                            if (!empty($val['children'])) {
                                                    echo "<li class='isFolder'>" . $val[$elmkey]['name'];
                                                    echo "<a href='currentfolder/".$val[$elmkey]['id']."'>".convertToMenu($val['children'], $elmkey)."</a>";
                                                    echo "</li>";
                                            } else {
                                                    if($val[$elmkey]['file']==''){
                                                        echo "<li><h4>" . $val[$elmkey]['name'] . "</h4></li>";
                                                    }elseif($val[$elmkey]['name']==''){
                                                        echo "<li><h4>" . $val[$elmkey]['file'] . "</h4></li>";
                                                    }
                                                    
                                            }
                                    }
                                    echo "</ul>";
                                }
                            $Folderlist=convertToMenu($categories, 'Category');
                            ?>
                            </div>
                        </div>
                    </div>
        </div>



    </div>
</div>
