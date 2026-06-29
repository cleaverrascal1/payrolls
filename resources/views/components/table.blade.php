@props([
    'headers' => [],
    'data' => null
])

<table class="w-full text-sm text-left">
    @if(count($headers))
        <thead class="border-b border-neutral-200 text-neutral-700">
        <tr>
            @foreach ($headers as $header)
                <th class="px-4 py-2.5 font-medium">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
        </thead>
    @endif

    <tbody class="divide-y divide-neutral-200">
    {{ $slot }}
    </tbody>
</table>
