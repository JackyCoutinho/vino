@extends('layouts.app')
@section('title', 'Recherche')
@section('content')

<div class="body__container">
    <div class="auth__header recherche">
        <h1>Recherche</h1>
        <form class="recherche__barre" action="{{ route('bouteille.recherche') }}" method="GET">
            <input class="recherche__input" type="tel" name="recherche" id="recherche" placeholder="RECHERCHE PAR NOM">
            <button  class="recherche__btn"><img src="/icons/rechercher.png" class="footer-icon" alt="recherche"/></button>
        </form>
    </div>
    <div>
        <div class="auth__col">
            @foreach($bouteilles as $bouteille)
                <div class="recherche__container">
                    <div class="recherche__img">
                        <img src="{{$bouteille->url_img}}" class="recherche__img">
                    </div>
                    <div class="bouteille__info">
                        <p class="bouteille__nom">{{$bouteille->nom}}</p>
                        <p class="bouteille__color">{{$bouteille->pays}} | {{$bouteille->type_id}} | {{$bouteille->format}}</p>
                        <p class="bouteille__prix">{{$bouteille->prix_saq}} $</p>
                        <p class="bouteille__voir__plus"><a class="bouteille__lien" href="{{$bouteille->url_saq}}">voir plus</a></p>
                        <form action="{{ route('affichier.bouteille.cellier') }}" method ="POST">
                            @csrf
                            <input type="hidden" name="bouteille_id" value="{{$bouteille->id}}">
                            <input type="submit" class="bouteille__lien" value="Ajouter au cellier">
                        </form>
                    </div>
                </div>
            @endforeach
            {{ $bouteilles->links() }}
        </div>
    </div>
</div>

@endsection
@include('layouts.footer')
