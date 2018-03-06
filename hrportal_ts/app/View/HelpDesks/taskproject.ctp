<div id="page_content">
    <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">
            <div class="heading_actions">
                <a title="Archive" data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                <a data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
               
            </div>
            <h1>Project Master</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Add Projects</a></span>
            </div>
    </div>
        <div id="page_content_inner">
            <?php echo $flash = $this->Session->flash(); ?> 
            <div class="md-card">
                 <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <i class="md-icon material-icons md-card-fullscreen-activate"></i>
                                <i class="md-icon material-icons"></i>
                                <div data-uk-dropdown="{pos:'bottom-right'}" class="md-card-dropdown">
                                </div>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                Add New Task Form
                            </h3>
                        </div>
                <div class="md-card-content large-padding">
                        <?php $check = array(1 => 'New', 2 => 'Existing'); ?>
                        <?php echo $this->form->create('task', array('url' => '', 'method' => 'post', 'action' => 'taskproject', 'enctype' => 'multipart/form-data', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked'))));
                        ?>
                         <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-1">
                               <div class="parsley-row">
                                 <h3 class="heading_a">Project Type:</h3> 
                                  <?php echo $this->form->input('hd', array('type' => 'hidden', 'id' => 'hd', 'value' => '0')); ?>
                                <input type="radio" name="proj" value="new" id="r1" checked="true">New</input>
                                <?php If ($sr != NULL) { ?>
                                    <input type="radio" name="proj" id="r1" value="existing">Existing</input>
                                <?php } ?>
                               </div>
                            </div>
                         </div>
                            <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-2">
                                        <div class="parsley-row">
                                            <label id ="pnameold_label" style='display:none'> Project Name:<span class="req">*</span></label>
                                            <?php echo $this->form->input('pnameold', array('label' => false, 'type' => 'select', 'style' => 'width:310px',
                                            'options' => $sr, 'class' => "", 'id' => 'pname_existing', 'style' => 'display:none'));
                                            ?>
                                            <label for="tname" id="tname_label">New Project Name: <span class="req">*</span></label>
                                            <input type="text" class="md-input" id="pname_new" name="pnamenew" maxlength="25" onkeyup="this.value=this.value.replace(/[^\w ]+$/g,'')" required>                            
                                        </div>
                                    </div>
                            </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <div class="parsley-row">
                                    <label for="mname">New Function Name: <span class="req">*</span></label>
                                            <input type="text" class="md-input" id="mname" name="mname" maxlength="25" onkeyup="this.value=this.value.replace(/[^\w ]+$/g,'')" required>                            
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                         <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <input type="submit" class="md-btn md-btn-success" id="b1" value="Add Project" onclick="return post1();"> 
                               
                            </div>
                        </div>
                        </div>  
                    </div> 
            </div>
                       
                <?php echo $this->form->end(); ?>
    
            <div class="md-card">
                <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <i class="md-icon material-icons md-card-fullscreen-activate"></i>
                                <i class="md-icon material-icons"></i>
                                <div data-uk-dropdown="{pos:'bottom-right'}" class="md-card-dropdown">
                                </div>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                Existing Projects Listing
                            </h3>
                        </div>
                
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table id="ts_issues" class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair hasFilters" role="grid" aria-describedby="ts_issues_pager_info"><colgroup class="tablesorter-colgroup"><col style="width: 4.6%;"><col style="width: 46.3%;"><col style="width: 12.3%;"><col style="width: 6.6%;"><col style="width: 7.2%;"><col style="width: 7.4%;"><col style="width: 6.1%;"></colgroup>
                            <thead>
                                <tr class="uk-text-center">
                                <th>S.No.</th>
                                <th>Project Name</th>
                                <th>Details</th>
                                <th>Action</th>
                                </tr>      
                     </thead>
                        <tbody aria-live="polite" aria-relevant="all">
                         <?php foreach ($ar as $k) {
                                        static $i = 0; ?> 
                                <tr>
                                    <td> <?php echo $i + 1; ?> </td>
                                    <td><?php echo $k['Tasksproject']['pname']; ?></td>
                                    <!-- <td><?php //echo $module[$i];  ?></td> -->
                                    <td><a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-success" 
                                           onclick="Get_Details('<?php echo $k['Tasksproject']['pid']; ?>')" class="view vtip" title="Click to View.">View Function</a></td>
                                    <td>
                                        <a href="#popup2" data-uk-modal="{ center:true }"
                                           onclick="Get_Details2('<?php echo $k['Tasksproject']['pid']; ?>')" class="view vtip" title="Click to Edit.">Edit Project</a> |
                                        <a href="projectdelete/<?php echo $k['Tasksproject']['pid']; ?>" class="btn btn-danger btn-xs" 
                                           class="view vtip" title="Click to delete.">Delete</a>
                                    </td>
                                </tr>
                            <?php $i++;
                        } ?>
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
<?php echo $this->form->end();?>
    <script type="text/javascript">
        $('.pnamenew').bind('keyup blur', function () {
            var node = $(this);
                    node.val(node.val().replace(/[^\w ]/$, '')); }
        );
    </script> 
    <script type="text/javascript">
        $('.mname').bind('keyup blur', function () {
            var node = $(this);
                    node.val(node.val().replace(/[^\w ]/$, '')); }
        );
    </script> 
<script type="text/javascript" >
    //    $(function(){
    //    $("#b1").click(function(){      
    //        alert($('input[name=proj]').val());
    //    });
    // });

        function post1()
        {

            var text = document.getElementById("pname_new").value;
            if (text.charAt(0) == " ") {

                alert("First Character never be blank space..");
                document.getElementById("pname_new").focus();
                return false;
            }
            var text1 = document.getElementById("mname").value;
            if (text1.charAt(0) == " ") {

                alert("First Character never be blank space..");
                document.getElementById("mname").focus();
                return false;
            }

            document.forms["task"].submit();

        }


    </script>
    <script>
        jQuery(document).ready(function () {
            $('#alerts').hide;
            $('input[name="proj"]').change(function () {
                $("#pname_new").hide();
                $("#tname_label").hide();
                $("#pname_existing").hide();
                $("#pname_" + $(this).val()).show();
                if ($(this).val() == 'new') {
                    $("#pname_new").attr('required', 'required');

                }
                else {
                    $("#pname_new").removeAttr('required');
                }


            });
        });
        function Get_Details(id)
        {   //alert(id);
            jQuery.ajax({
                url: '<?php echo $this->webroot ?>tasks/view1/' + id,
                success: function (data) {
                    //alert(data);
                    jQuery('.HRcontent').html(data);
                }
            });
        }

        function Get_Details2(pid)
        {   //alert(pid);
            jQuery.ajax({
                url: '<?php echo $this->webroot ?>tasks/projectedit/' + pid,
                success: function (data) {
                    //alert(data);
                    jQuery('.HRcontent2').html(data);
                }
            });
        }


    </script>

</div>

<div class="uk-modal" id="popup1">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="HRcontent"></div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>
<div class="uk-modal" id="popup2">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="HRcontent2"></div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>
            

</div>
        
