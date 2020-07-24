<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Cet email est déjà utilisé")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message="Veuillez taper un email valide")
     */
    private $email;

	/**
	 * @Assert\File(
	 *      maxSize = "1500k",
	 *      maxSizeMessage = "Ce fichier ne doit pas dépasser 1500k",
	 *		mimeTypes = { "image/png" },
	 *      mimeTypesMessage = "Seuls les fichiers de type .png sont autorisés"
	 * )
	 */
    private $avatar;

	/**
	 * @ORM\Column(type="string", length=255, unique=false, nullable=true)
	 */
    private $avatarFilename;

    /**
     * @ORM\Column(type="string", length=255, unique=false, nullable=true)
     */
    private $phonenumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $activation_token;

	/**
	 * @ORM\Column(type="boolean", nullable=true, options={"default" : 0}))
	 */
	private $activated_token;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $reset_token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user")
     */
    private $tricks;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getAvatar()
	{
		return $this->avatar;
	}

	/**
	 * @param mixed $avatar
	 */
	public function setAvatar($avatar)
	{
		$this->avatar = $avatar;
	}

	/**
	 * @return mixed
	 */
	public function getAvatarFilename()
	{
		return $this->avatarFilename;
	}

	/**
	 * @param mixed $avatarFilename
	 */
	public function setAvatarFilename($avatarFilename)
	{
		$this->avatarFilename = $avatarFilename;
		return $this;
	}

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;
        return $this;
    }


    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getActivationToken()
	{
		return $this->activation_token;
	}

	/**
	 * @param mixed $activation_token
	 */
	public function setActivationToken($activation_token)
	{
		$this->activation_token = $activation_token;
	}

	/**
	 * @return mixed
	 */
	public function getActivatedToken()
	{
		return $this->activated_token;
	}

	/**
	 * @param mixed $activated_token
	 */
	public function setActivatedToken($activated_token)
	{
		$this->activated_token = $activated_token;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResetToken()
	{
		return $this->reset_token;
	}

	/**
	 * @param mixed $reset_token
	 */
	public function setResetToken($reset_token)
	{
		$this->reset_token = $reset_token;
	}


    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
             $this->id,
             $this->email,
             $this->password
         ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
             $this->id,
             $this->email,
             $this->password
             ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
