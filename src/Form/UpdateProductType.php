<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UpdateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Название'])
            ->add('price', MoneyType::class, ['label' => 'Цена'])
            ->add('weight', IntegerType::class, ['label' => 'вес'])
            ->add('type', ChoiceType::class, ['label' => 'тип товара', 'choices' => [
                'напиток' => 1,
                'суп' => 2,
                'закуска' => 3
            ]])
            ->add('description', TextType::class, ['label' => 'описание'])
            ->add('status', ChoiceType::class, ['label' => 'статус', 'choices' => [
                'в наличии' => -1,
                'нет в наличии' => -2,
                'не доступен' => -3
            ]])
            ->add('quantity', IntegerType::class, ['label' => 'количество'])
            ->add('save', SubmitType::class, ['label' => 'Добавить']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
