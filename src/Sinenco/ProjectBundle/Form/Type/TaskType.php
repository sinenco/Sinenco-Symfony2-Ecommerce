<?php

// src/Sinenco/UserBundle/Form/Type/RegistrationFormType.php

namespace Sinenco\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('description', 'textarea', array(
                    'required' => false
                ))
                ->add('value')
                ->add('tasks', 'collection', array(
                    'type' => new TaskType(),
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sinenco\ProjectBundle\Entity\Task'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sinenco_project_task';
    }

}
