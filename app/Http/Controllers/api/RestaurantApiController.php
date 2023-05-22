<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Type;
use Illuminate\Http\Request;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;


class RestaurantApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $restaurants = Restaurant::where('name', '<>', null)
        ->with('types')
        ->paginate(5);
        return response()->json(
            $restaurants
        );
    }

    public function search($type, $query)
    {
        if ($type == 'all'){
            $restaurants = Restaurant::where('name', 'like', '%'.$query.'%')->with('types')->get();
            return $this->paginate($restaurants, 5);
        }
        else{
            if($query == 'null'){
                $type = Type::where('name', '=', $type)->first();
                $restaurants = $type->restaurants;
                $response = collect();
                foreach($restaurants as $restaurant)
                {
                    $response->add($restaurant);
                }
                return $this->paginate($response, 5);
            }
            else{
                $type = Type::where('name', '=', $type)->first();
                $restaurants = $type->restaurants;
                $response = collect();
                foreach($restaurants as $restaurant)
                {
                    if(str_contains(strtolower($restaurant->name), strtolower($query)))
                    {
                        $response->add($restaurant);
                    }
                }
                return $this->paginate($response, 5);
            }
        }
        return $this->paginate($restaurants, 5);
    }

    public function dishesByName($id, $query){
        $restaurant = Restaurant::all()->where('id', '==', $id)->first();
        $response = collect();
        foreach($restaurant->dishes as $dish){
            if(str_contains(strtolower($dish->name), strtolower($query))){
                $response->add($dish);
            }
        }
        return $response;
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('dishes')->where('id', '=', $id)->first();
        return response()->json(
            $restaurant
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function paginate(Collection $results, $showPerPage)
    {
        $pageNumber = Paginator::resolveCurrentPage('page');
        
        $totalPageNumber = $results->count();

        return self::paginator($results->forPage($pageNumber, $showPerPage), $totalPageNumber, $showPerPage, $pageNumber, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
