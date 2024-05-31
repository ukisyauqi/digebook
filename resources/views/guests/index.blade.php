<x-app-layout>
  <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
    <form method="POST" action="{{ route('guests.store') }}">
      @csrf
      <input name="name" type="text" placeholder="Masukan Nama Tamu"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
      <input name="whatsapp" type="number" placeholder="Nomor Whatsapp: 08123456789"
        class="mt-2 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
      <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
      <x-primary-button class="mt-2">{{ __('Tambah Tamu') }}</x-primary-button>
    </form>

    <hr class="my-6 border-gray-400">


    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-lg shadow">
      <table class="w-full text-sm text-left bg-white border border-gray-200">
        <thead class="text-xs text-white font-medium bg-indigo-800">
          <tr>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="text-center px-6 py-3">Whatsapp</th>
            <th scope="col" class="text-center px-6 py-3">Status</th>
            <th scope="col" class="text-center px-6 py-3">Checkin Time</th>
            <th scope="col" class="text-center px-6 py-3">Checkout Time</th>
            <th scope="col" class="text-center px-6 py-3">Action</th>
          </tr>
        </thead>
        <tbody>
          {{-- TABLE ITEMS --}}
          @foreach ($guests as $guest)
            <tr class="text-base text-gray-900 font-medium border-b">
              <td class="pl-4 pr-1 py-4">{{ $guest->name }}</td>
              <td class="text-center px-1 py-4">{{ $guest->whatsapp }}</td>
              <td class="text-center px-1 py-4 {{ $guest->status === 'absent' ? 'text-red-500' : 'text-green-500' }}">
                {{ $guest->status }}</td>
              <td class="text-center px-1 py-4">{{ $guest->checkin_time ?? '-' }}</td>
              <td class="text-center px-1 py-4">{{ $guest->checkout_time ?? '-' }}</td>
              <td class="text-center px-1 py-4">
                <div class="flex items-center">


                  <div class="border-r">
                    <x-dropdown-link :href="route('guests.edit', $guest)">
                      {{ __('Edit') }}
                    </x-dropdown-link>
                  </div>
                  <form method="POST" action="{{ route('guests.destroy', $guest) }}" class="border-r">
                    @csrf
                    @method('delete')
                    <x-dropdown-link :href="route('guests.destroy', $guest)" onclick="event.preventDefault(); this.closest('form').submit();">
                      Delete
                    </x-dropdown-link>
                  </form>
                  <div
                    class="text-nowrap rounded px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 group cursor-pointer">
                    Invite by Whatsapp
                    <div class="hidden group-hover:block absolute z-10">
                      <div class="bg-white flex flex-col p-2 gap-2 rounded-lg shadow-lg">
                        <a target="_blank"
                          href="https://wa.me/{{ $guest->whatsapp }}?text=Hai%20{{ explode(' ', $guest->name)[0] }},%20Kami%20mengundang%20Anda%20untuk%20menghadiri%20acara%20X.%20Untuk%20memudahkan%20proses%20masuk%20ruangan,%20silakan%20scan%20QRCode%20berikut%20ini:%20(Gambar%20pertama%20untuk%20Check-in)%20(Gambar%20kedua%20untuk%20Check-out%20QRCode%20ini%20dapat%20Anda%20scan%20ketika%20Anda%20sudah%20sampai%20di%20lokasi%20acara.%20Kami%20harap%20Anda%20dapat%20hadir%20dan%20memeriahkan%20acara%20ini."
                          class="block w-full px-2 py-1 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                          Chat Tamu</a>
                        <button onclick="copyQRCode({{ $guest->qrcode_checkin }})"
                          class="block w-full px-2 py-1 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">Copy
                          QR Code (Check-in)</button>
                        <button onclick="copyQRCode({{ $guest->qrcode_checkout }})"
                          class="block w-full px-2 py-1 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">Copy
                          QR Code (Check-out)</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>


    {{-- hidden qrcode --}}
    <div class="qrcode hidden">
    </div>
  </div>

</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  let qrcode = new QRCode(
    document.querySelector(".qrcode")
  );

  function setToClipboard(blob) {
    const data = [new ClipboardItem({
      [blob.type]: blob
    })]
    return navigator.clipboard.write(data, "asdasd")
  }

  async function copyQRCode(text) {
    qrcode.makeCode(text)
    await setTimeout(async () => {
      const img = await document.querySelector(".qrcode img")
      const response = await fetch(img.src)
      const blob = await response.blob()
      console.log(blob)
      await setToClipboard(blob)
    }, 100);
  }
</script>
