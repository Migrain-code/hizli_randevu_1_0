function fetchClock(clickedTime, businessId, personels){
    var appointmentInput = document.querySelector('input[name="appointment_date"]');
    appointmentInput.value= clickedTime;

    var apiUrl = "/api/appointment/clock/get";

    var postData = {
        business_id: businessId,
        date: clickedTime,
        personals: personels,
    };

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(postData)
    })
        .then(function (response) {
            if (!response.ok) {
                throw new Error("API isteği başarısız!");
            }
            return response.json();
        })
        .then(function (data) {
            // API'den gelen verileri işleyin ve HTML öğelerini oluşturun
            var swiperSlides = document.querySelectorAll('.swiper-wrapper .swiper-slide');

            swiperSlides.forEach(function(slide) {
                slide.remove();
            });
            var personelTimesDiv = document.getElementById('personelTimes');
            personelTimesDiv.innerHTML="";
            data.personel_clocks.forEach(function (row) {
                var newTimeInput = document.createElement('input');
                newTimeInput.type = "hidden";
                newTimeInput.checked = "true";
                newTimeInput.id =`appointment_time${row.personel.id}`;
                newTimeInput.name ="times[]";

                personelTimesDiv.appendChild(newTimeInput);
                var docTimesHtml = "";

                row.clocks.forEach(function (clock){
                    if (clock.durum == false){
                        var newHtml = `
                          <div class="timePickers">
                            <div class="timePickerRadio">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="appointment_time${row.personel.id}"
                                    id="flexRadioDefault1"

                                />
                                <span>${clock.saat}</span>
                            </div>
                          </div>
                        `;

                        docTimesHtml += newHtml;
                    }
                    else {
                        var newHtml = `
                          <div class="timePickers">
                            <div class="timePickerRadio">
                                <input
                                    class="form-check-input active-time"
                                    type="radio"
                                    name="appointment_time${row.personel.id}"
                                    id="flexRadioDefault1"

                                />
                                <span>${clock.saat}</span>
                            </div>
                          </div>
                        `;
                        docTimesHtml += newHtml;
                    }
                })

                var newSlide = document.createElement('div');
                newSlide.classList.add('swiper-slide');
                newSlide.classList.add('doc-times');
                newSlide.innerHTML =`<div class="w-100"><h3>${row.personel.name} İçin Saat Seçin</h3></div>` + docTimesHtml;

                var swiperWrapper = document.querySelector('.swiper-wrapper');
                swiperWrapper.appendChild(newSlide);
            });
        })
        .catch(function (error) {
            console.error("API hatası:", error);
        });

}
