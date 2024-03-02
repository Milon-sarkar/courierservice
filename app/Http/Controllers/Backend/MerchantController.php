<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Services\SmsService;
use Illuminate\Http\Request;
use App\Http\Requests\Merchant\StoreRequest;
use App\Http\Requests\Merchant\SignUpRequest;
use App\Http\Requests\Merchant\UpdateRequest;
use App\Http\Requests\Merchant\OtpRequest;
use App\Mail\MerchantSignup;
use App\Repositories\Merchant\MerchantInterface;
use Illuminate\Support\Facades\Mail;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\User;
use Illuminate\Support\Facades\Http;
class MerchantController extends Controller
{
    protected $repo;
    public function __construct(MerchantInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $merchants = $this->repo->all();
        return view('backend.merchant.index',compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hubs = $this->repo->all_hubs();

        return view('backend.merchant.create', compact('hubs'));
    }

    public function signUp(Request $request)
    {

        $hubs       = $this->repo->all_hubs();
        return view('backend.merchant.sign_up',compact('hubs','request'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        if($this->repo->store($request)){
            Toastr::success(__('merchant.added_msg'),__('message.success'));
            return redirect()->route('merchant.index');
        }else{
            Toastr::error(__('merchant.error_msg'),__('message.error'));
            return redirect()->back()->withInput($request->all());
        }

    }


    public function signUpStore(SignUpRequest $request)
    {
        if($this->repo->signUpStore($request)){
            $user_otp = User::where('mobile',$request->mobile)->first();
            //return $user_otp;
            // API endpoint
            $url = 'https://smsplus.sslwireless.com/api/v3/send-sms';

            // Data to be sent in the request body
            $data = [
                "api_token" => "rlzsm3c7-3f09natf-x7jkiuk0-6ex2auq7-a19c76vy",
                "sid" => "SAFELINENONOTP",
                "msisdn" => $user_otp->mobile,
                "sms" => "Naver Share Any Code. OTP Code " .$user_otp->otp." for verification",
                "csms_id" => "4473433434pZ684".rand(1000, 9999)
            ];

            // Make API call
            $response = Http::post($url, $data);
            return redirect()->route('merchant.otp-verification-form');
        }else{
            Toastr::error(__('merchant.error_msg'),__('message.error'));
            return redirect()->back()->withInput($request->all());
        }
    }


    public function otpVerification(OtpRequest $request)
    {
        $result     = $this->repo->otpVerification($request);
        if($result != null){
            if(auth()->attempt([
                                'mobile' => $result->mobile,
                                'password' => session('password')
                            ]))
            {
                return redirect()->route('login');
            }
        }
        elseif($result == 0){
            return redirect()->route('merchant.otp-verification-form')->with('warning', 'Invalid OTP');
        }
        else{
            Toastr::error(__('merchant.error_msg'),__('message.error'));
            return redirect()->back();
        }
    }

    public function otpVerificationForm()
    {
        return view('backend.merchant.verification');
    }

    public function resendOTP(Request $request)
    {
        $this->repo->resendOTP($request);
        return redirect()->route('merchant.otp-verification-form')->with('success', 'Resend OTP');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $singleMerchant = $this->repo->get($id);
        $merchant_shops =$this->repo->merchant_shops_get($id);
        if(blank($singleMerchant)){
            abort(404);
        }
        return view('backend.merchant.merchant-details',compact('singleMerchant','merchant_shops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hubs     = $this->repo->all_hubs();
        $merchant = $this->repo->get($id);
        if(blank($merchant)){
            abort(404);
        }
        return view('backend.merchant.edit',compact('merchant','hubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateRequest $request)
    {

        if($this->repo->update($id,$request)){
            Toastr::success(__('merchant.update_msg'),__('message.success'));
            return redirect()->route('merchant.index');
        }else{
            Toastr::error(__('merchant.error_msg'),__('message.error'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->repo->delete($id)){
            Toastr::success(__('merchant.delete_msg'),__('message.success'));
            return back();
        }else{
            Toastr::error(__('merchant.error_msg'),__('message.error'));
            return redirect()->back();
        }
    }
}
