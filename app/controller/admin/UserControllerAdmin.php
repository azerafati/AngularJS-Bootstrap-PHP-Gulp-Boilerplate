<?php


class UserControllerAdmin {

    static function userListPage() {
        HtmlControllerAdmin::create()->viewScope([
            "title" => "مشتریان",
            "activeSection" => "users",
            "script" => [
                "user-list-page.js?v=1.0.3"
            ]
        ])->showView('admin/UserList');
    }

    static function userPage($id) {
        $c = HtmlControllerAdmin::create();
        $user = UserRepository::loadById($id);
        if (!$user) {
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            $c->viewScope([])->showView("404");
        } else {
            $c->viewScope([
                "title" => $user->getName(),
                "activeSection" => "users",
                'body' => '<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>',
                "script" => [
                    "user-page.js?v=2.2.5"
                ],
                "meta" => [
                    "user_id" => $id
                ],
                "user" => $user,
            ])->showView('admin/UserPage');
        }
    }

    static function chgPass($_req, $ctrl) {
        if (!isset($_req['id']))
            $ctrl->badRequest('ID_INVALID');

        if (!isset($_req['pass']))
            $ctrl->badRequest('PASSWORD_INVALID');

        if (strlen($_req['pass']) < 5) {
            $ctrl->badRequest("SHORT_PASSWORD");
        }
        $pass = password_hash($_req['pass'], PASSWORD_BCRYPT);

        UserRepository::update($_req['id'], 'pass', $pass);
    }

    static function get($_req) {
        $user_id = $_req['id'];
        $user = UserRepository::loadByIdWithDetails($user_id);
        $user['name'] = $user['fname']. ' ' .$user['lname'];
        $user['mobile'] = $user['tel'];
        //$user['balance'] = UserService::getBalance($user_id);
        //$user['payment_total'] = UserRepository::getSumPayments($user_id);
        //$user['order_total'] = UserRepository::getSumOrders($user_id) ?: 0;
        echo json_encode($user);

    }

    static function page() {
        $count = UserRepository::countAllFiltered();
        $page = PageService::createPage($count, 40);
        $users = UserRepository::loadAllFilteredForAdminPanel($page);
        $jsonUsers = [];
        foreach ($users as $user) {
            /* @var $user User */
            $jsonUsers[] = [
                'id' => $user->id,
                'fname' => $user->fname,
                'lname' => $user->lname,
                'name' => $user->name,
                'gender' => $user->gender,
                'mobile' => $user->tel,
                'is_guest' => Util::boolify($user->guest),
                'rnd_img' => $user->rnd_img ?? null,
                'group_name' => $user->group_id > 1 ? $user->group_name : null,
                'created' => $user->created,
                'last_login' => $user->last_login,
                'last_order' => $user->last_order,
                'balance' => $user->balance,
                'company' => $user->company,
                'known_as' => $user->known_as,
            ];
        }

        echo PageService::jsonPage($page, $jsonUsers);
    }

    static function editProperty($property) {
        RestControllerAdmin::create()->run(function () use ($property) {
            if (!isset($_REQUEST['val']))
                Util::badReq();
            $id = $_REQUEST['id'];
            $val = $_REQUEST['val'];
            $actions = [
                "fname",
                "lname",
                "email",
                "user_group_id",
                "tel",
                "info",
            ];
            if (in_array($property, $actions)) {

                UserRepository::executeQuery("update user set $property = :val WHERE id = :id", [
                    ":id" => $id,
                    ":val" => $val
                ]);
                if ($property == 'user_group_id') {
                    $group = UserGroupRepository::loadByUserId($id);
                    $permissions = UserGroupRepository::getPermissions($group->id);
                    if (in_array(Permission::AGENCY, $permissions)) {
                        //creating default group for normal users
                        AgencyUserGroupRepository::loadDefaultGroupOfAgency($id);
                        //creating default admin group if it doesn't exist
                        // and sets the user->agency_group_id to the default admin group
                        AgencyUserGroupRepository::defaultAdminAgencyGroup($id, $group);
                    }
                }

            }
        });
    }

    static function edit() {
        if (!isset($_REQUEST['val'])) {
            Util::badReq();
        }
        $id = $_REQUEST['id'];
        $val = $_REQUEST['val'];
        $actions = ["fname",
            "lname",
            "email",
            "user_group_id",
            "tel",
            "info",];
        $property = $_REQUEST['property'];
        if (in_array($property, $actions)) {
            UserRepository::executeQuery("update user set $property = :val WHERE id = :id", [":id" => $id,
                ":val" => $val]);
            if ($property == 'user_group_id') {
                $group = UserGroupRepository::loadByUserId($id);
                $permissions = UserGroupRepository::getPermissions($group->id);
                if (in_array(Permission::AGENCY, $permissions)) {
                    //creating default group for normal users
                    AgencyUserGroupRepository::loadDefaultGroupOfAgency($id);
                    //creating default admin group if it doesn't exist
                    // and sets the user->agency_group_id to the default admin group
                    AgencyUserGroupRepository::defaultAdminAgencyGroup($id, $group);
                }
            }
        }
    }


    static function PackageQuePage() {
        HtmlControllerAdmin::create()->viewScope([
            "title" => "اولویت بسته بندی و ارسال",
            "activeSection" => "order",
            "script" => [
                "package-que.js?v=1.0.0"
            ]
        ])->showView('admin/PackageQue');
    }

    static function save($_req) {

        if (isset($_req['id'])) {
            $user = UserRepository::loadById($_req['id']);
        } else {
            $user = new User();
        }
        $user->fname = $_req['fname'];
        $user->lname = $_req['lname'] ?? null;
        $user->gender = $_req['gender'] ?? null;
        $user->tel = $_req['tel'];
        $user->company = $_req['company'] ?? null;
        $user->known_as = $_req['known_as'] ?? null;
        $user->info = $_req['info'] ?? null;
        $user->birth_date = $_req['birth_date'] ?? null;
        $user->user_group_id = $_req['user_group_id'] ?? 1;

        $user = UserRepository::save($user);

        //saving profile image
        if (isset($_req['img'])) {
            UserService::saveProfileImage($_req['img'], $user->id);

        }
    }

    static function getCSV() {

        $result = UserRepository::loadAll();
        $headers = ['Name', 'Mobile Phone'];

        $fp = fopen('php://output', 'w');
        if ($fp && $result) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="export.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            fputcsv($fp, $headers);
            foreach ($result as $user) {
                /* @var $user User */
                fputcsv($fp, [$user->getName(), $user->tel]);
            }
            die;
        }

    }

    static function getMe() {
        $curUser = UserService::currentUser();
        if ($curUser && $curUser->id) {

            $curUser = UserRepository::loadById($curUser->id);
            if (!$curUser) {
                echo json_encode(['is_guest' => true]);
            } else {
                $user = [
                    'id' => $curUser->id,
                    'name' => $curUser->getName(),
                    'gender' => $curUser->gender,
                    'mobile' => $curUser->tel,
                    'rnd_img' => $curUser->rnd_img ?? null,
                    'group_name' => $curUser->user_group_name ?? null,
                ];
                echo json_encode($user);
            }
        } else {
            echo json_encode(['is_guest' => true]);
        }
    }




}
