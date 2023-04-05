<?php

namespace App\Http\Controllers;

use App\Models\Notification as ModelsNotification;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use App\Notifications\OffersNotification;
use Illuminate\Support\Facades\URL;
use Kutia\Larafirebase\Facades\Larafirebase;
use Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $my_notifications = auth()->user()->notifications()->orderBy('notification_users.is_read', 'asc')->orderBy('notification_users.id', 'desc')->paginate(15);
        return view('notification.index', compact('my_notifications'));
    }

    public function mark_read($id)
    {
        auth()->user()->notifications()->updateExistingPivot($id, [
            'is_read' => true,
        ]);
        return redirect()->route('notifications.index');
    }

    public function sendOfferNotification()
    {
        $userSchema = User::first();

        $offerData = [
            'name' => 'BOGO',
            'body' => 'You received an offer.',
            'thanks' => 'Thank you',
            'offerText' => 'Check out the offer',
            'offerUrl' => url('/'),
            'offer_id' => 007
        ];

        Notification::send($userSchema, new OffersNotification($offerData));

        dd('Task completed!');
    }


    public function updateToken(Request $request)
    {
        try {
            $request->user()->update(['fcm_token' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function notification($title = "", $body = "", $fcmTokens = array())
    {

        try {
            //$fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            $SERVER_API_KEY = config('constants.server_key');

            $data = [
                "registration_ids" => $fcmTokens,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "icon" => URL::asset('assets/images/favicon.ico'),
                    'click_action' => 'https://www.example.com/'
                ],
                "webpush" => [
                    "fcm_options" => [
                        "link" => "https://dummypage.com"
                    ]
                ]

            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            return redirect("/")->with('success', 'Notification Sent Successfully!!');
        } catch (\Exception $e) {
            report($e);
            return redirect("/")->with('error', 'Something goes wrong while sending notification.');
        }
    }
}
