// JavaScript Document
     var theTable = document.getElementById("table_bg");
	 var aSpan=theTable.getElementsByTagName('span');
     var totalPage = document.getElementById("spanTotalPage");
     var pageNum = document.getElementById("spanPageNum");


     var spanPre = document.getElementById("spanPre");
     var spanNext = document.getElementById("spanNext");
	 var pageInp= document.getElementById("TurnInp");
	 
	 var numberRowsInTable = theTable.rows.length;
     var pageSize = 8;
     var page = 1;
	 
     //下一页
     function next() {
         hideTable();
         currentRow = pageSize * page;
         maxRow = currentRow + pageSize;
         if (maxRow > numberRowsInTable) maxRow = numberRowsInTable;
         for (var i = currentRow; i < maxRow; i++) {
             theTable.rows[i].style.display = '';
         }
         page++;
         if (maxRow == numberRowsInTable) { nextText();}
         showPage();
         preLink();
     }
	 

     //上一页
     function pre() {
         hideTable();
         page--;
         currentRow = pageSize * page;
         maxRow = currentRow - pageSize;
         for (var i = maxRow; i < currentRow; i++) {
             theTable.rows[i].style.display = '';
         }
         if (maxRow == 0) { preText();}
         showPage();
         nextLink();
     }

    //第一页
     function first() {
         hideTable();
         page = 1;
         for (var i = 0; i < pageSize; i++) {
             theTable.rows[i].style.display = '';
         }
         showPage();
  	     firstBg();
         preText();
         nextLink();
     }
	 
	 
     //页面跳转
	 function Num() {
		 hideTable();
		 page=pageInp.value;
		 currentRow = pageSize * page;
		 maxRow = currentRow - pageSize;
		 if ( currentRow > numberRowsInTable) currentRow=numberRowsInTable;
		 for (var i=maxRow;i<currentRow;i++) {
			 theTable.rows[i].style.display = '';
			 }
		 maxRow==0?preText():preLink();
		 currentRow==numberRowsInTable?nextText():nextLink();
		 }


     function hideTable() {
         for (var i = 0; i < numberRowsInTable; i++) {
             theTable.rows[i].style.display = 'none';
         }
     }


     function showPage() {
         pageNum.innerHTML = page;
     }	 
	 
	 
	 //总共页数
     function pageCount() {
         var count = 0;
         if (numberRowsInTable % pageSize != 0) count = 1;
         return parseInt(numberRowsInTable / pageSize) + count;
     }

     //第一页背景
	 function firstBg () { aSpan[1].style.background='#cdd8dc'; }
     //显示链接
     function preLink() { spanPre.innerHTML = "<a href='javascript:pre();'>上一页</a>"; }
     function preText() { spanPre.innerHTML = "上一页"; }


     function nextLink() { spanNext.innerHTML = "<a href='javascript:next();'>下一页</a>"; }
     function nextText() { spanNext.innerHTML = "下一页"; }


     //隐藏表格
     function hide() {
         for (var i = pageSize; i < numberRowsInTable; i++) {
             theTable.rows[i].style.display = 'none';
         }
         totalPage.innerHTML = pageCount();
         pageNum.innerHTML = '1';
         nextLink();
     }
     hide();