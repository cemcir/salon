<h1>NewPage Sayfası Route Oluşturma</h1>

<a href="{{route('homepage')}}">New Page Sayfasına Git</a>
<a href="{{route('welcome')}}">Welcome Sayfasına Git</a>

<br/>

<a href="{{route('newPageParam',['ad'=>'enes','soyad'=>'cemcir'])}}">NewPage Parametreli</a>

<p>Method : <?php echo $_SERVER['REQUEST_METHOD']; ?></p>

<form action="/post" method="post">
    @csrf
    <input type="submit">
</form>
