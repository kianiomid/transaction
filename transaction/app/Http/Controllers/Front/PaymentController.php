<?php
/**
 * Created by PhpStorm.
 * User: omid
 * Date: 10/22/20
 * Time: 5:07 PM
 */

namespace App\Http\Controllers\Front;


use App\Http\Controllers\AppBaseController;
use App\Models\UserGatewayLog;
use App\Repositories\UserAccountSettingRepository;
use App\Repositories\UserGatewayLogRepository;
use App\Services\Zarinpal\Zarinpal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Finder\Exception\AccessDeniedException;


class PaymentController extends AppBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.payment.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function payment(Request $request)
    {
        $price = $request->get('price');
        $mobile = $request->get('mobile');

        $this->validate($request, [
            'price' => 'required|integer|between:10000,100000000',
            'mobile' => 'required|numeric|regex:/^09(\d{9})$/'
        ]);

        $this->loadCurrentUser();

        $userAccountSetting = UserAccountSettingRepository::createInstance(app())
            ->findByUserId($this->currentUser->getKey());

        $order = new ZarinPal();
        $res = $order->payment($price / 10, $this->currentUser->email, $mobile);

        $ugl = new UserGatewayLog();
        $ugl->setAttribute('user_id', $this->currentUser->getKey());
        $ugl->setAttribute('currency_id', $userAccountSetting->country->currency_id);
        $ugl->setAttribute('price', $price);
        $ugl->setAttribute('gateway_result', $res);
        $ugl->save();

        return redirect('https://www.zarinpal.com/pg/StartPay/' . $res);
    }

    public function order(Request $request)
    {
        $merchantID = Config::get('app.MERCHANTID');
        $authority = $request->get('Authority');

        $userGatewayLog = UserGatewayLogRepository::createInstance(app())
            ->findByGatewayResult($authority);
        $price = $userGatewayLog->price;

        $userAccountSettingRepos = UserAccountSettingRepository::createInstance(app());

        if ($request->get('Status') == 'OK') {

            $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $merchantID,
                    'Authority' => $authority,
                    'Amount' => $price / 10,
                ]
            );

            if ($result['Status'] == 100) {

                $options = [
                    'refId' => $result['RefID'],
                    'userId' => $userGatewayLog->user_id,
                    'deposit' => $price,
                    'paymentType' => 'ZarinPal',
                    'currencyId' => $userGatewayLog->currency_id,
                ];

                DB::beginTransaction();
                try {
                    $userAccountSettingRepos->updateAccountBalance($options);

                    DB::commit();

                    return redirect(route('front.success.payment', [
                        'id' => $userGatewayLog->id
                    ]))->with('message', Lang::get('field.success_payment'));

                } catch (\Exception $e) {
                    DB::rollBack();

                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                }

            } else {

                return redirect(route('front.failure.payment', [
                    'id' => $userGatewayLog->id
                ]))->with('message', Lang::get('field.failed_payment'));
            }
        } else {

            return redirect(route('front.failure.payment', [
                'id' => $userGatewayLog->id
            ]))->with('message', Lang::get('field.failed_payment'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function successPayment($id)
    {
        $this->loadCurrentUser();
        $userGatewayLog = $this->loadGatewayAndCheckCredentials($id);

        return view('front.success.payment', compact('userGatewayLog'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function failurePayment($id)
    {
        $this->loadCurrentUser();
        $userGatewayLog = $this->loadGatewayAndCheckCredentials($id);

        return view('front.failure.payment', compact('userGatewayLog'));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function loadGatewayAndCheckCredentials($id)
    {
        $userGatewayLog = UserGatewayLogRepository::createInstance(app())
            ->find($id);

        if ($userGatewayLog->user_id != $this->currentUser->getKey()) {
            throw new AccessDeniedException();
        }

        return $userGatewayLog;
    }
}