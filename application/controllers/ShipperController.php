<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 25/08/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */
class ShipperController extends Zend_Controller_Action
{
    protected $models_shipper;
    protected $models_shipperalias;

    public function init() {
        parent::init();
        $this->models_shipper = new Models_Shipper();
        $this->models_shipperalias = new Models_ShipperAlias();
    }

    public function indexAction() {
        $shippers = $this->models_shipper->fetchAll();
        $this->view->shippers = $shippers;
    }

    public function editAction() {
        $shipper_id = $this->_request->getParam('id');
        $this->view->shipper_id = $shipper_id;
        if ($shipper_id) {
            $find = $this->models_shipperalias->select()->where('shipper_id = ?', $shipper_id);
            $aliases = $this->models_shipperalias->fetchAll($find);
            $this->view->aliases = $aliases;
        }
    }

    public function editAliasAction() {
        $shipper_alias_id = $this->_request->getParam('shipper_alias_id');
        $shipper_id = $this->_request->getParam('shipper_id');
        if ($this->_request->isPost() && $shipper_id) {
            $name = $this->_request->getParam('name');
            $new_shipper_alias_id = $this->models_shipperalias->insert(array(
                'shipper_id' => $shipper_id,
                'name' => $name,
            ));
            if ($new_shipper_alias_id) {
                $this->_helper->redirector('edit', 'shipper', null, array('id' => $shipper_id));
            }
        }

        $form_shipperalias = new Forms_ShipperAlias();
        $this->view->form_shipperalias = $form_shipperalias;
    }
}