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
     * @return array|false
     */
    public function getList()
    {
        $files = $this->cache->getAllFilesName();
        if (empty($files)) {
            return false;
        }

        $organizationsList = [];
        foreach ($files as $file) {
            $jsonData = $this->cache->get($file);
            $organizations = json_decode($jsonData, true);

            if (is_array($organizations)){
                foreach ($organizations as $organization => $fields) {
                    $organizationsList[] = new Organization($fields);
                }
            }
        }
        return $organizationsList;
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function getLastOrganizationId(string $data): int
    {
        $items = json_decode($data,true);
        $ids = array_column($items, 'id');
        return max($ids);
    }
}
