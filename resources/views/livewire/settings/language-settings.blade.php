<div class="px-4 my-4">

    <div class="mb-4">
        <a href="{{ url('/translations') }}" target="_blank" class="text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[.8] font-semibold rounded-lg text-sm px-5 py-2.5 text-center" >
            @lang('modules.settings.manageTranslations')
        </a>
    </div>

    <form wire:submit="submitForm">

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.language.languageCode')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.language.languageName')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.language.active')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-left">
                                        @lang('modules.language.rtl')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                                wire:key='menu-item-list-{{ microtime() }}'>

                                @foreach ($languageSettings as $key => $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                    wire:key='menu-item-{{ $item->id . microtime() }}'
                                    wire:loading.class.delay='opacity-10'>
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">{{
                                        $item->language_code }}
                                    </td>
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->language_name }}
                                    </td>
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-checkbox name="languageActive.{{ $key }}"
                                            id="languageActive.{{ $key }}"
                                            wire:model='languageActive.{{ $key }}' />
                                    </td>
                                    <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-left">
                                        <x-checkbox name="languageRtl.{{ $key }}"
                                            id="languageRtl.{{ $key }}"
                                            wire:model='languageRtl.{{ $key }}' />
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                    <div class="mt-2">
                        <x-button>@lang('app.save')</x-button>
                    </div>
                </div>
            </div>
        </div>

    </form>


</div>