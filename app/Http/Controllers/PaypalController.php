<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use Illuminate\Support\Facades\Input;

use App\Cliente;
use App\CarroCompra;
use App\DetalleCarroCompra;

class PaypalController extends Controller
{

	private $_api_context;


	public function __construct()
	{
		// instalar PayPal api context
		$paypal_conf = \Config::get('paypal');
		$this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
		$this->_api_context->setConfig($paypal_conf['settings']);
	}


	/**
	*	Enviar informacion a Paypal
	**/
    public function postPayment()
    {
    	$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$currency = 'USD';// Modena Dolar
		$precioDolar = 641.05;//Cargar con web service PROXIMAMENTE
		$items = array();
		$subtotal = 0;
		$envio = 0;

		$id_carro_compra = \Session::get('id_carro_compra');

		$carro_compra = CarroCompra::find($id_carro_compra);
        $detalleCarro = DetalleCarroCompra::idCarroCompra($carro_compra->id_carro_compra)->get();

		foreach ($detalleCarro as $detalle) {
			$detalle = (object)$detalle;

			$item = new Item();
			$item->setName($detalle->producto->nombre)
				->setCurrency($currency)
				->setDescription($detalle->producto->descripcion)
				->setQuantity($detalle->cantidad)
				->setPrice($detalle->precio/$precioDolar);

			$items[] = $item;
			$subtotal += $detalle->cantidad * $detalle->precio/$precioDolar;			
		}
		
		//Listado de de productos venta
		$item_list = new ItemList();
		$item_list->setItems($items);

		//Detalle de la venta
		$details = new Details();
		$details->setSubtotal($subtotal)
		->setShipping($envio);//Costo de envio

		$total = $subtotal + $envio;

		//Total venta
		$amount = new Amount();
		$amount->setCurrency($currency)
			->setTotal($total)
			->setDetails($details);

		//Transaccion
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription('Pedido de prueba en mi Laravel App Store');

		//URL redireccion resultados
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(\URL::route('payment.status'))//Url exito
			->setCancelUrl(\URL::route('payment.status'));//Url fracaso

		//Venta
		$payment = new Payment();
		$payment->setIntent('Sale')
			->setPayer($payer)
			->setRedirectUrls($redirect_urls)
			->setTransactions(array($transaction));

		try {
			$payment->create($this->_api_context);
		} catch (\PayPal\Exception\PPConnectionException $ex) {
			if (\Config::get('app.debug')) {
				echo "Exception: " . $ex->getMessage() . PHP_EOL;
				$err_data = json_decode($ex->getData(), true);
				exit;
			} else {
				die('Ups! Algo salió mal');
			}
		}

		foreach($payment->getLinks() as $link) {
			if($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
				break;
			}
		}


		// add payment ID to session
		\Session::put('paypal_payment_id', $payment->getId());

		if(isset($redirect_url)) {
			// redirect to paypal
			return \Redirect::away($redirect_url);
		}

		return \Redirect::route('carroCompra')
			->with('message', 'Ups! Error desconocido.');
    }

    /**
    *	Recibir informacion de Paypal
    */
    public function getPaymentStatus(){
    	// Obtener el payment ID antes que se elimine de la session
		$payment_id = \Session::get('paypal_payment_id');

		// Eliminar en la session el payment ID
		\Session::forget('paypal_payment_id');

		$payerId = Input::get('PayerID');
		$token = Input::get('token');

		if (empty($payerId) || empty($token)) {
			return \Redirect::route('carroCompra')
				->with('message', 'Ups! Ocurrio un problema al intentar pagar con Paypal');
		}

		$payment = Payment::get($payment_id, $this->_api_context);

		$execution = new PaymentExecution();
		$execution->setPayerId(Input::get('PayerID'));

		$result = $payment->execute($execution, $this->_api_context);


		if ($result->getState() == 'approved') {
			return \Redirect::route('guardarVenta',[1]);
		}
		return \Redirect::route('carroCompra')
			->with('info', 'La compra fue cancelada');
    }
}
