<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch;

use FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade\CategoryStoreStorePageSearchToSearchBridge;
use Spryker\Zed\CategoryPageSearch\CategoryPageSearchDependencyProvider as SprykerCategoryPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CategoryStorePageSearchDependencyProvider extends SprykerCategoryPageSearchDependencyProvider
{
    public const FACADE_SEARCH = 'FACADE_SEARCH';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[self::FACADE_SEARCH] = function (Container $container) {
            return new CategoryStoreStorePageSearchToSearchBridge($container->getLocator()->search()->facade());
        };

        return $container;
    }
}
