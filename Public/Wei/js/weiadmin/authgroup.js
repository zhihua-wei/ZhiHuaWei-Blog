/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/19
 * Time: 上午 11:10
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power: authgroup.js
 * ==========================================
 */

$(function() {

	$(".children").click(function() {
		$(this).parent().parent().parent().find(".father").prop("checked", true);
	})
	$(".father").click(function() {
		if(this.checked) {
			$(this).parent().parent().parent().find(".children").prop("checked", true);
		} else {
			$(this).parent().parent().parent().find(".children").prop("checked", false);
		}
	})

});

//表单提交验证
var Script = function() {

	'use strict';

	$.validator.setDefaults({
		submitHandler: function(form) {
			form.submit();
		}
	});

	$().ready(function() {
		$("#authgroupaddForm").validate({
			rules: {
				title: {
					required: true,
				},
			},
			messages: {
				title: "角色名不能为空！",
			}
		});
	});

	$().ready(function() {
		$("#authgroupeditForm").validate({
			rules: {
				title: {
					required: true,
				},
			},
			messages: {
				title: "角色名不能为空！",
			}
		});
	});

}();