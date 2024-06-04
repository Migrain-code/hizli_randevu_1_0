<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="pageSubTitle mb-2">
                <strong>Fotoğraf</strong>
                <span>Arşivi</span>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="js-photo-gallery">
                <div class="owl-carousel">
                    @forelse($business->gallery as $gallery)
                        <div class="item">
                            <a
                                href="{{image($gallery->way)}}"
                                data-lightbox="image-1"
                                data-title="{{$gallery->name}}"
                            >
                                <img src="{{image($gallery->way)}}" style="height: 150px;
    object-fit: cover;" alt="" />
                            </a>
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
