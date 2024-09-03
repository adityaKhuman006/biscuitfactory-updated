@include('dashboard')
<div class="d-flex flex-column w-100">
    <div style="height: 60vh" class="d-flex w-100 justify-content-center align-items-center flex-wrap">
        <a type="button" class="btn m-2 btn-lg btn-success custom-btn text-white" href="{{ route('production') }}"><img
                src="{{ asset('assets/images/icone/production.png') }}" alt="">Production</a>
        <a type="button" class="btn m-2 btn-lg btn-success custom-btn text-white" href="{{ route('rep') }}"><img
                src="{{ asset('assets/images/icone/report.png') }}" alt="">Report</a>
        <a type="button" class="btn m-2 btn-lg btn-success custom-btn text-white" href="{{ route('admin') }}"><img
                src="{{ asset('assets/images/icone/admin.png') }}" alt="">Admin</a>
    </div>
    <div class="d-flex justify-content-center align-items-top">
        <a class="text-center text-decoration-underline" href="{{ route('index') }}">Back To Home Screen</a>
    </div>
</div>
@include('footer')
