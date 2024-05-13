@extends('layouts.master')
@section('title', 'Bloglar')
@section('styles')

@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @if(request()->routeIs('blog.category'))
                                    <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('blog.index')}}">Blog Yazıları</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{$blogCategories->first()->getName()}}
                                    </li>
                                @else
                                    <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Blog Yazıları
                                    </li>
                                @endif

                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section id="bigSlider" class="mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bigSliderContent">
                            <div class="owl-carousel owl-theme">
                                @forelse($ads as $advert)
                                    <div class="item">
                                        <a href="{{$advert->link}}" target="_blank" >
                                            <img src="{{image($advert->image)}}" alt="" style="height: 350px"/>
                                        </a>
                                    </div>
                                @empty
                                @endforelse

                            </div>
                            <div class="sliderArrow">
                                <a href="javascript:;" class="sliderPrev">
                                    <img src="/assets/images/icons/ico-slider-left.svg" />
                                </a>
                                <a href="javascript:;" class="sliderNext">
                                    <img src="/assets/images/icons/ico-slider-right.svg" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="pageContent">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="pageTitle mb-5">Blog Yazıları</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pageTab">
                            <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                                @foreach($blogCategories as $category)
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link  @if($loop->first) active @endif"
                                            id="pills-{{$category->id}}-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#pills-{{$category->id}}"
                                            type="button"
                                            role="tab"
                                            aria-controls="pills-{{$category->id}}"
                                            aria-selected="true"
                                        >
                                            {{$category->getName()}}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                @foreach($blogCategories as $category)
                                    <div
                                        class="tab-pane fade @if($loop->first) show active @endif"
                                        id="pills-{{$category->id}}"
                                        role="tabpanel"
                                        aria-labelledby="pills-{{$category->id}}"
                                        tabindex="0"
                                    >
                                        <div class="blogList">
                                            <div class="row">
                                                @forelse($category->blogs()->where('status', 1)->paginate(12) as $blog)
                                                    <div class="col-lg-3">
                                                        <div class="blogListItem">
                                                            <div class="blogLıstItemPhoto">
                                                                <a href="{{route('blog.detail', $blog->getSlug())}}">
                                                                    <img src="{{image($blog->image)}}" alt="" />
                                                                </a>
                                                                <a href="{{route('blog.category', $category->getSlug())}}" class="tag">{{$category->getName()}}</a>
                                                            </div>
                                                            <div class="blogLıstItemText">
                                                                <i>{{$blog->created_at->format('d.m.Y')}}</i>
                                                                <a href="{{route('blog.detail', $blog->getSlug())}}">
                                                                    {{$blog->getTitle()}}
                                                                </a>
                                                                <span>
                                                                    {{\Illuminate\Support\Str::limit(strip_tags($blog->getDescription()), 100)}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-warning" role="alert">
                                                        Bu türde Blog bulunamadı
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <div class="my-2 d-flex justify-content-center">
                                            {{ $category->blogs()->paginate(12)->links() }}
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection

@section('scripts')

@endsection
