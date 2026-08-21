<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('priority', ChoiceType::class, ['label' => 'Priorité', 'choices' => array_combine(Task::PRIORITIES, Task::PRIORITIES)])
            ->add('status', ChoiceType::class, ['label' => 'Statut', 'choices' => array_combine(Task::STATUSES, Task::STATUSES)])
            ->add('assignee', EntityType::class, [
                'class' => User::class,
                'label' => 'Assignée à',
                'required' => false,
                'placeholder' => 'Non assignée',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Task::class]);
    }
}