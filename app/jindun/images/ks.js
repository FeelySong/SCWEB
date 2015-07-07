var disp=1;var R1="<a href=http://wpa.qq.com/msgrd?v=3&uin=1975418259&site=qq&menu=yes target=_blank style=display:inline-block;height:283px; ><img src=images/zaixiankf.png  WIDTH=143 HEIGHT=283 /></a><p></p>"
var R2="<a href=http://wpa.qq.com/msgrd?v=3&uin=1975418259&site=qq&menu=yes target=_blank><img src=images/kfqq.png WIDTH=143 HEIGHT=80 /></a><img src='images/close.png' onClick='javascript:window.hide()' width='143' height='31' border='0'  alt='¹Ø±Õ'>"
if(disp==1)
{lastScrollY=0;function heartBeat(){var diffY;if(document.documentElement&&document.documentElement.scrollTop)
diffY=document.documentElement.scrollTop;else if(document.body)
diffY=document.body.scrollTop
else
{}
percent=.1*(diffY-lastScrollY);if(percent>0)percent=Math.ceil(percent);else percent=Math.floor(percent);document.getElementById("lovexin14").style.top=parseInt(document.getElementById("lovexin14").style.top)+percent+"px";lastScrollY=lastScrollY+percent;}
suspendcode14="<DIV id=\"lovexin14\" style='right:10px;POSITION:absolute;TOP:200px;width:143px;'>"+ R1+ R2+"</div>"
document.write(suspendcode14);window.setInterval("heartBeat()",1);function hide()
{lovexin14.style.visibility="hidden";}}