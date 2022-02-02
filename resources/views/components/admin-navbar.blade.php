<span class='category-drop-zone' id='cdz-0' ondragover="return false">
    <i class="fas fa-share"></i>
</span>

@foreach($categories as $category)

    <ul class='category-container'>

        <li class='category' draggable="false">
            <div class='content show'>
                <h2 class='category-name'>{{$category->name}}</h2>
                <div class='edit-toolbox'>
                    <i class="fas fa-plus"></i>
                    <i class="fas fa-arrows-alt-v"></i>
                    <i class="fas fa-pen-alt"></i>
                    <i class="fa fa-trash"></i>
                </div>
            </div>
            <div class='edit-content'>
                <input class='input' placeholder="{{$category->name}}...">
                <div>
                    <i class="fas fa-check"></i>
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </li>

        <span class='galery-drop-zone' id='gdz-0' ondragover="return false">
            <i class="fas fa-share"></i>
        </span>

        @foreach($category->galeries->sortBy('order')->all() as $galery)

            <li class='galery' draggable="false">
                <div class='content show'>
                    <h3 class='galery-name'>{{$galery->name}}</h3>
                    <div class='edit-toolbox'>
                        <i class="fas fa-arrows-alt-v"></i>
                        <i class="fas fa-pen-alt"></i>
                        <i class="fa fa-trash"></i>
                    </div>
                </div>
                <div class='edit-content'>
                    <input class='input' placeholder="{{$galery->name}}...">
                    <div>
                        <i class="fas fa-check"></i>
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </li>

            <span class='galery-drop-zone' id='gdz-{{$galery->order+1}}' ondragover="return false">
                <i class="fas fa-share"></i>
            </span>

        @endforeach


        <div class='new-content-hidden' id='addGaleryTo-{{$category->name}}'>
            <input class='input' type='text' placeholder=" Nouvelle galerie..."/>
            <button class='btn add-new-galery-btn'>Ajouter</button>
        </div>

    </ul>

    <span class='category-drop-zone' id='cdz-{{$category->order+1}}' ondragover="return false">
        <i class="fas fa-share"></i>
    </span>

@endforeach


<div class='category'>
    <input id='newCatgName' class='input' type='text' placeholder=" Nouvelle catégorie..."/>
    <button id='addNewCatg' class='btn'>Ajouter</button>
</div>
