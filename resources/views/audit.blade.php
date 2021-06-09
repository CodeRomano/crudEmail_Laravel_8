@extends('layouts.app')
@push('scripts')
    <script>
        $('#itemsPerPage').on('change', function() {
            window.location = "{!! url()->current() !!}?items="+$('#itemsPerPage').val()+"&filterValue="+$('#filterValue').val();
        });
        $('#btnFilter').on('click', function() {
            window.location = "{!! url()->current() !!}?items="+$('#itemsPerPage').val()+"&filterValue="+$('#filterValue').val();
        });
    </script>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-bolder">{{ __('labels.audits') }}</div>
        <div class="card-body">
            <form class="form-inline" method="GET" action="{{url()->current()}}">
            <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="perPage">{!! __('labels.items_per_page') !!}:  </label>&nbsp;
                            <select id="itemsPerPage" class="form-control">
                                <option value="5" @if($items == 5) selected @endif >5</option>
                                <option value="10" @if($items == 10) selected @endif >10</option>
                                <option value="25" @if($items == 25) selected @endif >25</option>
                            </select>&nbsp;&nbsp;
                            <label for="perPage">{!! __('labels.search') !!}:  </label>&nbsp;
                            <input id="filterValue" type="search" class="form-control form-control-sm" value="{{$filterValue}}">
                            &nbsp;
                            <button type="button" id="btnFilter" class="btn btn-primary float-right">Search</button>
                        </div>
                </div>
            </div>
            </form>
        
            <br/><br/>
            <table id="users-table" class="table table-striped table-advance table-hover table-responsive">
                <thead>
                <tr>
                    <th scope="col">{{ __('labels.#') }}</th>
                    <th scope="col">{{ __('labels.event') }}</th>
                    <th scope="col">{{ __('labels.old') }}</th>
                    <th scope="col">{{ __('labels.new') }}</th>
                    <th scope="col">{{ __('labels.type') }}</th>
                    <th scope="col">{{ __('labels.user') }}</th>
                    <th scope="col">{{ __('labels.ip') }}</th>
                    <th scope="col">{{ __('labels.createdAt') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($audits as $audit)
                <tr>
                            <td class="align-middle">{{ $audit->id }}</td>
                            <td class="align-middle"><span class="{{ $audit->getColorAction($audit->event) }}">{{ $audit->event }}</td>
                            <td class="align-middle">{{ $audit->getOldValuesFormat($audit->id) }}</td>
                            <td class="align-middle">{{ $audit->getNewValuesFormat($audit->id) }}</td>
                            <td class="align-middle">{{ $audit->auditable_type }}</td>
                            <td class="align-middle">{{ $audit->getUserName($audit->user_id) }}</td>
                            <td class="align-middle">{{ $audit->ip_address }}</td>
                            <td class="align-middle">{{ $audit->created_at->format('M d, Y h:i:s A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No records found</td>
                        </tr>
                    @endforelse
            </tbody>
            </table>
            {{ $audits->links() }}
        </div>
    </div>
</div>
@endsection