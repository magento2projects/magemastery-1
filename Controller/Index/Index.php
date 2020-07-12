<?php

declare(strict_types=1);

namespace MageMastery\Todo\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Context $context, Session $session)
    {
        parent::__construct($context);
        $this->session = $session;
    }

    public function execute()
    {
        if (!$this->session->isLoggedIn()) {
            /** @var Redirect $redirect */
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setPath('customer/account/login');

            return $redirect;
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
