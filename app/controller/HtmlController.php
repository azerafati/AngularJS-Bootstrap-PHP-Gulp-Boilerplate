<?php


/**
 * Class to manage php viewControllers
 *
 * @author Alireza Zerafati (bludream@gmail.com)
 *
 */
class HtmlController extends Controller {
    private static $fragmentsPath = AppRoot . "view/fragments/";
    protected $useBase = true;

    public $view = [
        "script" => [],
        "title" => '',
        "head" => '',
        "scriptTag" => null
    ];

    /**
     *
     * @return HtmlController
     */
    static function create() {
        return parent::create();
    }

    function setBase($basePath = false) {
        if (!$basePath) {
            $this->useBase = false;
        } else {

        }
        return $this;
    }

    /**
     *
     * Getting fragments
     *
     * @param Html $fragment
     */
    function get($fragment) {
        $view = $this->view;
        $controller = $this;

        require(static::$fragmentsPath . $fragment . ".php");
    }

    /**
     * parameters passed to view Scope used in base template
     *
     * @param array $viewParams
     */
    function viewScope($viewParams) {
        $this->view = array_merge($this->view, $viewParams);
        return $this;
    }

    /*
     * Overwritten authorize to redirect users to the login page
     *
     * @see Controller::authorize()
     */
    function authorize($permission) {
        if (! AuthorizationService::hasPermission($permission)) {
            http_response_code(405);
            if(!UserService::isUserSignedIn()){
                header( 'location: /login?r='.$_SERVER['REQUEST_URI'] );
            }else{
                exit("شما مجوز دسترسی به این صفحه را ندارید با پشتیبانی تماس بگیرید.");
            }
            exit();
        }
        return $this;
    }

    /*
     * (non-PHPdoc)
     * @override
     * @see Controller::run()
     */
    function run($function) {
        parent::run(function () use ($function) {
            if (!$this->view["title"])
                $this->view["title"] = "";
            $this->view["content"] = $function;
            $this->view["fpath"] = self::$fragmentsPath;
            if ($this->useBase) {
                $this->get("base");
            } else {
                call_user_func_array($function, $this->view);
            }
        });
    }

    function showView($viewPage) {
        $this->run(function () use ($viewPage) {
            $this->get('../' . $viewPage);
        });
    }


    static function notFound() {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        self::create()->viewScope([])->showView("404");
    }


}