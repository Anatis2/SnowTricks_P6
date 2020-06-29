<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @Assert\File(
	 *      maxSize = "1500k",
			mimeTypes = { "image/png" }
	 * )
	 */
    private $file;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
    private $filename;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=true)
     */
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return mixed
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * @param mixed $file
	 */
	public function setFile($file): void
	{
		$this->file = $file;
	}



	public function getFilename()
	{
		return $this->filename;
	}

	public function setFilename($filename)
	{
		$this->filename = $filename;

	}

	public function getAlt()
	{
		return $this->alt;
	}

	public function setAlt($alt): void
	{
		$this->alt = $alt;
	}

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }

}
