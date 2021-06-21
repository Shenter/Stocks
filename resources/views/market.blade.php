<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stocks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table width="60%">
                        <thead>
                        <tr>
                            <td>Наименование</td>
                            <td>Наличие дивидендов</td>
                            <td>Изменение за день</td>
                            <td>Действия</td>

                        </tr>
                        </thead>
                        <tbody>

{{--{{ dd($catalog)}}--}}
                   @foreach($stocks as $stock)

                       <tr>
                           <td><a href="{{route('stock.show',['stock'=>$stock['id']])}}">{{$stock['name']}}</a></td>
                           <td>-</td>
                           <td>-</td>
                           <td>
                               @if (Auth::user()->howManystockscanBuy($stock['id']))
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
                           </td>
                           <td>
                                   @if ( !Auth::user()->howManystockscanSell($stock['id'])  )
                                       <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">Продать
                                       </button>
                                   @else
                                   <a href="{{route('stock.sell', ['stock'=>$stock['id']])}}">
                                           <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Продать
                                           </button>
                                   </a>
                                    @endif
                           </td>
                       </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
