<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Gen;
use DB;

class GenController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $userid = Auth::user()->id;
        $gen = Gen::where('user_id', $userid)->get();
        return view('gen.index')->with('gen', $gen);
    }

    public function getData() {
        
        try {
            //Get The key
            $gen = Gen::where('user_id', null)->first();
            if(Auth::check() == false) {
                throw new \Exception('Not Authorized');
            }
            if($gen == null) {
                throw new \Exception('No Keys are available');
            }
            $userId = Auth::id();
            $user = User::find($userId);            
            $date = date('Y-m-d');
            $todayGeneration = Gen::where('user_id', $userId)->where('gen_at', $date)->count();

            if($user->gen_limit == null) {
                throw new \Exception('Please Buy Subscription');
            }

            if ($user->gen_limit <= $todayGeneration) {
                throw new \Exception('Today Limit Exceed');
            }

            $gen->user_id = $userId;
            $gen->gen_at = $date;
            $gen->save();
            return json_encode($gen->stkey);
            
        } catch(\Exception $e) {
            return json_encode($e->getMessage());
        }
    
    }

    public function admin() {
        if (Auth::id() == 1) {
            $users = User::all();
            return view('admin.index')->with('users', $users);
        } else {
            abort(404);
        }
    }


    public function setLimit(Request $request) {
        $user = User::find($request->user_id);
        $user->gen_limit = $request->gen_limit;
        if ($user->save()) {
            return redirect('/admin')->with('msg', 'Limit Sucessfully Changed');
        } else{
            return 'ERROR';
        }
    }


    public function addKeys(Request $request) {

        $key = new Gen;
        $key->stkey = $request->input('stkey');

        if($key->stkey) {
            if($key->save()) {
                $msg = "Key Added";
            } 
        }
        else {
            $msg = "Please Enter a key";
        }

        return redirect('/admin')->with('msg', $msg);
    }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
}
