<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "The Title must be at least {{ limit }} characters long",
     *      maxMessage = "The Title cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 500,
     *      minMessage = "The Description must be at least {{ limit }} characters long",
     *      maxMessage = "The Description cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Assert\Length(
     *      min = 4,
     *      max = 200,
     *      minMessage = "The Image Url must be at least {{ limit }} characters long",
     *      maxMessage = "The Image Url cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="image_url", type="string", length=200)
     */
    private $imageUrl;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Offer
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
     * Set description
     *
     * @param string $description
     *
     * @return Offer
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
     * Set email
     *
     * @param string $email
     *
     * @return Offer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Offer
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Offer
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}

