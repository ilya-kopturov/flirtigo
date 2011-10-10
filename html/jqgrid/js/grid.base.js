;(function ($) {
/*
 * jqGrid  3.1 - jQuery Grid
 * Copyright (c) 2008, Tony Tomov, tony@trirand.com
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * Date: 2008-04-07 rev 33
 */
$.jgrid = $.jgrid || {};
$.jgrid.defaults = {
	recordtext: "Rows",
	loadtext: "Loading..."
};

$.fn.jqGrid = function( p ) {
	p = $.extend({
	url: '',
	height: 150,
	page: 1,
	rowNum: 20,
	records: 0,
	pager: "",
	colModel: [],
	rowList: [],
	colNames: [],
	sortorder: "asc",
	sortname: "",
	datatype: "xml",
	mtype: "GET",
	imgpath: "",
	sortascimg: "sort_asc.gif",
	sortdescimg: "sort_desc.gif",
	firstimg: "first.gif",
	previmg: "prev.gif",
	nextimg: "next.gif",
	lastimg: "last.gif",
	altRows: true,
	selarrrow: [],
	savedRow: [],
	shrinkToFit: true,
	xmlReader: {},
	jsonReader: {},
	subGrid: false,
	subGridModel :[],
	lastpage: 0,
	lastsort: 0,
	selrow: null,
	onSelectRow: null,
	onSortCol: null,
	ondblClickRow: null,
	onRightClickRow: null,
	onPaging: null,
	loadComplete: null,
	viewrecords: false,
	loadonce: false,
	multiselect: false,
	multikey: null,
	rowheight: null,
	editurl: null,
	search: false,
	searchdata: {},
	caption: "",
	hidegrid: true,
	postData: {},
	userData: {},
	toolbar: [false,"top"]
	}, $.jgrid.defaults, p || {});
	var grid={
		headers:[],
		cols:[],
		dragStart: function(i,x) {
			this.resizing = { idx: i, startX: x};
			this.hDiv.style.cursor = "e-resize";
		},
		dragMove: function(x) {
			if(this.resizing) {
				var diff = x-this.resizing.startX;
				var h = this.headers[this.resizing.idx];
				var newWidth = h.width + diff;
				if(newWidth > 30) {
					h.el.style.width = newWidth+"px";
					h.newWidth = newWidth;
					this.cols[this.resizing.idx].style.width = newWidth+"px";
					this.newWidth = this.width+diff;
					$('table',this.bDiv).css("width",this.newWidth + "px");
					this.hTable.style.width = this.newWidth + "px";
					var scrLeft = this.bDiv.scrollLeft;
					this.hDiv.scrollLeft = this.bDiv.scrollLeft;
					if($.browser.msie) {
						if(scrLeft - this.hDiv.scrollLeft >= 5) this.bDiv.scrollLeft = this.bDiv.scrollLeft - 17;
					}
				}
			}
		},
		dragEnd: function() {
			this.hDiv.style.cursor = "default";
			if(this.resizing) {
				var idx = this.resizing.idx;
				this.headers[idx].width = this.headers[idx].newWidth;
				this.cols[idx].style.width = this.headers[idx].newWidth;
				this.width = this.newWidth;
				this.resizing = false;
			}
		},
		scrollGrid: function() {
			return;
			var scrollLeft = this.bDiv.scrollLeft;
			this.hDiv.scrollLeft = this.bDiv.scrollLeft;
			if(scrollLeft - this.hDiv.scrollLeft > 5) this.bDiv.scrollLeft = this.bDiv.scrollLeft - 17;
		}
	};
	$.fn.getGridParam = function(pName) {
		var $t = this[0];
		if (!$t.grid) return;
		var retval = null;
		if (!pName) { retval = $t.p }
		else {retval = ($t.p[pName]) ? $t.p[pName] : null;}
		return retval;
	};
	$.fn.setGridParam = function (newParams){
		return this.each(function(){
			if (this.grid && typeof(newParams) === 'object') $.extend(this.p,newParams);
		});
	};
// WILL BE REMOVED IN NEXT RELEASE
	$.fn.getUrl = function() {return this[0].p.url;};
	$.fn.getSortName = function() {return this[0].p.sortname;};
	$.fn.getSortOrder = function() {return this[0].p.sortorder;};
	$.fn.getSelectedRow = function() {return this[0].p.selrow};
	$.fn.getPage = function() {return parseInt(this[0].p.page);};
	$.fn.getRowNum = function() {return parseInt(this[0].p.rowNum);};
	$.fn.getMultiRow = function () {return this[0].p.selarrrow;};
	$.fn.getDataType = function () {return this[0].p.datatype;};
	$.fn.getRecords = function () {return parseInt(this[0].p.records);};
	$.fn.setSortOrder = function (neword) { return this.each( function(){this.p.sortorder=neword; });};
	$.fn.setPage = function (newpage) { return this.each( function() {
		if( typeof newpage === 'number' && newpage > 0) {this.p.page=newpage;}
		});
	};
	$.fn.setRowNum = function (newrownum) {
		return this.each(function(){if( typeof newrownum === 'number' && newrownum > 0) {this.p.rowNum=newrownum;} });
	};
	$.fn.setDataType = function(newtype) { return this.each( function(){this.p.datatype=newtype; });}
	$.fn.setUrl = function (newurl) { return this.each( function(){this.p.url=newurl;}); };
// END OF REMOVING
	$.fn.getDataIDs = function () {
		var ids=[];
		this.each(function(){
			$("tr:gt(0)",this.grid.bDiv).each(function(i){
				ids[i]=this.id;
			});
		});
		return ids;
	};
	$.fn.setSortName = function (newsort) {
		return this.each(function(){
			var $t = this;
			for(var i=0;i< $t.p.colModel.length;i++){
				if($t.p.colModel[i].name==newsort || $t.p.colModel[i].index==newsort){
					$("tr th:eq("+$t.p.lastsort+") div img",$t.grid.hDiv).remove();
					$t.p.lastsort = i;
					$t.p.sortname=newsort;
					$t.p.msort = true;
					break;
				}
			};
		});
	};
	$.fn.setSelection = function(selection)	{
		return this.each(function(){
			var t = this, stat;
			var pt = $("tbody tr#"+selection,t.grid.bDiv);
			if (!pt.html()) return;
			if(!t.p.multiselect) {
				if( t.p.selrow ) $("tbody tr#"+t.p.selrow,t.grid.bDiv).removeClass("selected");
				t.p.selrow = $(pt).attr("id");
				if($(pt).attr("class") !== "subgrid") $(pt).addClass("selected");
				if( t.p.onSelectRow ) { t.p.onSelectRow.call($(this), t.p.selrow, true); }
			} else {
				t.p.selrow = selection;
				var ia = t.p.selarrrow.indexOf(t.p.selrow);
				if (  ia === -1 ){
					if($(pt).attr("class") !== "subgrid") { $(pt).addClass("selected");};
					stat = true;
					$("#jqg_"+t.p.selrow,t.grid.bDiv).attr("checked",stat);
					t.p.selarrrow.push(t.p.selrow);
				} else {
					if($(pt).attr("class") !== "subgrid") { $(pt).removeClass("selected");};
					stat = false;
					$("#jqg_"+t.p.selrow,t.grid.bDiv).attr("checked",stat);
					t.p.selarrrow.splice(ia,1);
				}
				if( t.p.onSelectRow ) { t.p.onSelectRow.call($(this), t.p.selrow, stat); }
			}
		});
	};
	$.fn.resetSelection = function(){
		return this.each(function(){
			var t = this;
			if(!t.p.multiselect) {
				if(t.p.selrow) {
					$("tbody tr#"+t.p.selrow,t.grid.bDiv).removeClass("selected");
					t.p.selrow = null;
				}
			} else {
				for(var i = 0;i < t.p.selarrrow.length;i++){
					$("tbody tr#"+t.p.selarrrow[i],t.grid.bDiv).removeClass("selected");
					$("#jqg_"+t.p.selarrrow[i],t.grid.bDiv).attr("checked",false);
				}
				t.p.selarrrow = [];
			}
		});
	};
	$.fn.getRowData = function( rowid ) {
		var res = {};
		if (rowid){
			this.each(function(){
				var $t = this,nm;
				$('#'+rowid+' td',$t.grid.bDiv).each( function(i) {
					nm = $t.p.colModel[i].name;
					if ( nm !== 'cb' && nm !== 'subgrid')
						res[nm] = $(this).text().replace(/\&nbsp\;/ig,'');
				});
			});
		};
		return res;
	};
	$.fn.delRowData = function(rowid) {
		var success = false, rowInd;
		if(rowid) {
			this.each(function() {
				var t = this;
				$('#'+rowid,this.grid.bDiv).each(function(){
					rowInd = this.rowIndex;
					$(this).remove();
					t.p.records--;
					t.updatepager();
					success=true;
				});
				if(rowInd == 1 && success) {
					$("tbody tr:eq(1) td",this.grid.bDiv).each( function( k ) {
						$(this).css("width",t.grid.headers[k].width+"px");
						t.grid.cols[k] = this;
					});
				};
				if( this.p.altRows === true && success) {
					$("tr",this.grid.bDiv).removeClass("alt");
					$("tr:odd",this.grid.bDiv).addClass("alt");
				};
			});
		};
		return success;
	};
	$.fn.setRowData = function(rowid, data) {
		var success = false, nm, vl=true;
		this.each(function(){
			var t = this;
			if( $("#"+rowid,t.grid.bDiv).attr('id')==rowid &&  data ) {
				success=true;
				$(this.p.colModel).each(function(i){
					nm = this.name;
					$(data).each(function() {
						if(this[nm]) {
							$("#"+rowid,t.grid.bDiv).find("td:eq("+i+")").html(this[nm]);
							vl = true;
							return false;
						}
						success = success && vl;
					});
				});
			}
		});
		return success;
	};
	$.fn.addRowData = function(rowid,data,pos) {
		if(!pos) pos = "last";
		var success = false;
		var nm, row, td, gi=0, si=0;
		if(data) {
			this.each(function() {
				var t = this;
				row =  document.createElement("tr");
				row.id = rowid || t.p.records+1;
				if(t.p.multiselect) {
					td = $('<td valign="middle" align="center"></td>');
					$(td[0],t.grid.bDiv).html("<input type='checkbox'"+" id='jqg_"+rowid+"' class='cbox' value='" + rowid + "'/>");
					row.appendChild(td[0]);
					gi = 1;
				}
				if(t.p.subGrid ) {$(t).addSubGrid(t.grid.bDiv,row,gi); si=1;}
				for(var i = gi+si; i < this.p.colModel.length;i++){
					nm = this.p.colModel[i].name;
					td  = $('<td></td>');
					$(td[0]).html('&nbsp;');
					t.formatCol($(td[0],t.grid.bDiv),i);
					$(data).each(function(j) {
						if(this[nm]) {
							$(td[0]).html(this[nm]);
							return false;
						}
					});
					row.appendChild(td[0]);
				}
				if (pos === "last") $("tbody",t.grid.bDiv).append(row);
				else $("tbody tr:eq(0)",t.grid.bDiv).after(row);
				t.p.records++;
				if(!$.browser.msie) {
					t.scrollLeft = t.scrollLeft;
					$("tbody tr:eq(1) td",t.grid.bDiv).each( function( k ) {
						$(this).css("width",t.grid.headers[k].width+"px");
						t.grid.cols[k] = this;
					});
				};
				if( t.p.altRows === true ) { $("tr", t.grid.bDiv).removeClass("alt");$("tr:odd", t.grid.bDiv).addClass("alt"); }
				t.updatepager();
				success = true;
			});
		}
		return success;
	};
	$.fn.hideCol = function(colname) {
		return this.each(function() {
			var $t = this,w=0;
			if (!$t.grid ) return;
			$(this.p.colModel).each(function(i) {
				if (this.name === colname && !this.hidden) {
					w = $("table:first",$t.grid.hDiv).width();
 					$("tr th:eq("+i+")",$t.grid.hDiv).css({display:"none"});
					$("tr",$t.grid.bDiv).each(function(j){
						$("td:eq("+i+")",this).css({display:"none"});
					});
					this.hidden=true;
					$("table:first",$t.grid.hDiv).css("width",w+"px");
					return false;
				};
			});
		});
	};
	$.fn.showCol = function(colname) {
		return this.each(function() {
			$t = this; var w = 0;
			if (!$t.grid ) return;
			$($t.p.colModel).each(function(i) {
				if (this.name === colname && this.hidden) {
					$("tr th:eq("+i+")",$t.grid.hDiv).css("display","");
					$("tr",$t.grid.bDiv).each(function(){
						$("td:eq("+i+")",this).css("display","");
					});
					this.hidden=false;
					return false;
				};
			});
		});
	};
	$.fn.setCaption = function (newcap){
		return this.each(function(){
			this.p.caption=newcap;
			$("table th",this.grid.cDiv).text(newcap);
			$(this.grid.cDiv).show();
		});
	};
	return this.each( function() {
		if(this.grid) return;
		this.p = p ;
		if(this.p.imgpath !== "" ) this.p.imgpath += "/";
		var ts = this;
		if( this.p.colNames.length === 0 || this.p.colNames.length !== this.p.colModel.length ) {
			alert("Length of colNames <> colModel or 0!");
			return;
		}
		var onSelectRow = this.p.onSelectRow, ondblClickRow = this.p.ondblClickRow, onSortCol=this.p.onSortCol, loadComplete = this.p.loadComplete;
		var onRightClickRow = this.p.onRightClickRow;
		if(typeof onSelectRow !== 'function') {onSelectRow=false;}
		if(typeof ondblClickRow !== 'function') {ondblClickRow=false;}
		if(typeof onSortCol !== 'function') {onSortCol=false;}
		if(typeof loadComplete !== 'function') {loadComplete=false;}
		if(typeof onRightClickRow !== 'function') {onRightClickRow=false;}
		if(!Array.indexOf){
			Array.prototype.indexOf = function(obj){
				for(var i=0; i<this.length; i++){
					if(this[i]==obj){
						return i;
					}
				}
				return -1;
			}
		}
		var sortkeys = ["shiftKey","altKey","ctrlKey"];
		if (sortkeys.indexOf(ts.p.multikey) == -1 ) ts.p.multikey = null;
		var formatCol = function (elem, pos){
			var rowalign1 = ts.p.colModel[pos].align || "left";
			$(elem).css("text-align",rowalign1);
			if(ts.p.colModel[pos].hidden) $(elem).css("display","none");
			return false;
		};
		var resizeFirstRow = function (t){
			$("tbody tr:eq(1) td",t).each( function( k ) {
				$(this).css("width",grid.headers[k].width+"px");
				grid.cols[k] = this;
			});
			return false;
		};
		var addCell = function(t,row,cell,pos) {
			var td;
			td = document.createElement("td");
			$(td,t).html( cell);
			formatCol($(td,t), pos);
			row.appendChild(td);
			return false;
		};
		var addMulti = function(t,row){
			var cbid,td;
			td = document.createElement("td");
			td.setAttribute('align', 'center');
			td.setAttribute('valign', 'middle');
			cbid = "jqg_"+row.id;
			var c = $(td,t).html("<input type='checkbox'"+" id='"+cbid+"' class='cbox' value='" + row.id + "'/>");
			formatCol(c, 0);
			row.appendChild(td);
		};
		var reader = function (datatype) {
			var field, f=[], j=0;
			for(var i =0; i<ts.p.colModel.length; i++){
				var field = ts.p.colModel[i];
				if (field.name !== 'cb' && field.name !=='subgrid') {
					f[j] = datatype=="xml" ? field.xmlmap || field.name : field.jsonmap || field.name;
					j++;
				}
			}
			return f
		};
		var addXmlData = function addXmlData (xml,t) {
			if(xml) { $("tbody tr:gt(0)", t).remove(); } else { return false; }
			var row,gi=0,si=0,cbid,rowh=0,idn, f=[];
			if(!ts.p.xmlReader.repeatitems) f = reader("xml");
			if( !ts.p.keyIndex ) {
				idn = ts.p.xmlReader.id;
				if( idn.indexOf("[") === -1 )
					var getId = function( trow, k) { return $(idn,trow).text() || k }
				else
					var getId = function( trow, k) { return trow.getAttribute(idn.replace(/[\[\]]/g,"")) || k }
			} else {
				var getId = function(trow) { return f.length >= ts.p.keyIndex ? $(f[ts.p.keyIndex],trow).text() : $(ts.p.xmlReader.cell+":eq("+ts.p.keyIndex+")",trow).text() }
			}
			$(ts.p.xmlReader.page,xml).each(function() {ts.p.page = this.textContent  || this.text ; });
			$(ts.p.xmlReader.total,xml).each(function() {ts.p.lastpage = this.textContent  || this.text ; }  );
			$(ts.p.xmlReader.records,xml).each(function() {ts.p.records = this.textContent  || this.text ; }  );
			$(ts.p.xmlReader.userdata,xml).each(function() {ts.p.userData[this.getAttribute("name")]=this.textContent || this.text});
			$(ts.p.xmlReader.root+">"+ts.p.xmlReader.row,xml).each( function( j ) {
				row = document.createElement("tr");
				row.id = getId(this,j+1);
				if(ts.p.multiselect) {
					addMulti(t,row);
					gi = 1;
				}
				if (ts.p.subGrid) {
					$(ts).addSubGrid(t,row,gi);
					si= 1;
				}
				if(ts.p.xmlReader.repeatitems===true){
					$(ts.p.xmlReader.cell,this).each( function (i) {
						addCell(t,row,this.textContent || this.text || '&nbsp;',i+gi+si);
					});
				} else {
					var v;
					for(var i = 0; i < f.length;i++) {
						v = $(f[i],this).text() || '&nbsp;';
						addCell(t, row, v, i+gi+si);
					}
				}
				$("tbody",t).append(row);
				if(ts.p.rowheight) rowh = rowh+ts.p.rowheight;
			});
			xml = null;
			if(!isMSIE) { ts.scrollLeft = ts.scrollLeft; resizeFirstRow(t);}
		  	ts.scrollTop = 0;
		  	if(ts.p.rowheight) $(grid.bDiv).css({height:rowh+2+'px'});
		 	if( ts.p.altRows === true ) { $("tbody tr:odd", t).addClass("alt"); }
			grid.hDiv.loading = false;
			$("div.loading",grid.bDiv).fadeOut("fast");
			updatepager();
			return false;
		};
		var addJSONData = function(data,t) {
			if(data) { $("tbody tr:gt(0)", t).remove(); } else { return false; }
			var row,cur,gi=0,rowh=0,si=0,drows,idn;
			ts.p.page = data[ts.p.jsonReader.page];
			ts.p.lastpage= data[ts.p.jsonReader.total];
			ts.p.records= data[ts.p.jsonReader.records];
			ts.p.userData = data[ts.p.jsonReader.userdata] || {};
			idn = !ts.p.keyIndex ? ts.p.jsonReader.id : ts.p.keyIndex;
			if(!ts.p.jsonReader.repeatitems) var f = reader("json");
			drows = data[ts.p.jsonReader.root];
			if (drows) {
			for (var i=0;i<drows.length;i++) {
				cur = drows[i];
				row = document.createElement("tr");
				row.id = cur[idn] || i+1;
				if(ts.p.multiselect){
					addMulti(t,row);
					gi = 1;
				}
				if (ts.p.subGrid) {
					$(ts).addSubGrid(t,row,gi);
					si= 1;
				}
				if (ts.p.jsonReader.repeatitems === true) {
					if(ts.p.jsonReader.cell) cur = cur[ts.p.jsonReader.cell];
					for (var j=0;j<cur.length;j++) {
						addCell(t,row,cur[j] || '&nbsp;',j+gi+si);
					}
				} else {
					for (var j=0;j<f.length;j++) {
						addCell(t,row,cur[f[j]] || '&nbsp;',j+gi+si);
					}
				}
				$("tbody",t).append(row);
				if(ts.p.rowheight) rowh = rowh+ts.p.rowheight;
			}
			}
			data = null;
			if(!isMSIE) { ts.scrollLeft = ts.scrollLeft; resizeFirstRow(t);}
			ts.scrollTop = 0;
			if(ts.p.rowheight) $(grid.bDiv).css({height:rowh+2+'px'});
			if( ts.p.altRows === true ) { $("tbody tr:odd", t).addClass("alt"); }
			grid.hDiv.loading = false;
			$("div.loading",grid.bDiv).fadeOut("fast");
			updatepager();
			return false;
		};
		var updatepager = function() {
			if(ts.p.pager) {
				var cp, last,imp = ts.p.imgpath;
				if (ts.p.loadonce) {
					cp = last = 1;
					ts.p.lastpage = ts.page =1;
					$(".selbox",ts.p.pager).attr("disabled",true);
				} else {
					cp = IntNum(ts.p.page);
					last = IntNum(ts.p.lastpage);
					$(".selbox",ts.p.pager).attr("disabled",false);
				}
				$('#sp_1',ts.p.pager).html("/"+"&nbsp;"+ts.p.lastpage );
				$('input.selbox',ts.p.pager).val(ts.p.page);
				if (ts.p.viewrecords)
					$('#sp_2',ts.p.pager).html(ts.p.records+"&nbsp;"+ts.p.recordtext+"&nbsp;");
				if(cp==1) $("#first",ts.p.pager).attr({src:imp+"off-"+ts.p.firstimg,disabled:true}); else $("#first",ts.p.pager).attr({src:imp+ts.p.firstimg,disabled:false});
				if(cp==1) $("#prev",ts.p.pager).attr({src:imp+"off-"+ts.p.previmg,disabled:true}); else $("#prev",ts.p.pager).attr({src:imp+ts.p.previmg,disabled:false});
				if(cp==last) $("#next",ts.p.pager).attr({src:imp+"off-"+ts.p.nextimg,disabled:true}); else $("#next",ts.p.pager).attr({src:imp+ts.p.nextimg,disabled:false});
				if(cp==last) $("#last",ts.p.pager).attr({src:imp+"off-"+ts.p.lastimg,disabled:true}); else $("#last",ts.p.pager).attr({src:imp+ts.p.lastimg,disabled:false});
			}
			return false;
		};
		var populate = function () {
			if(!grid.hDiv.loading) {
				grid.hDiv.loading = true;
				$("div.loading",grid.bDiv).fadeIn("fast");
				var gdata = $.extend(ts.p.postData,{page: ts.p.page, rows: ts.p.rowNum, sidx: ts.p.sortname, sord:ts.p.sortorder, _nd: (new Date().getTime()), _search:ts.p.search});
				if (ts.p.search ===true) gdata =$.extend(gdata,ts.p.searchdata);
				switch(ts.p.datatype)
				{
				case "json":
					$.ajax({url:ts.p.url,type:ts.p.mtype,datatype:"json",data: gdata, complete:function(JSON) { addJSONData(eval("("+JSON.responseText+")"),ts.grid.bDiv); if(loadComplete) loadComplete();}});
					if( ts.p.loadonce ) ts.p.datatype = "local";
				break;
				case "xml":
					$.ajax({url: ts.p.url,type:ts.p.mtype,dataType:"xml",data: gdata, complete:function(xml) { addXmlData(xml.responseXML,ts.grid.bDiv);if(loadComplete) loadComplete();}});
					if( ts.p.loadonce ) ts.p.datatype = "local";
				break;
				case "xmlstring":
					addXmlData(stringToDoc(ts.p.datastr),ts.grid.bDiv);
					ts.p.datastr = null;
					ts.p.datatype = "local";
					if(loadComplete) loadComplete();
				break;
				case "jsonstring":
					addJSONData(eval("("+ts.p.datastr+")"),ts.grid.bDiv);
					ts.p.datastr = null;
					ts.p.datatype = "local";
					if(loadComplete) loadComplete();
				break;
				case "local":
				case "clientSide":
					sortArrayData();
				break;
				}
			}
			return false;
		};
		var stringToDoc =	function (xmlString) {
			var xmlDoc;
			if (isSafari2){
				var z=document.createElement('div');
				z.innerHTML = xmlString;
				xmlDoc=z;
				z.responseXML=z;
			}
			else {
				try	{
					var parser = new DOMParser();
					xmlDoc = parser.parseFromString(xmlString,"text/xml");
				}
				catch(e) {
					xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
					xmlDoc.async=false;
					xmlDoc["loadXM"+"L"](xmlString);
				}
			}
			return (xmlDoc && xmlDoc.documentElement && xmlDoc.documentElement.tagName != 'parsererror') ? xmlDoc : null;
		};
		var sortArrayData = function() {
			var newDir = ts.p.sortorder == "asc" ? 1 :-1;
			var column = ts.p.lastsort >=0 ? ts.p.lastsort:0;
			var st = ts.p.colModel[column].sorttype;
			if (st == 'float') {
				findSortKey = function($cell) {
					var key = parseFloat($cell.html().replace(/,/g, ''));
					return isNaN(key) ? 0 : key;
				}
			} else if (st=='int') {
				findSortKey = function($cell) {
					return IntNum($cell.html().replace(/,/g, ''))
				}
			} else if(st == 'date') {
				findSortKey = function($cell) {
					var fd = ts.p.colModel[column].datefmt || "Y-m-d";
					return parseDate(fd,$cell.html()).getTime();
				}
			} else {
				findSortKey = function($cell) {
					return $cell.html().toUpperCase();
				}
			}
			var rows = $(ts.grid.bDiv).find('tbody > tr:gt(0)').get();
			$.each(rows, function(index, row) {
				row.sortKey = findSortKey($(row).children('td').eq(column));
				var a =1;
			});
			rows.sort(function(a, b) {
				if (a.sortKey < b.sortKey) return -newDir;
				if (a.sortKey > b.sortKey) return newDir;
				return 0;
			});
			$.each(rows, function(index, row) {
				$('tbody',ts.grid.bDiv).append(row);
				row.sortKey = null;
			});
			if(!isMSIE) { ts.scrollLeft = ts.scrollLeft; resizeFirstRow(grid.bDiv);}
			if(ts.p.multiselect) {
				$("tbody tr:gt(0)", ts.grid.bDiv).removeClass("selected");
				$("[@id^=jqg_]",ts.grid.bDiv).attr("checked",false);
				ts.p.selarrrow = [];
			}
			if( ts.p.altRows === true ) {
				$("tbody tr:gt(0)", ts.grid.bDiv).removeClass("alt");
				$("tbody tr:odd", ts.grid.bDiv).addClass("alt");
			}
			ts.scrollTop = 0;
			ts.grid.hDiv.loading = false;
			$("div.loading",ts.grid.bDiv).fadeOut("fast");
		};
		var parseDate = function(format, date) {
			var tsp = {m : 1, d : 1, y : 1970, h : 0, i : 0, s : 0};
			format = format.toLowerCase();
			date = date.split(/[\\\/:_;.\s-]/);
			format = format.split(/[\\\/:_;.\s-]/);
			for(var i=0;i<format.length;i++){
				tsp[format[i]] = IntNum(date[i],tsp[format[i]]);
			}
			tsp.m = parseInt(tsp.m)-1;
			var ty = tsp.y;
			if (ty >= 70 && ty <= 99) tsp.y = 1900+tsp.y;
			else if (ty >=0 && ty <=69) tsp.y= 2000+tsp.y;
			return new Date(tsp.y, tsp.m, tsp.d, tsp.h, tsp.i, tsp.s,0);
		};
		var setPager = function (){
			$(ts.p.pager).css('width', grid.width + 'px');
			var inpt = "<input type='image' class='pgbuttons' src='"+ts.p.imgpath+"spacer.gif'";
			$(ts.p.pager).append(inpt+" id='first'/>"+"&nbsp;&nbsp;"+inpt+" id='prev'/>"+"&nbsp;<input class='selbox' type='text' size='3' maxlength='5' value='0'/><span id='sp_1'></span>&nbsp;"+inpt+" id='next'/>&nbsp;&nbsp;"+inpt+" id='last'/>");
			if(ts.p.rowList.length >0){
				var str="<SELECT class='selbox'>";
				for(var i=0;i<ts.p.rowList.length;i++){
					str +="<OPTION value="+ts.p.rowList[i]+((ts.p.rowNum == ts.p.rowList[i])?' selected':'')+">"+ts.p.rowList[i];
				}
				str +="</SELECT>";
				$(ts.p.pager).append("&nbsp;"+str+"&nbsp;<span id='sp_2'></span>");
				$(ts.p.pager).find("select").bind('change',function() {
					ts.p.rowNum = this.value>0 ? this.value : ts.p.rowNum; populate();
					ts.p.selrow = null;
				});
			}
			$("#first, #prev, #next, #last",ts.p.pager).click( function() {
				var cp = IntNum(ts.p.page);
				var last = IntNum(ts.p.lastpage), selclick = false;
				var fp=true; var pp=true; var np=true; var lp=true;
				if(last ===0 || last===1) {fp=false;pp=false;np=false;lp=false; }
				else if( last>1 && cp >=1) {
					if( cp === 1) { fp=false; pp=false; }
					else if( cp>1 && cp <last){ }
					else if( cp===last){ np=false;lp=false; }
				} else if( last>1 && cp===0 ) { np=false;lp=false; cp=last-1;}
				if( $(this).attr('id') === 'first' && fp ) { ts.p.page=1; selclick=true;}
				if( $(this).attr('id') === 'prev' && pp) { ts.p.page=(cp-1); selclick=true;}
				if( $(this).attr('id') === 'next' && np) { ts.p.page=(cp+1); selclick=true;}
				if( $(this).attr('id') === 'last' && lp) { ts.p.page=last; selclick=true;}
				if(selclick) {
					if (typeof ts.p.onPaging =='function') ts.p.onPaging();
					populate();
					ts.p.selrow = null;
					if(ts.p.multiselect) {ts.p.selarrrow =[];$('#cb_jqg',ts.grid.hDiv).attr("checked",false);}
					ts.p.savedRow = [];
				}
				return false;
			});
			$('input.selbox',ts.p.pager).keypress( function(e) {
				var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
				if(key == 13) {
					ts.p.page = $(this).val()>0 ? $(this).val():ts.p.page;
					if (typeof ts.p.onPaging =='function') ts.p.onPaging();
					populate();
					ts.p.selrow = null;
					return false;
				}
				return this;
			});
			return false;
		};
		var sortData = function (index, idxcol,reload){
			if(!reload) {
				if( ts.p.lastsort === idxcol ) {
					if( ts.p.sortorder === 'asc') {
						ts.p.sortorder = 'desc';
					} else if(ts.p.sortorder === 'desc') { ts.p.sortorder='asc';}
				} else { ts.p.sortorder='asc';}
				ts.p.page = 1;
			}
			var imgs = ts.p.sortorder==='asc' ? ts.p.sortascimg : ts.p.sortdescimg;
			imgs = "<img class='sort_arrow' src='"+ts.p.imgpath+imgs+"'>";
			var thd= $("thead", grid.hTable);
			$("img.sort_arrow").remove();
			$("tr th div#"+index,thd).append(imgs);
			ts.p.lastsort = idxcol;
			ts.p.sortname = ts.p.colModel[idxcol].index || index;
			if(onSortCol) {onSortCol(index,idxcol);}
			if(ts.p.selrow && ts.p.datatype == "local" && !ts.p.multiselect){ $('#'+ts.p.selrow,grid.bDiv).removeClass("selected");}
			ts.p.selrow = null;
			if(ts.p.multiselect && ts.p.datatype !== "local"){ts.p.selarrrow =[]; $("#cb_jqg",ts.grid.hTable).attr("checked",false);}
			ts.p.savedRow =[];
			populate();
			return false;
		};
		var setGridWidth = function () {
			var initwidth = 0;
			for(var l=0;l<ts.p.colModel.length;l++)
				if(!ts.p.colModel[l].hidden)
					initwidth += IntNum(ts.p.colModel[l].width || 150);
			var tblwidth = ts.p.width ? ts.p.width : initwidth;
			/*
			for(l=0;l<ts.p.colModel.length;l++) {
				if(!ts.p.shrinkToFit)
					if(!ts.p.colModel[l].hidden)
						ts.p.colModel[l].owidth = ts.p.colModel[l].width;
				ts.p.colModel[l].width = Math.round(tblwidth/initwidth*ts.p.colModel[l].width);
			}
			*/
			return false;
		};
		var IntNum = function(val,defval) {
			val = parseInt(val,10);
			if (isNaN(val)) {
				return defval ? defval : 0;
			} else {
				return val;
			}
		};
		if(this.p.subGrid) {
			this.p.colNames.unshift("");
			this.p.colModel.unshift({name:'subgrid',width:25,sortable: false,resizable:false});
		};
		if(this.p.multiselect) {
			this.p.colNames.unshift("<input id='cb_jqg' class='cbox' type='checkbox'/>");
			this.p.colModel.unshift({name:'cb',width:28,sortable:false,resizable:false,align:'center'});
		};
		var	xReader = {
			root: "rows",
			row: "row",
			page: "rows>page",
			total: "rows>total",
			records : "rows>records",
			repeatitems: true,
			cell: "cell",
			id: "[id]",
			userdata: "userdata",
			subgrid: {root:"rows", row: "row", repeatitems: true, cell:"cell"}
		};
		var jReader = {
			root: "rows",
			page: "page",
			total: "total",
			records: "records",
			repeatitems: true,
			cell: "cell",
			id: "id",
			userdata: "userdata",
			subgrid: {root:"rows", repeatitems: true, cell:"cell"}
		};
		this.p.xmlReader = $.extend(xReader, this.p.xmlReader);
		this.p.jsonReader = $.extend(jReader, this.p.jsonReader);
		if (this.p.width) setGridWidth();
		var thead = document.createElement("thead");
		var trow = document.createElement("tr");
		thead.appendChild(trow);
		var i=0, th, idn, thdiv;
		ts.p.keyIndex=false;
		for (var i=0; i<ts.p.colModel.length;i++) {
			if (ts.p.colModel[i].key==true) {
				ts.p.keyIndex = i;
				break;
			}
			i++;
		};
		for(i=0;i<this.p.colNames.length;i++){
			th = document.createElement("th");
			th.setAttribute('align', 'center');
			th.setAttribute('valign', 'middle');
			idn = ts.p.colModel[i].name;
			idn = idn ? idn : i+1;
			thdiv = document.createElement("div");
			thdiv.id = ""+idn+"";
			if (idn == 'cb') {
				$(thdiv).remove();
				$(th).css('text-align', 'center').html(ts.p.colNames[i]);
			} else {
				$(thdiv).html(ts.p.colNames[i]+"&nbsp;");
				th.appendChild(thdiv);
			}
			trow.appendChild(th);
		};
		if(this.p.multiselect) {
			$('#cb_jqg',trow).click(function(){
				if (this.checked) {
					$("[@id^=jqg_]",grid.bDiv).attr("checked",true);
					$("tr:gt(0)",ts.grid.bDiv).each(function(i) {
						$(this).addClass("selected");
						ts.p.selarrrow[i]=this.id;
					});
				}
				else {
					$("[@id^=jqg_]",grid.bDiv).attr("checked",false);
					$("tr",grid.bDiv).removeClass("selected");
					ts.p.selarrrow = [];
				}
			});
		};
		this.appendChild(thead);
		thead = $("thead:first",ts).get(0);
		var w, res, sort;
		$("tr:first th",thead).each(function ( j ) {
			w = ts.p.colModel[j].width || 150;
			//alert(w);
			if(typeof ts.p.colModel[j].resizable == 'undefined') ts.p.colModel[j].resizable = true;
			if (ts.p.colModel[j].resizable) {
				res = document.createElement("span");
				res.setAttribute('style', 'display:inline;vertical-align:middle');
				$(res).html("&nbsp;");
				$(res).mousedown(function (e) {
					grid.dragStart( j ,e.clientX);
					return false;
				});
				$(this).prepend(res);
			}
			$(this).css("width", w + "px");
			if( ts.p.colModel[j].hidden) $(this).css("display","none");
			grid.headers[j] = { width: w, el: this };
		});
		$("tr:first th div",thead).each(function(l) {
			if (ts.p.multiselect) l++;
			sort = ts.p.colModel[l].sortable;
			if( typeof sort !== 'boolean') sort =  true;
			if(sort) {
				$(this).css("cursor","pointer");
				$(this).click(function(){sortData(this.id,l);return false;});
			}
		});
		var tbody = document.createElement("tbody");
		trow = document.createElement("tr");
		trow.style.display="none";
		trow.id = "_empty";
		tbody.appendChild(trow);
		var td, ptr;
		for(i=0;i<ts.p.colNames.length;i++){
			td = document.createElement("td");
			trow.appendChild(td);
		};
		this.appendChild(tbody);
		var gw=0;
		$("tbody tr:first td",ts).each(function(ii) {
			w = ts.p.colModel[ii].width || 150;
			$(this).css("width",w+"px");
			if( ts.p.colModel[ii].hidden) {
				$(this).css("display","none");
			} else {
				w +=  IntNum($(this).css("padding-left")) +
				IntNum($(this).css("padding-right"))+
				IntNum($(this).css("border-left-width"))+
				IntNum($(this).css("border-right-width"));
			}
			grid.cols[ii] = this;
			gw += w;
		});
		//grid.width = $(this).width();
		grid.width = ts.p.width || 730;
		if (grid.width == 0) grid.width = gw;
		ts.p.width = grid.width;
		grid.hTable = document.getElementById(this.id);
		grid.hTable.appendChild(thead);
		grid.hDiv = document.createElement("div");
		$(grid.hDiv)
			.css({ width: grid.width+"px", overflow: "hidden", display: 'none'})
			.bind("selectstart", function () { return false; });
		if(ts.p.pager){
			if( $(ts.p.pager).attr("class") === "scroll") $(ts.p.pager).css({ width: (grid.width)+1+"px", overflow: "hidden"}).show();
			setPager();
		};
		$(ts).mouseover(function(e) {
			td = (e.target || e.srcElement);
			ptr = $(td,ts).parents("tr:first");
			if($(ptr).attr("class") !== "subgrid") {
				$(ptr).addClass("over");
				td.title = $(td).text();
			}
			return false;
		}).mouseout(function(e) {
			td = (e.target || e.srcElement);
			ptr = $(td,ts).parents("tr:first");
			$(ptr).removeClass("over");
			td.title = "";
			return false;
		}).css("width", grid.width+"px").before(grid.hDiv).click(function(e) {
			if ( !ts.p.multikey) {
				td = (e.target || e.srcElement);
				ptr = $(td,ts).parents("tr:first");
				$(ts).setSelection($(ptr).attr("id"));
			} else {
				if (e[ts.p.multikey]){
					td = (e.target || e.srcElement);
					ptr = $(td,ts).parents("tr:first");
					$(ts).setSelection($(ptr).attr("id"));
				} else {
					td = (e.target || e.srcElement);
					ptr = $(td).parents("td:first");
					if ( $(ptr).html() !== null) {
						td = $("[@id^=jqg_]",ptr).attr("checked");
						td = typeof td == "undefined" ? false: td;
						$("[@id^=jqg_]",ptr).attr("checked",!td);
					}
				}
			}
			e.stopPropagation();
		}).bind('reloadGrid', function(e) {
			ts.p.selrow=null;
			if(ts.p.multiselect) {
				ts.p.selarrrow = [];
				$('input#cb_jqg', ts.grid.hTable).attr("checked", false);
			}
			populate();
		});
		if( ondblClickRow ) {
			$(this).dblclick(function(e) {
				td = (e.target || e.srcElement);
				ptr = $(td,ts).parents("tr:first");
				ts.p.ondblClickRow($(ptr).attr("id"));
				return false;
			});
		};
		if (onRightClickRow)
			$(this).bind('contextmenu', function(e) {
				td = (e.target || e.srcElement);
				ptr = $(td,ts).parents("tr:first");
				$(ts).setSelection($(ptr).attr("id"));
				ts.p.onRightClickRow($(ptr).attr("id"));
				return false;
			});
		grid.bDiv = document.createElement("div");
		$(grid.bDiv)
			.scroll(function (e) {grid.scrollGrid()})
			.css({ height: ts.p.height+(isNaN(ts.p.height)?"":"px"), padding: "0px", margin: "0px", overflow: "auto",width: (grid.width)+1+"px"} ).css("overflow-x","hidden")
			.append('<div class="loading">'+ts.p.loadtext+'</div>')
			.append(this);
		$("table:first",grid.bDiv).css("margin-right","20px");
		var isMSIE = $.browser.msie ? true:false;
		var isSafari2 = $.browser.safari && ( parseInt($.browser.version) <= 419) ? true : false;
		if( isMSIE ) {
			if( $("tbody",this).size() === 2 ) { $("tbody:first",this).remove();}
			if( ts.p.multikey) $(grid.bDiv).bind("selectstart",function(){return false;});
		} else {
			if( ts.p.multikey) $(grid.bDiv).bind("mousedown",function(){return false;});
		};
		grid.cDiv = document.createElement("div");
		if(ts.p.caption) {
			$(grid.cDiv).append("<table class='Header' cellspacing='0' cellpadding='0' border='0'><tr><td class='HeaderLeft'><img src='"+ts.p.imgpath+"spacer.gif' border='0' /></td><th>"+ts.p.caption+"</th>"+ ((ts.p.hidegrid==true) ? "<td class='HeaderButton'><img src='"+ts.p.imgpath+"up.gif' border='0'/></td>" :"") +"<td class='HeaderRight'><img src='"+ts.p.imgpath+"spacer.gif' border='0' /></td></tr></table>").addClass("GridHeader");
			$(grid.cDiv).insertBefore(grid.hDiv);
		}
		if( ts.p.toolbar[0] ) {
			grid.uDiv = document.createElement("div");
			if(ts.p.toolbar[1] == "top") $(grid.uDiv).insertBefore(grid.hDiv);
			else $(grid.uDiv).insertAfter(grid.hDiv);
			$(grid.uDiv,ts).width(grid.width).addClass("userdata").attr("id","t_"+this.id);
		};
		if(ts.p.caption) {
			$(grid.cDiv,ts).show().width(grid.width).css("text-align","center");
			if(ts.p.hidegrid==true) {
				$(".HeaderButton",grid.cDiv).toggle( function(){
					if(ts.p.pager) $(ts.p.pager).fadeOut("slow");
					if(ts.p.toolbar[0]) $(grid.uDiv,ts).fadeOut("slow");
					$(grid.bDiv,ts).fadeOut("slow");
					$(grid.hDiv,ts).fadeOut("slow");
					$("img",this).attr("src",ts.p.imgpath+"down.gif");
					},
					function() {
					$(grid.hDiv ,ts).fadeIn("slow");
					$(grid.bDiv,ts).fadeIn("slow");
					if(ts.p.pager) $(ts.p.pager,ts).fadeIn("slow");
					if(ts.p.toolbar[0]) $(grid.uDiv).fadeIn("slow");
					$("img",this).attr("src",ts.p.imgpath+"up.gif");
					}
				);
			};
		};
		$(grid.hDiv).after(grid.bDiv);
		$('thead tr:first', grid.hTable).mousemove(function (e) {grid.dragMove(e.clientX);});
		$(grid.bDiv).mouseup(function (e) {
			if(grid.resizing) {
				grid.dragEnd();
				var gwdt = grid.width < ts.p.width ? grid.width : ts.p.width;
				var overfl = grid.width < ts.p.width ? "hidden" : "auto";
				if(ts.p.pager && $(ts.p.pager).attr("class")=="scroll" ) {
					$(ts.p.pager).width(gwdt+1);
				}
				if(ts.p.caption) $(grid.cDiv).width(gwdt);
				if(ts.p.toolbar[0]) $(grid.uDiv).width(gwdt);
				$(grid.bDiv).width(gwdt+1).css("overflow-x",overfl);
			}
			return false;
		});
		ts.formatCol = function(a,b) {formatCol(a,b);};
		ts.sortData = function(a,b,c){sortData(a,b,c);};
		ts.updatepager = function(){updatepager();};
		this.grid = grid;
		populate();
		if (!ts.p.shrinkToFit) {
			$("tr:first th", thead).each(function(j){
				var w = ts.p.colModel[j].owidth;
				var diff = w - ts.p.colModel[j].width;
				if (diff > 0) {
					grid.headers[j].width = w;
					$(this).add(grid.cols[j]).width(w);
					grid.width = grid.width + diff;
					$('table',grid.bDiv).add(grid.hTable).width(grid.width);
					grid.hDiv.scrollLeft = grid.bDiv.scrollLeft;
				}
			});
			$(grid.bDiv).css("overflow-x","auto");
		};
		$(window).unload(function () {
			$(this).unbind();
			this.p = null;
			this.grid = null;
			$(ts.p.pager).unbind();
		});
	});
};
})(jQuery);
