<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch;

use FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade\CategoryPageSearchToSearchBridge;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryPageSearch\CategoryPageSearchDependencyProvider as SprykerCategoryPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CategoryStorePageSearchDependencyProvider extends SprykerCategoryPageSearchDependencyProvider
{
    public const FACADE_SEARCH = 'FACADE_SEARCH';
    public const STORE = 'store';
    
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };

        $container[self::FACADE_SEARCH] = function (Container $container) {
            return new CategoryPageSearchToSearchBridge($container->getLocator()->search()->facade());
        };

        return $container;
    }
}
