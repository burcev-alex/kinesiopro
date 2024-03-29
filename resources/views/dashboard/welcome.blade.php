<div class="row mb-2 g-3 g-mb-4">
    @foreach($metrics as $key => $metric)
        <div class="col">
            <div class="p-4 bg-white rounded shadow-sm h-100">
                <small class="text-muted d-block mb-1">{{ __($key) }}</small>
                <p class="h3 text-black fw-light">
                    {{ is_array($metric) ? $metric['value'] : $metric }}

                    @if(isset($metric['diff']) && (float)$metric['diff'] !== 0.0)
                        <small class="small {{ (float)$metric['diff'] < 0 ? 'text-danger': 'text-success' }}">
                            {{ round($metric['diff'], 2) }} %
                        </small>
                    @endif
                </p>
            </div>
        </div>
    @endforeach
</div>