<div class="profileBox mb-3 packageHeader">
    <div class="row">
        <div class="col-lg-3 col-xl-2">
            <div class="boxItem">
                <span>Hakkınız var</span>
                <strong>{{$packet->amount}} {{$packageTypes[$packet->type]}}</strong>
            </div>
        </div>
        <div class="col-lg-3 col-xl-2">
            <div class="boxItem">
                <span>Toplam Ödenecek</span>
                <strong>{{$packet->total}} TL</strong>
            </div>
        </div>
        <div class="col-lg-3 col-xl-2">
            <div class="boxItem">
                <span>Paket Kullandınız</span>
                <strong>{{$packet->usages->sum('amount')}} {{$packageTypes[$packet->type]}}</strong>
            </div>
        </div>
        <div class="col-lg-3 col-xl-2">
            <div class="boxItem">
                <span>Paket Ödemesi Yaptınız</span>
                <strong>{{$packet->payments->sum('price')}} TL</strong>
            </div>
        </div>
        <div class="col-lg-3 col-xl-2">
            <div class="boxItem">
                <span>Kalan Kullanım Hakkınız</span>
                <strong>{{$packet->amount - $packet->usages->sum('amount')}} {{$packageTypes[$packet->type]}}</strong>
            </div>
        </div>
        <div class="col-lg-3 col-xl-2">
            <div class="boxItem">
                <span>Kalan Ödemeniz</span>
                <strong>{{$packet->total -$packet->payments->sum('price')}} TL</strong>
            </div>
        </div>
    </div>
</div>
