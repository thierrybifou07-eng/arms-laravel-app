@extends('layouts.app')
@section('content')
    <div class="card m-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($permissions->count() > 0)
            <div class="table-responsive text-nowrap table-hover">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Label</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($permissions as $permission)
                            <tr>
                                <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                    <span>{{ $permission->label }}</span>
                                </td>
                                <td> {{ $permission->created_at }}
                                </td>
                                <td>
                                    {{ $permission->updated_at }}
                                </td>
                                <td>
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-outline-dark">
                                            <a class="active" href="{{ route('permissions.show', $permission) }}">

                                            </a>View
                                        </button>
                                        <button type="button" class="btn btn-outline-warning">
                                            <a href="{{ route('permissions.edit', $permission) }}">

                                            </a>Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row mx-3 justify-content-between"><div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0"><div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status">Showing 1 to 10 of 100 entries</div></div><div class="d-md-flex align-items-center dt-layout-end col-md-auto ms-auto justify-content-md-between justify-content-center d-flex flex-wrap gap-2 mb-md-0 mb-4 mt-0"><div class="dt-paging"><nav aria-label="pagination"><ul class="pagination"><li class="dt-paging-button page-item disabled"><button class="page-link previous" role="link" type="button" aria-controls="DataTables_Table_0" aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1"><i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i></button></li><li class="dt-paging-button page-item active"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" aria-current="page" data-dt-idx="0">1</button></li><li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="1">2</button></li><li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="2">3</button></li><li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="3">4</button></li><li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="4">5</button></li><li class="dt-paging-button page-item disabled"><button class="page-link ellipsis" role="link" type="button" aria-controls="DataTables_Table_0" aria-disabled="true" data-dt-idx="ellipsis" tabindex="-1">…</button></li><li class="dt-paging-button page-item"><button class="page-link" role="link" type="button" aria-controls="DataTables_Table_0" data-dt-idx="9">10</button></li><li class="dt-paging-button page-item"><button class="page-link next" role="link" type="button" aria-controls="DataTables_Table_0" aria-label="Next" data-dt-idx="next"><i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i></button></li></ul></nav></div></div></div>
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>No permissions found</h5>
            </div>
        @endif
    </div>
@endsection
