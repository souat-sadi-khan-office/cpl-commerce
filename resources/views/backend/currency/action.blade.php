{{-- @if (Auth::guard('admin')->user()->hasPermissionTo('zone.update')) --}}
    <a href="javascript:;" id="content_management" data-url="{{ route('admin.currency.edit', $model->id) }}" class="btn btn-soft-warning" data-bs-toggle="tooltip" data-bs-placement="Top" title="Edit">
        <i class="bi bi-pen"></i>
    </a>
{{-- @endif --}}

{{-- @if (Auth::guard('admin')->user()->hasPermissionTo('zone.delete')) --}}
    <a href="javascript:;" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.currency.destroy',$model->id) }}" class="btn btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
        <i class="bi bi-trash"></i>
    </a>
{{-- @endif --}}