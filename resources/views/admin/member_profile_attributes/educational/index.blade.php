@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Education')}}</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="@if(auth()->user()->can('add_educational')) col-lg-7 @else col-lg-12 @endif">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Education') }}</h5>
                </div>
                <div class="col-md-4">
                    <form class="" id="sort_educationals" action="" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Name')}}</th>
                            <th>{{ translate('Status') }}</th>
                            <th class="text-right" width="20%">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($educationals as $key => $edu)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{$edu->name}}</td>
                                <td>
                                    @can('edit_professional')
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                          <input onchange="update_status(this)" value="{{ $edu->id }}" type="checkbox" <?php if($edu->present == 1) echo "checked";?> >
                                          <span class="slider round"></span>
                                        </label>
                                    @endcan
                                </td>
                                <td class="text-right">
                                    @can('edit_educational')
                                        <a href="{{ route('educational.edit', encrypt($edu->id)) }}" class="btn btn-soft-info btn-icon btn-circle btn-sm" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete_educational')
                                        <a href="javascript:void(0);" data-href="{{route('educational.destroy', $edu->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $educationals->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
    @can('add_educational')
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-md-0 h6">{{ translate('Add New Education') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('educational.store') }}" method="POST" >
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" placeholder="{{ translate('Education Name') }}"
                                   class="form-control" required>
                            @error('name')
                               <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save New Education')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>
@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script>
      function sort_educationals(el){
          $('#sort_educationals').submit();
      }

      function update_status(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('educational.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data) {
            if(data == 1){
                AIZ.plugins.notify('success', '{{ translate('Professional status updated successfully') }}');
            }
            else{
                AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
            }
        });
    }
    </script>
@endsection
