$(document).ready(function() { //开始
if($('input#author[value]').length>0){ //判断用户框是否有值
$("#author_info").css('display','none'); //将id为author_info的对象的display属性设为none，即隐藏
var change='<span id="show_author_info" style="cursor: pointer; color:#2970A6;">更改用户 &raquo;</span>'; //定义change，style是定义CSS样式，让他有超链接的效果，color要根据你自己的来改，当然你也可以在CSS中定义#show_author_info来实现，这样是为了不用再去修改style.css而已！
var close='<span id="hide_author_info" style="cursor: pointer;color: #2970A6;">关闭更改 &raquo;</span>'; //定义close
$('#welcome').append(change); //在ID为welcome的对象里添加刚刚定义的change
$('#welcome').append(close); // 添加close
$('#hide_author_info').css('display','none'); //隐藏close
$('#show_author_info').click(function() { //鼠标点击change时发生的事件
$('#author_info').slideDown('slow'); //用户输入框向下滑出
$('#show_author_info').css('display','none'); //隐藏change
$('#hide_author_info').css('display','inline'); //显示close
$('#hide_author_info').click(function() { // 鼠标点击close时发生的事件
$('#author_info').slideUp('slow'); //用户输入框向上滑
$('#hide_author_info').css('display','none'); //隐藏close
$('#show_author_info').css('display','inline'); })})}}) //显示change