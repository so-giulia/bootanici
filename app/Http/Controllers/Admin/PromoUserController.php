<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Portfolio;
use App\UserDetail;
use App\Lead;
use App\Promo;
use App\Review;
use App\PromoUser;
use Carbon\Carbon;
use Braintree\Gateway;
use Illuminate\Support\Facades\Redirect;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;



use App\Specialization;
use Illuminate\Support\Facades\Auth;



class PromoUserController extends Controller
{
    

    function index(Request $request,Gateway $gateway, $promo) {

        // cerca per la promozione e calcolo di quante promozioni applicare
        $promozione = Promo::where('id', $promo)->get();
        // validazioni nuova promo
        $request->validate(
            [
                'number_promo' => 'required|integer',
            ]
        );

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
        // prendo il token 
        $token = $gateway->clientToken()->generate();
        $data = [
            'token' => $token,
            'promozione' => $promozione,
            'npromos' => $request->get('number_promo')
        ];
        // admin.home ha bisogno di questi dati 
        // $promo = Promo::where('id',$promo)->first();
        // $promos = Promo::all();
        // 
        return view('admin.promo', compact('data'));


    }

    public function makePayment(Request $request,Gateway $gateway,$promo,$npromo) {
        
        // calcolo prezzo, ore totali 
        $promozione = Promo::where('id', $promo)->get();
        $addHours = $promozione[0]->duration * $npromo;
        $amount = $promozione[0]->price * $npromo;
        //
        // mando dati e il token a braintree
        $result = $gateway->transaction()->sale([

            'amount' => $amount,
            'paymentMethodNonce' => $request->all()['payment_method_nonce'],
            'options' => [
                'submitForSettlement' => true
            ]         
            ]);
        //
        // controllo la risposta di braintree
        if($result->success) {
            $users = Auth::user();

            $newPromoUser = new PromoUser();
            $newPromoUser->promo_id = $promo;
            $newPromoUser->user_id = $users->id;
            $newPromoUser->start = Carbon::now();
            $newPromoUser->end =Carbon::now()->addHours($addHours);
            $newPromoUser->save();
            // $users = $users->toArray();

            // Mail::to('emmanuel.paris@icloud.com')->send(new SendNewMail($users));

             return redirect()->to('admin/user')->with('messagePromo', 'Hai acquistato la promo con successo');
        } else {
            return redirect()->to('admin/user')->with('messaggino', 'Il pagamento non è andato a buon fine');
        }
        
    }
}
