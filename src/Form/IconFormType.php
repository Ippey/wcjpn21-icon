<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class IconFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'コミュニティ' => 'community',
                    'コア' => 'core',
                    'デザイン' => 'design',
                    'ドキュメント' => 'docs',
                    '学習' => 'learn',
                    '翻訳' => 'polyglots',
                    'サポート' => 'support',
                    'テスト' => 'test',
                    'WordPress.tv' => 'tv',
                ],
            ])
            ->add('icon', FileType::class, [
                'constraints' => [
                    new Image()
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
