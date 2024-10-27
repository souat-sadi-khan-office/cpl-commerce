<div class="dropdown">
    <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="javascript:;" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Action
    </a>
  
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li>
            <a class="dropdown-item" href="{{ URL::to($model->slug) }}" target="_blank">
                <i class="bi bi-eye"></i>
                View
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin.product.edit', $model->id) }}">
                <i class="bi bi-pen"></i>
                Edit
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin.stock.create', ['product_id' => $model->id]) }}">
                <i class="bi bi-archive"></i>
                Add Stock
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin.product.stock', $model->id) }}">
                <i class="bi bi-archive"></i>
                Stock Report
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="javascript:;" id="duplicate_item" data-id="{{ $model->id }}" data-url="{{ route('admin.product.duplicate', $model->id) }}">
                <i class="bi bi-copy"></i>
                Duplicate
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="javascript:;" id="delete_item" data-id="{{ $model->id }}" data-url="{{ route('admin.product.destroy',$model->id) }}">
                <i class="bi bi-trash"></i>
                Remove
            </a>
        </li>
        {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
    </ul>
</div>