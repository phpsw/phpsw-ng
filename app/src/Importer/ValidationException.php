<?php

namespace Phpsw\Website\Importer;

use Exception;

/**
 * Holds validation errors.
 */
class ValidationException extends Exception
{
    /**
     * @var ValidationError[]
     */
    private $validationErrors;

    /**
     * ValidationException constructor.
     *
     * @param ValidationError[] $validationErrors
     */
    public function __construct(array $validationErrors)
    {
        $this->validationErrors = $validationErrors;
    }

    /**
     * Returns an array of strings. Each array entry is a validation failure message.
     *
     * @return ValidationError[]
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
