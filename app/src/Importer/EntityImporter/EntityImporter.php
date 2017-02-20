<?php

namespace Phpsw\Website\Importer\EntityImporter;

use Phpsw\Website\Importer\EntityImporter\Form\FormBuilder;
use Phpsw\Website\Importer\ValidationError;
use Phpsw\Website\Importer\ValidationException;
use Symfony\Component\Form\FormInterface;

class EntityImporter implements EntityImporterInterface
{
    private $repository;

    /**
     * @var string
     */
    private $entityFqcn;

    /**
     * @var FormBuilder
     */
    private $formBuilder;

    /**
     * EntityImporter constructor.
     *
     * The supplied repository must have a persist method.
     *
     * @param FormBuilder $formBuilder
     * @param $repository
     * @param string $entityFqcn
     */
    public function __construct(
        FormBuilder $formBuilder,
        $repository,
        string $entityFqcn
    ) {
        $this->formBuilder = $formBuilder;
        $this->repository = $repository;
        $this->entityFqcn = $entityFqcn;
    }

    /**
     * Import an entity.
     *
     * {@inheritdoc}
     */
    public function importEntity(string $slug, array $entityData)
    {
        $entity = $this->convertDataToEntity($slug, $entityData);
        $this->repository->persist($entity);
    }

    private function convertDataToEntity(string $slug, array $entityData)
    {
        $entityData['slug'] = $slug;
        $form = $this->formBuilder->createForm($this->entityFqcn);
        $form->submit($entityData, true);

        if (!$form->isValid()) {
            $this->handleInvalidForm($slug, $form);
        }

        return $form->getData();
    }

    private function handleInvalidForm(string $slug, FormInterface $form)
    {
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
}
