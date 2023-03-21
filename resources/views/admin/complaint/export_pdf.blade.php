<!DOCTYPE html>
<html>
<head>
  <title>Laporan-Pengaduan</title><style>
    table {
  border-collapse: collapse;
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial, sans-serif;
  font-size: 14px;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
  text-transform: uppercase;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f2f2f2;
}

thead>th {
  width: 60px;
}
table{
      max-width: 1050px;
}
</style>
</head>
<body>
    <h1>Laporan Pengaduan</h1>
    <h5>Periode : 
    @if(!$filter || !$from)
        Semua Data
    @else
        {{ $filter != 'date_range' ? ucFirst($filter) . ' | ' . $periode : $from . ' - ' . $to }}</h5>
    @endif
    <table>
    <thead>
        <tr>
        <th>#</th>
        <th>Nama Pengadu</th>
        <th>Judul</th>
        <th>Keterangan</th>
        <th>Link Video</th>
        <th>Gambar</th>
        <th>Status</th>
        <th>Tanggapan</th>
        <th>Gambar Tanggapan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($complaints as $key => $complaint)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $complaint->user->name }}</td>
                <td>{{ $complaint->title }}</td>
                <td>{!! $complaint->description !!}</td>
                <td>{{ $complaint->link_video }}</td>
                <td><img src="{{ storage_path('app/public/complaint-image/'. $complaint->complaintImages()->first()->image) }}" width="50" height="50"></td>
                <td>
                    @if($complaint->status == 'PENDING')
                    <span style="color:white;background:yellow;padding:5px;">PENDING</span>
                    @elseif($complaint->status == 'REJECTED')
                    <span style="color:white;background:red;padding:5px;">REJECTED</span>
                    @elseif($complaint->status == 'DONE')
                    <span style="color:white;background:green;padding:5px;">DONE</span>
                    @endif
                </td>
                <td>
                    
                    @if($complaint->responses()->count() > 0)
                    <ol>
                        @foreach($complaint->responses()->get() as $response)
                            <li>{!! $response->response !!}</li>
                        @endforeach
                    </ol>
                @else
                    Belum ada tanggapan
                @endif
                </td>
                <td>
                    
                @if($complaint->responses()->count() > 0)
                
                @foreach($complaint->responses()->get() as $response)
                  @if($response->file)
                  <img src="{{ storage_path('app/public/response-file/'. $response->file) }}" width="50" height="50">
                  @endif
                @endforeach
                @else
                    Tidak ada gambar
                @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
</body>
</html>