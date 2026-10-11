@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
    <p><a href="{{ route('loans.index') }}">&larr; Kembali ke daftar peminjaman</a></p>

    <h1>Edit Peminjaman</h1>

    <div class="form-container">
        <label>Anggota</label>
        <div class="readonly">{{ $loan['member']['nama'] }} ({{ $loan['member']['nim'] }})</div>

        <label style="margin-top: 12px;">Buku</label>
        <div class="readonly">
            @foreach ($loan['loanItems'] as $item)
                {{ $item['book']['judul'] }}@if (!$loop->last), @endif
            @endforeach
        </div>

        <form action="{{ route('loans.update', $loan['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="tanggal_pinjam" value="{{ $loan['tanggal_pinjam'] }}">

            <label for="tanggal_kembali">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', $loan['tanggal_kembali']) }}">
            @error('tanggal_kembali')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="dipinjam" @selected(old('status', $loan['status']) == 'dipinjam')>Dipinjam</option>
                <option value="dikembalikan" @selected(old('status', $loan['status']) == 'dikembalikan')>Dikembalikan</option>
                <option value="terlambat" @selected(old('status', $loan['status']) == 'terlambat')>Terlambat</option>
            </select>
            @error('status')
                <div class="error">{{ $message }}</div>
            @enderror

            <div style="margin-top: 20px;">
                <button type="submit" class="btn">Perbarui</button>
            </div>
        </form>
    </div>
@endsection
