!function(t){function e(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,e),o.l=!0,o.exports}var n={};e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=32)}({0:function(t,e,n){t.exports=n(2)(430)},1:function(t,e){t.exports=_xe_bundle_common},2:function(t,e){t.exports=_xe_bundle_vendor},3:function(t,e,n){t.exports=n(1)(555)},32:function(t,e,n){t.exports=n(33)},33:function(t,e,n){"use strict";function r(t){return t&&t.__esModule?t:{default:t}}var o=n(0),a=r(o),u=n(34),f=r(u),c=n(3),i=r(c);window.jQuery("#btnCreateCategory").on("click",function(t){var e=t.target,n=(0,a.default)(e).closest("form").find('[name="id"]').val(),r={};if(!n)return void f.default.form((0,a.default)(e),"You must first create a category ID.");f.default.form.fn.clear((0,a.default)(e).closest("form")),r.categoryName=n,i.default.post("fieldType.storeCategory",r).then(function(t){var n=(0,a.default)(e).closest(".__xe_df_category");n.find('[name="category_id"]').val(t.data.id),n.find("button").hide(),n.append((0,a.default)("<a>").text(i.default.Lang.trans("xe::categoryManagement")).prop("target","_blank").prop("href","/settings/category/"+t.data.id))})})},34:function(t,e,n){t.exports=n(1)(77)}});