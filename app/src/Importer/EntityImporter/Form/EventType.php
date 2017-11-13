<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @var PeopleTransformer
     */
    private $peopleTransformer;

    /**
     * @var LocationTransformer
     */
    private $locationTransformer;

    /**
     * @var SponsorsTransformer
     */
    private $sponsorsTransformer;

    /**
     * EventType constructor.
     *
     * @param PeopleTransformer $peopleTransformer
     * @param LocationTransformer $locationTransformer
     * @param SponsorsTransformer $sponsorsTransformer
     */
    public function __construct(
        PeopleTransformer $peopleTransformer,
        LocationTransformer $locationTransformer,
        SponsorsTransformer $sponsorsTransformer
    ) {
        $this->peopleTransformer = $peopleTransformer;
        $this->locationTransformer = $locationTransformer;
        $this->sponsorsTransformer = $sponsorsTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', TextType::class);
        $builder->add('meetup-id', TextType::class, ['property_path' => 'meetupId']);
        $builder->add('date', TextType::class);
        $builder->add('title', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add('venue', TextType::class);
        $builder->add('pub', TextType::class);
        $builder->add('organisers', CollectionType::class, ['entry_type' => TextType::class, 'allow_add' => true]);
        $builder->add('sponsors', CollectionType::class, ['entry_type' => TextType::class, 'allow_add' => true]);
        $builder->add('joindInUrl', TextType::class);

        $builder->get('organisers')->addModelTransformer($this->peopleTransformer);
        $builder->get('sponsors')->addModelTransformer($this->sponsorsTransformer);
        $builder->get('venue')->addModelTransformer($this->locationTransformer);
        $builder->get('pub')->addModelTransformer($this->locationTransformer);
        $builder->get('date')->addModelTransformer(new DateTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'csrf_protection' => false,
        ]);
    }
}
