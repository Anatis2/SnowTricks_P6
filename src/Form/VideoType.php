<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filename', TextType::class, [
				'disabled' => true,
			])
            ->add('alt', TextType::class, [
				'label' => "Nom de la vidéo",
			])
			->add('file', FileType::class, [
			'label' => "Envoi d'un nouveau fichier",
			'help' => "fichiers autorisés : .mp4",
			'mapped' => true,
			'required' => false,
		])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
