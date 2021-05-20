<?php

namespace Ziletech\Services\Chart;

use phpDocumentor\Reflection\Types\Object_;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Exceptions\BusinessException;

class ChartService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getBarChart($districtName, $startDate = null, $endDate = null) {
        $sql = " SELECT c.district_name districtName, s.date date, s.vaccine vaccine, SUM(s.available_capacity) available";
        $sql .= " FROM center c JOIN SESSION s ON c.center_id = s.center_id";
        $sql .= " WHERE c.district_name = '$districtName' AND s.date BETWEEN '$startDate' AND '$endDate'";
        $sql .= " GROUP BY  c.district_name, s.date, s.vaccine";
        $sql .= " ORDER BY s.date";
        $result = $this->daoFactory->getGenericCodeDAO()->executeNativeQuery($sql);

        $labels = [];
        $vaccines = array();
        foreach ($result as $item) {
            array_push($labels, $item['date']);
            array_push($vaccines, $item['vaccine']);
        }
        $labels = array_unique($labels);
        $labels = array_values($labels);
        $vaccines = array_unique($vaccines);

        /**
         *       {data: [65, 59, 80, 81, 56, 55, 40], label: 'Series A'},
                {data: [28, 48, 40, 19, 86, 27, 90], label: 'Series B'}
         */

        $finalSet = [];
        foreach ($vaccines as $vaccine){
            $v = [];
            $v["label"] = $vaccine;
            $data = [];
            foreach ($labels as $label){
                array_push($data, $this->getAvailbility($result, $vaccine, $label));
            }
            $v["data"] = $data;
            array_push($finalSet, $v);
        }
        $response["labels"] = $labels;
        $response["dataSets"] = $finalSet;
        return $response;
    }

    function getAvailbility($items, $vaccine, $label){
        foreach ($items as $item){
            if($item["date"] == $label && $item["vaccine"] == $vaccine){
                return +$item["available"];
            }
        }
        return 0;
    }

}
