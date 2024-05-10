@if($rooms->count() > 0)
<div class="servicesBox">
    <div
        class="d-flex align-items-center justify-content-between"
    >
        <div class="stepsTitle d-flex align-items-start">
            <div class="step"><i class="fa fa-star"></i></div>
            <div class="text"><span>Salon Seçimi</span></div>
        </div>
    </div>

    <div class="servicesBoxContent" style="padding-top: 10px;">
        <div
            class="customSelect iconSelect servicesSelect customTomSelect"
        >
            <select class="tomSelect" id="roomSelect" name="room_id" required>
                <option value="">Oda Seçiniz</option>

                    <option value="0">Salon</option>
                    @foreach($rooms as $room)
                        <option value="{{$room->id}}">{{$room->name}}</option>
                    @endforeach
            </select>
        </div>

    </div>

</div>
@else
    <input type="hidden" name="room_info" id="roomSelect" value="">
@endif

<div class="servicesBox">
    <div
        class="d-flex align-items-center justify-content-between"
    >
        <div class="stepsTitle d-flex align-items-start">
            <div class="step">1</div>
            <div class="text"><span>Hizmet Seçimi</span></div>
        </div>
        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="editButton">
            Ekle/Düzenle<svg
                width="24"
                height="25"
                viewBox="0 0 24 25"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M3 21.7394H21M13.7844 6.05115C13.7844 6.05115 13.7844 7.68578 15.419 9.3204C17.0537 10.955 18.6883 10.955 18.6883 10.955M7.31963 18.7275L10.7523 18.2371C11.2475 18.1664 11.7064 17.937 12.06 17.5833L20.3229 9.3204C21.2257 8.41762 21.2257 6.95393 20.3229 6.05115L18.6883 4.41652C17.7855 3.51375 16.3218 3.51375 15.419 4.41652L7.15616 12.6794C6.80248 13.0331 6.57305 13.4919 6.50231 13.9871L6.01193 17.4198C5.90295 18.1826 6.5568 18.8365 7.31963 18.7275Z"
                    stroke="#43506E"
                    stroke-width="1.5"
                    stroke-linecap="round"
                />
            </svg>
        </a>
    </div>
</div>
