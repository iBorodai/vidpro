var quotes=[
		    {
					text:'Даже если ты один против всех &ndash;<br>это не значит, что ты не прав!',
					ill:'/img/stub/q1.png',
					sign:'Хью Лорри',
				},{
					text:'Если я попался вам навстречу &ndash;<br> значит вам со мной не попути',
					ill:'/img/stub/q2.png',
					sign:'Алексей Романов',
				},{
					text:'Ну и рожа у тебя, <br>Шарапов!',
					ill:'/img/stub/q3.png',
					sign:'Глеб Жиглов',
				},{
					text:'Жизнь &ndash; это то, что с тобой происходит, в то время как ты планируешь что-то другое.',
					ill:'/img/stub/q4.png',
					sign:'John Lenon',
				},{
					text:'То, что приятно сделать один раз, будет приятно сделать еще 100 раз. Потому из музыки меня так просто не попрешь!',
					ill:'/img/stub/q5.png',
					sign:'Mick Jagger',
				}
			];
			function switch_quote(){
			  var tst=( Math.round( (quotes.length-1) *Math.random()) );

			  if(quotes.length>1) while(tst==last_quote) tst=( Math.round( (quotes.length-1) *Math.random()) );
			  last_quote=tst;

			  var tb=$('#quote');
				tb.stop( true, true ).animate({opacity:0},300,function(){
				  $('#quote_text',tb).html( quotes[tst].text );
				  $('#sign',tb).html( quotes[tst].sign );
				  $('#ill',tb).attr('src', quotes[tst].ill );
				  if( !tb.hasClass('inited') ){
				    tb.css('visibility','visible');
				    tb.addClass('inited');
					}
          tb.animate({opacity:1},500);
				});
			}
			var last_quote=false;
		  $(document).ready(function(){
        switch_quote();
        $('#quote_reload').click(function(){
          switch_quote();
          return false;
				});
				$('#form_open').click(function(){
				  $('#login_form').show();
				  return false;
				});
				$('#form_close').click(function(){
				  $('#login_form').hide();
				  return false;
				});

			});