<h1>Lista de Países</h1>

<ul>
@foreach($countries as $country)
    <li>
        {{ $country['name']['common'] ?? 'Sin nombre' }}
        – <a href="/countries/{{ $country['name']['common'] }}">Ver más</a>
    </li>
@endforeach
</ul>
