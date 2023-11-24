<?php
class AuthController extends BaseController
{

    /**
     * Show register form
     */
    function showRegister()
    {
        // Render register page
        $this->view->render("auth/register");
    }

    /**
     * Handle register logic
     */
    function indexRegister(Request $request, Response $response)
    {
        // Store notifications
        $notifications = [];
        // Check if form has username and password
        if (!empty($request->body["username"]) && !empty($request->body["password"])) {
            try {
                // Avoid xss attack
                $username = htmlspecialchars($request->body["username"]);
                // Hash password
                $hashedPassword = password_hash($request->body["password"], PASSWORD_DEFAULT);
                $userModel = new UserModel();
                // Create user
                $userModel->create($username, $hashedPassword);
                // Redirect user to login page
                $this->view->render("auth/login", ["notifications" => [["type" => "success", "message" => "Votre compte viens d'être crée veuillez vous connectez."]]]);
                return;
            } catch (Exception $e) {
                // Handle errors
                switch ($e->getCode()) {
                    // Handle unique username
                    case 23000:
                        array_push($notifications, ["type" => "danger", "message" => "Ce surnom est déjà utilisé."]);
                        break;

                    // Handle all other error
                    default:
                        array_push($notifications, ["type" => "danger", "message" => "Une erreur est survenu. Veuillez réessayer."]);
                        break;
                }
            }
        } else {
            // Add notifications
            array_push($notifications, ["type" => "danger", "message" => "Tout les champs sont obligatoire !"]);
        }

        // Render view register with notifications
        $this->view->render("auth/register", ["notifications" => $notifications]);
    }

    /**
     * Show Login form
     */
    function showLogin()
    {
        // render login page
        $this->view->render("auth/login");
    }

    /**
     * Handle login logic
     */
    function indexLogin(Request $request, Response $response)
    {
        $notifications = [];
        // Check if request body include username and password and they equal or lower than 255 caracters
        if (!empty($request->body["username"]) && strlen($request->body["username"]) <= 255 && !empty($request->body["password"]) && strlen($request->body["password"]) <= 255) {
            try {
                // Avoid xss attack
                $username = htmlspecialchars($request->body["username"]);
                $userModel = new UserModel();
                // Get user
                $user = $userModel->getOneOrFail($username);
                // Check if hashed password from db and provided password is same
                if (password_verify($request->body["password"], $user["USER_PASSWORD"])) {
                    // Connect user and redirect to home page
                    $_SESSION["user"] = ["id" => $user["USER_ID"], "username" => $user["USER_NAME"]];
                    $response->locateTo("/");
                    return $response;
                } else {
                    throw new Exception("Wrong credidentials");
                }
            } catch (Exception $e) {
                // Handle wrong credidential
                array_push($notifications, ["type" => "danger", "message" => "Identifiants incorrect."]);
            }
        } else {
            // Handle all required data error
            array_push($notifications, ["type" => "danger", "message" => "Tout les champs sont obligatoire !"]);
        }
        // Render view login with notifications
        $this->view->render("auth/login", ["notifications" => $notifications]);
    }

    /**
     * Logout user and redirect to login page.
     */
    function logout(Request $request, Response $response)
    {
        // Remove user from session if exist
        if (isset($_SESSION["user"]))
            unset($_SESSION["user"]);

        // Redirect to login page
        $response->locateTo("/login");
        return $response;
    }
}
?>