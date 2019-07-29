<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Business\Search;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Propel\Runtime\Map\TableMap;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\CategoryPageSearch\Business\Search\CategoryNodePageSearch as SprykerCategoryNodePageSearch;

class CategoryNodePageSearch extends SprykerCategoryNodePageSearch
{
    use LoggerTrait;

    /**
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $spyCategoryNodeEntity
     * @param string $localeName
     * @param \Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch|null $spyCategoryNodePageSearchEntity
     *
     * @throws
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
     * @param array $categoryNodeData
     * @param string $localeName
     *
     * @throws
     *
     * @return array
     */
    public function mapToSearchData(array $categoryNodeData, $localeName)
    {
        return $this->searchFacade
            ->transformPageMapToDocumentByMapperName(
                $categoryNodeData,
                (new LocaleTransfer())->setLocaleName($localeName),
                CategoryPageSearchConstants::CATEGORY_NODE_RESOURCE_NAME
            );
    }

    /**
     * Retreieve Store Name
     *
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $spyCategoryNodeEntity
     *
     * @throws
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
