<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\title]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'text', length:100)]
    private $title;

    #[ORM\body]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'text')]
    private $body;

    // getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    // get / set title

    public function getTitle() 
    {
        return $this->title; 
    }

    public function setTitle($title) 
    {
        $this->title = $title; 
    }

    // get / set body

    public function getBody() 
    {
        return $this->body; 
    }

    public function setBody($body) 
    {
        $this->body = $body; 
    }

}

// if we wanted to add more fields we would have to do it here and than run doctrine:migrations:diff 
// and doctrine:migrations:migrate
