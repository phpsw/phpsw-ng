<?php

namespace Phpsw\Website\Importer;

use Exception;

/**
 * Holds validation errors.
 */
class ValidationException extends Exception
{
    /**
     * @var array
     */
    private $validationErrors;

    /**
     * ValidationException constructor.
     *
     * @param array $validationErrors
     */
    public function __construct(array $validationErrors)
    {
        $this->validationErrors = $validationErrors;
    }

    /**
     * Returns an array of strings. Each array entry is a validation failure message.
     *
     * @return string[]
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
