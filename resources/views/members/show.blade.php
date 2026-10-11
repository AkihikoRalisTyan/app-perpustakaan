@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>

    <h1>Detail Anggota</h1>

    <div class="form-container">
        <table>
            <tr>
                <th style="width: 160px; background: #f3f4f6;">Nama</th>
                <td>{{ $member['nama'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">NIM</th>
                <td>{{ $member['nim'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Email</th>
                <td>{{ $member['email'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">No. Telepon</th>
                <td>{{ $member['nomor_telepon'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Alamat</th>
                <td>{{ $member['alamat'] }}</td>
            </tr>
            <tr>
                <th style="background: #f3f4f6;">Status</th>
                <td>{{ ucfirst($member['status']) }}</td>
            </tr>
        </table>

        <div style="margin-top: 1rem;">
            <a href="{{ route('members.edit', $member['id']) }}" class="btn">Edit</a>
        </div>
    </div>

    <h2 style="margin-top: 32px;">Riwayat Peminjaman</h2>
    <p><em>Diambil lewat relasi <code>$member->loans</code> - satu anggota bisa punya banyak transaksi peminjaman.</em></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Petugas</th>
                <th>Buku</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($member['loans'] as $loan)
                <tr>
                    <td>{{ $loan['tanggal_pinjam'] }}</td>
                    <td>{{ $loan['tanggal_kembali'] }}</td>
                    <td>{{ $loan['user']['name'] }}</td>
                    <td>
                        @foreach ($loan['loanItems'] as $item)
                            {{ $item['book']['judul'] }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        <span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Anggota ini belum pernah meminjam buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection