<header>
    <div class="container">
        <div class="row">
            <div class="col-4 col-xl-3 d-flex align-items-center">
                <div class="logo">
                    <a href="/">
                        <img
                            src="{{image(setting('speed_logo_white'))}}"
                            class="logo-white"
                            alt="logo"
                        />
                        <img
                            src="{{image(setting('speed_logo_dark'))}}"
                            class="logo-dark"
                            alt="logo"
                        />
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-xl-block">
                <div class="topMenu">
                    <ul>
                        <li class="active">
                            <a href="/">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-home-2"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                    <path
                                        d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"
                                    ></path>
                                    <path d="M10 12h4v4h-4z"></path>
                                </svg>
                                Ana Sayfa
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-category"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 4h6v6h-6z"></path>
                                    <path d="M14 4h6v6h-6z"></path>
                                    <path d="M4 14h6v6h-6z"></path>
                                    <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                                Salonlar
                            </a>
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="{{route('search.businessCategorySearch', $category->getSlug())}}">{{$category->getName()}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="megaMenu">
                            <a href="javascript:;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-users"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path
                                        d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                    ></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                </svg>
                                Hizmetler
                            </a>

                            <ul class="megaMenuItem">
                                @foreach($featuredCategory as $fCategory)
                                    <li>
                                        <a href="#">{{$fCategory->name}}</a>
                                        <ul>
                                            @foreach($fCategory->subCategories()->where('is_menu', 1)->orderBy('order_number', 'asc')->take(6)->get() as $subCategory)
                                                <li><a href="{{route('search.service', $subCategory->getSlug())}}">{{$subCategory->getName()}}</a></li>
                                            @endforeach

                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a href="{{route('faq')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-24-hours"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 13c.325 2.532 1.881 4.781 4 6"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2"></path>
                                    <path d="M4 5v4h4"></path>
                                    <path
                                        d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2"
                                    ></path>
                                    <path d="M18 15v2a1 1 0 0 0 1 1h1"></path>
                                    <path d="M21 15v6"></path>
                                </svg>
                                S.S.S
                            </a>
                        </li>
                        <li>
                            <a href="{{route('blog.index')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-article"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"
                                    ></path>
                                    <path d="M7 8h10"></path>
                                    <path d="M7 12h10"></path>
                                    <path d="M7 16h10"></path>
                                </svg>
                                Blog
                            </a>
                        </li>
                        <li class="d-sm-none">
                            <a href="javascript:;">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-building"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 21l18 0"></path>
                                    <path d="M9 8l1 0"></path>
                                    <path d="M9 12l1 0"></path>
                                    <path d="M9 16l1 0"></path>
                                    <path d="M14 8l1 0"></path>
                                    <path d="M14 12l1 0"></path>
                                    <path d="M14 16l1 0"></path>
                                    <path
                                        d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"
                                    ></path>
                                </svg>
                                İşletmeler</a>
                        </li>
                        <li class="mobile-menu-logo">
                            <img src="{{image(setting('speed_logo_white'))}}" alt="" />
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="col-8 col-xl-3 d-flex align-items-center justify-content-end"
            >
                <div class="headerRight">
                    @if(auth('customer')->check())
                        <a href="{{route('customer.home')}}" class="btn-outline-white"> <i class="fa fa-user-circle"></i> Hesabım </a>
                    @else
                        <a href="{{route('customer.login')}}" class="btn-outline-white"> Giriş Yap </a>
                    @endif
                    <a href="{{env('REMOTE_URL')}}" target="_blank" class="btn-white d-none d-sm-block">İşletmeler</a>
                    <a href="javascript:;" class="toggle"><span></span></a>
                </div>
            </div>
        </div>
    </div>
</header>
