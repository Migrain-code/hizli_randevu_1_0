<div class="col-lg-3">

    <div class="saloonItem">
        <div class="saloonPhoto">
            @if(auth('customer')->check())
                <a href="javascipt:void(0);" class="fav-btn" data-business="{{$business->id}}" onclick="toggleHeart(this)">
                    <i id="heartIcon" @if(in_array($business->id, auth('customer')->user()->favorites()->pluck('business_id')->toArray()))) class="fa fa-heart" @else class="fa fa-heart-o" @endif></i>
                </a>
            @endif
            <a href="{{route('business.detail', $business->slug)}}">
                <img
                    src="{{image($business->wallpaper)}}"
                    alt=""
                />
                @if($business->order_number > 0)
                    <span class="featured"><i>Öne Çıkan</i></span>
                @endif
            </a>
        </div>

        <div class="saloonItemHeader">
            <a href="{{route('business.detail', $business->slug)}}">{{$business->name}}</a>
            <p>{{$business->cities?->name}}/{{$business->districts?->name}}</p>
            @php
                $averageRating = $business->comments->count() > 0 ? number_format($business->comments()->sum('point') / $business->comments->count(), 1) : 0
            @endphp
            <div
                class="rating d-flex align-items-center justify-content-between"
            >
                <div class="stars d-flex align-items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $averageRating ? 'active' : '' }}" aria-hidden="true"></i>
                    @endfor
                </div>
                <span>{{$averageRating}}</span>
            </div>
        </div>
        <div class="saloonItemBottom">
            <div class="row">
                <div class="col-lg-6">
                    <div class="price">
                        <strong>{{$business->services()->min('price')}} TL</strong>
                        <span>‘den başlayan</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    @if($business->approve_type == 1)
                        <a href="javascript:;">Hızlı Onay</a>
                    @else
                        <a href="javascript:;">Hızlı Yanıt</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
