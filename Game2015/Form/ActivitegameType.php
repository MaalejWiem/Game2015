<?php

namespace Aip\SeriousgameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ActivitegameType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', 'text', array('constraints' => new NotBlank()));
        $builder->add('instructions', 'textarea');
        $activitegame=$options['data'];
        $aggregate=$activitegame->getAggregate();
        $builder->add('nomconfiguration','entity',array(
        		'class'=>'AipSeriousgameBundle:Configurationgame',
        		'property' => 'Nom',
        		'query_builder' => function(\Doctrine\ORM\EntityRepository $er) use ($aggregate)
        		{
        			 
        			return $er->createQueryBuilder('r')->where('r.aggregate = :id')->setParameter('id',$aggregate->getId());
        		},
        		'mapped' => false,
        		 
        		 
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Aip\SeriousgameBundle\Entity\Activitegame',
            'translation_domain' => 'game'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'activitegame_form';
    }
}
