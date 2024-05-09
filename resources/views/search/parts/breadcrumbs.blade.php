@php
    if (request()->routeIs('search.businessCategorySearch')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    }elseif (request()->routeIs('search.service')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $subCategory->getName();
        echo '</li>';
    }
    elseif (request()->routeIs('search.serviceCityAndCategorySearch')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo "<a href=".route('search.citySearch', $city->slug).">".$city->name."</a>";
        echo '</li>';
         echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    }elseif (request()->routeIs('search.serviceCityAndDistrictCategorySearch')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo "<a href=".route('search.citySearch', $city->slug).">".$city->name."</a>";
        echo '</li>';
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $district->name;
        echo '</li>';
         echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    }elseif (request()->routeIs('search.businessCategoryAndCityAndDistrictSearch')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo "<a href=".route('search.citySearch', $city->slug).">".$city->name."</a>";
        echo '</li>';
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $district->name;
        echo '</li>';
         echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    }elseif (request()->routeIs('search.businessCategoryAndCitySearch')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo "<a href=".route('search.citySearch', $city->slug).">".$city->name."</a>";
        echo '</li>';
         echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    }elseif (request()->routeIs('search.serviceCategorySearch')){
         echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    }elseif (request()->routeIs('search.cityAndCategory')){
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo "<a href=".route('search.citySearch', $city->slug).">".$city->name."</a>";
        echo '</li>';
         echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo $category->getName();
        echo '</li>';
    } else{
        echo "<li class='breadcrumb-item active' aria-current='page'>";
         echo "İşletme Listesi";
        echo '</li>';
    }
@endphp
