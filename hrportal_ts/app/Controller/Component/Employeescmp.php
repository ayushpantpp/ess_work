<?php

	class EmployeescmpComponent extends Component {

var $uses = array('General');
	function initialize(&$controller) {
 
		//load required for component models
		if ($this->uses !== false) {
			foreach($this->uses as $modelClass) {
				$controller->loadModel($modelClass);
				$this->$modelClass = $controller->$modelClass;
			}
		}
 
	}
        function getTreeJson($id='') {
                            if ($id=="")
                                $sql = "SELECT vc_emp_name, vc_emp_code FROM HRPAY.persdet WHERE VC_EMP_CODE='196' ORDER BY VC_EMP_NAME";
                            else
                                $sql = "SELECT vc_emp_name, vc_emp_code FROM HRPAY.persdet WHERE VC_REP_TO='".$id."' ORDER BY VC_EMP_NAME";
                            $result = $this->General->query($sql);
                            $data="[";
                            foreach($result as &$row){
                                if ($data != "[") $data = $data . ',';
                                $data = $data . '{';
                                $relation_name = 'engineer';
                                $children = $this->getTreeJson($row[0]['vc_emp_code']);
                                if ($children != "[]") $relation_name = 'manager';
                                $data = $data . '"data" : "'.ucwords(strtolower($row[0]['vc_emp_name']))."[".$row[0]['vc_emp_code']."]".'","attr" : { "id" : "'.$row[0]['vc_emp_code'].'", "rel" : "'.$relation_name.'" }';
                                if ($children != "[]") $data = $data . ', "children" : '.$children;
                                $data = $data . '}';
                            }
                            $data = $data . ']';
                            return $data;
        }
}