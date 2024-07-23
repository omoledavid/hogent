@extends('admin.layouts.app')
<style>
.active-status{
    
    background-color: rgba(40, 199, 111, 0.1);
    color: #28c76f;
    padding: 1px 15px;
    border: 1px solid #28c76f;
    border-radius: 10px;

}
.inactive-status{
    
    background-color: rgba(255, 159, 67, 0.1);
    color: #ff9f43;
    padding: 1px 15px;
    border: 1px solid #ff9f43;
    border-radius: 10px;

}
</style>

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper bg-white p-30 radius-20">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive--sm table-responsive">
                                        <table class="table table--light style--two custom-data-table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Name')</th>
                                                    <th>@lang('Subject')</th>
                                                    <th>@lang('Status')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($email_templates as $template)
                                                    <tr>
                                                        <td data-label="@lang('Name')">{{ __($template->name) }}</td>
                                                        <td data-label="@lang('Subject')">{{ __($template->subj) }}</td>
                                                        <td data-label="@lang('Status')">
                                                            @if ($template->email_status == 1)
                                                                <span
                                                                    class="active-status">@lang('Active')</span>
                                                            @else
                                                                <span
                                                                    class="inactive-status">@lang('Disabled')</span>
                                                            @endif
                                                        </td>
                                                        <td data-label="@lang('Action')">
                                                            <a href="{{ route('sms-mail.template.edit', $template->id) }}" class="icon-btn  ml-1 editGatewayBtn"
                                                                data-toggle="tooltip" title=""
                                                                data-original-title="@lang('Edit')">
                                                                edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-muted text-center" colspan="100%">
                                                            {{ __($emptyMessage) }}</td>
                                                    </tr>
                                                @endforelse

                                            </tbody>
                                        </table><!-- table end -->
                                    </div>
                                </div>
                            </div><!-- card end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
