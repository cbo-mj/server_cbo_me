!function(t){t.fn.drawDoughnutChart=function(e,n){function a(t,e){var n=-1.57,a=4.7131,o=g+y(n)*t,i=v+T(n)*t,r=g+y(n)*e,s=v+T(n)*e,u=g+y(a)*t,m=v+T(a)*t,l=g+y(a)*e,p=v+T(a)*e,f=["M",o,i,"A",t,t,0,1,1,u,m,"Z","M",l,p,"A",e,e,0,1,0,r,s,"Z"];return f=f.join(" ")}function o(n){var a=t(this).data().order;q.text(e[a].title+": "+e[a].value).fadeIn(200),x.onPathEnter.apply(t(this),[n,e])}function i(n){q.hide(),x.onPathLeave.apply(t(this),[n,e])}function r(t){q.css({top:t.pageY+x.tipOffsetY,left:t.pageX-q.width()/2+x.tipOffsetX})}function s(t){var n=-C/2,o=1;if(x.animation&&x.animateRotate&&(o=t),u(t,F),R.attr("opacity",t),1===e.length&&4.7122<o*(e[0].value/F)*2*C+n)return void O[0].attr("d",a(E,N));for(var i=0,r=e.length;r>i;i++){var s=o*(e[i].value/F)*2*C,m=n+s,l=(m-n)%(2*C)>C?1:0,p=g+y(n)*E,f=v+T(n)*E,d=g+y(n)*N,c=v+T(n)*N,h=g+y(m)*E,w=v+T(m)*E,b=g+y(m)*N,S=v+T(m)*N,A=["M",p,f,"A",E,E,0,l,1,h,w,"L",b,S,"A",N,N,0,l,0,d,c,"Z"];O[i].attr("d",A.join(" ")),n+=s}}function u(t,e){P.css({opacity:t}).text((e*t).toFixed(1))}function m(t,e){var n=x.animation?d(k(t),null,0):1;e(n)}function l(t){var e=x.animation?1/d(x.animationSteps,Number.MAX_VALUE,1):1,n=x.animation?0:1;S(function(){n+=e,m(n,t),1>=n?S(arguments.callee):x.afterDrawed.call(c)})}function p(t){return Math.min.apply(null,t)}function f(t){return!isNaN(parseFloat(t))&&isFinite(t)}function d(t,e,n){return f(e)&&t>e?e:f(n)&&n>t?n:t}var c=this,h=c.width(),w=c.height(),g=h/2,v=w/2,y=Math.cos,T=Math.sin,C=Math.PI,x=t.extend({segmentShowStroke:!0,segmentStrokeColor:"#0C1013",segmentStrokeWidth:1,baseColor:"rgba(0,0,0,0.5)",baseOffset:4,edgeOffset:10,percentageInnerCutout:75,animation:!0,animationSteps:90,animationEasing:"easeInOutExpo",animateRotate:!0,tipOffsetX:-8,tipOffsetY:-45,tipClass:"doughnutTip",summaryClass:"doughnutSummary",summaryTitle:"TOTAL:",summaryTitleClass:"doughnutSummaryTitle",summaryNumberClass:"doughnutSummaryNumber",beforeDraw:function(){},afterDrawed:function(){},onPathEnter:function(){},onPathLeave:function(){}},n),b={linear:function(t){return t},easeInOutExpo:function(t){var e=.5>t?8*t*t*t*t:1-8*--t*t*t*t;return e>1?1:e}},S=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(t){window.setTimeout(t,1e3/60)}}();x.beforeDraw.call(c);var A=t('<svg width="'+h+'" height="'+w+'" viewBox="0 0 '+h+" "+w+'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>').appendTo(c),O=[],k=b[x.animationEasing],E=p([w/2,h/2])-x.edgeOffset,N=E*(x.percentageInnerCutout/100),F=0,M=E+x.baseOffset,I=N-x.baseOffset;t(document.createElementNS("http://www.w3.org/2000/svg","path")).attr({d:a(M,I),fill:x.baseColor}).appendTo(A);var R=t(document.createElementNS("http://www.w3.org/2000/svg","g"));R.attr({opacity:0}).appendTo(A);for(var q=t('<div class="'+x.tipClass+'" />').appendTo("body").hide(),D=(q.width(),q.height(),2*(N-(E-N))),L=t('<div class="'+x.summaryClass+'" />').appendTo(c).css({width:D+"px",height:D+"px","margin-left":-(D/2)+"px","margin-top":-(D/2)+"px"}),P=(t('<p class="'+x.summaryTitleClass+'">'+x.summaryTitle+"</p>").appendTo(L),t('<p class="'+x.summaryNumberClass+'"></p>').appendTo(L).css({opacity:0})),X=0,j=e.length;j>X;X++)F+=e[X].value,O[X]=t(document.createElementNS("http://www.w3.org/2000/svg","path")).attr({"stroke-width":x.segmentStrokeWidth,stroke:x.segmentStrokeColor,fill:e[X].color,"data-order":X}).appendTo(R).on("mouseenter",o).on("mouseleave",i).on("mousemove",r);return l(s),c}}(jQuery);