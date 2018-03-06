<script>
    window.setInterval(function () {
        $('#blinkText').toggle();
    }, 700);

    function getDataTypeForm(val) {
        window.location.replace("<?php echo $this->webroot ?>ComplianceAudit/monitor_entry/" + val);
    }

    function ShowDet(val) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>ComplianceAudit/monitor_entry/' + val,
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
        <h1>Monitoring and Evaluation Entry</h1>
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
                                $list = "<option value=' '>---Select Listing---</option>";
                                foreach ($audit_param as $key => $rt) {
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
                            <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('monitor_entry_save'); ?>">Monitoring Entry</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <h3 ><?php  echo ucfirst($paramName); ?></h3>
        <?php
        //echo $flash = $this->Session->flash();

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
                                        <th class="uk-text-nowrap">S.No.</th>
                                        <th class="uk-text-nowrap">MDA</th>
                                        <th class="uk-text-nowrap">Monitoring Parameter</th>
                                        <th class="uk-text-nowrap">Entry Date</th>
                                        <?php
                                        foreach ($labels as $key => $val) {
                                            ?>
                                            <th class="uk-text-nowrap"><?php echo ucfirst($val); ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $p = 1;
//                                        echo "<pre>";
//                                        print_r($allRecord);
                                    foreach ($allRecord as $k => $v) {
                                        ?>
                                        <tr>
                                            <td class="uk-text-small uk-text-center"><?php echo $p; ?> </td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getMinistryByID($v[$model__Name]['ministry_id']); ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getAuditMonitoringParamByID($v[$model__Name]['audit_parameter']); ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d-m-Y",  strtotime($v[$model__Name]['entry_date'])); ?></span></td>
                                            <?php foreach ($labels as $kk => $vv) {
                                                 $lvl = str_replace(" ", "_", strtolower($labels[$kk]));
                                                ?>
                                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $v[$model__Name][$lvl]; ?></span></td>
                                            <?php } ?>
                                        </tr>  
                                        <?php
                                        $p++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>

                <?php } else{
                    ?>
                    <div class="md-card" >
                        <div class="md-card-content">
                            <div class="clearfix"></div>
                            <div class="uk-overflow-container uk-margin-bottom" >
                                <h3>Sorry, No record found !!!</h3>
                            </div>
                        </div>   
                    </div>
                <?php } ?>
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