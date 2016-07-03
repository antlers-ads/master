<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * Form used to manage advertisement entity.
 */
class AdvertisementType extends AbstractType
{
    /** @var string */
    const ADD_MODE = 'add';

    /** @var string */
    const EDIT_MODE = 'data';

    /** @var string */
    const IMAGE_MODE = 'image';

    /** @var string */
    protected $mode;

    /**
     * Initializes form.
     *
     * @param string $mode
     */
    public function __construct($mode = self::ADD_MODE)
    {
        $this->mode = $mode;
    }

    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->mode == self::ADD_MODE || $this->mode == self::EDIT_MODE) {
            $builder
                ->add('name', 'text')
                ->add('client', 'entity', [
                    'class' => 'AppBundle:Client',
                    'empty_value' => '',
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('Client')
                            ->orderBy('Client.name', 'ASC');
                    },
                ])
                ->add('start_date', DateTimeType::class)
                ->add('end_date', DateTimeType::class)
                ->add('url', 'url');
        }

        if ($this->mode == self::ADD_MODE || $this->mode == self::IMAGE_MODE) {
            $builder->add('image', FileType::class);
        }
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
