<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Culqi\Culqi;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', array());
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        return $this->render('admin/admin.html.twig', array());
    }

    /**
     * @Route("/verify", name="verify")
     */
    public function verifyAction(Request $request)
    {
        $culqi = new Culqi(array('api_key' => $this->get('secret_api_key')));
        $culqi->setEnv("INTEG");

        $request->request->get('category');

        $pedidoId = sha1(uniqid(mt_rand(), true));

        try {
            $cargo = $culqi->Cargos->create(array(
                "moneda"=> "PEN",
                "monto"=> 19900,
                "usuario"=> "71701956",
                "descripcion"=> "Venta de prueba",
                "pedido"=> $pedidoId,
                "codigo_pais"=> "PE",
                "direccion"=> "Avenida Lima 1232",
                "ciudad"=> "Lima",
                "telefono"=> 3333339,
                "nombres"=> "Brayan",
                "apellidos"=> "Cruces",
                "correo_electronico"=> "brayan.cruces@culqi.com",
                "token"=> "vJk6e1LIoZLdDwEXTE6KMQlaJvqswSwU"
            ));
        } catch(Exception $e) {
            // ERROR: El cargo tuvo algún error o fue rechazado
            echo $e->getMessage();

        }

        return $this->render('default/verify.html.twig', array());
    }
}
