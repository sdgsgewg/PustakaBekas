<div class="title mb-2">
    <h1>{{ $title }}</h1>
</div>
<div class="position-relative">
    <ul class="nav nav-underline nav-fill d-flex justify-content-between" data-selected-status="{{ $selectedStatus }}">
        @foreach ($allStatus as $s)
            <li class="nav-item position-relative">
                <a class="nav-link me-2" href="#" data-status="{{ $s }}">{{ $s }}</a>
                <span class="badge bg-primary text-white rounded-circle">{{ $numTransactionByStatus[$s] ?? 0 }}</span>
            </li>
        @endforeach
    </ul>
</div>

<hr class="mt-0 mb-3">

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
    document.querySelectorAll('.nav-item').forEach(item => {
        const badge = item.querySelector('.badge');
        if (badge && parseInt(badge.textContent) === 0) {
            // Ensure badges with zero transactions remain hidden
            badge.style.visibility = 'hidden';
            badge.style.opacity = '0';
        }
    });
</script>
