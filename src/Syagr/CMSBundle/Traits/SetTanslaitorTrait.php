<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 18:46
 */

namespace Syagr\CMSBundle\Traits;

use Symfony\Component\Translation\TranslatorInterface as  Translator;


trait SetTanslaitorTrait
{
    /* @var Translator */
    protected $trans;

    /**
     * @param Translator $trans
     * @return $this
     */
    public function setTrans(Translator $trans){
        $this->trans = $trans;
        return $this;
    }
}