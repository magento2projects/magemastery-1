<?php

declare(strict_types=1);

namespace MageMastery\Todo\Controller\Index;

use MageMastery\Todo\Model\ResourceModel\Task as TaskResource;
use MageMastery\Todo\Model\Task;
use MageMastery\Todo\Model\TaskFactory;
use MageMastery\Todo\Service\TaskRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    private $taskResource;

    private $taskFactory;
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(
        Context $context,
        TaskFactory $taskFactory,
        TaskResource $task,
        TaskRepository $taskRepository
    ) {
        $this->taskFactory = $taskFactory;
        $this->taskResource = $task;
        parent::__construct($context);
        $this->taskRepository = $taskRepository;
    }

    public function execute()
    {
        $task = $this->taskRepository->get(1);
        var_dump($task->getData());


//        $task = $this->taskFactory->create();
//        $task->setData([
//            'label' => 'New Task 3',
//            'status' => 'open',
//            'customer_id' => 1
//        ]);
//        $this->taskResource->save($task);

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
