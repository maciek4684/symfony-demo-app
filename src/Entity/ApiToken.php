<?php

namespace App\Entity;

use App\Strategy\TaskEvaluator;
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
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"view_user"})
     */
    private string $token;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"view_user"})
     */
    private \DateTime $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AppUser", inversedBy="apiTokens")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?AppUser $user;

    public function __construct(?UserInterface $user = null)
    {
        $this->token = bin2hex(random_bytes(32));
        $this->expiresAt = new \DateTime('+24 hours');
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
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
