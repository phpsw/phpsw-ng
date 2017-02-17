<?php

namespace Phpsw\Website\Importer\EntityImporter;

use Phpsw\Website\Container\Form\FormBuilder;
use Phpsw\Website\Importer\ValidationError;
use Phpsw\Website\Importer\ValidationException;

/**
 * Used to convert raw data to an entity using a FormType.
 */
class DataToEntityConverter
{
    /**
     * @var FormBuilder
     */
    private $formBuilder;

    /**
     * DataToEntityConverter constructor.
     *
     * @param FormBuilder $formBuilder
     */
    public function __construct(FormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Builds a form of the given formTypeClass, populates the data and returns a built entity.
     *
     * If there are any validation problems then a ValidationException is thrown.
     *
     * @param string $formTypeClass
     * @param string $slug
     * @param array $data
     *
     * @throws ValidationException
     *
     * @return mixed
     */
    public function getEntity(string $formTypeClass, string $slug, array $data)
    {
        $data['slug'] = $slug;
        $form = $this->formBuilder->createForm($formTypeClass);
        $form->submit($data, true);

        if (!$form->isValid()) {
            $validationErrors = [];

            foreach ($form->getErrors(true) as $error) {
                $validationErrors[] = new ValidationError(
                    $form->getConfig()->getDataClass(),
                    $slug,
                    $error->getOrigin()->getName(),
                    $error->getMessage()
                );
            }
            throw new ValidationException($validationErrors);
        }

        return $form->getData();
    }
}
