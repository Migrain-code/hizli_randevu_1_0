<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    @if($business->type_id == 1)
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="pills-1-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-1"
                type="button"
                role="tab"
                aria-controls="pills-1"
                aria-selected="true"
            >
                Kadın
            </button>
        </li>
    @endif
    @if($business->type_id == 2)
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="pills-2-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-2"
                type="button"
                role="tab"
                aria-controls="pills-2"
                aria-selected="false"
            >
                Erkek
            </button>
        </li>
    @endif
    @if($business->type_id == 3)
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="pills-2-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-2"
                type="button"
                role="tab"
                aria-controls="pills-2"
                aria-selected="false"
            >
                Erkek
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="pills-1-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-1"
                type="button"
                role="tab"
                aria-controls="pills-1"
                aria-selected="true"
            >
                Kadın
            </button>
        </li>


        {{--
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="pills-3-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-3"
                type="button"
                role="tab"
                aria-controls="pills-3"
                aria-selected="true"
            >
                Unisex
            </button>
        </li>
            --}}
    @endif




</ul>
