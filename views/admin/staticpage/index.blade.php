@extends('layouts.admin')
@section('title', 'Страницы подборок мебели')

@section('content')

@if ($errors->any())
  @include ('includes.alerts.errors')   
@endif
 
@if (session('status'))
  @include ('includes.alerts.success') 
@endif


<body class="relative">
  <div class="w-full">
    <div class="w-full h-full bg-white dark:bg-darker px-4 mx-auto">
      <header class="border-t flex items-center py-3">
        <div class="flex">
          <h2 class="font-semibold text-lg">
           Страницы подборок мебели:
          </h2>
        </div>
        <div class="ml-auto">
          <a href="{{ route('admin.staticpages.create') }}" class="border bg-blue-500 text-white hover:bg-violet-700 font-medium rounded-md px-3 py-2 leading-none">Добавить страницу
          </a>
        </div>
      </header>
      <div class="mx-auto w-full h-full flex flex-col items-center justify-center">
        <div x-data="dataTable()"
        x-init="
        initData()
        $watch('searchInput', value => {
          search(value)
        })" class="bg-white dark:bg-darker px-2 py-1 shadow-md w-full flex flex-col">
          <div class="flex justify-between items-center">
            <div class="flex space-x-2 items-center">
              <p class="text-sm whitespace-nowrap">Выводить по:</p>
              <select class="block appearance-none outline-none text-sm font-medium text-gray-700 border border-gray-400 w-full py-1 px-3 pr-6 rounded focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-1" x-model="view" @change="changeView()">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
            </div>
            <div>
              <input x-model="searchInput" type="text" class="block appearance-none outline-none text-sm font-medium text-gray-700 border border-gray-400 w-full py-1 px-3 pr-6 rounded focus:outline-none focus:border-blue-500 focus:ring-blue-500 focus:ring-1" placeholder="Поиск...">
            </div>
          </div>
          <table class="mt-5">
            <thead class="border-b-2 text-sm font-medium text-gray-500 dark:text-primary-light">
              <th width="2.5%">
                <div class="flex space-x-2">
                  <span>
                    №
                  </span>
                </div>
              </th>
              <th width="20%">
                <div class="flex space-x-2">
                  <span>
                    Название страницы
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('name', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'name' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('name', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'name' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
              <th width="25%">
                <div class="flex space-x-2">
                  <span>
                    ЧПУ url
                  </span>
                </div>
              </th>
              <th width="12.5%">
                <div class="flex space-x-2">
                  <span>
                    Создана
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('created_at', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'created_at' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('created_at', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'created_at' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
              <th width="12.5%">
                <div class="flex space-x-2">
                  <span>
                    Изменена
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('updated_at', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'updated_at' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('updated_at', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'updated_at' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
          
              <th width="30%">
                <div class="flex justify-center items-center">
                  <span class="">
                    Действие
                  </span>
                </div>
              </th>
            </thead>
            <tbody>

              <template x-for="(item, index) in items" :key="index">
                <tr x-show="checkView(index + 1)" class="hover:bg-violet-200 text-sm font-medium text-gray-500 dark:text-primary-light even:bg-gray-100 odd:bg-blue-200 dark:bg-darker">
                  <td class="py-3">
                    <span x-text="item.number"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.name"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.cnc"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.created_at"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.updated_at"></span>
                  </td>                  
                  <td class="py-3 flex items-center justify-center">
                    <a :href="item.link_meta" title="Добавить SEO данные" class="inline-block mr-2">
                      <svg class="text-orange-400 w-5 h-5" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        @include('includes.svg.book-admin')
                      </svg>
                    </a>
                    <a :href="item.link_related" title="Сопутствующие товары" class="inline-block mr-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-500 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </a>
                    <a :href="item.link_show" title="Просмотр страницы на сайте" class="inline-block mr-2">
                      <svg class="text-green-500 w-5 h-5" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        @include('includes.svg.show-admin')
                      </svg>
                    </a>
                    <a :href="item.link_edit" title="Редактировать" class="inline-block mr-2">
                      <svg class="text-blue-500 w-5 h-5" width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                @include('includes.svg.edit-admin')
                      </svg>
                    </a>
                    <a :href="item.link_delete" title="Удалить" onclick="return confirm('Удалить страницу?')" class="inline-block mr-2">
                      <svg class="text-red-500 w-5 h-5" width="18" height="18" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  @include('includes.svg.delate-admin')
                      </svg>
                    </a>
                  </td>
                </tr>
              </template>
        
        
      
              <tr x-show="isEmpty()">
                <td colspan="5" class="text-center py-3 text-gray-900 text-sm">Ничего не найдено</td>
              </tr>
            </tbody>
          </table>
          <div class="flex mt-5">
            <div class="border px-2 cursor-pointer" @click.prevent="changePage(1)">
              <span class="text-gray-700">Начало</span>
            </div>
            <div class="border px-2 cursor-pointer" @click="changePage(currentPage - 1)">
              <span class="text-gray-700"><</span>
            </div>
            <template x-for="item in pages">
              <div @click="changePage(item)" class="border px-2 cursor-pointer" x-bind:class="{ 'bg-gray-300': currentPage === item }">
                <span class="text-gray-700" x-text="item"></span>
              </div>
            </template>
            <div class="border px-2 cursor-pointer" @click="changePage(currentPage + 1)">
              <span class="text-gray-700">></span>
            </div>
            <div class="border px-2 cursor-pointer" @click.prevent="changePage(pagination.lastPage)">
              <span class="text-gray-700">Конец</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

@push('scripts')
<script>
const data = []
 window.dataTable = function () {
  return {
    items: [],
    searchInput: '',
    view: 10,
    sorted: {
      field: 'updated_at',
      rule: 'desc'
    },    
    pages: [],
    offset: 6,
    pagination: {
      total: 0, 
      lastPage: 0, 
      perPage: 10,
      currentPage: 1,
      from: 1,
      to: 1 * 10
    },
    currentPage: 1,     
    isEmpty() {
      return this.pagination.total ? false : true
    },      
    initData() {
       this.createGetFromUrl(1); 
    },
    createGetFromUrl (page){
      let params = {
        ajax:1,
        page:page,
        per_page:this.view,
        sort_by:this.sorted.field,
        order:this.sorted.rule,
      name:this.searchInput
      }
      
      
      let paramsArr = [];
      for (let x in params) {
        paramsArr.push(x + '=' + params[x])
      }
     
      let url = '/admin/staticpages?'+paramsArr.join('&'); 
      fetch(url)
        .then((response) => response.json())
        .then((json) => {
          console.log(json.data);
          this.items = json.data
          this.items=json.data;
          this.currentPage=this.pagination.currentPage= json.meta.currentPage;
          this.pagination.lastPage=json.meta.lastPage;
          this.pagination.total=json.meta.total;
          const from = (page - 1) * this.view + 1;
          let to = page * this.view
          if (page === this.pagination.lastPage) {
            to = this.pagination.total
          }
          this.pagination.from = from;
          this.pagination.to = to;  
          this.showPages()          
        });

      return url;
    },
    checkView(index) {
    return true
    },
    checkPage(item) {
      if (item <= this.currentPage + 5) {
      return true
      }
      return false
    },  
    search(value) {
      this.createGetFromUrl(1)
    },
    sort(field, rule) {
      this.sorted.field = field
      this.sorted.rule = rule
      this.createGetFromUrl (this.pagination.currentPage); 
    },
    changePage(page) {
      this.pagination.perPage = this.view
      this.createGetFromUrl (page); 
    },
    showPages() {
      const pages = []
      let from = this.pagination.currentPage - Math.ceil(this.offset / 2)
  
      if (from < 1) {
      from = 1
      }
      let to = from + this.offset - 1
      if (to > this.pagination.lastPage) {
      to = this.pagination.lastPage
      }
      while (from <= to) {
      pages.push(from)
      from++
      }
      this.pages = pages
    },
    changeView() {
      this.changePage(1)
      this.showPages()
    },
  }
}
</script>
@endpush
@endsection