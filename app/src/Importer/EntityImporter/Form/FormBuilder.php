<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

/**
 * Responsible for building Forms via the createForm method.
 *
 * Forms should reference the Entity they wish to validate. Validation annotations are enabled.
 */
class FormBuilder
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct()
    {
        // As suggested @see https://symfony.com/doc/2.8/components/validator/resources.html
        $validatorInterface = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $builder = Forms::createFormFactoryBuilder();
        $builder->addExtension(new ValidatorExtension($validatorInterface));
        $this->formFactory = $builder->getFormFactory();
    }

    /**
     * Returns Form of the given $type.
     *
     * @param string $type FQCN of Form
     *
     * @return FormInterface
     */
    public function createForm(string $type)
    {
        return $this->formFactory->createNamed('', $type);
    }
}
