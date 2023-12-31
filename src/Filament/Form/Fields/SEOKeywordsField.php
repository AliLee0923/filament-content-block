<?php

namespace Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields;

use Filament\Forms\Components\TagsInput;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component as Livewire;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\Concerns\HasTranslatableHint;

class SEOKeywordsField extends TagsInput
{
    use HasTranslatableHint;

    public const FIELD = 'seo_keywords';

    public static function create(bool $required = false): static
    {
        return static::make(self::FIELD)
            ->label(trans('filament-flexible-content-blocks::filament-flexible-content-blocks.form_component.seo_keywords_lbl'))
            ->required($required)
            ->suggestions(function (?Model $record, Livewire $livewire) {
                $locale = null;
                if (! $record) {
                    return [];
                }

                if (method_exists($livewire, 'getActiveFormsLocale')) {
                    $locale = $livewire->getActiveFormsLocale();
                }

                if ($locale) {
                    $keywords = $record::select("seo_keywords->$locale as seo_keywords")
                        ->whereNotNull("seo_keywords->$locale")
                        ->get();
                } else {
                    $keywords = $record::select('seo_keywords')
                        ->whereNotNull('seo_keywords')
                        ->get();
                }

                return $keywords->map(fn ($item) => json_decode($item))
                    ->reduce(fn ($carry, $item) => $carry ? array_unique(array_merge($carry, $item->seo_keywords)) : $item->seo_keywords) ?? [];
            })
            ->addsTranslatableHint();
    }
}
