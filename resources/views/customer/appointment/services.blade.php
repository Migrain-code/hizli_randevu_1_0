<div class="col-lg-6">
    <div class="profileBox mb-3 packageSummary h-100">
        <div class="profileTitle">
            Randevu Hizmet Detayları
        </div>
        <div class="profileTable">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Personel</th>
                        <th scope="col">İşlem Tarihi</th>
                        <th scope="col">Hizmet</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($appointment->services as $service)
                            <tr>
                                <td>{{$service->personel->name}}</td>
                                <td>{{$service->start_time}}</td>
                                <td>{{$service->service->subCategory->name}}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
