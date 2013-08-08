<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 6/08/13
 * Time: 7:38 PM
 * To change this template use File | Settings | File Templates.
 */
class ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
                $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
                break;
            default:
                break;
        }
    }
}