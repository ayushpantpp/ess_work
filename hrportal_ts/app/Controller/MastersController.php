<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Leaves_controller.php
  *  ******************************************************************************
  *  file (Leaves_controller.php) version: 0.1.0
  *  file description: Cake PHP Controller file for manupilating Leave data
  *  file change log:
  *            created by Ayush Pant <ayush.pant@essindia.com>
  *            Jan 28, 2017 2:59:31 PM Created controller, and actions add | edit | view | delete.
  *            changed by Arti Gupta
  *            <date> <time> <changed-action-name> <change-description> 
  *  
  * ******************************************************************************
  *  project: EssPortal
  * project version: 0.1.0
  *  @author Ayush Pant <ayush.pant@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Jun 28, 2011 2:59:31 PM 
  *  ******************************************************************************
 */

class MastersController extends AppController {

    var $name = 'Masters';
    var $layout = 'employee-new';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('Ministry', 'MstPromotionType', 'MstSchemeOfService', 'MstLogo', 'MstJobcode', 'MstRecommendedTermsService', 'MstTermsOfService', 'MstRetirementGround', 'UserDetail', 'MstRequest', 'MstSignatory', 'Departments', 'MyProfile', 'Company','Appmaster');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
      function index() {
        $this->layout = 'admin';
    }


