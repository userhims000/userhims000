/*Loader Js*/
let cnt=document.getElementById("count");
let water=document.getElementById("shapeFill");
if(water != null){
    let cln = water.cloneNode(true);
    cln.setAttribute("id", "shapeFill2");
    let clnEle = document.getElementById("shapeGroup").appendChild(cln);
    let percent=cnt.innerText;
    let interval;
    let isPaused = false;
    interval=setInterval(function(){
        if(!isPaused) {
            percent++;
            cnt.innerHTML = percent;
            water.style.transform='translate('+(0+percent)/.4+'px'+','+('-'+0-percent)/2.4 +'%)';
            clnEle.style.transform='translate('+(0-percent)/2.5+'px'+','+('-'+0-percent)/2.3 +'%)';
            if(percent==100){
                // clearInterval(interval);
                percent = 0;
                isPaused = true;
            }
        }
    },15);
}

setInterval(function(){
    isPaused = false
}, 1400)
