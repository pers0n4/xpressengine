!function(e){function t(a){if(n[a])return n[a].exports;var l=n[a]={i:a,l:!1,exports:{}};return e[a].call(l.exports,l,l.exports,t),l.l=!0,l.exports}var n={};t.m=e,t.c=n,t.d=function(e,n,a){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:a})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=139)}({139:function(e,t,n){"use strict";var a=function(){var e,t=$(),n=[],a="",l="",i={},s=function(){t.on("click",".btnDeleteEmail",function(e){e.preventDefault(),$(this).css({display:"none"}).siblings().css({display:"inline-block"})}),t.on("click",".btnDeleteEmailConfirm",function(t){t.preventDefault();var n=$(this),a=n.closest("li.list-group-item").find("[name=email]").val();e.delete(a)}),t.on("click",".btnDeleteEmailCancle",function(e){e.preventDefault(),$(this).siblings().andSelf().css({display:"none"}).parent().find(".btnDelete").css({display:"inline-block"})}),t.on("click","#__xe_emailAddBtn",function(){var t=$("#__xe_addedEmailInput"),n=t.val();n&&(t.val(""),e.add(n))}),t.on("change","[name=email]",function(e){var t=$(this),n=t.closest("li.list-group-item"),a=n.closest("ul");n.siblings().each(function(){var e=$(this);if(!e.find("> span.pull-right").length){var t='<span class="pull-right">';t+='<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>',t+='<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>',t+='<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>',t+="</span>",e.append(t)}}),n.find("> span.pull-right").length>0&&n.find("> span.pull-right").remove(),a.prepend(n.detach())})};return{init:function(n){return e=this,t=n.$wrapper,a=n.email,l=n.userId,i=n.url,s(),e.getEmailList(),this},getEmailList:function(){$.ajax({url:i.mail.list,type:"get",dataType:"json",data:{userId:l},context:this,success:function(t){n=t.mails,e.render(t.mails)},error:function(e){XE.toast("danger","오류!.",".__xe_alertEmailModal")}})},delete:function(t){$.ajax({url:i.mail.delete,type:"post",dataType:"json",data:{userId:l,address:t},context:this,success:function(a){var l=n.indexOf(t);n.splice(l,1),e.render(n),XE.toast("success","삭제하였습니다.",".__xe_alertEmailModal")},error:function(e){XE.toast("danger",e.responseJSON.message,".__xe_alertEmailModal")}})},add:function(t){$.ajax({url:i.mail.add,type:"post",dataType:"json",data:{userId:l,address:t},context:this,success:function(t){var a=t.mail;n.push(a),e.render(n),XE.toast("success","추가되었습니다.",".__xe_alertEmailModal")},error:function(e){XE.toast("danger",e.responseJSON.message,".__xe_alertEmailModal")}})},render:function(e){var n="";n+="<div>",e.length>0&&(n+='<ul class="list-group">',e.forEach(function(e,t){var l=e.address,i=l===a?'checked="checked"':"";n+='<li class="list-group-item clearfix">',n+='<label><input type="radio" name="email" value="'+l+'" '+i+"/> "+l+"</label>",e.address!==a&&(n+='<span class="pull-right">',n+='<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>',n+='<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>',n+='<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>',n+="</span>"),n+="</li>"}),n+="</ul>"),n+='<div class="input-group input-group-sm" style="margin-bottom: 20px;">',n+='<input type="text" class="form-control" id="__xe_addedEmailInput" placeholder="이메일을 입력하세요">',n+='<span class="input-group-btn"><buttion id="__xe_emailAddBtn" class="btn btn-default" type="button">추가</buttion></span>',n+="</div>",t.html(n)}}}();$(function(){$(".__xe_settingEmail").click(function(){$(".__xe_emailView").slideToggle(),$("#__xe_emailSetting").slideToggle()}),a.init({$wrapper:$("#__xe_emailSetting"),url:url,userId:$("#__xe_emailSetting").data("user-id"),email:$("#__xe_emailSetting").data("email")})})}});