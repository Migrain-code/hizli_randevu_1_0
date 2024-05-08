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
        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.83366 0.0317383H20.8337C25.8955 0.0317383 30.0003 4.13657 30.0003 9.19841V20.1984C30.0003 25.2602 25.8955 29.3651 20.8337 29.3651H9.83366C4.77183 29.3651 0.666992 25.2602 0.666992 20.1984V9.19841C0.666992 4.13657 4.77183 0.0317383 9.83366 0.0317383ZM20.8338 26.6141C24.3721 26.6141 27.2505 23.7358 27.2505 20.1974V9.19743C27.2505 5.6591 24.3721 2.78076 20.8338 2.78076H9.83378C6.29545 2.78076 3.41711 5.6591 3.41711 9.19743V20.1974C3.41711 23.7358 6.29545 26.6141 9.83378 26.6141H20.8338Z" fill="#43506E"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00098 14.6966C8.00098 10.6468 11.2845 7.36328 15.3343 7.36328C19.3841 7.36328 22.6676 10.6468 22.6676 14.6966C22.6676 18.7465 19.3841 22.03 15.3343 22.03C11.2845 22.03 8.00098 18.7465 8.00098 14.6966ZM10.751 14.6961C10.751 17.2225 12.808 19.2795 15.3343 19.2795C17.8606 19.2795 19.9176 17.2225 19.9176 14.6961C19.9176 12.168 17.8606 10.1128 15.3343 10.1128C12.808 10.1128 10.751 12.168 10.751 14.6961Z" fill="#43506E"></path>
            <circle cx="23.2174" cy="6.81359" r="0.977167" fill="#43506E"></circle>
        </svg>
        <span>Instagram</span>
    </a>
</div>
