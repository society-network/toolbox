<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 6/08/13
 * Time: 7:34 PM
 * To change this template use File | Settings | File Templates.
 */
class ReviewCsvController extends Zend_Controller_Action
{
    protected $models_srcfile;
    protected $models_srcdata;
    protected $models_shipper;
    protected $models_shipperalias;
    protected $models_depotcarriercode;

    public function init() {
        parent::init();
        $this->models_srcfile = new Models_Srcfile();
        $this->models_srcdata = new Models_Srcdata();
        $this->models_shipper = new Models_Shipper();
        $this->models_shipperalias = new Models_ShipperAlias();
        $this->models_depotcarriercode = new Models_DepotCarrierCode();
    }

    public function openAction() {
        $id = $this->_request->getParam('id');

        if ($id) {
            $srcfile = $this->models_srcfile->find($id);
            $this->view->srcfile = $srcfile;
            //Zend_Debug::dump($srcfile);
            $srcdata_where = $this->models_srcdata->select()->where('src_file_id = ?', $id);
            $srcdata = $this->models_srcdata->fetchAll($srcdata_where);
            $this->view->srcdata = $srcdata;
            //Zend_Debug::dump($srcdata);

            $form_exportcsv = new Forms_Exportcsv();
            $form_exportcsv->getElement('src_file_id')->setValue($id);
            $url = $this->view->url(array(
                'controller'=>'review-csv',
                'action'=>'export-csv'
            ), null, true);
            $form_exportcsv->setAction($url);
            $this->view->form_exportcsv = $form_exportcsv;
        }
    }

