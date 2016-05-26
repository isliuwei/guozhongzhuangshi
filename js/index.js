$(function(){


	var $carouselImg = $('.carousel-img img');
	var $carouselLi = $('.carousel-num li');
	 





		var index = 0;
		function play(){
			timer = setInterval(function(){
				$carouselLi.eq(index).addClass('active').siblings('li').removeClass('active');
				$carouselImg.eq(index).addClass('active').siblings('img').removeClass('active');
				//$carouselImg.eq(index).fadeIn(3000).siblings('img').hide();
				index++;
				if(index == 3){
					index=0;
				}
			},5000);

		}
		play();








	
});
