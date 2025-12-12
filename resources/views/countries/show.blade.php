<h1>{{ $country['name']['common'] }}</h1>

<p><strong>Capital:</strong> {{ $country['capital'][0] ?? 'N/A' }}</p>
<p><strong>Región:</strong> {{ $country['region'] }}</p>
<p><strong>Población:</strong> {{ number_format($country['population']) }}</p>

<img src="{{ $country['flags']['png'] }}" width="200">
