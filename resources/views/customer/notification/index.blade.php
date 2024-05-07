@extends('layouts.master')
@section('styles')

@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="mt-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('customer.home')}}">Hesabım</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Bildirimler
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section id="pageContent">
                        <div class="d-flex align-items-start">
                            @include('customer.layouts.menu')
                            <div class="profileContent">
                                <div id="profileContentBox">
                                    <div class="profileTitle">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                Bildirim Listeniz
                                            </div>
                                            <div class="col-lg-4 d-flex align-items-center justify-content-md-end mt-2 mt-md-0">
                                                <a href="javascript:void(0)" onclick="unReads()" class="btn-pink btn-radius btn-xs">Okunmayanları Göster</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="notificationList">
                                        @forelse(auth('customer')->user()->notifications()->paginate(setting('speed_pagination_number')) as $notification)
                                            <a href="{{route('customer.notification.detail', $notification->slug)}}" data-type="{{$notification->status}}" class="notificationItem purple unseen">
                                            <span class="row">
                                              <span class="col-8 col-lg-10">
                                                  <span class="left" style="color: {{$notification->icon->background}}">
                                                      <span class="icon" style="background: {{$notification->icon->background}}">
                                                        <img
                                                            src="{{image($notification->icon->icon)}}"
                                                            alt=""
                                                        />
                                                      </span>
                                                      <span class="text">
                                                        <strong>{{$notification->title}}</strong>
                                                            <p>{{str($notification->content)->limit(100)}}</p>
                                                      </span>
                                                </span>
                                              </span>
                                              <span class="col-4 col-lg-2 d-flex align-items-center justify-content-center">
                                                <div class="seenIcon read">
                                                    @if($notification->status == 0)
                                                        <div class="seenIcon unread" style="background-color: #dc3545d4 !important;">
                                                            <img class="" src="/assets/images/icons/ico-seen.svg" alt="">
                                                        </div>
                                                    @else
                                                        <div class="seenIcon unread" style="background: #cbebe0 !important;">
                                                          <img class="unseenimg" src="/assets/images/icons/ico-unseen.svg" alt="">

                                                        </div>

                                                    @endif
                                                </div>
                                              </span>
                                            </span>
                                            </a>

                                        @empty
                                        @endforelse
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        {!! auth('customer')->user()->notifications()->paginate(setting('speed_pagination_number'))->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </article>

@endsection

@section('scripts')
    <script>
        function unReads(){
            var elements = document.querySelectorAll('[data-type="1"]');

            elements.forEach(function(element) {
                element.remove();
            });
        }
    </script>
@endsection
