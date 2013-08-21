<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 13/08/13
 * Time: 10:25 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class Models_DbAbstractTable extends Zend_Db_Table_Abstract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data) {
        if (empty($data['created'])) {
            $data['created'] = date_create('now')->format(DateTime::ISO8601);
        }
        return parent::insert($data);
    }

    /**
     * @param array $data
     * @param array|string $where
     * @return int
     */
    public function update(array $data, $where) {
        if (empty($data['modified'])) {
            $data['modified'] = date_create('now')->format(DateTime::ISO8601);
            return parent::update($data, $where);
        }
    }

    /**
     * @param array|string $where
     * @return int
     */
    public function soft_delete($where) {
        $data['deleted'] = date_create('now')->format(DateTime::ISO8601);
        return $this->update($data, $where);
    }
}