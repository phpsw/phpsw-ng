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
     * @var SponsorsTransformer
     */
    private $sponsorTransformer;

    /**
     * WebsiteInfoType constructor.
     *
     * @param PeopleTransformer $peopleTransformer
     * @param SponsorsTransformer $sponsorTransformer
     */
    public function __construct(PeopleTransformer $peopleTransformer, SponsorsTransformer $sponsorTransformer)
    {
        $this->peopleTransformer = $peopleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', TextType::class);
        $builder->add('organisers', CollectionType::class, [
            'entry_type' => TextType::class,
            'allow_add' => true,
        ]);
        $builder->add('sponsors', CollectionType::class, [
            'entry_type' => TextType::class,
            'allow_add' => true,
        ]);
        $builder->add('emailAddress', TextType::class);
        $builder->add('meetupUrl', TextType::class);
        $builder->add('friends', CollectionType::class, [
            'entry_type' => TextType::class,
            'allow_add' => true,
        ]);

        $builder->get('organisers')->addModelTransformer($this->peopleTransformer);
        $builder->get('sponsors')->addModelTransformer($this->sponsorTransformer);
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
