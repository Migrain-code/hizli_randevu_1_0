<div class="saloonDetailBox mb-4">
    <div class="detailTitle">Çalışma Saatleri</div>
    <div class="detailBoxContent">
        <div class="detailBoxContentList userList">

            @foreach($dayList as $day)
                @if(isset($business->off_day) && $day->id == $business->off_day)
                    <div
                        class="detailBoxContentListItem d-flex align-items-center justify-content-between">
                        <span> {{$day->name}} </span>
                        <span style="text-decoration: line-through;">
                                                          <span class="badge bg-danger text-white">Kapalı</span>
                                                        </span>
                    </div>
                @else
                    <div
                        class="detailBoxContentListItem d-flex align-items-center justify-content-between">
                        <span> {{$day->name}} </span>
                        <span> {{$business->start_time}} - {{$business->end_time}} </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
