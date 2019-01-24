window.onscroll=function() {
	if($(window).scrollTop() >= 0 && $(window).scrollTop() < 700 ){
		var abc = $(window).scrollTop()+'px';
		$('.content_m_r').css('margin-top', abc);
	}
};