    public function exportCsvAction() {
        $src_file_id = $this->_request->getParam('src_file_id');
        $csv_type = $this->_request->getParam('csv_type');

        if ($this->_request->isPost() && $src_file_id && $csv_type) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            $srcdata_where = $this->models_srcdata->select()->where('src_file_id = ?', $src_file_id);
            $srcdata = $this->models_srcdata->fetchAll($srcdata_where);
            switch ($csv_type) {
                case 'export-csv-custom-upload':
                    $shipping_date = $this->_request->getParam('shipping_date');
                    $this->generateCustomUploadCsv($srcdata, $shipping_date);
                    break;
                case 'export-csv-supply-master':
                    $airway_bill = $this->_request->getParam('airway_bill');
                    $this->generateSupplyMasterCsv($srcdata, $airway_bill);
                    break;
                default:
                    $this->_helper->redirector('open', 'review-csv', null, array('id' => $src_file_id));
            }
        } else {
            $this->_helper->redirector('open', 'review-csv', null, array('id' => $src_file_id));
        }
    }

    private function findShipperByName($name) {
        return $this->models_shipper->findShipperByName($name);
    }

    private function generateCustomUploadCsv($srcdata, $shipped_date = '') {
        $csv_headers = array(
            'invoice_number',
            'flight_id',
            'sort_code',
            'value',
            'shipped_quantity',
            'shipped_date',
            'delname',
            'deladdr1',
            'deladdr2',
            'deladdr3',
            'deladdr4',
            'postcode',
            'product_description',
            'origin',
            'value_flag',
            'tarrif_id',
            'duty_per_item',
            'weight',
            'ShipperName1',
            'ShipperName2',
            'ShipperAddr1',
            'ShipperAddr2',
            'ShipperAddr3',
            'ShipperCity',
            'ShipperState',
            'ShipperPostcode',
            'ShipperCountry'
        );
        $out = fopen('php://output', 'w');
        fputcsv($out, $csv_headers);
        if ($srcdata) {
            foreach ($srcdata as $row) {
                $line_data = array_fill(0, sizeof($csv_headers), '');
                //'invoice_number',
                $line_data[0] = $row->ref_code;
                //'flight_id',
                $line_data[1] = '';
                //'sort_code',
                $line_data[2] = '';
                //'value',
                $line_data[3] = $row->gross_value;
                //'shipped_quantity',
                $line_data[4] = $row->quantity;
                //'/shipped_date',
                $line_data[5] = $shipped_date ? $shipped_date : '';
                //'delname',
                $line_data[6] = $row->receiver_name;
                //'deladdr1',
                $line_data[7] = $row->address1;
                //'deladdr2',
                $line_data[8] = $row->address2;
                //'deladdr3',
                $line_data[9] = $row->suburb;
                //'deladdr4',
                $line_data[10] = $row->state;
                //'postcode',
                $line_data[11] = str_pad($row->postcode, 4, '0', STR_PAD_LEFT);
                //'product_description',
                $line_data[12] = 'CLOTHING';
                //'origin',
                $line_data[13] = $row->sender_country;
                //'value_flag',
                $line_data[14] = '';
                //'tarrif_id',
                $line_data[15] = '';
                //'duty_per_item',
                $line_data[16] = '';
                //'weight',
                $line_data[17] = $row->weight;

                $shipper = $this->findShipperByName($row->sender_name);
                if ($shipper) {
                    //'ShipperName1',
                    $line_data[18] = $shipper->shipper_name1;
                    //'ShipperName2',
                    $line_data[19] = $shipper->shipper_name2;
                    //'ShipperAddr1',
                    $line_data[20] = $shipper->shipper_addr1;
                    //'ShipperAddr2',
                    $line_data[21] = $shipper->shipper_addr2;
                    //'ShipperAddr3',
                    $line_data[22] = $shipper->shipper_addr3;
                    //'ShipperCity',
                    $line_data[23] = $shipper->shipper_city;
                    //'ShipperState',
                    $line_data[24] = $shipper->shipper_state;
                    //'ShipperPostcode',
                    $line_data[25] = str_pad($shipper->shipper_postcode, 4, '0', STR_PAD_LEFT);
                    //'ShipperCountry'
                    $line_data[26] = $shipper->shipper_country;
                }

                fputcsv($out, $line_data);
            }
        }
        $this->getResponse()
            ->setHeader('Content-Disposition', 'inline; filename=custom_upload.csv')
            ->setHeader('Content-type', 'text/csv');
        fclose($out);
    }

    private function findCarrierCodeByDepotCode($depot_code) {
        if ($depot_code) {
            $find = $this->models_depotcarriercode->select()->where('depot_code = ?', $depot_code)->limit(1);
            $carrier_codes = $this->models_depotcarriercode->fetchAll($find);
            if (count($carrier_codes)) {
                return $carrier_codes[0]->carrier_code;
            }
        }
        return null;
    }

    private function generateSupplyMasterCsv($srcdata, $airway_bill = '') {
        $csv_headers = array(
            'Sender',
            'Group',
            'Customer Reference',
            'Receiver Name',
            'Receiver Code',
            'Receiver Address 1',
            'Receiver Address 2',
            'Receiver Address 3',
            'Receiver Suburb',
            'Receiver State',
            'Receiver postcode',
            'Receiver Contact',
            'Receiver Phone',
            'Carier and Service Code',
            'Total Items',
            'Airway',
            'Description',
            'Dimensions (Length)',
            'Dimensions (Width)',
            'Dimensions (Height)',
            'Total Weight',
            'Total Cubic',
            'Special Instructions 1',
            'Special Instructions 2',
            'Special Instructions 3',
            'Reciever Email',
            'Customer Reference1'
        );
        $out = fopen('php://output', 'w');
        fputcsv($out, $csv_headers);
        if ($srcdata) {
            foreach ($srcdata as $row) {
                $line_data = array_fill(0, sizeof($csv_headers), '');

                $depot_code = substr($row->ref_code, 8, 3);

                $shipper = $this->findShipperByName($row->sender_name);
                if ($shipper) {
                    //'Sender',
                    $line_data[0] = $shipper->shipper_name1;
                }
                //'Group',
                $line_data[1] = '';
                //'Customer Reference',
                $line_data[2] = $row->ref_code;
                //'Receiver Name',
                $line_data[3] = $row->receiver_name;
                //'Receiver Code',
                $line_data[4] = $row->ref_code;
                //'Receiver Address 1',
                $line_data[5] = $row->address1;
                //'Receiver Address 2',
                $line_data[6] = $row->address2;
                //'Receiver Address 3',
                $line_data[7] = '';
                //'Receiver Suburb',
                $line_data[8] = $row->suburb;
                //'Receiver State',
                $line_data[9] = $row->state;
                //'Receiver postcode',
                $line_data[10] = $row->postcode;
                //'Receiver Contact',
                $line_data[11] = '';
                //'Receiver Phone',
                $line_data[12] = $row->phone;
                //'Carier and Service Code',
                $carrier_code = $this->findCarrierCodeByDepotCode($depot_code);
                $line_data[13] = $carrier_code ? $carrier_code : '';
                //'Total Items',
                $line_data[14] = $row->quantity;
                //'Airway',
                $line_data[15] = $airway_bill ? $airway_bill : '';
                //'Description',
                $line_data[16] = 'CARTON';
                //'Dimensions (Length)',
                $line_data[17] = '';
                //'Dimensions (Width)',
                $line_data[18] = '';
                //'Dimensions (Height)',
                $line_data[19] = '';
                //'Total Weight',
                $line_data[20] = $row->weight;
                //'Total Cubic',
                $line_data[21] = '';
                //'Special Instructions 1',
                $line_data[22] = 'Authority to leave in a secure';
                //'Special Instructions 2',
                $line_data[23] = 'location if no one home';
                //'Special Instructions 3',
                $line_data[24] = '';
                //'Reciever Email',
                $line_data[25] = $row->email;
                //'Customer Reference1'
                $line_data[26] = $row->ref_code;

                fputcsv($out, $line_data);
            }
        }
        $this->getResponse()
            ->setHeader('Content-Disposition', 'inline; filename=supply_master.csv')
            ->setHeader('Content-type', 'text/csv');
        fclose($out);
    }

    public function deleteCsvAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $id = $this->_request->getParam('id');
        if ($id) {
            $where = $this->models_srcdata->getAdapter()->quoteInto('src_file_id = ?', $id);
            $this->models_srcdata->delete($where);
            $where = $this->models_srcfile->getAdapter()->quoteInto('src_file_id = ?', $id);
            $this->models_srcfile->delete($where);

            $this->_helper->redirector('upload-csv', 'data-import');
        }
    }
}