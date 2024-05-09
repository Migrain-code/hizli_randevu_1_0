@php
    $title = "Salon Ara";
    $description = "Salon Ara";
    if (request()->routeIs('search.businessCategorySearch')){
        $title = $category->getMetaTitle();
        $description = $category->getMetaDescription();
    } elseif (request()->routeIs('search.service')){
        $title = $subCategory->getName(). " Hizmetlerinde Fiyatlar , Müşteri Deneyimleri, Kampanyalar ve İndirimler - Hemen Randevunuzu Alın!";
        $description = $subCategory->getName(). " Hizmeti Sunan Tüm İşletmelerde: Fiyatlar, Müşteri Yorumları, Fırsatlar, Kampanyalar, Tavsiyeler, Adresler ve Puanlar - En İyi Seçimi Yapmak İçin Her Şey Burada!";
    } elseif (request()->routeIs('search.serviceCityAndCategorySearch')){
        $title = $city->name. " ". $category->getName(). " Fiyatları & Kampanyaları - Gerçek Müşteri Yorumları | Randevu Al";
        $description = $city->name." ve Çevresindeki En İyi ".$category->getName(). " Hizmetleri: Fiyatlar, Müşteri Yorumları, Kampanyalar, Tavsiyeler ve Daha Fazlası Burada! İhtiyacınıza Özel Randevu Alın.";
    } elseif (request()->routeIs('search.serviceCityAndDistrictCategorySearch')){
        $title = $district->name. " ". $category->getName(). " Fiyatları & Kampanyaları - Gerçek Müşteri Yorumları | Randevu Al";
        $description = $district->name." ve Çevresindeki En İyi ".$category->getName(). " Hizmetleri: Fiyatlar, Müşteri Yorumları, Kampanyalar, Tavsiyeler ve Daha Fazlası Burada! İhtiyacınıza Özel Randevu Alın.";
    } elseif(request()->routeIs('search.businessCategoryAndCityAndDistrictSearch')){
        $title = $district->name. " ". $category->getName(). " Fiyatları & Kampanyaları - Gerçek Müşteri Yorumları | Randevu Al";
        $description = $district->name." ve Çevresindeki En İyi ".$category->getName(). " : Fiyatlar, Müşteri Yorumları, Kampanyalar, Tavsiyeler ve Daha Fazlası Burada! İhtiyacınıza Özel Randevu Alın.";
    }elseif(request()->routeIs('search.businessCategoryAndCitySearch')){
        $title = $city->name. " ". $category->getName(). " Fiyatları & Kampanyaları - Gerçek Müşteri Yorumları | Randevu Al";
        $description = $city->name." ve Çevresindeki En İyi ".$category->getName(). " : Fiyatlar, Müşteri Yorumları, Kampanyalar, Tavsiyeler ve Daha Fazlası Burada! İhtiyacınıza Özel Randevu Alın.";
    }elseif(request()->routeIs('search.serviceCategorySearch')){
      $title = $category->getName(). " Hizmetlerinde Fiyatlar , Müşteri Deneyimleri, Kampanyalar ve İndirimler - Hemen Randevunuzu Alın!";
      $description = $category->getName(). " Hizmeti Sunan Tüm İşletmelerde: Fiyatlar, Müşteri Yorumları, Fırsatlar, Kampanyalar, Tavsiyeler, Adresler ve Puanlar - En İyi Seçimi Yapmak İçin Her Şey Burada!";
    }elseif(request()->routeIs('search.cityAndCategory')){
      $title = $city->name." ".$category->getName(). ": Fiyatlar, Yorumlar, Kampanyalar ve İndirimler - Randevu Al!";
      $description = $city->name." ".$category->getName(). "Tüm Berberler : Fiyatlar, Müşteri Yorumları, Fırsatlar, Kampanyalar, Tavsiyeler, Adresler ve Puanlar - Herkes için En İyi Berberi Bulun!";
    }
@endphp
