@extends('layouts.adminlte.master')

@section('title')
    @lang('customer.edit.title')
@endsection

@section('page_title')
    <span class="fa fa-smile-o fa-fw"></span>&nbsp;@lang('customer.edit.page_title')
@endsection
@section('page_title_desc')
    @lang('customer.edit.page_title_desc')
@endsection

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>@lang('labels.GENERAL_ERROR_TITLE')</strong> @lang('labels.GENERAL_ERROR_DESC')<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('customer.edit.header.title')</h3>
        </div>
        {!! Form::model($customer, ['method' => 'PATCH','route' => ['db.master.customer.edit', $customer->hId()], 'class' => 'form-horizontal', 'data-parsley-validate' => 'parsley']) !!}
            {{ csrf_field() }}
            <div ng-app="customerModule" ng-controller="customerController">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li><a href="#tab_customer" data-toggle="tab">@lang('customer.edit.tab.customer')</a></li>
                                    <li><a href="#tab_pic" data-toggle="tab">@lang('customer.edit.tab.pic')</a></li>
                                    <li><a href="#tab_bank_account" data-toggle="tab">@lang('customer.edit.tab.bank_account')</a></li>
                                    <li><a href="#tab_settings" data-toggle="tab">@lang('customer.edit.tab.settings')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_customer">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">@lang('customer.field.name')</label>
                                            <div class="col-sm-10">
                                                <input id="inputName" name="name" type="text" class="form-control" value="{{ $customer->name }}" placeholder="@lang('customer.field.name')" data-parsley-required="true">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress" class="col-sm-2 control-label">@lang('customer.field.address')</label>
                                            <div class="col-sm-10">
                                                <textarea name="address" id="inputAddress" class="form-control" rows="4">{{ $customer->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCity" class="col-sm-2 control-label">@lang('customer.field.city')</label>
                                            <div class="col-sm-10">
                                                <input id="inputCity" name="city" type="text" class="form-control" value="{{ $customer->city }}" placeholder="@lang('customer.field.city')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPhone" class="col-sm-2 control-label">@lang('customer.field.phone')</label>
                                            <div class="col-sm-10">
                                                <input id="inputPhone" name="phone" type="tel" class="form-control" value="{{ $customer->phone }}" placeholder="@lang('customer.field.phone')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTaxId" class="col-sm-2 control-label">@lang('customer.field.tax_id')</label>
                                            <div class="col-sm-10">
                                                <input id="inputTaxId" name="tax_id" type="text" class="form-control" value="{{ $customer->tax_id }}" placeholder="@lang('customer.field.tax_id')">
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                            <label for="inputStatus" class="col-sm-2 control-label">@lang('customer.field.status')</label>
                                            <div class="col-sm-10">
                                                {{ Form::select('status', $statusDDL, $customer->status, array('class' => 'form-control', 'placeholder' => 'Please Select', 'data-parsley-required' => 'true')) }}
                                                <span class="help-block">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputRemarks" class="col-sm-2 control-label">@lang('customer.field.remarks')</label>
                                            <div class="col-sm-10">
                                                <input id="inputRemarks" name="remarks" type="text" class="form-control" value="{{ $customer->remarks }}" placeholder="@lang('customer.field.remarks')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_pic">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <button class="btn btn-xs btn-default" type="button" ng-click="addNewProfile()">@lang('buttons.create_new_button')</button>
                                            </div>
                                            <div class="col-md-11">
                                                <div ng-repeat="profile in profiles">
                                                    <div class="box box-widget">
                                                        <div class="box-header with-border">
                                                            <div class="user-block">
                                                                <strong>Person In Charge @{{ $index + 1 }}</strong><br/>
                                                                &nbsp;&nbsp;&nbsp;@{{ profile.first_name }}&nbsp;@{{ profile.last_name }}
                                                            </div>
                                                            <div class="box-tools">
                                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <label for="inputFirstName" class="col-sm-2 control-label">@lang('customer.field.first_name')</label>
                                                                <div class="col-sm-10">
                                                                    <input id="inputFirstName" type="text" name="first_name[]" class="form-control" ng-model="profile.first_name" placeholder="@lang('customer.field.first_name')">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputLastName" class="col-sm-2 control-label">@lang('customer.field.last_name')</label>
                                                                <div class="col-sm-10">
                                                                    <input id="inputLastName" type="text" name="last_name[]" class="form-control" ng-model="profile.last_name" placeholder="@lang('customer.field.last_name')">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputAddress" class="col-sm-2 control-label">@lang('customer.field.address')</label>
                                                                <div class="col-sm-10">
                                                                    <input id="inputAddress" type="text" name="profile_address[]" class="form-control" ng-model="profile.address" placeholder="@lang('customer.field.address')">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputICNum" class="col-sm-2 control-label">@lang('customer.field.ic_num')</label>
                                                                <div class="col-sm-10">
                                                                    <input id="inputICNum" type="text" name="ic_num[]" class="form-control" ng-model="profile.ic_num" placeholder="@lang('customer.field.ic_num')">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputPhoneNumber" class="col-sm-2 control-label">@lang('customer.field.phone_number')</label>
                                                                <div class="col-sm-10">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>@lang('customer.edit.table_phone.header.provider')</th>
                                                                            <th>@lang('customer.edit.table_phone.header.number')</th>
                                                                            <th>@lang('customer.edit.table_phone.header.remarks')</th>
                                                                            <th class="text-center">@lang('labels.ACTION')</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr ng-repeat="ph in profile.phone_numbers">
                                                                            <td>
                                                                                <select name="profile_@{{ $parent.$index }}_phone_provider[]" class="form-control"
                                                                                        ng-init="phone_provider = { id: ph.phone_provider_id }"
                                                                                        ng-model="phone_provider"
                                                                                        ng-change="ph.phone_provider_id = phone_provider.id"
                                                                                        ng-options="p as p.name + ' (' + p.short_name + ')' for p in providerDDL track by p.id">
                                                                                    <option value="">@lang('labels.PLEASE_SELECT')</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="profile_@{{ $parent.$index }}_phone_number[]" class="form-control" ng-model="ph.number"></td>
                                                                            <td><input type="text" class="form-control" name="profile_@{{ $parent.$index }}_remarks[]" ng-model="ph.remarks"></td>
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-xs btn-danger" data="@{{ $index }}" ng-click="removeSelectedPhone($parent.$index, $index)">
                                                                                    <span class="fa fa-close fa-fw"></span>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <button type="button" class="btn btn-xs btn-default" ng-click="addNewPhone($index)">@lang('buttons.create_new_button')</button>
                                                                            </td>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_bank_account">
                                        <div class="box-group" id="accordion_bankaccount">
                                            <div class="panel box box-default">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                        <a class="collapsed" aria-expanded="false" href="#collapseBankAccountLists" data-toggle="collapse" data-parent="#accordion_bankaccount">
                                                            @lang('customer.edit.tab.header.bank_lists')
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div class="panel-collapse collapse" id="collapseBankAccountLists" aria-expanded="false">
                                                    <div class="box-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center">@lang('customer.edit.table_bank.header.bank')</th>
                                                                <th class="text-center">@lang('customer.edit.table_bank.header.account_number')</th>
                                                                <th class="text-center">@lang('customer.edit.table_bank.header.remarks')</th>
                                                                <th class="text-center">@lang('labels.ACTION')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat="bank in banks">
                                                                <td>
                                                                    <div ng-repeat="b in bankDDL | filter:{'id': bank.bank_id }:true">
                                                                        @{{ b.name }}&nbsp;(@{{ b.short_name }})
                                                                    </div>
                                                                    <input type="hidden" name="bank[]" value="@{{ bank.bank_id }}">
                                                                </td>
                                                                <td>
                                                                    @{{ bank.account_number }}
                                                                    <input type="hidden" name="account_number[]" value="@{{ bank.account_number }}">
                                                                </td>
                                                                <td>
                                                                    @{{ bank.remarks }}
                                                                    <input type="hidden" name="bank_remarks[]" value="@{{ bank.remarks }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-xs btn-danger" data="@{{ $index }}" ng-click="removeSelectedBank($index)"><span class="fa fa-close fa-fw"></span></button>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel box box-default">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                        <a class="collapsed" aria-expanded="false" href="#collapseBankAccountInputs" data-toggle="collapse" data-parent="#accordion_bankaccount">
                                                            @lang('customer.edit.tab.header.bank_inputs')
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div class="panel-collapse collapse" id="collapseBankAccountInputs" aria-expanded="false">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputBank" class="col-sm-2 control-label">@lang('customer.field.bank')</label>
                                                            <div class="col-sm-10">
                                                                <select id="inputBank" class="form-control"
                                                                        ng-model="inputBank.bank"
                                                                        ng-options="b.name + ' (' + b.short_name + ')' for b in bankDDL">
                                                                    <option value="">@lang('labels.PLEASE_SELECT')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputBankAccount" class="col-sm-2 control-label">@lang('customer.field.bank_account')</label>
                                                            <div class="col-sm-10">
                                                                <input id="inputBankAccount" type="text" class="form-control" ng-model="inputBank.bank_account" placeholder="@lang('customer.field.bank_account')">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputRemarks" class="col-sm-2 control-label">@lang('customer.field.remarks')</label>
                                                            <div class="col-sm-10">
                                                                <input id="inputRemarks" type="text" class="form-control" ng-model="inputBank.remarks" placeholder="@lang('customer.field.remarks')">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputBankButtons" class="col-sm-2 control-label">&nbsp;</label>
                                                            <div class="col-sm-10">
                                                                <button class="btn btn-xs btn-default" type="button" ng-click="resetInputBank()">@lang('buttons.reset_button')</button>
                                                                <button class="btn btn-xs btn-default" type="button" ng-click="addNewBank()">@lang('buttons.create_new_button')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_settings">
                                        <div class="form-group">
                                            <label for="inputPaymentDueDay" class="col-sm-2 control-label">@lang('customer.field.payment_due_day')</label>
                                            <div class="col-sm-10">
                                                <input id="inputPaymentDueDay" name="payment_due_day" type="text" value="{{ $customer->payment_due_day }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <a href="{{ route('db.master.customer') }}" class="btn btn-default">@lang('buttons.cancel_button')</a>
                            <button class="btn btn-default" type="submit">@lang('buttons.submit_button')</button>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('custom_js')
    <script type="application/javascript">
        var app = angular.module("customerModule", []);
        app.controller("customerController", ['$scope', function($scope) {
            $scope.banks = JSON.parse('{!! empty(htmlspecialchars_decode($customer->bankAccounts)) ? '[]':htmlspecialchars_decode($customer->bankAccounts) !!}');
            $scope.profiles = JSON.parse('{!! empty(htmlspecialchars_decode($customer->profiles)) ? '[]':htmlspecialchars_decode($customer->profiles) !!}');
            $scope.bankDDL = JSON.parse('{!! htmlspecialchars_decode($bankDDL) !!}');
            $scope.providerDDL = JSON.parse('{!! htmlspecialchars_decode($providerDDL) !!}');

            $scope.addNewBank = function() {
                $scope.banks.push({
                    'bank_id': $scope.inputBank.bank.id,
                    'bank_name': $scope.inputBank.bank.name + ' (' + $scope.inputBank.bank.short_name + ')',
                    'account_number': $scope.inputBank.bank_account,
                    'remarks': $scope.inputBank.remarks
                });
            };

            $scope.removeSelectedBank = function(idx) {
                $scope.banks.splice(idx, 1);
            };

            $scope.resetInputBank = function() {
                $scope.inputBank = {};
            };

            $scope.addNewProfile = function() {
                $scope.profiles.push({
                    'first_name': '',
                    'last_name': '',
                    'address': '',
                    'ic_num': '',
                    'image_filename': '',
                    'phone_numbers':[{
                        'phone_provider_id': '',
                        'number': '',
                        'remarks': ''
                    }]
                });
            };

            $scope.removeSelectedProfile = function(idx) {
                $scope.profiles.splice(idx, 1);
            };

            $scope.addNewPhone = function(parentIndex) {
                $scope.profiles[parentIndex].phone_numbers.push({
                    'phone_provider_id': '',
                    'number': '',
                    'remarks': ''
                });
            };

            $scope.removeSelectedPhone = function(parentIndex, idx) {
                $scope.profiles[parentIndex].phone_numbers.splice(idx, 1);
            };
        }]);
    </script>
@endsection