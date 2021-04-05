<?php


namespace ZTT\app\Action;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use ZutzuTechTask\app\CacheInterface;
use ZTT\app\GitHub;
use ZTT\app\Model\Cache;

class CacheSaveAction
{
    /** @var Cache */
    private $cache;
    /** @var GitHub */
    private $client;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
        $this->client = new GitHub();
    }

    /**
     * @return string
     *
     * @throws GuzzleException
     */
    public function fire()
    {
        try {
            $this->client->setMethod('/organizations');
            $result = $this->client->getGetData();

            if ($result) {
                $this->cache->set(uniqid(), $result, 300);

                return 'Data is cached. File path: ' . $this->cache->getFileName();
            }
        } catch (RequestException $exception) {
            throw new RequestException($exception->getMessage());
        }
    }
}

//
//namespace ZutzuTechTask\app\Action;
//
//use GuzzleHttp\Exception\GuzzleException;
//use GuzzleHttp\Exception\RequestException;
//use ZutzuTechTask\app\CacheInterface;
//use ZutzuTechTask\app\GitHub;
//
//class CacheSaveAction
//{
//    /** @var CacheInterface */
//    private $cache;
//    /** @var GitHub */
//    private $client;
//
//    public function __construct(CacheInterface $cache)
//    {
//        $this->cache = $cache;
//        $this->client = new GitHub();
//    }
//
//    /**
//     * @return string
//     *
//     * @throws GuzzleException
//     */
//    public function fire()
//    {
//        try {
//            $this->client->setMethod('/organizations');
//            $result = $this->client->getGetData();
//
//            if ($result) {
//                $this->cache->set(uniqid(), $result, 300);
//
//                return 'Data is cached. File path: ' . $this->cache->getFileName();
//            }
//        } catch (RequestException $exception) {
//           throw new RequestException($exception->getMessage());
//        }
//    }
//}
