@props(['estoque'])

@php
    $config = match(true) {
        $estoque === 0  => ['fundo' => '#7f1d1d', 'texto' => '#fecaca', 'label' => 'ESGOTADO'],
        $estoque < 10   => ['fundo' => '#78350f', 'texto' => '#fef3c7', 'label' => 'CRÍTICO'],
        default         => ['fundo' => '#14532d', 'texto' => '#bbf7d0', 'label' => 'DISPONÍVEL'],
    };
@endphp

<span style="background: {{ $config['fundo'] }}; color: {{ $config['texto'] }}; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">
    {{ $config['label'] }} ({{ $estoque }} un)
</span>
