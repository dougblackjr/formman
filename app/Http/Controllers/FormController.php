<?php

namespace App\Http\Controllers;

use App\Form;
use App\Response;
use App\Services\ExportService;
use App\Http\Requests\FormRequest;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
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

        return view('forms.create');

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
                            }])
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

        return view('forms.edit', compact('form'));

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
        ];

        $form->update($data);

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
