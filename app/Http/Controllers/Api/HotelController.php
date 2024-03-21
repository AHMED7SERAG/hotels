<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HotelController extends Controller
{
    public function search(Request $request)
    {
        $filteredHotels = $this->fetchHotels();
        $filteredHotels = $filteredHotels['hotels'];
            // Search by hotel name
            if ($request->has('name')) {
                $name = $request->input('name');
                $filteredHotels = $this->filterByName($name, $filteredHotels);
            }
    
            // Search by destination (city)
            if ($request->has('city')) {
                $city = $request->input('city');
                $filteredHotels = $this->filterByCity($city, $filteredHotels);
            }
    
            // Search by price range
            if ($request->has('price_range')) {
                $priceRange = $request->input('price_range');
                $filteredHotels = $this->filterByPriceRange($priceRange[0], $priceRange[1], $filteredHotels);
            }
    
            // Search by date range (availability)
            if ($request->has('date_range')) {
                $dateRange =  $request->input('date_range');
                $filteredHotels = $this->filterByDateRange($dateRange[0], $dateRange[1], $filteredHotels);
            }
    
            return response()->json([ array_values($filteredHotels)]);
    }
       

    private function fetchHotels()
    {
        $response = Http::get('https://api.npoint.io/dd85ed11b9d8646c5709');
        return $response->json();
    }
    public function sort(Request $request)
    {
        $sortedHotels = $this->fetchHotels();
        $sortedHotels = $sortedHotels['hotels'];
        // Sort by hotel name
        if ($request->has('sort_by') && $request->input('sort_by') === 'name') {
            usort($sortedHotels, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            // dd("ssss");
        }

        // Sort by price
        if ($request->has('sort_by') && $request->input('sort_by') === 'price') {
            usort($sortedHotels, function ($a, $b) {
                return $a['price'] - $b['price'];
            });
        }
// dd(count($sortedHotels));
        return response()->json([array_values($sortedHotels)] );
    }

    private function filterByName($name, $hotels)
    {
        return array_filter($hotels, function ($hotel) use ($name) {
            return stripos($hotel['name'], $name) !== false;
        });
    }

    private function filterByCity($city, $hotels)
    {
        return array_filter($hotels, function ($hotel) use ($city) {
            return strtolower($hotel['city']) === strtolower($city);
        });
    }

    private function filterByPriceRange($minPrice, $maxPrice, $hotels)
    {
        return array_filter($hotels, function ($hotel) use ($minPrice, $maxPrice) {
            return $hotel['price'] >= $minPrice && $hotel['price'] <= $maxPrice;
        });
    }
    private function filterByDateRange($startDate, $endDate, $hotels)
    {
        return array_filter($hotels, function ($hotel) use ($startDate, $endDate) {
            foreach ($hotel['availability'] as $availability) {
                $from = strtotime($availability['from']);
                $to = strtotime($availability['to']);
                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);
                if ($from <= $startDate && $to >= $endDate) {
                    return true;
                }
            }
            return false;
        });
    }
  

 
   

   
}
