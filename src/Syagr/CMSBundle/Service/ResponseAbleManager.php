<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.01.16
 * Time: 0:15
 */

namespace Syagr\CMSBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Syagr\CMSBundle\Exception\ManagerException;
use Syagr\CMSBundle\Exception\NotFoundManagerException;
use Syagr\CMSBundle\Exception\AccessForbiddenManagerException;


class ResponseAbleManager
{
    /**
     * @return array
     */
    public function getResponse()
    {
        try {
            $args = func_get_args();
            $method = $args[0];
            unset($args[0]);
            $result = call_user_func_array(array($this, $method), $args);

            return ['response' => $result, 'code' => Response::HTTP_OK];

        } catch (NotFoundManagerException $ex) {
            return ['response' => ['error' => $ex->getMessage()], 'code' => Response::HTTP_NOT_FOUND];
        }catch (AccessForbiddenManagerException $ex) {
            return ['response' => ['error' => $ex->getMessage()], 'code' => Response::HTTP_FORBIDDEN];
        } catch (ManagerException $ex) {
            return ['response' => ['error' => $ex->getMessage()], 'code' => Response::HTTP_BAD_REQUEST];
        }
    }
}