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
        href="#phoneSection"
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
                d="M21.6211 19.6326V17.9866C21.6211 17.1688 21.1232 16.4334 20.3639 16.1297L18.3297 15.316C17.364 14.9297 16.2633 15.3482 15.7981 16.2786L15.6211 16.6326C15.6211 16.6326 13.1211 16.1326 11.1211 14.1326C9.12109 12.1326 8.62109 9.63257 8.62109 9.63257L8.97511 9.45556C9.90547 8.99038 10.3239 7.88971 9.93764 6.92392L9.12398 4.88979C8.82025 4.13047 8.08484 3.63257 7.26703 3.63257H5.62109C4.51652 3.63257 3.62109 4.528 3.62109 5.63257C3.62109 14.4691 10.7845 21.6326 19.6211 21.6326C20.7257 21.6326 21.6211 20.7371 21.6211 19.6326Z"
                stroke="#28303F"
                stroke-width="1.5"
                stroke-linejoin="round"
            />
        </svg>

        <span>Telefon</span>
    </a>
</div>
