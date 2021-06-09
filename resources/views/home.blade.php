@extends('layouts.app')
@push('scripts')
    <script>
        $('#itemsPerPage').on('change', function() {
            window.location = "{!! url()->current() !!}?items="+$('#itemsPerPage').val()+"&filterValue="+$('#filterValue').val();
        });
        $('#btnFilter').on('click', function() {
            window.location = "{!! url()->current() !!}?items="+$('#itemsPerPage').val()+"&filterValue="+$('#filterValue').val();
        });
        $.ajaxSetup({
                headers:{
                    'X-CSRF-Token' : $("input[name=_token]").val()
                }
            });
        $('#users-table').Tabledit({
                url:'{{ route('users-data.action') }}',
                dataType:"json",
                columns:{
                    identifier:[0, 'id'],
                    editable:[
                        [1, '<?= __('labels.name') ?>'],
                        [4, '<?= __('labels.cellphone') ?>'],
                        [5, '<?= __('labels.date') ?>']
                    ]
                },
                onDraw: function() {
                    $('table tr td:nth-child(6) input').each(function() {
                        var $j = jQuery.noConflict();
                        $j(this).datepicker({
                            format: 'dd/mm/yyyy',
                            endDate: '+0d',
                            todayHighlight: true,
                            autoclose: true

                        });
                    });
                },
                buttons: {
                    edit: {
                        class: 'btn btn-primary',
                        html: 'Edit',
                        action: 'edit'
                    },
                    delete: {
                        class: 'btn btn-danger',
                        html: 'Delete',
                        action: 'delete'
                    },
                    save: {
                        class: 'btn btn-sm btn-success',
                        html: 'Save'
                    },
                    restore: {
                        class: 'btn btn-sm btn-warning',
                        html: 'Restore',
                        action: 'restore'
                    },
                    confirm: {
                        class: 'btn btn-sm btn-danger',
                        html: 'Confirm'
                    }
                },
                restoreButton:false,
                onFail: function(jqXHR, textStatus, errorThrown) {
                    if(data.message){
                        alert(data.message);
                        return;
                    }
                    alert(textStatus);
                },
                onSuccess:function(data, textStatus, jqXHR)
                {   
                    if(data.message){
                        alert(data.message);
                        return;
                    }

                    if(data.action === 'delete'){   
                        let $=jQuery.noConflict();
                        $('#'+data.id).remove();
                    }
                }
            });
    </script>
    

@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-bolder">{{ __('labels.users') }}</div>
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
                            <input id="filterValue" type="search" class="form-control form-control-sm" value="{{ $filterValue }}">
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
                    <th scope="col">@sortablelink('id', __('labels.id'))</th>
                    <th scope="col">@sortablelink('name', __('labels.name'))</th>
                    <th scope="col">@sortablelink('num_doc_identity', __('labels.id_card'))</th>
                    <th scope="col">@sortablelink('email', __('labels.email'))</th>
                    <th scope="col">@sortablelink('phone_number', __('labels.cellphone'))</th>
                    <th scope="col">@sortablelink('date_of_birth', __('labels.date_of_birth'))</th>
                    <th scope="col">@sortablelink('date_of_birth', __('labels.age'))</th>
                    <th scope="col">@sortablelink('flag_admin', __('labels.role'))</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $user)
                <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->num_doc_identity }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->date_of_birth->format('d/m/Y') }}</td>
                        <td>{{ $user->getAge() }}</td>
                        <td>{{ ($user->flag_admin =='1' ? 'Administrator':'Staff') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No records found</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
    
</div>
@endsection
