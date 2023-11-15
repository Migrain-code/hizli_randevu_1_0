<div class="col-lg-6">
    <div class="profileBox mb-3 packageSummary">
        <div class="profileTitle">Paket Ödeme Detayları</div>
        <div class="profileTable">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Fiyat</th>
                        <th scope="col">Adet</th>
                        <th scope="col">Ödeme Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($packet->payments()->paginate(setting('speed_pagination_number')) as $payment)
                            <tr>
                                <td>{{$payment->price}}</td>
                                <td>{{$payment->amount}}</td>
                                <td>{{$payment->created_at->format('d.m.Y H:i')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="alert alert-primary text-center">Paket Ödemeniz Bulunamadı</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center my-2">
                    {{$packet->payments()->paginate(setting('speed_pagination_number'))}}
                </div>
            </div>
        </div>
    </div>
</div>
