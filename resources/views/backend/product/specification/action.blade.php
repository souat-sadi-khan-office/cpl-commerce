<div class="text-center">
    <a href="javascript:;" id="content_management"
        data-url="{{ route('admin.product.specification.edit.modal', $model['id']) }}" class="btn btn-info"
        data-bs-toggle="tooltip" data-bs-placement="top" title="Keys">
        <i class="bi bi-info-circle"></i>
    </a>
    <a href="{{ route('admin.product.specification.edit.page', $model['id']) }}" class="btn btn-primary"
        data-bs-toggle="tooltip" data-bs-placement="top" title="Update Specifications">
        <i class="bi bi-send"></i>
    </a>
</div>
