<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Util\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;
use Payment\Model\PaymentConfig;
use PayU\Payment\PaymentCountries;
use Likerow\Util\Server;
use Util\Util\Util;
use \Pgp\Entity\PgpPerfilPago as EntityPgpPerfilPago;
use Pgp\Entity\PgpPago as EntityPgpPago;

class PaymentController extends BaseController
{
    public function createCartAction()
    {        
        $id = 'chk'.uniqid();
        $params = $this->getZParams();
        $uri = '/';
        $params['idTransaction'] = $id;
        $paymentBase = new PaymentConfig($params, $this->getServiceLocator());
        if(!$paymentBase->isError()) {
            $partner = $paymentBase->getPartner();
            $uri = '/payment/' . $partner['partner_slug'].'/'.  $id;
        }
        $this->redirect()->toUrl($uri);
    }

    public function orderAction()
    {      
        $params = $this->getZParams();
        $idtransaction = $params['id'];
        $this->service()->get('ZendViewRendererPhpRenderer')->headTitle('Payment');
        $paymentCart = $this->getServiceLocator()->get('PaymentCart');
        $modelParters =  $this->getServiceLocator()->get('Model\SysPartners');
        $optionalInfo = $paymentCart->getOptionalInfo($idtransaction);
        $dataPartner = $modelParters->getParterKey($optionalInfo['KEY']);
        $countryBilling = empty($optionalInfo['DPAGO']['PAIS']) 
                ? PaymentCountries::PERU : $optionalInfo['DPAGO']['PAIS'];
        $data = array(
            'nombres' => !empty($optionalInfo['DPAGO']['NOMBRES'])?$optionalInfo['DPAGO']['NOMBRES']:'',
            'apellidos' => !empty($optionalInfo['DPAGO']['APELLIDOS'])?$optionalInfo['DPAGO']['APELLIDOS']:'',
            'email' => !empty($optionalInfo['DPAGO']['EMAIL'])?$optionalInfo['DPAGO']['EMAIL']:'',
            'direccion' => !empty($optionalInfo['DPAGO']['DIRECCION'])?$optionalInfo['DPAGO']['DIRECCION']:'',
            //'countries' => $optionalInfo['DPAGO']['PAIS'],
            'ciudad' => !empty($optionalInfo['DPAGO']['CIUDAD'])?$optionalInfo['DPAGO']['CIUDAD']:'',
            'countries' =>$countryBilling,
        );
        $formPagos = $this->service()->get('Form\FormPago');
        $modelPgpPagos = $this->service()->get('Model\PgpPago');
        $dataPaymentMethods = $modelPgpPagos->getPaymentMethods($countryBilling, $dataPartner['partner_id']);
        $formPagos->setData($data);
        $view = new ViewModel(array(
                'optionPayment' => Json::encode($dataPaymentMethods),
                'countryBilling' => $countryBilling,
                'formPagos' => $formPagos,
                'total' => $this->ZendCart()->total(),
                'items' => $this->ZendCart()->cart(),
                'partnerData' => $dataPartner,
                'aliasPartner' => $this->layout()->aliasPartner,
                'idTransaction' =>  $idtransaction,
            ));
        if (Util::isCustomFrontHtml($dataPartner['partner_slug'])) {
            $view->setTemplate($dataPartner['partner_slug'] . '/order.phtml');
        }
        return $view;
    }

    public function paymentMethodsAction()
    {
        $params = $this->getZParams();
        $paymentCart = $this->getServiceLocator()->get('PaymentCart');
        $modelPgpPagos = $this->service()->get('Model\PgpPago');
        $countryBilling = PaymentCountries::PERU;
        if(isset($params['country'])){
            $countryBilling = $params['country'];
        }
        $optionalInfo = $paymentCart
                ->getOptionalInfo($params['transactionId']);
        $dataPaymentMethods = $modelPgpPagos
                ->getPaymentMethods($countryBilling ,$optionalInfo['partner']['partner_id']);

        return new JsonModel($dataPaymentMethods);
    }

