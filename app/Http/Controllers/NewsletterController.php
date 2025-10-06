<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email,
            'is_subscribed' => true,
        ]);

    //    return response()->json([
    //         'ok' => true,
    //         'message' => 'Vous êtes inscrit à la newsletter.'
    //     ]);
    }

    public function manage()
    {
        $subscribers = NewsletterSubscriber::all();
        return view('newsletter.admin', compact('subscribers'));
    }

    public function unsubscribe($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->subscribed = false;
        $subscriber->save();

        return redirect()->back()->with('success', 'Subscriber has been unsubscribed.');
    }
public function admin()
{
    $subscribers = NewsletterSubscriber::all();
    return view('newsletter.admin', compact('subscribers'));
}

}
