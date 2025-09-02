<form method="POST" action="{{ route('signup') }}">
    @csrf
    <input type="text" name="name" placeholder="Nom">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mot de passe">
    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe">
    <button type="submit">S'inscrire</button>
</form>