    function ministry() {
        $this->layout = 'employee-new';
        $ministryData = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {

            $new = 0;
            foreach ($this->request->data['ministry_name'] as $k) {
                $ministryData['ministry_name'] = $this->request->data['ministry_name'][$new];
                $ministryData['ministry_code'] = $this->request->data['ministry_code'][$new];
                $ministryData['email_id'] = $this->request->data['email_id'][$new];
                $ministryData['created_date'] = date("Y-m-d");
                $ministryData['created_by'] = $emp_code;
                $ministryData['ministry_status'] = 1;

                $new++;

                $this->Ministry->create();
                $success = $this->Ministry->save($ministryData);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Record saved succesfully. !!!</div>');
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('Ministry.id', 'Ministry.ministry_name', 'Ministry.ministry_code', 'Ministry.email_id', 'Ministry.ministry_status'),
            'order' => array('Ministry.id' => 'desc')
        );

        $ministryList = $this->paginate('Ministry');
        $this->set("ministryList", $ministryList);

        //// Update Ministry Status /////

        if (isset($this->request->data['ministry_status'])) {
            if (isset($this->request->data['id'])) {
                $ministry_id = $this->request->data['id'];
                $ministry_status = $this->request->data['ministry_status'];
                $task = array();
                $m = 0;
                foreach ($this->data['id'] as $k) {
                    $mID = $this->request->data['id'][$m];
                    $ministry_status = $this->request->data['ministry_status'];
                    $m++;
                    $successStatus = $this->Ministry->updateAll(array('ministry_status' => $ministry_status), array('id' => $mID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Ministry status saved succesfully. !!!</div>');
                    $this->redirect("ministry");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Ministry. !!!</div>');
                $this->redirect("ministry");
            }
        }


        ///// Update Ministry /////
        if (isset($this->request->params['pass'][0]) == "ministryEdit") {

            $meetingEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $meetingEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editMinistry = $this->Ministry->find('first', array('fields' => array('Ministry.id', 'Ministry.ministry_name', 'Ministry.ministry_code', 'Ministry.email_id', 'Ministry.ministry_status'),
                'conditions' => array('id' => $meetingEditId)
            ));

            if (!empty($this->request->data['ministry_name'])) {

                $new = 0;
                foreach ($this->request->data['ministry_name'] as $k) {
                    $ministry_name = $this->request->data['ministry_name'][$new];
                    $ministry_code = $this->request->data['ministry_code'][$new];
                    $email_id = $this->request->data['email_id'][$new];

                    $successUpdate = $this->Ministry->updateAll(array('ministry_name' => "'$ministry_name'", 'ministry_code' => "'$ministry_code'", 'email_id' => "'$email_id'"), array('id' => $meetingEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Record updated succesfully. !!!</div>');
                    $this->redirect("ministry");
                }
            }

            $this->set('meetingEdit', $meetingEdit);
            $this->set('meetingEditId', $meetingEditId);
            $this->set('editMinistry', $editMinistry);
        }
    }

    function ministryDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Ministry->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Ministry deleted succesfully. !!!</div>');
                $this->redirect("ministry");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Ministry not deleted succesfully. !!!</div>');
                $this->redirect("ministry");
            }
        } else
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Ministry is not selected. !!!</div>');
        $this->redirect("ministry");
        exit;
    }

    public function jobcode() {
         $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            $counter = count($this->request->data['department']);
            for ($i = 0; $i < $counter; $i++) {
                $department = $this->request->data['department'][$i];
                $jobcode = $this->request->data['jobcode'][$i];
                $sal_struc = $this->request->data['sal_struc'][$i];

                $data['MstJobcode']['dept_id'] = $department;
                $data['MstJobcode']['jobcode'] = $jobcode;
                $data['MstJobcode']['salary_structure'] = $sal_struc;

                $this->MstJobcode->create();
                $success = $this->MstJobcode->save($data);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Job Code Submited Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Job Code not created !</div>');
            }
            $this->redirect("jobcode");
        }
        $Departments = $this->Departments->find('list', array('fields' => array('Departments.dept_name')));

        $this->set('Departments', $Departments);
    }

    function promotion() {
        $this->layout = 'employee-new';
        $promotionData = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {

            $new = 0;
            foreach ($this->request->data['promotion_name'] as $k) {
                $promotionData['promotion_name'] = $this->request->data['promotion_name'][$new];
                $promotionData['promotion_code'] = $this->request->data['promotion_code'][$new];
                $promotionData['created_date'] = date("Y-m-d");
                $promotionData['created_by'] = $emp_code;
                $promotionData['promotion_status'] = 1;
                $new++;

                $this->MstPromotionType->create();
                $success = $this->MstPromotionType->save($promotionData);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Promotion type saved succesfully. !!!</div>');
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstPromotionType.id', 'MstPromotionType.promotion_name', 'MstPromotionType.promotion_code', 'MstPromotionType.promotion_status'),
            'order' => array('MstPromotionType.id' => 'desc')
        );

        $promotionList = $this->paginate('MstPromotionType');
        $this->set("promotionList", $promotionList);

        //// Update Promotion Type Status /////

        if (isset($this->request->data['promotion_status'])) {
            if (isset($this->request->data['id'])) {
                $promotion_id = $this->request->data['id'];
                $promotion_status = $this->request->data['promotion_status'];
                $task = array();
                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $pID = $this->request->data['id'][$p];
                    $promotion_status = $this->request->data['promotion_status'];
                    $p++;
                    $successStatus = $this->MstPromotionType->updateAll(array('promotion_status' => $promotion_status), array('id' => $pID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Promotion type status saved succesfully. !!!</div>');
                    $this->redirect("promotion");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Promotion Type. !!!</div>');
                $this->redirect("promotion");
            }
        }


        ///// Update Promotion Type /////
        if (isset($this->request->params['pass'][0]) == "ministryEdit") {

            $promotionEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $promotionEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editPromotion = $this->MstPromotionType->find('first', array('fields' => array('MstPromotionType.id', 'MstPromotionType.promotion_name', 'MstPromotionType.promotion_code', 'MstPromotionType.promotion_status'),
                'conditions' => array('id' => $promotionEditId)
            ));

            if (!empty($this->request->data['promotion_name'])) {

                $new = 0;
                foreach ($this->request->data['promotion_name'] as $k) {
                    $promotion_name = $this->request->data['promotion_name'][$new];
                    $promotion_code = $this->request->data['promotion_code'][$new];

                    $successUpdate = $this->MstPromotionType->updateAll(array('promotion_name' => "'$promotion_name'", 'promotion_code' => "'$promotion_code'"), array('id' => $promotionEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Promotion Type updated succesfully. !!!</div>');
                    $this->redirect("promotion");
                }
            }

            $this->set('promotionEdit', $promotionEdit);
            $this->set('promotionEditId', $promotionEditId);
            $this->set('editPromotion', $editPromotion);
        }
    }

    function promotionDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstPromotionType->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Promotion type deleted succesfully. !!!</div>');
                $this->redirect("promotion");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Promotion type not deleted succesfully. !!!</div>');
                $this->redirect("promotion");
            }
        } else
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Promotion type is not selected. !!!</div>');
        $this->redirect("promotion");
        exit;
    }

    function schemeService() {
        $this->layout = 'employee-new';
        $schemeOfServicesData = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {

            $new = 0;
            foreach ($this->request->data['scheme_name'] as $k) {
                $schemeOfServicesData['scheme_name'] = $this->request->data['scheme_name'][$new];
                $schemeOfServicesData['scheme_code'] = $this->request->data['scheme_code'][$new];
                $schemeOfServicesData['created_date'] = date("Y-m-d");
                $schemeOfServicesData['created_by'] = $emp_code;
                $schemeOfServicesData['scheme_status'] = 1;
                $new++;

                $this->MstSchemeOfService->create();
                $success = $this->MstSchemeOfService->save($schemeOfServicesData);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Scheme of services type saved succesfully. !!!</div>');
                $this->redirect("schemeService");
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstSchemeOfService.id', 'MstSchemeOfService.scheme_name', 'MstSchemeOfService.scheme_code', 'MstSchemeOfService.scheme_status'),
            'order' => array('MstSchemeOfService.id' => 'desc')
        );

        $schemeServicesList = $this->paginate('MstSchemeOfService');
        $this->set("schemeServicesList", $schemeServicesList);

        //// Update  Scheme Services Type Status /////

        if (isset($this->request->data['scheme_status'])) {
            if (isset($this->request->data['id'])) {
                $scheme_id = $this->request->data['id'];
                $scheme_status = $this->request->data['scheme_status'];

                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $sID = $this->request->data['id'][$p];
                    $scheme_status = $this->request->data['scheme_status'];
                    $p++;
                    $successStatus = $this->MstSchemeOfService->updateAll(array('scheme_status' => $scheme_status), array('id' => $sID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Scheme of service type status saved succesfully. !!!</div>');
                    $this->redirect("schemeService");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Scheme of service Type. !!!</div>');
                $this->redirect("schemeServices");
            }
        }


        ///// Update Scheme Of Service /////
        if (isset($this->request->params['pass'][0]) == "promotionEdit") {

            $schemeServicesEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $schemeServicesEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editSchemeServices = $this->MstSchemeOfService->find('first', array('fields' => array('MstSchemeOfService.id', 'MstSchemeOfService.scheme_name', 'MstSchemeOfService.scheme_code', 'MstSchemeOfService.scheme_status'),
                'conditions' => array('id' => $schemeServicesEditId)
            ));

            if (!empty($this->request->data['scheme_name'])) {

                $new = 0;
                foreach ($this->request->data['scheme_name'] as $k) {
                    $scheme_name = $this->request->data['scheme_name'][$new];
                    $scheme_code = $this->request->data['scheme_code'][$new];
                    $successUpdate = $this->MstSchemeOfService->updateAll(array('scheme_name' => "'$scheme_name'", 'scheme_code' => "'$scheme_code'"), array('id' => $schemeServicesEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Scheme of services Type updated succesfully. !!!</div>');
                    $this->redirect("schemeService");
                }
            }

            $this->set('schemeServicesEdit', $schemeServicesEdit);
            $this->set('schemeServicesEditId', $schemeServicesEditId);
            $this->set('editSchemeServices', $editSchemeServices);
        }
    }

    function schemeServicesDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstSchemeOfService->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Scheme Of services type deleted succesfully. !!!</div>');
                $this->redirect("schemeService");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Scheme of services type not deleted succesfully. !!!</div>');
                $this->redirect("schemeService");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Scheme of services type is not selected. !!!</div>');
        }
        $this->redirect("schemeService");
        exit;
    }

    function recommendedTermsService() {
        $this->layout = 'employee-new';
        $recommendedTermsServiceData = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {

            $new = 0;
            foreach ($this->request->data['recommended_tos_name'] as $k) {
                $recommendedTermsServiceData['recommended_tos_name'] = $this->request->data['recommended_tos_name'][$new];
                $recommendedTermsServiceData['created_date'] = date("Y-m-d");
                $recommendedTermsServiceData['created_by'] = $emp_code;
                $recommendedTermsServiceData['recommended_tos_status'] = 1;
                $new++;

                $this->MstRecommendedTermsService->create();
                $success = $this->MstRecommendedTermsService->save($recommendedTermsServiceData);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Recommended terms of  services type saved succesfully. !!!</div>');
                $this->redirect("recommendedTermsService");
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstRecommendedTermsService.id', 'MstRecommendedTermsService.recommended_tos_name', 'MstRecommendedTermsService.recommended_tos_status'),
            'order' => array('MstRecommendedTermsService.id' => 'desc')
        );

        $recommendedTermsServiceList = $this->paginate('MstRecommendedTermsService');
        $this->set("recommendedTermsServiceList", $recommendedTermsServiceList);

        //// Update  Scheme Services Type Status /////

        if (isset($this->request->data['recommended_tos_status'])) {
            if (isset($this->request->data['id'])) {
                $recommended_tos_id = $this->request->data['id'];
                $recommended_tos_status = $this->request->data['recommended_tos_status'];

                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $sID = $this->request->data['id'][$p];
                    $recommended_tos_status = $this->request->data['recommended_tos_status'];
                    $p++;
                    $successStatus = $this->MstRecommendedTermsService->updateAll(array('recommended_tos_status' => $recommended_tos_status), array('id' => $sID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Recommended terms of  service type status saved succesfully. !!!</div>');
                    $this->redirect("recommendedTermsService");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Recommended terms of  service type. !!!</div>');
                $this->redirect("recommendedTermsService");
            }
        }


        ///// Update Recommended Terms of Service Type /////
        if (isset($this->request->params['pass'][0]) == "recommendedTermsServiceEdit") {

            $recommendedTermsServiceEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $recommendedTermsServiceEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editRecommendedTermsService = $this->MstRecommendedTermsService->find('first', array('fields' => array('MstRecommendedTermsService.id', 'MstRecommendedTermsService.recommended_tos_name', 'MstRecommendedTermsService.recommended_tos_status'),
                'conditions' => array('id' => $recommendedTermsServiceEditId)
            ));

            if (!empty($this->request->data['recommended_tos_name'])) {

                $new = 0;
                foreach ($this->request->data['recommended_tos_name'] as $k) {
                    $recommended_tos_name = $this->request->data['recommended_tos_name'][$new];

                    $successUpdate = $this->MstRecommendedTermsService->updateAll(array('recommended_tos_name' => "'$recommended_tos_name'"), array('id' => $recommendedTermsServiceEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Recommended terms of  services type updated succesfully. !!!</div>');
                    $this->redirect("recommendedTermsService");
                }
            }

            $this->set('recommendedTermsServiceEdit', $recommendedTermsServiceEdit);
            $this->set('recommendedTermsServiceEditId', $recommendedTermsServiceEditId);
            $this->set('editRecommendedTermsService', $editRecommendedTermsService);
        }
    }

    function recommendedTermsServiceDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstRecommendedTermsService->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Recommended termsof service type deleted succesfully. !!!</div>');
                $this->redirect("recommendedTermsService");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Recommended termsof service type not deleted succesfully. !!!</div>');
                $this->redirect("recommendedTermsService");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Recommended termsof service type is not selected. !!!</div>');
        }
        $this->redirect("recommendedTermsService");
        exit;
    }

    function termsOfService() {
        $this->layout = 'employee-new';
        $termsOfServiceData = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {

            $new = 0;
            foreach ($this->request->data['tos_name'] as $k) {
                $termsOfServiceData['tos_name'] = $this->request->data['tos_name'][$new];
                $termsOfServiceData['created_date'] = date("Y-m-d");
                $termsOfServiceData['created_by'] = $emp_code;
                $termsOfServiceData['tos_status'] = 1;
                $new++;

                $this->MstTermsOfService->create();
                $success = $this->MstTermsOfService->save($termsOfServiceData);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Terms of  services type saved succesfully. !!!</div>');
                $this->redirect("termsOfService");
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstTermsOfService.id', 'MstTermsOfService.tos_name', 'MstTermsOfService.tos_status'),
            'order' => array('MstTermsOfService.id' => 'desc')
        );

        $termsOfServiceList = $this->paginate('MstTermsOfService');
        $this->set("termsOfServiceList", $termsOfServiceList);

        //// Update  Scheme Services Type Status /////

        if (isset($this->request->data['tos_status'])) {
            if (isset($this->request->data['id'])) {
                $tos_id = $this->request->data['id'];
                $tos_status = $this->request->data['tos_status'];

                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $sID = $this->request->data['id'][$p];
                    $tos_status = $this->request->data['tos_status'];
                    $p++;
                    $successStatus = $this->MstTermsOfService->updateAll(array('tos_status' => $tos_status), array('id' => $sID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Terms of  services type status saved succesfully. !!!</div>');
                    $this->redirect("termsOfService");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one terms of services type. !!!</div>');
                $this->redirect("termsOfService");
            }
        }


        ///// Update Recommended Terms of Service Type /////
        if (isset($this->request->params['pass'][0]) == "termsOfServiceEdit") {

            $termsOfServiceEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $termsOfServiceEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editTermsOfService = $this->MstTermsOfService->find('first', array('fields' => array('MstTermsOfService.id', 'MstTermsOfService.tos_name', 'MstTermsOfService.tos_status'),
                'conditions' => array('id' => $termsOfServiceEditId)
            ));

            if (!empty($this->request->data['tos_name'])) {

                $new = 0;
                foreach ($this->request->data['tos_name'] as $k) {
                    $tos_name = $this->request->data['tos_name'][$new];

                    $successUpdate = $this->MstTermsOfService->updateAll(array('tos_name' => "'$tos_name'"), array('id' => $termsOfServiceEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Terms of  services type updated succesfully. !!!</div>');
                    $this->redirect("termsOfService");
                }
            }

            $this->set('termsOfServiceEdit', $termsOfServiceEdit);
            $this->set('termsOfServiceEditId', $termsOfServiceEditId);
            $this->set('editTermsOfService', $editTermsOfService);
        }
    }

    function termsOfServiceDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstTermsOfService->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Terms of service type deleted succesfully. !!!</div>');
                $this->redirect("termsOfService");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Terms of service type not deleted succesfully. !!!</div>');
                $this->redirect("termsOfService");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Terms of service type is not selected. !!!</div>');
        }
        $this->redirect("termsOfService");
        exit;
    }

    function retirementGround() {
        $this->layout = 'employee-new';
        $retirementGroundData = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {

            $new = 0;
            foreach ($this->request->data['retirement_ground_name'] as $k) {
                $retirementGroundData['retirement_ground_name'] = $this->request->data['retirement_ground_name'][$new];
                $retirementGroundData['created_date'] = date("Y-m-d");
                $retirementGroundData['created_by'] = $emp_code;
                $retirementGroundData['retirement_ground_status'] = 1;
                $new++;

                $this->MstRetirementGround->create();
                $success = $this->MstRetirementGround->save($retirementGroundData);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Retirement ground type saved succesfully. !!!</div>');
                $this->redirect("retirementGround");
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstRetirementGround.id', 'MstRetirementGround.retirement_ground_name', 'MstRetirementGround.retirement_ground_status'),
            'order' => array('MstRetirementGround.id' => 'desc')
        );

        $retirementGroundList = $this->paginate('MstRetirementGround');
        $this->set("retirementGroundList", $retirementGroundList);

        //// Update Retirement Grounds Type Status /////

        if (isset($this->request->data['retirement_ground_status'])) {
            if (isset($this->request->data['id'])) {
                $retirement_ground_id = $this->request->data['id'];
                $retirement_ground_status = $this->request->data['retirement_ground_status'];

                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $sID = $this->request->data['id'][$p];
                    $retirement_ground_status = $this->request->data['retirement_ground_status'];
                    $p++;
                    $successStatus = $this->MstRetirementGround->updateAll(array('retirement_ground_status' => $retirement_ground_status), array('id' => $sID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Retirement ground type status saved succesfully. !!!</div>');
                    $this->redirect("retirementGround");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one terms of services type. !!!</div>');
                $this->redirect("retirementGround");
            }
        }


        ///// Update Retirement Ground Type /////
        if (isset($this->request->params['pass'][0]) == "retirementGroundEdit") {

            $retirementGroundEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $retirementGroundEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editRetirementGround = $this->MstRetirementGround->find('first', array('fields' => array('MstRetirementGround.id', 'MstRetirementGround.retirement_ground_name', 'MstRetirementGround.retirement_ground_status'),
                'conditions' => array('id' => $retirementGroundEditId)
            ));

            if (!empty($this->request->data['retirement_ground_name'])) {

                $new = 0;
                foreach ($this->request->data['retirement_ground_name'] as $k) {
                    $retirement_ground_name = $this->request->data['retirement_ground_name'][$new];

                    $successUpdate = $this->MstRetirementGround->updateAll(array('retirement_ground_name' => "'$retirement_ground_name'"), array('id' => $retirementGroundEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Retirement ground type updated succesfully. !!!</div>');
                    $this->redirect("retirementGround");
                }
            }

            $this->set('retirementGroundEdit', $retirementGroundEdit);
            $this->set('retirementGroundEditId', $retirementGroundEditId);
            $this->set('editRetirementGround', $editRetirementGround);
        }
    }

    public function retirementGroundDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstRetirementGround->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Retirement ground deleted succesfully. !!!</div>');
                $this->redirect("retirementGround");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Retirement ground type not deleted succesfully. !!!</div>');
                $this->redirect("retirementGround");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Retirement ground type is not selected. !!!</div>');
        }
        $this->redirect("retirementGround");
        exit;
    }

    public function mstRequest() {
        $this->layout = 'employee-new';
        $data = array();
        $emp_code = $this->Auth->User('emp_code');
        if (empty($this->request->data['id'])) {
            $new = 0;
            foreach ($this->request->data['req_type_name'] as $k) {
                $data['req_type_name'] = $this->request->data['req_type_name'][$new];
                $data['created_date'] = date("Y-m-d");
                $data['created_by'] = $emp_code;
                $data['status'] = 1;
                $new++;
                $this->MstRequest->create();
                $success = $this->MstRequest->save($data);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request Type saved succesfully. !!!</div>');
                $this->redirect("mstRequest");
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstRequest.id', 'MstRequest.req_type_name', 'MstRequest.status'),
            'order' => array('MstRequest.id' => 'desc')
        );

        $MstRequest = $this->paginate('MstRequest');
        $this->set("MstRequest", $MstRequest);

        //// Update  Scheme Services Type Status /////

        if (isset($this->request->data['status'])) {
            if (isset($this->request->data['id'])) {
                $tos_id = $this->request->data['id'];
                $tos_status = $this->request->data['status'];

                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $sID = $this->request->data['id'][$p];
                    $tos_status = $this->request->data['status'];
                    $p++;
                    $successStatus = $this->MstRequest->updateAll(array('status' => $tos_status), array('id' => $sID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request type status saved succesfully. !!!</div>');
                    $this->redirect("mstRequest");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Request type. !!!</div>');
                $this->redirect("mstRequest");
            }
        }
        ///// Update Recommended Terms of Service Type /////
        if (isset($this->request->params['pass'][0]) == "termsOfServiceEdit") {
            $termsOfServiceEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $termsOfServiceEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";
            $editTermsOfService = $this->MstRequest->find('first', array('fields' => array('MstRequest.id', 'MstRequest.req_type_name', 'MstRequest.status'),
                'conditions' => array('id' => $termsOfServiceEditId)
            ));

            if (!empty($this->request->data['req_type_name'])) {

                $new = 0;
                foreach ($this->request->data['req_type_name'] as $k) {
                    $tos_name = $this->request->data['req_type_name'][$new];

                    $successUpdate = $this->MstRequest->updateAll(array('req_type_name' => "'$tos_name'"), array('id' => $termsOfServiceEditId));
                }if ($successUpdate) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Request Type updated succesfully. !!!</div>');
                    $this->redirect("mstRequest");
                }
            }

            $this->set('termsOfServiceEdit', $termsOfServiceEdit);
            $this->set('termsOfServiceEditId', $termsOfServiceEditId);
            $this->set('editTermsOfService', $editTermsOfService);
        }
    }

    public function mstRequestDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstRequest->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request Type deleted succesfully. !!!</div>');
                $this->redirect("mstRequest");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request Type not deleted succesfully. !!!</div>');
                $this->redirect("mstRequest");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request Type type is not selected. !!!</div>');
        }
        $this->redirect("mstRequest");
        exit;
    }

    public function mstRequestEdit($id = null, $name) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            $successUpdate = $this->MstRequest->updateAll(array('req_type_name' => "'$name'"), array('id' => $id));
            if ($successUpdate) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Terms of  services type updated succesfully. !!!</div>');
            }
        }
    }

    public function SignatoryMaster() {
        $this->layout = 'employee-new';
        $data = array();
        $emp_code = $this->Auth->User('emp_code');
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => '01')
        ));
        $this->set("department_list", $dept);

        if (empty($this->request->data['id'])) {
            $new = 0;
            foreach ($this->request->data['employee_id'] as $k) {
                $data['signatory_id'] = $k;
                $data['department_id'] = $this->request->data['department_id'];
                $data['created_date'] = date("Y-m-d");
                $data['created_by'] = $emp_code;
                $data['status'] = 1;
                $new++;
                $this->MstSignatory->create();
                $success = $this->MstSignatory->save($data);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Signatory saved succesfully. !!!</div>');
                $this->redirect("SignatoryMaster");
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstSignatory.id', 'MstSignatory.department_id', 'MstSignatory.signatory_id', 'MstSignatory.status'),
            'order' => array('MstSignatory.id' => 'desc')
        );

        $MstRequest = $this->paginate('MstSignatory');
        $this->set("MstRequest", $MstRequest);

        //// Update  Scheme Services Type Status /////

        if (isset($this->request->data['status'])) {
            if (isset($this->request->data['id'])) {
                $tos_id = $this->request->data['id'];
                $tos_status = $this->request->data['status'];

                $p = 0;
                foreach ($this->data['id'] as $k) {
                    $sID = $this->request->data['id'][$p];
                    $tos_status = $this->request->data['status'];
                    $p++;
                    $successStatus = $this->MstSignatory->updateAll(array('status' => $tos_status), array('id' => $sID));
                }
                if ($successStatus) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Signatory status saved succesfully. !!!</div>');
                    $this->redirect("SignatoryMaster");
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Signatory. !!!</div>');
                $this->redirect("SignatoryMaster");
            }
        }
    }

    public function SignatoryMasterDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstSignatory->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request Type deleted succesfully. !!!</div>');
                $this->redirect("SignatoryMaster");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request Type not deleted succesfully. !!!</div>');
                $this->redirect("SignatoryMaster");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Request Type type is not selected. !!!</div>');
        }
        $this->redirect("SignatoryMaster");
        exit;
    }

    public function SignatoryMasterEdit($id = null, $name) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            $successUpdate = $this->MstSignatory->updateAll(array('signatory_id' => "'$name'"), array('id' => $id));
            if ($successUpdate) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Terms of  services type updated succesfully. !!!</div>');
            }
        }
    }

    public function employeelist($val) {
        $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
            'conditions' => array('dept_code' => $val),
            'order' => array('MyProfile.emp_name' => 'DESC')
        ));
        $xyz = "";
        foreach ($employee_list as $k => $val) {
            $xyz .= '<option  value="$k">$val</option>';
        }
        $html = '<script src="<?php echo $this->webroot ?>js/js/pages/kendoui.min.js"></script>
                <label for="kUI_multiselect_basic" class="uk-form-label">Select Employee</label>
                <select id="kUI_multiselect_basic" name="employee_id[]" required="" id="employee_id" multiple="multiple" data-placeholder="Select Employee...">
                $xyz</select>';
        $this->set("employee_list", $employee_name);
    }

    public function Logo() {
        $this->layout = 'admin';
        $data = array();
        $emp_code = $this->Auth->User('emp_code');
        $comp = $this->Company->find('list', array(
            'fields' => array('Company.org_id', 'Company.comp_name')
        ));
        $this->set("company_list", $comp);
        
        $value = $this->MstLogo->find('first', 
                array('conditions' => array('org_id' => $this->request->data['master']['org_id'])));
        if (!empty($_FILES['doc_file']['name'])) {
            $newfilename = $n . basename($_FILES['doc_file']['name']);
            $file = "images/" . $newfilename;
            $filename = basename($_FILES['doc_file']['name']);
            move_uploaded_file($_FILES['doc_file']['tmp_name'], $file);
        } else {
            $newfilename = "";
        }
        if (!empty($this->request->data)) {
            if (empty($value)) {
                $new = 0;
                $data['logo_file'] = $newfilename;
                $data['org_id'] = $this->request->data['master']['org_id'];
                $data['created_date'] = date("Y-m-d");
                $data['created_by'] = $emp_code;
                $new++;
                $this->MstLogo->create();
                $success = $this->MstLogo->save($data);
                if ($success) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Signatory saved succesfully. !!!</div>');
                    $this->redirect("Logo");
                }
            } else {
                $new = 0;
                $data['id'] = $value['MstLogo']['id'];
                $data['logo_file'] = $newfilename;
                $data['org_id'] = $this->request->data['master']['org_id'];
                $data['created_date'] = date("Y-m-d");
                $data['created_by'] = $emp_code;
                $this->MstLogo->create();
                $success = $this->MstLogo->save($data);
                if ($success) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Logo Updated succesfully. !!!</div>');
                    $this->redirect("Logo");
                }
            }
        }

        $this->paginate = array(
            'limit' => 5,
            'fields' => array('MstLogo.id', 'MstLogo.logo_file', 'MstLogo.org_id', 'MstLogo.created'),
            'order' => array('MstLogo.id' => 'desc')
        );

        $MstRequest = $this->paginate('MstLogo');
        $this->set("MstRequest", $MstRequest);

    }
      public function Appmaster() {
        //Configure::write('debug',1);
       $this->layout = 'admin';
        $data = array();
        if (!empty($this->request->data)) {
        
            
                $data['app_id'] = $this->request->data['app_name'];
                $data['org_id'] = $this->request->data['org_id'];
                $data['apply_in_days']=$this->request->data['max_days'];
                $data['created_date'] = date("Y-m-d");
              
                $this->Appmaster->create();
                
                $success = $this->Appmaster->save($data);

                if ($success) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Application  saved succesfully. !!!</div>');
                    $this->redirect("Appmaster");
                }
             else {
                
            
                $data['app_id'] = $this->request->data['app_name'];
                $data['org_id'] = $this->request->data['org_id'];
                $data['apply_in_days']=$this->request->data['max_days'];
                     $data['created_date'] = date("Y-m-d");
                
                $this->Appmaster->create();
                $success = $this->Appmaster->save($data);
                if ($success) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Application Updated succesfully. !!!</div>');
                    $this->redirect("Appmaster");
                }
            }
        }
    }
 function lists() {


 $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Appmaster.id', 'Appmaster.app_id', 'Appmaster.apply_in_days', 'Appmaster.org_id'),
            'order' => array(
                'Appmaster.id' => 'desc',
            )
        );
   $result = $this->paginate('Appmaster');
   
        
        $this->set('list', $result);

