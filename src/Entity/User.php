<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`userr`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="idU")
     */
    private $idU;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var Role[]
     *
     * Many Users have many roles
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles",  joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="idU")})
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $prenom;

    /**
     * @var string
     * @ORM\Column(type="string", options={"Femme","Homme"}, name="BIO")
     */
    private $bio;

    /**
     * @var string
     * @ORM\Column(type="string", name="Age")
     * @Assert\Range(min="10", max="120")
     */
    private $age;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $tel;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, options={"Membre", "Enseignant", "admin"})
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $enable;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->type = 'Membre';
        $this->enable = false;
    }

    /**
     * @return int
     */
    public function getIdU(): ?int
    {
        return $this->idU;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->idU;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return (string)$this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];
        foreach ($this->roles as $role) {
            $name = $role->getName();
            if (!str_starts_with($name, "ROLE_")) {
                $name = "ROLE_" . $name;
            }
            array_push($roles, $name);
        }

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function addRole(Role $role): self
    {
        $this->roles->add($role);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
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
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return string
     */
    public function getAge(): ?string
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge(string $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * @param $size
     * @return string
     */
    public function getAvatarUrl($size)
    {
        return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBba0js-FmmQZDKqlMWoxKtzoT5Fg_mpdeMw&usqp=CAU";
    }


    /**
     * @return string
     */
    function getColorCode()
    {
        $code = dechex(crc32($this->getUsername()));
        $code = substr($code, 0, 6);
        return "#" . $code;
    }

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }
}