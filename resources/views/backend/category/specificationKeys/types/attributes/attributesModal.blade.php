<h3 class="m-4">Specification Key Type Attributes</h3>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered table-striped table-hover" id="data-table">
                    <thead>
                        <tr>
                            <th style="width: 13%;">Created By</th>
                            <th style="width: 5%;">Status</th>
                            <th style="width: 77%; text-align:center">Name &nbsp;&nbsp; & &nbsp;&nbsp;
                                Extra <span class="text-danger">*</span></th>
                            <th style="width: 5%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $data)
                            <tr>
                                <td>{{ $data->admin ? $data->admin->name : '-' }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input
                                            data-url="{{ route('admin.category.specification.type.attribute.status', $data->id) }}"
                                            class="form-check-input" type="checkbox" role="switch" name="status"
                                            id="status{{ $data->id }}" {{ $data->status == 1 ? 'checked' : '' }}
                                            data-id="{{ $data->id }}">
                                    </div>
                                </td>


                                <td>
                                    <form
                                        action="{{ route('admin.category.specification.type.attribute.update', $data->id) }}"
                                        method="POST" class="nested-form" data-id="{{ $data->id }}">
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                <input type="text" name="name" id="name{{ $data->id }}"
                                                    class="form-control name-input" value="{{ $data->name }}">
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" name="extra" id="extra{{ $data->id }}"
                                                    class="form-control extra-input" value="{{ $data->extra }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-soft-success submit-btn" type="submit">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>

                                <td>
                                    <a href="javascript:;" id="delete_item" data-id="{{ $data->id }}"
                                        data-url="{{ route('admin.category.specification.type.attribute.delete', $data->id) }}"
                                        class="btn btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        _initializeMultipleFormsValidation();

        $('.form-check-input[name="is_featured"]').change(function() {
            const checkbox = $(this);
            const id = checkbox.data('id');
            const filterInput = $('#filter_name' + id);

            filterInput.prop('disabled', !checkbox.is(':checked'));
        });
    });
</script>
