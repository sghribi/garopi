<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("username")
 */
class User extends BaseUser implements UserInterface
{
    use TimestampableEntity;
    use IpTraceableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $firstName
     *
     * @Assert\NotBlank(message="Merci de préciser votre prénom.", groups={"Registration"})
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string $lastName
     *
     * @Assert\NotBlank(message="Merci de préciser votre nom.", groups={"Registration"})
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    protected $lastName;

    /**
     * @var string
     *
     * String corresponding to the photo of the user encoded in base64
     *
     * @ORM\Column(name="photo", type="text", nullable=true)
     */
    protected $photo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wants_to_receive_mails", type="boolean", options={"default" = false})
     */
    protected $wantsToReceiveMails = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", cascade={"persist", "remove"}, mappedBy="author")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    protected $comments;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reading", cascade={"persist", "remove"}, mappedBy="reader")
     */
    protected $readings;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
        $this->comments = new ArrayCollection();
        $this->readings = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set wantsToReceiveMails
     *
     * @param boolean $wantsToReceiveMails
     *
     * @return User
     */
    public function setWantsToReceiveMails($wantsToReceiveMails)
    {
        $this->wantsToReceiveMails = $wantsToReceiveMails;

        return $this;
    }

    /**
     * Get wantsToReceiveMails
     *
     * @return boolean 
     */
    public function getWantsToReceiveMails()
    {
        return $this->wantsToReceiveMails;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return User
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setAuthor($this);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get nb comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNbComments()
    {
        return $this->comments->count();
    }

    /**
     * Add reading
     *
     * @param Reading $reading
     *
     * @return User
     */
    public function addReading(Reading $reading)
    {
        $this->readings[] = $reading;
        $reading->setReader($this);

        return $this;
    }

    /**
     * Remove reading
     *
     * @param Reading $readings
     */
    public function removeReading(Reading $reading)
    {
        $this->readings->removeElement($reading);
    }

    /**
     * Get readings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReadings()
    {
        return $this->readings;
    }
}
