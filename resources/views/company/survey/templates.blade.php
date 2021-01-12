@extends('company.layouts.app')
@section('content')
    <style>
        #table_templates_filter label{
            float: right;
        }

        #table_templates_paginate ul{
            float: right;
        }
    </style>

    <div class="row">
        <div class="col-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <br>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">All Surveys</h4>
                    <table id="table_templates" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 153px;" >Title</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 235px;" >Description</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 47px;" >Status</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 99px;" >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($surveys as $survey)
                            <tr role="row" class="odd">
                                    <td tabindex="0" class="sorting_1">{{@$survey->template_name}}</td>
                                    <td>{{$survey->template_description}}</td>
                                <td>@if($survey->status == 1)<span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Ban</span> @endif</td>
                                    <td>
                                        <button class="btn btn-info" onclick="ViewSurveyQuestions({{$survey->question}});"><i class="ti-eye"></i></button>
                                        <a href="{{url('survey/templates/' . $survey->id)}}"<button class="btn btn-info"><i class="ti-pencil-alt"></i></button>
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('company.survey.deleteSurveyModal')
    @include('company.survey.viewSurveyQuestionsModal')
@endsection
