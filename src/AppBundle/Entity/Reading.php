<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Reading
 *
 * @ORM\Table(name="reading")
 * @ORM\Entity
 */
class Reading
{
    use TimestampableEntity;
    use IpTraceableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article", cascade={"persist"}, inversedBy="readings")
     */
    protected $article;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"}, inversedBy="readings")
     */
    protected $reader;

    /**
     * @param User      $user
     * @param Article   $article
     */
    public function __construct(User $user, Article $article)
    {
        $this->reader = $user;
        $this->article = $article;
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
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     * @return Reading
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set reader
     *
     * @param \AppBundle\Entity\User $reader
     * @return Reading
     */
    public function setReader(User $reader = null)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Get reader
     *
     * @return \AppBundle\Entity\User 
     */
    public function getReader()
    {
        return $this->reader;
    }
}
