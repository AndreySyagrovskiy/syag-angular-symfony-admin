<?php

/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 13:09
 */

namespace Syagr\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Syagr\PageBundle\Repository\PageRepository")
 * @ORM\Table(name="page",
        indexes={
            @ORM\Index(name="slug", columns={"slug"}),
        }
    )
 *
 */
class Page
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $customs;

    /**
     * @ORM\Column(type="text", name="meta_desciption", nullable=true)
     */
    private $metaDesctiption;

    /**
     * @Gedmo\Slug(fields={"title"}, separator="-", updatable=false, style="defaul", unique=true)
     * @ORM\Column(name="slug", type="string", length=58)
     */
    protected $slug;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    private $style;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
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
     * Set text
     *
     * @param string $text
     *
     * @return Page
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set customs
     *
     * @param string $customs
     *
     * @return Page
     */
    public function setCustoms($customs)
    {
        $this->customs = $customs;

        return $this;
    }

    /**
     * Get customs
     *
     * @return string
     */
    public function getCustoms()
    {
        return $this->customs;
    }

    /**
     * Set metaDesctiption
     *
     * @param string $metaDesctiption
     *
     * @return Page
     */
    public function setMetaDesctiption($metaDesctiption)
    {
        $this->metaDesctiption = $metaDesctiption;

        return $this;
    }

    /**
     * Get metaDesctiption
     *
     * @return string
     */
    public function getMetaDesctiption()
    {
        return $this->metaDesctiption;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Page
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
     * Set style
     *
     * @param string $style
     *
     * @return Page
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }
}
