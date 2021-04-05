<?php


namespace ZTT\app\Service;


use ZTT\app\Model\Cache;
use ZTT\app\Model\Organization;

class OrganizationService
{
    /** @var Cache */
    private $cache;

    /**
     * OrganizationService constructor.
     */
    public function __construct()
    {
        $this->cache = new Cache();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $jsonData = $this->cache->get('ddfdf');
        $organizations = json_decode($jsonData, true);
        $organizationsList = [];

        foreach ($organizations as $organization => $fields) {
            $organizationsList[] = new Organization($fields);
        }

        return $organizationsList;
    }

}