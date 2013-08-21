<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 6/08/13
 * Time: 7:34 PM
 * To change this template use File | Settings | File Templates.
 */
class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $user = new Models_User();
        $user->insert(array(
            'username' => 'test',
            'password' => 'pass',
        ));
    }
}