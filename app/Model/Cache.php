<?php

namespace zutzuTechTask\app\Model;

use zutzuTechTask\app\CacheInterface;

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
        $this->setFileName('cache/'.$key.'_'.$duration);
        file_put_contents($this->getFileName(), $value);
    }

    /**
     * @param string $key
     *
     * @return false|int|mixed|null
     */
    public function get(string $key)
    {
        if (file_exists('cache/'.$key)) {
           return readfile('cache/'.$key);
        }

        return null;
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

    public function delete(string $key)
    {
        // TODO: Implement delete() method.
    }

    public function exists(string $key)
    {
        // TODO: Implement exists() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }
}