@php
    $badgeClasses = [
        'pending' => 'bg-warning',
        'confirmed' => 'bg-success',
        'cancelled' => 'bg-danger'
    ];
@endphp

<span class="badge {{ $badgeClasses[$status] ?? 'bg-secondary' }}">
    {{ ucfirst($status) }}
</span>