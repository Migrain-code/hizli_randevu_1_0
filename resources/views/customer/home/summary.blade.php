<div class="profileSummary">
    <div class="row">
        <div class="col-lg-3">
            <div class="profileSummaryItem d-flex align-items-center">
                <div class="icon">
                    <img src="/assets/images/icons/ico-profil-summary-1.svg" alt="">
                </div>
                <div class="text">
                    <strong>Randevu Ödemeleriniz</strong>
                    <span>{{number_format($payments['appointment'], 2)}} TL</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="profileSummaryItem d-flex align-items-center">
                <div class="icon">
                    <img src="/assets/images/icons/ico-profil-summary-2.svg" alt="">
                </div>
                <div class="text">
                    <strong>Paket Ödemeleriniz</strong>
                    <span>{{number_format($payments['packetPayment'], 2)}} TL</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="profileSummaryItem d-flex align-items-center">
                <div class="icon">
                    <img src="/assets/images/icons/ico-profil-summary-3.svg" alt="">
                </div>
                <div class="text">
                    <strong>Ürün Ödemeleriniz</strong>
                    <span>{{number_format($payments['orderTotal'], 2)}} TL</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="profileSummaryItem d-flex align-items-center">
                <div class="icon">
                    <img src="/assets/images/icons/ico-profil-summary-4.svg" alt="">
                </div>
                <div class="text">
                    <strong> Toplam Harcamanız</strong>
                    <span>{{number_format($payments['total'], 2)}} TL</span>
                </div>
            </div>
        </div>
    </div>
</div>
