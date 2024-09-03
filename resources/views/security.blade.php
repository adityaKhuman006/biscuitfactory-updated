@include('dashboard')

<div class="d-flex flex-column w-100 align-items-center justify-content-center flex-wrap">
        <a type="button" class="btn btn-lg btn-success fw-bolder text-white" style="width: 200px;"
                href="{{ route('getin') }}"><img class="mr-3" style="width:20px;"
                        src="{{ asset('assets/images/icone/secure.png') }}" alt="">Get In</a>
        <a type="button" class="btn btn-lg btn-success fw-bolder mt-3 text-white" style="width: 200px;"
                href="{{ route('getout') }}"><img class="mr-2" style="width: 20px;"
                        src="{{ asset('assets/images/icone/door.png') }}" alt="">Get Out</a>
        <a type="button" class="btn btn-lg btn-success fw-bolder mt-3 text-white" style="width: 200px;"
                href="{{ route('transfer.material') }}"><img class="mr-2" style="width: 20px;"
                        src="{{ asset('assets/images/icone/transfer.png') }}" alt="">Transfer</a>
</div>
@include('footer')
</body>

</html>