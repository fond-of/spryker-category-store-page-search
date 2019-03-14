<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Communication\Plugin\Search;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;
use Spryker\Zed\Search\Dependency\Plugin\NamedPageMapInterface;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Search\CategoryNodeDataPageMapBuilder as SprykerCategoryNodeDataPageMapBuilder;

/**
 * @method \Spryker\Zed\CategoryPageSearch\Communication\CategoryPageSearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\CategoryPageSearch\Business\CategoryPageSearchFacadeInterface getFacade()
 */
class CategoryNodeDataPageMapBuilder extends SprykerCategoryNodeDataPageMapBuilder
{
    /**
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $categoryData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function buildPageMap(PageMapBuilderInterface $pageMapBuilder, array $categoryData, LocaleTransfer $localeTransfer)
    {
        $pageMapTransfer = parent::buildPageMap($pageMapBuilder, $categoryData, $localeTransfer);

        $pageMapTransfer->setStore($this->getStoreName($categoryData['fk_store']));

        return $pageMapTransfer;
    }

    /**
     * Retreieve Store Name
     *
     * @param int $idStore
     *
     * @return string
     */
    protected function getStoreName($idStore)
    {
        $storeEntity = SpyStoreQuery::create()
            ->filterByIdStore($idStore)
            ->findOne();

        return $storeEntity->getName();
    }
}
