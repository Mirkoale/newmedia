function fade(id, inOut, time)
{
    var el = document.querySelector('#'+ id);
    inOut == "in" ? (el.style.opacity = 1 ,el.style.height = 100 +'vh' , el.style.width = 100+'%', el.style.borderRadius = 0) : el.style.opacity = 0;
    el.style.transition = "all " + time + "s";
    el.style.WebkitTransition = "all " + time + "s";
}


function scale(id, inOut, time){

   var el = document.querySelector('#'+ id);
    inOut == "in" ? (el.style.opacity = 1 ,el.style.transform = 'scale(1)', el.style.borderRadius = 0) : el.style.opacity = 0;
    el.style.transition = "all " + time + "s";
    el.style.WebkitTransition = "all " + time + "s";

}

function slide(id, inOut, time)
{
    var el = document.querySelector('#'+ id);
    inOut == "in" ? el.style.height = 300 + 'px' : el.style.height = 0;

    el.style.transition = "all " + time + "s";
    el.style.WebkitTransition = "all " + time + "s";
}