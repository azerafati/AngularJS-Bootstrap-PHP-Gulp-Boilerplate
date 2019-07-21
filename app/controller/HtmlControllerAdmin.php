<?php


/**
 * Class to manage php viewControllers
 *
 * @author Alireza Zerafati (bludream@gmail.com)
 *
 */
class HtmlControllerAdmin extends HtmlController {
    protected static $fragmentsPath = AppRoot . "view/" . "admin_fragments/";

    /**
     * @return HtmlControllerAdmin
     */
    static function create() {
        $controller = parent::create()->authorize(Permission::ADMIN_DASHBOARD);
        return $controller;
    }


    function authorize($permission) {
        if (!AuthorizationService::hasPermission($permission)) {
            http_response_code(405);
            if (!UserService::isUserSignedIn()) {
                header('location: /login?r=' . $_SERVER['REQUEST_URI']);
            } else {
                exit("شما مجوز دسترسی به این صفحه را ندارید با پشتیبانی تماس بگیرید.");
            }
            exit();
        }
        return $this;
    }


    function run($function) {

        if (!$this->view["title"])
            $this->view["title"] = "پنل مدیریت";

        parent::run($function);

    }


}