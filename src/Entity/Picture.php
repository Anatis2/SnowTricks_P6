<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @Vich\Uploadable
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
	 * @Vich\UploadableField(mapping="property_picture", fileNameProperty="fileName")
	 * @var File|null
	 */
	private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="pictures")
	 * @ORM\JoinColumn(nullable=false, name="trick_id", referencedColumnName="id")
     */
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return File|null
	 */
	public function getImageFile(): ?File
	{
		return $this->imageFile;

		return $this;
	}

	/**
	 * @param File|null $imageFile
	 */
	public function setImageFile(?File $imageFile): void
	{
		$this->imageFile = $imageFile;
	}

	/**
	 * @return string|null
	 */
	public function getFileName(): ?string
	{
		return $this->fileName;

		return $this;
	}

	/**
	 * @param string|null $fileName
	 */
	public function setFileName(?string $fileName): void
	{
		$this->fileName = $fileName;
	}

    public function getLink(): ?string
    {
        return $this->link;

		return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
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
