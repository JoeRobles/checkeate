<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Culqi\Culqi;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('AppBundle:File')->findById(1);

        return $this->render(
            'default/index.html.twig',
            array(
                'orden' => uniqid(mt_rand(), true),
                'file' =>  $file[0]
            )
        );
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
        $culqi = new Culqi(array(
            'api_key' => $this->container->getParameter('secret_api_key')
        ));
        $culqi->setEnv("PRODUC");
        $token = $request->request->get('token');
        $datos = $request->request->get('datos');
        $datos = json_decode($datos);

        if ($token) {
            try {
                $cargo = $culqi->Cargos->create(array(
                    "token"=> $token,
                    "moneda"=> "PEN",
                    "monto"=> 200,
                    "descripcion"=> $datos->descripcion,
                    "pedido"=> $datos->orden,
                    "codigo_pais"=> "PE",
                    "ciudad"=> "Lima",
                    "usuario"=> "71701956",
                    "direccion"=> "Avenida Lima 1232",
                    "telefono"=> 3333339,
                    "nombres"=> $datos->nombre,
                    "apellidos"=> $datos->apellido,
                    "correo_electronico"=> $datos->correo_electronico
                ));

                if (isset($cargo->id)) {
                    return $this->render('default/verify.html.twig', array('cargo' => $cargo));
                } else {
                    return $this->render('default/verify.html.twig', array('cargo' => $cargo));
                }
            } catch(Exception $e) {
                return $this->render('default/verify.html.twig', array('mensaje' => $e->getMessage()));
            }
        }

        return $this->render('default/verify.html.twig', array());
    }

    /**
     * @Route("/libro", name="libro")
     */
    public function libroAction(Request $request)
    {
        return new BinaryFileResponse(__DIR__ . '/../Resources/private/Demasiado-inteligente-para-ser-feliz-Jeanne-Siaud-Facchin.pdf');
    }
}
