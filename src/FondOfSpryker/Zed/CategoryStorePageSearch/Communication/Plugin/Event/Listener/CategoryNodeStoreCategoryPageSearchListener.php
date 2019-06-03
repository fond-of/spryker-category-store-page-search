<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Event\Listener;

use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Event\Listener\CategoryNodeCategoryPageSearchListener as SprykerCategoryNodeCategoryPageSearchListener;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \FondOfSpryker\Zed\CategoryStorePageSearch\Business\CategoryStorePageSearchFacadeInterface getFacade()
 */
class CategoryNodeStoreCategoryPageSearchListener extends SprykerCategoryNodeCategoryPageSearchListener
{
    use DatabaseTransactionHandlerTrait;

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
        $categoryIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);
        $categoryNodeIds = $this->getQueryContainer()->queryCategoryNodeIdsByCategoryIds($categoryIds)->find()->getData();

        if ($eventName === CategoryEvents::ENTITY_SPY_CATEGORY_DELETE) {
            $this->getFacade()->unpublish($categoryNodeIds);
        } else {
            $this->getFacade()->publish($categoryNodeIds);
        }
    }
}
