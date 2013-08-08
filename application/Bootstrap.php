<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jack
 * Date: 19/07/13
 * Time: 1:51 PM
 * To change this template use File | Settings | File Templates.
 */
Zend_Layout::startMvc(array(
    'layout' => 'layout',
    'layoutPath' => APP_DIR . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'scripts',
    'contentKey' => 'content',
));
$router     = new Zend_Controller_Router_Rewrite();
$front      = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(APP_DIR . DIRECTORY_SEPARATOR .'controllers')
    ->setRouter($router)
    ->setBaseUrl(BASE_URL)
    ->setParam('useDefaultControllerAlways', false);
$front->dispatch();