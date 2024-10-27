@if (Auth::guard('admin')->user()->hasPermissionTo('roles.update'))
    <a href="{{ route('admin.roles.edit', $model->id) }}" class="btn btn-soft-warning">
        <i class="bi bi-pen"></i>
    </a>
@endif

@if (Auth::guard('admin')->user()->hasPermissionTo('roles.delete'))
    @if ($model->id != 1)
        <a href="javascript:;" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.roles.destroy',$model->id) }}" class="btn btn-soft-danger">
            <i class="bi bi-trash"></i>
        </a>
    @endif
@endif