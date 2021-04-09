<?php

namespace ZTT\app\Service;

use ZTT\app\Model\Cache;

class CacheService
{
    /**
     * @return array|false
     */
    public function getAllFilesName()
    {
        return glob('../cache/*');
    }

    /**
     * @return array|false
     */
    public function deleteByTimeout()
    {
        $files = $this->getAllFilesName();
        foreach(glob('../cache/*') as $file)
        {
            $liveTime = substr(strrchr($file, "_"),1);
            if(filemtime($file) <= strtotime('-'.$liveTime.' seconds'))
            {
               (new Cache())->delete($file);
            }
        }
    }
}
