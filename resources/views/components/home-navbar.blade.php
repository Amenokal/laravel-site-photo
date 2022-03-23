    <h1>XAVIER CAUCHY PHOTOGRAPHIE</h1>

@foreach($categories as $category)

    <ul class='category-container' id='category-{{$category->order}}'>

        <li class='category-wrapper'>
            <h2 id='category-{{$category->order}}'>{{$category->name}}</h2>
        </li>


        <ul class='galery-container'>
            @foreach($category->galeries->sortBy('order')->all() as $galery)
                <li class='galery-wrapper' id='gal-{{$category->order}}-{{$galery->order}}'>
                    <h3 id='galery-{{$galery->order}}'>{{$galery->name}}</h3>
                </li>
            @endforeach
        </ul>


    </ul>
@endforeach

    <div class='contact-container'>
        <h2 class='contact' id='contact-menu'>CONTACT</h2>

            <ul class='contact-content'>
                <li class="fas fa-envelope-square">
                    <a href='bonjour@xavier-cauchy.com'>bonjour@xavier-cauchy.com</a>
                </li>
                <li class="fab fa-facebook-square">
                    <a href='https://www.facebook.com/maurice.querient'>Xavier Cauchy Photographie</a>
                </li>
                <li class="fa-brands fa-instagram-square">
                    <a href='https://www.instagram.com/xavier_cauchy/'>xavier_cauchy</a>
                </li>
                <li class="fas fa-phone">
                    <span>06.09.62.35.99</span>
                </li>
            </ul>
    </div>
