<div class="saloonInfoTitle d-flex align-items-center">
    <img src="{{image($business->logo)}}" style="border-radius: 50%" alt=""/>
    <span>{{$business->name}}</span>
</div>
<div
    class="infoRating d-flex align-items-center justify-content-start"
>
    @php
        $averageRating = $business->comments->count() > 0 ? number_format($business->comments()->sum('point') / $business->comments->count(), 1) : 0
    @endphp
    <div class="stars">
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star {{ $i <= $averageRating ? 'active' : '' }}"
               aria-hidden="true"></i>
        @endfor
    </div>
    <span>{{number_format($averageRating, 1)}}</span>
    <span>{{$business->comments->count()}} Ziyaretçi Puanı İle</span>
</div>
<div class="description">
    Listelenen fiyatlar bilgi amaçlıdır ve güncel tutulması
    işletmenin sorumluluğundadır. Fiyatları teyit etmek için
    bu sayfadaki numara üzerinden işletmeye ulaşabilirsiniz.
</div>

<div class="linkGroup d-flex align-items-center">
    <a
        href="#comments"
        class="d-flex align-items-center justify-content-center"
    >
        <svg
            width="25"
            height="25"
            viewBox="0 0 25 25"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M13.6211 3.63257H11.6211C6.65053 3.63257 2.62109 7.66201 2.62109 12.6326V17.6326C2.62109 19.8417 4.41195 21.6326 6.62109 21.6326H13.6211C18.5917 21.6326 22.6211 17.6031 22.6211 12.6326C22.6211 7.66201 18.5917 3.63257 13.6211 3.63257Z"
                stroke="#43506E"
                stroke-width="1.5"
                stroke-linejoin="round"
            />
            <circle
                cx="12.6211"
                cy="12.6326"
                r="1"
                fill="#43506E"
            />
            <circle
                cx="16.6211"
                cy="12.6326"
                r="1"
                fill="#43506E"
            />
            <circle
                cx="8.62109"
                cy="12.6326"
                r="1"
                fill="#43506E"
            />
        </svg>
        <span>Yorumlar</span>
    </a>
    <a
        href="#address"
        class="d-flex align-items-center justify-content-center"
    >
        <svg
            width="25"
            height="25"
            viewBox="0 0 25 25"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M21.6211 11.5215C21.6211 16.4307 15.9961 22.6326 12.6211 22.6326C9.24609 22.6326 3.62109 16.4307 3.62109 11.5215C3.62109 6.61226 7.65053 2.63257 12.6211 2.63257C17.5917 2.63257 21.6211 6.61226 21.6211 11.5215Z"
                stroke="#43506E"
                stroke-width="1.5"
            />
            <path
                d="M15.6211 11.6326C15.6211 13.2894 14.2779 14.6326 12.6211 14.6326C10.9642 14.6326 9.62109 13.2894 9.62109 11.6326C9.62109 9.97571 10.9642 8.63257 12.6211 8.63257C14.2779 8.63257 15.6211 9.97571 15.6211 11.6326Z"
                stroke="#43506E"
                stroke-width="1.5"
            />
        </svg>

        <span>Adres</span>
    </a>
    <style>
        .saloonInfoBox .saloonInfoHeader .linkGroup a img:hover {
            margin-right: 10px;
        }
    </style>
    <a
        href="#https://instagram.com/{{$business->phone}}"
        class="d-flex align-items-center justify-content-center"
    >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke-width="1" fill="#43506E" version="1.1" id="Layer_1" width="25px" height="25px" viewBox="0 0 169.063 169.063" xml:space="preserve">
            <g>
                <path d="M122.406,0H46.654C20.929,0,0,20.93,0,46.655v75.752c0,25.726,20.929,46.655,46.654,46.655h75.752   c25.727,0,46.656-20.93,46.656-46.655V46.655C169.063,20.93,148.133,0,122.406,0z M154.063,122.407   c0,17.455-14.201,31.655-31.656,31.655H46.654C29.2,154.063,15,139.862,15,122.407V46.655C15,29.201,29.2,15,46.654,15h75.752   c17.455,0,31.656,14.201,31.656,31.655V122.407z"/>
                <path d="M84.531,40.97c-24.021,0-43.563,19.542-43.563,43.563c0,24.02,19.542,43.561,43.563,43.561s43.563-19.541,43.563-43.561   C128.094,60.512,108.552,40.97,84.531,40.97z M84.531,113.093c-15.749,0-28.563-12.812-28.563-28.561   c0-15.75,12.813-28.563,28.563-28.563s28.563,12.813,28.563,28.563C113.094,100.281,100.28,113.093,84.531,113.093z"/>
                <path d="M129.921,28.251c-2.89,0-5.729,1.17-7.77,3.22c-2.051,2.04-3.23,4.88-3.23,7.78c0,2.891,1.18,5.73,3.23,7.78   c2.04,2.04,4.88,3.22,7.77,3.22c2.9,0,5.73-1.18,7.78-3.22c2.05-2.05,3.22-4.89,3.22-7.78c0-2.9-1.17-5.74-3.22-7.78   C135.661,29.421,132.821,28.251,129.921,28.251z"/>
            </g>
        </svg>
        <span>Instagram</span>
    </a>
</div>
