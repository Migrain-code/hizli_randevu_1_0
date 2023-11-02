<div class="saloonDetailBox mb-4" id="comments">
    <div
        class="detailRating d-flex align-items-center justify-content-between"
    >
        @php
            $averageRating = $business->comments->count() > 0 ? number_format($business->comments()->sum('point') / $business->comments->count(), 1) : 0
        @endphp
        <div class="stars">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fa fa-star {{ $i <= $averageRating ? 'active' : '' }}"
                   aria-hidden="true"></i>
            @endfor
            <span>{{$business->comments->count()}} Yorum ve Puanlama</span>
        </div>

        <span>[{{$averageRating}}/5]</span>
    </div>
</div>
<div class="saloonDetailBox mb-4">
    <div class="commentsList p-0">
        @forelse($business->comments as $comment)
            <div class="commentListItem">
                <div class="commentsPhoto">
                    <img src="/assets/images/blogitem.png" alt=""/>
                </div>
                <div class="commentsText">
                    <div class="commentsTop">
                        <span>{{hideName($comment->customer->name)}}</span>
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
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $comment->point ? 'active' : '' }}"
                                           aria-hidden="true"></i>
                                    @endfor
                                    <span>{{number_format($comment->point, 1)}}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div
                                    class="date">{{$comment->created_at->translatedFormat('d F Y')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse

    </div>
    <a href="javascript:;" class="btn-detail mt-4"
    >Daha Fazla</a
    >
</div>
