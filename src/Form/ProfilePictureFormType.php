<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilePictureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileName', FileType::class, [
                'label' => 'My photo',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "You must select at least one picture please !"
                    ]),
                    new Image([
                        'maxSize' => '4M',
                        'maxSizeMessage' => 'Your picture must be less than 4Mo.',
                        'mimeTypes' => ["image/jpeg", "image/png", "image/jpg"],
                        'mimeTypesMessage' => 'The files accepted is only .jpeg, .jpg, .png.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
