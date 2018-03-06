
<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class DocumentsController extends AppController {

    public $name = 'Documents';
    public $uses = array('Documentlist', 'DocumentRequest', 'Category', 'MstCat', 'Gallerylist', 'DocumentReceiveRequestForward', 'MailOffice', 'MailOfficeAttachFiles', 'WfPaginateLvl');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler');
    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'TaskAssign.tid' => 'asc'
        )
    );
    var $paginate1 = array(
        'limit' => 2,
        'order' => array(
            'Tasksproject.pid' => 'asc'
        )
    );

    public function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    function mkdirs($dir, $mode = 0777, $recursive = true) {
        if (is_null($dir) || $dir === "") {
            return FALSE;
        }
        if (is_dir($dir) || $dir === "/") {
            return TRUE;
        }
        if (mkdirs(dirname($dir), $mode, $recursive)) {
            return mkdir($dir, $mode);
        }
        return FALSE;
    }

    public function index() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $category_tree = $this->Category->find('threaded', array('conditions' => array('status' => '1')));
        $data = $this->Category->generateTreeList("status=1 and name!=''", null, null, '');
        $leveList = $this->Category->query("Select distinct folder_level from categories where status=1 and file_req_status='1' ");

        $lvlList = array();
        foreach ($leveList as $level) {
            if ($level['categories']['folder_level'] == '0') {
                $lvlList[$level['categories']['folder_level']] = 'Level-0';
            } elseif ($level['categories']['folder_level'] == '1') {
                $lvlList[$level['categories']['folder_level']] = 'Level-1';
            }if ($level['categories']['folder_level'] == '2') {
                $lvlList[$level['categories']['folder_level']] = 'Level-2';
            }if ($level['categories']['folder_level'] == '3') {
                $lvlList[$level['categories']['folder_level']] = 'Level-3';
            }if ($level['categories']['folder_level'] == '4') {
                $lvlList[$level['categories']['folder_level']] = 'Level-4';
            }
        }


        $this->set("Folder_list", $lvlList);
        $this->set('categories', $category_tree);
    }

    public function doc_upload($val) 
    {
       // Configure::write("debug",2);
        if (!empty($val)) {
            $dt = $val;
            $_SESSION['page'] = $dt;
        } else {
            $dt = $this->Common->findpaginateLevel('19');
        }
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $incometax = $this->paginate('Documentlist');
        $this->set('Documentlist', $incometax);
    }

    public function office_gallery() {
        $id = $_GET['id'];
        $this->layout = 'employee-new';
        $incometax = $this->paginate('Documentlist');
        App::import("Model", "Documentlist");
        $model = new Documentlist();
        $gallery = $model->find('all', array('fields' => array(
                'file', 'created_date', 'document_desc'), 'conditions' => array('catagory' => $id)));
        $this->set('Documentlist', $gallery);
    }

    public function cat_gallery() {

        $this->layout = 'employee-new';
        $incometax = $this->paginate('Gallerylist');
        App::import("Model", "Gallerylist");
        $model = new Gallerylist();
        $gallery = $model->find('first', array('fields' => array(
                'cat_gallery')));
        $this->set('Gallerylist', $gallery);
    }

    function add() {
        $add_data = strtoupper($this->request->data['catagory']);
        App::import("Model", "MstCat");
        $model = new MstCat();
        $gallery = $model->find('first', array('fields' => array(
                'id', 'cat_gallery'), 'conditions' => array('id' => $add_data)
        ));
        $status = $gallery['MstCat']['cat_gallery'];
        if (!empty($this->data)) {
            $auth = $this->Session->read('Auth');
            $comp_code = $auth['User']['comp_code'];
            $emp_code = $auth['User']['emp_code'];
            $newfilename = $emp_code . date('Ymdhis') . basename($_FILES['data']['name']['files']);
            $file = "uploads/document/" . $newfilename;
            $filename = $emp_code . date('Ymdhis') . basename($_FILES['data']['name']['files']);
            $files = $_FILES['data']['tmp_name']['files'];
            $filePath = WWW_ROOT . $file;
            if (!empty($filename)) {
                move_uploaded_file($files, $filePath);
            }
            $add_data = array();
            if (!empty($this->data)) {
                $add_data['comp_code'] = $comp_code;
                $add_data['emp_code'] = $emp_code; //= $this->data['Department']['company_name'];
                $add_data['catagory'] = $this->request->data['catagory']; // = $this->data['Department']['dept_code'];
                $add_data['document_name'] = $this->request->data['doc_name']; // = $this->data['Department']['dept_name'];
                $add_data['document_desc'] = $this->request->data['Desc'];
                $add_data['open_all'] = $this->request->data['all'];
                $add_data['restricted_access'] = $this->request->data['Access'];
                $add_data['file'] = $filename;
                $add_data['created_date'] = date('Y-m-d h:i:s');
                $con = $this->Documentlist->find('count', array('conditions' => array('document_name' => $this->request->data['doc_name'])));
                if ($con > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                }
                if ($status == '1') {

                    $add_data['file'] = $filename;
                    $extension = explode(".", $filename);
                    $ext = $extension[1];
                    if (!($ext == 'jpg' || $ext == 'png')) {

                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        $this->redirect('doc_upload');
                    }
                }

                $extension = explode(".", $filename);
                $ext = $extension[1];
                if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' || $ext == 'xls')) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                    $this->redirect('doc_upload');
                } else if ($con > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {

                    if ($this->Documentlist->save($add_data)) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Data saved successfully</div>');
                        //$this->Session->setFlash('msg' => "Data saved successfully", 'true');
                        $this->redirect('doc_upload');
                    } else {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Some Error Occurred</div>');
                    }
                }


                echo $st;
                exit;
            }
        }
    }

    public function levelfolder($parentID = null) {
        $auth = $this->Session->read('Auth');
        $data = $this->Category->generateTreeList("status=1 and folder_level='" . $parentID . "' and file_req_status='1'  and name!=''", null, null, '');
        $this->set("Folder_list", $lvlList);
        $this->set("Folderlist", $data);
    }

    public function folder_container($val = null, $folderID = null) {
        $fields = array();
        if ($folderID == '4') {
            $fields = array('id', 'file', 'file_req_status', 'status');
        } else {
            $fields = array('id', 'name', 'file_req_status', 'status');
        }
        $child_Folder = array();
        $childFolder = $this->Category->children($val, true, $fields);

        foreach ($childFolder as $value) {
            if ($value['Category']['file_req_status'] == '1' && $value['Category']['status'] == '1') {
                if ($value['Category']['name'] != '') {
                    $child_Folder[$value['Category']['id']] = $value['Category']['name'];
                } else {
                    $child_Folder[$value['Category']['id']] = $value['Category']['file'];
                }
            }
        }
        $child_Folder[''] = '--Please Select--';
        ksort($child_Folder);
        $folderID = $folderID + 1;
        $this->set(compact('val', 'folderID', 'child_Folder'));
    }

    public function createFolder() {
        $type = $this->request->data['type'];
        if ($type == '0') {
            $level = $this->request->data['level'] + 1;
            $data['Category']['parent_id'] = $this->request->data['folder'];
            $data['Category']['folder_level'] = $level;
            $data['Category']['name'] = $this->request->data['fname'];
            $data['Category']['remark'] = $this->request->data['remark'];
            $data['Category']['doc_reference_num'] = "PSC" . $this->randNumber();
            $parents = $this->Category->getPath($this->request->data['folder']);
            $NewFolder = $this->request->data['fname'];
            $chk_Fld = $this->Category->find('first', array('fields' => array('name'), 'conditions' => array('status' => '1', 'name' => $NewFolder)));
            $path = '';
            foreach ($parents as $fullpath) {
                $path .= $fullpath['Category']['name'] . DS;
            }
            $folderPath = WWW_ROOT . $path . $NewFolder;
            if (!is_dir($folderPath)) {
                $success = $this->Category->save($data);
                if ($success) {
                    mkdir($folderPath, $mode = 0777);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>File Created Successfully !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, file not created !</div>');
                }
            } else {
                $existFld = $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, this file name is already used !</div>');
            }
                } elseif ($type == '1') {
            $invl = '0';
            $counter = count($this->request->data['upl_doc']);
            for ($i = 0; $i < $counter; $i++) {
                $FILE_UPNAME = substr($this->request->data['upl_doc'][$i]['name'], 0, -4);

                $filecheck = basename($this->request->data['upl_doc'][$i]['name']);
                $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                $file__name = $FILE_UPNAME . "-" . date("dmYHis") . "." . $ext;
                $filename = str_replace(" ", "", $file__name);

                $data['Category']['parent_id'] = $this->request->data['folder'];
                $data['Category']['file'] = $filename;
                $data['Category']['remark'] = $this->request->data['remark'];
                $data['Category']['reference_letter'] = $this->request->data['ref_let'];
                $data['Category']['source_of_origin'] = $this->request->data['origin'];
                $data['Category']['ministry_id'] = $this->request->data['ministry'];
                $data['Category']['date_of_letter'] = date("Y-m-d", strtotime($this->request->data['dol']));
                $data['Category']['doc_receiving_date'] = date("Y-m-d", strtotime($this->request->data['dor']));
                $data['Category']['file_alias_name'] = $this->request->data['falias'];

                if (isset($this->request->data['public_doc']) && $this->request->data['public_doc'] == '1') {
                    $data['Category']['public_doc'] = $this->request->data['public_doc'];
                }
                $parents = $this->Category->getPath($this->request->data['folder']);
                $path = '';
                foreach ($parents as $fullpath) {
                    $path .= $fullpath['Category']['name'] . DS;
                }

                $filePath = WWW_ROOT . $path . $filename;
                $data['Category']['doc_reference_num'] = $path . $filename;

                if (!is_file($filePath)) {

                    if (!($ext == 'txt' || $ext == 'jpg' || $ext == 'png' || $ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'odt' || $ext == 'xls' || $ext == 'xlsx') || ($file_up['size'] > 15728640)) {
                        $InvalidFiles .= $FILE_UPNAME . ",";
                        $invl = '1';
                    } else {
                        if (move_uploaded_file($this->request->data['upl_doc'][$i]['tmp_name'], $filePath)) {
                            $this->Category->create();
                            $success_upld = $this->Category->save($data);
                        }
                    }
                    if ($invl == '0') {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mail Submited Successfully !</div>');
                    } elseif ($invl == '1') {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mail Details Submited Successfully, This is invalid file [<font color="red">' . $InvalidFiles . $invl . '</font>] Only !</div>');
                    }
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this file is already exist!</div>');
                }
            }
        }
        $this->redirect('index');
    }

    function deletezip($foldername, $zipname) {
        echo $zip_path = $foldername . '/' . $zipname;
        unlink($zip_path);
        $this->redirect('request_view');
    }

    function dwnld($id) {

        $zip_name = "pscdoczip" . time() . ".zip"; // Zip name
        $parents = $this->Category->getPath($id);
        foreach ($parents as $fullpath) {
            $srcDir .= $fullpath['Category']['name'] . DS;
        }
        $files = scandir($srcDir);

        unset($files[0], $files[1]);
        foreach ($files as $file) {
            $zip->addFile($srcDir . $file, $file);
        }
        $zip->close();
        echo "PSC/" . $zip_name;
        die();
    }



    public function fields($val = null) {
        //$this->layout = 'employee-new';
        $this->set('val', $val);
    }

    public function doc_edit($docID = null) {
        if (isset($this->request->data['submit']) && $this->request->data['docid'] != '') {

            $id = $this->request->data['docid'];
            $fname = $this->request->data['fname'];
            $remark = $this->request->data['remark'];
            $success = $this->Category->updateAll(array('name' => "'$fname'", 'remark' => "'$remark'"), array('id' => $id));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>File has been modified successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, file has not been modified!</div>');
            }
            $this->redirect('currentfolder/' . $this->request->data['parentID']);
        }
        $data = $this->Category->find('first', array('conditions' => array('id' => $docID)));
        $treeData = $this->Category->generateTreeList(null, null, null, '');
        $folder_filter = array_filter($treeData);
        $removElement[] = $data['Category']['name'];
        $allFolders = array_diff($folder_filter, $removElement);
        $this->set("Folderlist", $allFolders);
        $this->set('data', $data);
    }

    public function file_return($docID = null, $reqID = null) {
        $req_ID = $this->DocumentRequest->find('first', array('conditions' => array('DocumentRequest.id' => $reqID)));
        $data = $this->Category->find('first', array('conditions' => array('id' => $docID)));
        $parent_id = $data['Category']['parent_id'];
        $this->set('parent_id', $parent_id);
        $this->set('reqID', $reqID);
        $this->set('docID', $docID);
    }

    public function file_forward($docID = null, $reqID = null) {
        $auth = $this->Session->read('Auth');
        if (isset($this->request->data['users'])) {
            $current_user = $auth['MyProfile']['id'];

            $userID = $this->request->data['users'];
            $reqID = $this->request->data['docs']['reqID'];
            $docID = $this->request->data['docs']['docID'];
            $reqData['request_receive_id'] = $this->request->data['docs']['reqID'];
            $reqData['req_receive_by'] = $this->request->data['users'];
            $reqData['req_forward_by'] = $auth['MyProfile']['id'];
            $reqData['frwd_status'] = '0';
            $success = $this->DocumentReceiveRequestForward->updateAll(array('DocumentReceiveRequestForward.frwd_status' => "'1'"), array('DocumentReceiveRequestForward.request_receive_id' => $reqID));
            $success2 = $this->DocumentRequest->updateAll(array('DocumentRequest.req_status' => "'5'"), array('DocumentRequest.id' => $reqID));
            $Savesuccess = $this->DocumentReceiveRequestForward->save($reqData);
            if ($success) {

                $From = "megha.yadav@essindia.com";
                $UserMailID = "rohan.arora@essindia.com"; //// make it comment when going live....
                $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....
                $To = $UserMailID;
                $sub = "Document Request Received!";
                $msg = "You received a request of document!";
                $template = 'rms_notification';
                $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>File Forwarded Successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, File not Forwarded !</div>');
            }
            $this->redirect('request_view');
        }




        $req_ID = $this->DocumentRequest->find('first', array('conditions' => array('DocumentRequest.id' => $reqID)));
        // $reqID = $req_ID['DocumentRequest']['id'];
        $data = $this->Category->find('first', array('conditions' => array('id' => $docID)));
        $parent_id = $data['Category']['parent_id'];
        $this->set('parent_id', $parent_id);
        $this->set('reqID', $reqID);
        $this->set('currentuser', $auth['MyProfile']['id']);
        $this->set('docID', $docID);
    }

    public function request_details($id) {
        $reqDetails = $this->DocumentRequest->find('all', array(
            'conditions' => array('DocumentRequest.id' => $id),
        ));
        $this->set("reqDetails", $reqDetails);
    }

    public function file_reject($docID = null, $reqID = null) {
        if (isset($this->request->data['reason'])) {
            $reason = $this->request->data['reason'];
            $reqID = $this->request->data['docs']['reqID'];
            $docID = $this->request->data['docs']['docID'];

            $success = $this->DocumentRequest->updateAll(array('DocumentRequest.req_status' => "'4'", 'DocumentRequest.reason' => "'$reason'"), array('DocumentRequest.id' => $reqID));
            $success_update = $this->Category->updateAll(array('file_req_status' => '1'), array('id' => $docID));
            if ($success) {

                $From = "megha.yadav@essindia.com";
                $UserMailID = "rohan.arora@essindia.com"; //// make it comment when going live....
                $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....

                $To = $UserMailID;
                $sub = "Document Request Rejected!";
                $msg = "Now, Your document's request has been rejected !";
                $template = 'rms_notification';
                $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Request Rejected Successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Request not Rejected!</div>');
            }
            $this->redirect('request_view');
        }


        $req_ID = $this->DocumentRequest->find('first', array('conditions' => array('DocumentRequest.id' => $reqID)));
        // $reqID = $req_ID['DocumentRequest']['id'];
        $data = $this->Category->find('first', array('conditions' => array('id' => $docID)));
        $parent_id = $data['Category']['parent_id'];

        $this->set('parent_id', $parent_id);
        $this->set('reqID', $reqID);
        $this->set('docID', $docID);
    }

    public function test() {
        
    }

    public function randNumber() {

        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
        die;
    }

    public function currentfolder($id) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $allChildren = $this->Category->children($id, $direct = true);
        $bredcrum = $this->Category->getPath($id);
        $this->set("allChildren", $allChildren);
        $this->set("bredcrum", $bredcrum);
    }

    public function request_view($process = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $currentUser = $auth['MyProfile']['id'];

        if ($this->Common->check_access_right($this->Auth->User('emp_code'), $this->Auth->User('comp_code'), 'doc_module', 'approval')) {
            $accessUser = $this->Auth->User('id');
        } else {
            $accessUser = "";
        }

        // echo $currentUser."===".$accessUser;

        if ($currentUser == $accessUser && ($process != '' && $process != '3')) {
            $cond = "req_status = '1' OR req_status != '3'";
        } elseif ($currentUser == $accessUser && ($process != '' && $process == '3')) {
            $cond = "req_status  = 3";
        } elseif (($currentUser == $accessUser) && ($process == '')) {
            $cond = "req_status  = '1' OR req_status = '2' OR req_status = '4'  OR req_status = '5'";
        } elseif (($currentUser != $accessUser && $process == '')) {
            $cond = "DocumentRequest.user_id = '" . $currentUser . "' OR (req_status  = '1' OR req_status = '2' OR req_status = '3' OR req_status = '4'  OR req_status = '5')";
            //$cond = "req_status = '3' OR req_status = '5'";
        }


        $data = $this->DocumentRequest->find('all', array('conditions' => array($cond)));

        $i = 0;
//        echo "<pre>";
//        print_r($data);die;
        foreach ($data as $rec) {


            $parentid[] = $this->Category->getParentNode($rec['DocumentRequest']['document_id']);
            $data[$i]['DocumentRequest']['desg_code'] = $auth['MyProfile']['desg_code'];
            $data[$i]['DocumentRequest']['emp_code'] = $auth['MyProfile']['emp_code'];
            $data[$i]['DocumentRequest']['comp_code'] = $auth['User']['comp_code'];
            $data[$i]['DocumentRequest']['emp_full_name'] = $auth['MyProfile']['emp_full_name'];
            $i++;
        }

        foreach ($parentid as $recd) {
            $bredcrum[] = $this->Category->getPath($recd['Category']['id']);
        }
        $this->set('bredcrum', $bredcrum);
        $this->set('data', $data);
        $this->set('recordUnit', $accessUser);
        $this->set('currentUser', $currentUser);
        $this->set('process', $process);
    }

    public function public_doc() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $publicFile = $this->Category->find('all', array('conditions' => array('status' => '1', 'public_doc' => '1')));
        $this->set(compact('publicFile'));
    }

    public function public_doclist($doc) {
        $id = $this->params['url']['id'];
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $dt = $this->Common->findpaginateLevel('19');
        $doclist = $this->Documentlist->find('all', array('conditions' => array('Catagory' => $id), 'limit' => $dt));

        $this->set(compact('doclist'));
    }

    public function request_complete() {
        if ($this->request->data['upl_doc'] != '') {
            $ManuleFilesByRequester = $this->request->data['upl_doc'];
        } else {
            $ManuleFilesByRequester = '';
        }
        $reqID = $this->request->data['docs']['reqID'];
        $docID = $this->request->data['docs']['docID'];
        $success = $this->DocumentRequest->updateAll(array('DocumentRequest.req_status' => "'3'", 'DocumentRequest.manual_files_byRequester' => "'$ManuleFilesByRequester'"), array('DocumentRequest.id' => $reqID));
        $success_update = $this->Category->updateAll(array('file_req_status' => '1'), array('id' => $docID));
        if ($success) {

            $From = "megha.yadav@essindia.com";
            $UserMailID = "rohan.arora@essindia.com"; //// make it comment when going live....
            $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....

            $To = $UserMailID;
            $sub = "Document Request Completed!";
            $msg = "You received a requested document, please check!";
            $template = 'rms_notification';

            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);


            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>File Send to RMS Successfully!</div>');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, File not sent !</div>');
        }
        $this->redirect('request_view');
    }

    public function fileremark($docid) {
        $success = $this->DocumentRequest->updateAll(array('DocumentRequest.req_status' => '2', 'DocumentRequest.file_receive_date' => 'now()'), array('DocumentRequest.id' => $docid));
        if ($success) {

            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>File Forwarded Successfully!</div>');
        }
        $this->redirect('request_view');
    }

    public function delete($id = null) {
        $this->Documentlist->id = $id;

        if (!$this->Documentlist->exists()) {
            throw new NotFoundException(__('Invalid Document'));
        }
        // $this->request->allowMethod('post', 'delete');
        if ($this->Documentlist->delete($this->Documentlist->id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The Document has been deleted!!</div>');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster could not be deleted. Please, try again!!</div>');
        }
        return $this->redirect(array('action' => 'doc_upload'));
    }

    public function docDelete($id) {
        //Configure::write('debug',2);
        $parentID = $this->Category->getParentNode($id);
        $par_id = $parentID['Category']['id'];
        $ChildExist = $this->Category->children($id, $direct = true);

        $chk_Fld = $this->Category->find('first', array('fields' => array('name', 'file'), 'conditions' => array('status' => '1', 'id' => $id)));

        $flag = '0';
        foreach ($ChildExist as $val) {
            if ($val['Category']['status'] == '1') {
                $flag = '1';
            }
        }

        if (!empty($ChildExist)) {
            $Element = 'File';
        } else {
            $Element = 'Mail';
        }
        if ($flag == '0') {
            $success = $this->Category->updateAll(array('status' => "'0'"), array('id' => $id));
            if ($success) {

                echo $OldFolder = $chk_Fld['Category']['name'];
                echo $OldFile = $chk_Fld['Category']['file'];
                $parents = $this->Category->getPath($par_id);
                $path = '';
                foreach ($parents as $fullpath) {
                    $path .= $fullpath['Category']['name'] . DS;
                }

                if ($OldFolder != '') {
                    $folderPath = WWW_ROOT . $path . $OldFolder;
                    $dir = new Folder($folderPath);
                    $dir->delete();
                }

                if ($OldFile != '') {
                    $filePath = WWW_ROOT . $path . $OldFile;
                    $file = new File($filePath, false, 0777);
                    if ($file->delete()) {
                        echo "file deleted";
                    }
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>' . $Element . ' Deleted Successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, ' . $Element . ' not Deleted !</div>');
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is sub files and mails exist please remove them !</div>');
        }
        $this->redirect('currentfolder/' . $par_id);
    }

    public function request_raise() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        if (isset($this->request->data['submit'])) {
            $auth = $this->Session->read('Auth');
            $rec = $this->Common->findDocByRefno($this->request->data['folderName4']);
            $ReqNum = "REQ" . $this->randNumber();
            $manualFiles = $this->request->data['manualfiles'];
            $reqData['user_id'] = $auth['MyProfile']['id'];
            $reqData['document_id'] = $rec['Category']['id'];
            $reqData['request_num'] = $ReqNum;
            $reqData['file_ref_num'] = $rec['Category']['doc_reference_num'];
            $reqData['remark'] = $this->request->data['reason'];
            $reqData['file_name'] = $rec['Category']['name'];
            $reqData['manual_files'] = $manualFiles;

            $success = $this->DocumentRequest->save($reqData);
            if ($success) {

                $From = "megha.yadav@essindia.com";
                $UserMailID = "rohan.arora@essindia.com"; //// make it comment when going live....
                $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....

                $To = $UserMailID;
                $CC = $ManagerMailID;
//                $CC = "";
                $sub = "Document Request Raised!";
                $msg = "Now, Your document's request has been genrated !";
                $template = 'rms_notification';

                $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);



                $success_update = $this->Category->updateAll(array('file_req_status' => '2'), array('id' => $rec['Category']['id']));
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>File request Submited Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Request is not matched !</div>');
            }
            $this->redirect('request_raise');
        }


        /*
         * Get the record for frontend form.
         */


        $leveList = $this->Category->query("Select distinct folder_level from categories where status=1 and folder_level is not null ");
//        echo "<pre>";
//        print_r($leveList);

        $listcount = count($leveList);
        $lvlList = array();
        $rootfile = array();
        foreach ($leveList as $level) {
            if ($level['categories']['folder_level'] == '0') {
                $lvlList[$level['categories']['folder_level']] = 'Level-0';
                $rootfile['1'] = 'PSC';
            } elseif ($level['categories']['folder_level'] == '1') {
                $lvlList[$level['categories']['folder_level']] = 'Level-1';
            }if ($level['categories']['folder_level'] == '2') {
                $lvlList[$level['categories']['folder_level']] = 'Level-2';
            }if ($level['categories']['folder_level'] == '3') {
                $lvlList[$level['categories']['folder_level']] = 'Level-3';
            }if ($level['categories']['folder_level'] == '4') {
                $lvlList[$level['categories']['folder_level']] = 'Level-4';
            }
        }


//        $this->set("listcount", $listcount);
//        $this->set("Folder_list", $lvlList);



        $fileRef = $this->Category->find('list', array(
            'fields' => array('id', 'name'),
            'conditions' => array('status' => '1', 'name !=' => null, 'file_req_status' => '1')
        ));
        $fileName = $this->Category->find('list', array(
            'fields' => array('id', 'file'),
            'conditions' => array('status ' => '1', 'file !=' => null, 'file_req_status' => '1')
        ));




        $this->set(compact('listcount', 'lvlList', 'fileName', 'fileRef', 'rootfile'));
    }

    public function advance_search() {
        $this->layout = 'employee-new';
    }

    public function mail_received_listing($frwdTo) {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $frwdTo = base64_decode($frwdTo);
        $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.notify' => '0'), array('MailOffice.forward_to' => $frwdTo));
        $this->paginate = array(
            'conditions' => array('MailOffice.status' => '0', 'MailOffice.forward_to' => $frwdTo),
            'limit' => 10,
            'order' => array(
                'MailOffice.id' => 'desc'
            )
        );


        $this->set('ar', $this->paginate($this->MailOffice));
    }

    public function mail_office_ceo_received() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.notify' => '0'), array('MailOffice.forward_to' => '2'));


        $ORconditions1['MailOffice.forward_to'] = '2';
        $ORconditions2['MailOffice.forward_to'] = '3';
        $ORconditions3['MailOffice.forward_to'] = '4';

        $conditions = array('MailOffice.status' => '0',
            'OR' => array($ORconditions1, $ORconditions2, $ORconditions3)
        );

        $this->paginate = array(
            'conditions' => array($conditions),
            'limit' => 10,
            'order' => array(
                'MailOffice.id' => 'desc'
            )
        );




        $this->set('ar', $this->paginate($this->MailOffice));
        $this->set(compact('Repot_attach'));
    }

    public function mail_office() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $this->paginate = array(
            'conditions' => array('MailOffice.status' => '0'),
            'limit' => 10,
            'order' => 'MailOffice.id desc'
        );

        $this->set('ar', $this->paginate($this->MailOffice));
        $this->set(compact('Repot_attach'));
    }

    public function mail_office_save() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            $UPLOAD_FILES = $this->request->data['upl_doc'];
            $data['MailOffice']['serial_no'] = $this->request->data['serial_no'];
            $data['MailOffice']['receive_from'] = $this->request->data['rec_from'];
            $data['MailOffice']['reference'] = $this->request->data['reference'];
            $data['MailOffice']['receiving_date'] = date("Y-m-d", strtotime($this->request->data['dor']));
            $data['MailOffice']['subject'] = $this->request->data['subject'];
            $data['MailOffice']['remark'] = $this->request->data['remark'];
            $data['MailOffice']['created_by'] = $auth['MyProfile']['id'];

            $success = $this->MailOffice->save($data);
            $FileAttachID = $this->MailOffice->getLastInsertID();

            $invl = '0';
            if ($success) {
                if (!empty($UPLOAD_FILES)) {
                    $Dir = WWW_ROOT . 'mail_office';
                    $Path = new Folder($Dir);
                    foreach ($UPLOAD_FILES as $file_up) {
                        $FILE_UPNAME = str_replace(".", "", substr($file_up['name'], 0, -4));
                        $filecheck = basename($file_up['name']);
                        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                        $file__name = $FILE_UPNAME . "-" . date("dmYHis") . "." . $ext;
                        $FILE_NAME = str_replace(" ", "", $file__name);
                        $FILE_PATH = WWW_ROOT . 'mail_office' . DS . $FILE_NAME;
                        chmod($FILE_PATH, 0777);
                        if (!is_file($FILE_PATH)) {
                            $filecheck = basename($FILE_NAME);
                            $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));

                            if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx') || ($file_up['size'] > 2048000)) {
                                $InvalidFiles .= $file_up['name'] . ",";
                                $invl = '1';
                            } else {
                                if (move_uploaded_file($file_up['tmp_name'], $FILE_PATH)) {
                                    $File_Data['MailOfficeAttachFiles']['mail_office_id'] = $FileAttachID;
                                    $File_Data['MailOfficeAttachFiles']['attach_file'] = $FILE_NAME;
                                    // $File_Data['MailOfficeAttachFiles']['folder_name'] = $DirName;
                                    $this->MailOfficeAttachFiles->create();
                                    $success_upld = $this->MailOfficeAttachFiles->save($File_Data);
                                }
                            }
                        }
                    }
                }
            }
            if ($invl == '0') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mail details entered successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mail details entered successfully!, This is invalid file [<font color=' . red . '>' . $InvalidFiles . '</font>] Only !</div>');
            }
            $this->redirect('mail_office');
        }




        $lastId = $this->MailOffice->find('first', array('fields' => array('id', 'serial_no'),
            'conditions' => array('status' => '0'),
            'order' => array('id' => 'DESC')
        ));


        /////////If Year change then serial no. start from 1//////////////

        $lastSerialNo = substr($lastId['MailOffice']['serial_no'], 12);
        $slNo = explode("/", $lastId['MailOffice']['serial_no']);
        $lastSerialYear = $slNo['1'];
        if (date('Y') > $lastSerialYear) {
            $lastSerialNo = 0;
        }

        if (count($lastId) == 0) {
            $lastId = 1;
        } else {
            $lastId = ($lastSerialNo + 1);
        }
        $this->set('SerialNo', 'PSC-' . date('m/Y') . '/' . str_pad($lastId, 5, '0', STR_PAD_LEFT));
    }

    public function mail_office_update($MailOfficeID = null, $Detail = null) {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $MailOfficeID = base64_decode($MailOfficeID);


        if ($Detail != '') {
            if ($Detail == 'del') {
                $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.status' => '1'), array('MailOffice.id' => $MailOfficeID));
                if ($Detsuccess) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted  !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record Not Deleted !</div>');
                }
            } elseif ($Detail == 'rms') {
                $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.forward_to' => '1', 'MailOffice.notify' => '1'), array('MailOffice.id' => $MailOfficeID));
                if ($Detsuccess) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record forwarded to RMS!</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record Not Forwarded !</div>');
                }
            } elseif ($Detail == 'ceo') {
                $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.forward_to' => '2', 'MailOffice.notify' => '1'), array('MailOffice.id' => $MailOfficeID));
                if ($Detsuccess) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record forwarded to CEO !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record Not Forwarded !</div>');
                }
            } elseif ($Detail == 'bms') {
                $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.forward_to' => '3', 'MailOffice.notify' => '1'), array('MailOffice.id' => $MailOfficeID));
                if ($Detsuccess) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record forwarded to Board Management !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Recored Not Forwarded !</div>');
                }
                $this->redirect('mail_office_ceo_received');
            } elseif ($Detail == 'dir') {
                $Detsuccess = $this->MailOffice->updateAll(array('MailOffice.forward_to' => '4', 'MailOffice.notify' => '1'), array('MailOffice.id' => $MailOfficeID));
                if ($Detsuccess) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record forwarded to Directorate !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record Not Forwarded !</div>');
                }
                $this->redirect('mail_office_ceo_received');
            }

            $this->redirect('mail_office');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            $UPLOAD_FILES = $this->request->data['upl_doc'];
            $counter = $this->MailOfficeAttachFiles->find('count', array(
                'conditions' => array('MailOfficeAttachFiles.mail_office_id' => $this->request->data['reportid'], 'MailOfficeAttachFiles.status' => '0')));
            if ($counter == '0' && $UPLOAD_FILES['0']['name'] == '') {

                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Please upload at least one file!</div>');

                $this->redirect('mail_office_update/' . base64_encode($this->request->data['reportid']));
            }
            $data['MailOffice']['id'] = $this->request->data['reportid'];
            $data['MailOffice']['serial_no'] = $this->request->data['serial_no'];
            $data['MailOffice']['receive_from'] = $this->request->data['rec_from'];
            $data['MailOffice']['reference'] = $this->request->data['reference'];
            $data['MailOffice']['receiving_date'] = date("Y-m-d", strtotime($this->request->data['dor']));
            $data['MailOffice']['subject'] = $this->request->data['subject'];
            $data['MailOffice']['remark'] = $this->request->data['remark'];
            $data['MailOffice']['created_by'] = $auth['MyProfile']['id'];
            $success = $this->MailOffice->save($data);
            $FileAttachID = $this->request->data['reportid'];
            $invl = '0';
            if ($success) {
                if (!empty($UPLOAD_FILES) && $UPLOAD_FILES['0']['name'] != '') {
                    $Dir = WWW_ROOT . 'mail_office';
                    $Path = new Folder($Dir);
                    foreach ($UPLOAD_FILES as $file_up) {
                        $FILE_UPNAME = str_replace(".", "", substr($file_up['name'], 0, -4));
                        $filecheck = basename($file_up['name']);
                        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                        $file__name = $FILE_UPNAME . "-" . date("dmYHis") . "." . $ext;
                        $FILE_NAME = str_replace(" ", "", $file__name);
                        $FILE_PATH = WWW_ROOT . 'mail_office' . DS . $FILE_NAME;
                        chmod($FILE_PATH, 0777);
                        if (!is_file($FILE_PATH)) {
                            $filecheck = basename($FILE_NAME);
                            $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));

                            if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'wmv' || $ext == 'doc' || $ext == 'docx') || ($file_up['size'] > 2048000)) {
                                $InvalidFiles .= $file_up['name'] . ",";
                                $invl = '1';
                            } else {
                                if (move_uploaded_file($file_up['tmp_name'], $FILE_PATH)) {
                                    $File_Data['MailOfficeAttachFiles']['mail_office_id'] = $FileAttachID;
                                    $File_Data['MailOfficeAttachFiles']['attach_file'] = $FILE_NAME;
                                    $this->MailOfficeAttachFiles->create();
                                    $success_upld = $this->MailOfficeAttachFiles->save($File_Data);
                                }
                            }
                        }
                    }
                }
            }
            if ($invl == '0') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Record Modified Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Record Modified Successfully, This is invalid file [<font color=' . red . '>' . $InvalidFiles . '</font>] Only !</div>');
            }
            $this->redirect('mail_office');
        }
        $MailOfficeDet = $this->MailOffice->find('first', array('conditions' => array('MailOffice.id' => $MailOfficeID)));
        $this->set(compact('MailOfficeDet'));
    }

    public function mail_office_file_remove($ReportId = null, $fileID = null) {
        $fileID = base64_decode($fileID);
        $counter = $this->MailOfficeAttachFiles->find('count', array(
            'conditions' => array('MailOfficeAttachFiles.mail_office_id' => $ReportId, 'MailOfficeAttachFiles.status' => '0')));
        if ($counter <= '1') {

            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Please upload at least one Mail!</div>');

            $this->redirect('mail_office_update/' . $ReportId);
        }

        $Delsuccess = $this->MailOfficeAttachFiles->updateAll(array('MailOfficeAttachFiles.status' => '1'), array('MailOfficeAttachFiles.id' => $fileID));
        if ($Delsuccess) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Mail Deleted  !</div>');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Mail Not Deleted !</div>');
        }
        $this->redirect('mail_office_update/' . $ReportId);
    }

    public function report_attach_files($ReportAttachID) {
        //Configure::write('debug',2);
        $Allfiles = $this->MailOfficeAttachFiles->find('all', array('conditions' => array('MailOfficeAttachFiles.mail_office_id' => $ReportAttachID, 'MailOfficeAttachFiles.status' => '0')));

        $this->set('Allfiles', $Allfiles);
    }

    public function download_mailoffice($id) {
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $Compliants = $this->MailOfficeAttachFiles->find('all', array(
            'conditions' => array('MailOfficeAttachFiles.id' => $id, 'MailOfficeAttachFiles.status' => '0'),
        ));
        $DirName = "mail_office";
        $fileName = $Compliants[0]['MailOfficeAttachFiles']['attach_file'];
        $path = WWW_ROOT . $DirName . DS;
        $fullPath = $path . $fileName;
        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            if ($ext) {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
            }
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while (!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose($fd);
        die;
    }

    public function downloadMailoffice($id) {
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $Dir_Name = $this->MailOfficeAttachFiles->find('first', array('conditions' => array('id' => $id, 'status' => '0')));
        $DirName = "mail_office";
        $fileName = "Penguins-15092017094313.jpg"; //$Dir_Name['MailOfficeAttachFiles']['attach_file'];
        $path = WWW_ROOT . $DirName . DS;
        $fullPath = $path . $fileName;
        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            if ($ext) {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
            }

            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while (!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose($fd);
        die;
    }

}
?>
 









