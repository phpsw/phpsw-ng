<?php

namespace Phpsw\Website\Importer\EntityImporter\Form;

use Phpsw\Website\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', TextType::class);
        $builder->add('name', TextType::class);
        $builder->add('photo-url', TextType::class, ['property_path' => 'photoUrl']);
        $builder->add('description', TextType::class);
        $builder->add('twitter-handle', TextType::class, ['property_path' => 'twitterHandle']);
        $builder->add('github-handle', TextType::class, ['property_path' => 'githubHandle']);
        $builder->add('website-url', TextType::class, ['property_path' => 'websiteUrl']);
        $builder->add('meetup-id', IntegerType::class, ['property_path' => 'meetupId']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
            'csrf_protection' => false,
        ]);
    }
}
