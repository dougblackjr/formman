<?php

namespace App\Http\Controllers;

use App\EmailResponse;
use App\Form;
use App\Response;
use App\Key;
use App\Services\ExportService;
use App\Http\Requests\FormRequest;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{

    public function __construct()
    {

        $this->middleware(['auth']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        $forms = Form::byUser($user->id)
                        ->withCount([
                            'responses',
                            'responses as spam_count' => function(Builder $query) {
                                $query->where('is_spam', true);
                            },
                            'responses as recent_count' => function(Builder $query) {
                                $query->where('created_at', '>=', now()->subDay());
                            }
                        ])
                        ->get();

        

        $responses_count = $forms->reduce(function($carry, $f) {
            return $carry + $f->responses_count;
        });
        
        $spam_count = $forms->reduce(function($carry, $f) {
            return $carry + $f->spam_count;
        });
        
        $recent_count = $forms->reduce(function($carry, $f) {
            return $carry + $f->recent_count;
        });

        
        $data = [
            'forms'             => $forms,
            'total_forms'       => $forms->count(),
            'total_responses'   => $responses_count ?? 0,
            'total_spam'        => $spam_count ?? 0,
            'total_recent'      => $recent_count ?? 0,
        ];

        return response()->json($data);

    }

    public function create()
    {

        $user = User::find(Auth::user()->id);
        $email = $user->email;
        $plan = $user->tier;
        $forms = Form::where('user_id', $user->id)->count();
       
        if($plan == 'free') {
            if($forms > 0) {
                return redirect()->route('upgrade')->with('failed', 'You hit your form capacity. Upgrade for unlimited forms!');
            }
            
        }

        return view('forms.create', compact('email', 'plan'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {

        $user = Auth::user();

        $form = Form::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'slug' => Str::uuid()->toString(),
            'secret' => Str::uuid()->toString(),
            'domain' => $request->domain,
            'enabled' => true,
            'notify_by_email' => $request->notify_by_email ? true : false,
            'webhook_url' => $request->webhook_url
        ]);

       

        return redirect("/form/{$form->id}");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {

        $this->authorize('read', $form);

        $formToSend = Form::with(['responses' => function($q) {
                                $q->orderBy('created_at', 'desc');
                            }], 'emailResponse')
                            ->withCount([
                                'responses',
                                'responses as spam_count' => function(Builder $query) {
                                    $query->where('is_spam', true);
                                },
                                'responses as recent_count' => function(Builder $query) {
                                    $query->where('created_at', '>=', now()->subDay());
                                }
                            ])
                            ->where('id', $form->id)
                            ->first();

        $form = $formToSend;

        return view('forms.view', compact('form'));

    }

    public function edit(Form $form)
    {
        $this->authorize('edit', $form);
        $form->load('emailResponse');
        $user = Auth::user();
        return view('forms.edit', compact('form', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequest $request, Form $form)
    {
        $this->authorize('edit', $form);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'domain' => $request->domain,
            'notify_by_email' => $request->has('notify_by_email'),
            'webhook_url' => $request->webhook_url,
            'enabled' => $request->has('enabled'),
            'site_key' => $request->site_key,
            'secret_key' => $request->secret_key,
        ];

        $form->update($data);

        if($request->has('template')) {
            $template = json_decode($request->template);
            if($template) {
                $emailResponse = EmailResponse::updateOrCreate(
                    [
                        'form_id' => $form->id,
                    ],
                    [
                        'subject' => $request->subject,
                        'template' => $template->html,
                        'json_template' => json_encode($template->design),
                    ]
                );
            }
        }

        return redirect("/form/{$form->id}");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {

        $this->authorize('delete', $form);

        $form->enabled = false;
        $form->save();
        $form->delete();

        return response()->json('ok');

    }

    public function export(string $type, Form $form)
    {

        $formToSend = Form::find($form->id)
                            ->with(['responses' => function($q) {
                                $q->orderBy('created_at', 'desc');
                            }])
                            ->first();

        $service = new ExportService($formToSend);

        switch ($type) {
            case 'excel':
                return $service->toExcel();
                break;
            
            default:
                // We'll just do a CSV
                return $service->toCsv();
                break;
        }

    }

}
