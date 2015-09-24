<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ArticleCategory
 *
 * @ORM\Entity
 * @ORM\Table(name="article_category")
 * @UniqueEntity("name")
 * @UniqueEntity("order")
 */
class ArticleCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Merci de préciser un nom de catégorie.")
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Merci de préciser une description de catégorie.")
     * @ORM\Column(name="description", type="string", length=511)
     */
    protected $description;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Merci de préciser un ordre d'affichage.")
     * @ORM\Column(name="appearance_order", type="integer")
     */
    protected $order;

    /**
     * @var string
     *
     * @ORM\Column(name="fontawesome_class", type="string", length=255, nullable=true)
     */
    protected $fontawesomeClass;

    /**
     * @var string
     *
     * @ORM\Column(name="displayed_on_homepage", type="boolean", options={"default": true})
     */
    protected $displayedOnHomepage = true;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @var ArrayCollection $gangs
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Article", mappedBy="category", cascade={"persist"}, fetch="EAGER")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $articles;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return ArticleCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return ArticleCategory
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add articles
     *
     * @param Article $article
     *
     * @return ArticleCategory
     */
    public function addArticle(Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param Article $article
     */
    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return int
     */
    public function getNbArticles()
    {
        return $this->articles->count();
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return ArticleCategory
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
     * Set fontawesomeClass
     *
     * @param string $fontawesomeClass
     *
     * @return ArticleCategory
     */
    public function setFontawesomeClass($fontawesomeClass)
    {
        $this->fontawesomeClass = $fontawesomeClass;

        return $this;
    }

    /**
     * Get fontawesomeClass
     *
     * @return string 
     */
    public function getFontawesomeClass()
    {
        return $this->fontawesomeClass;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ArticleCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set displayedOnHomepage
     *
     * @param boolean $displayedOnHomepage
     * @return ArticleCategory
     */
    public function setDisplayedOnHomepage($displayedOnHomepage)
    {
        $this->displayedOnHomepage = $displayedOnHomepage;

        return $this;
    }

    /**
     * Get displayedOnHomepage
     *
     * @return boolean 
     */
    public function getDisplayedOnHomepage()
    {
        return $this->displayedOnHomepage;
    }
}
