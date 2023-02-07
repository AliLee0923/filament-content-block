<?php

namespace Statikbe\FilamentFlexibleContentBlocks\Models\Contracts;

use Filament\Forms\Components\Builder\Block;

/**
 * @property array $content_blocks
 */
interface HasContentBlocks
{
    /**
     * Returns an array of the Filament blocks of all allowed content blocks for this resource.
     * The order will be the order in which they are presented to the user.
     *
     * @return array<Block>
     */
    public static function getFilamentContentBlocks(): array;

    /**
     * Returns an array of all allowed content block classes for this resource.
     * The order will be the order in which they are presented to the user.
     *
     * @return array<string>
     */
    public static function registerContentBlocks(): array;

    /**
     * Extract all searchable text from the content blocks, to enable simple searching in content blocks.
     *
     * @return string|null
     */
    public function getSearchableContent(): ?string;
}
