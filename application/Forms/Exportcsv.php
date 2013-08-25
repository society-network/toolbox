<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 25/08/13
 * Time: 9:39 PM
 * To change this template use File | Settings | File Templates.
 */
class Forms_Exportcsv extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $src_file_id = new Zend_Form_Element_Hidden('src_file_id');
        $src_file_id->setValue($this->src_file_id);
        $src_file_id->setRequired(true);
        $src_file_id->setDecorators(array('ViewHelper'));
        $this->addElement($src_file_id);

        $csv_type = new Zend_Form_Element_Select('csv_type');
        $csv_type->setLabel('CSV type:');
        $csv_type->setMultiOptions(array(
            //''                              => '-- select ---',
            'export-csv-custom-upload' => 'Custom upload CSV',
            'export-csv-supply-master' => 'Supply master CSV',
        ));
        $csv_type->setRequired(true);
        $this->addElement($csv_type);

        $airway_bill = new Zend_Form_Element_Text('airway_bill');
        $airway_bill->setLabel('Airway bill:');
        $airway_bill->setRequired(false);
        $airway_bill->addFilter('StringTrim');
        $this->addElement($airway_bill);

        $shipping_date = new Zend_Form_Element_Text('shipping_date');
        $shipping_date->setLabel('Shipping date:');
        $shipping_date->setValue(date('d/m/Y'));
        $shipping_date->setRequired(false);
        $shipping_date->addValidator('date', false, array('dd/mm/yyyy'));
        $shipping_date->addFilter('StringTrim');
        $this->addElement($shipping_date);

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}