<div class="saloonDetailBox mb-4" id="phoneSection">
    <div
        class="d-flex align-items-center justify-content-between"
    >
        <div class="detailTitle">İletişim</div>
        <div class="copyPhone">
            <span id="copyText">{{$business->phone}}</span>
            <a href="javascript:;"
               onclick="copyToClipboard('copyText')">
                <svg
                    width="25"
                    height="25"
                    viewBox="0 0 25 25"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M8.06543 8.34528V6.34528C8.06543 4.13614 9.85629 2.34528 12.0654 2.34528L18.0654 2.34528C20.2746 2.34528 22.0654 4.13614 22.0654 6.34528V12.3453C22.0654 14.5544 20.2746 16.3453 18.0654 16.3453H16.0654M8.06543 8.34528H6.06543C3.85629 8.34528 2.06543 10.1361 2.06543 12.3453V18.3453C2.06543 20.5544 3.85629 22.3453 6.06543 22.3453H12.0654C14.2746 22.3453 16.0654 20.5544 16.0654 18.3453V16.3453M8.06543 8.34528H12.0654C14.2746 8.34528 16.0654 10.1361 16.0654 12.3453V16.3453"
                        stroke="#43506E"
                        stroke-width="1.5"
                        stroke-linejoin="round"
                    />
                </svg>
            </a>
        </div>
    </div>
</div>
