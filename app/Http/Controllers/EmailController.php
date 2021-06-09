<?php

namespace App\Http\Controllers;

use Stackkit\LaravelDatabaseEmails\Email;
use App\Http\Requests\EmailRequest;
use Illuminate\Http\Request;
use App\Models\Email as EmailModel;
use Auth;

class EmailController extends Controller
{
    /**
     * Show email list, filter by user or all if user is admin
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $itemsPerPage = $request->input('items',5);

        $emails = EmailModel::query();
        $emails = (!Auth::user()->flag_admin) ? $emails->where('label', '=', Auth::user()->id) : $emails;
        $emails = ($sort && $direction ) ? $emails->orderBy($sort, $direction) : $emails;
        $emails = $emails->paginate($itemsPerPage);

        return view('email-list', [ 'emails' => $emails, 'items' => $itemsPerPage, 'message' => null]);
    }

    /**
     * Show form to create and send email
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('email-create');
    }

    /**
     * Put email on queue to send after when execute command: php artisan email:send
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request): \Illuminate\Http\RedirectResponse
    {
        /**
        *   Validate data
        */
        $request->validate([
            'recipient' => 'required|email',
            'subject' => 'required|max:250',
            'message' => 'required|string'
        ]);

        /*
        * Get data in variables
        */
        $recipient = $request->input('recipient');
        $subject = $request->input('subject');
        $message = $request->input('message');

        try {
            /**
            *   Email is put on queue and send when this command is ejecuted: php artisan email:send
            */
            Email::compose()
                ->label(Auth::user()->id)
                ->from(Auth::user()->email)
                ->recipient($recipient)
                ->subject($subject)
                ->view('email-layout')
                ->variables([
                    'message' => $message,
                ])
                ->send();

            return redirect()->route('email.index');

        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

    }

    /**
     * Return email in json data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function indexApi(EmailRequest $request): \Illuminate\Http\JsonResponse
    {   
        $itemsPerPage = $request->input('items',10);
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $filter_text = $request->input('filter_text');

        $emails = EmailModel::query();
        $emails = ( $sort && $direction ) ? $emails->orderBy($sort, $direction) : $emails;

        $emails = ( $filter_text ) ?
            $emails->where('from', 'like', '%' . $filter_text . '%')
                ->orWhere('recipient', 'like', '%"' . $filter_text . '"%')
                ->orWhere('subject', 'like', '%' . $filter_text . '%')
            : $emails;

        $emails = $emails->paginate($itemsPerPage);

        return response()->json($emails);
    }
}
