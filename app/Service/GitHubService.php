<?php

namespace ZTT\app\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use ZTT\app\Action\CacheSaveAction;
use ZTT\app\Model\Cache;

class GitHubService
{
    /** @var CacheSaveAction */
    private $cacheSaveAction;
    /** @var Cache */
    private $cache;

    /**
     * GitHubService constructor.
     */
    public function __construct()
    {
        $this->cacheSaveAction = new CacheSaveAction();
        $this->cache = new Cache();
    }

    /**
     * @throws GuzzleException
     */
    public function downloadMoreOrganizations()
    {
        $flags = $this->cache->getCacheFlags();
        if (empty($flags)) {
            $this->downloadOrganization();
        } else {
            $method = '/organizations?since=' . max($flags);
            try {
                $this->cacheSaveAction->fire($method);
            } catch (ClientException $exception) {
                print ($exception->getMessage());
            }
        }
    }

    /**
     * @throws GuzzleException
     */
    public function downloadOrganization()
    {
        try {
            $this->cacheSaveAction->fire('/organizations');
        } catch (ClientException $e) {
            print($e->getMessage());
        }
    }
}
