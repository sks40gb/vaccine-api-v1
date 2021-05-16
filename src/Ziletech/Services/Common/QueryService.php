<?php

namespace Ziletech\Services\Common;

class QueryService {

    const CODE_TYPE = " SELECT id , description from code_type WHERE description LIKE '%{0}%' ";
    const GENERIC_CODE_BY_CODE_TYPE = " SELECT gc.id AS id, UPPER(gc.code) AS CODE, UPPER(gc.description) AS description FROM generic_code gc LEFT JOIN CODE_TYPE t ON t.id = gc.code_type_id WHERE t.description = '{0}' AND ( gc.code LIKE '{1}%' OR gc.description LIKE '{1}%') ";

    public function getQuery(string $query, ...$params) {

        $sql = "";
        if ($query == "CODE_TYPE") {
            $sql = QueryService::CODE_TYPE;
        }
        if ($query == "GENERIC_CODE_BY_CODE_TYPE") {
            $sql = QueryService::GENERIC_CODE_BY_CODE_TYPE;
        }
        for ($i = 0; $i <= sizeof($params); $i++) {
            $sql = str_replace("{" . $i . "}", $params[0], $sql);
        }

        return $sql;
    }

}
