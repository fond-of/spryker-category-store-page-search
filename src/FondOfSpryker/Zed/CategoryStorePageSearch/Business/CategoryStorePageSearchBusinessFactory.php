<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Business;

use FondOfSpryker\Zed\CategoryStorePageSearch\Business\Search\CategoryNodePageSearch;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\CategoryPageSearch\CategoryPageSearchDependencyProvider;
use Spryker\Zed\CategoryPageSearch\Business\CategoryPageSearchBusinessFactory as SprykerCategoryPageSearchBusinessFactory;

/**
 * @method \Spryker\Zed\CategoryPageSearch\CategoryPageSearchConfig getConfig()
 * @method \Spryker\Zed\CategoryPageSearch\Persistence\CategoryPageSearchQueryContainerInterface getQueryContainer()
 */
class CategoryStorePageSearchBusinessFactory extends SprykerCategoryPageSearchBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CategoryStorePageSearch\Business\Search\CategoryNodePageSearchInterface
     */
    public function createCategoryNodeSearch()
    {
        return new CategoryNodePageSearch(
            $this->getUtilEncoding(),
            $this->getSearchFacade(),
            $this->getQueryContainer(),
            $this->getStore(),
            $this->getConfig()->isSendingToQueue()
        );
    }
}
