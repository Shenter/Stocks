
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stocks') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('messages'))
            <div class="px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                <p class="font-bold">Это успех!</p>
                <p>{{session('messages')}}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">

                    <table width="100%">
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


                   @forelse($catalog as $stock)

                       <tr>
                           <td>   <a href="{{route('stock.show',['stock'=>$stock['id']])}}">{{$stock['name']}}</a></td>
                           <td>{{$stock['count']}}</td>

                           <td> {{$stock['avgBuyPrice']/100}}</td>
                           <td>  {{$stock['currentPrice']/100}}</td>
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
                               {{$stock['change']}}% </font>
                           </td>


                           <td>
                               @if ($stock['userHasMoneyToBuyStock'])
                                   <a href="{{route('stock.buy', ['stock'=>$stock['id']])}}">
                               <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">


                               @else
                                   <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                               @endif
                                       Купить
                                   </button>
                                   </a>
                               </td>
                           <td>
                               <a href="{{route('stock.sell', ['stock'=>$stock['id']])}}">
                                   <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">

                                   Продать
                               </button>
                               </a>
                           </td>
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
