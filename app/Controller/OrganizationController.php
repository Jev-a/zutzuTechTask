<?php


namespace ZTT\app\Controller;


class OrganizationController
{
    public function listAction()
    {
        $organisationList =  (new \ZTT\app\Service\OrganizationService())->getList();
        include(ROOT . '/../templates/index.phtml');
        return true;
    }

}