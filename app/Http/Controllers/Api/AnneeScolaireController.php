<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnneeScolaireController extends BaseController
{
    // public function __construct() {

    //     $this->middleware('auth:api');

    // }

    public function index(){

        $anneeScolaires = AnneeScolaire::all();

        if (count($anneeScolaires) == 0) {

            return response()->json([
                'message' => 'Aucune rentrée scolaire n\'est enregistrée',
            ], 201);

        } else {

            return response()->json([
                'message' => 'liste de toutes les rentrées scolaires',
                'anneeScolaires' => $anneeScolaires
            ], 201);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return response()->json([
            'message' => 'Formulaire d\'enregistrement',
            'Rentrée Scolaire' => [
                'dateDebut' => '',
                'dateFin' => '',
                'TypePeriode' => '',
            ],
           
        ], 201);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(Request $request) {

        $datas = $request->all();
        $validator = Validator::make($datas, [
            'dateDebut' => 'required|date_format:d/m/Y',
            'dateFin' => 'required|date_format:d/m/Y',
            'TypePeriode' => 'required|string',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($datas['dateDebut'] < $datas['dateFin'] ){

            $dateDebut = date_parse($datas['dateDebut']);

            $dateFin = date_parse($datas['dateFin']);

            $anneeDebut = $dateDebut['year'];

            $anneeFin = $dateFin['year'];

            $datas['anneeScolaire'] = $anneeDebut.'-'.$anneeFin ;

            $anneeScolaire = AnneeScolaire::create($datas);

            return $this->sendResponse( $anneeScolaire, 'Une Nouvelle Rentrée Scoalire a été enregistre avec succès.');

        }else{
            return $this->sendError('Ooops Desolé. La date de fin est anterieure à la date du debut');
        }
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try {
            $anneeScolaire = AnneeScolaire::findOrFail($id);

            return response()->json([$anneeScolaire]);

        } catch (ModelNotFoundException $modelNotFoundException){

            return $this->sendError('Aucune Information trouvée.');

        }
        
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
        $datas = $request->all();
        $validator = Validator::make($datas, [
            'dateDebut' => 'required|date_format:d/m/Y',
            'dateFin' => 'required|date_format:d/m/Y',
            'TypePeriode' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($datas['dateDebut'] < $datas['dateFin'] ){

            $dateDebut = date_parse($datas['dateDebut']);

            $dateFin = date_parse($datas['dateFin']);

            $anneeDebut = $dateDebut['year'];

            $anneeFin = $dateFin['year'];

            $datas['anneeScolaire'] = $anneeDebut.'-'.$anneeFin ;

            $anneeScolaire = AnneeScolaire::findOrFail($id);

            $anneeScolaire->update($datas);

            return $this->sendResponse( $anneeScolaire, 'Une Nouvelle Rentrée Scoalire a été modifiée avec succès.');

        }else{
            return $this->sendError('Ooops Desolé. La date de fin est anterieure à la date du debut');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, $id)
    {

        $anneeScolaireMoment = AnneeScolaire::where('status', 'En Cours')->get();

        if (count($anneeScolaireMoment) == 1) {

            $anneeScolaireMoment->status = "Terminée";

            $anneeScolaire = AnneeScolaire::findOrFail($id);
            
            $anneeScolaire->status = "En Cours";

            $anneeScolaire->update();

        }else{

            $anneeScolaire = AnneeScolaire::findOrFail($id);
        
            $anneeScolaire->status = "En Cours";

            $anneeScolaire->update();

        }

        return $this->sendResponse( $anneeScolaire, 'Une Nouvelle Rentrée Scoalire a été mise en cours.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anneeScolaire = AnneeScolaire::findOrFail($id);
        $anneeScolaire->delete();
        return $this->sendResponse($anneeScolaire, 'La Rentrée scolaire  a été supprimée avec succès.');
    }
}

