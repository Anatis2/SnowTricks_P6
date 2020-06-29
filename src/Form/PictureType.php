<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
			->add('filename', TextType::class, [
				'disabled' => true,
			])
			->add('alt', TextType::class, [
				'label' => 'Nom de l\'image'
			])
			->add('file', FileType::class, [
				'label' => false,
				'mapped' => true,
				'required' => false,
			])
			->add('deleteButton', ButtonType::class, [
				'label' => 'Supprimer l\'image'
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
