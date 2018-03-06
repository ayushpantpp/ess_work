<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RatingController
 *
 * @author hp4420-50 (Ayush Pant)
 */
class RatingsController extends AppController {

    var $uses = array('RatingType','Competency','CompetencyBehaviour', 'Rating', 'HcmGroupMaster', 'GroupRating', 'AssignRatingDeptDesg', 'Departments', 'OptionAttribute', 'AssignRatingToEmp', 'AssignCompToEmpDetails', 'AssignGroupToDesgDetails' ,'RatingRating','AssignGroupToDesg');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail','Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->layout = 'employee-new';
        $this->set('appId', 12);
        $this->set('emp_code', $this->Auth->User('emp_code'));
        $currentUser = $this->checkUser();
    }

    public function addRating() {
//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $this->paginate = array(
            'limit' => 10,
            'fields' => array('*'),
            'order' => array('Rating.id' => 'desc')
        );
        
        $ratingList = $this->paginate('Rating');
        $this->set("ratingList", $ratingList);
        if (empty($this->request->data['id'])) {
            if ($this->request->is('post') && !empty($this->request->data['Rating']['ratingName'])) {
                $arrayRating['rating_name'] = $this->request->data['Rating']['ratingName'];
                $arrayRating['rating_scale_from'] = $this->request->data['Rating']['ratingScalefrom'];
                $arrayRating['rating_scale_to'] = $this->request->data['Rating']['ratingScaleto'];
                
                $comment = $this->request->data['Rating']['comment'];
                $arrayRating['description'] = str_replace("'","&#39",$comment);
                $arrayRating['status'] = $this->request->data['Rating']['status'];
                $arrayRating['created_by'] = $this->Auth->User('emp_code');
                $arrayRating['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                $arrayRating['org_id'] = $this->Auth->User('comp_code');
                $arrayRating['created_date'] = date("Y-m-d");

                $conditions = array('Rating.rating_name' => $arrayRating["rating_name"],
                    'Rating.description' => $arrayRating["description"]);
                $data = $this->Rating->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Rating already exists. !!!</div>');
                    $this->redirect('/Ratings/addRating');
                } else {
                    $this->Rating->save($arrayRating);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Rating added successfully. !!!</div>');
                    $this->redirect('/Ratings/addRating');
                }
            }
        }

        ///// Update Rating /////
        if (isset($this->request->params['pass'][0]) == "ratingEdit") {

            $ratingEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $ratingEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editRating = $this->Rating->find('first', array('fields' => array('Rating.id', 'Rating.rating_name', 'Rating.rating_scale_from', 'Rating.rating_scale_to', 'Rating.description', 'Rating.status'),
                'conditions' => array('id' => $ratingEditId)
            ));

            if (!empty($this->request->data['Rating']['ratingName'])) {

                $rating_name = $this->request->data['Rating']['ratingName'];
                $comment = $this->request->data['Rating']['comment'];
                $rating_scalefrm = $this->request->data['Rating']['ratingScalefrom'];
                $rating_scaleto = $this->request->data['Rating']['ratingScaleto'];
                $description = str_replace("'","&#39",$comment);
                $status = $this->request->data['Rating']['status'];
                $updated_by = $this->Auth->User('emp_code');
                $updated_date = date("Y-m-d");
                $successUpdate = $this->Rating->updateAll(array('rating_name' => "'$rating_name'", 'rating_scale_from' => "'$rating_scalefrm'" , 'rating_scale_to' => "'$rating_scaleto'",
                    'description' => "'$description'", 'status' => "'$status'", 'updated_date' => "'$updated_date'",'updated_by' => $updated_by), array('id' => $ratingEditId));

                if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Rating updated successfully. !!!</div>');
                    $this->redirect("addRating");
                }
            }

            $this->set('ratingEdit', $ratingEdit);
            $this->set('ratingEditId', $ratingEditId);
            $this->set('editRating', $editRating);
        }
    }

    public function ratingDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Rating->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Rating deleted successfully. !!!</div>');
                $this->redirect("addRating");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Rating not deleted successfully. !!!</div>');
                $this->redirect("addRating");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Rating is not selected. !!!</div>');
        }
        $this->redirect("addRating");
        exit;
    }

  
    public function RatingRatingList() {
       $this->layout = false;
    }
    
    
    public function addCompetencyBehaviour() {
//Configure::write('debug',2);      
        //echo "<pre>"; print_r($this->request->data); die;
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 10,
            'fields' => array('*'),
            'order' => array('CompetencyBehaviour.id' => 'desc')
        );
        $Competency = $this->Competency->find('list', 
                array('fields' => array('Competency.id', 'Competency.competency_name'),
                        'conditions' => array('Competency.status' => 1),
                    'order' => 'Competency.competency_name ASC',
                        ));

        $this->set('Competency',$Competency);
        $behaviourList = $this->paginate('CompetencyBehaviour');
        //die('djaj');
        $this->set("behaviourList", $behaviourList);

        if (empty($this->request->data['id'])) {
            $i = 0;
            if ($this->request->is('post') && !empty($this->request->data['CompetencyBehaviour']['CompetencyName'])) {
                 foreach ($this->request->data['CompetencyBehaviour']['comment'] as $k) {
                        $arrayCompetencyBehaviour['compitency_id'] = $this->request->data['CompetencyBehaviour']['CompetencyName'];
                        $comment = $this->request->data['CompetencyBehaviour']['comment'][$i];
                        $arrayCompetencyBehaviour['behaviour_desc'] = str_replace("'","&#39",$comment);
                        $arrayCompetencyBehaviour['status'] = $this->request->data['CompetencyBehaviour']['status'];
                        $arrayCompetencyBehaviour['created_by'] = $this->Auth->User('emp_code');
                        $arrayCompetencyBehaviour['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                        $arrayCompetencyBehaviour['org_id'] = $this->Auth->User('comp_code');
                        $arrayCompetencyBehaviour['created_date'] = date("Y-m-d");

                        $i++;
                        $this->CompetencyBehaviour->create();
                        $success = $this->CompetencyBehaviour->save($arrayCompetencyBehaviour);
                }

                
                if ($success) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency Behaviour added successfully. !!!</div>');
                    $this->redirect('/Ratings/addCompetencyBehaviour');
                } 
            }
        }

        ///// Update CompetencyBehaviour /////
        if (isset($this->request->params['pass'][0]) == "ratingEdit") {
            
            
            $behaviourEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $behaviourEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editCompetencyBehaviour = $this->CompetencyBehaviour->find('first', array('fields' => array('CompetencyBehaviour.id', 'CompetencyBehaviour.compitency_id', 'CompetencyBehaviour.behaviour_desc','CompetencyBehaviour.status'),
                'conditions' => array('id' => $behaviourEditId)
            ));
                
            if (!empty($this->request->data['CompetencyBehaviour']['CompetencyName'])) {
                
                $behaviour_name = $this->request->data['CompetencyBehaviour']['CompetencyName'];
                $comment = $this->request->data['CompetencyBehaviour']['comment'][0];
                $description = str_replace("'","&#39",$comment);
                $status = $this->request->data['CompetencyBehaviour']['status'];
                $updated_by = $this->Auth->User('emp_code');
                $updated_date = date("Y-m-d");
                $successUpdate = $this->CompetencyBehaviour->updateAll(array('compitency_id' => "'$behaviour_name'", 'behaviour_desc' => "'$description'",
                     'status' => "'$status'", 'updated_date' => "'$updated_date'",'updated_by' => $updated_by), array('id' => $behaviourEditId));

                if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency Behaviour updated successfully. !!!</div>');
                    $this->redirect("addCompetencyBehaviour");
                }
            }

            $this->set('behaviourEdit', $behaviourEdit);
            $this->set('behaviourEditId', $behaviourEditId);
            $this->set('editCompetencyBehaviour', $editCompetencyBehaviour);
        }
    }
    
     public function competencyBehaviourDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->CompetencyBehaviour->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency Behaviour deleted successfully. !!!</div>');
                $this->redirect("addCompetencyBehaviour");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency Behaviour not deleted successfully. !!!</div>');
                $this->redirect("addCompetencyBehaviour");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency Behaviour is not selected. !!!</div>');
        }
        $this->redirect("addCompetencyBehaviour");
        exit;
    }
        
    

}
