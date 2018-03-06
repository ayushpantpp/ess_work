<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);
</script>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">
            
        </div>
        <h1>Manage Declaration Date</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                
                
                    <h3 class="heading_a uk-margin-small-bottom">List of Declaration Date
                        <span class="icheck-inline uk-float-right">
                        <a  class="md-btn md-btn-primary " href="<?php echo $this->Html->url('wealthdeclaration_date'); ?>">Enter Declaration Date</a>
                        </span>
                </h3>
                
                <div class="clearfix"></div>
                
                <?php if(isset($AllDeclarDate)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Date For Employee(From)</th>
                                <th class="uk-text-center">Date For Employee(To)</th>
                                <th class="uk-text-center">Date For Commission(From)</th>
                                <th class="uk-text-center">Date For Commission(To)</th>
                                <th class="uk-text-center">Days From Joining</th>
                                <th class="uk-text-center">Days From Exit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $p=1;
//                            echo "<pre>";
//                            print_r($AllDeclarDate);die;
                            for($i=0;$i<count($AllDeclarDate);$i++)
                      {
                                $ctr = (($this->params['paging']['CADeclarationDate']['page']*$this->params['paging']['CADeclarationDate']['limit'])-$this->params['paging']['CADeclarationDate']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $ctr; ?> </td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($AllDeclarDate[$i]['CADeclarationDate']['emp_from']));?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($AllDeclarDate[$i]['CADeclarationDate']['emp_to']));?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($AllDeclarDate[$i]['CADeclarationDate']['commission_from']));?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($AllDeclarDate[$i]['CADeclarationDate']['commission_to']));?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $AllDeclarDate[$i]['CADeclarationDate']['days_from_joining'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $AllDeclarDate[$i]['CADeclarationDate']['days_from_exit'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php if(strtotime(date("Y", strtotime($AllDeclarDate[$i]['CADeclarationDate']['emp_from']))) == strtotime(date('Y'))){?>
                                        <span class="uk-badge uk-badge-info">Activate</span>
                                        <?php }else{ ?>
                                        <span class="uk-badge uk-badge-warning">Inactive</span>
                                            <!--<a class="uk-badge uk-badge-warning" href="<?php echo $this->Html->url('/ComplianceAudit/wealthdeclaration_date_listing/' .base64_encode($AllDeclarDate[$i]['CADeclarationDate']['id'])); ?>" >Click to Active</a>
                                            |
                                            <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/wealthdeclaration_date_listing/' . base64_encode($AllDeclarDate[$i]['CADeclarationDate']['id'])."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                            -->
                                        <?php }?>
                                    </span>
                                </td>
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
