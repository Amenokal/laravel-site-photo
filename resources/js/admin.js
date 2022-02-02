const { default: axios } = require('axios');
require('./bootstrap');



/** -----------
 *  Onload Init
 *  -----------
 */

function addAllListeners(){

    // clicks
    document.querySelector('body').addEventListener('click', clickListeners);

    // drags
    document.querySelector('body').addEventListener('mousedown', dragListeners);

    // drops
    document.querySelector('body').addEventListener('drop', dropListeners);

}
document.onload = addAllListeners();




/** ---------------
 *  Click Listeners
 *  ---------------
 */

function clickListeners(e){

    var targetName;
    var type;

// -----------------------
// MENU TOOL-BOX LISTENERS
// -----------------------

    // catch category/galery name
    if(e.target.parentNode.previousElementSibling){
        targetName = e.target.parentNode.previousElementSibling.innerText;
    }
    // catch type
    if(e.target.parentNode.parentNode.parentNode.className.includes('category') ||
        e.target.parentNode.parentNode.parentNode.className.includes('galery') ){
        type = e.target.parentNode.parentNode.parentNode.className;
    }

    // create category request
    if(e.target === document.getElementById('addNewCatg')){
        let name = document.getElementById('newCatgName').value;
        if(!isUsed(name)){
            axios.post('./category/create',{
                name: name,
            })
            .then(res=>{
                document.querySelector('.admin-menu').innerHTML = res.data;
            })
        }
        else {
            document.getElementById('newCatgName').style.color = "firebrick";
        }
    }

    // toggle add new galery visibility
    if(e.target.className.includes('plus')){
        document.getElementById('addGaleryTo-'+targetName).classList.toggle('show');
    }
        // create galery request
        else if(e.target.className.includes('add-new-galery-btn')){
            let name = e.target.previousElementSibling.value;
            let categoryName = e.target.parentNode.id.split('-')[1];
            if(!isUsed(name)){

                axios.post('./galery/create',{
                    categoryName: categoryName,
                    name: name,
                })
                .then(res=>{
                    document.querySelector('.admin-menu').innerHTML = res.data;
                })
            }
        }

    // toggle edit name
    else if(e.target.className.includes('pen')){
        e.target.parentNode.parentNode.classList.remove('show');
        e.target.parentNode.parentNode.nextElementSibling.classList.add('show');
    }
        // edit name request
        else if(e.target.className.includes('check')){
            let oldName = e.target.parentNode.parentNode.previousElementSibling.children[0].innerText;
            let newName = e.target.parentNode.previousElementSibling.value;

            if(!isUsed(newName)){
                axios.post('./'+type+'/edit', {
                    oldName: oldName,
                    newName: newName
                })
                .then(res=>{
                    document.querySelector('.admin-menu').innerHTML = res.data;
                })
            }
            else{
                e.target.parentNode.previousElementSibling.style.color = "firebrick";
            }
        }

        // toggle back edit name
        else if(e.target.className.includes('times')){
            e.target.parentNode.parentNode.classList.remove('show');
            e.target.parentNode.parentNode.previousElementSibling.classList.add('show');
        }

    // delete category/galery
    else if(e.target.className.includes('trash')){
        axios.post('./'+type+'/delete', {
            name: targetName
        })
        .then(res=>{
            document.querySelector('.admin-menu').innerHTML = res.data;
        })
    }



// ---------------------
// SHOW GALERY LISTENERS
// ---------------------

    else if(e.target.className.includes('galery-name')){
        targetName = e.target.innerText;

        axios.get('./galery/admin/show/'+targetName)
        .then(res=>{
            document.querySelector('.admin-galery').innerHTML = res.data;
        });
    }



// -------------
// UPLOAD PHOTOS
// -------------

    // choose images to upload
    else if(e.target === document.getElementById('chooseImgsBtn')){
        e.target.classList.remove('show');
        document.getElementById('cancelUpload').classList.add('show');

        let importImg = document.getElementById("photos");
        importImg.click();
        importImg.addEventListener('change',()=>{
            document.getElementById('uploadBtn').classList.add('show');
            document.getElementById('uploadBtn').innerText = `Télécharger ${[...importImg.files].length} fichier(s)`;
        });
    }

        // upload images
        else if(e.target === document.getElementById('uploadBtn')){
            if(checkSize()){
                document.getElementById('uploadFormBtn').click();
            }
            else {
                clearFiles(true);
            }
        }

        // cancel upload
        else if(e.target === document.getElementById('cancelUpload')){
            clearFiles(false);
            document.getElementById('uploadBtn').classList.remove('show');
            document.getElementById('cancelUpload').classList.remove('show');
            document.getElementById('chooseImgsBtn').classList.add('show');
        }



// ------------------------
// PHOTO TOOL-BOX LISTENERS
// ------------------------

    var id;

    // highlight photo
    if(e.target.className.includes('fa-star') && !e.target.className.includes('highlighted')){
        id = e.target.parentNode.previousElementSibling.id.split('-')[1];

        if(e.target.className.includes('fas')){
            e.target.className = 'far fa-star'
            let elms = e.target.parentNode.parentNode.children;
            for(el of elms){
                if(el.className.includes('highlighted')){
                    el.remove();
                }
            }
        }else{
            e.target.className = 'fas fa-star';
            e.target.parentNode.parentNode.innerHTML += '<i class="fas fa-star highlighted"></i>';
        }

        axios.post('./photo/highlight', {
            id: id
        })
    }

    // delete photo
    else if(e.target.className.includes('delete-photo')){
        id = e.target.parentNode.previousElementSibling.id.split('-')[1];

        axios.post('./photo/delete', {
            id: id
        })
        .then(res=>{
            document.querySelector('.admin-galery').innerHTML = res.data;
        })
    }
}



