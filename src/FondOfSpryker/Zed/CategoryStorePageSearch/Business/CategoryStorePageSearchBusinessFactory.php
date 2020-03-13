<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Business;

use FondOfSpryker\Zed\CategoryStorePageSearch\Business\Search\CategoryNodePageSearch;
use FondOfSpryker\Zed\CategoryStorePageSearch\CategoryStorePageSearchDependencyProvider;
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
            $this->createCategoryNodePageSearchDataMapper(),
            $this->getQueryContainer(),
            $this->getStoreFacade(),
            $this->getConfig()->isSendingToQueue()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToSearchInterface
     */
    public function getSearchFacade()
    {
        return $this->getProvidedDependency(CategoryStorePageSearchDependencyProvider::FACADE_SEARCH);
    }
}
