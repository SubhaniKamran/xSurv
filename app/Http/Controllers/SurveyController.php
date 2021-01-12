<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use voku\helper\ASCII;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $surveys = DB::table('surveys')
            ->where([
                ['user_id', '=', 1],
                ['deleted_at', '=', null]
            ])
        ->get();
        return view('admin.survey.index',compact('surveys'));
    }

    public function create()
    {
        return view('admin.survey.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name'=>'required|min:4',
            'template_description'=>'required',
            'question'=>'required',
        ]);
        $user_id = Auth::id();
        $Questions = array();
        foreach ($request->question as $index => $item){
            $_question = str_replace(",", "~", $item['question']);
            $Questions[] = $_question;
        }
        if($Questions[0] != "")
        {
          Survey::create([
              'user_id' => $user_id,
              'template_name' => $request['template_name'],
              'template_description' => $request['template_description'],
              'question' => isset($request->question) ? json_encode($Questions) : null,
          ]);
          return redirect(route('admin.survey.index'))->with('message','Survey Added Successfully');
        }
        else
        {
          return redirect(route('admin.survey.index'))->with('error','Atleast one question is required to create survey');
        }
    }

    public function destroy(Survey $survey)
    {
        if($survey->forceDelete())
        {
            return back()->with('message','Survey Deleted successfully');
        }
        else
        {
            return back()->with('message','Error Deleting Survey');
        }
    }

    public function ban(Request $request , Survey $survey)
    {
        $survey->status=0;
        $survey->save();
        return redirect(route('admin.survey.index'))->with('message', 'Survey Successfully Banned');
    }
    public function active(Request $request , Survey $survey)
    {
        $survey->status=1;
        $survey->save();
        return redirect(route('admin.survey.index'))->with('message', 'Survey Successfully Activated');
    }

    public function edit($SurveyId){
        $survey = DB::table('surveys')
            ->where([
                ['id', '=', $SurveyId]
            ])
            ->get();
        return view('admin/survey/edit', compact('survey'));
    }

    public function AdminUpdateSurvey(Request $request){
        $request->validate([
            'template_name'=>'required|min:4',
            'template_description'=>'required',
            'question'=>'required',
        ]);
        $Questions = array();
        foreach ($request->question as $index => $item){
            $Questions[] = $item['question'];
        }
        $SurveyId = $request->surveyId;
        DB::table('surveys')
            ->where('id', $SurveyId)
            ->update([
                'template_name' => $request['template_name'],
                'template_description' => $request['template_description'],
                'question' => isset($request->question) ? json_encode($Questions) : null,
                'updated_at' => Carbon::now()
            ]);
        return redirect(url('admin/survey'))->with('message','Survey Updated Successfully');
    }

    //Company Side
    public function CompanyNewSurvey(){
        // check company google place id
        $user_id = Auth::id();
        $company_google_id = DB::table('google_reviews')
            ->where('user_id', $user_id)
            ->count();

        return view('company/survey/create', compact('company_google_id'));
    }

    public function CompanyAllSurveys(){
        $surveys = DB::table('surveys')
            ->where([
                ['user_id', '=', Auth::id()],
                ['deleted_at', '=', null]
            ])
        ->get();
        return view('company/survey/index', compact('surveys'));
    }

    public function CompanyStoreSurvey(Request $request){
        $request->validate([
            'template_name'=>'required|min:4',
            'template_description'=>'required',
            'question'=>'required',
        ]);
        $user_id = Auth::id();
        $Questions = array();
        foreach ($request->question as $index => $item){
            $_question = str_replace(",", "~", $item['question']);
            $Questions[] = $_question;
        }
        if ($Questions[0] != "") {
          Survey::create([
              'user_id' => $user_id,
              'template_name' => $request['template_name'],
              'template_description' => $request['template_description'],
              'question' => isset($request->question) ? json_encode($Questions) : null,
          ]);
          return redirect(url('/survey/all'))->with('message','Survey Added Successfully');
        }
        else{
          return redirect(url('/survey/add'))->with('error','Atleast one question is required to create survey');
        }
    }

    public function CompanyEditSurvey($SurveyId){
        $survey = DB::table('surveys')
            ->where([
                ['id', '=', $SurveyId]
            ])
            ->get();

        return view('company/survey/edit', compact('survey'));
    }

    public function CompanyUpdateSurvey(Request $request){
        $request->validate([
            'template_name'=>'required|min:4',
            'template_description'=>'required',
            'question'=>'required',
        ]);
        $Questions = array();
        foreach ($request->question as $index => $item){
            $Questions[] = $item['question'];
        }
        $SurveyId = $request->surveyId;
        DB::table('surveys')
            ->where('id', $SurveyId)
            ->update([
                'template_name' => $request['template_name'],
                'template_description' => $request['template_description'],
                'question' => isset($request->question) ? json_encode($Questions) : null,
                'updated_at' => Carbon::now()
            ]);
        return redirect(url('/survey/all'))->with('message','Survey Updated Successfully');
    }

    public function CompanyBanSurvey($SurveyId){
        DB::table('surveys')
            ->where('id', $SurveyId)
            ->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
        return redirect(url('/survey/all'))->with('message','Survey Updated Successfully');
    }

    public function CompanyActiveSurvey($SurveyId){
        DB::table('surveys')
            ->where('id', $SurveyId)
            ->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        return redirect(url('/survey/all'))->with('message','Survey Updated Successfully');
    }

    public function CompanyDeleteSurvey($SurveyId){
        DB::table('surveys')
            ->where('id', $SurveyId)
            ->update([
                'deleted_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect(url('/survey/all'))->with('message','Survey Deleted Successfully');
    }

    public function CompanyTemplatesSurveys(){
        $surveys = DB::table('surveys')
            ->where([
                ['user_id', '=', 1],
                ['status', 1],
                ['deleted_at', '=', null]
            ])
            ->get();
        return view('company/survey/templates', compact('surveys'));
    }

    public function CompaniesAllSurveys()
    {
      $surveys = DB::table('surveys')
          ->where([
              ['user_id', '!=', 1],
              ['deleted_at', '=', null]
          ])
          ->get();
      return view('admin/survey/companies_surveys', compact('surveys'));
    }

    /* Company Admin Templates - Start */
    public function CompanyEditTemplate($templateId)
    {
      $survey = DB::table('surveys')
          ->where([
              ['id', '=', $templateId]
          ])
          ->get();

      // check company google place id
      $user_id = Auth::id();
      $company_google_id = DB::table('google_reviews')
          ->where('user_id', $user_id)
          ->count();

      return view('company/survey/editTemplate', compact('survey', 'company_google_id'));
    }

    public function CompanyStoreTemplate(Request $request)
    {
        $request->validate([
            'template_name'=>'required|min:4',
            'template_description'=>'required',
            'question'=>'required',
        ]);
        $user_id = Auth::id();
        $Questions = array();
        foreach ($request->question as $index => $item){
            $_question = str_replace(",", "~", $item['question']);
            $Questions[] = $_question;
        }
        if ($Questions[0] != "") {
          $affected = Survey::create([
              'user_id' => $user_id,
              'template_name' => $request['template_name'],
              'template_description' => $request['template_description'],
              'question' => isset($request->question) ? json_encode($Questions) : null,
          ]);
          if($affected)
          {
            return redirect(url('/survey/all'))->with('message','Survey Added Successfully');
          }
          else
          {
            return redirect(url('/survey/all'))->with('error','Error! An unhandled error exception');
          }
        }
        else {
          return redirect(url('/survey/all'))->with('error','Atleast one question is required to create survey');
        }
    }
    /* Company Admin Templates - End */
}
