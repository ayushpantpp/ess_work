<script>
    window.setInterval(function () {
        $('#blinkText').toggle();
    }, 700);

    function getDataTypeForm(val) {
        window.location.replace("<?php echo $this->webroot ?>ComplianceAudit/quant_qual_list/" + val);
    }

    function ShowDet(val, datatype) {
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>ComplianceAudit/qual_quan_show_details/' + val + '/' + datatype,
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
        <h1>List of Quantitative Data Type & Qualitative Data Type</h1>
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
                                $DataType = array('1' => 'Quntitative data type', '2' => 'Qualitative data type');
                                $list = "<option value=' '>---Select Listing---</option>";
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
                            <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('quant_qual_save'); ?>">Enter Quantitative & Qualitative</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <h3 >
            <?php
            if ($Typeid == '1') {
                echo "Quantitative Data Type";
            } elseif ($Typeid == '2') {
                echo "Qualitative Data Type";
            }
            ?>
        </h3>
        <?php
        //echo $flash = $this->Session->flash();
//        echo "<pre>";
//        print_r($allRecord);
        if (!empty($allRecord)) {
            ?> 

            <div class="md-card" >
                <div class="md-card-content">
                    <div class="clearfix"></div>
    <?php if (isset($allRecord)) { ?>
                        <div class="uk-overflow-container uk-margin-bottom" >
                            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                                <thead>
                                    <tr>
                                        <th class="uk-text-center">S.No.</th>
                                        <th class="uk-text-center">MDA</th>
                                        <th class="uk-text-center">Thematic Area</th>
                                        <th class="uk-text-center">Details</th>
                                        <th class="uk-text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $p = 1;

                                    for ($i = 0; $i < count($allRecord); $i++) {
                                        $ctr = (($this->params['paging']['CAQuantitativeQualitative']['page'] * $this->params['paging']['CAQuantitativeQualitative']['limit']) - $this->params['paging']['CAQuantitativeQualitative']['limit']) + $p;
                                        ?>
                                        <tr>
                                            <td class="uk-text-small uk-text-center"><?php echo $ctr; ?> </td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $allRecord[$i]['Ministry']['ministry_name']; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $allRecord[$i]['CASetType']['set_name']; ?></span></td>
                                            <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><button class="md-btn" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet(<?php echo $allRecord[$i]['CAQuantitativeQualitative']['id']; ?>,<?php echo $allRecord[$i]['CAQuantitativeQualitative']['type']; ?>)">View</button></span></td>
                                            <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/ComplianceAudit/quant_qual_edit/' . $allRecord[$i]['CAQuantitativeQualitative']['id'] . '/' . $allRecord[$i]['CAQuantitativeQualitative']['type']); ?>">Edit</a> | <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/quant_qual_edit/' . $allRecord[$i]['CAQuantitativeQualitative']['id'] . '/' . $allRecord[$i]['CAQuantitativeQualitative']['type'] . "/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                                        </tr>
            <?php
            $p++;
        }
        ?>
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

                <?php } elseif ($DataTypeName != '') {
                    ?>
                    <div class="md-card" >
                        <div class="md-card-content">
                            <div class="clearfix"></div>
                            <div class="uk-overflow-container uk-margin-bottom" >
                                <h3>Sorry, No record found !!!</h3>
                            </div>
                        </div>   
                    </div>
    <?php }
?>
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