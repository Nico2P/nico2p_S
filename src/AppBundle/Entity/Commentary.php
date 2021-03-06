<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="commentary")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaryRepository")
 */
class Commentary implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ne dois pas etre vide")
     */
    private $author;


    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ne dois pas etre vide")
     */
    private $content;



    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function jsonSerialize()
    {
        return array(
            'date' => $this->date,
            'author'=> $this->author,
            'content'=> $this->content,
        );
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

}