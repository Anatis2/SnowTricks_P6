<?php

namespace App\EventListeners;

use App\Entity\Picture;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class RemoveFileListener
{
	private $targetDirectory;

	public function __construct($targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function postRemove(Picture $picture, LifecycleEventArgs $event)
	{
		$name = $picture->getFilename();
		$path = $this->targetDirectory . "/" . $name;

		if ($name === null) return;
		if (!strlen($name)) return;

		if (file_exists($path)) unlink($path);
	}

}

