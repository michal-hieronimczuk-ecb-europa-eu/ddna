/*
 * table-sortable
 * version: 2.0.3
 * release date: 4/2/2021
 * (c) Ravi Dhiman <ravi.dhiman@ravid.dev> https://ravid.dev
 * For the full copyright and license information, please view the LICENSE
*/
!function(t){var e={};function n(a){if(e[a])return e[a].exports;var i=e[a]={i:a,l:!1,exports:{}};return t[a].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,a){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(a,i,function(e){return t[e]}.bind(null,i));return a},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=1)}([function(t,e){t.exports=jQuery},function(t,e,n){t.exports=n(3)},function(t,e,n){},function(t,e,n){"use strict";n.r(e);var a={};function i(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function r(t,e){for(var n=0;n<e.length;n++){var a=e[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}function o(t,e,n){return e&&r(t.prototype,e),n&&r(t,n),t}n.r(a),n.d(a,"_isArray",function(){return c}),n.d(a,"_isNumber",function(){return h}),n.d(a,"_isObject",function(){return d}),n.d(a,"_isFunction",function(){return f}),n.d(a,"_isString",function(){return p}),n.d(a,"_isDate",function(){return g}),n.d(a,"_sort",function(){return _}),n.d(a,"_keys",function(){return m}),n.d(a,"_forEach",function(){return b}),n.d(a,"_filter",function(){return v}),n.d(a,"_invariant",function(){return y}),n.d(a,"_nativeCompare",function(){return P}),n.d(a,"debounce",function(){return k}),n.d(a,"_lower",function(){return C}),n.d(a,"lookInObject",function(){return w}),n.d(a,"_inRange",function(){return E});var s,l=n(0),u=n.n(l),c=function(t){return Array.isArray(t)},h=function(t){return"number"==typeof t&&!isNaN(t)},d=function(t){return"object"==typeof t},f=function(t){return"function"==typeof t},p=function(t){return"string"==typeof t},g=function(t){if("[object Date]"===Object.prototype.toString.call(t)&&!isNaN(t))return!0;if(p(t)){var e=new Date(t);if(h(e.getDate()))return!0}return!1},_=function(t,e){return t.sort(function(t,n){return"asc"===e?parseInt(t,10)-parseInt(n,10):parseInt(n,10)-parseInt(t,10)})},m=function(t){return"keys"in Object?Object.keys(t):Object.getOwnPropertyNames(t)},b=function(t,e){if(y(c(t),"ForEach requires array input"),!t.length)return[];f(e)||(e=function(){});for(var n=0,a=t.length;n<a;)e.apply(null,[t[n],n]),n+=1;return t},v=function(t,e){if(y(c(t),"_filter requires array input"),!t.length)return[];if(!f(e))return t;for(var n=0,a=t.length,i=[];n<a;)e.apply(null,[t[n],n])&&i.push(t[n]),n+=1;return i},y=function(t,e){var n;if(!t){for(var a=arguments.length,i=new Array(a>2?a-2:0),r=2;r<a;r++)i[r-2]=arguments[r];var o=[].concat(i),s=0;throw(n=new Error(e.replace(/%s/g,function(){return o[s++]}))).name="TableSortable Violation",n.framesToPop=1,n}},P=function(t,e){if(t!==e){if(h(t))return parseFloat(t)>parseFloat(e)?1:-1;if(g(t)){var n=new Date(t),a=new Date(e);return n.getTime()>a.getTime()?1:-1}return p(t)?t>e?1:-1:1}return 0},k=function(t,e){var n;return function(){var a=this,i=arguments;clearTimeout(n),n=window.setTimeout(function(){return t.apply(a,i)},e)}},C=function(t){return p(t)?t.toLowerCase():String(t)},w=function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];if(!e&&!h(e))return!1;var a=m(t);c(n)||(n=a);for(var i=0,r=a.length,o=!1,s=C(e);i<r;){var l=a[i],u=C(t[l]);if(n.length&&n.indexOf(l)>-1&&u.indexOf(s)>-1){o=!0;break}if(!n.length&&u.indexOf(s)>-1){o=!0;break}i+=1}return o},E=function(t,e){return c(e)&&e[0]<=t&&e[1]>t},D=function(){function t(){i(this,t),this._name="dataset",this.dataset=null,this._cachedData=null,this._datasetLen=0,this._outLen=10,this.sortDirection={ASC:"asc",DESC:"desc"}}return o(t,[{key:"_formatError",value:function(t,e,n){for(var i=arguments.length,r=new Array(i>3?i-3:0),o=3;o<i;o++)r[o-3]=arguments[o];y.apply(a,[t,"".concat(this._name,".").concat(e," ").concat(n)].concat(r))}},{key:"_hasDataset",value:function(){this._formatError(null!==this.dataset,"data",'No source collection is provided. Add your collection to dataset with "dataset.fromCollection([{}])" method.')}},{key:"fromCollection",value:function(t){this._formatError(c(t),"fromCollection","Requires dataset to be a collection, like [{ }]"),this.dataset=t,this._cachedData=JSON.stringify(t),this._datasetLen=t.length}},{key:"top",value:function(t){return this._hasDataset(),t?(this._formatError(h(t),"top","Requires length to be a number"),this.dataset.slice(0,t)):this.dataset.slice(0,this._outLen)}},{key:"bottom",value:function(t){return this._hasDataset(),t?(this._formatError(h(t),"bottom","Requires length to be a number"),t=Math.max(this._datasetLen-t,0),this.dataset.slice(t,this._datasetLen)):(t=Math.max(this._datasetLen-this._outLen,0),this.dataset.slice(t,this._datasetLen))}},{key:"get",value:function(t,e){return this._hasDataset(),this._formatError(h(t),"get",'Requires "from" to be a number'),this._formatError(h(e),"get",'Requires "to" to be a number'),this._formatError(!(t>e),"get",'"from" cannot be greater than "to"'),t=Math.max(t,0),e=Math.min(e,this._datasetLen),this.dataset.slice(t,e)}},{key:"sort",value:function(t,e){this._hasDataset(),this._formatError(p(t),"sort",'Requires "column" type of string'),this._formatError(p(e),"sort",'Requires "direction" type of string'),this._formatError("asc"===e||"desc"===e,"sort",'"%s" is invalid sort direction. Use "dataset.sortDirection.ASC" or "dataset.sortDirection.DESC".',e);var n=this.top(1)[0];return this._formatError(void 0!==n[t],"sort",'Column name "%s" does not exist in collection',t),this.sortDirection.ASC===e?this.dataset.sort(function(e,n){return P(e[t],n[t])}):this.dataset.sort(function(e,n){return P(n[t],e[t])}),this.top(this._datasetLen)}},{key:"pushData",value:function(t){c(t)&&Array.prototype.push.apply(this.dataset,t)}},{key:"lookUp",value:function(t,e){if(p(t)||h(t)){var n=JSON.parse(this._cachedData);this.dataset=""===t?n:v(n,function(n){return w(n,t,e)}),this._datasetLen=this.dataset.length}}}]),t}(),x=function(t,e,n){return{node:t,attrs:e,children:n}},S=function(t){var e=t.node,n=t.attrs;return t.children,function(t,e){if(!e)return t;for(var n=Object.keys(e),a=0;a<n.length;){var i=n[a],r=e[i];void 0!==r&&(/^on/.test(i)&&r?t.on(i.replace(/^on/,"").toLowerCase(),r):"text"===i?t.text(r):"html"===i?t.html(r):"append"===i?t.append(r):"className"===i?t.attr("class",r):t.attr(i,r),a+=1)}return t}(u()("<".concat(e,"></").concat(e,">")),n)},U=function t(e,n,a){if(a||n.empty(),c(e)){for(var i=[],r=0;r<e.length;r++){var o=S(e[r]);e[r].children&&(o=t(e[r].children,o,!0)),i.push(o)}n.append(i)}else if(d(e)){var s=S(e);e.children&&(s=t(e.children,s,!0)),n.append(s)}return n},L=function(){return{createElement:x,render:U}},O=(n(2),function(){function t(e){var n=this;i(this,t),this._name="tableSortable",this._defOptions={element:"",data:[],columns:{},sorting:!0,pagination:!0,paginationContainer:null,rowsPerPage:10,formatCell:null,formatHeader:null,searchField:null,responsive:{},totalPages:0,sortingIcons:{asc:"<span>▼</span>",desc:"<span>▲</span>"},nextText:"<span>Next</span>",prevText:"<span>Prev</span>",tableWillMount:function(){},tableDidMount:function(){},tableWillUpdate:function(){},tableDidUpdate:function(){},tableWillUnmount:function(){},tableDidUnmount:function(){},onPaginationChange:null},this._styles=null,this._dataset=null,this._table=null,this._thead=null,this._tbody=null,this._isMounted=!1,this._isUpdating=!1,this._sorting={currentCol:"",dir:""},this._pagination={elm:null,currentPage:0,totalPages:1,visiblePageNumbers:5},this._cachedOption=null,this._cachedViewPort=-1,this.setData=function(t,e,a){n.logError(c(t),"setData","expect first argument as array of objects"),n.logError(d(e),"setData","expect second argument as objects"),n._isMounted&&t&&(a?n._dataset.pushData(t):n._dataset.fromCollection(t),e&&(n.options.columns=e),n.refresh())},this.getData=function(){return n._isMounted?n._dataset.top():[]},this.getCurrentPageData=function(){if(n._isMounted){var t=n.options.rowsPerPage,e=n._pagination.currentPage*t,a=e+t;return n._dataset.get(e,a)}return[]},this.refresh=function(t){t?(n.distroy(),n.create()):n._isMounted&&n.updateTable()},this.distroy=function(){n._isMounted&&(n.emitLifeCycles("tableWillUnmount"),n._table.remove(),n._styles&&n._styles.length&&(n._styles.remove(),n._styles=null),n._dataset=null,n._table=null,n._thead=null,n._tbody=null,n._pagination.elm&&n._pagination.elm.remove(),n._pagination={elm:null,currentPage:0,totalPages:0,visiblePageNumbers:5},n._isMounted=!1,n._isUpdating=!1,n._sorting={currentCol:"",dir:""},n._cachedViewPort=-1,n._cachedOption=null,n.emitLifeCycles("tableDidUnmount"))},this.create=function(){n._isMounted||n.init()},this.options=u.a.extend(this._defOptions,e),delete this._defOptions,this._rootElement=u()(this.options.element),this.engine=L(),this.optionDepreciation(),this.init(),this._debounceUpdateTable()}return o(t,[{key:"optionDepreciation",value:function(){var t=this.options;this.logWarn(t.columnsHtml,"columnsHtml","has been deprecated. Use formatHeader()"),this.logWarn(t.processHtml,"processHtml","has been deprecated. Use formatCell()"),this.logWarn(t.dateParsing,"dateParsing","has been deprecated. It is true by default."),this.logWarn(t.generateUniqueIds,"generateUniqueIds","has been deprecated. It is true by default."),this.logWarn(t.showPaginationLabel,"showPaginationLabel","has been deprecated. It is true by default."),this.logWarn(t.paginationLength,"paginationLength","has been deprecated. Use rowsPerPage")}},{key:"logError",value:function(t,e,n){for(var i=arguments.length,r=new Array(i>3?i-3:0),o=3;o<i;o++)r[o-3]=arguments[o];y.apply(a,[t,"".concat(this._name,".").concat(e," ").concat(n)].concat(r))}},{key:"logWarn",value:function(t,e,n){t&&console.warn("".concat(this._name,".options.").concat(e," ").concat(n))}},{key:"emitLifeCycles",value:function(t){if(this.options){var e=this.options;if(f(e[t])){for(var n=arguments.length,a=new Array(n>1?n-1:0),i=1;i<n;i++)a[i-1]=arguments[i];e[t].apply(this,a)}}}},{key:"setPage",value:function(t,e){this.logError(h(t),"setPage","expect argument as number");var n=this._pagination.totalPages;h(t)&&E(t,[0,n])&&(this._pagination.currentPage=t,e&&this._dataset.pushData(e),this.updateTable())}},{key:"updateRowsPerPage",value:function(t){this.logError(h(t),"updateRowsPerPage","expect argument as number"),t&&(this._pagination.currentPage=0,this.options.rowsPerPage=t,this.updateTable())}},{key:"lookUp",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[],n=this.options.columns;this.logError(e&&c(e),"lookUp","second argument must be array of keys"),e.length||(e=n),this._pagination.currentPage=0,this._dataset.lookUp(t,m(e)),this.debounceUpdateTable()}},{key:"_bindSearchField",value:function(){var t=this,e=this.options.searchField;if(e){var n=u()(e);this.logError(n.length,"searchField",'"%s" is not a valid DOM element or string',n),n.on("input",function(){var e=u()(this).val();t.lookUp(e)}),this.options.searchField=n}}},{key:"_validateRootElement",value:function(){this.logError(this._rootElement.length,"element",'"%s" is not a valid root element',this._rootElement)}},{key:"_createTable",value:function(){this._table=u()("<table></table>").addClass("table gs-table")}},{key:"_initDataset",value:function(){var t=this.options.data;this.logError(c(t),"data","table-sortable only supports collections. Like: [{ key: value }, { key: value }]");var e=new D;e.fromCollection(t),this._dataset=e}},{key:"_validateColumns",value:function(){var t=this.options.columns;this.logError(d(t),"columns","Invalid column type, see docs")}},{key:"sortData",value:function(t){var e=this._sorting,n=e.dir,a=e.currentCol;t!==a&&(n=""),n?n===this._dataset.sortDirection.ASC?n=this._dataset.sortDirection.DESC:n===this._dataset.sortDirection.DESC&&(n=this._dataset.sortDirection.ASC):n=this._dataset.sortDirection.ASC,a=t,this._sorting={dir:n,currentCol:a},this._dataset.sort(a,n),this.updateCellHeader()}},{key:"_addColSorting",value:function(t,e){var n=this,a=this.options.sorting,i=this;return a?(a&&!c(a)&&((t=u()(t)).attr("role","button"),t.addClass("gs-button"),e===this._sorting.currentCol&&this._sorting.dir&&t.append(this.options.sortingIcons[this._sorting.dir]),t.click(function(t){i.sortData(e)})),c(a)&&b(a,function(a){e===a&&((t=u()(t)).attr("role","button"),t.addClass("gs-button"),e===n._sorting.currentCol&&n._sorting.dir&&t.append(n.options.sortingIcons[n._sorting.dir]),t.click(function(t){i.sortData(e)}))}),t):t}},{key:"getCurrentPageIndex",value:function(){var t=this._dataset._datasetLen,e=this.options,n=e.pagination,a=e.rowsPerPage,i=this._pagination.currentPage;if(!n)return{from:0};var r=i*a,o=Math.min(r+a,t);return{from:r=Math.min(r,o),to:o}}},{key:"_renderHeader",value:function(t){var e=this;t||(t=u()('<thead class="gs-table-head"></thead>'));var n=this.options,a=n.columns,i=n.formatHeader,r=[],o=m(a);b(o,function(t,n){var o=a[t];f(i)&&(o=i(a[t],t,n)),o=e._addColSorting(u()("<span></span>").html(o),t);var s=e.engine.createElement("th",{html:o});r.push(s)});var s=this.engine.createElement("tr",null,r);return this.engine.render(s,t)}},{key:"_renderBody",value:function(t){t||(t=u()('<tbody class="gs-table-body"></tbody>'));var e,n=this.engine,a=this.options,i=a.columns,r=a.formatCell,o=this.getCurrentPageIndex(),s=o.from,l=o.to;e=void 0===l?this._dataset.top():this._dataset.get(s,l);var c=[],h=m(i);return b(e,function(t,e){var a=[];b(h,function(e){var i;void 0!==t[e]&&(i=f(r)?n.createElement("td",{html:r(t,e)}):n.createElement("td",{html:t[e]}),a.push(i))}),c.push(n.createElement("tr",null,a))}),n.render(c,t)}},{key:"_createCells",value:function(){return{thead:this._renderHeader(),tbody:this._renderBody()}}},{key:"onPaginationBtnClick",value:function(t,e){var n=this,a=this._pagination,i=a.totalPages,r=a.currentPage,o=this.options.onPaginationChange;if("up"===t?r<i-1&&(r+=1):"down"===t&&r>=0&&(r-=1),f(o)){var s=isNaN(e)?r:e;o.apply(this,[s,function(t){return n.setPage(t)}])}else this._pagination.currentPage=void 0!==e?e:r,this.updateTable()}},{key:"renderPagination",value:function(t){var e=this,n=this.engine,a=this.options,i=a.pagination,r=a.paginationContainer,o=a.prevText,s=a.nextText,l=this._pagination,c=l.currentPage,h=l.totalPages,d=l.visiblePageNumbers,f=Math.min(h,d),p=0,g=Math.min(h,p+f);if(c>f/2&&c<h-f/2?(p=c-Math.floor(f/2),g=Math.min(h,p+f)):c>h-f/2&&(p=h-f,g=h),t||(t=u()('<div class="gs-pagination"></div>'),u()(r).length?u()(r).append(t):this._table.after(t)),!i)return t;var _=[],m=n.createElement("button",{className:"btn btn-default",html:o,disabled:0===c,onClick:function(){return e.onPaginationBtnClick("down")}});_.push(m);var b=n.createElement("button",{className:"btn btn-default",disabled:!0,text:"..."});c>f/2&&_.push(b);for(var v=p;v<g;){var y=n.createElement("button",{className:c===v?"btn btn-primary active":"btn btn-default",onClick:function(){var t=parseInt(u()(this).attr("data-page"),10);Number.isNaN(t)&&(t=parseInt(u()(this).text()-1)),e.onPaginationBtnClick(null,t)},text:v+1,"data-page":v});_.push(y),v+=1}c<h-f/2&&_.push(b);var P=n.createElement("button",{className:"btn btn-default",html:s,disabled:c>=h-1,onClick:function(){return e.onPaginationBtnClick("up")}});_.push(P),t.append(_);var k=this.getCurrentPageIndex(),C=k.from,w=k.to,E=n.createElement("span",{text:"Showing ".concat(Math.min(w,C+1)," to ").concat(w," of ").concat(this._dataset._datasetLen," rows")}),D=n.createElement("div",{className:"col-md-6"},E),S=n.createElement("div",{className:"col-md-6"},x),U=n.createElement("div",{className:"row"},[D,S]);return n.render(U,t)}},{key:"createPagination",value:function(){var t=this.options,e=t.rowsPerPage,n=t.pagination,a=t.totalPages;if(!n)return!1;this.logError(e&&h(e),"rowsPerPage","should be a number greater than zero."),this.logError(h(a),"totalPages","should be a number greater than zero.");var i=a||Math.ceil(this._dataset._datasetLen/e);0>=i&&(i=1),this._pagination.totalPages=i,this._pagination.elm?this.renderPagination(this._pagination.elm):this._pagination.elm=this.renderPagination()}},{key:"_generateTable",value:function(t,e){this._table.html(""),this._table.append(t),this._table.append(e),this._thead=t,this._tbody=e}},{key:"_renderTable",value:function(){if(this._rootElement.is("table"))this._rootElement.html(this._table.html());else{var t=this.engine.createElement("div",{className:"gs-table-container",append:this._table});this._rootElement=this.engine.render(t,this._rootElement)}}},{key:"_initStyles",value:function(){if(!this.options.responsive){var t=u()("<style></style>");t.attr("id","gs-table"),t.html(".gs-table-container .table{table-layout:fixed}@media(max-width:767px){.gs-table-container{overflow:auto;max-width:100%}}"),u()("head").append(t),this._styles=t}}},{key:"init",value:function(){this.emitLifeCycles("tableWillMount"),this._validateRootElement(),this._initDataset(),this._createTable(),this._validateColumns();var t=this._createCells(),e=t.thead,n=t.tbody;this._generateTable(e,n),this._renderTable(),this.createPagination(),this._bindSearchField(),this._initStyles(),this._isMounted=!0,this.emitLifeCycles("tableDidMount"),-1===this._cachedViewPort&&this.resizeSideEffect()}},{key:"_debounceUpdateTable",value:function(){this.debounceUpdateTable=k(this.updateTable,400)}},{key:"updateTable",value:function(){this._isUpdating||(this.emitLifeCycles("tableWillUpdate"),this._isUpdating=!0,this._renderHeader(this._thead),this._renderBody(this._tbody),this.createPagination(),this._isUpdating=!1,this.emitLifeCycles("tableDidUpdate"))}},{key:"updateCellHeader",value:function(){this._isUpdating||(this._isUpdating=!0,this.emitLifeCycles("tableWillUpdate"),this._renderHeader(this._thead),this._renderBody(this._tbody),this._isUpdating=!1,this.emitLifeCycles("tableDidUpdate"))}},{key:"resizeSideEffect",value:function(){var t=k(this.makeResponsive,500);window.addEventListener("resize",t.bind(this)),this.makeResponsive()}},{key:"makeResponsive",value:function(){var t,e=this.options.responsive,n=window.innerWidth,a=_(m(e),"desc");if(this.logError(d(e),"responsive",'Invalid type of responsive option provided: "%s"',e),b(a,function(e){parseInt(e,10)>n&&(t=e)}),this._cachedViewPort!==t){this._cachedViewPort=t;var i=e[t];d(i)?(this._cachedOption||(this._cachedOption=u.a.extend({},this.options)),this.options=u.a.extend(this.options,i),this.refresh()):this._cachedOption&&(this.options=u.a.extend({},this._cachedOption),this._cachedOption=null,this._cachedViewPort=-1,this.refresh())}}}]),t}());window.Pret=L(),window.TableSortable=O,window.DataSet=D,(s=jQuery).fn.tableSortable=function(t){return t.element=s(this),new window.TableSortable(t)},e.default=O}]);

