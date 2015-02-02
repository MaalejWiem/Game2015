<?php

namespace Aip\SeriousgameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfigurationgameType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('nom', 'text', array('required' => false));
    	$builder->add('url', 'text', array('required' => false));
    	$builder->add('port', 'text', array('required' => false));
    	
    	$builder->add('scenario', 'text', array('required' => false));
    	
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Aip\SeriousgameBundle\Entity\Configurationgame',
        	'translation_domain' => 'game'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'game_form';
    }
}
