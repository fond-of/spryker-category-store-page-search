<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Event\Listener\CategoryNodeStoreCategoryPageSearchListener;
use FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Event\Listener\CategoryNodeStoreSearchListener;
use FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Event\Listener\CategoryStoreNodeCategoryAttributeSearchListener;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Event\Listener\CategoryNodeCategoryAttributeSearchListener;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Event\Subscriber\CategoryPageSearchEventSubscriber as SprykerCategoryPageSearchEventSubscriber;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

/**
 * @method \FondOfSpryker\Zed\CategoryPageSearch\Communication\CategoryPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CategoryPageSearch\Business\CategoryPageSearchFacadeInterface getFacade()
 */
class CategoryStorePageSearchEventSubscriber extends SprykerCategoryPageSearchEventSubscriber
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection)
    {
        $this->addCategoryPageSearchPublishListener($eventCollection);
        $this->addCategoryPageSearchUnPublishListener($eventCollection);
        $this->addCategoryNodeSearchCreateListener($eventCollection);
        $this->addCategoryNodeSearchUpdateListener($eventCollection);
        $this->addCategoryNodeSearchDeleteListener($eventCollection);
        $this->addCategoryNodeCategoryPageSearchCreateListener($eventCollection);
        $this->addCategoryNodeCategoryPageSearchUpdateListener($eventCollection);
        $this->addCategoryNodeCategoryPageSearchDeleteListener($eventCollection);
        $this->addCategoryNodeCategoryAttributeSearchCreateListener($eventCollection);
        $this->addCategoryNodeCategoryAttributeSearchUpdateListener($eventCollection);
        $this->addCategoryNodeCategoryAttributeSearchDeleteListener($eventCollection);
        $this->addCategoryNodeCategoryTemplateSearchCreateListener($eventCollection);
        $this->addCategoryNodeCategoryTemplateSearchUpdateListener($eventCollection);
        $this->addCategoryNodeCategoryTemplateSearchDeleteListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryPageSearchPublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_PUBLISH, new CategoryNodeStoreSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryPageSearchUnPublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_UNPUBLISH, new CategoryNodeStoreSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeSearchCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryNodeStoreSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeSearchUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryNodeStoreSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeSearchDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE, new CategoryNodeStoreSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCategoryPageSearchCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_CREATE, new CategoryNodeStoreCategoryPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCategoryPageSearchUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_UPDATE, new CategoryNodeStoreCategoryPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCategoryPageSearchDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_DELETE, new CategoryNodeStoreCategoryPageSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCategoryAttributeSearchCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_CREATE, new CategoryStoreNodeCategoryAttributeSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCategoryAttributeSearchUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_UPDATE, new CategoryStoreNodeCategoryAttributeSearchListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCategoryAttributeSearchDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_DELETE, new CategoryStoreNodeCategoryAttributeSearchListener());
    }
}
