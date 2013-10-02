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
    protected $flashMessager;

    public function init() {
        parent::init();
        $this->models_shipper = new Models_Shipper();
        $this->models_shipperalias = new Models_ShipperAlias();
        $this->flashMessager = $this->_helper->FlashMessenger;
    }

    public function indexAction() {
        $shippers = $this->models_shipper->fetchAll();
        $this->view->shippers = $shippers;
    }

    public function editAction() {
        $shipper_id = $this->_request->getParam('id');
        $this->view->shipper_id = $shipper_id;
        $successes = array();
        $errors = array();

        $form_shipper = new Forms_Shipper();

        if ($shipper_id) {
            $shipper = $this->models_shipper->find($shipper_id)->current();

            if ($this->_request->isPost() && $form_shipper->isValid($this->_request->getPost())) {
                $new_data = $form_shipper->getValues();
                if ($shipper->shipper_name1 != $new_data['shipper_name1'] && $this->models_shipper->findShipperByName( $new_data['shipper_name1'])) {
                    $errors[] = 'shipper name already exists';
                } elseif ($shipper->shipper_name2 !=  $new_data['shipper_name2'] && $this->models_shipper->findShipperByName( $new_data['shipper_name2'])) {
                    $errors[] = 'shipper name already exists';
                } else {
                    $query_status = $shipper->setFromArray($new_data)->save();
                    if ($query_status) {
                        $successes[] = 'successfully saved';
                    }
                }
            }

            $form_shipper->setDefaults($shipper->toArray());

            $find_alias = $this->models_shipperalias->select()->where('shipper_id = ?', $shipper_id);
            $aliases = $this->models_shipperalias->fetchAll($find_alias);
            $this->view->aliases = $aliases;
        } else {
            if ($this->_request->isPost() && $form_shipper->isValid($this->_request->getPost())) {
                $new_data = $form_shipper->getValues();
                if ($this->models_shipper->findShipperByName( $new_data['shipper_name1'])) {
                    $errors[] = 'shipper name already exists';
                } elseif ($this->models_shipper->findShipperByName( $new_data['shipper_name2'])) {
                    $errors[] = 'shipper name already exists';
                } else {
                    $new_shipper_id = $this->models_shipper->createRow($new_data)->save();
                    if ($new_shipper_id) {
                        $this->_helper->redirector('edit', 'shipper', null, array('id' => $new_shipper_id));
                    }
                }

            }
        }

        $this->view->successes = $successes;
        $this->view->errors = $errors;
        $this->view->form_shipper = $form_shipper;
    }

    public function editAliasAction() {
        $shipper_alias_id = $this->_request->getParam('shipper_alias_id');
        $shipper_id = $this->_request->getParam('shipper_id');
        $errors = array();

        $form_shipperalias = new Forms_ShipperAlias();

        if ($shipper_alias_id) {
            $shipper_alias = $this->models_shipperalias->find($shipper_alias_id)->current();
            $shipper_id = $shipper_alias->shipper_id;

            if ($this->_request->isPost() && $form_shipperalias->isValid($this->_request->getPost())) {
                $new_data = $form_shipperalias->getValues();
                if ($shipper_alias->name !=  $new_data['name'] && $this->models_shipper->findShipperByName( $new_data['name'])) {
                    $errors[] = 'name already exists';
                } else {
                    $query_status = $shipper_alias->setFromArray($new_data)->save();
                    if ($query_status) {
                        $this->_helper->redirector('edit', 'shipper', null, array('id' => $shipper_id));
                    }
                }
            }

            $form_shipperalias->setDefaults($shipper_alias->toArray());
        } else {
            if ($this->_request->isPost() && $form_shipperalias->isValid($this->_request->getPost()) && $shipper_id) {
                if (!$shipper_alias_id) {
                    $name = $form_shipperalias->getValue('name');
                    if ($this->models_shipper->findShipperByName($name)) {
                        $errors[] = 'name already exists';
                    } else {
                        $new_shipper_alias_id = $this->models_shipperalias->insert(array(
                            'shipper_id' => $shipper_id,
                            'name' => $name,
                        ));
                        if ($new_shipper_alias_id) {
                            $this->_helper->redirector('edit', 'shipper', null, array('id' => $shipper_id));
                        }
                    }
                }
            }
        }

        $this->view->errors = $errors;
        $this->view->form_shipperalias = $form_shipperalias;
    }

    public function deleteAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $id = $this->_request->getParam('id');
        if ($id) {
            $where = $this->models_shipperalias->getAdapter()->quoteInto('shipper_id = ?', $id);
            $this->models_shipperalias->delete($where);
            $where = $this->models_shipper->getAdapter()->quoteInto('shipper_id = ?', $id);
            $this->models_shipper->delete($where);

            $this->_helper->redirector('index', 'shipper');
        }
    }

    public function deleteAliasAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $id = $this->_request->getParam('id');
        if ($id) {
            $shipper_alias = $this->models_shipperalias->find($id)->current();

            $where = $this->models_shipperalias->getAdapter()->quoteInto('shipper_alias_id = ?', $id);
            $this->models_shipperalias->delete($where);

            $this->_helper->redirector('edit', 'shipper', null, array('id' => $shipper_alias->shipper_id));
        }
    }
}