/*
 * ddna_tabbed_table
 * version: 0.3.0
*/
(function ($, Drupal, drupalSettings) {

  /*
   * table-selectable
   * version: 0.0.1
   */
  !function(){var c,p,i,t,u,f,m,w,b,x=$("<div>").css({background:"rgba(135, 206, 235, .7)",border:"3px double","box-sizing":"content-box",display:"none","pointer-events":"none",position:"absolute","z-index":32767}).appendTo(document.body),s=$("<textarea>").css({"border-radius":0,margin:0,opacity:0,position:"absolute",top:-32767,"z-index":32767}).appendTo(document.body),n=!1,N=!1,h=!1,y=!1,g=$("<td>").css({border:"1px solid",padding:0,width:1}).appendTo($("<tr>").appendTo($("<table>").css({"border-collapse":"collapse",visibility:"hidden"}).appendTo(document.body))).innerWidth()-1,a=/chrome/i.test(navigator.userAgent)?"contextmenu":"mousedown";function r(){n=!1}function d(e){2===e.button&&e.pageX>m&&e.pageX<m+b+6&&e.pageY>w&&e.pageY<w+f+6&&(s.css({left:e.pageX,top:e.pageY}).select(),setTimeout(function(){s.css("top",-32767)}))}function l(e){this===c?($(i).css({cursor:"","user-select":""}),x.css("display","none")):L(this)}function I(){x.css("display","none")}function C(e){if($(i).css({cursor:"","user-select":""}).off({mouseenter:l,mouseleave:I}),i.contains(e.target)&&!c.contains(e.target)){for(var o,t,r=e.target;"td"!==r.nodeName.toLowerCase()&&"th"!==r.nodeName.toLowerCase()&&r!==i;)r=r.parentNode;function n(e){function o(e){return result=e.textContent.trim().replace(/\s+/g," "),-1!==result.indexOf('"')?'"'+result.replace(/"/g,'""')+'"':result}var t,n,s;return(y||N&&r.parentNode.rowIndex!==c.parentNode.rowIndex)&&!h?(s=Array.prototype.map.call(e.cells,o),y=!0):(n=r.cellIndex>c.cellIndex?(t=c.cellIndex,r.cellIndex):(t=r.cellIndex,c.cellIndex),s=Array.prototype.slice.call(e.cells,t,n+1).map(o)),s.join("\t")}"td"!==r.nodeName.toLowerCase()&&"th"!==r.nodeName.toLowerCase()||((h||N&&r.cellIndex!==c.cellIndex)&&!y?(t=Array.prototype.map.call(i.rows,n),h=!0):(e=r.parentNode.rowIndex>c.parentNode.rowIndex?(o=c.parentNode.rowIndex,r.parentNode.rowIndex):(o=r.parentNode.rowIndex,c.parentNode.rowIndex),t=Array.prototype.slice.call(i.rows,o,e+1).map(n)),s.val(t.join("\n")).select(),$(document.body).on(a,d))}}function L(e){$(i).css({cursor:"cell","user-select":"none"}).on("mouseleave",I),getSelection().collapseToStart();var o,t,n,s,r,a,d,l=$(e).offset();(h||N&&e.cellIndex!==c.cellIndex)&&!y?(f=$(i).innerHeight()-2,w=u.top+parseFloat($(i).css("border-top-width"))-2,"collapse"===$(i).css("border-collapse")&&(g?(f-=2,w+=1):--f)):(s=l.top>p.top?(o=e,t=l.top,n=c,p.top):(o=c,t=p.top,n=e,l.top),f=t-s+$(o).innerHeight()-2,w=s+parseFloat($(n).css("border-top-width"))-2,g&&"collapse"===$(i).css("border-collapse")&&(f+=1)),(y||N&&e.parentNode.rowIndex!==c.parentNode.rowIndex)&&!h?(m=u.left+parseFloat($(i).css("border-left-width"))-2,b=$(i).innerWidth()-2,"collapse"===$(i).css("border-collapse")&&(g?(m+=1,b-=2):--b)):(l=l.left>p.left?(r=c,a=p.left,d=e,l.left):(r=e,a=l.left,d=c,p.left),m=a+parseFloat($(r).css("border-left-width"))-2,b=l-a+$(d).innerWidth()-2,g&&"collapse"===$(i).css("border-collapse")&&(b+=1)),x.css({display:"",height:f,left:m,top:w,width:b})}$(document.body).on("mousedown",function(e){if(0===e.button)if(e.shiftKey&&!e.ctrlKey){if("td"===c.nodeName.toLowerCase()||"th"===c.nodeName.toLowerCase()){if(i.contains(e.target)&&!c.contains(e.target)){for(var o=e.target;"td"!==o.nodeName.toLowerCase()&&"th"!==o.nodeName.toLowerCase()&&o!==i;)o=o.parentNode;"td"===o.nodeName.toLowerCase()||"th"===o.nodeName.toLowerCase()?L(o):(x.css("display","none"),$(document.body).off(a,d))}else x.css("display","none"),$(document.body).off(a,d);$(i).on("mouseenter","td,th",l),$(document).one("mouseup",C)}}else if(x.css("display","none"),$(document.body).off(a,d),!e.shiftKey){for(c=e.target;"td"!==c.nodeName.toLowerCase()&&"th"!==c.nodeName.toLowerCase()&&c!==this;)c=c.parentNode;if("td"===c.nodeName.toLowerCase()||"th"===c.nodeName.toLowerCase()){for(p=$(c).offset(),i=c.parentNode;"table"!==i.nodeName.toLowerCase();)i=i.parentNode;e.ctrlKey||($(i).on("mouseenter","td,th",l),$(document).one("mouseup",C),clearTimeout(t),t=setTimeout(r,400),n?(N=!0,u=$(i).offset()):(N=!(n=!0),$(c).one("mouseleave",r))),h=y=!1}}})}();

  'use strict';

  var tables = [];
  var table_data_by_tab = [];
  var action_hide_timer;
  var active_action_frame;
  var pending_cell_selection;
  Drupal.ddnaTableInstances = tables;

  function updateHorizontalScrollShadows(container) {
    if (!container) {
      return;
    }

    var max_scroll = container.scrollWidth - container.clientWidth;
    container.classList.toggle('has-scroll-left', container.scrollLeft > 1);
    container.classList.toggle('has-scroll-right', max_scroll > 1 && container.scrollLeft < max_scroll - 1);
  }

  function watchHorizontalScroll(container) {
    if (!container || container.dataset.ddnaScrollShadowBound) {
      return;
    }

    container.dataset.ddnaScrollShadowBound = 'true';
    container.addEventListener('scroll', function () {
      updateHorizontalScrollShadows(container);
    }, { passive: true });
    if (typeof ResizeObserver !== 'undefined') {
      var resize_observer = new ResizeObserver(function () {
        updateHorizontalScrollShadows(container);
      });
      resize_observer.observe(container);
      if (container.firstElementChild) {
        resize_observer.observe(container.firstElementChild);
      }
    }
    window.requestAnimationFrame(function () {
      updateHorizontalScrollShadows(container);
    });
  }

  function updateSearchHighlights(search_value) {
    var normalized_search = search_value.toLowerCase();
    $('.table__filter--text-source').each(function (idx, element) {
      var cell_value = element.getAttribute('data-search-value') || '';
      element.classList.toggle('highlighted', normalized_search !== '' && cell_value.toLowerCase().includes(normalized_search));
    });
  }

  function getActiveTable() {
    var table_element = document.querySelector('.ddna-table-wrapper.active [data-table-json]');
    var table_index = table_element && table_element.id.match(/\d+/);
    return table_index ? tables[table_index[0]] : null;
  }

  function getCellConfiguration(table_index, row) {
    var machine_name;
    var config_name;
    var edit_url;
    var bundle_routes = {
      node: '/admin/structure/types/manage/{id}',
      taxonomy_term: '/admin/structure/taxonomy/manage/{id}',
      paragraph: '/admin/structure/paragraphs_type/{id}',
      media: '/admin/structure/media/manage/{id}',
      block_content: '/admin/structure/block-content/manage/{id}'
    };
    switch (Number(table_index)) {
      case 0:
        machine_name = row.block_id;
        config_name = 'block.block.' + row.block_id;
        edit_url = '/admin/structure/block/manage/' + encodeURIComponent(row.block_id);
        break;
      case 1:
        machine_name = row.machine_name;
        var bundle_prefixes = {
          node: 'node.type',
          taxonomy_term: 'taxonomy.vocabulary',
          paragraph: 'paragraphs.paragraphs_type',
          media: 'media.type',
          block_content: 'block_content.type'
        };
        config_name = bundle_prefixes[row.entity_type] ? bundle_prefixes[row.entity_type] + '.' + machine_name : null;
        edit_url = bundle_routes[row.entity_type] ? bundle_routes[row.entity_type].replace('{id}', encodeURIComponent(machine_name)) : null;
        break;
      case 2:
        machine_name = row.machine_name;
        config_name = 'field.field.' + row.entity_type + '.' + row.bundle + '.' + machine_name;
        var field_config = encodeURIComponent(row.entity_type + '.' + row.bundle + '.' + machine_name);
        var field_routes = {
          node: '/admin/structure/types/manage/{bundle}/fields/{field}',
          taxonomy_term: '/admin/structure/taxonomy/manage/{bundle}/overview/fields/{field}',
          paragraph: '/admin/structure/paragraphs_type/{bundle}/fields/{field}',
          media: '/admin/structure/media/manage/{bundle}/fields/{field}',
          block_content: '/admin/structure/block-content/manage/{bundle}/fields/{field}',
          user: '/admin/config/people/accounts/fields/{field}'
        };
        edit_url = field_routes[row.entity_type]
          ? field_routes[row.entity_type].replace('{bundle}', encodeURIComponent(row.bundle)).replace('{field}', field_config)
          : null;
        break;
      case 3:
        machine_name = row.machine_name;
        config_name = 'system.menu.' + machine_name;
        edit_url = '/admin/structure/menu/manage/' + encodeURIComponent(machine_name);
        break;
      case 4:
        machine_name = row.machine_name;
        config_name = 'views.view.' + machine_name;
        edit_url = '/admin/structure/views/view/' + encodeURIComponent(machine_name);
        break;
      case 5:
      case 6:
        machine_name = row.machine_name;
        config_name = 'image.style.' + machine_name;
        edit_url = '/admin/config/media/image-styles/manage/' + encodeURIComponent(machine_name);
        break;
      case 7:
        machine_name = row.machine_name;
        config_name = 'user.role.' + machine_name;
        edit_url = '/admin/people/roles/manage/' + encodeURIComponent(machine_name);
        break;
      case 8:
      case 9:
        machine_name = row.workflow_machine_name;
        config_name = 'workflows.workflow.' + machine_name;
        edit_url = '/admin/config/workflow/workflows/manage/' + encodeURIComponent(machine_name);
        break;
      case 10:
        machine_name = row.migrate_machine_name;
        config_name = 'migrate_plus.migration.' + machine_name;
        edit_url = row.migration_group && row.migration_group !== '-'
          ? '/admin/structure/migrate/manage/' + encodeURIComponent(row.migration_group) + '/migrations/' + encodeURIComponent(machine_name) + '/edit'
          : null;
        break;
      default:
        return null;
    }

    return {machineName: machine_name || null, configName: config_name || null, editUrl: edit_url || null};
  }

  function removeCellActionRail(frame) {
    if (!frame) {
      return;
    }
    var value_element = frame.querySelector('.table__filter--text-source');
    if (value_element) {
      value_element.removeAttribute('tabindex');
    }
    var rail = frame.querySelector('.ddna-cell-actions');
    if (rail) {
      rail.remove();
    }
    frame.classList.remove('ddna-actions-visible');
    if (active_action_frame === frame) {
      active_action_frame = null;
    }
  }

  function showCellActionRail(value_element) {
    var frame = value_element.closest('.ddna-cell-frame');
    if (!frame) {
      return;
    }
    window.clearTimeout(action_hide_timer);
    if (active_action_frame && active_action_frame !== frame) {
      var prior_value = active_action_frame.querySelector('.table__filter--text-source');
      if (prior_value) {
        prior_value.removeAttribute('tabindex');
      }
      removeCellActionRail(active_action_frame);
      var open_panel = document.querySelector('.ddna-cell-action-panel');
      if (open_panel) {
        open_panel.hidden = true;
      }
    }
    if (frame.querySelector('.ddna-cell-actions')) {
      active_action_frame = frame;
      return;
    }

    var action_attributes = {
      'data-table-index': value_element.dataset.tableIndex,
      'data-row-index': value_element.dataset.rowIndex,
      'data-cell-key': value_element.dataset.cellKey
    };
    var rail = document.createElement('div');
    rail.className = 'ddna-cell-actions';
    rail.setAttribute('role', 'group');
    rail.setAttribute('aria-label', 'Cell actions');
    [
      {className: 'filter', label: 'Search or filter this value', title: 'Search or filter this value', icon: '⌕'},
      {className: 'edit', label: 'Edit or copy this configuration', title: 'Edit or copy', icon: '⋯'}
    ].forEach(function (definition) {
      var button = document.createElement('button');
      button.type = 'button';
      button.className = 'ddna-cell-action-trigger ddna-cell-action-trigger--' + definition.className;
      button.setAttribute('aria-label', definition.label);
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('title', definition.title);
      Object.keys(action_attributes).forEach(function (attribute) {
        button.setAttribute(attribute, action_attributes[attribute]);
      });
      button.textContent = definition.icon;
      rail.appendChild(button);
    });
    frame.appendChild(rail);
    frame.classList.add('ddna-actions-visible');
    value_element.setAttribute('tabindex', '-1');
    active_action_frame = frame;
  }

  function getActionPanel() {
    var panel = document.querySelector('.ddna-cell-action-panel');
    if (panel) {
      return panel;
    }

    panel = document.createElement('div');
    panel.className = 'ddna-cell-action-panel';
    panel.setAttribute('role', 'menu');
    panel.hidden = true;
    panel.addEventListener('pointerenter', function () {
      window.clearTimeout(action_hide_timer);
    });
    panel.addEventListener('pointerleave', hideCellActionPanel);
    panel.addEventListener('click', function (event) {
      var action = event.target.closest('[data-ddna-action]');
      if (!action) {
        return;
      }
      if (action.dataset.ddnaAction === 'search' || action.dataset.ddnaAction === 'filter') {
        var input_id = action.dataset.ddnaAction === 'search' ? 'searchField' : 'filterField';
        var input = document.getElementById(input_id);
        if (input) {
          input.value = panel.dataset.value || '';
          input.dispatchEvent(new Event('input', {bubbles: true}));
          if (input_id === 'filterField') {
            var table = Drupal.ddnaTableInstances[panel.dataset.tableIndex];
            if (table) {
              table.lookUp(input.value);
            }
          }
          input.focus();
        }
        hideCellActionPanel();
      }
      else if (action.dataset.ddnaAction === 'copy') {
        copyText(action.dataset.copyValue || '');
      }
    });
    document.body.appendChild(panel);
    return panel;
  }

  function copyText(value) {
    var announcement = document.querySelector('.ddna-action-announcement');
    function announce() {
      if (announcement) {
        announcement.textContent = 'Copied to clipboard';
      }
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(value).then(announce).catch(function () {
        fallback_copy(value, announce);
      });
    }
    else {
      fallback_copy(value, announce);
    }
  }

  function fallback_copy(value, on_copy) {
    var textarea = document.createElement('textarea');
    textarea.value = value;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    textarea.remove();
    on_copy();
  }

  function hideCellActionPanel() {
    window.clearTimeout(action_hide_timer);
    action_hide_timer = window.setTimeout(function () {
      closeCellActionPanel();
    }, 130);
  }

  function closeCellActionPanel() {
    window.clearTimeout(action_hide_timer);
    var panel = document.querySelector('.ddna-cell-action-panel');
    if (panel) {
      panel.hidden = true;
    }
    document.querySelectorAll('.ddna-cell-action-trigger[aria-expanded="true"]').forEach(function (trigger) {
      trigger.setAttribute('aria-expanded', 'false');
    });
    removeCellActionRail(active_action_frame);
  }

  function positionActionPanel(panel, trigger) {
    panel.hidden = false;
    var trigger_rect = trigger.getBoundingClientRect();
    var panel_rect = panel.getBoundingClientRect();
    var left = Math.min(Math.max(8, trigger_rect.right + 6), window.innerWidth - panel_rect.width - 8);
    var top = trigger_rect.top;
    if (top + panel_rect.height > window.innerHeight - 8) {
      top = Math.max(8, window.innerHeight - panel_rect.height - 8);
    }
    panel.style.left = left + 'px';
    panel.style.top = top + 'px';
  }

  function openCellActionPanel(trigger) {
    window.clearTimeout(action_hide_timer);
    var panel = getActionPanel();
    var table_index = trigger.dataset.tableIndex;
    var row_index = Number(trigger.dataset.rowIndex);
    var cell_key = trigger.dataset.cellKey;
    var row = table_data_by_tab[table_index] && table_data_by_tab[table_index].rows[row_index];
    if (!row) {
      return;
    }

    panel.replaceChildren();
    panel.dataset.tableIndex = table_index;
    panel.dataset.value = row[cell_key] === null || typeof row[cell_key] === 'undefined' ? '' : String(row[cell_key]);
    if (trigger.classList.contains('ddna-cell-action-trigger--filter')) {
      panel.setAttribute('aria-label', 'Search and filter actions');
      addPanelButton(panel, 'Search for this value', 'search');
      addPanelButton(panel, 'Filter rows by this value', 'filter');
    }
    else {
      panel.setAttribute('aria-label', 'Configuration actions');
      var details = getCellConfiguration(table_index, row);
      if (details && details.editUrl) {
        var edit_link = document.createElement('a');
        edit_link.href = details.editUrl;
        edit_link.textContent = 'Edit configuration';
        edit_link.target = '_blank';
        edit_link.rel = 'noopener noreferrer';
        edit_link.setAttribute('role', 'menuitem');
        panel.appendChild(edit_link);
      }
      if (details && details.configName) {
        addPanelButton(panel, 'Copy config name', 'copy', details.configName);
      }
      if (details && details.machineName) {
        addPanelButton(panel, 'Copy machine name', 'copy', details.machineName);
      }
    }

    trigger.setAttribute('aria-expanded', 'true');
    positionActionPanel(panel, trigger);
  }

  function addPanelButton(panel, label, action, copy_value) {
    var button = document.createElement('button');
    button.type = 'button';
    button.dataset.ddnaAction = action;
    if (copy_value) {
      button.dataset.copyValue = copy_value;
    }
    button.setAttribute('role', 'menuitem');
    button.textContent = label;
    panel.appendChild(button);
  }

  function initCellActionPanel() {
    getActionPanel();
    document.addEventListener('pointerover', function (event) {
      var value_element = event.target.closest('.table__filter--text-source');
      if (value_element) {
        showCellActionRail(value_element);
      }
      var trigger = event.target.closest('.ddna-cell-action-trigger');
      if (trigger) {
        openCellActionPanel(trigger);
      }
    });
    document.addEventListener('pointerout', function (event) {
      var value_element = event.target.closest('.table__filter--text-source');
      if (value_element && !event.relatedTarget?.closest('.ddna-cell-frame, .ddna-cell-action-panel')) {
        hideCellActionPanel();
      }
    });
    document.addEventListener('pointerout', function (event) {
      if (event.target.closest('.ddna-cell-action-trigger') &&
        !event.relatedTarget?.closest('.ddna-cell-action-trigger, .ddna-cell-action-panel')) {
        hideCellActionPanel();
      }
    });
    document.addEventListener('focusin', function (event) {
      var value_element = event.target.closest('.table__filter--text-source');
      if (value_element) {
        showCellActionRail(value_element);
      }
      var trigger = event.target.closest('.ddna-cell-action-trigger');
      if (trigger) {
        openCellActionPanel(trigger);
      }
    });
    document.addEventListener('focusout', function (event) {
      var value_element = event.target.closest('.table__filter--text-source');
      if (value_element && !event.relatedTarget?.closest('.ddna-cell-frame, .ddna-cell-action-panel')) {
        hideCellActionPanel();
      }
      if (event.target.closest('.ddna-cell-action-trigger') &&
        !event.relatedTarget?.closest('.ddna-cell-action-panel')) {
        hideCellActionPanel();
      }
    });
    document.addEventListener('click', function (event) {
      var trigger = event.target.closest('.ddna-cell-action-trigger');
      if (trigger) {
        event.preventDefault();
        openCellActionPanel(trigger);
      }
    });
    window.addEventListener('scroll', hideCellActionPanel, true);
    window.addEventListener('resize', hideCellActionPanel);
  }

  function getReaderCell(target) {
    return target && target.closest ? target.closest('.ddna-reader-focus') : null;
  }

  function clearReaderSelection() {
    document.querySelectorAll('.ddna-reader-focus.is-selected').forEach(function (cell) {
      cell.classList.remove('is-selected');
      cell.removeAttribute('aria-selected');
    });
    closeCellActionPanel();
  }

  function selectReaderRange(start_cell, end_cell) {
    if (!start_cell || !end_cell || start_cell.closest('tr') !== end_cell.closest('tr')) {
      return;
    }

    document.querySelectorAll('.ddna-reader-focus.is-selected').forEach(function (cell) {
      cell.classList.remove('is-selected');
      cell.removeAttribute('aria-selected');
      cell.removeAttribute('tabindex');
    });

    var cells = Array.prototype.slice.call(start_cell.closest('tr').querySelectorAll('.ddna-reader-focus'));
    var start_index = cells.indexOf(start_cell);
    var end_index = cells.indexOf(end_cell);
    if (start_index < 0 || end_index < 0) {
      return;
    }

    var first_index = Math.min(start_index, end_index);
    var last_index = Math.max(start_index, end_index);
    for (var index = first_index; index <= last_index; index++) {
      cells[index].classList.add('is-selected');
      cells[index].setAttribute('aria-selected', 'true');
      cells[index].setAttribute('tabindex', '0');
    }
  }

  function initReaderCellSelection() {
    document.addEventListener('pointerdown', function (event) {
      var cell = getReaderCell(event.target);
      if (!cell || event.button !== 0 || event.target.closest('button, a, input, select')) {
        pending_cell_selection = null;
        return;
      }

      pending_cell_selection = {
        cell: cell,
        row: cell.closest('tr'),
        pointerId: event.pointerId,
        moved: false
      };
    });

    document.addEventListener('pointermove', function (event) {
      if (!pending_cell_selection || pending_cell_selection.pointerId !== event.pointerId) {
        return;
      }
      var cell = getReaderCell(document.elementFromPoint(event.clientX, event.clientY));
      if (cell && cell.closest('tr') === pending_cell_selection.row && cell !== pending_cell_selection.cell) {
        pending_cell_selection.moved = true;
      }
    });

    document.addEventListener('pointerup', function (event) {
      if (!pending_cell_selection || pending_cell_selection.pointerId !== event.pointerId) {
        return;
      }

      var selection = pending_cell_selection;
      pending_cell_selection = null;
      var end_cell = getReaderCell(document.elementFromPoint(event.clientX, event.clientY)) || selection.cell;
      selectReaderRange(selection.cell, end_cell);
    });

    document.addEventListener('pointercancel', function () {
      pending_cell_selection = null;
    });
  }

  function initDisplaySettings() {
    var root = document.querySelector('.ddna-tabs-container');
    if (!root) {
      return;
    }

    var defaults = {contrastFocus: false, redTone: 'yellow', fontSize: 'medium'};
    try {
      defaults = Object.assign(defaults, JSON.parse(localStorage.getItem('ddna-display-settings') || '{}'));
    }
    catch (error) {
      defaults = {contrastFocus: false, redTone: 'yellow', fontSize: 'medium'};
    }

    var contrast_checkbox = document.getElementById('ddna-contrast-focus');
    var tone_select = document.getElementById('ddna-focus-red-tone');
    var font_select = document.getElementById('ddna-font-size');

    function update() {
      var preferences = {
        contrastFocus: contrast_checkbox.checked,
        redTone: tone_select.value,
        fontSize: font_select.value
      };
      root.dataset.fontSize = preferences.fontSize;
      root.classList.toggle('ddna-contrast-focus', preferences.contrastFocus);
      tone_select.disabled = !preferences.contrastFocus;

      var hue_by_tone = {yellow: 12, green: 34, blue: 330};
      var hue = hue_by_tone[preferences.redTone] || hue_by_tone.yellow;
      var base_saturation = 90;
      var main_saturation = base_saturation - 11;
      var first_pastel_saturation = Math.min(100, base_saturation + 5);
      var second_pastel_saturation = Math.min(100, base_saturation + 18);
      root.style.setProperty('--ddna-focus-red', 'hsl(' + hue + ' ' + main_saturation + '% 49%)');
      root.style.setProperty('--ddna-focus-pastel-one', 'hsl(260 ' + first_pastel_saturation + '% 87%)');
      root.style.setProperty('--ddna-focus-pastel-two', 'hsl(' + ((hue + 18) % 360) + ' ' + second_pastel_saturation + '% 91%)');
      var table_widths = {
        small: ['1450px', '105vw', '1900px'],
        medium: ['1600px', '115vw', '2200px'],
        large: ['1800px', '125vw', '2600px']
      }[preferences.fontSize] || ['1600px', '115vw', '2200px'];
      root.style.setProperty('--ddna-table-width-min', table_widths[0]);
      root.style.setProperty('--ddna-table-width-mid', table_widths[1]);
      root.style.setProperty('--ddna-table-width-max', table_widths[2]);
      try {
        localStorage.setItem('ddna-display-settings', JSON.stringify(preferences));
      }
      catch (error) {
        // Keep the selected settings for the current page when storage is blocked.
      }
    }

    contrast_checkbox.checked = Boolean(defaults.contrastFocus);
    tone_select.value = defaults.redTone;
    font_select.value = defaults.fontSize;
    contrast_checkbox.addEventListener('change', update);
    tone_select.addEventListener('change', update);
    font_select.addEventListener('change', update);
    update();
  }

  function renderActiveTable(tab) {
    var active_wrapper = document.querySelector('.ddna-table-wrapper.active');
    var table_element = active_wrapper && active_wrapper.querySelector('[data-table-json]');
    if (!table_element) {
      return;
    }

    var active_table_data;
    try {
      active_table_data = JSON.parse(table_element.getAttribute('data-table-json'));
    }
    catch (error) {
      console.error('Unable to parse ddna table data.', error);
      return;
    }

    if (!active_table_data.rows || !active_table_data.headers) {
      return;
    }
    table_data_by_tab[tab] = active_table_data;
    var table_rows = active_table_data.rows;
    var row_indices = new WeakMap();
    table_rows.forEach(function (row, index) {
      if (row && typeof row === 'object') {
        row_indices.set(row, index);
      }
    });

    tables[tab] = $('#js-table-' + tab).tableSortable({
      data: active_table_data.rows,
      columns: active_table_data.headers,
      searchField: '#filterField',
      formatCell: function(row, key) {
        var value = row[key] === null || typeof row[key] === 'undefined' ? '' : String(row[key]);
        var row_index = row_indices.get(row);
        var el = $('<div></div>')
          .addClass('table__filter--text-source ddna-reader-focus')
          .attr('role', 'group')
          .attr('data-table-index', tab)
          .attr('data-row-index', row_index)
          .attr('data-cell-key', key)
          .attr('data-search-value', value);
        var parsed_json = null;
        var is_json = false;
        try {
          parsed_json = JSON.parse(value);
          is_json = parsed_json !== null && typeof parsed_json === 'object';
        }
        catch (error) {
          is_json = false;
        }

        if (is_json) {
          var json_button = $('<button type="button" class="ddna-json-value-button">View JSON</button>');
          json_button.attr('aria-label', 'View JSON value for ' + key);
          json_button[0].dataset.jsonValue = value;
          el.append(json_button);
        }
        else {
          var preview_limit = 'access content, access environment indicator ribbon, access sitemap,'.length;
          if (value.length > preview_limit) {
            el.addClass('ddna-text-preview-trigger')
              .attr('data-preview-text', value)
              .attr('tabindex', '0')
              .attr('aria-label', value)
              .text(value.slice(0, preview_limit) + '...');
          }
          else {
            el.text(value);
          }
        }

        var search_value = $('#searchField').val();
        if (search_value && value === search_value) {
          el.addClass('highlighted');
        }

        return $('<div class="ddna-cell-frame"></div>').append(el);
      },
      rowsPerPage: active_table_data.rows.length,
      pagination: true,
      tableWillMount: function () {
      },
      tableDidMount: function () {
        watchHorizontalScroll(this._rootElement[0].closest('.ddna-table-container'));
      },
      tableWillUpdate: function () {
        clearReaderSelection();
      },
      tableDidUpdate: function () {
        clearReaderSelection();
        watchHorizontalScroll(this._rootElement[0].closest('.ddna-table-container'));
      },
      tableWillUnmount: function () {
      },
      tableDidUnmount: function () {
      },
      onPaginationChange: function (nextPage, setPage) {
        setPage(nextPage);
      }
    });
  }

  function initTabs(elem) {
    $(elem + ' .t-btn').click(function (e) {
      var tab_button = e.currentTarget;
      var tab_name = tab_button.getAttribute('data-name');
      var active_wrapper = document.querySelector('.ddna-table-wrapper.active');
      var new_wrapper = tab_name ? document.querySelector('.ddna-table-wrapper.' + tab_name) : null;
      if (tab_button.classList.contains('active') || !active_wrapper || !new_wrapper) {
        return;
      }

      closeCellActionPanel();
      findActiveElementAndRemoveIt(elem + ' .t-btn');
      findActiveElementAndRemoveIt(elem + ' .t-panel');
      setTimeout(function () {
        active_wrapper.classList.remove('active');
        new_wrapper.classList.add('active');
        tab_button.classList.add('active');
        var tab_index = tab_name.match(/\d+/);
        if (tab_index) {
          renderActiveTable(tab_index[0]);
        }
      }, 200);
    });
  }

  function findActiveElementAndRemoveIt(elem) {
    var elementList = document.querySelectorAll(elem);
    Array.prototype.forEach.call(elementList, function (e) {
      e.classList.remove('active');
    });
  }

  var module_initialized = false;
  Drupal.behaviors.ddna_tabbed_table = {
    attach: function (context, settings) {
      if (module_initialized) {
        return;
      }

      // var action_context_handler = function (evt) {
      //   console.log(evt);
      //   // if (this === anchor) {
      //   //   $(table).css({
      //   //     cursor: '',
      //   //     'user-select': '' });
      //   //
      //   //   $cellection.css('display', 'none');
      //   // } else {
      //   //   redraw(this);
      //   // }
      // }
      // $('table tbody tr td div span').on('mouseenter', action_context_handler);

      module_initialized = true;
      initTabs('.ddna-tabbed-table.ddna-tabbed-table--horizontal');
      initDisplaySettings();
      initCellActionPanel();
      initReaderCellSelection();
      var active_table = document.querySelector('.ddna-table-wrapper.active [data-table-json]');
      var active_tab_index = active_table && active_table.id.match(/\d+/);
      if (active_tab_index) {
        renderActiveTable(active_tab_index[0]);
      }
      $('.ddna-filter-input').on('input', function () {
        var clear_button = document.querySelector('[data-clear-filter="' + this.id + '"]');
        if (clear_button) {
          clear_button.hidden = this.value === '';
        }
        if (this.id === 'searchField') {
          updateSearchHighlights(this.value);
        }
        else if (this.id === 'filterField') {
          clearReaderSelection();
        }
      });
      $('.ddna-filter-clear').on('click', function () {
        var field = document.getElementById(this.getAttribute('data-clear-filter'));
        if (!field) {
          return;
        }

        field.value = '';
        $(field).trigger('input');
        if (field.id === 'filterField') {
          var active_table_instance = getActiveTable();
          if (active_table_instance) {
            active_table_instance.lookUp('');
          }
        }
        field.focus();
      });
    }
  }
}(jQuery, Drupal, drupalSettings));
