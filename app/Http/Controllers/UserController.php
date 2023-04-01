<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
Class UserController extends Controller {
private $request;
public function __construct(Request $request){
$this->request = $request;
}
public function aimex(){ /*Return/GE the list of users*/
    $users = User::all();
    return response()->json($users, 200);
}
public function show($id) /*Update the existing author*/
{
    return User::where('id','like','%'.$id.'%')->get();
}
public function ADD(Request $request ){ /*create new user*/
    $rules = [
    'firstName' => 'required|max:20',
    'lastName' => 'required|max:20',
    ];
    $this->validate($request,$rules);
    $user = User::create($request->all());
    return $user;
   
}
public function UPD(Request $request,$id) /*update and existing author*/
{
$rules = [
'firstName' => 'max:20',
'lastName' => 'max:20',
];
$this->validate($request, $rules);
$user = User::findOrFail($id);
$user->fill($request->all());

// if no changes happen
if ($user->isClean()) {  /*remove an existing user*/
return $this->errorResponse('At least one value must
change', Response::HTTP_UNPROCESSABLE_ENTITY);
}
$user->save();
return $user;
}
public function DELETE($id) 
{
$user = User::findOrFail($id);
$user->delete();


}
}
