<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade;

use FondOfSpryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToSearchBridge as FondOfSprykerCategoryPageSearchToSearchBridge;
use Generated\Shared\Transfer\LocaleTransfer;

class CategoryPageSearchToSearchBridge extends FondOfSprykerCategoryPageSearchToSearchBridge implements CategoryPageSearchToSearchInterface
{
    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param string $mapperName
     *
     * @return array
     */
    public function transformPageMapToDocumentByMapperName(array $data, LocaleTransfer $localeTransfer, $mapperName)
    {
        return $this->searchFacade->transformPageMapToDocumentByMapperName($data, $localeTransfer, $mapperName);
    }
}
