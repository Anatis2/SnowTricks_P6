<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
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
			->add('url')
			->add('alt')
			->add('pictureFile', FileType::class, [
				'label' => false,
				'mapped' => false, // on précise que ce champ n'est associé à aucune propriété de l'entité Trick (ni à aucune propriété d'autre entité)
				'required' => false,
				'constraints' => [
					new File([ // le champ picture permettra de créer un objet de type File
						'maxSize' => '1500k',
						'mimeTypes' => [
							'image/png'
						],
						'mimeTypesMessage' => 'Seules les images de type PNG sont autorisés'
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
