<div class="row gx-6 gx-xl-9 my-4">
    <!--begin::Col-->
    <div class="col-lg-6">
        <!--begin::Summary-->
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1 fs-4">Randevu Özeti</h3>

                    <div class="fs-6 fw-semibold text-gray-400">{{$customer->appointments->count()}} Toplam İşlem</div>
                </div>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <a href="{{route('customer.appointment.index')}}" class="btn btn-light btn-sm">Randevuları Gör</a>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body p-9 pt-5">
                <!--begin::Chart-->
                <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                    <div id="kt_docs_google_chart_pie"></div>
                </div>
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Summary-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-lg-6">
        <!--begin::Summary-->
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1 fs-4">Siparişler/Paketler</h3>

                    <div class="fs-6 fw-semibold text-gray-400">{{$customer->packets->count() + $customer->orders->count()}} Adet Paket ve Ürün Alım İşlemi Yaptınız</div>
                </div>
                <!--end::Card title-->

            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body p-9 pt-5">
                <!--begin::Chart-->
                <div class="position-relative d-flex justify-content-center align-items-center me-15 mb-3">
                    <div id="kt_project_overview_graph"></div>
                </div>
                <!--end::Chart-->

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Summary-->
    </div>
    <!--end::Col-->

</div>
