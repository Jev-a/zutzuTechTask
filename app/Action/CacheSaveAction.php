<?php

namespace ZTT\app\Action;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use ZTT\app\GitHub;
use ZTT\app\Model\Cache;
use ZTT\app\Service\OrganizationService;

class CacheSaveAction
{
    /** @var Cache */
    private $cache;
    /** @var GitHub */
    private $client;
    /** @var OrganizationService  */
    private $organizationService;

    public function __construct()
    {
        $this->cache = new Cache();
        $this->client = new GitHub();
        $this->organizationService = new OrganizationService();
    }

    /**
     * @param string $method
     * @return string
     * @throws GuzzleException
     */
    public function fire(string $method)
    {
        try {
            $this->client->setMethod($method);
            $result = $this->client->getGetData();

            if ($result) {
                $key = $this->organizationService->getLastOrganizationId($result);
                if (!$this->cache->exists($key)) {
                    $this->cache->set($key, $result, 60);
                }
            }
        } catch (RequestException $exception) {
            throw new RequestException($exception->getMessage());
        }
    }
}
