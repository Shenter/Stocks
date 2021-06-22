<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$stock->name}}
        </h2>
    </x-slot>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</script>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Ошибка!</strong><br>
                    <span class="block sm:inline">{{$errors->first('message')}}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <div>

                      <form method="POST" action={{route('stock.buy.confirm',['stock'=>$stock->id])}} class="w-full ">


                          @csrf
                      </div>




                    У вас в наличии - {{Auth::user()->money/100}}
                      <br>
                      Цена 1 - {{$stock->getLatestPrice()/100}}
                      <br>
                      Комиссия за покупку - {{$stock::$TAX}}%
                      <br>
                    <div class="flex flex-wrap -mx-3 mb-2">

                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label for="count" class="block text-sm font-medium text-gray-700">
                                Кол-во
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">

                                <input  id="count" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full  pr-12 sm:text-sm border-gray-300 rounded-md"  type="number" max="{{$howManystockscanBuy}}" min="1" step="1" placeholder="1" value="1" name="count">

                            </div>


                            <div class="relative">

{{--                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="number" max="{{$howManystockscanBuy}}" min="1" step="1" placeholder="1" value="1" name="count">--}}

{{--                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="number" min="1"  step="1" placeholder="1" value="1"  max="{{$howManystockscanBuy}}" name="count">--}}

{{--                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" name="count">--}}
{{--                                    @for($i=1; $i<=$howManystockscanBuy;$i++)--}}
{{--                                        <option value="{{$i}}">{{$i}}--}}

{{--                                        </option>--}}
{{--                                    @endfor--}}
{{--                                </select>--}}
{{--                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">--}}
{{--                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                  <span class="text-gray-500 sm:text-sm">
                                    $
                                  </span>
                                </div>
                                <input type="text" name="price" id="price" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="1" max="{{$stock->getLatestPrice()/100}}"  step="0.01" value="{{$stock->getLatestPrice()/100}}"  >

                            </div>
                        </div>

                  </div>
                    <input type="submit" value="Купить" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

