<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Search\Business\SearchFacadeInterface;

class CategoryStoreStorePageSearchToSearchBridge implements CategoryStorePageSearchToSearchInterface
{
    /**
     * @var \Spryker\Zed\Search\Business\SearchFacadeInterface
     */
    private $searchFacade;

    /**
     * @param \Spryker\Zed\Search\Business\SearchFacadeInterface $searchFacade
     */
    public function __construct(SearchFacadeInterface $searchFacade)
    {
        $this->searchFacade = $searchFacade;
    }

    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param $mapperName
     *
     * @return array
     */
    public function transformPageMapToDocumentByMapperName(array $data, LocaleTransfer $localeTransfer, $mapperName): array
    {
        return $this->searchFacade->transformPageMapToDocumentByMapperName($data, $localeTransfer, $mapperName);
    }
}
