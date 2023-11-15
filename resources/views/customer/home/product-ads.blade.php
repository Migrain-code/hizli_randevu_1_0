<div class="profileProduct mt-5">
    <div class="row">
        <div class="col-12">
            <div class="pageTab">
                <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                    @foreach($productCategories as $category)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($loop->first) active @endif" id="pills-3-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-{{$category->id}}"
                                    type="button" role="tab" aria-controls="pills-{{$category->id}}"
                                    aria-selected="true">{{$category->getName()}}</button>
                        </li>
                    @endforeach

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    @foreach($productCategories as $category)
                    <div class="tab-pane fade @if($loop->first) show active @endif" id="pills-{{$category->id}}" role="tabpanel"
                         aria-labelledby="pills-{{$category->id}}-tab" tabindex="0">
                        <div class="productSlider">
                            <div class="owl-carousel owl-theme">
                                @foreach($category->products as $product)
                                    <div class="item">
                                        <a href="{{$product->link}}" target="_blank" class="productSliderItem">
                                        <span class="photo">
                                            <img src="/assets/images/product.png" alt="">
                                        </span>
                                            <i>{{$product->getName()}}</i>
                                            <strong>{{$product->getPrice()}}</strong>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
