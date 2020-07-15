<?php

namespace App\Services;

use App\Entity\Picture;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class FileUploader
{
	private $targetDirectory;

	public function __construct($targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function upload(Picture $picture)
	{
		$uploadedFile = $picture->getFile();
		if($uploadedFile === null) {
			return;
		}
		$originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME); // On récupère le nom original du fichier, grâce à son chemin d'accès
		$safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename); // On transforme le nom original en nom sécurisé
		$newFileName = $safeFileName . '-' . uniqid() . '.' . $uploadedFile->guessExtension(); // On donne un nom final complet à notre fichier (comprenant un id unique, son extension, ...)

		try {
			$uploadedFile->move( // On envoie le fichier $newPictureFileName vers un dossier, dont le chemin est précisé dans services.yaml
				$this->targetDirectory,
				$newFileName
			);
		} catch (FileException $e) {
			return new Response("Il y a eu un problème lors du déplacement du fichier vers le dépôt");
		}

		$picture->setFilename($newFileName);
	}

	public function uploadAvatar(User $user)
	{
		$uploadedAvatar = $user->getAvatar();
		if($uploadedAvatar === null) {
			return;
		}
		$originalAvatarFilename = pathinfo($uploadedAvatar->getClientOriginalName(), PATHINFO_FILENAME); // On récupère le nom original du fichier, grâce à son chemin d'accès
		$safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalAvatarFilename); // On transforme le nom original en nom sécurisé
		$newFileName = $safeFileName . '-' . uniqid() . '.' . $uploadedAvatar->guessExtension(); // On donne un nom final complet à notre fichier (comprenant un id unique, son extension, ...)

		try {
			$uploadedAvatar->move( // On envoie le fichier $newPictureFileName vers un dossier, dont le chemin est précisé dans services.yaml
				$this->targetDirectory,
				$newFileName
			);
		} catch (FileException $e) {
			return new Response("Il y a eu un problème lors du déplacement du fichier vers le dépôt");
		}

		$user->setAvatarFilename($newFileName);
	}

}