<?php
session_start();
class UserController
{
    public function index($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('dashboard');
    }

    public function profile($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }

        return $router->view('profile');
    }

    public function products($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('products');
    }

    public function purchase_products($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('purchase');
    }

    public function purchase_products_post($router)
    {
        require "config.php";

        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        $array = filter_input_array(INPUT_POST);
        $newArray = array();
        foreach (array_keys($array) as $fieldKey) {
            foreach ($array[$fieldKey] as $key => $value) {
                $newArray[$key][$fieldKey] = $value;
            }
        }
        $count = count($newArray);
        $order_number = substr(str_shuffle("0123456789"), 0, 5);
        $total_cost = 0;
        for ($i = 0; $i < $count; $i++) {
            $total_cost = $newArray[$i]['price'] + $total_cost;
        }
        $sql = "INSERT INTO orders (user_ordered, order_number, order_cost) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $_SESSION['username'], $order_number, $total_cost);
            if (!$stmt->execute()) {
                return json_encode(['status' => 'danger', 'message' => 'Could not add order details!']);
            }
            $stmt->close();
        }
        for ($i = 0; $i < $count; $i++) {
            $sql = "SELECT id FROM parts WHERE part_name = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $item_name = $newArray[$i]['name'];
                $stmt->bind_param("s", $item_name);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($item_id);
                        if (!$stmt->fetch()) {
                            return json_encode(['status' => 'danger', 'message' => 'Could not add order!']);
                        }
                    }
                }
            }
            $sql = "INSERT INTO order_items (order_id, item_id, item_name, quantity) VALUES (?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssss", $order_number, $item_id, $newArray[$i]['name'], $newArray[$i]['quantity']);
                if (!$stmt->execute()) {
                    return json_encode(['status' => 'danger', 'message' => 'Could not add order!']);
                }
                $stmt->close();
            }
        }
        $mysqli->close();
        return $router->view('preorder-successful', ['order_number' => $order_number]);
    }

    public function orders($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('orders');
    }

    public function projects($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('project-detail');
    }

    public function project_add($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('project-add');
    }

    public function project_add_post($router)
    {
        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            require "config.php";

            $json = json_decode($body);

            if (!$json->inputName)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing project name.'
                ]);

            if (!$json->inputDescription)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing project description.'
                ]);

            if (!$json->inputStatus)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing project status.'
                ]);

            if (!$json->inputClientCompany)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing client name.'
                ]);

            if (!$json->inputEstimatedBudget)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing missing estimated budget.'
                ]);

            if (!$json->inputSpentBudget)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing spent budget.'
                ]);

            if (!$json->inputEstimatedDuration)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing estimated project duration.'
                ]);

            if (!$json->uuid) {
                $user_uuid = $_SESSION['uuid'];
            } else {
                $user_uuid = $json->uuid;
            }

            $project_name = $json->inputName;
            $project_desc = $json->inputDescription;
            $project_status = $json->inputStatus;
            $project_client = $json->inputClientCompany;
            $project_budget = $json->inputEstimatedBudget;
            $project_spent = $json->inputSpentBudget;
            $project_duration = $json->inputEstimatedDuration;

            $sql = "SELECT project_name FROM projects WHERE user_uuid = ? and project_name = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ss", $param_uuid, $project_name);
                $param_uuid = $user_uuid;
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        return json_encode(['status' => 'danger', 'message' => 'Cannot add duplicate project name.']);
                    }
                }
                $stmt->close();
            }

            $sql = "INSERT INTO projects (project_name, project_description, status, client, est_budget, total_spent, est_duration, user_uuid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssssssss", $param_name, $param_desc, $param_status, $param_client, $param_budget, $param_spent, $param_duration, $param_uuid);
                $param_uuid = $user_uuid;
                $param_name = $project_name;
                $param_desc = $project_desc;
                $param_status = $project_status;
                $param_client = $project_client;
                $param_budget = $project_budget;
                $param_spent = $project_spent;
                $param_duration = $project_duration;

                if ($stmt->execute()) {
                    return json_encode(['status' => 'success', 'message' => 'Added to database.']);
                } else {
                    return json_encode(['statys' => 'danger', 'message' => 'Cannot create project.']);
                }
                $stmt->close();
                $mysqli->close();
            }
        } else {
            return $router->abort(400);
        }
    }

    public function project_edit($router)
    {
        require "config.php";

        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        $strip = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $id = end($strip);
        $sql = "SELECT * FROM projects WHERE user_uuid = ? AND id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $param_uuid, $param_id);
            $param_uuid = $_SESSION['uuid'];
            $param_id = $id;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows != 1) {
                    return json_encode(['message' => 'Access Denied.']);
                } else {
                    return $router->view('project-edit', ['id' => $id]);
                }
            }
            $stmt->close();
        }
    }

    public function project_edit_post($router)
    {
        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            require "config.php";

            $json = json_decode($body);

            if (!$json->inputName)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing project name.'
                ]);

            if (!$json->inputDescription)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing project description.'
                ]);

            if (!$json->inputStatus)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing project status.'
                ]);

            if (!$json->inputClientCompany)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing client name.'
                ]);

            if (!$json->inputEstimatedBudget)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing missing estimated budget.'
                ]);

            if (!$json->inputSpentBudget)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing spent budget.'
                ]);

            if (!$json->inputEstimatedDuration)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing estimated project duration.'
                ]);

            if (!$json->uuid) {
                $user_uuid = $_SESSION['uuid'];
            } else {
                $user_uuid = $json->uuid;
            }

            $id = $json->id;
            $project_name = $json->inputName;
            $project_desc = $json->inputDescription;
            $project_status = $json->inputStatus;
            $project_client = $json->inputClientCompany;
            $project_budget = $json->inputEstimatedBudget;
            $project_spent = $json->inputSpentBudget;
            $project_duration = $json->inputEstimatedDuration;

            $sql = "UPDATE projects SET project_name = ?, project_description = ?, status = ?, client = ?, est_budget = ?, total_spent = ?, est_duration = ? WHERE user_uuid = ? AND id = ?";
            try {
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("sssssssss", $project_name, $project_desc, $project_status, $project_client, $project_budget, $project_spent, $project_duration, $user_uuid, $id);
                    if ($stmt->execute()) {
                        return json_encode(['status' => 'success', 'message' => 'Successfully edited project.']);
                    } else {
                        return json_encode(['status' => 'danger', 'message' => 'Cannot edit project.']);
                    }
                    $stmt->close();
                    $mysqli->close();
                }
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        } else {
            return $router->abort(400);
        }
    }

    public function calendar($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('calendar');
    }

    public function get_settings($router)
    {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: /login");
        }
        return $router->view('settings');
    }

    public function edit_settings($router)
    {
        require "config.php";

        $body = file_get_contents('php://input');

        if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
            $json = json_decode($body);

            if (!$json->fullName)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing full name.'
                ]);

            if (!$json->location1)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing location.'
                ]);

            if (!$json->occupation)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing occupation.'
                ]);

            if (!$json->education)
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Missing education.'
                ]);

            if (!$json->uuid) {
                $user_uuid = $_SESSION['uuid'];
            } else {
                $user_uuid = $json->uuid;
            }

            $fullname = $json->fullName;
            $location = $json->location1;
            $occupation = $json->occupation;
            $education = $json->education;

            $sql = "UPDATE users SET full_name = ?, location = ?, occupation = ?, education = ? where uuid = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("sssss", $fullname, $location, $occupation, $education, $user_uuid);
                if ($stmt->execute()) {
                    return json_encode(['status' => 'success', 'message' => 'Successfully user details.']);
                } else {
                    return json_encode(['status' => 'danger', 'message' => 'Cannot user details.']);
                }
                $stmt->close();
                $mysqli->close();
            }

            return json_encode(['message' => $ping->exec()]);
        } else {
            return $router->abort(400);
        }
    }
}