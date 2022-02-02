const { default: axios } = require('axios');
require('./bootstrap');

document.onload = setHomeImg();
function setHomeImg(){
    let img = new Image;
    img.src = document.querySelector('.home-img>img').src;
    img.onload = ()=>{
        if(img.width > img.height){
            document.querySelector('.home-img').classList.add('horizontal');
        }else{
            document.querySelector('.home-img').classList.add('vertical');
        }
    }
};


document.querySelectorAll('.category-wrapper').forEach(el=>{
    el.addEventListener('click', openCategory, true);
})
function openCategory(e){

    let galeries = e.currentTarget.nextElementSibling;
    let galNb = galeries.children.length;

    if(document.querySelector('ul.show') && galeries.className.includes('show')){
        document.querySelector('ul.show').style.height = "0px";
        document.querySelector('ul.show').classList.remove('show');
    }
    else if(document.querySelector('ul.show') && !galeries.className.includes('show')){
        document.querySelector('ul.show').style.height = "0px";
        document.querySelector('ul.show').classList.remove('show');
        galeries.classList.toggle('show');
        galeries.style.height = `${galNb*1.6}em`;
    }else{
        galeries.classList.toggle('show');
        galeries.style.height = `${galNb*1.6}em`;
    }
}

document.getElementById('contact-menu').addEventListener('click', openContact)
function openContact(){
    if(document.querySelector('ul.show')){
        document.querySelector('ul.show').style.height = "0px";
        document.querySelector('ul.show').classList.remove('show');
        document.querySelector('.contact-content').classList.toggle('show');
        document.querySelector('.show').style.height = "6em";
    }else if(document.querySelector('.contact-content.show')){
        document.querySelector('.contact-content').classList.toggle('show');
        document.querySelector('.show').style.height = "0px";
    }else{
        document.querySelector('.contact-content').classList.toggle('show');
        document.querySelector('.show').style.height = "6em";
    }
}

document.querySelectorAll('h3').forEach(el=>{
    el.addEventListener('click', getContent)
})
function getContent(e){
    let categoryOrder = document.querySelector('ul.show').parentNode.id.split('-')[1];
    let galeryOrder = e.target.id.split('-')[1];

    axios.get(`./galery/get/${categoryOrder}/${galeryOrder}`)
    .then(res=>{
        document.querySelector('main').innerHTML = res.data;
    })
}

document.querySelector('main').addEventListener('click', openCarousel)
function openCarousel(e){
    if(e.target.parentNode.className === 'img-container'){
        let galeryId = e.target.id.split('-')[1];
        let photoOrder = e.target.id.split('-')[2];

        axios.get(`./carousel/open/${galeryId}/${photoOrder}`)
        .then(res=>{
            document.querySelector('main').innerHTML = res.data;

            let imgs = document.querySelectorAll('.flicker>figure>img');
            imgs.forEach(el=>{
                let img = new Image;
                img.src = el.src;
                img.onload = ()=>{
                    if(img.width > img.height){
                        el.classList.add('horizontal');
                    }else{
                        el.classList.add('vertical');
                    }
                }

                if(el.className.includes('current')){
                    el.parentNode.classList.add('currentImg');
                }
            })
        })
        .then(()=>{
            document.getElementById('carouselPrev').addEventListener('click',prevImg)
            document.getElementById('carouselNext').addEventListener('click',nextImg)
            document.getElementById('carouselClose').addEventListener('click',closeCarousel)
        })
    }

}

function prevImg(){
    let currentImg = document.querySelector('.currentImg');
    let prevImg = currentImg.previousElementSibling ?? document.querySelector('.flicker figure:last-child');
    currentImg.classList.add('current-to-left');
    prevImg.classList.add('prev-image-inc');

    setTimeout(() => {
        currentImg.className = "";
        prevImg.className = "currentImg";
    }, 500);
}
function nextImg(){
    let currentImg = document.querySelector('.currentImg');
    let nextImg = currentImg.nextElementSibling ?? document.querySelector('.flicker figure:first-child');
    currentImg.classList.add('current-to-right');
    nextImg.classList.add('next-image-inc');

    setTimeout(() => {
        currentImg.className = "";
        nextImg.className = "currentImg";
    }, 500);
}
function closeCarousel(){
    let categoryOrder = document.querySelector('.carousel').id.split('-')[1];
    let galeryOrder = document.querySelector('.carousel').id.split('-')[2];

    axios.get('./galery/get/'+categoryOrder+'/'+galeryOrder)
    .then(res=>{
        document.querySelector('main').innerHTML = res.data;
    })

}
