<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use App\Portfolio;
use App\User;

use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Auth::user();
        $portfolio = Portfolio::all()->where('user_id', $users->id);
        // dd($portfolio);
        return view('admin.portfolio', compact('portfolio', 'users'));
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
    public function store(Request $request, User $user)
    {
        // dd($request->all()["file"]);
        request()->validate([
            'file' => 'required',
            'file.*' => 'mimes:jpeg,jpg,png,gif'
        ]);

        $users = Auth::user();
        $portfolio_array = $request->all()["file"];

        if($request->all()["file"])
        {
           foreach($portfolio_array as $img)
           {
                // dd($img);

                // abbiamo creato un nuovo record 
                $portfolio = new Portfolio();

                //mettiamo nella cartella portfolio l'istanza img
                // $new_pic = Storage::put('portfolio', $img);
                $new_pic = Storage::disk('local')->putFile('portfolio', $img);

                //gli diciamo che la image_url è questa img
                $portfolio->image_url = $new_pic;
                //dobbiamo associare l'id dell'utente
                $portfolio->user_id = $users->id;

                //salviamo
                $portfolio->save();

                //il nostro errore è che non crea la cartella portfolio
           }
        }
        
       return redirect()->route("admin.portfolio.index")->with('success', 'Caricamento avvenuto con successo');
    //    return Redirect::to("admin/portfolio")
    //    ->withSuccess('Great! files has been successfully uploaded.');
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
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        return redirect()->route("admin.portfolio.index")->with('deleted', 'Hai cancellato correttamente l\'immagine');
    } 
}
