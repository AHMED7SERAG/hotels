<?php


namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Api\HotelController;

class HotelControllerTest extends TestCase
{
    /** @test */
    public function it_can_sort_hotels_by_name()
    {
        // Arrange
        $controller = new HotelController();
    
        // Act
        $response = $controller->sort(request()->merge(['sort_by' => 'name']));
    
        // Extract hotel names from the response
        $sortedHotels = collect($response->getData()[0])->pluck('name')->toArray();
        // Expected order of hotel names after sorting
        $expectedOrder = [
            [
                "city" => "Manila",
                "name" => "Concorde Hotel",
                "price" => 79.4,
                "availability" => [
                    ["to" => "19-10-2023", "from" => "10-10-2023"],
                    ["to" => "22-11-2023", "from" => "22-10-2023"],
                    ["to" => "20-12-2023", "from" => "03-12-2023"]
                ]
            ],
            [
                "city" => "paris",
                "name" => "Golden Tulip",
                "price" => 109.6,
                "availability" => [
                    ["to" => "17-10-2023", "from" => "04-10-2023"],
                    ["to" => "11-11-2023", "from" => "16-10-2023"],
                    ["to" => "09-12-2023", "from" => "01-12-2023"]
                ]
            ],
            [
                "city" => "london",
                "name" => "Le Meridien",
                "price" => 89.6,
                "availability" => [
                    ["to" => "12-10-2023", "from" => "01-10-2023"],
                    ["to" => "10-11-2023", "from" => "05-10-2023"],
                    ["to" => "28-12-2023", "from" => "05-12-2023"]
                ]
            ],
            [
                "city" => "dubai",
                "name" => "Media One Hotel",
                "price" => 102.2,
                "availability" => [
                    ["to" => "15-10-2023", "from" => "10-10-2023"],
                    ["to" => "15-11-2023", "from" => "25-10-2023"],
                    ["to" => "15-12-2023", "from" => "10-12-2023"]
                ]
            ],
            [
                "city" => "Vienna",
                "name" => "Novotel Hotel",
                "price" => 111,
                "availability" => [
                    ["to" => "28-10-2023", "from" => "20-10-2023"],
                    ["to" => "20-11-2023", "from" => "04-11-2023"],
                    ["to" => "24-12-2023", "from" => "08-12-2023"]
                ]
            ],
            [
                "city" => "cairo",
                "name" => "Rotana Hotel",
                "price" => 80.6,
                "availability" => [
                    ["to" => "12-10-2023", "from" => "10-10-2023"],
                    ["to" => "10-11-2023", "from" => "25-10-2023"],
                    ["to" => "18-12-2023", "from" => "05-12-2023"]
                ]
            ]
        ];
        $expectedOrder =collect($expectedOrder)->pluck('name')->toArray();
    // dd(count($sortedHotels) ." sss " .count($expectedOrder));
        // Assert
        $this->assertEquals($expectedOrder, $sortedHotels);
    }

    /** @test */
    public function it_can_sort_hotels_by_price()
    {
        $controller = new HotelController();

        $response = $controller->sort(request()->merge(['sort_by' => 'price']));

        $sortedPrices = collect($response->getData()[0])->pluck('price')->toArray();
        $expectedOrder = [
            [
                "city" => "Manila",
                "name" => "Concorde Hotel",
                "price" => 79.4,
                "availability" => [
                    ["to" => "19-10-2023", "from" => "10-10-2023"],
                    ["to" => "22-11-2023", "from" => "22-10-2023"],
                    ["to" => "20-12-2023", "from" => "03-12-2023"]
                ]
            ],
            [
                "city" => "cairo",
                "name" => "Rotana Hotel",
                "price" => 80.6,
                "availability" => [
                    ["to" => "12-10-2023", "from" => "10-10-2023"],
                    ["to" => "10-11-2023", "from" => "25-10-2023"],
                    ["to" => "18-12-2023", "from" => "05-12-2023"]
                ]
            ],
            [
                "city" => "london",
                "name" => "Le Meridien",
                "price" => 89.6,
                "availability" => [
                    ["to" => "12-10-2023", "from" => "01-10-2023"],
                    ["to" => "10-11-2023", "from" => "05-10-2023"],
                    ["to" => "28-12-2023", "from" => "05-12-2023"]
                ]
            ],
            [
                "city" => "dubai",
                "name" => "Media One Hotel",
                "price" => 102.2,
                "availability" => [
                    ["to" => "15-10-2023", "from" => "10-10-2023"],
                    ["to" => "15-11-2023", "from" => "25-10-2023"],
                    ["to" => "15-12-2023", "from" => "10-12-2023"]
                ]
            ],
            [
                "city" => "paris",
                "name" => "Golden Tulip",
                "price" => 109.6,
                "availability" => [
                    ["to" => "17-10-2023", "from" => "04-10-2023"],
                    ["to" => "11-11-2023", "from" => "16-10-2023"],
                    ["to" => "09-12-2023", "from" => "01-12-2023"]
                ]
            ],
            [
                "city" => "Vienna",
                "name" => "Novotel Hotel",
                "price" => 111,
                "availability" => [
                    ["to" => "28-10-2023", "from" => "20-10-2023"],
                    ["to" => "20-11-2023", "from" => "04-11-2023"],
                    ["to" => "24-12-2023", "from" => "08-12-2023"]
                ]
            ]
        ];
        $expectedOrder =collect($expectedOrder)->pluck('price')->toArray();

        
        $this->assertEquals($expectedOrder, $sortedPrices);
    }

    /** @test */
    public function it_can_search_hotels_by_name()
    {
        $controller = new HotelController();

        $response = $controller->search(request()->merge(['name' => 'Le Meridien']));
        // dd($response->getData());
        $this->assertCount(1, $response->getData());
        // dd($response->get);

        $hotels= collect($response->getData()[0])->pluck('name')->toArray();
        $expectedOrder = [[
            "city" => "london",
            "name" => "Le Meridien",
            "price" => 89.6,
            "availability" => [
                ["to" => "12-10-2023", "from" => "01-10-2023"],
                ["to" => "10-11-2023", "from" => "05-10-2023"],
                ["to" => "28-12-2023", "from" => "05-12-2023"]
            ]
        ]];
        $expectedOrder =collect($expectedOrder)->pluck('name')->toArray();

        $this->assertEquals( $expectedOrder, $hotels);
    }

    /** @test */
    public function it_can_search_hotels_by_city()
    {
        $controller = new HotelController();

        $response = $controller->search(request()->merge(['city' => 'london']));
        $hotels= collect($response->getData()[0])->pluck('city')->toArray();
        $expectedOrder = [[
            "city" => "london",
            "name" => "Le Meridien",
            "price" => 89.6,
            "availability" => [
                ["to" => "12-10-2023", "from" => "01-10-2023"],
                ["to" => "10-11-2023", "from" => "05-10-2023"],
                ["to" => "28-12-2023", "from" => "05-12-2023"]
            ]
        ]];
        $expectedOrder =collect($expectedOrder)->pluck('city')->toArray();

        $this->assertCount(1, $response->getData());
        $this->assertEquals( $expectedOrder, $hotels);
    }

}
