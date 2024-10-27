{{-- @if (Auth::guard('admin')->user()->hasPermissionTo('brand.update')) --}}
<a href="javascript:;" data-url="{{ route('admin.stock.show', $model->id) }}" class="btn btn-soft-success" data-bs-toggle="tooltip" data-bs-placement="Top" title="View" id="content_management">
    <i class="bi bi-eye"></i>
</a>
{{-- @endif --}}

<a href="javascript:;" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.stock.destroy',$model->id) }}" class="btn btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
    <i class="bi bi-trash"></i>
</a>