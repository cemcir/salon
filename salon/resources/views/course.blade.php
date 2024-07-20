<h1>COURSE ANASAYFA</h1>
<h2>Kurs Ekle</h2>

<form action="{{route('courseInsert')}}" method="POST">
    @csrf
    <input type="text" name="course_title" placeholder="Title">
    <br/><br/>
    <input type="text" name="course_content" placeholder="Content">
    <br/><br/>
    <input type="number" name="course_must" placeholder="Must">
    <br/><br/>
    <input type="submit" value="Kurs Ekle">
</form>
