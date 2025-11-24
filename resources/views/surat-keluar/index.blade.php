<x-layouts.app :title="__('Dashboard')">

  @section('content')
    <div class="container mx-auto px-4 py-8">
      <!-- Header -->compo
      <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Surat Keluar</h1>
        <a href="{{ route('outgoing-mails.create') }}"
          class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          + Tambah Surat
        </a>
      </div>

      <!-- Alert Messages -->
      @if ($message = Session::get('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
          {{ $message }}
          <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <span>&times;</span>
          </button>
        </div>
      @endif

      @if ($message = Session::get('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
          {{ $message }}
          <button type="button" class="absolute top-0 right-0 px-4 py-3"
            onclick="this.parentElement.style.display='none';">
            <span>&times;</span>
          </button>
        </div>
      @endif

      <!-- Table -->
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        @if ($outgoingMails->count() > 0)
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($outgoingMails as $mail)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $mail->nomor_surat }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $mail->tanggal_surat->format('d/m/Y') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $mail->tujuan }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-700">
                    {{ Str::limit($mail->perihal, 50) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                    <a href="{{ route('outgoing-mails.show', $mail->id) }}"
                      class="text-blue-600 hover:text-blue-900 font-semibold">
                      Lihat
                    </a>
                    <a href="{{ route('outgoing-mails.edit', $mail->id) }}"
                      class="text-yellow-600 hover:text-yellow-900 font-semibold">
                      Edit
                    </a>
                    <form action="{{ route('outgoing-mails.destroy', $mail->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="px-6 py-4">
            {{ $outgoingMails->links() }}
          </div>
        @else
          <div class="px-6 py-8 text-center">
            <p class="text-gray-500">Tidak ada data surat keluar</p>
          </div>
        @endif
      </div>
    </div>
  </x-layouts.app>
