/**

 @Name：layuiAdmin 公共业务
 @Author：贤心
 @Site：http://www.cdsile.com/admin/
 @License：LPPL
    
 */

layui.define(function(exports) {
	var $ = layui.$,
		layer = layui.layer,
		laytpl = layui.laytpl,
		setter = layui.setter,
		view = layui.view,
		admin = layui.admin

	//公共业务的逻辑处理可以写在此处，切换任何页面都会执行
	//……
	layOpen = function(title = "信息", content = "/admin/index/index", area_x = "500px", area_y = "500px") {
		layer.open({
			type: 2,
			title: title,
			shade: false,
			maxmin: true,
			area: [area_x, area_y],
			content: content
		});

	};

	newTab = function(tit, url) {
		if(top.layui.index) {
			top.layui.index.openTabsPage(url, tit)
		} else {
			window.open(url)
		}
	}

	myAjax = function(url, type = "get", data = "") {
		$.ajax({          
			url: url,
			          type: type,
			          data: data,
			          dataType: 'JSON',
			          success: function(data) {            
				if(data.status) {              

					        
					var index = parent.layer.getFrameIndex(window.name);              
					parent.layer.msg(data.msg, {
						icon: 6
					}); //添加成功后提示
					              
					parent.layer.close(index); //关闭弹层的窗口
					              
					location.reload() //刷父界面
					            
				} else {              
					parent.layer.msg(data.msg, {
						icon: 5,
						time: 1000
					});            
				}          
			}
		})

	}
	
	
	//更新商品的价格
	refresh_goods_price  = function(goods_number = "") {
		layer.confirm('重现生成价格会清空原来的价格记录，且不可恢复，确认重新生成？', function(index) {
			$.ajax({          
				  url: "/admin/inc/refreshgoodspricelist",
		          type: "get",
		          data: "goods_number="+goods_number,
		          dataType: 'JSON',
	          success: function(data) {            
				if(data.status) {              
					parent.layer.msg(data.msg, {
						icon: 6
					}); //添加成功后提示
					            
					location.reload() //刷父界面
					            
				} else {              
					parent.layer.msg(data.msg, {
						icon: 5,
						time: 1000
					});            
				}          
			}
			})
		});
		
		
		
	}
	
	
	//退出
	admin.events.logout = function() {
		//执行退出接口
		layer.confirm('确定退出吗？', function(index) {
			location.href = '/admin/login/logout';
		});

	};

	//对外暴露的接口
	exports('common', {});
});