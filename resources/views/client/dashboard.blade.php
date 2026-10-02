<h1>Dashboard Pelanggan - {{ auth()->user()->name }}</h1>
<form method="POST" action="{{ route('logout') }}">@csrf <button>Logout</button></form>