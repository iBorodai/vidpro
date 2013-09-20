//search
$(document).ready(function(){
	checkField=setInterval(function(){
    	var val=$('#search').val();
        if(val!=$('#search').attr('rel') && !nActive) {
            $('#search').attr('rel',val.replace(reg0,' ').replace(regTrim,''));
            goodsSearch(val);
        }
    },300);
    document.getElementById('search').onkeyup=function(evt) {
        evt = (evt) ? evt : ((window.event) ? event : null);
        if (evt) {
            writing();
            switch (evt.keyCode) {
                case 38:
                    if(!resLength) return;
                    activeLi--;
                    if(activeLi<0) activeLi=resLength-1;
                    break;
                case 40:
                    if(!resLength) return;
                    activeLi++;
                    if(activeLi>=resLength) activeLi=0;
                    break;
                case 13:
                    return true;
					if(!resLength) return true;
                    var el=$('#results li').eq(activeLi).find('a:first');
                    if(el.length) window.location=el.get(0);
                    return false;
                    break;
                default:
                    return true;
            }
            if(resLength){
                $('#results li').removeClass('active');
                $('#results li').eq(activeLi).addClass('active');
            }
        }
    };
    document.getElementById('search').onkeypress=function(evt) {
        evt = (evt) ? evt : ((window.event) ? event : null);
        if (evt) {
            writing();
        }
    };
    document.getElementById('search').onkeydown=function(evt) {
        evt = (evt) ? evt : ((window.event) ? event : null);
        if (evt) {
            writing();
        }
    };
    $('#search').focus(function(){
        if($('#search').val()!='') $('#results').css('display','block');
        $('#searchFormHelper').css('display','block');
        searchBlur=0;
    }).blur(function(){
        if(!resultOver){
            $('#results').css('display','none');
            $('#searchFormHelper').css('display','none');
        }
        searchBlur=1;
    });
    $('#results').mouseenter(function(){resultOver=1;})
    .mouseleave(function(){
        resultOver=0;
        if(searchBlur) $('#search').blur();
    });
});

function writing(){
    nActive=true;
    clearInterval(nabor);
    nabor=setTimeout(function(){
        clearInterval(nabor);
        nabor=null;
        nActive=false;
    },300);
}

var checkField=null,currReq='',nabor=null,nActive=false;
var regTrim=/(<[^>]+>)|(^\s+)|(\s+$)|(\t+)|(\r+)|(\n+)|((\r\n)+)/img;
var reg0=/[\-\+=_\/\\`";\.,'\(\)\*\?!@#$%^&<>¹~\[\]\{\}\|]/gm;
function goodsSearch(el){
    if(!el || el=='') {
        currReq='';
        $('#results,#searchFormHelper').css('display','none');
        return;
    }
    el=el.replace(reg0,' ').replace(regTrim,'');
    if(currReq==el) return;
    var req = new JsHttpRequest();
    var limit=10;
    currReq=el;
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.responseJS && req.responseJS.val && req.responseJS.val==currReq) {
                if(req.responseJS.content) {
                    var words=el;
                    words=words.split(' ');
                    var words_=new Array();
                    var finded={};
                    $('#results').html(req.responseJS.content);
                    var text=$('#resultList').html();
                    if(req.responseJS.count) {
                        if(words && text){
                                for(i in words) {
                                if(words[i] && words[i]!='' && !in_array(words[i],words_)) {
                                    words_.push(words[i]);
                                    var reg=new RegExp('[^>]*'+words[i]+'[^<]*','igm');
                                    var reg3=new RegExp(words[i],'igm');
                                    var reg_tag=new RegExp('<[^<>]*>','igm');
                                    var matches = text.match( reg );
                                    var torepl=new Array();
                                    if(matches) for(j in matches){
                                        if(j>=0){
                                            matches[j]=matches[j].toString().replace(reg_tag,'').replace(regTrim,'');
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
                            var nodes=$('#resultList *');
                            var regReplace=['?','(',')','[',']','{','}','+','|','^','$','.'];
                            for(i in finded) {
                                finded[i]=finded[i].replace(/<!>/gm,'<span>').replace(/<\/!>/gm,'</span>');
                                nodes.each(function(){
                                    if(!$(this).children().length){
                                        var ii=i.replace(/\\/gm,'\\\\');
                                        for(jj in regReplace) ii=ii.replace(new RegExp('\\'+regReplace[jj],'gm'),'\\'+regReplace[jj]);
                                    	//var ii=i.replace(/\?/gm,'\\?').replace(/\(/gm,'\\(').replace(/\)/gm,'\\)');
                                        //if(this.nodeName=='A') alert($(this).text()+': '+ii+' -> '+finded[i]);
                                    	$(this).html($(this).text().replace(new RegExp('^'+ii+'$','gm'),finded[i]));
                                    }
                                });
                                //text=text.replace(new RegExp(i,'gm'),finded[i]);
                            }
                        }
                    }
                    $('#results').css('display','block');
                    $('#searchFormHelper').removeClass('loading');
                    $('#resultList li').each(function(i){$(this).attr('rel',i);});
                }
                else {
                    $('#results').css('display','none').html('');
                    $('#searchFormHelper').css('display','none');
                }
                activeLi=-1;
                req.responseJS.count=parseInt(req.responseJS.count);
                resLength=req.responseJS.count>limit?limit:req.responseJS.count;
                if(req.responseJS.count<=limit) $('#results ul:last').css('display','none');
            }
            if(req.responseText!='') alert(req.responseText);
        }
    }
    
    var lang=$('#lang').text();
	lang=(lang=='')?'':'/'+lang;
	req.open(null, lang+'/ajax/', true);
	$('#searchFormHelper').addClass('loading').show(0);
	req.send( {mode:'search',val:el,limit:limit} );
}
var activeLi=-1,resLength=0,resultOver=0,searchBlur=1;
function liHover(el){
    if(!el) return false;
    activeLi=$(el).attr('rel');
    $(el).parent().children().removeClass('active');
    $(el).addClass('active');
}
function in_array(what, where) {
    for(var i=0; i<where.length; i++)
        if(what == where[i]) 
            return true;
    return false;
}