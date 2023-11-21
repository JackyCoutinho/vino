<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Bouteille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CellierController extends Controller
{
    public static function randomIcon()
    {
        $list = [
            'cellierbrun.png',
            'cellierjaune.png',
            'cellierjaunefonce.png',
            'cellierrose.png',
            'cellierrouge.png',
        ];

        return $list[rand(0, count($list) - 1)];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listBouteilles($cellierId)
    {
        $cellier = Cellier::find($cellierId);

        if (!$cellier) {
            // Se o Cellier não for encontrado, redirecionar com uma mensagem de erro
            return back()->with('error', 'Cellier non trouvé');
        }

        // Carregue as bouteilles relacionadas ao cellier usando o relacionamento 'bouteilles'
        $bouteilles = $cellier->bouteilles;

        return view('cellier.select', ['cellier' => $cellier, 'bouteilles' => $bouteilles]);
    }

    
    public function ajouterBouteilles($cellierId){
        $bouteilles = Bouteille::orderBy('id','desc')->paginate(24);
        return view('bouteille.index',[
            'bouteilles' => $bouteilles,
            'cellierId' => $cellierId 
        ]);
    }


    public function index()
    {
        $items = Cellier::where('user_id', Auth::user()->id)->get();
        $random_icon = self::randomIcon();

        return view('cellier.index', compact('items', 'random_icon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cellier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['icon'] = self::randomIcon();
        //print_r($validatedData);die();
        Cellier::create($validatedData);
        return redirect()->route('cellier.index')->with('success', 'Cellier créé avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cellier $cellier
     * @return \Illuminate\Http\Response
     */
    public function show(Cellier $cellier)
    {
        return view('cellier.show', compact('cellier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Cellier $cellier
     * @return \Illuminate\Http\Response
     */
    public function edit(Cellier $cellier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cellier $cellier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cellier $cellier)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        $cellier->update($validatedData);
        return redirect()->route('cellier.index')->with('success', 'Cellier modifié avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cellier $cellier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cellier $cellier)
    {
        $cellier->delete();
        return redirect()->route('cellier.index')->with('success', 'Cellier supprimé avec succès!');
    }
}
