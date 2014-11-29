<?php

namespace Rudak\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PictureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
            'label'    => 'Image',
            'required' => false,
            'attr'     => array(
                'class' => 'filestyle',
                'title' => 'Parcourir...'
            )
        ))
            ->add('gallery', 'entity', array(
                'class'         => 'RudakGalleryBundle:Gallery',
                'label'         => 'Galerie',
                'attr'          => array(
                    'class' => 'selectpicker'
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.id', 'DESC');
                },
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rudak\GalleryBundle\Entity\Picture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rudak_blogbundle_picture';
    }
}
