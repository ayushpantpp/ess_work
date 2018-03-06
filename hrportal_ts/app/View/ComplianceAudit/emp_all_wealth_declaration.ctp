<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);
</script>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">
            
        </div>
        <h1>Employee Wealth Declaration</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                
                
                    <h3 class="heading_a uk-margin-small-bottom">List of Employee Wealth Declaration
                <?php /* if(!empty($EmployeeDefinition)){ ?>
                     <span class="icheck-inline uk-float-right">
                     <?php if($FormAccessRight == '1'){?>
                         <a  class="md-btn md-btn-primary"  href="<?php echo $this->Html->url('emp_wealthdeclaration/'.base64_encode($EmployeeDefinition[0]['CAEmployeeDefinition']['id'])); ?>">Go For Wealth Declaration</a>
                     <?php }?>
                     <a  class="md-btn md-btn-primary " href="<?php echo $this->Html->url('emp_dependent_detail_save/'.base64_encode($EmployeeDefinition[0]['CAEmployeeDefinition']['id'])); ?>">Enter Dependent Details</a>
                    </span>
                <?php }else{ ?>
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('emp_definition_save'); ?>">Enter Employee Details</a>
                <?php } */?>
                </h3>
                
                <div class="clearfix"></div>
                
                <?php if(isset($EmployeeDefinition)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Type Of Organisation </th>
                                <th class="uk-text-center">Organisation</th>
                                <th class="uk-text-center">KRA PIN</th>
                                <th class="uk-text-center">ID Number</th>
                                <th class="uk-text-center">Date of Birth</th>
                                <th class="uk-text-center">Place of Birth</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $p=1;
//                            echo "<pre>";
//                            print_r($EmployeeDefinition);
//                            die;
                            for($i=0;$i<count($EmployeeDefinition);$i++)
                      {
                                $ctr = (($this->params['paging']['CAEmployeeDefinition']['page']*$this->params['paging']['CAEmployeeDefinition']['limit'])-$this->params['paging']['CAEmployeeDefinition']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $p; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php  if($EmployeeDefinition[$i]['CAEmployeeDefinition']['type_of_organisation'] == '1'){
                                        echo "MDA";
                                    }elseif($EmployeeDefinition[$i]['CAEmployeeDefinition']['type_of_organisation'] == '2'){
                                        echo "Commission";
                                    }elseif($EmployeeDefinition[$i]['CAEmployeeDefinition']['type_of_organisation'] == '3'){
                                        echo "Independent office";
                                    }
                                    ?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $EmployeeDefinition[$i]['CAEmployeeDefinition']['organisation_name'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $EmployeeDefinition[$i]['CAEmployeeDefinition']['kra_pin'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $EmployeeDefinition[$i]['CAEmployeeDefinition']['id_number'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($EmployeeDefinition[$i]['CAEmployeeDefinition']['dob']));?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $EmployeeDefinition[$i]['CAEmployeeDefinition']['place_of_birth'];?></span></td>
                                <?php 
                                $search = '2';
                                $wd = $EmployeeDefinition[$i]['CAWealthdeclaration'];
                                $key = array_search($search, array_column($wd, 'declaration_type'));
                                $BenialDetect = $wd[$key]['declaration_type'];
                                
                                if($FormAccessRight == '1' && $BenialDetect=='2'){?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <!--<a class="uk-badge uk-badge-success" href="<?php //echo $this->Html->url('/ComplianceAudit/emp_definition_edit/' . base64_encode($EmployeeDefinition[$i]['CAEmployeeDefinition']['id'])); ?>">Edit</a> 
                                        |-->
                                        <a class="uk-badge uk-badge-info" href="<?php echo $this->Html->url('/ComplianceAudit/comment_emp_wealthdeclaration/' .base64_encode($EmployeeDefinition[$i]['CAEmployeeDefinition']['id'])); ?>" >Wealth Declaration</a>
                                        <!--| <a class="uk-badge uk-badge-danger" href="<?php //echo $this->Html->url('/ComplianceAudit/emp_definition_edit/' . base64_encode($EmployeeDefinition[$i]['CAEmployeeDefinition']['id'])."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a>-->
                                    </span></td>
                                <?php }else{
                                   ?>
                                       <td><span class="uk-badge uk-badge-info">
                                        NA
                                    </span></td>
                                       <?php
                                } ?>
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
            </div>
        </div>
        <?php if(!empty($DependentDetails)){ ?>
        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">Dependent Details
                <div class="clearfix"></div>
                
                <?php if(isset($DependentDetails)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Dependent Type </th>
                                <th class="uk-text-center">First Name</th>
                                <th class="uk-text-center">Surname</th>
                                <th class="uk-text-center">Date of Birth</th>
                                <th class="uk-text-center">Status</th>
                                <th class="uk-text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $p=1;
//                            echo "<pre>";
//                            print_r($DependentDetails);
                            for($i=0;$i<count($DependentDetails);$i++)
                      {
                                $ctr = (($this->params['paging']['CADependentDetails']['page']*$this->params['paging']['CADependentDetails']['limit'])-$this->params['paging']['CADependentDetails']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $ctr; ?> </td>
                               <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php  if($DependentDetails[$i]['CADependentDetails']['dependent_type'] == '1'){
                                        echo "Spouse";
                                    }elseif($DependentDetails[$i]['CADependentDetails']['dependent_type'] == '2'){
                                        echo "Children";
                                    }
                                    ?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $DependentDetails[$i]['CADependentDetails']['fname'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $DependentDetails[$i]['CADependentDetails']['surname'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($DependentDetails[$i]['CADependentDetails']['dob']));?></span></td>
                                 <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php  if($DependentDetails[$i]['CADependentDetails']['depend_status'] == '1'){
                                        echo "Active";
                                    }elseif($DependentDetails[$i]['CADependentDetails']['depend_status'] == '2'){
                                        echo "Inactive";
                                    }
                                    ?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/ComplianceAudit/emp_dependent_detail_edit/' . base64_encode($DependentDetails[$i]['CADependentDetails']['id'])); ?>">Edit</a> 
                                        <!--| <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/emp_dependent_detail_edit/' .$DependentDetails[$i]['CADependentDetails']['id']."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a> -->
                                    </span></td>
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
            </div>
        </div>
        <?php } ?>
   </div>
</div>
