<x-app-layout>
  <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
    <form method="POST" action="{{ route('guests.update', $guest) }}">
      @csrf
      @method('patch')
      <input name="name" type="text" placeholder="Masukan Nama Tamu"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
      <input name="whatsapp" type="number" placeholder="Nomor Whatsapp: 08123456789"
        class="mt-2 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
      <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
      <div class="mt-4 space-x-2">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
        <a href="{{ route('guests.index') }}">{{ __('Cancel') }}</a>
      </div>
    </form>
  </div>
</x-app-layout>

