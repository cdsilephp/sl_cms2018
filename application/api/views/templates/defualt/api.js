
var baseurl = "http://cms";
// var baseurl = window.location.protocol + '//' + window.location.host;//获取当前站点地址

/*
 *获取cookie
 */
function getCookie(name) {
	var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
	var temp = localStorage.getItem(name);

	if (temp == null || temp == "") {
		return '';
	}

	if (arr = temp.match(reg)) {

		return unescape(arr[2]);
	}
	else {
		return null;
	}
}

/*
 *将Token写入cookie
 */
function setToken(name, value) {
	var Mints = 10;
	var exp = new Date();
	exp.setTime(exp.getTime() + Mints * 60 * 1000);
	localStorage.setItem(name, name + "=" + escape(value) + ";expires=" + exp.toGMTString());
}

/*
 *获取url中所有的参数并且排序,经过md5加密后生成签名
 */

function getUrlSign_nomd5(url) {
	var vars = '',
		hash;
	url = (url + '&token=' + getToken()).toLowerCase();

	var hashes = url.slice(url.indexOf('?') + 1).split('&');
	hashes.sort();

	for (var i = 0; i < hashes.length; i++) {
		if (hashes[i].indexOf('token=') != -1) { //token经过加密，可能存在“=”，需要单独处理
			vars += "token" + hashes[i].split("token=")[1];
		} else {
			hash = hashes[i].split('=');
			vars += hash[0] + hash[1];
		}

	}
	return vars;
}

function getUrlSign(url) {

	var vars = getUrlSign_nomd5(url);
	console.log(vars);
	return $.md5(vars).toUpperCase();

}



/*
 * 获取、存储token，并且10分钟刷新一次
 */

function getToken() {

	var token = '';

	if (getCookie('token')) {

		token = getCookie('token');

	} else {

		var url = baseurl + '/api/index/gettoken';
		$.ajax({
			type: "get",
			dataType: "json",
			url: url,
			async: false,
			success: function (value) {
				console.log(value.code);
				if (value.code == '0') {
					setToken('token', value.data);
					token = value.data;
				} else {
					
					localStorage.removeItem('token');
					getToken();
					// console.log('获取token失败');
				}
			},
			error: function () {
				console.log('获取token失败');
			}
		});



	}
	return token;

}

setInterval(getToken(), 60*60*10);
