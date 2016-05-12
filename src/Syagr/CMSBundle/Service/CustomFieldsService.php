<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03.03.16
 * Time: 19:27
 */

namespace Syagr\CMSBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Syagr\MediaBundle\Traits\SetMediaManagerTrait;

class CustomFieldsService
{
    use SetMediaManagerTrait;
    
    const MEDIA_REPOSITORY = 'SyagrMediaBundle:Media';

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @param array $data
     * @param string $start
     * @return bool
     */
    public function convertToArray(&$data, $start = 'fields')
    {
        if (!is_array($data)) return false;
        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                if ($key === $start) {
                    foreach ($value as $k => &$v) {
                        $v['name'] = $k;
                    }
                    $value = array_values($value);
                    unset($v);
                }
                $this->convertToArray($value);
            }
        }
        unset($value);
    }

    /**
     * @param array $data
     * @param array $config
     * @return array
     */
    public function processDataForSaving(array $data, array $config)
    {
        foreach ($data as $key => $item) {
            if (isset($config[$key])) {
                if ($config[$key]['type'] === 'repeat') {
                    $data[$key] = $this->processRepeatForSaving($item, $config[$key]['fields']);
                } elseif ($config[$key]['type'] === 'file') {
                    $data[$key] = $this->processMediaForSaving($item);
                }
            } else {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param array $config
     * @return array
     */
    protected function processRepeatForSaving(array $data, array $config)
    {
        $newData = [];

        foreach ($data as $item) {
            $newData[] = $this->processDataForSaving($item, $config);
        }

        return $newData;
    }

    /**
     * @param $media
     * @return mixed
     */
    protected function processMediaForSaving($media)
    {
        return $media['media']['id'];
    }

    /**
     * @param array $data
     * @param array $config
     * @return array
     */
    public function processDataForLoading(array $data, array $config)
    {
        $data = $this->bindMedias($data, $config);

        return $data;
    }

    /**
     * @param array $data
     * @param array $config
     * @return array
     */
    protected function bindMedias(array $data, array $config)
    {
        $medias = $this->getAllMedias($data, $config);
        $data   = $this->bindMediaWorker($data, $config, $medias);

        return $data;
    }

    /**
     * @param array $data
     * @param array $config
     * @return array
     */
    protected function getAllMedias(array $data, array $config)
    {
        $ids = $this->getMediaIds([], $data, $config);

        if (!count($ids)) {
            return $data;
        } else {
            $newIds = [];

            foreach ($ids as $item){
                $newIds[$item] = $item;
            }

            $ids = [];
            foreach ($newIds as $item){
                $ids[] = $item;
            }
            unset($newIds);
        }

        $medias = $this->em->getRepository(self::MEDIA_REPOSITORY)->findBy(['id' => $ids]);
        $newMedias = [];

        foreach ($medias as $item){
            $newMedias[$item->getId()] = $item;
        }

        return $newMedias;
    }

    /**
     * @param $ids
     * @param array $data
     * @param array $config
     * @return array
     */
    protected function getMediaIds($ids, array $data, array $config)
    {
        foreach ($config as $key => $item) {
            if ('file' === $item['type']) {
                $ids[] = $data[$key];
            } elseif ('repeat' === $item['type']) {
                $ids = array_merge($ids, $this->getMediaIds([], $data[$key], $item['fields']));
            }
        }

        return $ids;
    }

    protected function bindMediaWorker($data, $config, $medias){
        /*foreach (){
            
        }*/
        
        return $data;
    }
    
    protected function processMediaForLoad($id, $medias){
        
    }
}
