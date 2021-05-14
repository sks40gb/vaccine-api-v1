<?php

namespace Ziletech\Services\Common;

class QueryService {

    const CODE_TYPE = " SELECT id , description from code_type WHERE description LIKE '%{0}%' ";
    const GENERIC_CODE_BY_CODE_TYPE = " SELECT gc.id AS id, UPPER(gc.code) AS CODE, UPPER(gc.description) AS description FROM generic_code gc LEFT JOIN CODE_TYPE t ON t.id = gc.code_type_id WHERE t.description = '{0}' AND ( gc.code LIKE '{1}%' OR gc.description LIKE '{1}%') ";
    const LOCATION = " SELECT id, loc_code AS locationCode, location_name AS locationName, delivery_address AS deliveryAddress FROM location WHERE loc_code LIKE '{0}%' OR location_name LIKE '{0}%' ";
    const PRODUCT_CATEGORY = " SELECT category_id AS id, description FROM stock_category WHERE description LIKE '%{0}%' ";
    const PRODUCT = " SELECT  id, description FROM item_code  WHERE description LIKE '%{0}%' OR stock_id LIKE '%{0}%' ";
    const CUSTOMER = " SELECT debtor_no as id , name from debtors_master WHERE name LIKE '%{0}%' ";

    public function getQuery(string $query, ...$params) {

        $sql = "";
        if ($query == "CODE_TYPE") {
            $sql .= QueryService::CODE_TYPE;
        }
        if ($query == "GENERIC_CODE_BY_CODE_TYPE") {
            $sql .= QueryService::GENERIC_CODE_BY_CODE_TYPE;
        }
        if ($query == "LOCATION") {
            $sql .= QueryService::LOCATION;
        }
        if ($query == "PRODUCT_CATEGORY") {
            $sql .= QueryService::PRODUCT_CATEGORY;
        }
        if ($query == "PRODUCT") {
            $sql .= QueryService::PRODUCT;
        }
        if ($query == "CUSTOMER") {
            $sql .= QueryService::CUSTOMER;
        }
        for ($i = 0; $i <= sizeof($params); $i++) {
            $sql = str_replace("{" . $i . "}", $params[0], $sql);
        }

        return $sql;
    }

}
