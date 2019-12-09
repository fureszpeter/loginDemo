<?php

namespace  App\Domain\Entities;

use Carbon\Carbon;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use JsonSerializable;

/**
 * Users.
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="users_email_unique", columns={"email"}), @ORM\UniqueConstraint(name="users_username_unique", columns={"username"})})
 * @ORM\Entity(repositoryClass="App\Domain\Repositories\UserRepository")
 */
class User implements Authenticatable, JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var null|DateTimeImmutable
     *
     * @ORM\Column(name="email_verified_at", type="datetime_immutable", nullable=true)
     */
    private $emailVerifiedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var null|string
     *
     * @ORM\Column(name="remember_token", type="string", length=100, nullable=true)
     */
    private $rememberToken;

    /**
     * @var null|DateTimeImmutable
     *
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @var null|DateTimeImmutable
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $name, string $username, string $email, string $password)
    {
        $now = Carbon::now()->toImmutable();

        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

        $this->createdAt = $now;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthIdentifier(): string
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getRememberTokenName(): string
    {
        return 'rememberToken';
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'createdAt' => $this->createdAt->format(DATE_ATOM),
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
