  @extends('layouts.app')

  @section('content')
  <div class="container">
    <h4 class="mb-4">Tambah Jadwal Ruangan</h4>

    <form action="{{ route('jadwal.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="id_room" class="form-label">Ruang</label>
        <select name="id_room" id="id_room" class="form-select" required>
          <option value="">-- Pilih Ruang --</option>
          @foreach($rooms as $r)
            <option value="{{ $r->id_room }}">{{ $r->nama_room }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="hari" class="form-label">Hari</label>
        <select name="hari" class="form-select" required>
          <option value="">-- Pilih Hari --</option>
          @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
            <option value="{{ $h }}">{{ $h }}</option>
          @endforeach
        </select>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="jam_mulai" class="form-label">Jam Mulai</label>
          <input type="time" name="jam_mulai" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="jam_selesai" class="form-label">Jam Selesai</label>
          <input type="time" name="jam_selesai" class="form-control" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <input type="text" name="deskripsi" class="form-control" placeholder="Opsional">
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
  @endsection
