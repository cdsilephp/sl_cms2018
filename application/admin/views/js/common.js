$(function() {
	//下拉菜单
	$(".drop-tag").click(function(e) {
		e.stopPropagation();
		var droplist = $(this).siblings(".drop-list");
		$(".drop-list").not(droplist).hide();
		droplist.slideToggle();
	})

	$(document).click(function(e) {
		$(".drop-list").slideUp();
//		$(".side-nav.collapse .sub").hide();
		$(".side-collapse .sub").hide();
	})

	$(".side-nav").find(".nLi h3").click(function(e) {
		//		$(".side-nav-ul .nLi h3").removeClass("down");
		e.stopPropagation();
		var sub = $(this).siblings(".sub");
		var _this = $(this);
		if( $(this).find('a').attr("data-padding") == null)
		{
			return false;
		}
		
		$(this).toggleClass("on");
		if ($(this).parents(".side-nav").hasClass("side-collapse")) {
			
		} else {
		
		var padding_left=sub.find("li a").css('padding-left').replace("px","");
		
		if(sub.find("li a").attr("data-padding")==null)
		{
			sub.find("li a").attr("data-padding",padding_left);
			padding_left=Number(sub.find("li a").attr("data-padding"))+Number(20);
			sub.find("li a").css("padding-left",padding_left+"px");
		}else 
		{
			//alert(sub.parent().find("a").css('padding-left').replace("px",""));
			var padding_parent= sub.parent().find("a").css('padding-left').replace("px","");
			padding_left=Number(sub.find("li a").attr("data-padding"));
			sub.find("li a").css("padding-left",Number(padding_parent)+Number(20)+"px");
			//sub.find("li a").attr("data-padding",Number(padding_left)-Number(20));
		}
		
		
		sub.slideToggle(300) ;
		}

	});


	//控制侧边栏折叠
	$(".top-nav .ficon-menu").click(function(e) {
		e.stopPropagation();
		$(".side-nav").toggleClass("side-collapse");
		$("header").toggleClass("header-collapse");
		$(".body-content").toggleClass("content-collapse");

	})

	$(".app-ficon-menu").click(function() {
		$(".side-nav").toggleClass("app-side");
		$(".body-content").toggleClass("app-content");

	})

	
	
})


function setSideHei(){
	if($(window).width()>640){
		
		var hei = $(document).height() - $("header").height();
		var selfHei = $(".side-nav").height();
		var newHei = hei>selfHei?hei:selfHei;
		 $(".side-nav").css({"min-height":newHei,"_height":newHei});
//		 alert(newHei);
	}
}
	

$(window).load(function(){
	setSideHei();
})
$(window).resize(function(){
	setSideHei();
	if($(window).width()<=640){
		$(".side-nav").removeClass("side-collapse");
		$("header").removeClass("header-collapse");
		$(".body-content").removeClass("content-collapse");
	}
})

//进度条
function showProgressbar(div) {
	var showTag = div.attr("data-show");
	if (showTag == "hidden") {
		div.find(".progress").each(function() {
			var len = $(this).attr("data-width");
			$(this).animate({
				width: len + '%'
			}, 1000);
		})
		div.attr("data-show", "show");
	}

}

$(window).load(function() {
	var tag = $(".progressbar_container");
	var targetTop;

	function jadgeshow() {
		tag.each(function(i) {
			targetTop = $(this).offset().top - $(window).height();
			if ($(document).scrollTop() > targetTop) {

				showProgressbar($(this));
			}
		})
	}
	jadgeshow();
	$(window).scroll(function() {
		jadgeshow();
	})
	
	//加载内容管理==》aside侧栏
	var col_id=$.cookie('col_id');
	if(col_id == null)
		{
		getAsideList('8');
		}
	else
		{
		getAsideList(col_id);
		}
	
})

//进度条 end


//模拟select
;(function($){  
  
    jQuery.fn.select = function(options){  
        return this.each(function(){  
            var $this = $(this);  
            var $shows = $this.find(".shows");  
            var $selectOption = $this.find(".selectOption");  
            var $el = $this.find("ul > li");  
                                      
            $this.click(function(e){  
                $(this).toggleClass("zIndex");  
                $(this).children("ul").toggleClass("dis");  
                e.stopPropagation();  
            });  
              
            $el.bind("click",function(){  
                var $this_ = $(this);  
                   
                $this.find("span").removeClass("gray");  
                $this_.parent().parent().find(".selectOption").text($this_.text());  
            });  
              
            $("body").bind("click",function(){  
                $this.removeClass("zIndex");  
                $this.find("ul").removeClass("dis");      
            })  
              
        //eahc End    
        });  
          
    }  
      
})(jQuery);

$(function(){
	$(".select-container").select();  
})

//模拟select end



//控制css
$(function(){
	$(".table-hover tbody tr").hover(function(){
		$(this).addClass("bgcolor");
	},function(){
		$(this).removeClass("bgcolor");
	});
	
	
	$(".add-input").click(function(e){
		e.stopPropagation();
		var par = $(this).parents("tr");
		//par.addClass("on").siblings("tr").removeClass("on");
	})
	$(document).click(function(){
		$(".add-table tr").removeClass("on");
	})
})



