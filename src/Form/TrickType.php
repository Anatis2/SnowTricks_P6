<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
            	'label' => 'Nom de la figure'
			])
            ->add('description', TextareaType::class, [
            	'label' => 'Description de la figure'
			])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
				'label' => 'Catégorie'
            ])
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
			->add('pictures', CollectionType::class, [
				'entry_type' => PictureType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'required' => false,
				'label' => false
			]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
