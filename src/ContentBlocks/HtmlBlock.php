<?php

namespace Statikbe\FilamentFlexibleContentBlocks\ContentBlocks;

use Filament\Forms\Components\Textarea;
use Statikbe\FilamentFlexibleContentBlocks\Models\Contracts\HasContentBlocks;

class HtmlBlock extends AbstractFilamentFlexibleContentBlock
{
    public ?string $content;

    /**
     * Create a new component instance.
     */
    public function __construct(HasContentBlocks $record, ?array $blockData)
    {
        parent::__construct($record, $blockData);

        $this->content = $blockData['content'] ?? null;
    }

    public static function getNameSuffix(): string
    {
        return 'html';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-code-bracket';
    }

    /**
     * {@inheritDoc}
     */
    protected static function makeFilamentSchema(): array|\Closure
    {
        return [
            Textarea::make('content')
                ->label(static::getFieldLabel('label'))
                ->hint(static::getFieldLabel('help'))
                ->hintIcon('heroicon-s-question-mark-circle')
                ->rows(5)
                ->required(),
        ];
    }

    public function getSearchableContent(): array
    {
        $searchable = [];

        $this->addSearchableContent($searchable, $this->content);

        return $searchable;
    }
}
