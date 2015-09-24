<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article
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
     * @var string
     *
     * @Assert\NotBlank(message="Merci de préciser un titre.")
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Merci de préciser un résumé.")
     * @ORM\Column(name="summary", type="string", length=511)
     */
    protected $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content = "";

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Merci de préciser un nom d'auteur.")
     * @ORM\Column(name="author_name", type="string", length=255)
     */
    protected $authorName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    protected $published = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="email_sent", type="boolean", options={"default"=true})
     */
    protected $emailSent = false;

    /**
     * @Gedmo\Slug(fields={"id", "title"})
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="legacy_id", unique=true, nullable=true)
     */
    protected $legacyId;

    /**
     * @var ArrayCollection $categories
     *
     * @Assert\NotNull(message="Veuillez associer l'article à une catégorie")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArticleCategory", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    protected $category;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArticleMedia", cascade={"persist", "remove"}, mappedBy="article")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $medias;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", cascade={"persist", "remove"}, mappedBy="article")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    protected $comments;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reading", cascade={"persist", "remove"}, mappedBy="article")
     */
    protected $readings;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->title;
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
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set authorName
     *
     * @param string $authorName
     *
     * @return Article
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string 
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Article
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set category
     *
     * @param ArticleCategory $category
     *
     * @return Article
     */
    public function setCategory(ArticleCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return ArticleCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->readings = new ArrayCollection();
    }

    /**
     * Add medias
     *
     * @param ArticleMedia $media
     *
     * @return Article
     */
    public function addMedia(ArticleMedia $media)
    {
        $this->medias[] = $media;
        $media->setArticle($this);

        return $this;
    }

    /**
     * Remove medias
     *
     * @param ArticleMedia $media
     */
    public function removeMedia(ArticleMedia $media)
    {
        $this->medias->removeElement($media);
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Article
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setArticle($this);

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
     * @return integer
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
     * @return Article
     */
    public function addReading(Reading $reading)
    {
        $this->readings[] = $reading;
        $reading->setArticle($this);

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

    /**
     * Get nb readings
     *
     * @return integer
     */
    public function getNbReadings()
    {
        return $this->readings->count();
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Article
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set legacyId
     *
     * @param string $legacyId
     * @return Article
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = $legacyId;

        return $this;
    }

    /**
     * Get legacyId
     *
     * @return string 
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     * Set emailSent
     *
     * @param boolean $emailSent
     * @return Article
     */
    public function setEmailSent($emailSent)
    {
        $this->emailSent = $emailSent;

        return $this;
    }

    /**
     * Get emailSent
     *
     * @return boolean 
     */
    public function getEmailSent()
    {
        return $this->emailSent;
    }
}
