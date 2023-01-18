<?php 
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Columns;
    
class ColumnsController extends Controller
{

    function __construct()
    {
    }
    
	/**
     * Columns List
     *
     * @param  array  $request
     * @return json array response
     */
    public function columns(Request $request)
    {
		$columns = Columns::all();
		return response()->json([
			'title' => 'Success.',
			'message' => 'Columns List.',
			'data' => $columns
		], 200);
		
    }
	public function save(Request $request)
    {
		$name = $request->name;
		$newColumn = new Columns;
		$newColumn->name = $name;
		$newColumn->save();
		return response()->json([
			'title' => 'Success.',
			'message' => 'New column added.',
			'data' => $newColumn
		], 200);
		
    }
	public function delete($id)
    {
		$column = Columns::find($id);
		if($column){
			$column->cards()->delete();
			$column->delete();
		}
		return response()->json([
			'title' => 'Success.',
			'message' => 'Column deleted.',
			'data' => $column
		], 200);
		
    }
	public function export(Request $request){
		\Spatie\DbDumper\Databases\MySql::create()
			->setDumpBinaryPath('D:\xampp\mysql\bin')
			->setDbName(env('DB_DATABASE'))
			->setUserName(env('DB_USERNAME'))
			->setPassword(env('DB_PASSWORD'))
			->setHost(env('DB_HOST'))
			->dumpToFile('dump.sql');
	}
	
}