/** --------------
 *  Drag Listeners
 *  --------------
 */

function dragListeners(e){

// ------------------
// MENU DRAG LISTENER
// ------------------

    if(e.target.className.includes('fa-arrows-alt-v')){

        var target = e.target.parentNode.previousElementSibling;

        if(target.className.includes('category')){
            target.parentNode.parentNode.parentNode.draggable = true;

            document.querySelectorAll('.category-drop-zone').forEach(el=>{
                if(el != document.querySelector('[draggable="true"]').previousElementSibling &&
                el != document.querySelector('[draggable="true"]').nextElementSibling     ){
                    el.classList.add('show');
                    el.addEventListener('dragenter', (e)=>{e.target.classList.toggle('dragged-over')});
                    el.addEventListener('dragleave', (e)=>{e.target.classList.toggle('dragged-over')});
                }
            });
        }

        else if(target.className.includes('galery')){
            target.parentNode.parentNode.draggable = true;
            target.parentNode.parentNode.parentNode.classList.add('dragged-from');

            document.querySelectorAll('.dragged-from .galery-drop-zone').forEach(el=>{
                if(el != document.querySelector('[draggable="true"]').previousElementSibling &&
                el != document.querySelector('[draggable="true"]').nextElementSibling     ){
                    el.classList.add('show');
                    el.addEventListener('dragenter', (e)=>{e.target.classList.toggle('dragged-over')});
                    el.addEventListener('dragleave', (e)=>{e.target.classList.toggle('dragged-over')});
                }
            });

            target.parentNode.parentNode.parentNode.classList.remove('dragged-from');
        }
    }



// -------------------
// PHOTO DRAG LISTENER
// -------------------

    else if(e.target.className.includes('fa-hand-paper')){
        e.target.parentNode.parentNode.draggable = true;
        document.querySelectorAll('.photo-drop-zone').forEach(el=>{
            el.classList.add('show');
            el.addEventListener('dragenter', (e)=>{e.target.classList.toggle('dragged-over')});
            el.addEventListener('dragleave', (e)=>{e.target.classList.toggle('dragged-over')});
        })
        document.querySelector('[draggable="true"]').previousElementSibling.classList.remove('show');
        document.querySelector('[draggable="true"]').nextElementSibling.classList.remove('show');
    }
}



/** --------------
 *  Drop Listeners
 *  --------------
 */

