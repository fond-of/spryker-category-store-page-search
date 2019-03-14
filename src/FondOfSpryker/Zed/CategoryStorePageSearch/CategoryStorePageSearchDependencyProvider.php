<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch;

use FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade\CategoryPageSearchToSearchBridge;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\CategoryPageSearch\CategoryPageSearchDependencyProvider as SprykerCategoryPageSearchDependencyProvider;

class CategoryStorePageSearchDependencyProvider extends SprykerCategoryPageSearchDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[self::FACADE_SEARCH] = function (Container $container) {
            return new CategoryPageSearchToSearchBridge($container->getLocator()->search()->facade());
        };

        return $container;
    }
}
