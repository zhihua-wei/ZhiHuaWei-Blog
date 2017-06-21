/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/19
 * Time: 上午 10:02
 * Project: Weiadmin后台管理系统
 * Version: 1.0.0
 * Power: setting.js
 * ==========================================
 */

//表单提交验证
var Script = function() {

	'use strict';

	$.validator.setDefaults({
		submitHandler: function(form) {
			form.submit();
		}
	});
	$().ready(function() {
		$("#settingForm").validate({
			rules: {
				title: {
					required: true,
				},
				sitename: {
					required: true,
				},
				footer: {
					required: true,
				},
			},
			messages: {
				title: "请输入网站标题！",
				sitename: "请输入网站SEO标题！",
				footer: "请输入版权信息！",
			}
		});

	});
	
	$().ready(function() {
		$("#menuForm").validate({
			rules: {
				title: {
					required: true,
				},
				name: {
					required: true,
				},
			},
			messages: {
				title: "菜单名称不能为空！",
				name: "访问路径不能为空！",
			}
		});
	});
}();