<?php

namespace ZTT\app\Model;

use ZTT\app\CacheInterface;

class Cache implements CacheInterface
{
    protected $fileName;

    /**
     * @param string $key
     * @param mixed $value
     * @param int $duration
     *
     * @return mixed|void
     */
    public function set(string $key, $value, int $duration)
    {
        $this->setFileName(ROOT.'/../cache/'.$key.'_'.$duration);
        file_put_contents($this->getFileName(), $value);
    }

    /**
     * @param string $key
     *
     * @return false|int|mixed|null
     */
    public function get(string $key)
    {
        return file_get_contents(ROOT.'/'.$key);
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return unlink(ROOT.'/'.$key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        $flags = $this->getCacheFlags();
        if (empty($flags)) {
            return false;
        }

        return array_key_exists($key, $flags);
    }

    /**
     * @return mixed|void
     */
    public function clear()
    {
        $files = $this->getAllFilesName();
        if (!empty($files)) {
            foreach($files as $file)
            {
                $this->delete($file);
            }
        }
    }

    /**
     * @return array
     */
    public function getCacheFlags(): array
    {
        $flags = [];
        $files = $this->getAllFilesName();
        foreach($files as $file)
        {
            $fileName = substr(strrchr($file, "/"),1);
            $flag = explode('_', $fileName);
            $flags[] = $flag[0];
        }
        return $flags;
    }

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
        foreach($files as $file)
        {
            $liveTime = substr(strrchr($file, "_"),1);
            if(filemtime($file) <= strtotime('-'.$liveTime.' seconds'))
            {
                $this->delete($file);
            }
        }
    }
}
