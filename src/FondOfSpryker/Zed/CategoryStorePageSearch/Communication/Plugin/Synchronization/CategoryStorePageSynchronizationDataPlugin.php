<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Synchronization;

use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Synchronization\CategoryPageSynchronizationDataPlugin as SprykerCategoryPageSynchronizationDataPlugin;


class CategoryStorePageSynchronizationDataPlugin extends SprykerCategoryPageSynchronizationDataPlugin
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return bool
     */
    public function hasStore(): bool
    {
        return true;
    }
}
