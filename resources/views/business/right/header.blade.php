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
        href="javascript:void(0)"
        class="d-flex align-items-center justify-content-center"
        onclick="openGoogleMaps()"
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

        <span>Konum</span>
    </a>

    <a
        href="https://instagram.com/{{$business->phone}}"
        class="d-flex align-items-center justify-content-center"
        target="_blank"
    >
        <svg
            width="25"
            height="25"
            viewBox="0 0 50 50"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >

            <path
                d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"
                stroke="#43506E"
                stroke-width="1"
            />
            <path
                d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"
                stroke="#43506E"
                stroke-width="1.5"
            />
        </svg>


        <span>Instagram</span>
    </a>
</div>
