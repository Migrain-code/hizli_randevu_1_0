@extends('layouts.master')
@section('title', $page->title)
@section('description', $page->meta_description)
@section('styles')
    <style>
        .privacy-policy {
        }

        .privacy-policy .hero h2 {
            color: #43506e;
            font-family: Euclid Circular A;
            font-size: 30px;
            font-style: normal;
            font-weight: 700;
            line-height: 60px; /* 150% */
            text-transform: capitalize;
        }

        .privacy-policy .content p {
            color: #43506e;
            font-family: Euclid Circular A;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 30px */
            margin-bottom: 30px;
        }

        .privacy-policy.container {
            max-width: 1100px;
        }

    </style>
@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{$page->title}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section id="pageContent">
            <div class="privacy-policy container">
                <div class="privacy-policy">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="content">
                                <div class="hero">
                                    <h2>{{$page->title}}</h2>
                                </div>
                                {!! $page->description !!}
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
