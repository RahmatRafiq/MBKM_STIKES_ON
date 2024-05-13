@include('includes.head')

<body>
    <div class="container">
        <aside>
            @include('includes.topbar')
            <!-- end top -->
            @include('includes.sidebar')
        </aside>
        <main>
            <div class="recent_order">
                <h1>Recent Permissions</h1>
                <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Nama Permission</th>
                                <th>ID Permission</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tanggal Diubah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->created_at }}</td>
                                <td>{{ $permission->updated_at }}</td>
                                <td>
                                    <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-primary">Ubah</a>
                                    <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="#" class="show-all-link">Show All</a>
            </div>
            
        </main>

        @include('includes.script')
    </div>
</body>

</html>