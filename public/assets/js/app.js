$(document).ready(function () {
    $(".topMenu").hover(function () {
        $("header").toggleClass("open");
    });
    $(".megaMenu").hover(function () {
        $("header").toggleClass("openMegaMenu");
    });
    document.querySelectorAll(".tomSelect").forEach((el) => {
        let settings = {};
        new TomSelect(el, settings);
    });
    $("#sallonTypeSlider .panel").hover(function () {
        $("#sallonTypeSlider .panel").removeClass("active");
        $(this).addClass("active");
    });
    var brandSlider = $("#brandList .owl-carousel");
    brandSlider.owlCarousel({
        loop: true,
        margin: 160,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        items: 5,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1024: {
                items: 4,
            },
            1200: {
                items: 5,
            },
        },
    });
    $("#brandList .sliderPrev").click(function () {
        brandSlider.trigger("prev.owl.carousel");
    });
    $("#brandList .sliderNext").click(function () {
        brandSlider.trigger("next.owl.carousel");
    });
    $("#homeBannerSlider .owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        items: 1,
        autoplay: true,
    });

    $.datepicker.regional["tr"] = {
        closeText: "kapat",
        prevText: "&#x3C;geri",
        nextText: "ileri&#x3e",
        currentText: "bugün",
        monthNames: [
            "Ocak",
            "Şubat",
            "Mart",
            "Nisan",
            "Mayıs",
            "Haziran",
            "Temmuz",
            "Ağustos",
            "Eylül",
            "Ekim",
            "Kasım",
            "Aralık",
        ],
        monthNamesShort: [
            "Oca",
            "Şub",
            "Mar",
            "Nis",
            "May",
            "Haz",
            "Tem",
            "Ağu",
            "Eyl",
            "Eki",
            "Kas",
            "Ara",
        ],
        dayNames: [
            "Pazar",
            "Pazartesi",
            "Salı",
            "Çarşamba",
            "Perşembe",
            "Cuma",
            "Cumartesi",
        ],
        dayNamesShort: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
        dayNamesMin: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
        weekHeader: "Hf",
        dateFormat: "dd.mm.yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: "",
    };
    $.datepicker.setDefaults($.datepicker.regional["tr"]);
    $("#eventDatePicker").datepicker();
    $(".homeBlogSlider .owl-carousel").owlCarousel({
        loop: true,
        margin: 9,
        nav: true,
        items: 2,
        autoplay: true,
        autoplayTimeout: 3000,
        navText: [
            "<img src='assets/images/icons/ico-slider-left.svg'>",
            "<img src='assets/images/icons/ico-slider-right.svg'>",
        ],

        navContainer: "#customBlogSliderNav",
        responsive: {
            0: {
                items: 1,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            },
        },
    });
    var bigSlider = $("#bigSlider .owl-carousel");
    bigSlider.owlCarousel({
        loop: true,
        margin: 160,
        nav: false,
        dots: false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 3000,
    });
    $("#bigSlider .sliderPrev").click(function () {
        bigSlider.trigger("prev.owl.carousel");
    });
    $("#bigSlider .sliderNext").click(function () {
        bigSlider.trigger("next.owl.carousel");
    });

    $(".moreContentLink").click(function () {
        $(this).toggleClass("open");
    });
    $(".moreCategoryLink").click(function () {
        $(".categoryListMore").toggleClass("open");
        $(this).toggleClass("open");
    });
    var dateSlider = $(".dateSlider .owl-carousel");
    dateSlider.owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        dots: true,
        items: 8,
        responsive: {
            0: {
                items: 5,
            },
            768: {
                items: 7,
            },
            1200: {
                items: 8,
            },
        },
    });
    $(".dateSlider .sliderPrev").click(function () {
        dateSlider.trigger("prev.owl.carousel");
    });
    $(".dateSlider .sliderNext").click(function () {
        dateSlider.trigger("next.owl.carousel");
    });

    $(".productSlider .owl-carousel").owlCarousel({
        stagePadding: 0,
        loop: true,
        margin: 30,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],

        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 3,
            },
            1024: {
                items: 4,
            },
        },
    });

    var eventUserList = $(".eventUserList"),
        owlOptions = {
            loop: true,
            margin: 24,
            nav: false,
            dots: true,
            items: 4,
            responsive: {
                0: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1200: {
                    items: 4,
                },
            },
        };

    if ($(window).width() < 992) {
        var owlActive = eventUserList.owlCarousel(owlOptions);
    } else {
        eventUserList.addClass("off");
    }

    $(window).resize(function () {
        if ($(window).width() < 992) {
            if ($(".owl-carousel").hasClass("off")) {
                var owlActive = eventUserList.owlCarousel(owlOptions);
                eventUserList.removeClass("off");
            }
        } else {
            if (!$(".owl-carousel").hasClass("off")) {
                eventUserList.addClass("off").trigger("destroy.owl.carousel");
                eventUserList.find(".owl-stage-outer").children(":eq(0)").unwrap();
            }
        }
    });
    var salloonCustomerGallery = $(".salloonCustomerGallery .owl-carousel");
    salloonCustomerGallery.owlCarousel({
        loop: true,
        margin: 24,
        nav: false,
        dots: true,
        items: 4,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 4,
            },
        },
    });
    $(".salloonCustomerGallery .sliderPrev").click(function () {
        salloonCustomerGallery.trigger("prev.owl.carousel");
    });
    $(".salloonCustomerGallery .sliderNext").click(function () {
        salloonCustomerGallery.trigger("next.owl.carousel");
    });
    var blogListSlider = $(".blogListSlider .owl-carousel");
    blogListSlider.owlCarousel({
        loop: true,
        margin: 24,
        dots: true,
        items: 4,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 4,
            },
        },
    });

    var EventSponsor = $(".js-event-sponsor .owl-carousel");
    EventSponsor.owlCarousel({
        loop: true,
        margin: 50,
        nav: false,
        dots: true,
        items: 4,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 4,
            },
        },
    });

    var jsPhotoGallery = $(".js-photo-gallery .owl-carousel");
    jsPhotoGallery.owlCarousel({
        loop: true,
        margin: 24,
        nav: false,
        dots: true,
        items: 4,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 3,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 6,
            },
        },
    });

    var customerGallery = $(".customerGallery .owl-carousel");
    customerGallery.owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        items: 6,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 6,
            },
        },
    });
    var bannerSlider = $(".bannerSlider .owl-carousel");
    bannerSlider.owlCarousel({
        loop: true,
        margin: 24,
        nav: false,
        dots: true,
        items: 3,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });
    $(".bannerSlider .sliderPrev").click(function () {
        bannerSlider.trigger("prev.owl.carousel");
    });
    $(".bannerSlider .sliderNext").click(function () {
        bannerSlider.trigger("next.owl.carousel");
    });
    var formBoxSlider = $(".formBoxSlider .owl-carousel");
    formBoxSlider.owlCarousel({
        loop: false,
        margin: 0,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        items: 1,
    });
    $(".formBoxSlider .sliderPrev").click(function () {
        formBoxSlider.trigger("prev.owl.carousel");
    });
    $(".formBoxSlider .sliderNext").click(function () {
        formBoxSlider.trigger("next.owl.carousel");
    });

    var sync1 = $(".saloonDetailSlider1");
    var sync2 = $(".saloonDetailSlider2");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1
        .owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: true,
            navText: [
                "<i class='fa-light fa-angle-left' aria-hidden='true'></i>",
                "<i class='fa-light fa-angle-right' aria-hidden='true'></i>",
            ],

            navContainer: "#customDiscoverNav",
            autoplay: false,
            dots: false,
            loop: true,
            responsiveRefreshRate: 200,
        })
        .on("changed.owl.carousel", syncPosition);

    sync2
        .on("initialized.owl.carousel", function () {
            sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: false,
            nav: false,
            margin: 10,
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: slidesPerPage,
            responsive: {
                0: {
                    items: 2,
                },
                600: {
                    items: 4,
                },
                1000: {
                    items: slidesPerPage,
                },
            },
            responsiveRefreshRate: 100,
        })
        .on("changed.owl.carousel", syncPosition2);

    function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }
        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find(".owl-item.active").length - 1;
        var start = sync2.find(".owl-item.active").first().index();
        var end = sync2.find(".owl-item.active").last().index();

        if (current > end) {
            sync2.data("owl.carousel").to(current, 100, true);
        }
        if (current < start) {
            sync2.data("owl.carousel").to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data("owl.carousel").to(number, 100, true);
        }
    }

    sync2.on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data("owl.carousel").to(number, 300, true);
    });
    $(".topMenu").hcOffcanvasNav({
        disableAt: 1200,
        customToggle: $(".toggle"),
        navTitle: "",
        labelBack: "Geri",
        levelTitles: true,
        levelTitleAsBack: true,
        levelOpen: "expand",
    });
});

function copyToClipboard(elementId) {
    var aux = document.createElement("input");
    aux.setAttribute("value", document.getElementById(elementId).innerHTML);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
}
$(window).on("load", function () {
    pageHeight();
});
$(window).on("resize", function () {
    pageHeight();
});

function pageHeight() {
    var pageHeight = 0;
    var windowHeight = $(window).outerHeight(true);
    $(".formBox").css("min-height", windowHeight);
}
