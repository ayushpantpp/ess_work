<?php
class Empcomplaint extends AppModel {
    var $useDbConfig = 'makess';
    var $name = 'hd_emp_complain';
    var $useTable='hd_emp_complain';
    var $primaryKey = 'vc_complain_no';
    var $recursive = 2;
    var $belongsTo = array(
                    'Projects' => array(
                            'className' => 'Projects',
                            'foreignKey' => 'nu_project_code',
                            'conditions' => '',
                            'fields' => '',
                            'order' => ''
                    ),        
    );
    var $hasMany = array(
                    'Complain_Annotation' => array(
                            'className' => 'EmpcomplaintAnnotations',
                            'foreignKey' => 'vc_complain_no',
                            'conditions' => '',
                            'fields' => '',
                            'order' => '',
                    ),
    );
    var $hasOne = array(
                    'Complain_Employee' => array(
                            'className' => 'ComplainEmployees',
                            'foreignKey' => 'vc_complain_no',
                            'conditions' => '',
                            'fields' => '',
                            'order' => ''
                    ),
    );
    var $validate = array(
            'vc_default_comp' => array(
                'rule1' => array(
                        'rule' => 'numeric',
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter numeric value.'
                ),
                'rule2' => array(
                        'rule' => array('between', 1, 2),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 and 2 characters.'
                ),                
            ),
            'vc_comp_code' => array(
                'rule1' => array(
                        'rule' => 'numeric',
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter numeric value'
                ),
                'rule2' => array(
                        'rule' => array('between', 1, 2),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 and 2 characters.'
                ),                
            ),
            'vc_complain_no' => array(
                'rule1' => array(
                        'rule' => 'alphaNumeric',
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter alpha numeric characters only.'
                ),
                'rule2' => array(
                        'rule' => array('between', 1, 16),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 and 16 characters.'
                ),                
            ),
            'dt_complain_date' => array(
                'rule1' => array(
                        'rule' => 'date',
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Please supply a valid date and time in YYYY-MM-DD HH:mm:ss format.'
                ),                
            ),
            'vc_desc' => array(
                'rule1' => array(
                        'rule' => array('between', 1, 1000),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 and 1000 characters.'
                ),                
            ),
            'vc_user_code' => array(
                'rule1' => array(
                        'rule' => 'numeric',
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Must be Numeric.'
                ),
                'rule2' => array(
                        'rule' => array('between', 1, 6),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 and 6 characters.'
                ),                
            ),
            'vc_logged_by' => array(
                'rule1' => array(
                        'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter alpha numeric characters only.'
                ),
                'rule2' => array(
                        'rule' => array('between', 1, 150),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 and 150 characters.'
                ),                
            ),
            /*'vc_type' => array(),
            'vc_stage' => array(),*/
            'vc_priority' => array(                
                'rule1' => array(
                        'rule' => array('inList',array('High','Medium','Low')),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Select between High, Medium, Low.'
                ),
            ),/*
            'dt_expected_closure' => array(),
            'dt_real_closure' => array(),
            'vc_owner' => array(),
            'vc_feedback' => array(),
            'vc_cc_remarks' => array(),
            'vc_cm_remarks' => array(),
            'vc_emp_code' => array(),
            'vc_pm_code' => array(),
            'vc_cm_code' => array(),
            'nu_complaint_id' => array(),
            'nu_dt_complaint_id' => array(),
            'dt_problem_date' => array(),
            'vc_os_version' => array(),   
            'ch_location_flag' => array(),
            'vc_jvm_version' => array(),
            'ch_machine_flag' => array(),
            'vc_jvm_path' => array(),
            'ch_message_flag' => array(),
            'vc_jar_path' => array(),
            'ch_update_flag' => array(),
            'vc_browser_version' => array(),
            'ch_popup_flag' => array(),
            'vc_popup_desc' => array(),
            'vc_problem_source' => array(),
            'vc_menu_option' => array(),
            'vc_error_message_type' => array(),
            'vc_error_message_desc' => array(),
            'vc_c_drive_space' => array(),
            'vc_d_drive_space' => array(),
            'vc_ram_size' => array(),
            'nu_initial_time' => array(),
            'nu_final_time' => array(),
            'ch_field_flag' => array(),
            'ch_period_flag' => array(),
            'vc_correct_val' => array(),
            'vc_error_val' => array(),
            'ch_module_flag' => array(),
            'vc_module_name' => array(),
            'ch_option_flag' => array(),
            'vc_option_name' => array(),
            'vc_image_path' => array(),*/
            'vc_email' => array(
                'rule1' => array(
                        'rule' => 'email',
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter valid email.'
                ),
                'rule2' => array(
                        'rule' => array('between', 1, 150),
                        'required' => true,
                        'allowEmpty' => false,                    
                        'message' => 'Enter between 1 to 150 characters only.'
                ),                
            ),
			'vc_nature' => array(
					'rule1' => array(
							'rule' => array('inList', array('Bug', 'Requirement', 'Support')),
							'required' => false,
							'allowEmpty' => true,                    
							'message' => 'Select between Bug, Requirement and Support.'
					)
			)
            /*'vc_manhours' => array(),
            'vc_contact_no' => array()*/
            );
}