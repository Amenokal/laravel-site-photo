<main @class([
    'home-img-display' => $home,
    'galery-display' => !$home,
])>

@if ($home)

    <div class='home-img-container'>
        @if($homeimg)
            <figure class='home-img'>
                <img src="storage/images/{{$homeimg->src}}" >
            </figure>
        @else
            <p class="no-home-img">Pas encore d'image d'acceuil</p>
        @endif
    </div>

@else

    <div class='galery-content'>
        @if($galery && $galery->photos->isNotEmpty())

            @foreach($galery->photos->sortBy('order')->all() as $photo)

                <figure class='img-container'>
                    <img id='img-{{ $photo->galery->id }}-{{ $photo->order }}'
                        src="storage/images/{{$photo->src}}" >
                </figure>

            @endforeach

        @endif

    </div>

@endif

</main>
