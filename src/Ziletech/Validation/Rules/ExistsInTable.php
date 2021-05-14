<?php

namespace Ziletech\Validation\Rules;

use BaseDAO;
use Respect\Validation\Rules\AbstractRule;

class ExistsInTable extends AbstractRule {

    /**
     * @var
     */
    private $column;

    
      /**
     * @var BaseDAO
     */
    private $dao;

    public function __construct($dao, $column) {
        $this->dao = $dao;
        $this->column = $column;
    }

    public function validate($input) {//employee.id
        $row = $this->dao->get([$this->column=>$input]);
        return !isset($row);
    }

}
