(function(t){function e(e){for(var r,a,s=e[0],c=e[1],u=e[2],d=0,l=[];d<s.length;d++)a=s[d],o[a]&&l.push(o[a][0]),o[a]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(t[r]=c[r]);f&&f(e);while(l.length)l.shift()();return i.push.apply(i,u||[]),n()}function n(){for(var t,e=0;e<i.length;e++){for(var n=i[e],r=!0,a=1;a<n.length;a++){var s=n[a];0!==o[s]&&(r=!1)}r&&(i.splice(e--,1),t=c(c.s=n[0]))}return t}var r={},a={app:0},o={app:0},i=[];function s(t){return c.p+"js/"+({about:"about"}[t]||t)+"."+{about:"a7af16c8","chunk-0fb7418a":"382d1c90","chunk-18beb0ee":"60c3cb7a","chunk-457db554":"b6463cef","chunk-41c3a02b":"96207b2b","chunk-c76aef02":"173820cc","chunk-5d479cda":"3a824af9","chunk-7da43ca4":"1bb49838","chunk-ae008d94":"d6e921ea","chunk-c393d520":"8c375ea6"}[t]+".js"}function c(e){if(r[e])return r[e].exports;var n=r[e]={i:e,l:!1,exports:{}};return t[e].call(n.exports,n,n.exports,c),n.l=!0,n.exports}c.e=function(t){var e=[],n={"chunk-0fb7418a":1,"chunk-18beb0ee":1,"chunk-41c3a02b":1,"chunk-c76aef02":1,"chunk-5d479cda":1,"chunk-7da43ca4":1,"chunk-ae008d94":1,"chunk-c393d520":1};a[t]?e.push(a[t]):0!==a[t]&&n[t]&&e.push(a[t]=new Promise(function(e,n){for(var r="css/"+({about:"about"}[t]||t)+"."+{about:"31d6cfe0","chunk-0fb7418a":"03c5226c","chunk-18beb0ee":"83916c0f","chunk-457db554":"31d6cfe0","chunk-41c3a02b":"e583347c","chunk-c76aef02":"efa7504c","chunk-5d479cda":"a44ff2f6","chunk-7da43ca4":"8af679a4","chunk-ae008d94":"bfe34a54","chunk-c393d520":"8af679a4"}[t]+".css",o=c.p+r,i=document.getElementsByTagName("link"),s=0;s<i.length;s++){var u=i[s],d=u.getAttribute("data-href")||u.getAttribute("href");if("stylesheet"===u.rel&&(d===r||d===o))return e()}var l=document.getElementsByTagName("style");for(s=0;s<l.length;s++){u=l[s],d=u.getAttribute("data-href");if(d===r||d===o)return e()}var f=document.createElement("link");f.rel="stylesheet",f.type="text/css",f.onload=e,f.onerror=function(e){var r=e&&e.target&&e.target.src||o,i=new Error("Loading CSS chunk "+t+" failed.\n("+r+")");i.code="CSS_CHUNK_LOAD_FAILED",i.request=r,delete a[t],f.parentNode.removeChild(f),n(i)},f.href=o;var h=document.getElementsByTagName("head")[0];h.appendChild(f)}).then(function(){a[t]=0}));var r=o[t];if(0!==r)if(r)e.push(r[2]);else{var i=new Promise(function(e,n){r=o[t]=[e,n]});e.push(r[2]=i);var u,d=document.createElement("script");d.charset="utf-8",d.timeout=120,c.nc&&d.setAttribute("nonce",c.nc),d.src=s(t),u=function(e){d.onerror=d.onload=null,clearTimeout(l);var n=o[t];if(0!==n){if(n){var r=e&&("load"===e.type?"missing":e.type),a=e&&e.target&&e.target.src,i=new Error("Loading chunk "+t+" failed.\n("+r+": "+a+")");i.type=r,i.request=a,n[1](i)}o[t]=void 0}};var l=setTimeout(function(){u({type:"timeout",target:d})},12e4);d.onerror=d.onload=u,document.head.appendChild(d)}return Promise.all(e)},c.m=t,c.c=r,c.d=function(t,e,n){c.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},c.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},c.t=function(t,e){if(1&e&&(t=c(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(c.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)c.d(n,r,function(e){return t[e]}.bind(null,r));return n},c.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return c.d(e,"a",e),e},c.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},c.p="/",c.oe=function(t){throw console.error(t),t};var u=window["webpackJsonp"]=window["webpackJsonp"]||[],d=u.push.bind(u);u.push=e,u=u.slice();for(var l=0;l<u.length;l++)e(u[l]);var f=d;i.push([0,"chunk-vendors"]),n()})({0:function(t,e,n){t.exports=n("56d7")},"167a":function(t,e,n){},"1b36":function(t,e,n){"use strict";var r=n("1ed5"),a=n.n(r);a.a},"1ed5":function(t,e,n){},"25be":function(t,e,n){"use strict";n.d(e,"a",function(){return p}),n.d(e,"c",function(){return b});var r=n("d225"),a=n("308d"),o=n("6bb5"),i=n("4e2b"),s=n("bc3a"),c=n.n(s),u=window.location.origin,d={"X-CSRF-TOKEN":document.head.querySelector("meta[name=csrf-token]").getAttribute("content"),"X-Requested-With":"XMLHttpRequest"},l=c.a.create({baseURL:u,headers:d});function f(t){l.defaults.headers["X-CSRF-TOKEN"]=t,document.querySelector("meta[name=csrf-token]").setAttribute("content",t)}function h(){l.get("/").then(function(t){var e=t.data,n=document.createElement("div");return n.innerHTML=e,n.querySelector("meta[name=csrf-token]").getAttribute("content")}).then(function(t){f(t)})}l.interceptors.response.use(function(t){return t.headers&&t.headers["new-token"]&&t.headers["new-token"].length&&f(t.headers["new-token"]),t},function(t){return Promise.reject(t)}),setInterval(h,3e6);var m=function(t){function e(){return Object(r["a"])(this,e),Object(a["a"])(this,Object(o["a"])(e).apply(this,arguments))}return Object(i["a"])(e,t),e}(l);e["b"]=m;var p=c.a.CancelToken,b=c.a.isCancel},"56d7":function(t,e,n){"use strict";n.r(e);n("cadf"),n("551c"),n("f751"),n("097d");var r=n("2b0e"),a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"p-0",attrs:{id:"app"}},[n("nav-bar"),n("transition",{attrs:{name:"fade",mode:"out-in"}},[n("router-view")],1)],1)},o=[],i=(n("4989"),function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("nav",{staticClass:"navbar navbar-expand navbar-dark bg-dark pl-0 pr-0"},[n("div",{staticClass:"row w-100 m-0"},[n("div",{staticClass:"col"},[n("ul",{staticClass:"navbar-nav row text-center"},[n("li",{ref:"brandWidth",staticClass:"nav-item col pl-0 pr-0"},[n("router-link",{staticClass:"navbar-brand",attrs:{to:{name:"main"}}},[t._v("ИНВЕСТТЕХ.Объекты")])],1),n("li",{staticClass:"nav-item col dropdown text-uppercase pl-0 pr-0"},[n("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"/",id:"categoryDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[t._v(t._s(t.currentCategoryName))]),n("div",{staticClass:"dropdown-menu my-dropdown-menu-center category",attrs:{"aria-labelledby":"categoryDropdown"}},t._l(t.selectableCategories,function(e,r){return n("a",{key:r,staticClass:"dropdown-item",attrs:{href:"/"},on:{click:function(n){return n.preventDefault(),t.changeCategory(e.slug)}}},[t._v(t._s(e.name))])}),0)]),n("search-object",{attrs:{"is-main-view":t.isMainView}}),n("li",{staticClass:"nav-item col col-auto"},[n("div",{staticClass:"btn-group",attrs:{role:"group"}},[n("button",{staticClass:"btn btn-outline-dark rounded-0",class:{active:t.activeItems.map},attrs:{type:"button",disabled:!t.isMainView},on:{click:function(e){return e.preventDefault(),t.toggleBlocks("ObjectsListBlock",!1)}}},[t._v("Карта")]),n("button",{staticClass:"btn btn-outline-dark rounded-0",class:{active:t.activeItems.objectsList},attrs:{type:"button",disabled:!t.isMainView},on:{click:function(e){return e.preventDefault(),t.toggleBlocks("ObjectsListBlock",!0)}}},[t._v("Список")])])]),n("li",{ref:"favourites",staticClass:"nav-item col col-auto"},[n("a",{staticClass:"nav-link",class:{active:t.favouritesOn,disabled:!t.isMainView},attrs:{href:"/"},on:{click:function(e){return e.preventDefault(),t.switchFavoritesState(e)}}},[n("i",{staticClass:"fa fa-heart mr-2",class:{"text-danger":t.favouritesOn}}),t._v("\n            Избранное\n          ")])]),n("lk-menu-navbar"),n("li",{ref:"filterWidth",staticClass:"nav-item col text-uppercase pl-0 pr-0"},[n("a",{staticClass:"nav-link dropdown-toggle",class:{active:t.activeItems.filter||t.filtersOn,disabled:!t.isMainView},attrs:{href:"/"},on:{click:function(e){return e.preventDefault(),t.toggleBlocks("FilterBlock","reverse")}}},[n("span",{staticClass:"d-inline-block position-relative"},[t._v("\n              Фильтр\n              "),t.filtersOn?n("button",{staticClass:"btn btn-outline-danger btn-sm btn-reset",on:{click:function(e){return e.stopPropagation(),e.preventDefault(),t.filterReset(e)}}},[t._v("Сброс")]):t._e()])])])],1)])])])}),s=[],c=(n("7f7f"),function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("li",{staticClass:"nav-item col col-auto dropdown"},[n("form",[n("input",{directives:[{name:"model",rawName:"v-model",value:t.text,expression:"text"}],staticClass:"form-control bg-transparent border-white text-white",attrs:{type:"text",placeholder:"Лот или адрес",disabled:t.disabled||!t.isMainView},domProps:{value:t.text},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:t.clearForm(e)},blur:t.closeDropdown,focus:t.focusInput,input:function(e){e.target.composing||(t.text=e.target.value)}}})]),n("div",{ref:"searchDropdown",staticClass:"dropdown-menu dropdown-search"},[t.foundedObjects.length?t._l(t.foundedObjects,function(e,r){return n("a",{key:e.id,staticClass:"dropdown-item text-truncate",attrs:{href:"/","data-object-index":r}},[t._v(t._s("Лот "+e.id+", "+e.address))])}):[n("span",{staticClass:"dropdown-item notfound"},[t._v("\n        Ничего не найдено\n      ")])]],2)])}),u=[],d=(n("4917"),n("3b2b"),n("a481"),n("1157")),l=n.n(d),f={name:"SearchObject",props:["isMainView"],data:function(){return{text:"",disabled:!1,minSearchStringLength:1}},computed:{objects:function(){return this.$store.getters.objects},modifiedText:function(){return this.text.trim().replace("  "," ")},foundedObjects:function(){if(this.modifiedText.length>=this.minSearchStringLength){var t=new RegExp(this.modifiedText,"i"),e=this.objects.filter(function(e){var n=e.id+e.address;return n.match(t)});return e.length>10&&(e.length=10),e}return[]},currentCategorySlug:function(){return this.$store.state.currentCategorySlug}},watch:{text:function(t,e){t.length>=this.minSearchStringLength&&e.length<this.minSearchStringLength&&l()(this.$refs.searchDropdown).dropdown("show")}},methods:{checkIfObjectFromAnotherCategory:function(t){var e=this;return this.currentCategorySlug!==t.type&&(this.$store.commit("changeCurrentCategorySlug",t.type),setTimeout(function(){e.chooseObject(t)},0),!0)},chooseObject:function(t){this.checkIfObjectFromAnotherCategory(t)||(this.$store.commit("main/filterReset"),this.$store.commit("main/switchFavoritesState",!1),this.$store.commit("main/changeCurrentObject",t),this.$store.commit("main/toggleBlocksVisibility",{block:"ObjectFullInfo",visible:!0}),this.$store.commit("main/showObjectAtMap",t.coordinates))},closeDropdown:function(t){if(t.relatedTarget&&t.relatedTarget.hasAttribute("data-object-index")){var e=t.relatedTarget.getAttribute("data-object-index"),n=this.foundedObjects[e];this.chooseObject(n)}l()(this.$refs.searchDropdown).dropdown("hide")},focusInput:function(){(this.foundedObjects.length||this.text.length>=this.minSearchStringLength)&&l()(this.$refs.searchDropdown).dropdown("show")},clearForm:function(){this.text=""}}},h=f,m=(n("be32"),n("2877")),p=Object(m["a"])(h,c,u,!1,null,"b24bbfb2",null),b=p.exports,g=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("li",{staticClass:"nav-item col col-auto dropdown"},[n("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"/",id:"lkDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[t._v("\n    Кабинет\n    "),n("i",{staticClass:"fa fa-user ml-2",class:{"text-primary":t.isAuthorized}})]),n("div",{staticClass:"dropdown-menu w-auto lk-menu",attrs:{"aria-labelledby":"lkDropdown"}},[["admin","manager"].includes(t.user.role)?[n("router-link",{staticClass:"dropdown-item",attrs:{to:{name:"lk-object",params:{id:"new"}}}},[t._v("\n          Новый объект\n      ")]),n("router-link",{staticClass:"dropdown-item",attrs:{to:{name:"lk-objects"}}},[t._v("\n          Каталог\n      ")])]:t._e(),"admin"===t.user.role?n("router-link",{staticClass:"dropdown-item",attrs:{to:{name:"lk-users"}}},[t._v("\n      Пользователи\n    ")]):t._e(),t.isAuthorized?[n("router-link",{staticClass:"dropdown-item",attrs:{to:{name:"lk-account"}}},[t._v("\n        Аккаунт\n      ")]),n("a",{staticClass:"dropdown-item",attrs:{href:""},on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[t._v("Выйти")]),n("form",{ref:"logoutForm",staticStyle:{display:"none"},attrs:{action:"/logout",method:"POST"}},[n("input",{ref:"csrf",attrs:{type:"hidden",name:"_token"}})])]:n("router-link",{staticClass:"dropdown-item",attrs:{to:{name:"lk-login"}}},[t._v("\n      Войти\n    ")])],2)])},v=[],k=(n("854a"),n("25be")),y={name:"LkMenuNavbar",computed:{isAuthorized:function(){return this.$store.state.isAuthorized},user:function(){return this.$store.state.user}},methods:{logout:function(t){"main"===this.$route.name&&t.stopPropagation(),this.$refs.csrf.value=document.head.querySelector("meta[name=csrf-token]").getAttribute("content"),this.$refs.logoutForm.submit()}}},S=y,w=(n("1b36"),Object(m["a"])(S,g,v,!1,null,null,null)),j=w.exports,C={components:{SearchObject:b,LkMenuNavbar:j},data:function(){return{allCategories:[{name:"Земельные участки",slug:"ZU"},{name:"Инвестобъекты",slug:"Invest"}]}},computed:{currentCategoryName:function(){var t,e=this;return this.allCategories.some(function(n){return n.slug===e.currentCategorySlug&&(t=n,!0)}),t?t.name:""},selectableCategories:function(){var t=this;return this.allCategories.filter(function(e){return e.slug!==t.currentCategorySlug})},favouritesOn:function(){return!!this.storeHasMainModule&&this.$store.state.main.favouritesOn},currentCategorySlug:function(){return this.$store.state.currentCategorySlug},storeHasMainModule:function(){return"main"in this.$store.state},activeItems:function(){return this.storeHasMainModule?this.$store.getters["main/activeItems"]:{}},filtersOn:function(){return!!this.storeHasMainModule&&this.$store.state.main.filtersOn},isMainView:function(){return"main"===this.$route.name}},mounted:function(){var t=this.$refs.filterWidth.offsetWidth,e=this.$refs.brandWidth.offsetWidth;this.$store.commit("setFilterWidth",t),this.$store.commit("setObjectBlockWidth",e),this.$store.commit("setFavoritesOffsetLeft",this.$refs.favourites.offsetLeft)},methods:{changeCategory:function(t){this.storeHasMainModule&&(this.filterReset(),this.$store.commit("main/changeCurrentObject",{})),this.$store.commit("changeCurrentCategorySlug",t)},toggleBlocks:function(t,e){this.storeHasMainModule&&("ObjectsListBlock"===t&&this.activeItems.map===e&&this.$store.commit("main/changeCurrentObject",{}),this.$store.commit("main/toggleBlocksVisibility",{block:t,visible:e}))},switchFavoritesState:function(){this.storeHasMainModule&&this.$store.commit("main/switchFavoritesState")},filterReset:function(){this.$store.commit("main/filterReset")}}},O=C,M=(n("ed6b"),Object(m["a"])(O,i,s,!1,null,null,null)),_=M.exports,x={components:{NavBar:_},beforeCreate:function(){}},$=x,I=(n("5c0b"),Object(m["a"])($,a,o,!1,null,null,null)),A=I.exports,D=(n("6762"),n("2fdb"),n("8c4f")),P=(n("8e6e"),n("bd86")),T=(n("ac6a"),n("456d"),n("6b54"),n("2f62")),N=(n("ed50"),[{address:"улица Петровка, 21с1-2",coordinates:[55.765417,37.615309],groundS:"0.22",areaS:"9273",type:"ZU"},{address:"Звонарский переулок, 1",coordinates:[55.764769,37.62095],groundS:"0.82",areaS:"2078",type:"Invest",buildingName:"Лапландия"},{address:"улица Кузнецкий Мост, 13/9с1",coordinates:[55.762409,37.623016],groundS:"0.59",areaS:"6249",type:"ZU"},{address:"улица Рождественка, 20/8с4",coordinates:[55.766101,37.624049],groundS:"0.68",areaS:"2165",type:"Invest",buildingName:"Новые времена"},{address:"Мясницкая улица, 1",coordinates:[55.760216,37.628595],groundS:"0.55",areaS:"8447",type:"ZU"},{address:"Большой Златоустинский переулок, 6с1",coordinates:[55.75864,37.632206],groundS:"0.1",areaS:"5062",type:"Invest",buildingName:"Островок"},{address:"Кривоколенный переулок, 10с5",coordinates:[55.761761,37.635673],groundS:"0.27",areaS:"3797",type:"ZU"},{address:"Милютинский переулок, 16с1",coordinates:[55.764242,37.632386],groundS:"0.85",areaS:"8404",type:"Invest",buildingName:"Каширский"},{address:"улица Покровка, 10с5",coordinates:[55.7586,37.644504],groundS:"0.44",areaS:"1427",type:"ZU"},{address:"Лялин переулок, 7/2с1",coordinates:[55.759603,37.652472],groundS:"0.25",areaS:"1364",type:"Invest",buildingName:"Космос"},{address:"Подсосенский переулок, 30",coordinates:[55.75479,37.65373],groundS:"0.87",areaS:"8802",type:"ZU"},{address:"Большой Николоворобинский переулок, 9/11",coordinates:[55.750753,37.64931],groundS:"0.74",areaS:"6009",type:"Invest",buildingName:"Москва Plaza"},{address:"Николоямская улица, 13с2",coordinates:[55.747991,37.651987],groundS:"0.01",areaS:"8449",type:"ZU"},{address:"Гончарная улица, 26к1",coordinates:[55.743015,37.649031],groundS:"0.07",areaS:"6018",type:"Invest",buildingName:"Айсберг"},{address:"Рабочая улица, 35к2",coordinates:[55.742255,37.687758],groundS:"0.64",areaS:"4163",type:"ZU"},{address:"Нижегородская улица, 32сБ",coordinates:[55.736635,37.689527],groundS:"0.74",areaS:"7252",type:"Invest",buildingName:"Европа"},{address:"Угрешская улица, 2с95",coordinates:[55.713045,37.691791],groundS:"0.68",areaS:"1226",type:"ZU"},{address:"улица Гурьянова, 73",coordinates:[55.678981,37.717231],groundS:"0.2",areaS:"5339",type:"Invest",buildingName:"Галереи Чижова"},{address:"Батюнинский проезд, 15с1",coordinates:[55.666442,37.697675],groundS:"0.29",areaS:"8059",type:"Invest",buildingName:"Сити Град"},{address:"Каширское шоссе, 44к2",coordinates:[55.647595,37.66221],groundS:"0.15",areaS:"8721",type:"ZU"},{address:"улица Москворечье, 4к5",coordinates:[55.643688,37.650729],groundS:"0.6",areaS:"2598",type:"Invest",buildingName:"Восток"}]),E=[{short:"ТЦ",full:"Торговый центр",bg:"primary",icon:"blueDotIcon"},{short:"МФК",full:"Многофункциональный комплекс",bg:"info",icon:"violetDotIcon"},{short:"БЦ",full:"Бизнес-центр",bg:"success",icon:"darkGreenDotIcon"},{short:"ИПН",full:"Инвестиционный портфель недвижимости",bg:"danger",icon:"redDotIcon"},{short:"ГО",full:"Гостиница",bg:"warning",icon:"orangeDotIcon"}],L=N.map(function(t,e){var n=t,r=e+1,a={id:r,lot:Math.round(1e4*Math.random()).toString().padEnd(4,"0"),district:"Москва, ЦАО",cost:1e8*Math.round(100*Math.random()),location:"Moscow"};return n.areaS=1e3*parseInt(t.areaS,10),n.groundS=parseFloat(t.groundS.toString()+Math.round(1e3*Math.random()).toString()),"Invest"===t.type?(a.buildingType=E[Math.floor(Math.random()*E.length)],a.GAP=1e4*Math.round(100*Math.random()),a.caprate=Math.round(50*Math.random()),a.image="/fakeImg/building.jpeg"):"ZU"===t.type&&(a.kadastrNumber="77:01:0004012",a.purpose=Math.random()>.5?"Жилое":"Нежилое",a.groundPlan=Math.random()>.5,a.image="/fakeImg/ZU.jpg",a.imageType=Math.random()>.5?"Проект":"Фото",a.ZUType=Math.random()>.5?"ОКС":"ЗУ"),Object.assign(n,a)}),B=(L.map(function(t){return t.id}).filter(function(){return Math.random()>.5}),n("c988"));function F(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,r)}return n}function U(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?F(n,!0).forEach(function(e){Object(P["a"])(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):F(n).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}r["a"].use(T["a"]);var W=new T["a"].Store({state:{objectsPre:[],buildingTypes:[],currentCategorySlug:"ZU",filterWidth:0,objectBlockWidth:0,isAuthorized:window.isAuthorized,isAccepted:window.isAccepted,user:window.user?window.user:{},favoritesOffsetLeft:"60%",imageFolders:{big:"/storage/images/big/",small:"/storage/images/small/"}},getters:{objects:function(t){return t.objectsPre.map(function(t){var e=Object.assign({},t);return e.cost=t.cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g," "),"GAP"in t&&(e.GAP=t.GAP.toString().replace(/\B(?=(\d{3})+(?!\d))/g," ")),"areaS"in t&&(e.areaS="".concat(e.areaS," м<sup>2</sup>")),"groundS"in t&&(e.groundS="".concat(e.groundS," Га")),e})},objectsForCurrentCategory:function(t,e){return e.objects.filter(function(e){return e.type===t.currentCategorySlug})}},mutations:{getAllInitData:function(t){k["b"].get("/objects").then(function(e){var n=Object.keys(e.data).map(function(t){var n=e.data[t],r=Object.assign(U({},n),n.characteristics);return delete r.characteristics,r});t.objectsPre=n}).catch(function(){return B["a"].warning("Обнаружены проблемы на сервере, обратитесь к разработчикам")}),t.buildingTypes=E},changeCurrentCategorySlug:function(t,e){t.currentCategorySlug=e},setFilterWidth:function(t,e){t.filterWidth=e},setObjectBlockWidth:function(t,e){t.objectBlockWidth=e},changeAuthState:function(t,e){var n=e.isAuthorized,r=e.user;t.isAuthorized=n,n&&(t.user=r)},changeSubscriptionStatus:function(t,e){t.user.subscribed=e},setFavoritesOffsetLeft:function(t,e){t.favoritesOffsetLeft="".concat(e,"px")},removeObject:function(t,e){t.objectsPre.some(function(n,r){return e===n.id&&(t.objectsPre.splice(r,1),!0)})}},actions:{getAllInitData:function(t){var e=t.commit;e("getAllInitData")}}});r["a"].use(D["a"]);var Z=new D["a"]({mode:"history",base:"/",routes:[{path:"*",redirect:"/"},{path:"/about",name:"about",component:function(){return n.e("about").then(n.bind(null,"f820"))}},{path:"/",name:"main",component:function(){return n.e("chunk-18beb0ee").then(n.bind(null,"cd56"))}},{path:"/lk",name:"lk",component:function(){return n.e("chunk-0fb7418a").then(n.bind(null,"bb31"))},redirect:{name:"lk-account"},children:[{path:"objects",name:"lk-objects",component:function(){return Promise.all([n.e("chunk-457db554"),n.e("chunk-c76aef02")]).then(n.bind(null,"8fff"))}},{path:"register",name:"lk-register",component:function(){return n.e("chunk-7da43ca4").then(n.bind(null,"ed70"))}},{path:"login",name:"lk-login",component:function(){return n.e("chunk-c393d520").then(n.bind(null,"21d5"))}},{path:"account",name:"lk-account",component:function(){return Promise.all([n.e("chunk-457db554"),n.e("chunk-41c3a02b")]).then(n.bind(null,"b961"))}},{path:"objects/:id",name:"lk-object",component:function(){return n.e("chunk-5d479cda").then(n.bind(null,"fecd"))}},{path:"users",name:"lk-users",component:function(){return n.e("chunk-ae008d94").then(n.bind(null,"8c82"))}}]}]});Z.beforeResolve(function(t,e,n){["lk-login","lk-register"].includes(t.name)&&W.state.isAuthorized?n({name:"lk-account"}):!["lk-users","lk-object","lk-objects"].includes(t.name)||W.state.isAccepted?!["lk-account"].includes(t.name)||W.state.isAuthorized?n():n({name:"lk-login"}):n({name:"lk-account"})});var R=Z;r["a"].config.productionTip=!1,new r["a"]({router:R,store:W,render:function(t){return t(A)}}).$mount("#app")},"5c0b":function(t,e,n){"use strict";var r=n("e332"),a=n.n(r);a.a},"6d8c":function(t,e,n){},be32:function(t,e,n){"use strict";var r=n("167a"),a=n.n(r);a.a},c988:function(t,e,n){"use strict";var r=n("854a"),a=n.n(r);a.a.options={closeButton:!0,debug:!1,newestOnTop:!1,progressBar:!1,positionClass:"toast-bottom-right",preventDuplicates:!0,onclick:null,showDuration:"300",hideDuration:"100",timeOut:3e3,extendedTimeOut:2e3,showEasing:"swing",hideEasing:"linear",showMethod:"slideDown",hideMethod:"slideUp",closeMethod:"fadeOut",tapToDismiss:!1},e["a"]=a.a},e332:function(t,e,n){},ed6b:function(t,e,n){"use strict";var r=n("6d8c"),a=n.n(r);a.a}});