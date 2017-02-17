<?php

namespace Phpsw\Website\Importer;

class ValidationError
{
    /**
     * @var string
     */
    private $entityType;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $problem;

    /**
     * ValidationError constructor.
     *
     * @param string $entityType
     * @param string $entity
     * @param string $field
     * @param string $problem
     */
    public function __construct($entityType, $entity, $field, $problem)
    {
        $this->entityType = $entityType;
        $this->entity = $entity;
        $this->field = $field;
        $this->problem = $problem;
    }

    /**
     * @return string
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getProblem()
    {
        return $this->problem;
    }

    public function __toString()
    {
        return "Error importing [{$this->entity}] of type [{$this->entityType}]. ".
        "Field [{$this->field}]: {$this->problem}";
    }
}
