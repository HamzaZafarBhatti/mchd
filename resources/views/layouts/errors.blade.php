@if ($errors->any())
    <div class="mb-1">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-border-left alert-dismissible fade show mb-xl-0" role="alert">
                <i class="ri-error-warning-line me-3 align-middle fs-16"></i><strong>Danger</strong>
                - {{$error}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    </div>
@endif
