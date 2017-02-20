<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\WebsiteInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsiteInfoType extends AbstractType
{
    /**
     * @var PeopleTransformer
     */
    private $peopleTransformer;

    /**
     * WebsiteInfoType constructor.
     *
     * @param PeopleTransformer $peopleTransformer
     */
    public function __construct(PeopleTransformer $peopleTransformer)
    {
        $this->peopleTransformer = $peopleTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add('photo-url', TextType::class, ['property_path' => 'photoUrl']);
        $builder->add('organisers', CollectionType::class, [
            'entry_type' => TextType::class,
            'allow_add' => true,
        ]);
        $builder->get('organisers')->addModelTransformer($this->peopleTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WebsiteInfo::class,
            'csrf_protection' => false,
        ]);
    }
}
