<div class="relative py-12">
    <div class="container px-4 mx-auto">
        @if($title)
            <div class="mb-6 prose max-w-none">
                <h2>{{$title}}</h2>
            </div>
        @endif
        <div class="grid grid-cols-{{$gridColumns ?? 3}} gap-4">
            @foreach($cards as $card)
                @php
                    /* @var \Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\Blocks\Data\CardData $card */
                @endphp

                <x-flexible-card :data="$card">
                    {!! $getCardImageMedia($card->imageId, $card->title) !!}
                </x-flexible-card>
            @endforeach
        </div>
    </div>
</div>
