<?php

class AuthController
{
    public function register($router)
    {
        return $router->view('register');
    }

    public function login($router)
    {
        return $router->view('login');
    }

    public function authenticate($router)
    {
        session_start();

        require_once "config.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty(trim($_POST["username"]))) {
                header("Location: /login?error=Invalid+username+or+password");
            } else {
                $username = trim($_POST["username"]);
            }

            if (empty(trim($_POST["password"]))) {
                header("Location: /login?error=Invalid+username+or+password");
            } else {
                $password = trim($_POST["password"]);
            }

            if (!empty($username) && !empty($password)) {
                $sql = "SELECT id, username, email, password, uuid FROM users WHERE username = ?";

                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("s", $param_username);
                    $param_username = $username;
                    if ($stmt->execute()) {
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($id, $username, $email, $hashed_password, $uuid);
                            if ($stmt->fetch()) {
                                if (password_verify($password, $hashed_password)) {
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["uuid"] = $uuid;
                                    header("Location: /dashboard");
                                } else {
                                    header("Location: /login?error=Invalid+username+or+password");
                                }
                            }
                        } else {
                            header("Location: /login?error=Invalid+username+or+password");
                        }
                    } else {
                        header("Location: /login?error=Oops!+Something+went+wrong.+Please+try+again+later");
                    }
                    $stmt->close();
                }
            }
        }
        $mysqli->close();
    }

    public function create_account($router)
    {
        function gen_uuid()
        {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
            );
        }

        require_once "config.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty(trim($_POST["username"]))) {
                header("Location: /register?error=Please+enter+a+username!");
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
                header("Location: /register?error=Usernames+can+only+contain+letters,+numbers+and+underscores.");
            } else {
                $sql = "SELECT id FROM users WHERE username = ?";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("s", $param_username);
                    $param_username = trim($_POST["username"]);
                    if ($stmt->execute()) {
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            header("Location: /register?error=This+username+is+already+taken.");
                        } else {
                            $username = trim($_POST["username"]);
                        }
                    } else {
                        header("Location: /register?error=This+username+is+already+taken.");
                    }
                    $stmt->close();
                }
            }

            if (empty(trim($_POST["email"]))) {
                header("Location: /register?error=Please+enter+a+email+address!");
            } else {
                $email = trim($_POST["email"]);
            }

            if (empty(trim($_POST["password"]))) {
                header("Location: /register?error=Please+enter+a+password!");
            } elseif (strlen(trim($_POST["password"])) < 6) {
                header("Location: /register?error=Password+must+have+atleast+6+characters!");
            } else {
                $password = trim($_POST["password"]);
            }

            if (empty(trim($_POST["confirm_password"]))) {
                header("Location: /register?error=Please+confirm+password.");
            } else {
                $confirm_password = trim($_POST["confirm_password"]);
                if (empty($password_err) && ($password != $confirm_password)) {
                    header("Location: /register?error=Passwords+did+not+match.");
                }
            }

            if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
                $sql = "INSERT INTO users (username, email, password, uuid) VALUES (?, ?, ?, ?)";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("ssss", $param_username, $param_email, $param_password, $param_uuid);
                    $param_username = $username;
                    $param_email = $email;
                    $param_password = password_hash($password, PASSWORD_DEFAULT);
                    $param_uuid = gen_uuid();
                    if ($stmt->execute()) {
                        header("location: /login");
                    }
                    $stmt->close();
                }
            }
            $mysqli->close();
        }
    }

    public function token_endpoint($router)
    {
        require_once "config.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
                $body = file_get_contents('php://input');
                $json = json_decode($body);

                if (!$json->uid)
                    return json_encode([
                        'status' => 'danger',
                        'message' => 'Missing parameter uid.'
                    ]);
                if (!$json->username)
                    return json_encode([
                        'status' => 'danger',
                        'message' => 'Missing parameter username.'
                    ]);

                $uid = $json->uid;
                $username = $json->username;

                $sql = "SELECT id, username, uuid FROM users WHERE id = ?";

                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("s", $param_uuid);
                    $param_uuid = $uid;
                    if ($stmt->execute()) {
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($id, $user_name, $uuid);
                            if ($stmt->fetch()) {
                                if ($username == $user_name && $uid == $id) {
                                    if ($user_name == "administrator") {
                                        $flag = file_get_contents('/opt/auth_flag.txt');
                                        $flag = trim(preg_replace('/\s\s+/', '', $flag));
                                        header('Content-Type: application/json; charset=utf-8');
                                        return json_encode(["token" => $uuid, "flag" => $flag]);
                                    } else {
                                        header('Content-Type: application/json; charset=utf-8');
                                        return json_encode(["token" => $uuid]);
                                    }
                                } else {
                                    header('Content-Type: application/json; charset=utf-8');
                                    return json_encode(["message" => "Error: Username and uid do not match."]);
                                }
                            } else {
                                header('Content-Type: application/json; charset=utf-8');
                                return json_encode(["message" => "Error: Could not retrieve API token."]);
                            }
                        } else {
                            header('Content-Type: application/json; charset=utf-8');
                            return json_encode(["message" => "Error: Could not retrieve API token."]);
                        }
                    } else {
                        header('Content-Type: application/json; charset=utf-8');
                        return json_encode(["message" => "Error: Could not retrieve API token."]);
                    }
                } else {
                    header('Content-Type: application/json; charset=utf-8');
                    return json_encode(["message" => "Error: Could not retrieve API token."]);
                }
            } else {
                return $router->abort(400);
            }
        }
    }

    public function forgot_password($router)
    {
        return $router->view('forgot-password');
    }

    public function post_forgot_password($router)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return header("Location: /forgot-password?success=An+email+has+been+sent+to+the+account's+associated+email+address.");
        }
    }

    public function logout($router)
    {
        return $router->view('logout');
    }
}