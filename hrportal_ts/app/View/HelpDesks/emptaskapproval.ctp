<script>

    function Get_Details(id)
    {   //alert(id);
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/view2/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#popup1val').html(data);
            }
        });
    }

    function Get_Details9(id)
    {   //alert(id);
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/showreject/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#popup9val').html(data);
            }
        });
    }

</script>      
<div id="page_content">

    <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">
          
            <h1>Issue Tracker</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Project Name</a></span>
        </div></div>
        <?php echo $flash = $this->Session->flash();?>
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table id="ts_issues" class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair hasFilters" role="grid" aria-describedby="ts_issues_pager_info"><colgroup class="tablesorter-colgroup"><col style="width: 4.6%;"><col style="width: 46.3%;"><col style="width: 12.3%;"><col style="width: 6.6%;"><col style="width: 7.2%;"><col style="width: 7.4%;"><col style="width: 6.1%;"></colgroup>
                        <thead>
                            <tr class="headings">
                                <th scope="row">S.No.</th>
                                <!--<th class="column-title">Task ID</th>-->
                                <th class="column-title">Task Name</th>
                                <th class="column-title">Start Date</th>
                                <th class="column-title">End Date</th>
                                <th class="column-title">Submitted On</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">View Details</th>

                            </tr>
                        </thead>
                        <tbody><?php $j = 1; ?> <?php
                            if (isset($join)) {
                                for ($i = 0; $i < count($join); $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $j; ?></td>
                                        <!--<td><?php //echo $join[$i]['TaskAssign']['tid'];  ?></td>-->
                                        <td><?php echo $join[$i]['TaskAssign']['tname']; ?></td>
                                        <td><?php echo $join[$i]['TaskAssign']['starttime']; ?></td>
                                        <td><?php echo $join[$i]['TaskAssign']['endtime']; ?></td>

                                        <td><?php if ($join[$i]['TaskAssign']['sdate'] == "") {//echo "Not Submit";  ?>
                                                <a class="uk-badge uk-badge-danger" title="Waiting for submit">Not Submit</a> 
                                            <?php
                                            } else {
                                                echo $join[$i]['TaskAssign']['sdate'];
                                            }
                                            ?></td>
                                        <td><?php
                                            if ($join[$i]['Assigned']['cstatus'] == 7) {
                                                ?> <a class="uk-badge uk-badge-danger" title="Click to Approved">Approved Successfully</a> 
                                                <?php
                                            } elseif ($join[$i]['Assigned']['cstatus'] == 0 AND $join[$i]['TaskAssign']['comment'] != NULL AND $join[$i]['TaskAssign']['comment'] != 'Read It') {
                                                ?>
                                                <a href="#popup9" onclick="Get_Details9('<?php echo $join[$i]['TaskAssign']['tid']; ?>')" class="uk-badge uk-badge-danger" title="Click to Show">Show Rejection </a>
                                            <?php } elseif ($join[$i]['Assigned']['cstatus'] == 6) {
                                                ?>
                                                <a class="uk-badge uk-badge-danger" title="Waiting to Approved">Waiting for Approval</a>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="uk-badge uk-badge-danger" title="Waiting for Approved">Pending</div>

        <?php } ?>   </td>

                                        <td><a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-primary"
                                               onclick="Get_Details('<?php echo $join[$i]['TaskAssign']['tid']; ?>')" class="view vtip" title="Click to View.">View</a></td>
                                    <?php $j++; ?>       
                                    </tr>
    <?php }
}
?>
                        </tbody>
                    </table>

                    <div class="navigation navigation-left" >
                        <?php echo $this->Paginator->counter(); ?> Pages
<?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group col-md-12 col-sm-6 col-xs-6">
                        <div class="col-md-8 col-sm-8 col-xs-12">
    <!--                        <input type="button" class="btn btn-success" value="Save As Draft" >  -->
    <!--                        <input type="submit" class="btn btn-success" value="Send" name='b1' id="b1" onclick= " return post1();" />-->
                            <input type="hidden" id="h1" name="h1"/>
                            <input type="hidden" id="h2" name="h2"/>
                            <input type="hidden" id="h3" name="h3"/>
                        </div>
                    </div>
<?php echo $this->form->end(); ?>
                    </table>
                </div>
                <ul class="uk-pagination ts_pager tablesorter-pager">
                    <li title="Select Page" data-uk-tooltip="">
                        <select class="ts_gotoPage ts_selectize selectized" aria-disabled="false" tabindex="-1" style="display: none;"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select><div class="selectize-control ts_gotoPage ts_selectize single"><div class="selectize-input items full has-options has-items"><div class="item" data-value="1">1</div><input type="text" autocomplete="off" tabindex="" style="width: 4px;"></div><div class="selectize-dropdown single ts_gotoPage ts_selectize" style="display: none;"><div class="selectize-dropdown-content"></div></div></div><div class="selectize_fix"></div>
                    </li>
                    <li class="first disabled" tabindex="0" aria-disabled="true"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
                    <li class="prev disabled" tabindex="0" aria-disabled="true"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
                    <li><span class="pagedisplay" id="ts_issues_pager_info">1 - 10 / 48 (48)</span></li>
                    <li class="next" tabindex="0" aria-disabled="false"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
                    <li class="last" tabindex="0" aria-disabled="false"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
                    <li title="Page Size" data-uk-tooltip="">
                        <select class="pagesize ts_selectize selectized" aria-disabled="false" tabindex="-1" style="display: none;"><option selected="selected" value="10">10</option></select><div class="selectize-control pagesize ts_selectize single"><div class="selectize-input items full has-options has-items"><div class="item" data-value="10">10</div><input type="text" autocomplete="off" tabindex="" style="width: 4px;"></div><div class="selectize-dropdown single pagesize ts_selectize" style="display: none;"><div class="selectize-dropdown-content"></div></div></div><div class="selectize_fix"></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="uk-modal" id="popup1">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div id="popup1val"> </div>
                <div class="uk-modal-footer uk-text-right" >
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
            <div class="uk-modal" id="popup9">
                <div class="uk-modal-dialog">
                    <div><p><h3> Task Remark:    </h3></p> </div>
                    <div  id="popup9val"> </div>
                    <div class="uk-modal-footer uk-text-right">
                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
