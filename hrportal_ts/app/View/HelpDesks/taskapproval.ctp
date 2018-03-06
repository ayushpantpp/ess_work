<script>

function Get_Details(id)
{   //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/view2/'+id,
        success: function(data){
     // alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
}
function Get_Details10(id)
{  // alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/rejecttask1/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent10').html(data);
        }
    });
} 
 
 
</script>   

<script>
      
function status(tid,val) {
    //alert("--Task ID--"+tid);
    //alert("--value--"+val);
    $.ajax({
    type: "POST",
    url: '<?php echo $this->webroot ?>tasks/approved1/'+val+'/'+tid,
        
    //data:'project_id='+val,
    success: function(data){
                 //alert(data);
        $("#mname").html(data);
    }
    });
}
</script>
<div id="page_content">

    <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">

            <h1>Issue Tracker</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Project Name</a></span>
        </div></div>
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table id="ts_issues" class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair hasFilters" role="grid" aria-describedby="ts_issues_pager_info"><colgroup class="tablesorter-colgroup"><col style="width: 4.6%;"><col style="width: 46.3%;"><col style="width: 12.3%;"><col style="width: 6.6%;"><col style="width: 7.2%;"><col style="width: 7.4%;"><col style="width: 6.1%;"></colgroup>
                        <thead>
                            <tr class="headings">
                            <th scope="row">S.NO.</th>
                            <th class="column-title">Task Name</th>
                            <th class="column-title">Start Date</th>
                            <th class="column-title">End Date</th>
                            <th class="column-title">Submitted On</th>
                            <th class="column-title">Approved Status</th>
                            <th class="column-title">View Details</th>
                            </tr>
                        </thead>
                       <tbody>
                             <?php $j=1;?>
                              <?php if(isset($join)){
                                for($i=0;$i<count($join); $i++){  
                                     $tid= $join[$i]['TaskAssign']['tid'];
                                    
                              ?>
                           <tr>
                              <td><?php echo $j?></td>
                               
                               <td><?php echo $join[$i]['TaskAssign']['tname'];?></td>
                               <td><?php echo $join[$i]['TaskAssign']['starttime'];?></td>
                               <td><?php echo $join[$i]['TaskAssign']['endtime'];?></td>
                               <td><?php if($join[$i]['TaskAssign']['fsdate']==""){//echo "Not Submit";?><a class="uk-badge uk-badge-danger" title="Waiting for Submit">Not Submit</a>  <?php
                               } else {echo $join[$i]['TaskAssign']['fsdate'];}?></td>
                               <!-- <td><?php // if($join[$i]['TaskAssign']['fsdate']==""){echo "Not Submit";}else {echo $join[$i]['TaskAssign']['fsdate'];}?></td> -->
                               <td> <?php if($join[$i]['TaskAssign']['fstatus']==6){ ?>
                               <?php //echo $this->form->input('astatus', array('label'=>false, 'type' => 'select', 'style'=>'width:125px',
//                                       'options' => array('none' => 'Select Status','0' => 'Rejected','7' => 'Approved'),'class' => "form-control col-md-7 col-xs-12",
//                                       'required'=>true,'id'=>'astatus', 'onChange'=> 'status(" '.$tid.' ",this.value);' ));
                                      // } ?>
                                <a href="approved1/<?php echo $join[$i]['TaskAssign']['tid']; ?>"  class="uk-badge uk-badge-success" 
                                title="Click to Approve">Approve</a> | <a href="#popup10" data-uk-modal="{ center:true }" 
                                 class="uk-badge uk-badge-danger" onclick="Get_Details10('<?php echo $join[$i]['TaskAssign']['tid']; ?>')" title="Click to Reject">Reject</a>
                                      
                               <?php } elseif($join[$i]['TaskAssign']['fstatus']==7){ ?>
                                   
                                      <?php //echo $this->form->input('astatus', array('label'=>false, 'type' => 'select', 'style'=>'width:125px',
//                                       'options' => array('7' => 'Approved','0' => 'Rejected'),'class' => "form-control col-md-7 col-xs-12",
//                                       'required'=>true,'id'=>'astatus', 'onChange'=> 'status(" '.$tid.' ",this.value);' ));?>
                                      
                                           <a href=""  class="uk-badge uk-badge-primary" title="Click to Approved" disabled='disabled'>Approved Successfully</a>  
                                      
                                    <?php   }
                                       


                                        else{ ?>
                                             <a  class="uk-badge uk-badge-success" title="Pending">Work in Progress</a>  
                                            
                                               
                                             <?php  
                                             //echo "Work in Progress";
                                        }  
                                 ?>
                               </td>
                               
                               <td><a href="#popup1" data-uk-modal="{ center:true }"  class="uk-badge uk-badge-primary"
                                      onclick="Get_Details('<?php echo $join[$i]['TaskAssign']['tid']; ?>')" class="view vtip" title="Click to View.">View</a></td>
                              <?php $j++;?>
                           </tr>
                              <?php  }}?>
                      </tbody>
                </table> 
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
                </div>
                <div>
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
        <div class="uk-modal" id="popup1">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div class="HRcontent"> 
                    <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
                </div> 
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
        </div>
        <div class="uk-modal" id="popup10">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark: </h3></p> </div>
                <div class="HRcontent10"> 
                    <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
                </div> 
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

 