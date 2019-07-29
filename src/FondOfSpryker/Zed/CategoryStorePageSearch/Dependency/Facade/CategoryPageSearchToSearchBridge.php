<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToSearchBridge as SprykerCategoryPageSearchToSearchBridge;

class CategoryPageSearchToSearchBridge extends SprykerCategoryPageSearchToSearchBridge implements CategoryPageSearchToSearchInterface
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
