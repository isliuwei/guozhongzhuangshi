var oUl = document.getElementById('nav');
var aLi = oUl.getElementsByTagName('li'); 
var oContainer = document.getElementById('container');
var aUl = oContainer.getElementsByTagName('ul');
for(var i=0;i<aLi.length;i++){
	aLi[i].index = i; 
	aLi[i].onclick = function(){

		for(var i =0;i<aLi.length;i++){
			aLi[i].className = '';
			aUl[i].className = 'item'; 
		}
		this.className = 'selected';
		aUl[this.index].className= 'item selected';
	};
}