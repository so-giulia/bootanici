<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Portfolio;
use App\UserDetail;
use App\Lead;
use App\Promo;
use App\PromoUser;
use App\Review;
use App\Specialization;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Redirect;
use Carbon\Carbon;

// per paginazione ecreare una collection 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    /**
     * 
     * 
        
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $user)
    {
        // prendo l'utente che si logga
        $users = Auth::user();
        $promos = Promo::all();


        $messaggi = Lead::where('user_id', $users->id)->orderBy('created_at', 'DESC')->paginate(1, ['*'], 'messaggi');
        $recs = Review::where('user_id', $users->id)->orderBy('created_at', 'DESC')->paginate(1, ['*'], 'recs');
        $newDateFormat = $users->created_at->format('d/m/Y H:i');

        
         $totalMex= $messaggi->total();
        

        // mediavoti
        // dd($users->reviews);
        $avgVote=0;
        foreach($users->reviews as $rec){
            $avgVote+= $rec['vote'] / $recs->total();
            $avgVote = round($avgVote,2);
        }
        
        


        // prendo tutti gli utenti 
        $utenti = User::all();
        // ciclo tutti gli utenti per controllora le tabelle PromoUser
        foreach($utenti as $utente) {
            
            // controllo se ci sono campi nelle tabelle 
            if(count($utente->promoUsers) != 0){
                // prendo l'ora attuale 
                $timeNow = Carbon::parse(Carbon::now());
                //
                // prendo il campo end del record 
                $end = Carbon::parse($utente->promoUsers[0]->end);
                //
                // faccio differenza tra ora attuale e end 
                $end = $end->diffInMinutes($timeNow, false);
                // 
                // se la differenza è 0 
                if($end >= 0) {
                PromoUser::where('user_id', $utente->id )->delete();
                }  
                // 
            }
        }
        return view('admin.home', compact('users', 'user', 'messaggi','promos', 'recs', 'newDateFormat', 'totalMex', 'avgVote'));

    }

          

 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create(User $user)
 {
     // passo il profilo per vedere le tabelle da aggiornare sul create 
     $users = Auth::user();
     // $userDetails=UserDetail::where('user_id', $users->id)->first();
     $specs = Specialization::all();

     return view('admin.create', compact('users', 'user', 'specs'));
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
     // validation user 
     $request->validate(
         [
             'propic_url' => 'required|image',
             'bio' => 'required|max:500',
             'service' => 'required|max:300',
             'phone' => 'nullable|numeric',
             'avg_hourly_rate' => 'required|numeric|between:0,99.99',
             'specs' => 'required'
         ]
     );
     // 

     // assegno ai campi del form creati l'id dello user 
     $users = Auth::user();
     $data = $request->all();
     $data['user_id'] = $users->id;
     // 
     // creo un nuovo record nella tabella UserDetail 
     $newUserDetail = new UserDetail();

     // aggiungiamo la img_url alla cartella storage
     $new_pic = Storage::put('propics', $data["propic_url"]);
     $data["propic_url"] = $new_pic;

     // riempo il record con i data e salvo i dati 
     $newUserDetail->fill($data);
     $newUserDetail->save();
     // 
     // attacco all'utente le specializzazioni
     $users->specializations()->attach($data['specs']);

     // lo rimando sulla index che lo manda sulla /admin/home
      return redirect()->route('admin.user.index')->with('add_details', 'Complimenti bootanico hai compleato il tuo profilo!');
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show(User $user)
 {
     

     $users = Auth::user();
     $portfolio = Portfolio::all()->where('user_id', $user->id);
     $specializations = Specialization::all();

     return view('admin.show', compact('user', 'users', 'specializations', 'portfolio'));
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit(User $user)
 {
     $users = Auth::user();
     $specializations = Specialization::all();
     $details = $users->user_details;
     return view('admin.edit', compact('details','specializations', 'user', 'users'));

 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, UserDetail $userDetail, User $user)
 {
     // validation
     $request->validate(
         [
             'name' => 'required|string',
             'last_name' => 'required|string',
             'address' => 'required|string|max:100',
             'cap' => 'required|numeric|digits:5',
             'propic_url' => 'image',
             'bio' => 'required|max:500',
             'service' => 'required|max:300',
             'phone' => 'nullable|numeric',
             'avg_hourly_rate' => 'required|numeric|between:0,99.99'
         ]
     );

     // assegno ai campi del form creati l'id dello user 
     $users = Auth::user();
     $data = $request->all();
     $utente = UserDetail::where('user_id',$users->id)->first();

     // ricreo lo slug se l'utente cambia nome o cognome
     $created_slug = Str::slug($data['name'] . ' ' . $data['last_name'] . '-');
     $existing_slug = User::where('slug', $created_slug)->first();
     $counter = 1;

     while($existing_slug) {
         $created_slug .= '-' . $counter;

         // ricontrollo che non ci sia sul database 
         $existing_slug = User::where('slug', $created_slug)->first();

         $counter++;
     }
     //lo salvo
     $users->slug = $created_slug;

     // se dal form dell'edit ricevo una propic url
     if( array_key_exists('propic_url', $data) ){
         //mi creo una nuova propic url
         $new_pic = Storage::put('propics', $data['propic_url']);

         // e cancello l'immagine che già c'è nel db
         Storage::delete($utente->propic_url);

         // salvo nei data
         $data["propic_url"] = $new_pic;
     }else{
         // altrimenti nei miei data ci sarà l'immagine vecchia
         $data["propic_url"] = $utente->propic_url;
     }

     // update dati
     $utente->update($data);
     $users->update($data);
     $users->specializations()->sync($data['specializations']);

     return redirect()->route('admin.user.index')->with('edited', 'Hai correttamente modificato il tuo profilo');
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy(User $user)
 {
     $user->delete();
     $user->specializations()->detach();

     return redirect(url('login'));
 }
}
         
        


