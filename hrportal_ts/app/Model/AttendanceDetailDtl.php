<?php

App::uses('AppModel', 'Model');

class AttendanceDetailDtl extends AppModel {

    var $useDbConfig = 'ora';
    public $useTable = 'HCM$TIME$MOVE$EDIT$DTL';

}
