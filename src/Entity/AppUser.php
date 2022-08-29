<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppUserRepository")
 * @UniqueEntity(fields={"email"}, message="Użytkownik o podanym adresie email już istnieje w systemie.")
 */
class AppUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message = "Podana wartość: {{ value }} nie jest poprawnym adresem email.")
     * @Assert\NotBlank()
     * @Groups({"view_tasksubmit", "view_user", "view_exam_results"})
     */
    private string $email;

    /**
     * @Gedmo\Slug(fields={"email"})
     * @ORM\Column(type="string", length=200, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $password;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $last_login;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaskSubmit",
     *     mappedBy="user",
     *     cascade={"remove"})
     */
    private Collection $taskSubmits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ApiToken", mappedBy="user", orphanRemoval=true)
     */
    private Collection $apiTokens;

    public function __construct()
    {
        $this->taskSubmits = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier():string
    {
        return (string) $this->email;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeInterface $date): self
    {
        $this->last_login = $date;

        return $this;
    }

    /**
     * @return Collection|TaskSubmit[]
     */
    public function getTaskSubmits(): Collection
    {
        return $this->taskSubmits;
    }

    public function addTaskSubmit(TaskSubmit $taskSubmit): self
    {
        if (!$this->taskSubmits->contains($taskSubmit)) {
            $this->taskSubmits[] = $taskSubmit;
            $taskSubmit->setUser($this);
        }

        return $this;
    }

    public function removeTaskSubmit(TaskSubmit $taskSubmit): self
    {
        if ($this->taskSubmits->contains($taskSubmit)) {
            $this->taskSubmits->removeElement($taskSubmit);
            // set the owning side to null (unless already changed)
            if ($taskSubmit->getUser() === $this) {
                $taskSubmit->setUser(null);
            }
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->email;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    /**
     * @return Collection|ApiToken[]
     * @Groups({"view_user"})
     */
    public function getValidApiTokens(): Collection
    {
        $tokens = new ArrayCollection();
        foreach ($this->getApiTokens() as $token)
        {
            if (!$token->isExpired())
            {
                $tokens->add($token);
            }
        }
        return $tokens;

    }

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
            $apiToken->setUser($this);
        }

        return $this;
    }

    private function removeApiToken(ApiToken $apiToken): self
    {
        if ($this->apiTokens->contains($apiToken)) {
            $this->apiTokens->removeElement($apiToken);
            // set the owning side to null (unless already changed)
            if ($apiToken->getUser() === $this) {
                $apiToken->setUser(null);
            }
        }

        return $this;
    }
}
