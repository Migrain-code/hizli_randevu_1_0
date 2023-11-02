<div class="saloonDetailBox mb-4">
    <div class="detailTitle">Personeller</div>
    <div class="detailBoxContent">
        <div class="detailBoxContentList userList">
            @forelse($business->personel as $personel)
                @include('business.left.personel.detail')
            @empty
            @endforelse
        </div>
    </div>
</div>
