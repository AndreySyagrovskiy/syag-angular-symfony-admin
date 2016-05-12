<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.01.16
 * Time: 18:12
 */

namespace Syagr\PageBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Syagr\PageBundle\Entity\Page;

class NgAdminPageEditDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     * )
     */
    public $title;

    public $text;

    public $slug;

    public $customs;

    public $style;

    /**
     * @param Page $page
     * @return $this
     */
    public function bindPage(Page $page){
        $this->title   = $page->getTitle();
        $this->text    = $page->getText();
        $this->slug    = $page->getSlug();
        $this->customs = $page->getCustoms();
        $this->style   = $page->getStyle();

        return $this;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function bindRequest(Request $request){
        $this->title   = $request->request->get('title');
        $this->text    = $request->request->get('text');
        $this->slug    = $request->request->get('slug');
        $this->customs = $request->request->get('customs');
        $this->style   = $request->request->get('style');

        return $this;
    }

    /**
     * @param Page $page
     * @return Page
     */
    public function loadDataToPage(Page $page){
        $page->setTitle($this->title);
        $page->setText($this->text);
        $page->setSlug($this->slug);
        $page->setCustoms($this->customs);
        $page->setStyle($this->style);

        return $page;
    }

}