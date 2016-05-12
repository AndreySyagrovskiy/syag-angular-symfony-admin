<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 22:16
 */

namespace Syagr\CMSBundle\Service;


use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorProcessService
{
    /**
     * @param ConstraintViolationListInterface $errorList
     * @return array
     */
    public function getAssociativeArrayOfErrors(ConstraintViolationListInterface $errorList){
        $errors = [];

        foreach($errorList as $item){
            $errors[$item->getPropertyPath()][] = $item->getMessage();
        }

        return $errors;
    }

    public function getMessageString(ConstraintViolationListInterface $errorList){
        $errorsString = '';
        $count = 0;

        foreach($errorList as $key => $item){
            if($count)
                $errorsString .= "\r\n";
            $errorsString .= $item->getPropertyPath() . ' - ' .$item->getMessage();
            $count++;
        }

        return $errorsString;
    }

    public function getResponseErrors(ConstraintViolationListInterface $errorList){
        $errors = $this->getAssociativeArrayOfErrors($errorList);
        $errorsString = $this->getMessageString($errorList);

        return [
            'error'  => $errorsString,
            'errors' => $errors
        ];
    }
}