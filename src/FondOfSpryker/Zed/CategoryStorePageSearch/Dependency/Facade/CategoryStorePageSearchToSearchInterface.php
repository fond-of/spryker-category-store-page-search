<?php

namespace FondOfSpryker\Zed\CategoryStorePageSearch\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface CategoryStorePageSearchToSearchInterface
{
    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param $mapperName
     *
     * @return array
     */
    public function transformPageMapToDocumentByMapperName(array $data, LocaleTransfer $localeTransfer, $mapperName): array;
}
