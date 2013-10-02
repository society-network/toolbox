<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 24/08/13
 * Time: 12:53 PM
 * To change this template use File | Settings | File Templates.
 */
class Forms_Shipper extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        // Add the shipper_name1 element
        $this->addElement('text', 'shipper_name1', array(
            'label'         => 'Primary name: *',
           // 'value'         => 'test',
            'required'      => true,
            'filters'       => array('StringToUpper'),
        ));

        // Add the shipper_name2 element
        $this->addElement('text', 'shipper_name2', array(
            'label'         => 'Secondary name:',
            'required'      => false,
            'filters'       => array('StringToUpper'),
        ));

        // Add the address line 1
        $this->addElement('text', 'shipper_addr1', array(
            'label'         => 'Address 1: *',
            'required'      => true,
            'filters'       => array('StringToUpper'),
        ));

        // Add the address line 2
        $this->addElement('text', 'shipper_addr2', array(
            'label'         => 'Address 2:',
            'required'      => false,
            'filters'       => array('StringToUpper'),
        ));

        // Add the address line 3
        $this->addElement('text', 'shipper_addr3', array(
            'label'         => 'Address 3:',
            'required'      => false,
            'filters'       => array('StringToUpper'),
        ));

        // Add the city
        $this->addElement('text', 'shipper_city', array(
            'label'         => 'City: *',
            'required'      => true,
            'filters'       => array('StringToUpper'),
        ));

        // Add the state
        $this->addElement('text', 'shipper_state', array(
            'label'         => 'State:',
            'required'      => false,
            'filters'       => array('StringToUpper'),
        ));

        // Add the postcode
        $this->addElement('text', 'shipper_postcode', array(
            'label'         => 'Postcode: *',
            'required'      => true,
            'filters'       => array('StringToUpper'),
        ));

        // Add the country
        $this->addElement('text', 'shipper_country', array(
            'label'         => 'Country: *',
            'required'      => true,
            'filters'       => array('StringToUpper'),
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