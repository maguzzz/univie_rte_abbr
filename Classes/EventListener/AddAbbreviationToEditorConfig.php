<?php

declare(strict_types=1);

namespace Univie\RteCkeditorAbbr\EventListener;

use TYPO3\CMS\RteCKEditor\Form\Element\Event\AfterPrepareConfigurationForEditorEvent;

final class AddAbbreviationToEditorConfig
{
    private const MODULE = '@univie/rte-ckeditor-abbr/abbreviation.js';
    private const TOOLBAR_ITEM = 'abbreviation';

    public function __invoke(AfterPrepareConfigurationForEditorEvent $event): void
    {
        $configuration = $event->getConfiguration();

        $configuration['importModules'] = $this->addImportModule(
            $this->normalizeList($configuration['importModules'] ?? [])
        );
        $configuration['contentsCss'] = $this->normalizeList($configuration['contentsCss'] ?? []);
        $configuration = $this->withToolbarItem($configuration);
        $configuration['htmlSupport']['allow'] = $this->allowAbbrTag(
            $this->normalizeList($configuration['htmlSupport']['allow'] ?? [])
        );

        $event->setConfiguration($configuration);
    }

    /**
     * @param mixed $value
     * @return list<mixed>
     */
    private function normalizeList(mixed $value): array
    {
        if (is_string($value) && $value !== '') {
            return [$value];
        }
        if (!is_array($value)) {
            return [];
        }

        return array_values($value);
    }

    /**
     * @param array<string, mixed> $configuration
     * @return array<string, mixed>
     */
    private function withToolbarItem(array $configuration): array
    {
        $toolbar = $configuration['toolbar'] ?? [];
        if (!is_array($toolbar)) {
            $toolbar = [];
        }
        if ($toolbar !== [] && array_is_list($toolbar)) {
            $configuration['toolbar'] = $this->addToolbarItem($toolbar);
            return $configuration;
        }
        $configuration['toolbar']['items'] = $this->addToolbarItem(
            $this->normalizeList($toolbar['items'] ?? [])
        );

        return $configuration;
    }

    /**
     * @param list<mixed> $modules
     * @return list<mixed>
     */
    private function addImportModule(array $modules): array
    {
        foreach ($modules as $item) {
            if ($item === self::MODULE || (is_array($item) && ($item['module'] ?? '') === self::MODULE)) {
                return $modules;
            }
        }
        $modules[] = self::MODULE;

        return $modules;
    }

    /**
     * @param list<mixed> $items
     * @return list<mixed>
     */
    private function addToolbarItem(array $items): array
    {
        if (in_array(self::TOOLBAR_ITEM, $items, true)) {
            return $items;
        }

        foreach (['superscript', 'italic', 'bold'] as $anchor) {
            $position = array_search($anchor, $items, true);
            if ($position !== false) {
                array_splice($items, (int)$position + 1, 0, [self::TOOLBAR_ITEM]);
                return $items;
            }
        }
        $items[] = self::TOOLBAR_ITEM;

        return $items;
    }

    /**
     * @param list<mixed> $allow
     * @return list<mixed>
     */
    private function allowAbbrTag(array $allow): array
    {
        foreach ($allow as $rule) {
            if (is_array($rule) && ($rule['name'] ?? '') === 'abbr') {
                return $allow;
            }
        }
        $allow[] = [
            'name' => 'abbr',
            'attributes' => ['title'],
        ];

        return $allow;
    }
}
