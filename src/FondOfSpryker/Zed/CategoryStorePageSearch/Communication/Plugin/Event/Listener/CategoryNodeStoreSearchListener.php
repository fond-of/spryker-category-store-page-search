<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Event\Listener;

use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Event\Listener\CategoryNodeSearchListener as SprykerCategoryNodeSearchListener;

/**
 * @method \Spryker\Zed\CategoryPageSearch\Persistence\CategoryPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\CategoryPageSearch\Communication\CategoryPageSearchCommunicationFactory getFactory()
 * @method \FondOFSpryker\Zed\CategoryPageSearch\Business\CategoryPageSearchFacadeInterface getFacade()
 */
class CategoryNodeStoreSearchListener extends SprykerCategoryNodeSearchListener
{
    use DatabaseTransactionHandlerTrait;

    use LoggerTrait;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $this->preventTransaction();
        $categoryNodeIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);

        if ($eventName === CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE) {
            $this->getFacade()->unpublish($categoryNodeIds);
        } else {
            $this->getFacade()->publish($categoryNodeIds);
        }
    }
}
