// JavaScript Document
	var colors=['#cb51f8','#d3bd50','#22beef','#ffc100','#aec785'];
	var oTable=document.getElementById('table_bg');
	var oTr=oTable.getElementsByTagName('tr');
	var oTda=[];
	var oTdb=[];
	for (var i=0;i<oTr.length;i++) {
		oTda[i]=oTr[i].getElementsByTagName('td')[1].getElementsByTagName('div')[0];
		oTdb[i]=oTr[i].getElementsByTagName('td')[6].getElementsByTagName('div')[0].getElementsByTagName('div')[0];
		oTda[i].style.backgroundColor=colors[i%5];
		oTdb[i].style.backgroundColor=colors[i%5];
	}
	