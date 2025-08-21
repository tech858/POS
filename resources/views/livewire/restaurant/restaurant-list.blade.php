<div>
    <div>

        <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('superadmin.menu.restaurants')</h1>
                </div>
                @if($showRegenerateQrCodes)
                    <x-alert type="warning" class="flex justify-between" >
                        <span>@lang('superadmin.domainChanged')</span>

                        <span><x-button type='button' wire:click="regenerateQrCodes()" >@lang('superadmin.regenerateQrCode')</x-button></span>
                    </x-alert>
                @endif
                <div class="items-center justify-between block sm:flex ">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <x-input id="menu_name" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.searchStaffmember') }}" wire:model.live.debounce.500ms="search"  />
                            </div>
                        </form>
                    </div>


                    <x-button type='button' wire:click="$set('showAddRestaurant', true)" >@lang('modules.restaurant.addRestaurant')</x-button>

                </div>
            </div>
        </div>

        <livewire:restaurant.restaurant-table :search='$search' key='restaurant-table-{{ microtime() }}' />


    </div>



    <x-right-modal wire:model.live="showAddRestaurant">
        <x-slot name="title">
            {{ __("modules.restaurant.addRestaurant") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.addRestaurant')
        </x-slot>
    </x-right-modal>

</div>
