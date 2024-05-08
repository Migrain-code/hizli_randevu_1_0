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
    <a
        href="#https://instagram.com/{{$business->phone}}"
        class="d-flex align-items-center justify-content-center"
    >
        <img src="/assets/images/instagram.png" style="margin-right: 10px;width: 25px;height: 25px;">
        <span>Instagram</span>
    </a>
</div>
