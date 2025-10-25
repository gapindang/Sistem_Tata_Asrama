@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-3">Kelola Denda</h3>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalDenda" onclick="openCreateModal()">+
            Tambah Denda</button>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggaran</th>
                    <th>Jumlah Denda</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableDenda">
                @foreach ($denda as $index => $item)
                    <tr id="row{{ $item->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_pelanggaran }}</td>
                        <td>Rp{{ number_format($item->jumlah_denda, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="openEditModal({{ $item }})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteDenda({{ $item->id }})">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDenda" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formDenda">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Tambah Denda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_denda">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggaran</label>
                            <input type="text" id="nama_pelanggaran" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Denda</label>
                            <input type="number" id="jumlah_denda" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea id="keterangan" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let isEdit = false;

        function openCreateModal() {
            isEdit = false;
            document.getElementById('modalTitle').innerText = 'Tambah Denda';
            document.getElementById('formDenda').reset();
            document.getElementById('id_denda').value = '';
        }

        function openEditModal(data) {
            isEdit = true;
            document.getElementById('modalTitle').innerText = 'Edit Denda';
            document.getElementById('id_denda').value = data.id;
            document.getElementById('nama_pelanggaran').value = data.nama_pelanggaran;
            document.getElementById('jumlah_denda').value = data.jumlah_denda;
            document.getElementById('keterangan').value = data.keterangan ?? '';
            new bootstrap.Modal(document.getElementById('modalDenda')).show();
        }

        document.getElementById('formDenda').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('id_denda').value;
            const payload = {
                nama_pelanggaran: document.getElementById('nama_pelanggaran').value,
                jumlah_denda: document.getElementById('jumlah_denda').value,
                keterangan: document.getElementById('keterangan').value,
                _token: '{{ csrf_token() }}'
            };
            const url = isEdit ? `/admin/denda/${id}` : `/admin/denda`;
            const method = isEdit ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            if (result.success) {
                location.reload();
            } else {
                alert('Gagal menyimpan data!');
            }
        });

        async function deleteDenda(id) {
            if (confirm('Yakin ingin menghapus denda ini?')) {
                const response = await fetch(`/admin/denda/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    document.getElementById(`row${id}`).remove();
                } else {
                    alert('Gagal menghapus data!');
                }
            }
        }
    </script>
@endsection
