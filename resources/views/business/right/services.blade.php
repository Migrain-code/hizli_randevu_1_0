<div class="pageTab mt-5 salloonsTab" id="servicesTab">
    @include('business.right.parts.nav')
    <div class="tab-content" id="pills-tabContent">
        @include('business.right.parts.woman')
        @include('business.right.parts.man')

    </div>
</div>
@if($business->activeForm())
    <a href="{{route('business.takePrice', $business->slug)}}" class="btn-pink d-block text-center mt-5">
        Fiyat Al
    </a>
@endif
