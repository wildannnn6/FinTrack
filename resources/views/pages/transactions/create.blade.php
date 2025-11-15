@extends('layouts.app')

@section('title', 'Tambah Transaksi - Fintrack')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Transaksi Baru</h1>
            <p class="text-gray-600">Isi form berikut untuk mencatat transaksi baru</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                
                <div class="grid gap-6">
                    <!-- Judul Transaksi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Transaksi *</label>
                        <input type="text" name="title" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                               placeholder="Contoh: Belanja Bulanan">
                    </div>

                    <!-- Jumlah dan Tipe -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp) *</label>
                            <input type="number" name="amount" required min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                   placeholder="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe *</label>
                            <select name="type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                                <option value="">Pilih Tipe</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kategori dan Eisenhower -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select name="category" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas Eisenhower *</label>
                            <select name="eisenhower_category" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                                <option value="">Pilih Prioritas</option>
                                @foreach($eisenhower_categories as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal dan Deskripsi -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                            <input type="date" name="date" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent transition"
                                      placeholder="Deskripsi transaksi (opsional)"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('transactions.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>

        <!-- Eisenhower Matrix Guide -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-800 mb-2">Panduan Prioritas Eisenhower:</h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-start">
                    <span class="w-3 h-3 bg-red-500 rounded-full mt-1 mr-2"></span>
                    <div>
                        <strong class="text-red-700">Penting & Mendesak:</strong>
                        <p class="text-blue-600">Bayar tagihan, kebutuhan darurat</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-3 h-3 bg-blue-500 rounded-full mt-1 mr-2"></span>
                    <div>
                        <strong class="text-blue-700">Penting & Tidak Mendesak:</strong>
                        <p class="text-blue-600">Tabungan, investasi, pendidikan</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full mt-1 mr-2"></span>
                    <div>
                        <strong class="text-yellow-700">Mendesak & Tidak Penting:</strong>
                        <p class="text-blue-600">Hiburan mendadak, makan di luar</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-3 h-3 bg-green-500 rounded-full mt-1 mr-2"></span>
                    <div>
                        <strong class="text-green-700">Tidak Mendesak & Tidak Penting:</strong>
                        <p class="text-blue-600">Belanja impulsif, subscription</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection