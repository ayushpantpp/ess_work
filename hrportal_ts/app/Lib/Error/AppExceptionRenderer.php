<?php

App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {

    public function notFound($error) {
        //echo "aaaaaa"; die;
        $this->controller->redirect(array('controller' => 'errors', 'action' => 'error404'));
    }
}
