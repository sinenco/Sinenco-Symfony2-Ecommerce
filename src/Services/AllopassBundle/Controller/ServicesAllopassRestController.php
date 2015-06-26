<?php

namespace Services\AllopassBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ServicesAllopassRestController extends Controller {

    public function returnAllopassAction() {
        if (isset($_GET["data"])) {
            if (!isset($_GET["action"])) {
                return $this->renderRedirectView();
            }
        }
    }

    public function callbackAllopassAction() {
        if (isset($_GET["data"])) {
            if (isset($_GET["action"])) {
                /* On traite la callback  */
                return $this->getCallbackResponse();
            }
        }
    }

    private function getUsefullParamaters(&$id, &$invoice, &$renting) {
        
        $id = $_GET["data"];
        $invoice = $_GET["user_id"];

        $renting = $this->getDoctrine()
                ->getRepository('ServicesCoreBundle:Renting')
                ->find($id);

        if ($renting == null) {
            echo "NO RENTING";
            return false;
        }

        return true;
    }

    private function getCallbackResponse() {

        $id = $invoice = $renting = 0;

        if ($this->getUsefullParamaters(&$id, &$invoice, &$renting) == false) {
            die();
        }

        if ($renting->getService()->getName() == "whcms_allopass_commission") {
            $url = $this->getCompleteAddress($renting) . "/modules/gateways/callback/allopass.php?";
        } elseif ($renting->getService()->getName() == "hostbill_allopass_commission") {
            $url = $this->getCallbackAddress($renting) . "&";
        } else {
            echo "BAD RENTING";
            die();
        }


        return new RedirectResponse(
                $url . http_build_query($_GET), 307
        );
    }

    private function renderRedirectView() {

        $id = $invoice = $renting = 0;

        if ($this->getUsefullParamaters(&$id, &$invoice, &$renting) == false) {
            die();
        }

        if ($renting->getService()->getName() == "whcms_allopass_commission") {
            $url = $this->getCompleteAddress($renting) . "/index.php?m=allopass";
        } elseif ($renting->getService()->getName() == "hostbill_allopass_commission") {
            $url = $this->getCallbackAddress($renting) . "&";
        } else {
            echo "BAD RENTING";
            die();
        }


        return new RedirectResponse(
                $url . http_build_query($_GET), 307
        );
    }

    private function getCompleteAddress($renting) {
        foreach ($renting->getDetails() as $detail) {
            if ($detail->getDetailName()->getCanonicalName == "complete_address") {
                return $detail->getValue();
            }
        }
    }

    private function getCallbackAddress($renting) {
        foreach ($renting->getDetails() as $detail) {
            if (strstr($detail->getDetailName()->getCanonicalName, "callback")) {
                return $detail->getValue();
            }
        }
    }

}