//回车输入关键词

$(function(){
	$(".enterwords-box").each(function(){
		var box = $(this);
		var enterinput = box.find(".enterinput").eq(0);
		box.click(function(e){
			e.stopPropagation();
			box.addClass("on");
			enterinput.focus();
		});
		$(document).click(function(){
			box.removeClass("on");
		});
		
		var wordValue='';
		var oldlen = 0;
		enterinput.keyup(function(event){
			 wordValue = $.trim(enterinput.val());
			 if(event.keyCode!=8){
			 	 oldlen = wordValue.length;
			 }
			if(event.keyCode==13){ 
				if(wordValue.length>40){
					alert("请输入内容小于20个字");
				}else if(wordValue.length>0){
					enterinput.before("<span class=\"wordspan\"><em class=\"word\">"+ wordValue +"</em><em class=\"remove ficon ficon-cancel\"></em></span>").val('');
				}
   	   		} 
   	   		if(event.keyCode==8){
   	   			if(oldlen>-1){
   	   				oldlen = oldlen -1;
   	   			}
   	   			if(oldlen==-1){
   	   			enterinput.prev(".wordspan").remove();
   	   			}
   	   		}
		});
		
		
	})
	
	$(".enterwords-box").on("click",".wordspan .remove",function(e){
		e.stopPropagation();
		$(this).parents(".wordspan").remove();
	})


})


function getAsideList(col_id) {
	$.cookie('col_id', col_id);
	var id = $.cookie('col_id');
	$(".lanmu_aside").hide();
	$("#index_aside").show();
	$("#" + id).show();
    //$("#"+id).find("h3").siblings(".sub").slideToggle(300);

	$("#"+id).find("h3").each(function () {
    	
    	var sub = $(this).siblings(".sub");
    	var _this = $(this);
    	$(this).toggleClass("on");
    	if ($(this).parents(".side-nav").hasClass("side-collapse")) {
    		
    	} else {
    	
    	var padding_left=sub.find("li a").css('padding-left').replace("px","");
    	
    	if(sub.find("li a").attr("data-padding")==null)
    	{
    		sub.find("li a").attr("data-padding",padding_left);
    		padding_left=Number(sub.find("li a").attr("data-padding"))+Number(20);
    		sub.find("li a").css("padding-left",padding_left+"px");
    	}else 
    	{
    		//alert(sub.parent().find("a").css('padding-left').replace("px",""));
    		var padding_parent= sub.parent().find("a").css('padding-left').replace("px","");
    		padding_left=Number(sub.find("li a").attr("data-padding"));
    		sub.find("li a").css("padding-left",Number(padding_parent)+Number(20)+"px");
    		//sub.find("li a").attr("data-padding",Number(padding_left)-Number(20));
    	}
    	
    	
    	sub.show();
    	}
    });
    
    
    
}

function selcheck(id) {
    var e = document.getElementById(id);
    var objs = e.getElementsByTagName("input");
    if (e.checked) {
        e.checked = false;
        for (var i = 0; i < objs.length; i++) {
            if (objs[i].type.toLowerCase() == "checkbox")
                objs[i].checked = false;
        }
    } else {
        e.checked = true;
        for (var i = 0; i < objs.length; i++) {
            if (objs[i].type.toLowerCase() == "checkbox")
                objs[i].checked = true;
        }
    }
}





function chk1(url)
{
	if(confirm('确定执行当前操作吗?')==false)return false;
    var boxes = document.getElementsByName("chk"); 
    var t2=0;
    var t1="";
    for (var i = 0; i < boxes.length; i++)   
    {
     if (boxes[i].checked)   
     {
        t2=t2+1;
        if(t2==1)
        {
        t1=t1+boxes[i].value;
        }
        else
        {
        t1=t1+","+boxes[i].value;
        }
     }
    }
    if(t1=="")
    	{
    	alert("请至少选择一项");
    	window.event.returnValue = false;
    	}
    window.location=url+"&id="+t1;
window.event.returnValue = false;
}

//在新标签页打开
function chk2(url)
{
	if(confirm('确定执行当前操作吗?')==false)return false;
    var boxes = document.getElementsByName("chk"); 
    var t2=0;
    var t1="";
    for (var i = 0; i < boxes.length; i++)   
    {
     if (boxes[i].checked)   
     {
        t2=t2+1;
        if(t2==1)
        {
        t1=t1+boxes[i].value;
        }
        else
        {
        t1=t1+","+boxes[i].value;
        }
     }
    }
    if(t1=="")
    	{
    	alert("请至少选择一项");
    	window.event.returnValue = false;
    	}
    console.log(url+"&id="+t1);
    window.open(url+"&id="+t1);
//    window.location=url+"&id="+t1;
//    window.event.returnValue = false;
}

//联动控件改变选中项
function change(val,divid,filedName)
{
	var htmlobj=$.ajax({url:"/?p=admin&a=api&type=getLiandongHtml&classid="+val+"&filedName="+filedName,async:false});
	var htmlstr=htmlobj.responseText;
	
	$("#"+filedName).val(val);
	if(htmlstr!="")
	{
		console.log("#"+divid+":        "+htmlstr);
		$("#"+divid).append(htmlstr);
	}
}

