<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/approvedleaves/' + id,
            success: function (data) {
                //alert(data);
                jQuery('.HRcontent').html(data);
            }
        });
    }

</script>    
<style>
    #dialog textarea{background-color:#ffffff; border: none !important; margin-top: -30px; }

    span#ui-id-2{ background-color:#E0ECF8; font-size:14px; font-weight:bold; width: 100%; padding: 10px; float:left;}
    button.ui-button{ float:right; position: relative; background-color: #00a65a !important;
                      border-color: #008d4c!important; border-radius: 3px;
                      box-shadow: none;  color: #fff; -moz-user-select: none;
                      background-image: none;
                      border: 1px solid transparent;
                      border-radius: 4px;
                      cursor: pointer;
                      display: inline-block;
                      font-size: 14px;
                      font-weight: normal;
                      line-height: 1.42857;
                      margin-bottom: 0;
                      padding: 6px 12px;
                      text-align: center;
                      vertical-align: middle;
                      white-space: nowrap; margin-right: 10px;}

</style>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Pending Addresses</h3>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

		 <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Applied Date</th>
                                    <th>Action </th>
                                </tr>
                        </thead>
                        <tbody>

                      

                <?php  $auth=$this->Session->read('Auth'); ?>

                  <?php if(count($pendingAdress)==0) { ?>
                                <tr>
                                    <td style="text-align:center;" colspan="4" >
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
        <?php } ?>




           <?php $i=1;
    //pr($pending_leave_employee);
    //pr($this->params['paging']);
            foreach($pendingAdress as $pending_address)
             { ?>
                    <tr>
                        <td> <?php echo $i; ?></td>
                         <td>
                        <?php $empname =$this->Common->getempinfo($pending_address['EmpAddress']['emp_code']);
                        echo $empname ;?>
                                    </td>
                                    <td>
                        <?php echo date("d-m-Y",strtotime($pending_address['EmpAddress']['created_at']));?>
                                    </td>
                                    
                                    
                           <td>
                        <?php 
                        if($pending_address['EmpAddress']['status']=='4')
                        {         
                          echo $this->Common->findSatus(4);
                        }
                        
                        else if($pending_address['EmpAddress']['status']=='5')
                        {
                          echo $this->Common->findSatus(5);
                        }
                        
                        
                        else if($pending_address['EmpAddress']['status']==2){ 
                        ?>
                                        <ul class="edit-delete-icon">
                                            <li>
                                                <a href="<?php echo $this->webroot.'users/editAddress/'
                                                   .base64_encode($pending_address['EmpAddress']['id']);?>" Title="Process Leave">Approve/Reject</a>
                                            </li>
                                            <!-- <li style="border:none;">
                                                <a href="<?php echo $this->webroot.'users/editAddress/'
                                                   .base64_encode($pending_address['EmpAddress']['id'])
                                                   ?>" id="dialog_link" class="icon-thumbs-down" title="Reject" >

                                                </a>
                                            </li> -->
                                        </ul>
                        <?php } ?>

                                    </td>

                                </tr>
    <?php $i++ ;}  ?>

                            </tbody>

                            <div id="dialog" title="Remark/Comment" style="display:none">
                                <div>
                                    <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 600px; height:200px;" onKeypress="getcmtval()" > </textarea>
                                    <div class="ui-widget" id="errdis" style="display:none">
                                        <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                                <strong></strong> Please write rejection reason.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="wf_id" name="wf_id" value=''/>
                            <input type="hidden" id="leaveno" name="leave_no" value=""/>
                            <input type="hidden" id="ccode" name="comp_code" value=""/>
                            <input type="hidden" id="stdate" name="start_date" value=""/>
                            <input type="hidden" id="eddate" name="end_date" value=""/>
                            <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                        </table>
                    </div>
                </div>
                
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
<br/>
            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    $(function () {

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal: true,
            buttons: {
                "Ok": function () {
                    var cmnt = $('#cmnt').val();

                    if (cmnt == ' ')
                    {
                        $('#errdis').show('slow', function () {
                            // Animation complete.
                        });
                        return false;

                    } else {
                        $(this).dialog("close");
                        document.leave.submit();
                    }

                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });


    });

</script>
<script>

    function reject(wfid, compcode, vno, sdate, edate)
    {
        var wfid = document.getElementById("wf_id").value = wfid;
        var compcode = document.getElementById("ccode").value = compcode;
        var leaveno = document.getElementById("leaveno").value = vno;
        var stdate = document.getElementById("stdate").value = sdate;
        edate = document.getElementById("eddate").value = edate;
        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var leaveno = document.getElementById("cmnt").value;
        var rjres = document.getElementById("rejectres").value = leaveno;

    }


</script>
