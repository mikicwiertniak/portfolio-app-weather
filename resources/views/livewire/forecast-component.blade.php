<div>
    @if(!empty($cityName))
        <main class="py-6 px-12 space-y-12 bg-gray-800 min-h-screen w-full">
            <div class="flex flex-col h-full w-full mx-auto  space-y-6">
                <section class="flex flex-col mx-auto rounded-lg p-6 shadow-md space-y-6 w-full">

                    <div class="grid grid-cols-4 gap-5">
                        @foreach($cityModel->weatherForecast as $forecastDay)
                            <div class="flex flex-col pt-6 py-2 bg-white shadow rounded-lg overflow-hidden w-full">
                                <div class="flex-row text-center">
                                    <div class="flex-1 text-2xl font-bold tracking-tight leading-none text-gray-800">{{\Carbon\Carbon::parse($forecastDay['weather_date'])->format('d-m-y H:i')}}</div>
                                </div>
                                <div class="flex flex-row">
                                    <div class="items-start pl-4 pb-4 justify-center w-1/3">
                                        <div class="font-bold">
                                            {{ svg($forecastDay['icon'],'w-20 h-20')}}
                                        </div>
                                    </div>
                                    <div class="items-center pl-2 pr-2 w-1/3">
                                        <div>
                                            Ciśnienie: {{$forecastDay['pressure']}} hPa
                                        </div>
                                        <div>
                                            Wilgotność powietrza: {{$forecastDay['humidity']}}%
                                        </div>
                                        @if(!empty($forecastDay['wind_speed']))
                                            <div>
                                                Wiatr: {{\App\Helpers\UnitsHelper::WindSpeedUnification($forecastDay['wind_speed'])}}
                                                km/h
                                            </div>
                                        @endif
                                    </div>
                                    <div class="items-end pr-4 w-1/3">
                                        <div @class(['justify-center text-6xl font-bold',
        'text-blue-700' => $forecastDay['temperature'] <=0,
        'text-blue-400' => $forecastDay['temperature'] > 0 && $forecastDay['temperature'] <= 10,
        'text-green-400'=>$forecastDay['temperature'] > 10 && $forecastDay['temperature'] <= 20,
        'text-yellow-400'=>$forecastDay['temperature'] > 20 && $forecastDay['temperature'] <= 30,
        'text-red-600'=>$forecastDay['temperature'] > 30])>
                                            {{$forecastDay['temperature']}}°C
                                        </div>
                                    </div>
                                </div>


                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </main>
    @endif
</div>


{{--<div class="flex flex-col items-center space-y-2">--}}
{{--    <div class="text-2xl font-bold tracking-tight leading-none text-gray-100">{{\Carbon\Carbon::parse($forecastDay['weather_date'])->format('d-m-y H:i')}}</div>--}}
{{--    <div class="text-lg font-medium text-gray-100">{{$forecastDay['condition']}}--}}
{{--        - {{$forecastDay['description']}}</div>--}}
{{--    <div class="text-lg font-medium text-gray-100"></div>--}}
{{--    <div class="p-6 text-gray-900 dark:text-gray-100">--}}
{{--       --}}
{{--        <p>{{$forecastDay['description']}}</p>--}}
{{--    </div>--}}
{{--</div>--}}