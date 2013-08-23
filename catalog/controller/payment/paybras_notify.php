<?php
header('Content-Type: text/html; charset=utf-8');
require_once "paybras.php";

class ControllerPaymentPaybrasNotify extends Controller {
    public function index() {
        $this->load->model('checkout/order');
        try {
            if(isset($_POST['data'])){
                $json = str_replace('&quot;', '"', $_POST['data']);
                $post_data = json_decode($json, true);

                $comment = null;
                if(!isset($post_data['nao_autorizado_codigo']) || empty($post_data['nao_autorizado_codigo'])) {
                    $post_data['nao_autorizado_codigo'] = null;
                }

                $statusOpecart = Paybras::getStatusOpencart($post_data['status_codigo'], $post_data['nao_autorizado_codigo']);

                if($statusOpecart == false){
                    $retorno['retorno'] = 'ok';
                    echo json_encode($retorno);
                    die;
                }

                $post_data['status_codigo'] = $statusOpecart['status_code'];
                $post_data['status_comment'] = $statusOpecart['status_comment'];

                $this->model_checkout_order->update($post_data['pedido_id'], $post_data['status_codigo'], $post_data['status_comment'], true, null);

                $retorno['retorno'] = 'ok';
                echo json_encode($retorno);
            } else {
                $retorno['retorno'] = 'nok';
                echo json_encode($retorno);
            }
        } catch (Exception $e) {
            $this->log->write('Paybras: '.$e->getMessage());
        }
    }
}