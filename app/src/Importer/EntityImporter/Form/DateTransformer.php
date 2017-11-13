<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between string representing a date and a date object.
 *
 * Any valid string representation of a date is allowed
 */
class DateTransformer implements DataTransformerInterface
{
    /**
     * Transforms a date object to a string representation.
     *
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        return $value->format('Y-m');
    }

    /**
     * Transforms a string representation to a date object.
     *
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $timestamp = strtotime($value);
        if (false === $timestamp) {
            throw new TransformationFailedException("Invalid date [$value]");
        }

        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp);

        return $dateTime;
    }
}
