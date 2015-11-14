<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Task;
use Illuminate\Http\Request;

// Display all tasks
Route::get('/', function () {
	$tasks = Task::orderBy('created_at', 'asc')->get();

	return view('tasks', [
			'tasks' => $tasks
		]);
});

// add a task
Route::post('/task', function(Request $request){

	# do the validation on input fields
	$validator = Validator::make($request->all(),[
		'name' => 'required|max:255'
	]); 

	# if validation fails, redirect where it came from
	if ($validator->fails()) {
		return redirect('/')->withInput()->withErrors($validator);
	}

	# validation passed
	# now add it to out task list
	
	$task = new Task;
	$task->name = $request->name;
	$task->save();

	return redirect('/');

});


// delete a task with given id
Route::delete('/task/{id}', function($id){
	Task::findOrFail($id)->delete();

  return redirect('/');
});