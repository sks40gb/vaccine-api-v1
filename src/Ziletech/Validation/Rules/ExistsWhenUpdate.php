<?php

namespace Ziletech\Validation\Rules;

use BaseDAO;
use Respect\Validation\Rules\AbstractRule;
use Ziletech\Database\DAO\Operator;
use Ziletech\Database\DAO\Property;

class ExistsWhenUpdate extends AbstractRule {

    /**
     * @var
     */
    private $column;

    /**
     * @var BaseDAO
     */
    private $dao;

    /**
     *
     * @var int 
     */
    protected $id;

    public function __construct($dao, $column, $id) {
        $this->dao = $dao;
        $this->column = $column;
        $this->id = $id;
    }

    public function validate($input): bool {
        $filters = array(Property::getInstance($this->column, $input), Property::getInstance("id", $this->id, Operator::NOT_EQUAL));
        $rows = $this->dao->filter($filters);
        return sizeof($rows) == 0;
    }

}
