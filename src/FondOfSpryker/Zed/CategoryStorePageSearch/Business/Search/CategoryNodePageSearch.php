<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Business\Search;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Propel\Runtime\Map\TableMap;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Zed\CategoryPageSearch\Business\Search\CategoryNodePageSearch as SprykerCategoryNodePageSearch;

class CategoryNodePageSearch extends SprykerCategoryNodePageSearch
{
    /**
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $spyCategoryNodeEntity
     * @param string $localeName
     * @param \Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch|null $spyCategoryNodePageSearchEntity
     *
     * @return void
     */
    protected function storeDataSet(SpyCategoryNode $spyCategoryNodeEntity, $localeName, ?SpyCategoryNodePageSearch $spyCategoryNodePageSearchEntity = null)
    {
        if ($spyCategoryNodePageSearchEntity === null) {
            $spyCategoryNodePageSearchEntity = new SpyCategoryNodePageSearch();
        }

        if (!$spyCategoryNodeEntity->getCategory()->getIsActive()) {
            if (!$spyCategoryNodePageSearchEntity->isNew()) {
                $spyCategoryNodePageSearchEntity->delete();
            }

            return;
        }

        $categoryTreeNodeData = $spyCategoryNodeEntity->toArray(TableMap::TYPE_FIELDNAME, true, [], true);
        $data = $this->mapToSearchData($categoryTreeNodeData, $localeName);
        $spyCategoryNodePageSearchEntity->setFkCategoryNode($spyCategoryNodeEntity->getIdCategoryNode());
        $spyCategoryNodePageSearchEntity->setStructuredData($this->utilEncoding->encodeJson($categoryTreeNodeData));
        $spyCategoryNodePageSearchEntity->setData($data);
        $spyCategoryNodePageSearchEntity->setStore($this->getStoreName($spyCategoryNodeEntity));
        $spyCategoryNodePageSearchEntity->setLocale($localeName);
        $spyCategoryNodePageSearchEntity->setIsSendingToQueue($this->isSendingToQueue);
        $spyCategoryNodePageSearchEntity->save();
    }

    /**
     * Retreieve Store Name
     *
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     *
     * @return string
     */
    protected function getStoreName(SpyCategoryNode $spyCategoryNodeEntity)
    {
        $storeEntity = SpyStoreQuery::create()
            ->filterByIdStore($spyCategoryNodeEntity->getFkStore())
            ->findOne();

        return $storeEntity->getName();
    }
}
