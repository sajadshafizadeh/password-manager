<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Passwords;
use Validator;
use Exception;

class PasswordsController extends Controller
{

    public function __construct(Request $request)
    {
        // To know the request has came from either api or web route files 
        $request->is('api/*') ? $this->middleware('auth:api') : $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // To get the user id
        $user_id = Auth::id();
        $res = Passwords::where('user_id', $user_id)
                        ->orderBy('id')
                        ->select(['passwords.id', 'username', 'password', 'pt.id as type_id', 'pt.name as type name'])
                        ->join('password_types as pt', 'pt.id', 'passwords.id')
                        ->paginate();

        return response()->json($res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO: Must be implemented for the client interface
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_errors = $inserted = null;

        try {

            // Validationg
            if(!empty($validation_errors = $this->do_validation($request)))
                throw new Exception;

            // Inserting
            $inserted = Passwords::create([
                "username" => $request->username,
                "password" => $request->password,
                "user_id" => Auth::id(),
                "type_id" => $request->type_id
            ]);

            // Check inserting status 
            if ($inserted) $msg = "The new password '". $request->username ."' succesfully inserted";
            else throw new Exception;


            // Error handling
        } catch (Exception $e){
                $msg = $e->getCode() === "23000" ? "Integrity constraint violation - Duplicate entry" : $e->getMessage();
        } 

        // Response
        return response()->json(["message" => $msg, "errors" => $validation_errors, "data" => $inserted]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = Passwords::select('passwords.id', 'username', 'password', 'pt.name as type_name', 'passwords.created_at')
                ->join('password_types as pt', 'pt.id', 'passwords.type_id')->find($id);
        return response()->json($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //TODO: Must be implemented for the client interface
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
        $validation_errors = $updated = null;

        try {

            // Validationg
            if(!empty($validation_errors = $this->do_validation($request)))
                throw new Exception;

            // Finding
            $obj = Passwords::find($id);
            if(empty($obj)) throw new Exception("404 - Not Found");

            // Updating
            $updated = $obj->update([
                "username" => $request->username,
                "password" => $request->password,
                "user_id" => Auth::id(),
                "type_id" => $request->type_id
            ]);

            // Check inserting status 
            if ($updated){
                $msg = "The password '". $request->username ."' succesfully updated";
                // Get the updated object
                $updated = $obj->refresh();
            }
            else throw new Exception;


            // Error handling
        } catch (Exception $e){
                $msg = $e->getCode() === "23000" ? "Integrity constraint violation - Duplicate entry" : $e->getMessage();
        } 

        // Response
        return response()->json(["message" => $msg, "errors" => $validation_errors, "data" => $updated]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            // Finding
            $obj = Passwords::find($id);
            if(empty($obj)) throw new Exception("404 - Not Found");
            
            // Deleting
            $obj->delete();
            $msg = "succesfully deleted";

        } catch (Exception $e) {
            // To detect if this is referenced as the parrent of sth
            $msg = $e->getCode() === "23000" ? "Relation Constraint Violation!" : $e->getMessage();
        }

        return response()->json(["message" => $msg, "errors" => null, "data" => null]);
    }

    /**
     * To validate data entry 
     *
     * @param  Collection  $requests
     * @return Array (errors)
     */

    public function do_validation($reqs){

        $validator = Validator::make($reqs->all(), [
                    'username' => 'required|max:255|string',
                    'password' => [ 'required',
                                    'min:8',
                                    'string',
                                    'confirmed',
                                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
                    'type_id' => 'required|max:12|integer',
                ]);

        if ($validator->fails()) {
            $validation_errors = $validator->errors()->all();  
        }

        return $validation_errors ?? [];
    }


}
