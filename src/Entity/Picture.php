<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks()
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
	 *      maxSizeMessage = "Ce fichier ne doit pas dépasser 1500k",
	 *		mimeTypes = { "image/png" },
	 *      mimeTypesMessage = "Seuls les fichiers de type .png sont autorisés"
	 * )
	 */
    private $file;

	/**
	 * @ORM\Column(type="string", length=255)
	 * #Assert\NotBlank
	 */
    private $filename;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
    private $alt;

	/**
	 * @ORM\Column(type="datetime")
	 */
    private $createdAt;

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
	public function setFile($file)
	{
		$this->file = $file;
		return $this;
	}


	public function getFilename()
	{
		return $this->filename;
	}

	public function setFilename($filename)
	{
		$this->filename = $filename;
		return $this;

	}

	public function getAlt()
	{
		return $this->alt;
	}

	public function setAlt($alt)
	{
		$this->alt = $alt;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param mixed $createdAt
	 */
	public function setCreatedAt($createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onPrePersist()
	{
		$this->createdAt = new DateTime();
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

	/**
	 * @Assert\IsTrue(message="Vous avez oublié le fichier pour votre image !")
	 */
	public function hasFile() {
		if ($this->filename !== null && $this->filename !== '') return true;
		if ($this->file !== null) return true;
		return false;
	}

}
