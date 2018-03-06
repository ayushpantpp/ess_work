
<?php if($reqID!=''){  ?>
<div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off">Request Category :</label>
                                <?php 
                                echo $this->form->input('doreq', array('type' => "text",'label'=>false,'disabled'=>'disabled','required'=>true,'value'=>$this->common->findRequestType($ReceivReq[0]['BMReceiveRequest']['request_type_id']), 'class' => "md-input")); 
                                echo $this->form->input('req_cat', array('type' => "hidden",'label'=>false,'required'=>true,'value'=>$ReceivReq[0]['BMReceiveRequest']['request_type_id'], 'class' => "md-input")); 
                                ?>
                        </div>
                    
                    </div>
<div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off">Subject :</label> 
                                <?php 
                                echo $this->form->input('doreq', array('type' => "text",'label'=>false,'required'=>true,'disabled'=>'disabled','value'=>$ReceivReq[0]['BMReceiveRequest']['subject'], 'class' => "md-input")); 
                                echo $this->form->input('sub', array('type' => "hidden",'label'=>false,'required'=>true,'value'=>$ReceivReq[0]['BMReceiveRequest']['subject'], 'class' => "md-input")); 
                                ?>
                        </div>
                    
                    </div>
<div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off">Date Of Request :</label>
                                <?php 
                                $doreq = date("d/m/Y", strtotime($ReceivReq[0]['BMReceiveRequest']['date_of_request']));
                                echo $this->form->input('dorq', array('type' => "text",'label'=>false,'required'=>true,'disabled'=>'disabled','value'=>$doreq, 'class' => "md-input")); 
                                echo $this->form->input('doreq', array('type' => "hidden",'label'=>false,'required'=>true,'value'=>$ReceivReq[0]['BMReceiveRequest']['date_of_request'], 'class' => "md-input")); 
                                ?>
                                
                        </div>
                    
                    </div>
<div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off">Date Of Received :</label>
                                <?php 
                                $dorec = date("d/m/Y", strtotime($ReceivReq[0]['BMReceiveRequest']['date_of_receive']));
                                echo $this->form->input('dor', array('type' => "text",'label'=>false,'required'=>true,'disabled'=>'disabled','value'=>$dorec, 'class' => "md-input")); 
                                echo $this->form->input('dorec', array('type' => "hidden",'label'=>false,'required'=>true,'value'=>$ReceivReq[0]['BMReceiveRequest']['date_of_receive'], 'class' => "md-input")); 
                                ?>
                             </div>
                    
                    </div>
<div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off">Signatory :</label>
                                <?php 
                                echo $this->form->input('doreq', array('type' => "text",'label'=>false,'disabled'=>'disabled','value'=>$this->common->finddepEmpName($ReceivReq[0]['BMReceiveRequest']['signatory_id']), 'class' => "md-input")); 
                                echo $this->form->input('signatory', array('type' => "hidden",'label'=>false,'value'=>$ReceivReq[0]['BMReceiveRequest']['signatory_id'], 'class' => "md-input")); 
                                ?>
                        </div>
                    
                    </div>

<?php }?>