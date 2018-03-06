<?php
class WfDtAppMapLvl extends AppModel{
	
	public  $useDbConfig = 'default';
    public  $name = 'WfDtAppMapLvl'; 
    public  $useTable = 'wf_dt_app_map_lvl';
    public  $primaryKey = 'wf_id';	

    public  $belongsTo = array(
        'RevokeLevelDetails' => array(
            'className' => 'WfDtAppMapLvl',
            'foreignKey' => 'revoke_level_id'
        ),
        'ApplicationDetails' => array(
            'className' => 'Applications',
            'foreignKey' => 'wf_app_map_lvl_id'
        )
    );
}
?>