<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Business\Search;

use FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade\CategoryStorePageSearchToSearchInterface;
use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Propel\Runtime\Map\TableMap;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\CategoryPageSearch\Business\Search\CategoryNodePageSearch as SprykerCategoryNodePageSearch;
use Spryker\Zed\CategoryPageSearch\Business\Search\DataMapper\CategoryNodePageSearchDataMapperInterface;
use Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToStoreFacadeInterface;
use Spryker\Zed\CategoryPageSearch\Dependency\Service\CategoryPageSearchToUtilEncodingInterface;
use Spryker\Zed\CategoryPageSearch\Persistence\CategoryPageSearchQueryContainerInterface;

class CategoryNodePageSearch extends SprykerCategoryNodePageSearch implements CategoryNodePageSearchInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToSearchInterface
     */
    protected $searchFacade;

    /**
     * @param \Spryker\Zed\CategoryPageSearch\Dependency\Service\CategoryPageSearchToUtilEncodingInterface $utilEncoding
     * @param \FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade\CategoryStorePageSearchToSearchInterface $searchFacade
     * @param \Spryker\Zed\CategoryPageSearch\Business\Search\DataMapper\CategoryNodePageSearchDataMapperInterface $categoryNodePageSearchDataMapper
     * @param \Spryker\Zed\CategoryPageSearch\Persistence\CategoryPageSearchQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToStoreFacadeInterface $storeFacade
     * @param bool $isSendingToQueue
     */
    public function __construct(
        CategoryPageSearchToUtilEncodingInterface $utilEncoding,
        CategoryStorePageSearchToSearchInterface $searchFacade,
        CategoryNodePageSearchDataMapperInterface $categoryNodePageSearchDataMapper,
        CategoryPageSearchQueryContainerInterface $queryContainer,
        CategoryPageSearchToStoreFacadeInterface $storeFacade,
        bool $isSendingToQueue
    ) {
        parent::__construct($utilEncoding, $categoryNodePageSearchDataMapper, $queryContainer, $storeFacade,
            $isSendingToQueue);
        $this->searchFacade = $searchFacade;
    }

    /**
     * @param array $categoryNodeData
     * @param string $localeName
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
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $spyCategoryNodeEntity
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
