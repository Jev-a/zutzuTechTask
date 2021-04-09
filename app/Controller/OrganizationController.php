<?php

namespace ZTT\app\Controller;

use GuzzleHttp\Exception\GuzzleException;
use ZTT\app\Model\Cache;
use ZTT\app\Service\CacheService;
use ZTT\app\Service\GitHubService;
use ZTT\app\Service\OrganizationService;

class OrganizationController
{
    /** @var OrganizationService */
    protected $organizationService;
    /** @var CacheService */
    protected $cacheService;
    /** @var GitHubService  */
    protected $gitHubService;
    /** @var Cache  */
    private $cache;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->cacheService = new Cache();
        $this->organizationService = new OrganizationService();
        $this->gitHubService = new GitHubService();
        $this->cacheService = new CacheService();
    }

    /**
     * @return bool
     */
    public function listAction(): bool
    {
        $organisationList =  $this->organizationService->getList();
        include(ROOT . '/../templates/index.phtml');
        return true;
    }

    /**
     * @return bool
     */
    public function deleteAction(): bool
    {
        $this->cacheService->deleteByTimeout();
        header('Location: /list');
        return true;
    }

    /**
     * @return bool
     */
    public function clearCacheAction(): bool
    {
        (new Cache())->clear();
        header('Location: /');
        return true;
    }

    /**
     * @throws GuzzleException
     */
    public function downloadMoreAction()
    {
        $this->gitHubService->downloadMoreOrganizations();
        header('Location: /list');
        return true;

    }

    /**
     * @throws GuzzleException
     */
    public function downloadAction()
    {
        $this->gitHubService->downloadOrganization();
        header('Location: /list');
        return true;
    }
}
