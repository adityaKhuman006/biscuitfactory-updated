@include('dashboard')
<div class="d-flex w-100 flex-column justify-content-center align-items-center flex-wrap">
        <div>
                <a type="button" class="btn btn-lg btn-success fw-bolder text-white" style="width: 200px;"
                        href="{{ route('select.category') }}"><img class="mr-4" style="width:30px;"
                                src="{{ asset('assets/images/icone/mixing.png') }}" alt="">Mixing</a>
        </div>
        <div class="mt-3">
                <a type="button" class="btn btn-lg btn-success fw-bolder text-white" style="width: 200px;"
                        href="{{ route('security') }}"><img class="mr-4" style="width:30px;"
                                src="{{ asset('assets/images/icone/globe.png') }}" alt="">Security</a>
        </div>
</div>
@include('footer')