    public function saveOrderAction()
    {
        $params = $this->getZParams();
        $modelPgpPagos = $this->service()->get('Model\PgpPago');
        $params['entidadPagoSelect'] =  $params['typecard'];
        $response = $modelPgpPagos->createOrder($params, $this->ZendCart());
        return new JsonModel($response);
    }


    public function cartAction(){

        $this->getEntityManager()->getRepository('Edu\Entity\EduComentarios');
        return new ViewModel();
    }

    public function completeAction(){
        $modelPgpPagos = $this->service()->get('Model\PgpPago');
        $params = $this->getZParams();
        $data = array();
        $uri = '/';
        $dataPartner = array();
        if(isset($params['pa_id'])){
            $data = $modelPgpPagos->getPagoOperacion($params['pa_id']);
            if(empty($data)) {
                $this->redirect()->toUrl(Server::getContent() . 'pgp/payment/cancel');
                exit;
            }
            else {
                $dataPartner = $modelPgpPagos->getPagoPartner($params['pa_id']);
                if(!empty($dataPartner['partner_uri_retorno'])) {
                    $uri = $dataPartner['partner_uri_retorno'];
                }
                $this->layout()->partnerData = $dataPartner;
            }
        }
        return new ViewModel(
                array(
                    'productos' => $data,
                    'uri' => $uri,
                    'partner' => $dataPartner,
                )
            );
    }

    public function pendingAction(){
        $modelPgpPagos = $this->service()->get('Model\PgpPago');
        $params = $this->getZParams();
        $data = array();
        $uri = '/';
        $dataPartner = array();
        if(isset($params['pa_id'])){
            $data = $modelPgpPagos->getPagoOperacion($params['pa_id']);
            if(empty($data)){
                $this->redirect()->toUrl('/pgp/payment/cancel');
            }
            else {
                $dataPartner = $modelPgpPagos->getPagoPartner($params['pa_id']);
                if(!empty($dataPartner['partner_uri_retorno'])) {
                    $uri = $dataPartner['partner_uri_retorno'];
                }
            }
        }
        return new ViewModel(
                array(
                    'productos' => $data,
                    'uri' => $uri,
                    'partner' => $dataPartner,
                )
            );
    }
    
    public function cancelAction(){
        return new ViewModel(array('message' => 'Cancelado :('));
    }

    public function confirmationsAction(){
        $params = $this->getZParams();
        $uri = Server::getContent() . 'pgp/payment/complete';
        $estadosTerminados  = array(
            EntityPgpPago::ESTADO_CANCELADO,
            EntityPgpPago::ESTADO_PAGADO
        );
        if(isset($params['transactionId'])){
            $modelPgpPagos = $this->service()->get('Model\PgpPago');
            $dataPago = $modelPgpPagos->getByCode($params['transactionId']);
            if(!empty($dataPago)){
                if($params['lapResponseCode'] == 'APPROVED'){
                    $uri = Server::getContent() . 'pgp/complete/' . $dataPago['pa_id'];
                    if(in_array($dataPago['estado'], $estadosTerminados)){

                    }
                    else{
                        $modelPgpPagos->update(
                            array('pa_estado' =>  EntityPgpPago::ESTADO_PAGADO,
                                'fecha_edicion' => date('Y-m-d H:i:s'),
                                'pa_params' => json_encode($params)),
                            array('pa_id=?' => $dataPago['pa_id'])
                        );
                    }
                }
                else{
                    $modelPgpPagos->update(
                            array('pa_estado' =>  EntityPgpPago::ESTADO_CANCELADO,
                                'fecha_edicion' => date('Y-m-d H:i:s'),
                                'pa_params' => json_encode($params)),
                            array('pa_id=?' => $dataPago['pa_id'])
                        );
                    $uri = Server::getContent() . 'pgp/cancel/' . $dataPago['pa_id'];
                }
            }
            else{
                $uri = Server::getContent() . 'pgp/cancel';
            }
        }
        else{
            $uri = Server::getContent() . 'pgp/cancel';
        }
        $this->redirect()->toUrl($uri);
        exit;
    }

}
