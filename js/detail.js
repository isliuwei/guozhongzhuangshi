$(function(){
var oUl = document.getElementById('pro-model');
var aLi = oUl.getElementsByTagName('li');





for(var i=0;i<aLi.length;i++){
	aLi[i].onclick = function(){

		$('.detail-item').html($(this).children().html());
	};
}






});