@extends('layouts.admin')
@section('title', 'Добавление посадочной страницы')

@section('content')

@if ($errors->any())
	@include ('includes.alerts.errors')   
@endif
 
@if (session('status'))
  @include ('includes.alerts.success') 
@endif

<form method="post" enctype="multipart/form-data">
@csrf
  <section class="bg-coolGray-50 py-4">
  <div class="container px-4 mx-auto">
    <div class="p-6 h-full border border-coolGray-100 overflow-hidden bg-white rounded-md shadow-dashboard">
      <div class="pb-6 border-b border-coolGray-100">
        <div class="flex flex-wrap items-center justify-between -m-2">
          <div class="w-full md:w-auto p-2">
            <h2 class="text-coolGray-900 text-lg font-semibold">Страница</h2>
            <p class="text-xs text-coolGray-500 font-medium">Добавление посадочной страницы</p>
          </div>
          <div class="w-full md:w-auto p-2">
            <div class="flex flex-wrap justify-between -m-1.5">
              <div class="w-full md:w-auto p-1.5">
                <a href="{{ route('admin.staticpages.home') }}" class="flex flex-wrap justify-center w-full px-4 py-2 font-medium text-sm text-coolGray-500 hover:text-coolGray-600 border border-coolGray-200 hover:border-coolGray-300 bg-white rounded-md shadow-button">
                  <p>Назад</p>
                </a>
              </div>
              <div class="w-full md:w-auto p-1.5">
                <button class="flex flex-wrap justify-center w-full px-4 py-2 bg-green-500 hover:bg-green-600 font-medium text-sm text-white border border-green-500 rounded-md shadow-button">
                  <p>Сохранить</p>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="py-6 border-b border-coolGray-100">
        <div class="w-full">
          <div class="flex flex-wrap -m-3">
            <div class="w-full md:w-1/4 p-3">
              <p class="text-sm text-coolGray-800 font-semibold">Название страницы</p>
            </div>
            <div class="w-full md:flex-1 p-3">
              <input class="@error('name') border-red-500 @enderror w-full px-4 py-2.5 text-base text-coolGray-900 font-normal outline-none focus:border-green-500 border border-coolGray-200 rounded-lg shadow-input" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Введите заголовок новости">
              @error('name')
                <p class="text-red-500">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
      </div>
      <div class="py-6 border-b border-coolGray-100">
        <div class="w-full">
          <div class="flex flex-wrap -m-3">
            <div class="w-full md:w-1/4 p-3">
              <p class="text-sm text-coolGray-800 font-semibold">ЧПУ url</p>
            </div>
            <div class="w-full md:flex-1 p-3">
              <input class="@error('cnc') border-red-500 @enderror w-full px-4 py-2.5 text-base text-coolGray-900 font-normal outline-none focus:border-green-500 border border-coolGray-200 rounded-lg shadow-input" id="cnc" name="cnc" type="text" value="{{ old('cnc') }}" placeholder="Введите ЧПУ url, который нужен">
              @error('cnc')
                <p class="text-red-500">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
      </div>
      @include('admin.includes.image',[
      'prefix'=>'staticpage',
    'session_form'=> $session_main_form,
    'l_id'=>0
    ])
    @include('admin.includes.image-mob',[
      'prefix'=>'staticpage',
    'session_form'=> $session_mob_form,
    'l_id'=>0
    ])        
      <div class="flex flex-wrap items-center justify-between -m-2">
        <div class="w-full md:w-auto p-2">
          <h2 class="text-coolGray-900 text-lg font-semibold">Страница</h2>
          <p class="text-xs text-coolGray-500 font-medium">Добавление посадочной страницы</p>
        </div>
        <div class="w-full md:w-auto p-2">
          <div class="flex flex-wrap justify-between -m-1.5">
            <div class="w-full md:w-auto p-1.5">
              <a href="{{ route('admin.staticpages.home') }}" class="flex flex-wrap justify-center w-full px-4 py-2 font-medium text-sm text-coolGray-500 hover:text-coolGray-600 border border-coolGray-200 hover:border-coolGray-300 bg-white rounded-md shadow-button">
                <p>Назад</p>
              </a>
            </div>
            <div class="w-full md:w-auto p-1.5">
              <button class="flex flex-wrap justify-center w-full px-4 py-2 bg-green-500 hover:bg-green-600 font-medium text-sm text-white border border-green-500 rounded-md shadow-button">
                <p>Сохранить</p>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  
</form>

@endsection