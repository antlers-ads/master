<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

/**
 * Form used to manage advertisement entity.
 */
class AdvertisementType extends AbstractType
{
    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Name'])
            ->add('client', 'entity', [
                'class' => 'AppBundle:Client',
                'empty_value' => '',
                'label' => 'Client',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('Client')
                        ->orderBy('Client.name', 'ASC');
                },
            ]);
    }

    /**
     * Sets default form options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Advertisement'
        ]);
    }

    /**
     * Returns form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_advertisement';
    }
}
