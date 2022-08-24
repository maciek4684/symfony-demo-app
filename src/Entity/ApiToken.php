<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApiTokenRepository")
 */
class ApiToken
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"view_user"})
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"view_user"})
     */
    private $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AppUser", inversedBy="apiTokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->token = bin2hex(random_bytes(32));
        $this->user = $user;
        $this->expiresAt = new \DateTime('+24 hours');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function getUser(): ?AppUser
    {
        return $this->user;
    }

    public function setUser(?AppUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isExpired(): bool
    {
        return $this->getExpiresAt() <= new \DateTime();
    }

}
