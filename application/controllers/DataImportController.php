<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 6/08/13
 * Time: 7:34 PM
 * To change this template use File | Settings | File Templates.
 */
class DataImportController extends Zend_Controller_Action
{
    protected $models_srcfile;
    protected $models_srcdata;

    public function init() {
        parent::init();
        $this->models_srcfile = new Models_Srcfile();
        $this->models_srcdata = new Models_Srcdata();
    }

    public function indexAction()
    {
        $this->_helper->redirector('upload-csv');
    }

    public function uploadCsvAction()
    {
        $fileupload_form = new Forms_Fileupload();
        $this->view->fileupload_form = $fileupload_form;

        $adapter = new Zend_File_Transfer_Adapter_Http();
        if ($this->_request->isPost() && $adapter->receive()) {
            $files = $adapter->getFileInfo();
            foreach ($files as $file) {
                $name = $file['name'];
                $new_srcfile_id = $this->models_srcfile->insert(array(
                    'name' => $name
                ));
                $destination = $file['destination'];
                $full_path = $destination . DS . $name;
                if (($handle = fopen($full_path, 'r')) !== FALSE) {
                    $insert_keys = array(
                        'src_file_id',
                        'ref_code',
                        'receiver_name',
                        'address1',
                        'address2',
                        'suburb',
                        'state',
                        'postcode',
                        'phone',
                        'email',
                        'delivery_note',
                        'description',
                        'quantity',
                        'weight',
                        'gross_value',
                        'sender_country',
                        'sender_name',
                        'gross_currency'
                    );

                    $row = 1;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $insert_values = array('src_file_id' => $new_srcfile_id);

                        $num = count($data);
                        //echo "<p> $num fields in line $row: <br /></p>\n";
                        $row++;
                        for ($c=0; $c < $num; $c++) {
                            $insert_values[] = $data[$c];
                        }

                        $insert_data = array_combine($insert_keys, $insert_values);
                        $new_srcdata_id = $this->models_srcdata->insert($insert_data);
                        //echo $new_srcdata_id;

                    }
                    fclose($handle);
                    unlink($full_path);
                }
            }
            //Zend_Debug::dump($adapter->getFileInfo());
            //Zend_Debug::dump($this->_request->getParams());
        }

        $all_srcfile = $this->models_srcfile->fetchAll();
        $this->view->all_srcfile = $all_srcfile;
        //Zend_Debug::dump($all_srcfile);
    }
}