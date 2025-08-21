<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
               
            <div>
                <x-label for="currencyName" value="{{ __('modules.settings.restaurantCurrency') }}" />
                <x-input id="currencyName" class="block mt-1 w-full" type="text" autofocus wire:model='currencyName' />
                <x-input-error for="currencyName" class="mt-2" />
            </div>

            <div>
                <x-label for="currencySymbol" value="{{ __('modules.settings.currencySymbol') }}" />
                <x-input id="currencySymbol" class="block mt-1 w-full" type="text" autofocus wire:model='currencySymbol' />
                <x-input-error for="currencySymbol" class="mt-2" />
            </div>

            <div>
                <x-label for="currencyCode" value="{{ __('modules.settings.currencyCode') }}" />
                <x-input id="currencyCode" class="block mt-1 w-full" type="text" autofocus wire:model='currencyCode' />
                <x-input-error for="currencyCode" class="mt-2" />
            </div>

        </div>
           
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideAddCurrency')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
