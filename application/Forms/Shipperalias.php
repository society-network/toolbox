<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 24/08/13
 * Time: 12:53 PM
 * To change this template use File | Settings | File Templates.
 */
class Forms_ShipperAlias extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        // Add the name element
        $this->addElement('text', 'name', array(
            'label'         => 'Alias name:',
            'required'      => true,
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}