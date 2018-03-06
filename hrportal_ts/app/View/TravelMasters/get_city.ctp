                               <?php 
                                echo $this->form->input('city_type', array('type'=>'select','label'=>false,'required'=>true,'class'=>"md-input",'empty' => '-- Select --','options'=>$city_list,'onChange'=>'checkothers(this.value)'));
                                  ?>