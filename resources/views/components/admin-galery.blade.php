
<section class='admin-galery-options'>
    @if($galery)
        <p>{{$galery->category->name}} > {{$galery->name}}</p>

        <div class='admin-btn-options'>
            <button class='btn show' id='chooseImgsBtn'>Ajouter des photos</button>
            <button class='btn' id='uploadBtn'></button>
            <button class='btn' id='cancelUpload'>Annuler</button>
        </div>

        <form method='POST' enctype="multipart/form-data" action='{{ route("upload") }}' class='hidden-form'>
            @csrf
            <input type='text' name='catagoryId' id='catagory-id' value="{{$galery->category->id}}" />
            <input type='text' name='galeryId' id='galery-id' value="{{$galery->id}}" />
            <input type='file' id='photos' name='photos[]' multiple />
            <button id='uploadFormBtn' type='submit'></button>
        </form>
    @endif
</section>

<section class='galery-content'>

    @if($galery && $galery->photos->isNotEmpty())
    <span class='photo-drop-zone' id='pdz-0' ondragover="return false">
        <i class="fas fa-share"></i>
    </span>
        @foreach($galery->photos->sortBy('order')->all() as $photo)

            <figure class='img-container'>
                <img id='img-{{$photo->id}}'
                     src="storage/images/{{$photo->src}}" >

                <div class='admin-photo-options'>
                    <i @class([
                        'hightlight',
                        'fas fa-star'=>$photo->highlighted,
                        'far fa-star'=>!$photo->highlighted
                    ])></i>
                    <i class="far fa-hand-paper"></i>
                    <i class='fa fa-times delete-photo'></i>

                </div>
                @if($photo->highlighted)
                    <i class='fas fa-star highlighted'></i>
                @endif
            </figure>
            <span class='photo-drop-zone' id='pdz-{{$photo->order+1}}' ondragover="return false">
                <i class="fas fa-share"></i>
            </span>
        @endforeach
    @endif

</section>

