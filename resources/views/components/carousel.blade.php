<div class='carousel' id='gal-{{$photos->first()->galery->category->order}}-{{$photos->first()->galery->order}}'>

    <i id="carouselPrev" class="fas fa-chevron-left"></i>
    <i id="carouselNext" class="fas fa-chevron-right"></i>
    <i id="carouselClose" class="fas fa-times"></i>

    <div class='flicker'>

        @foreach($photos as $photo)
            <figure>
                <img
                    @class(['current' => $photo->order === $current])
                    src="storage/images/{{$photo->src}}"
                >
            </figure>
        @endforeach

    </div>

</div>
