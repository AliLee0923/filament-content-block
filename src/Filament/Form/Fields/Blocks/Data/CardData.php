<?php

namespace Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\Blocks\Data;

    class CardData
    {
        /**
         * @param  string|null  $title
         * @param  string|null  $text
         * @param  array<CallToActionData>|null  $callToActions
         * @param  string|null  $imageId
         * @param  string|null  $imageUrl
         * @param  string|null  $imageHtml
         */
        public function __construct(
            public ?string $title,
            public ?string $text,
            public ?array $callToActions,
            public ?string $imageId,
            public ?string $imageUrl = null,
            public ?string $imageHtml = null,
        ) {
        }

        /**
         * @param  array  $cardBlockData
         * @param  string|null  $imageUrl
         * @param  string|null  $imageHtml
         * @param  array  $buttonStyleClasses
         * @return self
         */
        public static function create(array $cardBlockData, ?string $imageUrl, ?string $imageHtml, array $buttonStyleClasses): self
        {
            $callToActions = [];
            if (! empty($cardBlockData['card_call_to_action'])) {
                foreach ($cardBlockData['card_call_to_action'] as $callToAction) {
                    $callToActions[] = CallToActionData::create($callToAction, $buttonStyleClasses);
                }
            }

            return new self(
                $cardBlockData['title'] ?? null,
                $cardBlockData['text'] ?? null,
                $callToActions,
                $cardBlockData['image'] ?? null,
                $imageUrl,
                $imageHtml
            );
        }
    }
