<?php

namespace Ziletech\Database\DAO;

class Property {

    public $field, $value, $operator, $fieldNumber;

    public function __construct(string $field, $value, string $operator = "=") {
        $this->field = $field;
        $this->value = $value;
        $this->operator = $operator;
        $this->fieldNumber = "F" . mt_rand() . "_" . mt_rand();
    }

    public function getFieldExpression(): string {
        if ($this->operator === Operator::IN) {
            return "(:$this->fieldNumber)";
        } else {
            return ":$this->fieldNumber";
        }
    }

    public function getValueExpression() {
        if ($this->operator === Operator::LIKE) {
            return '%' . $this->value . '%';
        } else {
            return $this->value;
        }
    }

    /**
     * It will return the JOIN operation - ex: JOIN t.user user
     * @return string - JOIN Expression
     */
    public function getJoinExpression() {
        if ($this->containsDot()) {
            $firstWord = $this->getFirstWord();
            return " JOIN t.$firstWord $firstWord ";
        } else {
            return "";
        }
    }

    public function getFirstWord(): string {
        return explode(".", $this->field)[0];
    }

    public function containsDot() {
        return strpos($this->field, ".") !== false;
    }

    public function getConditionalExpression(): string {
        if ($this->containsDot()) {
            return "$this->field $this->operator " . $this->getFieldExpression();
        } else {
            return "t." . "$this->field $this->operator " . $this->getFieldExpression();
        }
    }

    public static function getInstance(string $field, $value, $operator = "=") {
        return new Property($field, $value, $operator);
    }

}

abstract class Operator {

    const EQUAL = "=";
    const NOT_EQUAL = "!=";
    const LESS_THAN = "<";
    const GREATER_THAN = ">";
    const LESS_THAN_EQUAL_TO = "<=";
    const GREATER_THAN_EQUAL_TO = ">=";
    const LIKE = "LIKE";
    const IN = "IN";

}

abstract class Condition {

    const AND_ = "AND";
    const OR_ = "OR";

}
