<style>
#tags{
  float:left;
  border:1px solid #ccc;
  padding:4px;
  font-family:Arial;
}
#tags span.tag{
  cursor:pointer;
  display:block;
  float:left;
  color:#555;
  background:#add;
  padding:5px 10px;
  padding-right:30px;
  margin:4px;
}
#tags span.tag:hover{
  opacity:0.7;
}
#tags span.tag:after{
 position:absolute;
 content:"×";
 border:1px solid;
 border-radius:10px;
 padding:0 4px;
 margin:3px 0 10px 7px;
 font-size:10px;
}
#tags textarea{
  background:#eee;
  border:0;
  margin:4px;
  padding:7px;
  width:auto;
}
</style>
<?php 
$emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
$comp_code = $this->Common->findEmpCompany($emp_code);
$fwemplist = $this->Common->findLevel($emp_code,$comp_code);
?>
<div id="page_content" >
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  

             <div class="md-card">
             
        <div class="md-card-toolbar">
          <h3 class="md-card-toolbar-heading-text">
                              <b> Candidate Detail Form</b>
                            </h3>
          </div>
            <div class="md-card-content large-padding">
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'add'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Position Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Position Name', array('label'=>false, 'value'=>'PHP Developer','type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name'));
                               
                               ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department"> Department  Name<span class="req">*</span></label>
                                <?php   //$department=$this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);'empty'=>'Select Department'
$department= array('PHP ADM'=>'PHP ADM');
                                ?>
                            <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'select', 'readonly' => true,'options' =>$department,'class' => "md-input",'required'=>true,'id'=>'first_name')); ?>
                        </div>
                    </div>
                </div>
            <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Designation Name <span class="req fixed">*</span></label>
                            <?php 
                            //$desgName =$this->Common->findDesignationList();'empty'=>'Select Designation';
                            $desgName =array('1'=>'Sr Software Engineer');    
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'options' => $desgName,'class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Location <span class="req fixed">*</span></label>
                            <?php //$locName =$this->Common->findLocationName();'empty'=>'Select Location'
                            $locName =array('1'=>'Noida');    
                            echo $this->form->input('location', array('label'=>false, 'type' => 'select','readonly' => true, 'options' => $locName,'class' => "md-input",'required'=>true,'id'=>'l_name')); 
                            ?>                
                        </div>
                        </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Name <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Current Organization <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    
                    </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Notice Period <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Email <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    
                    </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Adhar/PAN <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Current CTC <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                </div>
               
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor">Preferred Interview Date</label>
                                <?php 
                                echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' => 'startdate','required'=>true,'readonly'=>true));
                                ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-2" id="enddate_div">
                        <div class="parsley-row" >
                            <label for="for">Qualification</label>
                                <?php echo $this->form->input('Description', array('label' =>false, 'class'=>"md-input autosize_init",'required'=>true, "id" => "Requirementdesc" ,'onkeypress'=>'returntext()')); ?> 
                        </div>
                    </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Adhar/PAN <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Current CTC <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    
                    </div>
                    <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-2">
                            <label for="subject">Expected CTC</label>
                            <div class="parsley-row">
                            <?php echo $this->form->input('required_skills', array('label' =>false,'class'=>"md-input", "id" => 'jsj')); ?> 
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="for">Candidate DOB</label>
                                <?php echo $this->form->input('required_exp', array('label' =>false, 'class'=>"md-input",'required'=>true, "id" => "")); ?> 
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-2">
                            <label for="subject">Leaving Reason</label>
                            <div class="parsley-row">
                            <?php echo $this->form->textarea('required_skills', array('label' =>false,'class'=>"md-input", "id" => 'jsj')); ?> 
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <label for="subject">Why Our Company?</label>
                            <div class="parsley-row">
                            <?php echo $this->form->textarea('required_skills', array('label' =>false,'class'=>"md-input", "id" => 'jsj')); ?> 
                        </div>
                    </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-2" id="enddate_div">
                            <label for="cand">Candidate Skills</label>
                            <div class="parsley-row">
                              <?php echo $this->form->textarea('required_skills', array('label' =>false,'class'=>"md-input", "id" => 'jsj')); ?> 
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="enddate_div">
                        <div class="parsley-row">
                            <label for="cand">Candidate Experience</label>
                            <?php echo $this->form->textarea('required_skills', array('label' =>false,'class'=>"md-input", "id" => 'jsj')); ?> 
                            </div>
                        </div>
                    </div> 
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <label for="resume">Candidate Resume</label>
                    <div class="parsley-row">
                        <input type="file" name="cand_cv" id="cand_cv"/>                            
                    </div>
                </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success" >Submit</button>                    
                    </div>
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Recruitment/add') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
</div>
</div>
</div>
</div>

<div id="page_content" style="display:none"> 
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
<form>
            <textarea name="editor1" id="editor1" rows="10" cols="80">
                This is my textarea to be replaced with CKEditor.
            </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
        </form>

 </div>
 </div>
 </div>
 </div>
<script src="<?php echo $this->webroot ?>ckeditor/ckeditor.js"></script>
        