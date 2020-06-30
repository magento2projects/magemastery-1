<?php

namespace MageMastery\Todo\Service;

use MageMastery\Todo\Api\Data\TaskInterface;
use MageMastery\Todo\Api\TaskRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

class CustomerTaskList implements \MageMastery\Todo\Api\CustomerTaskListInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var Session
     */
    private $session;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        Session $session
    ) {
        $this->taskRepository = $taskRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->session = $session;
    }

    /**
     * @return TaskInterface[]
     */
    public function getList()
    {
        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField('customer_id')
                ->setValue($this->session->getCustomerId())
        );
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->taskRepository
            ->getList($searchCriteria)
            ->getItems();
    }
}
