<?php

namespace Garopi\LegacyWrapperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 */
class Articles
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $categoryId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $pictureFileName;

    /**
     * @var string
     */
    private $pictureContentType;

    /**
     * @var integer
     */
    private $pictureFileSize;

    /**
     * @var \DateTime
     */
    private $pictureUpdatedAt;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var string
     */
    private $author;

    /**
     * @var boolean
     */
    private $hidden;


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
     * @return Articles
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
     * @return Articles
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
     * Set categoryId
     *
     * @param integer $categoryId
     * @return Articles
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Articles
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set pictureFileName
     *
     * @param string $pictureFileName
     * @return Articles
     */
    public function setPictureFileName($pictureFileName)
    {
        $this->pictureFileName = $pictureFileName;

        return $this;
    }

    /**
     * Get pictureFileName
     *
     * @return string 
     */
    public function getPictureFileName()
    {
        return $this->pictureFileName;
    }

    /**
     * Set pictureContentType
     *
     * @param string $pictureContentType
     * @return Articles
     */
    public function setPictureContentType($pictureContentType)
    {
        $this->pictureContentType = $pictureContentType;

        return $this;
    }

    /**
     * Get pictureContentType
     *
     * @return string 
     */
    public function getPictureContentType()
    {
        return $this->pictureContentType;
    }

    /**
     * Set pictureFileSize
     *
     * @param integer $pictureFileSize
     * @return Articles
     */
    public function setPictureFileSize($pictureFileSize)
    {
        $this->pictureFileSize = $pictureFileSize;

        return $this;
    }

    /**
     * Get pictureFileSize
     *
     * @return integer 
     */
    public function getPictureFileSize()
    {
        return $this->pictureFileSize;
    }

    /**
     * Set pictureUpdatedAt
     *
     * @param \DateTime $pictureUpdatedAt
     * @return Articles
     */
    public function setPictureUpdatedAt($pictureUpdatedAt)
    {
        $this->pictureUpdatedAt = $pictureUpdatedAt;

        return $this;
    }

    /**
     * Get pictureUpdatedAt
     *
     * @return \DateTime
     */
    public function getPictureUpdatedAt()
    {
        return $this->pictureUpdatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Articles
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Articles
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Articles
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
     * Set author
     *
     * @param string $author
     * @return Articles
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     * @return Articles
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean 
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}
