<?php

namespace App\Form;

use App\Entity\Preference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'Man' => '1',
                    'Woman' => '0',
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Post Code (Country)',
            ])
            ->add('ageRange', ChoiceType::class, [
                'label' => 'Age range',
                'choices' => [
                    '18 - 25' => '18 and 25',
                    '26 - 35' => '26 and 35',
                    '36 - 45' => '36 and 45',
                    '46 - 55' => '46 and 55',
                    '56 - 65' => '56 and 65',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
