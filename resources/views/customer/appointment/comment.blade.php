@if($appointment->status == 6 or $appointment->status == 5)
    @if($appointment->comment_status == 0)
        <form class="col-lg-6" id="comment-form" method="post" action="{{route('customer.appointment.comment.store')}}">
            @csrf
            <input type="hidden" name="business_id" value="{{$appointment->business_id}}">
            <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
            <div class="profileBox mb-3 packageSummary h-100">
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="profileTitle">
                            Aldığınız Hizmeti Değerlendirin
                        </div>
                    </div>
                    <div
                        class="col-lg-6 d-flex align-items-center justify-content-md-end"
                    >
                        <style>
                            .star {
                                cursor: pointer;
                                font-size: 24px;
                            }
                        </style>
                        <div class="stars">

                            <label for="star1" class="star">
                                <input type="radio" id="star1" name="rating" value="1">
                            </label>

                            <label for="star2" class="star">
                                <input type="radio" id="star2" name="rating" value="2">
                            </label>

                            <label for="star3" class="star">
                                <input type="radio" id="star3" name="rating" value="3">
                            </label>
                            <label for="star4" class="star">
                                <input type="radio" id="star4" name="rating" value="4">

                            </label>
                            <label for="star5" class="star">
                                <input type="radio" id="star5" name="rating" value="5">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="sendComments">
                    <div class="form-floating mb-3">
            <textarea
                class="form-control"
                placeholder="Yorumunuzu bu alana giriniz"
                id="floatingTextarea2"
                rows="5"
                style="height: auto"
                name="content"
            ></textarea>
                        <label for="floatingTextarea2">Yorumunuzu bu alana giriniz</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-10">
                            <div class="customCheck">
                                <div class="customCheckInput">
                                    <input type="checkbox" name="terms"/>
                                    <span></span>
                                </div>
                                <span>
                                  <a href="{{route('page.detail', $terms->slug)}}" target="_blank">Şartlar ve Koşulları</a>
                                  okudum ve kabul ediyorum
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-end">
                            <a href="javascript:void(0);" onclick="$('#comment-form').submit()" class="btn btn-pink btn-xs">Gönder</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    @endif
@endif
