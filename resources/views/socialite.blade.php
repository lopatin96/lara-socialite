@if(config('lara-socialite.providers'))
    <div class="grid gap-4">
        @foreach(config('lara-socialite.providers') as $provider)
            <flux:button
                variant="filled"
                href="/auth/{{ $provider }}"
                :icon="$provider"
                icon-trailing="arrow-up-right"
                class="w-full"
            >
                {{ __($title, ['social' => $provider]) }}
            </flux:button>
        @endforeach
    </div>

    <flux:separator :text="__('lara-socialite::common.or')" />
@endif