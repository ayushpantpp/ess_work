<script>
    window.setInterval(function () {
        $('#blinkText').toggle();
    }, 700);

    function getDataTypeForm(val) {
        window.location.replace("<?php echo $this->webroot ?>Boards/data_type_detail_list/"+val);
    }
    
    function ShowDet(val,datatype){ 
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/bm_show_details/' + val+'/'+datatype,
            //data:'project_id='+val,
            success: function (data) {
                $("#showdata").html(data);
                
            }
        });
        
    }

</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">

        </div>
        <h1>List of Data Type Details</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content ">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <select name="data_type_id" required="true" onchange="getDataTypeForm(this.value)" class="md-input data-md-selectize">
                                <?php
                                $list = "<option value=' '>-------Select Data Type For Detaitls-------</option>";
                                foreach ($DataType as $key => $rt) {
                                    $list .= "<option value='" . $key . "'>" . $rt . "</option>";
                                }
                                echo $list;
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3 " >
                        <div class="parsley-row " >
                            <span class="uk-float-center"> 
                                </span>
                        </div>
                    </div>


                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('data_type_details'); ?>">Enter Data Type Details</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    <h3 >
            <?php if($DataTypeName!=''){
                               echo $DataTypeName; 
                            }?>
                                </h3>
        <?php //echo $flash = $this->Session->flash();
//        echo "<pre>";
//        print_r($dtlist);
        if(!empty($DataDetailsList)){ 
            
            ?> 
       
        <div class="md-card" >
            <div class="md-card-content">
                <div class="clearfix"></div>
                <?php if(isset($dtlist)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">App Serial No.</th>
                                <th class="uk-text-center">ID No.</th>
                                <th class="uk-text-center">P. No.</th>
                                <th>Officer Name(full name)</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $p=1;
                           
                            for($i=0;$i<count($dtlist);$i++)
                      {
                                $ctr = (($this->params['paging']['BMDataTypeDetails']['page']*$this->params['paging']['BMDataTypeDetails']['limit'])-$this->params['paging']['BMDataTypeDetails']['limit'])+$p;
                                $fullName = $this->common->getTitle($dtlist[$i]['BMDataTypeDetails']['title'])." ".ucfirst($dtlist[$i]['BMDataTypeDetails']['firstname'])." ".ucfirst($dtlist[$i]['BMDataTypeDetails']['surname']);
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center"><?php echo $ctr; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $dtlist[$i]['BMDataTypeDetails']['serial_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $dtlist[$i]['BMDataTypeDetails']['id_no'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $dtlist[$i]['BMDataTypeDetails']['p_no'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $fullName;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php if($dtlist[$i]['BMDataTypeDetails']['gender']=='0'){ echo "Male"; }else{ echo "Female"; }?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($dtlist[$i]['BMDataTypeDetails']['dob']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><button class="md-btn" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet(<?php echo $dtlist[$i]['BMDataTypeDetails']['id']; ?>,<?php echo $dtlist[$i]['BMDataTypeDetails']['data_type_id']; ?>)">View</button></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/Boards/data_type_details_edit/' . $dtlist[$i]['BMDataTypeDetails']['id'].'/'.$dtlist[$i]['BMDataTypeDetails']['data_type_id']); ?>">Edit</a> | <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/Boards/data_type_details_edit/' . $dtlist[$i]['BMDataTypeDetails']['id'].'/'.$dtlist[$i]['BMDataTypeDetails']['data_type_id']."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                            </tr>
                            <?php  
                            $p++;
                            
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                    <div  class="uk-width-medium-1-1">           
                        <ul class="uk-pagination uk-pagination-right">
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                            </ul>
                    </div>
            <?php } ?>
            
            <?php }elseif($DataTypeName!=''){
            ?>
                <div class="md-card" >
            <div class="md-card-content">
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <h3>Sorry, No record found !!!</h3>
                </div>
            </div>   
        </div>
                <?php
        } ?>
                </div>   
        </div>
    </div>
</div>

<div class="uk-modal" id="modal_large">
    <div class="uk-modal-dialog uk-modal-dialog-large" >
        <button type="button" class="uk-modal-close uk-close"></button>
        <div id="showdata"></div>
    </div>
</div>