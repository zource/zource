<?php
namespace ZourceContact\V1\Rest\ContactCompany;

use Zend\Paginator\Adapter\Callback;
use Zend\Paginator\Paginator;
use ZourceContact\Entity\AbstractContact;
use ZourceContact\TaskService\Contact;

class ContactCollection extends Paginator
{
    private $paginator;
    private $contactTaskService;

    public function __construct(Contact $contactTaskService)
    {
        $this->contactTaskService = $contactTaskService;
        $this->paginator = $this->contactTaskService->getOverviewPaginator('company');

        parent::__construct(new Callback([$this, 'onGetItems'], [$this, 'onCount']));
    }

    public function onCount()
    {
        return $this->paginator->getAdapter()->count();
    }

    public function onGetItems($offset, $itemCountPerPage)
    {
        $result = [];

        /** @var AbstractContact $item */
        foreach ($this->paginator->getAdapter()->getItems($offset, $itemCountPerPage) as $item) {
            $result[] = $this->contactTaskService->populateApiArray($item);
        }

        return $result;
    }
}
