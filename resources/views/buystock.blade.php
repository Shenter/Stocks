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
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                                Кол-во
                            </label>
                            <div class="relative">
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" name="count">
                                    @for($i=1; $i<=$howManystockscanBuy;$i++)
                                        <option value="{{$i}}">{{$i}}

                                        </option>
                                    @endfor
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                                Цена
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="number" min="{{$stock->getLatestPrice()/100}}"  step="0.01" placeholder="1" value="{{$stock->getLatestPrice()/100}}" name="price">
                        </div>

                  </div>
                    <input type="submit" value="Купить" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

