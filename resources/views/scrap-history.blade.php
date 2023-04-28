<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scrap History') }}
        </h2>
    </x-slot>
    @foreach ($instances as $instance)
        <div class="py-1 mt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <h3><a
                                href="{{ route('getScrapData', ['instance_id' => $instance->instance_id]) }}">{{ $instance->scrap_title }}</a>
                        </h3>
                        <p>Created: {{ $instance->created_at }} </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-app-layout>
