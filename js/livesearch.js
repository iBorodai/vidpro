var liveSearch={
	regTrim: /(<[^>]+>)|(^\s+)|(\s+$)|(\t+)|(\r+)|(\n+)|((\r\n)+)/img,
	reg0: /[\-\+=_\/\\`";\.,'\(\)\*\?!@#$%^&<>№~\[\]\{\}\|]/gm,
	init:function(el,opt){
		$.extend(true,{
			search_url:false,
			currReq:'',
			nabor:null,
			nActive:false,
			activeLi:-1,
			resLength:0,
			resultOver:0,
			searchBlur:1,
			limit:7,
			mode:'',
			attr_set: 'name',
			query:{},
			callback:null//function(resultQuery,inputSearchElement){}
		},opt);
		
		if(!opt.search_url) return false;

		var attrs='';
		var attrs_get=opt.attr_set.split(',');
		for( var i=0; i<attrs_get.length; i++ ){
			var av=$(el).attr( attrs_get[i] );
			if( typeof( av )!='undefined' )	attrs+=' '+attrs_get[i]+'="'+av+'"';
		}
		
		var ls=$('<div class="liveSearch "><div class="relative"><input type="text" liveSearch="liveSearch" autocomplete="off" '+attrs+'><div class="searchFormHelper"></div></div><div class="resDiv" style="display: none;"></div></div>');
		$(el).replaceWith(ls);
		el=$('input[liveSearch]',ls)[0];
		el.liveSearch=opt;
		el.liveSearch.results=$(el).parents('.liveSearch:first').find('.resDiv:eq(0)');
		el.liveSearch.helper=$(el).parents('.liveSearch:first').find('.searchFormHelper:eq(0)');
		el.liveSearch.helper.click(function(){
			el.liveSearch.helper.hide(0);
			el.liveSearch.results.hide(0);
			el.val('').blur();		
		});
		el.liveSearch.checkField=setInterval(function(){
			var $this=$(el);
			if( (typeof(el.liveSearch.make_query)+'').toLowerCase()=='function' ){
			  //Задан метод - построение запроса ajax
			  var query=new el.liveSearch.make_query(el);
			  var qjsprt='',qjsprt_obj=query; for(var qjspri in qjsprt_obj) qjsprt+="\n"+qjspri+' = '+qjsprt_obj[qjspri];
				var query_str=qjsprt;
			}else{
				//Метод не задан - просто взять значение
			  var query=$this.val().replace(liveSearch.regTrim,'');
			  var query_str=query;
			}
			if( query_str !=$this.attr('rel') && !el.liveSearch.nActive) {
				$this.attr('rel',query_str);
				liveSearch.get(el,query);
			}
		},300);
		el.onkeyup=function(evt) {
			evt = (evt) ? evt : ((window.event) ? event : null);
			if (evt) {
				liveSearch.writing(el);
				switch (evt.keyCode) {
					case 38:
							if(!resLength) return;
							el.liveSearch.activeLi--;
							if(el.liveSearch.activeLi<0) el.liveSearch.activeLi=el.liveSearch.resLength-1;
							break;
					case 40:
							if(!resLength) return;
							el.liveSearch.activeLi++;
							if(el.liveSearch.activeLi>=el.liveSearch.resLength) el.liveSearch.activeLi=0;
							break;
					case 13:
							if(!el.liveSearch.resLength) return true;
							var e=$('li',el.liveSearch.results).eq(el.liveSearch.activeLi).find('a:first');
							if(e.length) window.location=e.get(0);
							return false;
							break;
					default:
							return true;
				}
				if(el.liveSearch.resLength){
						$('li',el.liveSearch.results).removeClass('active');
						$('li',el.liveSearch.results).eq(el.liveSearch.activeLi).addClass('active');
				}
			}
		};
		el.onkeypress=function(evt) {
				evt = (evt) ? evt : ((window.event) ? event : null);
				if (evt) {
					liveSearch.writing(el);
				}
		};
		el.onkeydown=function(evt) {
				evt = (evt) ? evt : ((window.event) ? event : null);
				if (evt) {
					liveSearch.writing(el);
				}
		};
		$(el).focus(function(){
				if($(this).val()!='') this.liveSearch.results.show();
				el.liveSearch.helper.show();
				this.liveSearch.searchBlur=0;
		}).blur(function(){
				if(!this.liveSearch.resultOver){
					this.liveSearch.results.hide();
					this.liveSearch.helper.hide();
				}
				this.liveSearch.searchBlur=1;
		});
		el.liveSearch.results.mouseenter(function(){
			el.liveSearch.resultOver=1;
		})
		.mouseleave(function(){
			el.liveSearch.resultOver=0;
				if(el.liveSearch.searchBlur) $(el).blur();
		});
	},
	writing: function(el){
		el.liveSearch.nActive=true;
		clearInterval(el.liveSearch.nabor);
		el.liveSearch.nabor=setTimeout(function(){
				clearInterval(el.liveSearch.nabor);
				el.liveSearch.nabor=null;
				el.liveSearch.nActive=false;
		},300);
	},
	get:function(e,el){
		if(!el || el=='') {
			e.liveSearch.currReq='';
			e.liveSearch.results.hide();
			e.liveSearch.helper.hide();
			return;
		}

		if(e.liveSearch.currReq==el) return;
		var req = new JsHttpRequest();
		var limit=e.liveSearch.limit;
		e.liveSearch.currReq=el;
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
			    console.log(req,e.liveSearch.currReq);
					if(req.responseJS && req.responseJS.val && req.responseJS.val==e.liveSearch.currReq.query) {
						if(req.responseJS.content) {
							var words=el.query;
							words=words.split(' ');
							var words_=new Array();
							var finded={};
							e.liveSearch.results.html(req.responseJS.content);
							var text=$('ul:first',e.liveSearch.results).html();
							if(req.responseJS.count){
								if(words && text){

									for(i in words) {
										if(words[i] && words[i]!='' && !liveSearch.in_array(words[i],words_)) {
											words_.push(words[i]);
											var reg=new RegExp('[^>]*'+words[i]+'[^<]*','igm');
											var reg3=new RegExp(words[i],'igm');
											var reg_tag=new RegExp('<[^<>]*>','igm');
											var matches = text.match( reg );
											var torepl=new Array();
											if(matches) for(j in matches){
												if(j>=0){
													matches[j]=matches[j].toString().replace(reg_tag,'').replace(liveSearch.regTrim,'');
													if(matches[j]!=''){
														if(!finded[matches[j]]) finded[matches[j]]=matches[j];
														var m = matches[j].match( reg3 );
														torepl[j]=finded[matches[j]];
														if(m) for(l in m){
															if(l>=0){
																torepl[j]=torepl[j].replace(new RegExp('(?!<!>)'+m[l]+'(?!</!>)','gm'),'<!>'+m[l]+'</!>');
															}
														}
														finded[matches[j]]=torepl[j];
													}
												}
											}
										}
									}
									var nodes=$('ul:first *',e.liveSearch.results);
									var regReplace=['?','(',')','[',']','{','}','+','|','^','$','.'];
									for(i in finded) {
											finded[i]=finded[i].replace(/<!>/gm,'<span>').replace(/<\/!>/gm,'</span>');
											nodes.each(function(){
													if(!$(this).children().length){
															var ii=i.replace(/\\/gm,'\\\\');
															for(jj in regReplace) ii=ii.replace(new RegExp('\\'+regReplace[jj],'gm'),'\\'+regReplace[jj]);
														$(this).html($(this).text().replace(new RegExp('^'+ii+'$','gm'),finded[i]));
													}
											});
									}
								}
							}
							e.liveSearch.results.show();

							e.liveSearch.helper.removeClass('loading');
							$('ul:first li',e.liveSearch.results).each(function(i){$(this).attr('rel',i);});
						}	else {
							e.liveSearch.results.hide().html('');
								e.liveSearch.helper.hide();
						}
						e.liveSearch.activeLi=-1;
						req.responseJS.count=parseInt(req.responseJS.count);
						e.liveSearch.resLength=req.responseJS.count>e.liveSearch.limit?e.liveSearch.limit:req.responseJS.count;
						if(req.responseJS.count<=e.liveSearch.limit) $('ul:last',e.liveSearch.results).hide();

						if(e.liveSearch.callback && typeof(e.liveSearch.callback)=='function') e.liveSearch.callback(req.responseJS,e);
				}
				if(req.responseText!='') alert(req.responseText);
			}
		}
		req.open(null, e.liveSearch.search_url, true);
		e.liveSearch.helper.addClass('loading').show();
		req.send( {mode:e.liveSearch.mode,val:el,limit:e.liveSearch.limit,from_pg:window.location.href,query:e.liveSearch.query} );
	},
	in_array:function (what, where) {
		for(var i=0; i<where.length; i++)
			if(what == where[i])
				return true;
		return false;
	},
	liHover:function (el){
		if(!el) return false;
		var e=$(el).parents('.liveSearch:first').find('input[liveSearch]')
		if(!e.length) return false;
		e=e[0];
		e.liveSearch.activeLi=$(el).attr('rel');
		$(el).parent().children().removeClass('active');
		$(el).addClass('active');
	}
};