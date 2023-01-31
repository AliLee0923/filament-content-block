<?php

namespace Statikbe\FilamentFlexibleContentBlocks\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property string|null $title
 * @property Carbon|null $publishing_begins_at
 * @property Carbon|null $publishing_ends_at
 */
trait HasPageAttributes
{
    public function initializeHasPageAttributes(): void
    {
        $this->mergeFillable(['title', 'publishing_begins_at', 'publishing_ends_at']);

        //set casts of attributes:
        $this->mergeCasts([
            'publishing_begins_at' => 'datetime',
            'publishing_ends_at' => 'datetime',
        ]);
    }

    /**
     * Returns whether the page is published or visible, based on the begin and end publishing dates.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        $now = Carbon::now();
        if ($this->publishing_begins_at && $this->publishing_ends_at) {
            return $now->between($this->publishing_begins_at, $this->publishing_ends_at);
        } elseif ($this->publishing_begins_at) {
            return $now->greaterThan($this->publishing_begins_at);
        } elseif ($this->publishing_ends_at) {
            return $now->lessThan($this->publishing_ends_at);
        } else {
            return true;
        }
    }

    /**
     * Returns whether the page will be published, based on the begin publishing date.
     *
     * @return bool
     */
    public function willBecomePublished(): bool
    {
        return $this->publishing_begins_at && $this->publishing_begins_at->isFuture();
    }

    /**
     * Returns whether the page will be unpublished, based on the end publishing date.
     *
     * @return bool
     */
    public function willBecomeUnpublished(): bool
    {
        return $this->publishing_ends_at && $this->publishing_ends_at->isFuture();
    }

    /**
     * Returns whether this page was published in the past and its publication ended.
     *
     * @return bool
     */
    public function wasUnpublished(): bool
    {
        return $this->publishing_ends_at && $this->publishing_ends_at->isPast();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $publishedQuery) {
            $publishedQuery->orWhere(function (Builder $option1) {
                $option1->whereNull('publishing_begins_at')
                    ->whereNotNull('publishing_ends_at')
                    ->where('publishing_ends_at', '>', 'now()');
            })->orWhere(function (Builder $option2) {
                $option2->whereNotNull('publishing_begins_at')
                    ->whereNotNull('publishing_ends_at')
                    ->whereBetween('now()', ['publishing_begins_at', 'publishing_ends_at']);
            })->orWhere(function (Builder $option3) {
                $option3->whereNotNull('publishing_begins_at')
                    ->whereNull('publishing_ends_at')
                ->where('publishing_ends_at', '<', 'now()');
            })->orWhere(function (Builder $option4) {
                $option4->whereNull('publishing_begins_at')
                    ->whereNull('publishing_ends_at');
            });
        });
    }

    public function publishedOnFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => optional($this->published_on)->format(config('leudis.datetime_format')),
        );
    }
}
