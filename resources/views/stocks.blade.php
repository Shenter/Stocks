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
                            <td>Количество</td>
                            <td>Цена покупки</td>
                            <td>Текущая цена</td>
                            <td>Изменение</td>
                            <td>Действия</td>

                        </tr>
                        </thead>
                        <tbody>

{{--{{ dd($catalog)}}--}}
                   @forelse($catalog as $stock)

                       <tr>
                           <td>   <a href="{{route('stock.show',['stock'=>$stock['id']])}}">{{$stock['name']}}</a></td>
                           <td>{{$stock['count']}}</td>

                           <td> {{$stock['avgBuyPrice']}}</td>
                           <td>  {{$stock['currentPrice']}}</td>
                           <td>
                                @if($stock['change']<0)
                                    <font color="red">
                               @endif
                                @if($stock['change']>0)
                                    <font color="green">+
                               @endif
                                @if($stock['change']==0)
                                    <font>
                               @endif
                               {{$stock['change']}}%</td>
                       </font>
                           <td>Купить</td>
                           <td>Продать</td>
                    @empty
                        <p>У вас пока нет акций. Самое время <a href="{{route('dashboard')}}"><font color="red">купить</font></a></p>
                       </tr>
                    @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