      /*  $result = $this->paginate('Masters');
        
        $this->set('list', $result);
        if (!empty($this->data)) {
        
            $id = $this->data['Masters']['org_id'];
            $dept_name = strtoupper($this->data['Masters']['app_id']);
            $dept_code = $this->data['Masters']['apply_in_days'];
            if ($id != '') {
                $q .= "  Masters.comp_code= " . $id;
            }
            if ($dept_name != ''&& $id!='') {
                $q .= " AND Masters.app_id Like '$dept_name%'";
            }
            else if($dept_name != ''){
                 $q .= "  Masters.apply_in_days Like '$dept_name%'";
            }
            
        $conditions = array($q);
    
        
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Masters.id', 'Masters.app_id', 'Masters.apply_in_days', 'Masters.org_id'),
            'order' => array(
                'Masters.id' => 'Desc',
            )
        );

        $result = $this->paginate('Masters');
        //pr($result); die;
        $this->set('list', $result);
  }  else{

print_r($this->data);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Masters.id', 'Masters.app_id', 'Masters.apply_in_days', 'Masters.org_id'),
            'order' => array(
                'Masters.id' => 'asc',
            )
        );

        $result = $this->paginate('Masters');
        
        $this->set('list', $result);
    }*/
}
   function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Appmaster->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }   
      function edit($id) { //echo'<pre>';print_r($this->data);die('ss');
        $this->autoRender = false;
        $this->layout = false;

        if (!empty($this->data)) {
            $this->request->data['Appmaster']['id'] = $id;
            
                /*  $this->request->data['Department']['usr_id_mod'] = '1';
                  $this->request->data['Department']['usr_id_mod_dt']=date('Y-m-d'); */
                $this->request->data['Appmaster']['app_id'] = strtoupper($this->data['Appmaster']['app_id']);
                $this->request->data['Appmaster']['apply_in_days'] = strtoupper($this->data['Appmaster']['apply_in_days']);
                $this->request->data['Appmaster']['org_id'] = strtoupper($this->data['Appmaster']['org_id']);
                //pr($this->request->data['Department']);die;
                if ($this->Appmaster->save($this->data)) {
                    $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
                }
            
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }
    
}

?>