function dropListeners(e){

    var type = e.target.className.split('-')[0];
    var newOrder = e.target.id.split('-')[1];

    // menu drops
    if(e.target.className.includes('drop-zone') && !e.target.className.includes('photo')){

        if(type === 'category'){
            var name = document.querySelector('[draggable="true"]>li>div>h2').innerText;
        }
        else if(type === 'galery'){
            var name = document.querySelector('[draggable="true"]>div>h3').innerText;
        }

        axios.post('./'+type+'/new/order', {
            name: name,
            newOrder: newOrder,
        })
        .then(res=>{
            document.querySelector('.admin-menu').innerHTML = res.data;
        })
    }

    // photo drops
    else if(e.target.className.includes('photo-drop-zone')){
        let id = document.querySelector('[draggable="true"]').children[0].id.split('-')[1];
        let newOrder = e.target.id.split('-')[1];
        console.log(newOrder);

        axios.post('./photo/new/order', {
            id: id,
            newOrder: newOrder
        })
        .then(res=>{
            document.querySelector('.admin-galery').innerHTML = res.data;
            document.querySelectorAll('.photo-drop-zone').forEach(el=>{
                el.classList.remove('show');
            })
        })
    }

    // cancel drops
    else {
        document.querySelectorAll('.category-drop-zone, .galery-drop-zone, .photo-drop-zone').forEach(el=>{
            el.classList.remove('show');
        })
        if(document.querySelector('[draggable="true"]')){
            document.querySelector('[draggable="true"]').draggable = false;
        }

    }

}

/** -----------------
 *  Utility functions
 *  -----------------
 */

function isUsed(name){
    let names = document.querySelectorAll('h2, h3');
    var match = false;
    names.forEach(el=>{
        if(el.innerText === name){
            match = true;
        }
    })
    return match;
}

function checkSize(){
    let files = document.getElementById("photos").files;
    let totalSize = 0;
    for(let i=0; i<files.length; i++){
        totalSize += files[i].size;
    }
    let maxSize = 8388608;
    return totalSize < maxSize ? true : false;
}
function clearFiles(withMessage){
    let input = document.getElementById("photos");
    let fileList = [...input.files];
    while(fileList.length>0){
        fileList.pop();
    }
    if(withMessage){
        alert ("Oups, le poids total est trop lourd ! Veuillez réessayer avec moins d'images");
    }
}


// function adminListeners(e){
//     if(e.target === document.getElementById('newCatg')){
//         toggleNewCatg(e);
//     }
//     else if(e.target === document.getElementById('addNewCatg')){
//         addNewCatg(e);
//     }

//     else if(e.target.className.includes('fa-plus')){
//         toggleNewGal(e);
//     }
//     else if(e.target === document.querySelector('.new-content-hidden.show>button')){
//         addNewGal(e);
//     }

//     else if(e.target.className.includes('fa-pen-alt')){
//         toggleEdit(e);
//     }
//     else if(e.target.className.includes('fa-check')){
//         editName(e);
//     }
//     else if(e.target.className.includes('fa-times') && !e.target.parentNode.className.includes('admin')){
//         closeEdit(e);
//     }
//     else if(e.target.className.includes('fa-trash')){
//         remove(e);
//     }

//     else if(e.target.className.includes('show-galery')){
//         showGaleryContent(e);
//     }

//     else if(e.target === document.getElementById('chooseImgsBtn')){
//         chooseImgs(e);
//     }
//     else if(e.target === document.getElementById('uploadBtn')){
//         fileSizeHandler(e);
//     }

//     else if(e.target.className.includes('star')){
//         highlightPhoto(e);
//     }
//     else if(e.target.className.includes('fa-times') && e.target.parentNode.className.includes('admin')){
//         deletePhoto(e);
//     }
// }





function toggleNewCatg(e){
    let hidden = e.target.nextElementSibling;
    hidden.classList.toggle('show');
}
function addNewCatg(e){
    let name = document.getElementById('newCatgName').value;
    axios.post('./category/create',{
        name: name
    })
    .then(res=>{
        document.querySelector('.admin-menu').innerHTML = res.data;
    })
}

