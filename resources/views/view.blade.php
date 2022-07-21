

@include('layouts.css')
<div class="container">
    <div class="row-fluid">
        <div class="text-center">
            <br>
            <br>
            <br>
            {!! QrCode::size(250)->generate($qr['data']); !!}
        </div>
    </div>
</div>

