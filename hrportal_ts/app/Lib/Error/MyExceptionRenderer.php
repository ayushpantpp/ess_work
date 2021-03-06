<?php
App::uses('ExceptionRenderer', 'Error');

 class MyExceptionRenderer extends ExceptionRenderer 
 {
    /**
     * Overrided, to always use a bare controller.
     * 
     * @param Exception $exception The exception to get a controller for.
     * @return Controller
     */
    protected function _getController($exception) {
        if (!$request = Router::getRequest(true)) {
            $request = new CakeRequest();
        }
        $response = new CakeResponse(array('charset' => Configure::read('App.encoding')));
        $controller = new Controller($request, $response);
        $controller->viewPath = 'Errors';
        $controller->layout = 'employee-new';
        return $controller;
    }
 }
 ?>