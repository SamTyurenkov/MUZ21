$=jQuery,$(document).ready((function(){$(".validateuseremail, .invalidateuseremail, .makeresident, .cancelresident").on("click",(function(e){e.preventDefault();var el=this,ajaxurl=localize_admin_author.ajaxurl,aid=localize_admin_author.aid;console.log(el.classList[1]);jQuery.ajax({type:"POST",url:ajaxurl,cache:!1,data:{aid:aid,action:el.classList[1]},success:function(data,textStatus,jqXHR){el.style.pointerEvents="none",ErrorsManager.createEl("success","Пользователь обновлен")},error:function(jqXHR,textStatus,errorThrown){el.style.pointerEvents="none",ErrorsManager.createEl("error","Ошибка: "+textStatus)}})}))}));