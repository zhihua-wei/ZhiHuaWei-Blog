/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/19
 * Time: 下午 3:08
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power: background.js
 * ==========================================
 */

//表单提交验证
var Script = function () {

    'use strict';

    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        $("#background_addForm").validate({
            rules: {
                background_name: {
                    required: true,
                },
                background_desc: {
                    required: true,
                },
                background_pic: {
                    required: true,
                }
            },

            messages: {
                background_name: "请输入背景图名称",
                background_desc: "请输入背景图描述",
                background_pic: "请选择上传背景图"
            }
        });

        $("#background_editForm").validate({
            rules: {
                background_name: {
                    required: true
                },
                background_desc: {
                    required: true
                }
            },

            messages: {
                background_name: "请输入背景图名称",
                background_desc: "请输入背景图描述"
            }
        });
    });

}();
