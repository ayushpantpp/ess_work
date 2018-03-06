
<script>
    window.setInterval(function () {
        $('#blinkText').toggle();
    }, 700);

    function getDataTypeForm(dateval) {
        window.location.replace("<?php echo $this->webroot ?>holidays/holidaylisting/"+dateval);
    }
    

    function getDatalocation(loc)
    {
        window.location.replace("<?php echo $this->webroot ?>holidays/locationlisting/"+loc);
    }
     /* function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>holidays/holidaylisting/"+val; 

 }*/


</script>
<div id="page_content">
    

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
        
            <div class="md-card-content ">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <select name="data_type_id" required="true" onchange="getDataTypeForm(this.value)" class="md-input data-md-selectize">
                                <?php
                                $DateType = array('2019'=>'2019','2018'=>'2018','2017'=>'2017','2016'=>'2016');
                                //$list = "<option value=''>----Year Wise Holiday List----</option>";
                                $list = "";
                                $selectedDate = date('Y');
                                foreach ($DateType as $key => $rt) {
                                    if($selectedDate == $key){
                                        $list .= "<option value='".$key."' selected='selected'>".$rt."</option>";
                                    }else{
                                    $list .= "<option value='".$key."'>".$rt."</option>";
                                    }
                                }
                                echo $list;
                                ?>
                            </select>


                        </div>

                    </div>
                    <div class="uk-width-medium-1-3 " >
                        <div class="parsley-row " >
                            <span class="uk-float-center"> 
                                 <select name="data_type_id" required="true" onchange="getDatalocation(this.value)" class="md-input data-md-selectize">
                                <?php
                                $Datalocation = $this->Common->findholidayLocationName();
                               // $list = "<option value=''>----Year Wise Holiday List----</option>";
                                $list = "";
                                $selectedDate = $location_idsel;
                                 $list.= "<option value=''>----Select Location-------</option>";
                                   $list.= "<option value='0'>ALL</option>";
                                foreach ($Datalocation as $key => $rt) {
                                    if($selectedDate == $key){
                                        $list .= "<option value='".$key."' selected='selected'>".$rt."</option>";
                                    }else{
                                    $list .= "<option value='".$key."'>".$rt."</option>";
                                    }
                                }
                                echo $list;
                                ?>
                            </select>
                                </span>
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
        if(!empty($holidaylist)){ 
            
            ?> 
       
        <div class="md-card" >
        
        <div class="md-card-toolbar">
                             <div class="md-card-toolbar-actions">
                               
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               <b>List of Holidays</b>
                            </h3>
                        </div>            <div class="md-card-content">
                <div class="clearfix"></div>
                <?php if(isset($holidaylist)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Holiday Name</th>
                                <!-- <th class="uk-text-center">Location</th> -->
                                <th class="uk-text-center">Date of Holiday</th>
                                <th class="uk-text-center">Optional</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
//                            echo $holidaylist[0]['Holiday']['location_id'];
//                            echo "<pre>";
//                            print_r($holidaylist);
                            
                            $p=1;
                           
                            for($i=0;$i<count($holidaylist);$i++)

                      {

                                $ctr = (($this->params['paging']['Holiday']['page']*$this->params['paging']['Holiday']['limit'])-$this->params['paging']['Holiday']['limit'])+$p;
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-muted uk-text-center"><?php echo $ctr; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $holidaylist[$i]['Holiday']['holiday_name'];?></span></td>
                               <!--  <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                    <?php 
                          
                    $holidayName = $this->Common->findLocationNameByCode($holidaylist[$i]['Holiday']['location_id']);
                    
                    if($holidayName != '0'){
                        echo $holidayName;
                    }else{
                        echo "All";
                    }
                    ?></span></td> -->
                                <td class="uk-text-small uk-text-muted uk-text-center"><?php echo date("d/m/Y", strtotime($holidaylist[$i]['Holiday']['holiday_date']));?></td>
                                <td class="uk-text-small uk-text-muted uk-text-center"><?php if($holidaylist[$i]['Holiday']['op_leave']=='0'){ echo "NO"; }else{ echo "YES"; }?></td>
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
            
            <?php }elseif(empty($holidaylist)){
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
