<!DOCTYPE html>
<html>
<head>
    <title>Convertisseur MAD ⇄ USD</title>
</head>
<body>
    <h1>Convertisseur MAD ⇄ USD</h1>

    <form method="POST" action="{{ route('convertir') }}">
        @csrf
        <label>Montant :</label>
        <input type="number" step="0.01" name="montant" required>

        <label>Conversion :</label>
        <select name="sens">
            <option value="MAD_TO_USD">MAD → USD</option>
            <option value="USD_TO_MAD">USD → MAD</option>
        </select>

        <button type="submit">Convertir</button>
    </form>

    @isset($resultat)
        <h2>Résultat : {{ $montant }} ({{ $sens == 'MAD_TO_USD' ? 'MAD' : 'USD' }}) = {{ $resultat }} {{ $sens == 'MAD_TO_USD' ? 'USD' : 'MAD' }}</h2>
    @endisset
</body>
</html>
