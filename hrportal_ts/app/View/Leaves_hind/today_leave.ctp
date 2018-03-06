<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        $('#alerts').hide;

    });
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/leavedetail/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }


</script> 

<?php $i = 0; ?>



<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave List</h3>


        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Employee Name</th>
                                <th>Leave Date</th>
                                <th>Status </th>
                               </tr>
                        </thead>
                        <tbody>
                            <?php
                            $auth = $this->Session->read('Auth');
                            $i = 1;
                            if (!empty($leavelist)) {
                                foreach ($leavelist as $list) { ?>
                                    <tr> 
                                        <td><?php echo $i; ?></td> 
                                        <td><?php echo $this->Common->getempname($list['LeaveDetail']['emp_code']); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($list['LeaveDetail']['leave_date'])); ?></td>
                                        <td><?php echo $this->Common->findSatus($list['LeaveDetail']['leave_status']); ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            else {
                                ?>

                                <tr>
                                    <td colspan="12">
                                        No records found
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 

                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="container" ></div>
        </div>




        <script type="text/javascript">
            $(function () {

                $('#container').highcharts({
                    chart: {
                        type: 'column',
                        margin: 75,
                        options3d: {
                            enabled: true,
                            alpha: 10,
                            beta: 25,
                            depth: 70
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    plotOptions: {
                        column: {
                            depth: 25
                        }
                    },
                    xAxis: {
                        categories: [<?php echo $employeeleave ?>]
                    },
                    yAxis: {
                        title: {
                            text: null
                        }
                    },
                    series: [{
                            name: 'Approved  Leaves',
                            data: [<?php echo $leavetype ?>]
                        }]
                });

            });
        </script>