function toggleNewGal(e){
    let hidden = e.target.parentNode.parentNode.nextElementSibling.nextElementSibling;
    hidden.classList.toggle('show');
}
function addNewGal(e){
    let name = e.target.previousElementSibling.value;
    let categoryOrder = e.target.parentNode.parentNode.parentNode.id.split('-')[1];``

    axios.post('./galery/create',{
        name: name,
        categoryOrder: categoryOrder
    })
    .then(res=>{
        document.querySelector('.admin-menu').innerHTML = res.data;
    })
}

function toggleEdit(e){
    let content = e.target.parentNode.parentNode;
    let editContent = e.target.parentNode.parentNode.nextElementSibling;

    if(document.querySelector('.catg-wrapper>.edit-content.show')){
        document.querySelector('.catg-wrapper>.edit-content.show').previousElementSibling.classList.add('show');
        document.querySelector('.catg-wrapper>.edit-content.show').classList.remove('show');
    }

    content.classList.remove('show');
    editContent.classList.add('show');
}
function editName(e){
    let input = e.target.parentNode.previousElementSibling;
    let name = input.placeholder.split('...')[0];
    let newName = input.value ? input.value : name;

    let type = e.target.parentNode.parentNode.parentNode.className.includes('catg') ? 'category' : 'galery';
    let path = './'+type+'/edit';

    if(!document.querySelector('.content>h2').innerText.includes(newName)){
        axios.post(path,{
            name: name,
            newName: newName
        })
        .then(res=>{
            document.querySelector('.admin-menu').innerHTML = res.data;
        })
    }
    else{
        input.style.color = 'firebrick';
    }
}
function closeEdit(e){
    let content = e.target.parentNode.parentNode.previousElementSibling;
    let editContent = e.target.parentNode.parentNode;

    content.classList.add('show');
    editContent.classList.remove('show');
}

function remove(e){
    let name = e.target.parentNode.previousElementSibling.innerText;
    let path;
    if(e.target.parentNode.parentNode.parentNode.className.includes('catg')){
        path = 'category'
    }else if(e.target.parentNode.parentNode.parentNode.className.includes('gal')){
        path = 'galery'
    }
    axios.post('./'+path+'/delete', {
        name: name
    })
    .then(res=>{
        document.querySelector('body').innerHTML = res.data;
        document.querySelector('main').addEventListener('click', adminListeners);

        document.querySelectorAll('.fa-arrows-alt-v').forEach(el=>{
            el.addEventListener('mousedown', allowDrag);
        })
        document.querySelectorAll('.category-drop-zone, .galery-drop-zone').forEach(el=>{
            el.addEventListener('dragenter', (e)=>{e.target.classList.toggle('dragged-over')});
            el.addEventListener('dragleave', (e)=>{e.target.classList.toggle('dragged-over')});
            el.addEventListener('drop', drop);
        })
        document.querySelector('.admin-galery').addEventListener('mousedown',allowPhotoDrops);

        document.querySelector('body').addEventListener('drop', cancelDrop);
    })
}

function showGaleryContent(e){
    let categoryOrder = e.target.parentNode.parentNode.id.split('-')[1];
    let galeryOrder = e.target.parentNode.parentNode.id.split('-')[2];
    axios.get(`./galery/admin/${categoryOrder}/${galeryOrder}`)
    .then(res=>{
        document.querySelector('.admin-galery').innerHTML = res.data;
    })
}

function chooseImgs(e){
    document.getElementById('photos').click();
    e.target.classList.remove('show');
    document.getElementById('cancelUpload').classList.add('show');
    document.getElementById('photos').addEventListener('change',()=>{
        let input = document.getElementById("photos");
        document.getElementById('uploadBtn').classList.add('show');
        document.getElementById('uploadBtn').innerText = `Télécharger ${[...input.files].length} fichier(s)`;
    });
}




function highlightPhoto(e){
    let galeryId = e.target.parentNode.previousElementSibling.id.split('-')[1];
    let photoOrderId = e.target.parentNode.previousElementSibling.id.split('-')[2];

    if(e.target.className.includes('fas')){
        e.target.className = 'far fa-star'
        let elms = e.target.parentNode.parentNode.children;
        for(el of elms){
            if(el.className.includes('highlighted')){
                el.remove();
            }
        }
    }else{
        e.target.className = 'fas fa-star';
        e.target.parentNode.parentNode.innerHTML += '<i class="fas fa-star highlighted"></i>';
    }

    axios.post('./photo/highlight', {
        galeryId: galeryId,
        photoOrderId: photoOrderId
    })
}

