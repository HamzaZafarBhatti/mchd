@extends('layouts.master')
@section('title')
    @lang('translation.notifications')
@endsection
@section('content')
    @include('layouts.errors')
    @include('layouts.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-soft-primary">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="hstack text-nowrap gap-2">
                                @lang('translation.notifications') <span
                                    class="badge badge-danger badge-soft-secondary">{{ count($notifications) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-card table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Notification</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($my_notifications as $item)
                                    <tr>
                                        <th scope="row">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td>
                                            {{ $item->message }}
                                        </td>
                                        <td>
                                            @if ($item->pivot->is_read == 0)
                                                <a href="{{ route('notifications.mark_read', $item->id) }}"
                                                    class="btn btn-outline-success btn-sm" type="button"
                                                    data-bs-toggle="tooltip" data-bs-title="Mark as read">
                                                    <i class="ri-check-double-line"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $my_notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection


@section('script-bottom')
    <script>
        // $('.mark_read').click(function(e) {
        //     e.preventDefault();
        //     var _this = $(this);
        //     $.ajax({
        //         url: _this.attr('href'),
        //         success: function(response) {
        //             console.log(response);
        //         }
        //     })
        // })
    </script>
@endsection
