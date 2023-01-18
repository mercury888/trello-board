<?php 
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cards;
    
class CardsController extends Controller
{

    function __construct()
    {
    }
    
	/**
     * Cards List
     *
     * @param  array  $request
     * @return json array response
     */
    public function cards(Request $request)
    {
		$cards = Cards::all();
		return response()->json([
			'title' => 'Success.',
			'message' => 'Cards List.',
			'data' => $cards
		], 200);
		
    }
	public function listCards(Request $request)
    {
		$column_id = $request->column_id;
		$cards = Cards::where('column_id',$column_id)->orderBy('orderindex', 'asc')->get();
		return response()->json([
			'title' => 'Success.',
			'message' => 'Cards List.',
			'data' => $cards
		], 200);
		
    }
	public function save(Request $request)
    {
		$newCard = new Cards;
		$newCard->name = $request->name;
		$newCard->column_id = $request->column_id;
		$newCard->save();
		return response()->json([
			'title' => 'Success.',
			'message' => 'New card added.',
			'data' => $newCard
		], 200);
		
    }
	public function update(Request $request)
    {
		$newCard = Cards::find($request->id);
		$newCard->name = $request->name;
		$newCard->description = $request->description;
		$newCard->save();
		return response()->json([
			'title' => 'Success.',
			'message' => 'Card Updated.',
			'data' => $newCard
		], 200);
		
    }
	public function updateall(Request $request)
    {
		$cardsInstance = new Cards;
		$value = $request->data;
		$index = 'id';
		\Batch::update($cardsInstance, $value, $index);
    }
	
}