function deletePhoto(e){
    let galeryId = e.target.parentNode.previousElementSibling.id.split('-')[1];
    let photoOrderId = e.target.parentNode.previousElementSibling.id.split('-')[2];
    axios.post('./photo/delete', {
        galeryId: galeryId,
        photoOrderId: photoOrderId
    })
    .then(res=>{
        document.querySelector('.admin-galery').innerHTML = res.data;
    })
}





// DRAG & DROPS
// ------------

// function addDropListeners(){
//     document.querySelectorAll('.fa-arrows-alt-v').forEach(el=>{
//         el.addEventListener('mousedown', allowDrag);
//     })
//     document.querySelectorAll('.category-drop-zone, .galery-drop-zone').forEach(el=>{
//         el.addEventListener('dragenter', toggleDropZone);
//         el.addEventListener('dragleave', toggleDropZone);
//         el.addEventListener('drop', drop);
//     })
//     document.querySelector('.admin-galery').addEventListener('mousedown',allowPhotoDrops);
//     document.querySelector('body').addEventListener('drop', cancelDrop);
// }


// MENU DRAG & DROP
function allowDrag(e){
    let type = e.target.parentNode.previousElementSibling.id.split('-')[0];
    if(type === 'category'){
        e.target.parentNode.parentNode.parentNode.parentNode.draggable = true;
        document.querySelectorAll('.category-drop-zone').forEach(el=>{
            el.classList.add('show');
        })
        document.querySelector('[draggable="true"]').previousElementSibling.classList.remove('show');
        document.querySelector('[draggable="true"]').nextElementSibling.classList.remove('show');
    }else if(type === 'galery'){
        e.target.parentNode.parentNode.parentNode.draggable = true;
        document.querySelectorAll('.galery-drop-zone').forEach(el=>{
            el.classList.add('show');
        })
        document.querySelector('[draggable="true"]').previousElementSibling.classList.remove('show');
        document.querySelector('[draggable="true"]').nextElementSibling.classList.remove('show');

    }
}






// PHOTO DRAG & DROP
// function allowPhotoDrops(e){
//     if(e.target.className.includes('hand')){
//         e.target.parentNode.parentNode.draggable = true;
//         document.querySelectorAll('.photo-drop-zone').forEach(el=>{
//             el.classList.add('show');
//             el.addEventListener('dragenter', toggleDropZone);
//             el.addEventListener('dragleave', toggleDropZone);
//             el.addEventListener('drop', dropPhoto);
//         })
//         document.querySelector('[draggable="true"]').previousElementSibling.classList.remove('show');
//         document.querySelector('[draggable="true"]').nextElementSibling.classList.remove('show');
//     }
// }
// function dropPhoto(e){
//     let galeryId = document.querySelector('[draggable="true"]').children[0].id.split('-')[1];
//     let initialOrder = document.querySelector('[draggable="true"]').children[0].id.split('-')[2];
//     let newOrder = e.target.id.split('-')[3];

//     axios.post('./photo/new/order', {
//         galeryId: galeryId,
//         initialOrder: initialOrder,
//         newOrder: newOrder
//     })
//     .then(res=>{
//         document.querySelector('.admin-galery').innerHTML = res.data;

//         document.querySelectorAll('.photo-drop-zone').forEach(el=>{
//             el.classList.remove('show');
//             el.removeEventListener('dragenter', toggleDropZone);
//             el.removeEventListener('dragleave', toggleDropZone);
//             el.removeEventListener('drop', dropPhoto);
//         })
//     })
// }


// CLEAN IF DROP ON WRONG TARGET
// function cancelDrop(e){
//     if(!e.target.className.includes('drop-zone')){

//         document.querySelectorAll('.category-drop-zone, .galery-drop-zone, .photo-drop-zone').forEach(el=>{
//             el.classList.remove('show');
//         })

//         if(document.querySelector('[draggable="true"]')){
//             document.querySelectorAll('[draggable="true"]').forEach(el=>{
//                 el.draggable = false;
//             })
//         }
//     }
// }
