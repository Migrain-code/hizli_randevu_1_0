@extends('layouts.master')
@section('title', "Yorumlarım")
@section('meta_description', "Yapılan Tüm Yorumlar")
@section('styles')
    <style>
        .starActive{
            color: #ffdb70;
        }
    </style>
@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="mt-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Hesabım</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Yorumlarım
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
                                    <div class="profileTitle">Yorumlarınız</div>
                                    <div class="commentsList">
                                        @forelse($businessComments as $comment)
                                            <div class="commentListItem">
                                                <div class="commentsPhoto">
                                                    <img src="{{image($comment->business->logo)}}" alt="" />
                                                </div>
                                                <div class="commentsText">
                                                    <div class="commentsTop">
                                                        <a href="{{route('business.detail', $comment->business->slug)}}">{{$comment->business->name}}</a>
                                                    </div>
                                                    <p>
                                                        {{$comment->content}}
                                                    </p>
                                                    <div class="commentsBottom">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div
                                                                    class="commentRating d-flex align-items-center"
                                                                >
                                                                    @for($i = 0;$i < 4; $i++)
                                                                        <i class="fa fa-star @if($i < $comment->point) starActive @endif" aria-hidden="true"></i>
                                                                    @endfor
                                                                    <span>{{number_format($comment->point,1)}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="date">{{$comment->created_at->translatedFormat('d F Y')}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <div class="alert alert-warning">
                                                        Yorum Kaydınız Bulunamadı
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </div>
                                    <div class="my-2 d-flex justify-content-center">
                                        {!! $businessComments->links() !!}
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

@endsection
