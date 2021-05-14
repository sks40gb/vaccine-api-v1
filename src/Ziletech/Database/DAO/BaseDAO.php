<?php

use Ziletech\Database\DAO\Property;

class BaseDAO {

    // obtaining the entity manager
    private $entityClass;
    protected $entityManager;

    public function __construct($entityManager, $entityClass) {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
    }

    public function merge($entity, $flush = true) {
        $this->getManager()->merge($entity);
        if ($flush) {
            $this->flush();
        }
        return $entity;
    }

    public function persist($entity, $flush = true) {
        $this->getManager()->persist($entity);
        if ($flush) {
            $this->flush();
        }
        return $entity;
    }

    public function save($entity, $flush = true) {
        $this->getManager()->persist($entity);
        if ($flush) {
            $this->flush();
        }
        return $entity;
    }

    public function update($entity, $flush = true) {
        $this->getManager()->merge($entity);
        if ($flush) {
            $this->flush();
        }
        return $entity;
    }

    public function flush() {
        $this->getManager()->flush();
    }

    public function refresh($entity) {
        $this->getManager()->refresh($entity);
    }

    public function detach($entity) {
        return $this->getManager()->detach($entity);
    }

    public function remove($entity) {
        $this->getManager()->merge($entity);
        $this->getManager()->remove($entity);
        $this->flush();
    }

    public function findById($id = NULL) {
        return $this->get(array("id" => $id));
    }

    public function findAll($options = null) {
        return $this->find(null, $options);
    }

    /**
     * Filter by criteria
     * @param type $options
     * @return type
     */
    public function filter($filters, $options = null) {
        $query = $this->buildSelectDQL($filters, $options);
        $entities = $query->getResult();
        return $entities;
    }

    /**
     * Get array of entities by passing the conditional fields.
     * @param type $field_value_array
     * @return type
     */
    public function find($field_value_array = false, $options = null) {
        $filters = array();
        if ($field_value_array != false) {
            foreach ($field_value_array as $field => $value) {
                array_push($filters, Property::getInstance($field, $value));
            }
        }
        return $this->filter($filters, $options);
    }

    /**
     * Whether records exist into the sytem for given criteria
     * @param type $field_value_array
     * @return boolean
     */
    public function exist($field_value_array = false) {
        if ($this->get($field_value_array) == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get single record
     * @param type $field_value_array
     * @return type
     */
    public function get($field_value_array) {
        $filters = array();
        foreach ($field_value_array as $field => $value) {
            array_push($filters, Property::getInstance($field, $value));
        }
        $query = $this->buildSelectDQL($filters);
        return $query->getOneOrNullResult();
    }

    /**
     * Get count
     * @param type $field_value_array
     * @return type
     */
    public function getCount($field_value_array = [], $options = []) {
        $filters = array();
        foreach ($field_value_array as $field => $value) {
            array_push($filters, Property::getInstance($field, $value));
        }
        $query = $this->buildCountDQL($filters, $options);
        $result = $query->getOneOrNullResult();
        $count = $result != null && sizeof($result) > 0 ? $result[1] : 0;
        return $count;
    }

    /**
     * Build Count DQL
     * @param type $properties
     * @param type $options - ["limit"=>10, "orderBy"=>"description", "order"=>"ASC"]
     * @return type
     */
    private function buildCountDQL($properties, $options = []) {
        $table = $this->entityClass;
        $sql = "SELECT count(t) FROM $table t ";
        return $this->buildDQL($sql, $properties, $options);
    }

    /**
     * Build Select DQL
     * @param type $properties
     * @param type $options - ["limit"=>10, "orderBy"=>"description", "order"=>"ASC"]
     * @return type
     */
    private function buildSelectDQL($properties, $options = []) {
        $table = $this->entityClass;
        $sql = "SELECT t FROM $table t ";
        return $this->buildDQL($sql, $properties, $options);
    }

    /**
     * 
     * @param type $sql
     * @param type $properties
     * @param type $options - ["limit"=>10, "orderBy"=>"description", "order"=>"ASC"]
     * @return type
     */
    private function buildDQL($sql, $properties, $options = []) {
        $limit = $this->getOption($options, "limit");
        $orderBy = $this->getOption($options, "orderBy");
        $order = $this->getOption($options, "order") ? $this->getOption($options, "order") : "ASC";

          //Build Join
        foreach ($properties as $property) {
            $sql .= $property->getJoinExpression();
        }
        
        if (isset($properties) && !empty($properties)) {
            $sql .= " WHERE ";
        }
        //add where condition and remove the 'AND from the query';
        foreach ($properties as $property) {
            $sql .= $property->getConditionalExpression() . " AND ";
        }
        $sql = rtrim($sql, "AND "); //remove the last AND

        if (isset($orderBy)) {
            $sql .= " ORDER BY t.$orderBy $order";
        }

        $query = $this->getManager()->createQuery($sql);
        #echo "QUERY : $sql";
        //bind the value
        foreach ($properties as $property) {
            $query->setParameter($property->fieldNumber, $property->getValueExpression());
        }

        $query->setMaxResults($limit);
        return $query;
    }

    private function getOption($options, $property) {
        if (isset($options) && isset($options[$property])) {
            return $options[$property];
        } else {
            return null;
        }
    }

    public function getManager() {
        //print_r($entityManager);
        return $this->entityManager;
    }

    public function executeNativeQuery($sql) {
        $stmt = $this->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
