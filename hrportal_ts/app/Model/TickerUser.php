<?php
App::uses('AppModel', 'Model');
class TickerUser extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'tickerUser';
    var $primaryKey = 'id';
    var $useTable = 'ticker_user';
    var $belongsTo = array(
        'Ticker' => array(
            'className' => 'Ticker',
            'foreignKey' => 'ticker_id',
            
        ),
        'MyProfile' => array(
            'className' => 'MyProfile',
            'foreignKey' => 'myprofile_id',
           
        ),
        
    );

}