
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
{{--            {{$stock->name}}--}}
        </h2>
    </x-slot>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->howManyStocksCanBuy($stock['id']))
                        <a href="{{route('stock.buy', ['stock'=>$stock['id']])}}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                Купить
                            </button>
                        </a>
                    @else
                        <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                            Купить
                        </button>
                        @endif

                            @if ( !Auth::user()->howManyStocksCanSell($stock['id'])  )
                                <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                                    Продать
                                </button>
                            @else
                                <a href="{{route('stock.sell', ['stock'=>$stock['id']])}}">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                        Продать
                                    </button>
                                </a>
                            @endif

                        Период:
                        <select name="period" >
                            <option value="day" onclick="location.href='{{route('stock.show',['stock'=>$stock['id'],'period'=>'day'])}}'" @if(request()->period=='day') selected @endif>День</option>
                            <option value="month" onclick="location.href='{{route('stock.show',['stock'=>$stock['id'],'period'=>'month'])}}'" @if(request()->period=='month') selected @endif>Месяц</option>
                        </select>

                  <div>
                    <canvas id="myChart"></canvas>
                  </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        const labels = [
            @foreach   ($dates as $date)
                "{{ $date->created_at}}",
            @endforeach


        ];
        const data = {
            labels: labels,
            datasets: [{
                label: '',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: {{$values}},

            }]
        };
        const config = {
            type: 'line',
            data,
            options: {}
        };

        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
</x-app-layout>


