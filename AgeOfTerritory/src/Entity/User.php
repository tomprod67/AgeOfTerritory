<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "L'adresse mail {{ value }} n'est pas une adresse email valide.",
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit comporté au minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Le mot de passe et la confirmation de sont pas identiques !")
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $recordDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lastLoginTimestamp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evolution", inversedBy="users")
     */
    private $evolution;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="author")
     */
    private $messages;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Isle", mappedBy="user")
     */
    private $isles;

    /**
     * @ORM\Column(type="array", nullable=true)
     *
     */
    private $roles = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Isle", inversedBy="userMainIsle", cascade={"persist", "remove"})
     */
    private $mainIsle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="cible")
     */
    private $messageCible;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingUnit")
     */
    private $preferenceUnitSpy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingMachine")
     */
    private $preferenceMachineSpy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NbPreferenceSpy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lastLogoutTimestamp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbUnreadMessage;


    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->searchTechnologies = new ArrayCollection();
        $this->isles = new ArrayCollection();
        $this->mainIsle = new ArrayCollection();
        $this->messageCible = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }


    public function setConfirmPassword($confirm_password): void
    {
        $this->confirm_password = $confirm_password;
    }


    public function getRecordDate(): ?\DateTimeInterface
    {
        return $this->recordDate;
    }

    public function setRecordDate(\DateTimeInterface $recordDate): self
    {
        $this->recordDate = $recordDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastLoginTimestamp()
    {
        return $this->lastLoginTimestamp;
    }

    /**
     * @param mixed $lastLoginTimestamp
     */
    public function setLastLoginTimestamp($lastLoginTimestamp): void
    {
        $this->lastLoginTimestamp = $lastLoginTimestamp;
    }

    /**
     * @return mixed
     */
    public function getLastLogoutTimestamp()
    {
        return $this->lastLogoutTimestamp;
    }

    /**
     * @param mixed $lastLogoutTimestamp
     */
    public function setLastLogoutTimestamp($lastLogoutTimestamp): void
    {
        $this->lastLogoutTimestamp = $lastLogoutTimestamp;
    }





    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


    public function getEvolution(): ?Evolution
    {
        return $this->evolution;
    }

    public function setEvolution(?Evolution $evolution): self
    {
        $this->evolution = $evolution;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Isle[]
     */
    public function getIsles(): Collection
    {
        return $this->isles;
    }

    public function addIsle(Isle $isle): self
    {
        if (!$this->isles->contains($isle)) {
            $this->isles[] = $isle;
            $isle->setUser($this);
        }

        return $this;
    }

    public function removeIsle(Isle $isle): self
    {
        if ($this->isles->contains($isle)) {
            $this->isles->removeElement($isle);
            // set the owning side to null (unless already changed)
            if ($isle->getUser() === $this) {
                $isle->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // tous les utilisateurs on le role user
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    /**
     * @return mixed
     */
    public function getMainIsle()
    {
        return $this->mainIsle;
    }

    /**
     * @param mixed $mainIsle
     */
    public function setMainIsle($mainIsle): void
    {
        $this->mainIsle = $mainIsle;
    }



    public function __toString():String
    {
        return $this->username;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessageCible(): Collection
    {
        return $this->messageCible;
    }

    public function addMessageCible(Message $messageCible): self
    {
        if (!$this->messageCible->contains($messageCible)) {
            $this->messageCible[] = $messageCible;
            $messageCible->setCible($this);
        }

        return $this;
    }

    public function removeMessageCible(Message $messageCible): self
    {
        if ($this->messageCible->contains($messageCible)) {
            $this->messageCible->removeElement($messageCible);
            // set the owning side to null (unless already changed)
            if ($messageCible->getCible() === $this) {
                $messageCible->setCible(null);
            }
        }

        return $this;
    }

    public function getPreferenceUnitSpy(): ?TrainingUnit
    {
        return $this->preferenceUnitSpy;
    }

    public function setPreferenceUnitSpy(?TrainingUnit $preferenceUnitSpy): self
    {
        $this->preferenceUnitSpy = $preferenceUnitSpy;

        return $this;
    }

    public function getPreferenceMachineSpy(): ?TrainingMachine
    {
        return $this->preferenceMachineSpy;
    }

    public function setPreferenceMachineSpy(?TrainingMachine $preferenceMachineSpy): self
    {
        $this->preferenceMachineSpy = $preferenceMachineSpy;

        return $this;
    }

    public function getNbPreferenceSpy(): ?int
    {
        return $this->NbPreferenceSpy;
    }

    public function setNbPreferenceSpy(?int $NbPreferenceSpy): self
    {
        $this->NbPreferenceSpy = $NbPreferenceSpy;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getNbUnreadMessage(): ?int
    {
        return $this->nbUnreadMessage;
    }

    public function setNbUnreadMessage(?int $nbUnreadMessage): self
    {
        $this->nbUnreadMessage = $nbUnreadMessage;

        return $this;
    }


}
