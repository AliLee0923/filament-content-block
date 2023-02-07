<?php

namespace Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Model;
use Statikbe\FilamentFlexibleContentBlocks\Models\Contracts\HasSEOAttributes;

class SEOImageField extends SpatieMediaLibraryFileUpload
{
    public static function create()
    {
        return SpatieMediaLibraryFileUpload::make('seo_image')
            ->label(trans('filament-flexible-content-blocks::filament-flexible-content-blocks.form_component.seo_image_lbl'))
            ->collection(function (Model $record) {
                /** @var HasSEOAttributes $record */
                return $record->getSEOImageCollection();
            })
            ->conversion('thumbnail');
    }
}
