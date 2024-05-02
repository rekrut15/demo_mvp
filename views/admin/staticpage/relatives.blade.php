@extends('layouts.admin')
@section('title', 'Добавление товаров для посадочной страницы')

@section('content')

@if ($errors->any())
  @include ('includes.alerts.errors')   
@endif
 
@if (session('status'))
  @include ('includes.alerts.success') 
@endif




<body class="relative">
  <div class="pb-5">
    <div class="container mx-auto w-full h-full bg-white">
      <header class="bg-white border-t py-3 px-4">
        <div class="flex flex-wrap items-center justify-between">
          <div class="w-full md:w-auto p-2">
          <h2 class="font-semibold text-lg">
           Выбор товаров для посадочной страницы
          </h2>
        </div>
        <div class="ml-auto">
          <a href="{{ route('admin.staticpages.home') }}" class="border bg-blue-500 text-white hover:bg-violet-700 font-medium rounded-md px-3 py-2 leading-none">Посадочные страницы
          </a>
        </div>

          </div>
      </header>
      <div class="w-full h-full flex flex-col items-center justify-center">
        <div x-data="dataTable()"
        x-init="
        initData()
        $watch('searchInput', value => {
          search(value)
        })" class="bg-white px-2 py-1 shadow-md w-full flex flex-col">
          <div class="flex justify-between items-center">
            <div class="flex space-x-2 items-center">
              <p class="text-sm whitespace-nowrap">Выводить по:</p>
              <select class="block appearance-none outline-none text-sm font-medium text-gray-700 border border-gray-200 w-full py-1 px-3 pr-6 rounded focus:outline-none focus:border-green-500 focus:ring-green-500 focus:ring-1" x-model="view" @change="changeView()">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
            </div>
            <div class="flex justify-between items-center">
            <div class="flex flex-wrap">
              <p class="text-sm text-gray-700">Выбранные</p>
              <div class="flex flex-wrap justify-start items-center pl-3">
                      <input x-model="owned" type="checkbox" @click="ownFilter()">
                   </div>
            </div>
            <div class="pl-3">
              <input x-model="searchInput" type="text" class="block appearance-none outline-none text-sm font-medium text-gray-700 border border-gray-200 w-full py-1 px-3 pr-6 rounded focus:outline-none focus:border-green-500 focus:ring-green-500 focus:ring-1" placeholder="Поиск...">
            </div>
          </div>
          </div>
          <table class="mt-5">
            <thead class="border-b-2">
              <th width="30%">
                <div class="flex space-x-2">
                  <span>
                    Наименование
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('name', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'name' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('name', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-4 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'name' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
              <th width="20%">
                <div class="flex items-center space-x-2">
                  <span class="">
                    Категория
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('category', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-4 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'category' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('category', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-4 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'category' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
              <th width="10%">
                <div class="flex items-center space-x-2">
                  <span class="">
                    Цена
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('price', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-4 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'price' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('price', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-4 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'price' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
              <th width="15%">
                <div class="flex items-center space-x-2">
                  <span class="">
                    Дата редакции
                  </span>
                  <div class="flex flex-col">
                    <svg @click="sort('created_at', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-4 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'created_at' && sorted.rule === 'asc'}"><path d="M5 15l7-7 7 7"></path></svg>
                    <svg @click="sort('created_at', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-4 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'created_at' && sorted.rule === 'desc'}"><path d="M19 9l-7 7-7-7"></path></svg>
                  </div>
                </div>
              </th>
              <th width="15%">
                <div class="flex items-center space-x-2">
                  <span class="">
                    Добавление
                  </span>
                </div>
              </th>
            
            </thead>
            <tbody>

              <template x-for="(item, index) in items" :key="index">
                <tr x-show="checkView(index + 1)" class="hover:bg-gray-200 text-gray-900 text-xs">
                  <td class="py-3">
                    <span x-text="item.name"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.category"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.price"></span>
                  </td>
                  <td class="py-3">
                    <span x-text="item.date"></span>
                  </td>
                  <td class="py-3">
                    <div class="flex justify-center items-center">
                      <input x-model="item.checked" type="checkbox" @click="checkboxclick(item)">
                    </div>
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
	parent: {{$staticpage->id}},  
	owned:0,
    items: [],
    view: 25,
    searchInput: '',
    pages: [],
    offset: 25,
    pagination: {
      total: 0, 
      lastPage: 0, 
      perPage: 25,
      currentPage: 1,
      from: 1,
      to: 1 * 25
    },
    currentPage: 1,
    sorted: {
      field: 'name',
      rule: 'asc'
    },
  createGetFromUrl (page){

    let params = {
      ajax:1,
      page:page,
      per_page:this.view,
      sort_by:this.sorted.field,
      order:this.sorted.rule,
	  owned:this.owned,
	  name:this.searchInput
    } ;
    if (this.parent) {
      
      //params['parent_id'] = this.parent
    }
    //const url = new URL(window.location.href);
    //url.searchParams.set('lib', value);
    //history.pushState(null, document.title, url.toString());
    
    let paramsArr = [];
    for (let x in params) {
      paramsArr.push(x + '=' + params[x])
    }
    
    let url = '/admin/staticpages/'+this.parent+'/relatives?'+paramsArr.join('&') 

    fetch(url)
            .then((response) => response.json())
            .then((json) => {
    console.log(json)
        this.items = json.data

        this.currentPage = this.pagination.currentPage  = json.meta.currentPage
        this.pagination.lastPage  = json.meta.lastPage
        this.pagination.total = json.meta.total
    const from = (page - 1) * this.view + 1
        let to = page * this.view
        if (page === this.pagination.lastPage) {
          to = this.pagination.total
        }
    
        this.pagination.from = from
        this.pagination.to = to
        
        this.showPages()
        
    });
    return url
  },
    initData() {
      this.createGetFromUrl(1); 
    
    },
    compareOnKey(key, rule) {
    
    this.sorted.field = key;
    this.sorted.rule = rule;
    //this.createGetFromUrl(this.currentPage); 
  /*
    return;
      return function(a, b) { 
        if (key === 'name' || key === 'job' || key === 'email' || key === 'country') {
          let comparison = 0
          const fieldA = a[key].toUpperCase()
          const fieldB = b[key].toUpperCase()
          if (rule === 'asc') {
            if (fieldA > fieldB) {
              comparison = 1;
            } else if (fieldA < fieldB) {
              comparison = -1;
            }
          } else {
            if (fieldA < fieldB) {
              comparison = 1;
            } else if (fieldA > fieldB) {
              comparison = -1;
            }
          }
          return comparison
        } else {
          if (rule === 'asc') {
            return a.year - b.year
          } else {
            return b.year - a.year
          }
        }
      }
    */
    },
    checkView(index) {
    return true;
      //return index > this.pagination.to || index < this.pagination.from ? false : true
    },
    checkPage(item) {
      if (item <= this.currentPage + 5) {
        return true
      }
      return false
    },
	ownFilter(e) {
		
		this.owned = this.owned ? 0 : this.parent ;
		
	    this.createGetFromUrl(1); 	
	},
    search(value) {
    this.createGetFromUrl(1)
    return;
      if (value.length > 1) {
        const options = {
          shouldSort: true,
          keys: ['name', 'job'],
          threshold: 0
        }                
        const fuse = new Fuse(data, options)
        this.items = fuse.search(value).map(elem => elem.item)
      } else {
        this.items = data
      }
      // console.log(this.items.length)
      
      this.changePage(1)
      this.showPages()
    },
    sort(field, rule) {
      //this.items = this.items.sort(this.compareOnKey(field, rule))
      this.sorted.field = field
      this.sorted.rule = rule
    this.createGetFromUrl (this.pagination.currentPage); 
    },
    changePage(page) {
    this.pagination.perPage = this.view
    this.createGetFromUrl (page); 
    return;
    /*
      if (page >= 1 && page <= this.pagination.lastPage) {
        this.currentPage = page
        const total = this.items.length
        const lastPage = Math.ceil(total / this.view) || 1
        const from = (page - 1) * this.view + 1
        let to = page * this.view
        if (page === lastPage) {
          to = total
        }
        this.pagination.total = total
        this.pagination.lastPage = lastPage
        this.pagination.perPage = this.view
        this.pagination.currentPage = page
        this.pagination.from = from
        this.pagination.to = to
        this.showPages()
      }
    */
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
    isEmpty() {
      return this.pagination.total ? false : true
    }, 
	checkboxclick(item) {
		let id = item.id;
		let paramsArr = [];
		paramsArr.push('rid='+item.id)
		if (item.checked) {
			paramsArr.push('action=remove')
					//alert('снять')
		} else {
			paramsArr.push('action=add')
			//alert('добавить')
		}
		
		let url = '/admin/staticpages/'+this.parent+'/set-relatives?'+paramsArr.join('&') 

		fetch(url)
            .then((response) => response.json())
            .then((json) => {
			  console.log(json)		
		});
	}
  }
}
</script>
@endpush

@endsection 