(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-6d2b98f5"],{"21aa":function(t,e,s){"use strict";var n=s("4edd"),a=s.n(n);a.a},"4edd":function(t,e,s){},"5a9e":function(t,e,s){},"7c02":function(t,e,s){"use strict";var n=s("5a9e"),a=s.n(n);a.a},"8c82":function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"mt-5 users-block",class:{"d-none":!t.objectBlockWidth},style:{paddingLeft:t.objectBlockWidth+"px"}},[s("back-button"),s("h5",{staticClass:"text-primary mb-5"},[t._v("Пользователи")]),s("div",{staticClass:"row pb-5"},[s("div",{staticClass:"col"},[t.users.length?s("table",{staticClass:"table table-hover m-0 sticky-thead"},[t._m(0),s("tbody",t._l(t.users,function(e,n){return s("tr",{key:e.id,staticClass:"bg-white"},[s("td",[t._v(t._s(n+1))]),s("td",[t._v(t._s(e.name))]),s("td",[t._v(t._s(e.company))]),s("td",[t._v(t._s(e.tel))]),s("td",[t._v(t._s(e.email))]),s("td",{staticClass:"text-center"},[e.deleted_at?t._e():s("select",{staticClass:"text-lowercase custom-select w-auto pb-0 pt-0",on:{change:function(s){return t.setRole(e.id,n,s)}}},[e.role?t._e():s("option",{attrs:{value:""},domProps:{selected:!e.role}},[t._v("Не установлено")]),s("option",{attrs:{value:"admin"},domProps:{selected:"admin"===e.role}},[t._v(t._s(t.roles["admin"]))]),s("option",{attrs:{value:"manager"},domProps:{selected:"manager"===e.role}},[t._v(t._s(t.roles["manager"]))]),s("option",{attrs:{value:"partner"},domProps:{selected:"partner"===e.role}},[t._v(t._s(t.roles["partner"]))])])]),e.deleted_at?s("td",{staticClass:"text-center"},[s("button",{staticClass:"btn btn-sm btn-outline-primary",on:{click:function(s){return t.restoreUser(e,n)}}},[t._v("восстановить")])]):s("td",{staticClass:"text-center"},[s("button",{staticClass:"btn btn-sm btn-outline-danger",on:{click:function(s){return t.deleteUser(e,n)}}},[t._v("удалить")])])])}),0)]):t._e()])])],1)},a=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",{staticClass:"thead-light"},[s("tr",[s("th",{attrs:{scope:"col"}},[t._v("#")]),s("th",{attrs:{scope:"col"}},[t._v("ФИО")]),s("th",{attrs:{scope:"col"}},[t._v("Компания")]),s("th",{attrs:{scope:"col"}},[t._v("Телефон")]),s("th",{attrs:{scope:"col"}},[t._v("Email")]),s("th",{staticClass:"text-center",attrs:{scope:"col"}},[t._v("Доступ")]),s("th",{attrs:{scope:"col"}})])])}],r=s("c988"),c=s("25be"),o=s("d3c7");r["a"].options.preventDuplicates=!1;var i={name:"LKUsers",components:{BackButton:o["a"]},data:function(){return{users:[]}},computed:{objectBlockWidth:function(){return this.$store.state.objectBlockWidth},roles:function(){return this.$store.getters["lk/roles"]}},created:function(){var t=this;c["b"].get("/users").then(function(e){t.users=e.data}).catch(function(){return r["a"].warning("Что-то пошло не так, попробуйте позднее")})},methods:{setRole:function(t,e,s){var n=this,a=s.target.value;c["b"].post("/users/".concat(t),null,{params:{_method:"PUT",role:a}}).then(function(){n.users[e].role=a,r["a"].success("Роль пользователя успешно изменена")}).catch(function(){return r["a"].warning("Что-то пошло не так, попробуйте позднее")})},deleteUser:function(t,e){var s=this;c["b"].post("/users/".concat(t.id),null,{params:{_method:"DELETE"}}).then(function(){s.users[e].deleted_at=!0,r["a"].success("Пользователь удален")}).catch(function(){return r["a"].warning("Что-то пошло не так, попробуйте позднее")})},restoreUser:function(t,e){var s=this;c["b"].post("/users/".concat(t.id,"/restore")).then(function(){s.users[e].deleted_at=null,r["a"].success("Пользователь восстановлен")}).catch(function(){return r["a"].warning("Что-то пошло не так, попробуйте позднее")})}}},l=i,u=(s("21aa"),s("2877")),d=Object(u["a"])(l,n,a,!1,null,null,null);e["default"]=d.exports},d3c7:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{class:t.isMobileDevice?"back-button-relative":"back-button-absolute"},[s("router-link",{staticClass:"btn btn-outline-dark border-0",class:[t.isMobileDevice?"mb-4":"ml-5"],attrs:{to:{name:t.currentCategorySlug}}},[s("i",{staticClass:"fa fa-reply",attrs:{"aria-hidden":"true"}}),t._v("\n      Вернуться в каталог\n    ")])],1)},a=[],r={name:"BackButton",computed:{currentCategorySlug:function(){return this.$store.state.currentCategorySlug},isMobileDevice:function(){return this.$store.getters.isMobileDevice}}},c=r,o=(s("7c02"),s("2877")),i=Object(o["a"])(c,n,a,!1,null,null,null);e["a"]=i.exports}}]);