<h1>Manajemen Mata Kuliah</h1>
<form method="POST" action="{{route('admin.courses.store')}}">@csrf
<input name="code" placeholder="Kode"><input name="name" placeholder="Nama Mata Kuliah"><input name="credits" placeholder="SKS"><button>Simpan</button>
</form>
@foreach($courses as $c)
<div>{{$c->code}} - {{$c->name}} <form method="POST" action="{{route('admin.courses.destroy',$c)}}">@csrf @method('DELETE')<button>Hapus</button></form></div>
@endforeach
