<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 24/08/13
 * Time: 12:53 PM
 * To change this template use File | Settings | File Templates.
 */
class Forms_Fileupload extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

        // Add an file element
        $file = new Zend_Form_Element_File('file1');
        $file->setLabel('CSV file:');
        $file->setRequired(true);
        $file->addValidator('Size', false, 1024000); //1M size limit
        $file->addValidator('Extension', false, 'csv,txt');
        $this->addElement($file);

        // Add the comment element
//        $this->addElement('textarea', 'comment', array(
//            'label'         => 'Comment:',
//            'required'      => false,
//            'cols'          => 40,
//            'rows'          => 4,
//        ));

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