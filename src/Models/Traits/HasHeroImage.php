<?php

namespace Statikbe\FilamentFlexibleContentBlocks\Models\Traits;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasHeroImage
{
    use InteractsWithMedia;

    public function initializeHasHeroImage(): void
    {
        $this->registerHeroImageMediaCollectionAndConversion();
    }

    protected function registerHeroImageMediaCollectionAndConversion()
    {
        $this->addMediaCollection($this->getHeroImageCollection())
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion($this->getHeroImageConversionName())
                    ->fit(Manipulations::FIT_CROP, 1200, 630);
                //for filament upload field
                $this->addMediaConversion('thumbnail')
                    ->fit(Manipulations::FIT_CROP, 400, 400);
            });
    }

    public function addHeroImage(string $imagePath): void
    {
        $this->addMedia($imagePath)
            ->toMediaCollection($this->getHeroImageCollection());
    }

    public function getHeroImageConversionName(): string
    {
        return 'hero_image';
    }

    public function getHeroImageCollection(): string
    {
        return 'hero_image';
    }

    public function getHeroImageUrl(string $conversion = null): string
    {
        return $this->getFirstMediaUrl($this->getHeroImageCollection(), $conversion ?? $this->getHeroImageConversionName());
    }
}
