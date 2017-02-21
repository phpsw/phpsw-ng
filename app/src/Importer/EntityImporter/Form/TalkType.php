<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\Talk;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TalkType extends AbstractType
{
    /**
     * @var PeopleTransformer
     */
    private $peopleTransformer;

    /**
     * @var EventTransformer
     */
    private $eventTransformer;

    /**
     * TalkType constructor.
     *
     * @param PeopleTransformer $peopleTransformer
     * @param EventTransformer $eventTransformer
     */
    public function __construct(PeopleTransformer $peopleTransformer, EventTransformer $eventTransformer)
    {
        $this->peopleTransformer = $peopleTransformer;
        $this->eventTransformer = $eventTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', TextType::class);
        $builder->add('title', TextType::class);
        $builder->add('abstract', TextType::class);
        $builder->add('event', TextType::class);
        $builder->add('slides-url', TextType::class, ['property_path' => 'slidesUrl']);
        $builder->add('joindin-url', TextType::class, ['property_path' => 'joindinUrl']);
        $builder->add('video-url', TextType::class, ['property_path' => 'videoUrl']);
        $builder->add('speakers', CollectionType::class, ['entry_type' => TextType::class, 'allow_add' => true]);

        $builder->get('speakers')->addModelTransformer($this->peopleTransformer);
        $builder->get('event')->addModelTransformer($this->eventTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Talk::class,
            'csrf_protection' => false,
        ]);
    }
}
