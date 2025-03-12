<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex flex-row">
                <div class="basis-64">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>{{$cityDislpayName}}</p>
                        <p> {{\Carbon\Carbon::now(\App\Helpers\UnitsHelper::timeZonesUnification($weather['timezone']))->format('Y-m-d H:i')}}</p>
                    </div>
                </div>
                <div class="basis-64">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ svg($weather['icon'],'w-6 h-6')}}
                        <p>{{$weather['description']}}</p>
                    </div>
                </div>
                <div class="basis-128">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            Temp: {{$weather['temperature']}}°C
                        </div>
                        <div>
                            Odczuwalna temperatura: {{$weather['temperature_feel']}}°C
                        </div>
                    </div>
                </div>
                <div class="basis-128">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            Ciśnienie: {{$weather['pressure']}} hPa
                        </div>
                        <div>
                            Wilgotność powietrza: {{$weather['humidity']}}%
                        </div>
                    </div>
                </div>
                <div class="basis-128">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            Wiatr: {{\App\Helpers\UnitsHelper::WindSpeedUnification($weather['wind']['speed'])}}km/h
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-sm min-w-[200px] p-6">
                    <div class="relative">
                        <input wire:model="city"
                               class="w-full bg-transparent text-gray-900 dark:text-gray-100 text-sm border border-slate-200 rounded-md pl-3 pr-28 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                               placeholder="Wpisz miasto..."
                        />
                        <button wire:click="SearchWeatherForCity"
                                class="absolute top-1 right-1 flex items-center rounded bg-slate-800 py-1 px-2.5 border border-transparent text-center text-sm text-white transition-all shadow-sm hover:shadow focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-4 h-4 mr-2">
                                <path fill-rule="evenodd"
                                      d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                                      clip-rule="evenodd"/>
                            </svg>

                            Search
                        </button>
                    </div>
                </div>
            </div>
            @if (!empty($cityErrorMsg))
                <div class="text-center p-6 text-bold text-lg text-red-500">{{ $cityErrorMsg }}</div>
            @endif
        </div>

    </div>
</div>
