<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

// per paginazione ecreare una collection 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

// Tutti i model dello user
use App\User;
use App\UserDetail;
use App\Specialization;
use App\PromoUser;
use Carbon\Carbon;
use App\Review;
use App\Portfolio;


class UserController extends Controller
{
    public function index(){

    }
    // PAGINA HOME - SLIDER SPECIALIZZAZIONI
    public function specializations(){

        $specializations = Specialization::all();
        
        return response()->json([
            'success' => true,
            'results' => $specializations
        ]);
    }
    // PAGINA HOME - SLIDER SPONSORIZZATI
    public function sponsored(){
        
        // CONTROLLO PROMO 
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
        // END CONTROLLO PROMO 

        $sponsored = User::whereHas('promoUsers')->with('user_details', 'specializations','promoUsers')->get();

        return response()->json([
            'success' => true,
            'results' => $sponsored
        ]);
    }
    // PAGINA SEARCH 
    public function search($spec_slug, $checkbox, $checkboxVote){

        //  funzione per creare la collezione paginata come paginate 
        function paginate($items, $perPage = 2, $page = null, $options = [])
        {
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

            // trasformo array in collection per poterla inpaginare
            $items = $items instanceof Collection ? $items : Collection::make($items);
            //

            return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        }
        //
        // CONTROLLO PROMO 
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
        // END CONTROLLO PROMO 


        // prendo la specializzazione cliccata dall'utente 
        $specializzazioni = Specialization::where('slug_specialization', $spec_slug)->first();

        // NON TOCCARE 
        // prendo tutti gli utenti che hanno la  specializzazione cliccata dall'utente CON LE PROMO
        $botanici = User::whereHas('specializations', function($query) use ($specializzazioni) {
            $query->whereRaw('specialization_id =' . $specializzazioni->id);
         })->whereHas('promoUsers')->with('user_details', 'specializations', 'reviews','promoUsers')->get();
         //
        // prendo tutti gli utenti che hanno la  specializzazione cliccata dall'utente SENZA PROMO
        $botaniciSenzaPromo = User::whereHas('specializations', function($query) use ($specializzazioni) {
            $query->whereRaw('specialization_id =' . $specializzazioni->id);
         })->whereDoesntHave('promoUsers')->with('user_details', 'specializations', 'reviews')->get();
         //
        //  PER OGNI UTENTE CON PROMO AGGIUNGO NUMERO RCENSIONI E MEDIA VOTI ((DA VEDERE!!))
        foreach($botanici as $k => $botanico){
            
            // conto il numero di (recensioni/voti) di ogni botanico e setto un campo avg cioè media
            $botanico['nVote'] = count($botanico['reviews']);
            $botanico['avg'] = 0;
            //

            // sommo al campo media tutti i voti nelle reviews 
            foreach($botanico['reviews'] as $review){
                $botanico['avg'] += $review['vote'];
            }
            //

            // divido avg per il numero di voti cosi da ottenere la media 
            if($botanico['nVote'] != 0){
                $botanico['avg'] /= $botanico['nVote'];
            } else {
                $botanico['avg'] = 0;
                $botanico['nVote'] = 0;
            }
            $botanico['avg'] = round($botanico['avg'],2);
            //
        };
        //  PER OGNI UTENTE SENZA PROMO AGGIUNGO NUMERO RCENSIONI E MEDIA VOTI ((DA VEDERE!!))
        foreach($botaniciSenzaPromo as $k => $botanicoSenzaPromo){
    
            // conto il numero di (recensioni/voti) di ogni botanicoSenzaPromo e setto un campo avg cioè media
            $botanicoSenzaPromo['nVote'] = count($botanicoSenzaPromo['reviews']);
            $botanicoSenzaPromo['avg'] = 0;
            //

            // sommo al campo media tutti i voti nelle reviews 
            foreach($botanicoSenzaPromo['reviews'] as $review){
                $botanicoSenzaPromo['avg'] += $review['vote'];
            }
            //

            // divido avg per il numero di voti cosi da ottenere la media 
            if($botanicoSenzaPromo['nVote'] != 0){
                $botanicoSenzaPromo['avg'] /= $botanicoSenzaPromo['nVote'];
            } else {
                $botanicoSenzaPromo['avg'] = 0;
                $botanicoSenzaPromo['nVote'] = 0;
            }
            $botanicoSenzaPromo['avg'] = round($botanicoSenzaPromo['avg'],2);
            //
        };
        // transformo una colection in array per fare il sort 
        $botanici = $botanici->toArray();
        $botaniciSenzaPromo = $botaniciSenzaPromo->toArray();

        //
        //controllo se ha cliccato una delle checkbox e faccio il sort DEI DUEI ARRAY SEPARATAMENTE
        // if($checkbox == 1) {
        //     usort($botanici,function($a, $b)
        //     {
        //         if ($a["nVote"] == $b["nVote"])
        //             return (0);
        //         return (($a["nVote"] > $b["nVote"]) ? -1 : 1);
        //     });
        //     usort($botaniciSenzaPromo,function($a, $b)
        //     {
        //         if ($a["nVote"] == $b["nVote"])
        //             return (0);
        //         return (($a["nVote"] > $b["nVote"]) ? -1 : 1);
        //     });
        // }

        // if($checkboxVote == 1) {

        //     usort($botanici,function($a, $b)
        //     {
        //         if ($a["avg"] == $b["avg"])
        //             return (0);
        //         return (($a["avg"] > $b["avg"]) ? -1 : 1);
        //     });
        //     usort($botaniciSenzaPromo,function($a, $b)
        //     {
        //         if ($a["avg"] == $b["avg"])
        //             return (0);
        //         return (($a["avg"] > $b["avg"]) ? -1 : 1);
        //     });  
        // }

        //
        // unisco i due array mettendendo prima BOTANICI CON PROMO E POI BOTANICI SENZA PROMO
        foreach ($botaniciSenzaPromo as $key => $botanicoSenzaPromo) {
            $botanici[] = $botanicoSenzaPromo;
        }

        if($checkbox == 1) {
            usort($botanici,function($a, $b)
            {
                if ($a["nVote"] == $b["nVote"])
                    return (0);
                return (($a["nVote"] > $b["nVote"]) ? -1 : 1);
            });
        }

        if($checkboxVote == 1) {
            usort($botanici,function($a, $b)
            {
                if ($a["avg"] == $b["avg"])
                    return (0);
                return (($a["avg"] > $b["avg"]) ? -1 : 1);
            });
        }

        //
        // transformo $botanici in una collection e poi faccio l'impaginazione
        $botanici = paginate($botanici,2);
        //
        return response()->json([
            'success' => true,
            'results' => $botanici
        ]);

        //  $botanici = User::with('user_details', 'specializations', 'reviews')
        //     ->whereHas('specializations', function ($query) use ($specializzazioni) {
        //     $query->where('specialization_id', $specializzazioni->id);
        //     })
        //     ->paginate(2);


    // NON TOCCARE 

    }

    public function profile($slug){
        
        $profile = User::where('slug', $slug)->with(['user_details', 'specializations', 'reviews', 'portfolios'])->first();
        
        return response()->json([
            'success' => true,
            'results' => $profile,
         ]);
    }

    public function reviews(Request $request){
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            // 'rating' => 'numeric',
            'name' => 'required',
            'feedback' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }else{
            $new_review = new Review();
            $new_review->fill($data);
            $new_review->save();

            return response()->json([
                'success' => true,
                'results' => $new_review
            ]);
        }

        
    }
    public function searchByOrder($spec_slug) {
        $specializzazioni = Specialization::where('slug_specialization', $spec_slug)->first();

        $botanici = User::with('user_details', 'specializations', 'reviews')
        ->whereHas('specializations', function ($query) use ($specializzazioni) {
        $query->where('specialization_id', $specializzazioni->id);
        })
        ->orderBy('reviews')
        ->paginate(2);

    }

    
}
