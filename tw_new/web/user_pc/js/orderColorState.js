// JavaScript Document
	var colors=['#cb51f8','#d3bd50','#22beef','#ffc100','#aec785'];
	var theTable = document.getElementById("order-tab");
    var oTbody=theTable.getElementsByTagName('tbody');

		for (var i=0;i<oTbody.length;i++) {
  			$('.Color-dots').eq(i).css('backgroundColor',colors[i%5]);
		}
	