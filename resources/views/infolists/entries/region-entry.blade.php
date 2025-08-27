<div class="fi-in-entry">
    @if ($getLabel())
        <dt class="fi-in-entry-label">
            {{ $getLabel() }}
        </dt>
    @endif

    <dd class="fi-in-entry-content">
        {{ $getState() ?? '-' }}
    </dd>
</div>
