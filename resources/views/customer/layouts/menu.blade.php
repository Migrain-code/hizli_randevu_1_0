<div class="leftMenu">
    <div class=" userItem">
        <div class="left">
            <div class="userPhoto">
                <img src="{{image(auth('customer')->user()->image)}}" alt="">
            </div>
        </div>
        <div class="right">
            <div class="userInfo">
                <strong>{{auth('customer')->user()->name}}</strong>
                <div class="location"><img src="/assets/images/icons/ico-menu-location.svg"
                                           alt="">{{auth('customer')->user()->city->name}}</div>
                @if(auth('customer')->user()->birthday)
                    <div class="birthday">
                        <img src="/assets/images/icons/ico-menu-birthday.svg" alt="">
                        {{isset(auth('customer')->user()->birthday) ? \Illuminate\Support\Carbon::parse(auth('customer')->user()->birthday)->format('d.m.Y') : ""}}
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="leftMenuContent">
        <div class="menuItem">
            <a href="{{route('customer.home')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-user.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Hesabım</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.favorite.index')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-favori.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Favoriler</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.order.index')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-text.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Siparişlerim</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.packet.index')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-list.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Paketler</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.appointment.index')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-clock.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Randevularım</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.comments')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-comments.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Yorumlarım</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.campaign.index')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-ticket.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Kampanyalarım</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.profile.password.edit')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-key.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Şifre Değiştir</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.profile.edit')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/gear.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Ayarlar</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.notification')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-notification.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Bildirimler</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="{{route('customer.permissions')}}">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-notification2.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Bildirim İzinleri</span>
            </span>
            </a>
        </div>
        <div class="menuItem">
            <a href="javascript:void(0);" onclick="$('#customer-logout-form').submit()">
            <span class="left">
                <div class="icon">
                    <img src="/assets/images/icons/ico-menu-logout.svg" alt="">
                </div>
            </span>
                <span class="right">
                <span class="text">Güvenli Çıkış</span>
            </span>
            </a>
        </div>
        <form method="post" action="{{route('customer.logout')}}" id="customer-logout-form">@csrf</form>

    </div>

</div>
