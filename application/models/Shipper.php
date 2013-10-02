<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 15/08/13
 * Time: 7:09 PM
 * To change this template use File | Settings | File Templates.
 */
class Models_Shipper extends Models_DbAbstractTable
{
    protected $_name = 'shippers';
    protected $_primary = 'shipper_id';

    /**
     * Find shipper by search its names and aliases
     *
     * @param $name
     * @return array|null
     */
    public function findShipperByName($name) {
        if ($name) {
            $sql = '
            SELECT DISTINCT sp.*
            FROM shippers AS sp
            LEFT JOIN shipper_aliases AS sa ON (sp.shipper_id = sa.shipper_id)
            WHERE sp.deleted IS NULL
            AND sa.deleted IS NULL
            AND (
                upper(sp.shipper_name1) = upper(?)
                OR upper(sp.shipper_name2) = upper(?)
                OR upper(sa.name) = upper(?)
            )
            ';
            $query_value = array($name, $name, $name);
            $shipper = $this->getAdapter()->fetchRow($sql, $query_value, Zend_Db::FETCH_OBJ);
            if (count($shipper) > 0) {
                return $shipper;
            }
        }
        return null;
    }
}