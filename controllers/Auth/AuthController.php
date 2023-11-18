<?php

namespace Controllers\Auth;

use Controllers\BaseController;
use Core\Application;
use Core\Request;
use Core\Response;
use Models\LoginForm;
use Models\UserModel;

class AuthController extends BaseController
{
    /**
     * The path the user should be redirected to.
     *
     * @var string
     */
    private $redirectTo = '/';

    /**
     * The path the user should be redirected to after logout.
     *
     * @var string
     */
    private $logoutRoute = '/login';

    public function __construct($layout = 'auth')
    {
        $this->layout = $layout;
    }

    /**
     * Register new user
     * 
     * @param Request $request
     * @param Response $respnose
     * 
     * @return mixte
     */
    public function register(Request $request)
    {
        $userModel = new UserModel();
        if ($request->isPost()) {

            $userModel->loadData($request->getBody());

            if ($userModel->validate() && $userModel->save()) {
                $app = Application::$app;

                $app->getSession()->setFlash('success', 'Your account has been created successfully.');

                return $app->getResponse()->redirect($this->redirectTo);
            }

            return $this->render("auth/register", [
                'model' => $userModel
            ]);
        }

        return $this->render("auth/register", [
            'model' => $userModel
        ]);
    }

    /**
     * Log in user
     * 
     * @param Request $request
     * @param Response $respnose
     * 
     * @return mixte
     */
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();

        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect($this->redirectTo);
                return;
            }
        }
        return $this->render("auth/login", [
            'model' => $loginForm
        ]);
    }

    /**
     * Logout authenticated user
     * 
     * @param Request $request
     * @param Response $respnose
     * 
     * @return void
     */
    public function logout()
    {
        $application = Application::$app;
        $application->getSession()->remove('user');

        return $application->getResponse()->redirect($this->logoutRoute);
    }
}
