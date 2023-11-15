<div class="col-lg-6">
    <div class="profileBox mb-3 packageSummary">
        <div class="profileTitle">
            Paket Kullanım Detayları
        </div>
        <div class="profileTable">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Personel</th>
                        <th scope="col">Kullanım Tarihi</th>
                        <th scope="col">Adet</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($packet->usages()->paginate(setting('speed_pagination_number')) as $usage)
                            <tr>
                                <td>{{$usage->personel->name ?? "Silinmiş"}}</td>
                                <td>{{$usage->created_at->format('d.m.Y H:i')}}</td>
                                <td>{{$usage->amount}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="alert alert-primary text-center">Paket Kullanımınız Bulunamadı</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center my-2">
                    {{$packet->usages()->paginate(setting('speed_pagination_number'))}}
                </div>
            </div>
        </div>
    </div>
</div>
